<?php

class Aihelper extends CI_Controller
{
    public $data = array();
    private $opanai_api_key = '';
    private $max_fields = 100;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('settings_m');
        $this->settings = $this->settings_m->get_fields();

        $method = $this->uri->segment(2);

        if ($method == 'rss') {
            header('Content-Type: application/rss+xml; charset=utf-8');
        } else {
            header('Content-Type: application/json');
        }
    }

    public function generateformdata()
    {
        $form_num = $this->input->get('form_num');
        $ai_input = $this->input->get('ai_input');

        // Get JSON data from POST body
        $json_forms = json_decode(file_get_contents('php://input'), true);

        $data_form_ai = [];
        $data = [];
        $apiKey = $this->opanai_api_key;
        $clean_json = '';
        $image_ocr = false;

        // Check if API key is available
        if (empty($apiKey)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'data' => '',
                    'message' => 'OpenAI API key is not configured. Please set OPENAI_API_KEY environment variable.'
                ]));
            return;
        }

        $keys_only = [];
        $field_count = 0;
        $max_fields = $this->max_fields; // Maximum number of fields allowed

        foreach ($json_forms as $form_num => $form_data) {
            if ($form_num == $form_num) {
                foreach ($form_data as $field_name => $field_data) {
                    // Check if we've reached the maximum number of fields
                    if ($field_count >= $max_fields) {
                        break 2; // Exit both loops
                    }

                    if (!empty($field_name) && empty($field_data['value'])) {

                        if ($field_data['type'] == 'search' || $field_name == 'image' || $field_name == 'documents[]' || empty($field_data['label'])) {
                            continue;
                        }

                        $data_form_ai[$field_name] = $field_data;

                        if ($field_data['placeholder'] == $field_data['label'] || $field_data['label'] == $field_data['placeholder'] . ' *') {
                            unset($data_form_ai[$field_name]['placeholder']);
                        }

                        $keys_only[] = $field_name;
                        $field_count++; // Increment field counter
                    }
                }
            }
        }


        if (empty($ai_input) && file_exists(WRITEPATH . 'uploads/' . $this->data['session']['iduser'] . '_ai_image.jpg')) {
            $ai_input = "";
            $image_ocr = true;
        } elseif (empty($ai_input)) {
            $ai_input = "For each field, fill in the 'value' with appropriate dummy data based on its type and label";
        }

        //if ai_input contains and dummy then prepare input for ai
        if (strpos($ai_input, 'dummy') !== false) {
            $ai_input = str_replace('dummy', 'fill in other unknown \'value\' with appropriate dummy data based on its type and label', $ai_input);
        }

        //if ai_input contains and url then prepare input for ai
        if (strpos($ai_input, 'https') === 0) {
            // Define the URL to fetch
            $url = $ai_input; // Replace with your actual URL

            // Initialize CURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            try {
                // Make the request
                $content = curl_exec($ch);

                if ($content === false) {
                    throw new Exception(curl_error($ch));
                }

                // Process the content as needed
                $ai_input = $content;
            } catch (Exception $e) {
                // Handle any errors
                $ai_input = $url;
            }

            curl_close($ch);
        }

        $ai_instructions = [
            [
                "role" => "system",
                "content" => "You are a helpful assistant that fills HTML form data based on a user description."
            ],
            [
                "role" => "user",
                "content" => "Based on this user input: \"$ai_input\", fill out the values in this JSON object where applicable. Keep the rest of the structure unchanged."
            ],
            [
                "role" => "user",
                "content" => "```json\n" . json_encode($data_form_ai, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n```"
            ]
        ];

        $data_ai = [
            "model" => "gpt-4.1", //"gpt-4-turbo", //"gpt-3.5-turbo-16k",
            "messages" => $ai_instructions,
            "temperature" => 0.5,
            "max_tokens" => 10000
        ];

        if ($image_ocr) {

            $imagePath = WRITEPATH . 'uploads/' . $this->data['session']['iduser'] . '_ai_image.jpg';
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageMime = mime_content_type($imagePath); // e.g. image/jpeg
            $imageBase64 = "data:$imageMime;base64,$imageData";

            $ai_instructions = [
                [
                    "role" => "user",
                    "content" => [
                        ["type" => "text", "text" => "Extract text details from the following image and fill out this JSON object. Replace only the 'value' fields with info from the document.Return raw JSON only. No explanation, no markdown:"],
                        ["type" => "text", "text" => "```json\n" . json_encode($data_form_ai, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n```"],
                        ["type" => "image_url", "image_url" => ["url" => $imageBase64]]
                    ]
                ]
            ];

            $data_ai = [
                "model" => "gpt-4.1",
                "messages" => $ai_instructions,
                "max_tokens" => 10000
            ];
        }

        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . trim($apiKey),
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_ai));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


        if (curl_errno($ch)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'data' => $response,
                    'message' => 'CURL Error: ' . curl_error($ch)
                ]));
            curl_close($ch);
            return;
        }

        curl_close($ch);

        $result = json_decode($response, true);
        $json_string = $result;

        // Handle API errors
        if ($httpCode !== 200) {
            $errorMessage = 'OpenAI API Error';
            if (isset($result['error']['message'])) {
                $errorMessage = $result['error']['message'];
            } elseif (isset($result['error'])) {
                $errorMessage = is_string($result['error']) ? $result['error'] : 'Unknown API error';
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'data' => $response,
                    'message' => $errorMessage
                ]));
            return;
        }

        if (!is_array($result) && strpos($result, '```json') !== false) {
            $reply = $result;
        } elseif (!is_array($result)) {
            $reply = $result;
        } elseif (!isset($result['choices'][0]['message']['content'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'data' => '',
                    'message' => 'Invalid response format from OpenAI API'
                ]));
            return;
        } else {
            $json_string = $result['choices'][0]['message']['content'];
        }

        $clean_json = '';
        if (preg_match('/```json\s*(.*?)```/is', $json_string, $matches)) {
            $clean_json = trim($matches[1]);
        } else {
            // fallback: assume the entire string is just the JSON
            $clean_json = trim($json_string);
        }

        $data = json_decode($clean_json, true);

        if (is_array($data)) {
            foreach ($data as $field_name => $field_data) {
                if ($field_data['type'] == 'date' && !empty($field_data['value'])) {
                    $data[$field_name]['value'] = date('Y-m-d', strtotime($field_data['value']));
                }
            }
        }

        if (empty($data) && !empty($reply)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'data' => $data,
                    'message' => $reply
                ]));
            return;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'data' => $data,
                'message' => lang('Dash.generatedSuccessfully')
            ]));
    }

    public function index()
    {
        echo 'Hello, API here!';
        exit();
    }
}
