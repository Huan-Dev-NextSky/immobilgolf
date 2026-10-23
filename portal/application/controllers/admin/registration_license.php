<?php

class Registration_license extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('registration_license_m');
        $this->load->model('payments_m');
        $this->data['content_language_id'] = $this->language_m->get_content_lang();
    }

    public function index()
    {
        $this->data['licenses'] = $this->registration_license_m->get();

        $this->data['subview'] = 'admin/registration_license/index';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function edit($id = NULL)
    {
        if ($id)
        {
            $this->data['license'] = $this->registration_license_m->get($id);
            sw_count($this->data['license']) || $this->data['errors'][] = 'Could not be found';
        }
        else
        {
            $this->data['license'] = $this->registration_license_m->get_new();
            if (!empty($this->data['settings']['default_currency']))
                $this->data['license']->currency_code = $this->data['settings']['default_currency'];
        }

        $this->data['currencies'] = $this->payments_m->currencies;

        $rules = $this->registration_license_m->rules_admin;
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE)
        {
            if ($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', lang('Data editing disabled in demo'));
                redirect('admin/registration_license/edit/'.$id);
                exit();
            }

            $data = $this->registration_license_m->array_from_post(array(
                'license_name', 'duration_months', 'price', 'currency_code', 'active'
            ));

            if (!isset($_POST['active']))
                $data['active'] = 0;

            $data['duration_months'] = (int) $data['duration_months'];
            $data['date_modified'] = date('Y-m-d H:i:s');
            if (empty($id))
                $data['date_created'] = date('Y-m-d H:i:s');

            $this->registration_license_m->save($data, $id);

            $this->session->set_flashdata('message',
                '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');

            redirect('admin/registration_license');
        }

        $this->data['subview'] = 'admin/registration_license/edit';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function delete($id)
    {
        if ($this->config->item('app_type') == 'demo')
        {
            $this->session->set_flashdata('error', lang('Data editing disabled in demo'));
            redirect('admin/registration_license');
            exit();
        }

        $this->registration_license_m->delete($id);
        redirect('admin/registration_license');
    }

    public function free_date()
    {
        $this->load->model('registration_free_date_m');
        $this->data['free_date'] = $this->registration_free_date_m->get_settings();

        $rules = $this->registration_free_date_m->rules;
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE)
        {
            if ($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', lang('Data editing disabled in demo'));
                redirect('admin/registration_license/free_date');
                exit();
            }

            $data = $this->registration_free_date_m->array_from_post(array(
                'date_start', 'date_end', 'free_months', 'active'
            ));

            if (!isset($_POST['active']))
                $data['active'] = 0;

            $data['free_months'] = (int) $data['free_months'];
            $this->registration_free_date_m->save_settings($data);

            $this->session->set_flashdata('message',
                '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');

            redirect('admin/registration_license/free_date');
        }

        $this->data['subview'] = 'admin/registration_free_date/edit';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function _check_date($str)
    {
        $date_from = $this->input->post('date_start');
        $date_to = $this->input->post('date_end');

        if (strtotime($date_to) < strtotime($date_from))
        {
            $this->form_validation->set_message('_check_date', lang_check('Please correct dates start/end'));
            return FALSE;
        }

        return TRUE;
    }

    public function payments($pagination_offset = 0)
    {
        $this->load->library('pagination');

        $where = array('invoice_num LIKE' => '%_REG_%');
        $this->data['payments'] = $this->payments_m->get_by($where);

        $config['base_url'] = site_url('admin/registration_license/payments/');
        $config['uri_segment'] = 4;
        $config['total_rows'] = sw_count($this->data['payments']);
        $config['per_page'] = 20;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';

        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['payments'] = $this->payments_m->get_by($where, FALSE, $config['per_page'], 'id DESC', $pagination_offset);

        $this->data['subview'] = 'admin/registration_license/payments';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function view_payment($id = NULL)
    {
        if ($id)
        {
            $this->data['payment'] = $this->payments_m->get_by(array('id' => $id), TRUE);
            sw_count($this->data['payment']) || $this->data['errors'][] = 'Could not be found';
        }
        else
        {
            redirect('admin/registration_license/payments');
        }

        $payment = $this->data['payment'];
        $meta = array();
        $raw_before = array();
        if (is_object($payment) && !empty($payment->data_post))
        {
            $raw = @unserialize($payment->data_post);
            if (is_array($raw))
            {
                $meta = $raw;
                $raw_before = $raw;
            }
        }

        $meta = $this->_enrich_registration_payment_meta($payment, $meta);

        // Persist enriched meta for older Free/Stripe logs so detail stays complete.
        if (is_object($payment) && !empty($meta) && (
            empty($raw_before['duration_months']) ||
            (!isset($raw_before['discount_amount']) && !empty($meta['coupon'])) ||
            !isset($raw_before['original_price'])
        ))
        {
            $this->payments_m->save(array(
                'data_post' => serialize($meta),
            ), $payment->id);
            $payment->data_post = serialize($meta);
            $this->data['payment'] = $payment;
        }

        $this->data['payment_meta'] = $meta;
        $this->data['subview'] = 'admin/registration_license/view_payment';
        $this->load->view('admin/_layout_main', $this->data);
    }

    private function _enrich_registration_payment_meta($payment, $meta)
    {
        if (!is_array($meta))
            $meta = array();

        $this->load->model('registration_license_m');
        $this->load->model('registration_coupon_m');

        $license_id = !empty($meta['license_id']) ? (int) $meta['license_id'] : 0;
        if (!$license_id && is_object($payment) && !empty($payment->invoice_num))
        {
            $parts = explode('_', $payment->invoice_num);
            if (!empty($parts[0]) && isset($parts[1]) && $parts[1] === 'REG')
                $license_id = (int) $parts[0];
        }

        $license = FALSE;
        if ($license_id)
        {
            $license = $this->registration_license_m->get($license_id);
            if (is_object($license))
            {
                $meta['license_id'] = $license_id;
                if (empty($meta['license_name']))
                    $meta['license_name'] = $license->license_name;
                if (empty($meta['duration_months']))
                    $meta['duration_months'] = (int) $license->duration_months;
                if (!isset($meta['original_price']) || $meta['original_price'] === '' || $meta['original_price'] === null)
                    $meta['original_price'] = round((float) $license->price, 2);
            }
        }

        $coupon_code = !empty($meta['coupon']) ? trim((string) $meta['coupon']) : '';
        if ($coupon_code !== '')
        {
            $coupon = $this->registration_coupon_m->get_by_code($coupon_code);
            $paid = is_object($payment) ? (float) $payment->paid : 0;
            $orig = isset($meta['original_price']) ? (float) $meta['original_price'] : 0;

            if (is_object($coupon))
            {
                $meta['coupon'] = $coupon->coupon_code;
                $meta['coupon_discount_type'] = $coupon->discount_type;
                $meta['coupon_discount_value'] = $coupon->discount_value;
                $meta['coupon_discount_label'] = $this->registration_coupon_m->format_discount($coupon);
            }

            if ($orig <= 0 && is_object($license))
                $orig = round((float) $license->price, 2);

            if ($orig > 0)
            {
                $meta['original_price'] = $orig;
                if (!isset($meta['discount_amount']) || $meta['discount_amount'] === '' || $meta['discount_amount'] === null)
                    $meta['discount_amount'] = round(max(0, $orig - $paid), 2);
            }
        }
        elseif (isset($meta['original_price']) && is_object($payment))
        {
            $orig = (float) $meta['original_price'];
            $paid = (float) $payment->paid;
            if ($orig > $paid && (!isset($meta['discount_amount']) || $meta['discount_amount'] === '' || $meta['discount_amount'] === null))
                $meta['discount_amount'] = round(max(0, $orig - $paid), 2);
        }

        return $meta;
    }

    public function _check_unique_duration($str)
    {
        $id = $this->uri->segment(4);
        $months = (int) $str;

        $this->db->where('duration_months', $months);
        if (!empty($id))
            $this->db->where('id !=', $id);

        $existing = $this->registration_license_m->get();

        if (sw_count($existing))
        {
            $this->form_validation->set_message(
                '_check_unique_duration',
                lang_check('Duration months already exists')
            );
            return FALSE;
        }

        return TRUE;
    }
}
