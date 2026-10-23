<?php

class Api extends CI_Controller
{
    public $data = array();
    private $settings = array();
    
    // www.mapquestapi.com api key, to generate map image for PDF export
    private $mapquest_api_key='c9MNDPFQVui453XfIl7RBH1FxXkVW9sd';
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('settings_m');
        $this->settings = $this->settings_m->get_fields();
        
        $method = $this->uri->segment(2);
        
        if($method == 'rss')
        {
            header('Content-Type: application/rss+xml; charset=utf-8');
        }
        elseif($method == 'registration_licenses' || $method == 'registration_checkout')
        {
            header('Content-Type: text/html; charset=utf-8');
            header('Content-Security-Policy: frame-ancestors https://immobilgolf.com https://www.immobilgolf.com');
            header_remove('X-Frame-Options');
        }
        else
        {
            header('Content-Type: application/json');
        }
    }
   
	public function index()
	{
		echo 'Hello, API here!';
        exit();
	}
    
    /**
     * Api::translate()
     * 
     * @param string $api, mymemory | google
     * @return
     */
    public function translate($api = 'mymemory')
    {
        $this->load->model('language_m');
        
        $this->load->library('gTranslation', array());
        $this->load->library('mymemoryTranslation', array());
        
        $code_from = $this->input->get_post('from');
        $code_to = $this->input->get_post('to');
        $value = $this->input->get_post('value');
        $index = $this->input->get_post('index');
        
        if(is_numeric($code_from))
        {
            $code_from = $this->language_m->get_code($code_from);
        }
        
        if(is_numeric($code_to))
        {
            $code_to = $this->language_m->get_code($code_to);
        }
        
        $translated_value = '';
        $all_translations = array();
        
        // Fix value if HTML errors exists:
        if(function_exists('tidy'))
        {
            $tidy = new tidy();
            $value = $tidy->repairString($value);
        }
        
        if($api == 'google')
        {
            $translated_value = $this->gtranslation->translate($value, $code_from, $code_to);
        }
        else
        {
            $translated_value = $this->mymemorytranslation->translate($value, $code_from, $code_to);
        }
        
        $all_translations['result'] = $translated_value;
        
        echo json_encode($all_translations);
        exit();
    }
    
    public function export_lang_files()
    {
        $this->load->helper('file');
        $zip = new ZipArchive;
        
        $filename_zip = APP_VERSION_REAL_ESTATE.'-languages.zip';
        unlink(FCPATH.$filename_zip);
        
        $zip->open(FCPATH.$filename_zip, ZipArchive::CREATE);
        
        $lang_path = realpath(BASEPATH.'language/');
        $remove_chars = strlen(realpath(BASEPATH.'../'))+1;
        $directory_iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($lang_path));
        foreach($directory_iterator as $filename => $path_object)
        {
            if(is_file($filename))
            {
                $zip_filename = substr($filename, $remove_chars);
                $zip->addFile($filename, $zip_filename);
            }
        }
        
        $lang_path = realpath(BASEPATH.'../'.APPPATH.'language/');
        $remove_chars = strlen(realpath(BASEPATH.'../'))+1;
        $directory_iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($lang_path));
        foreach($directory_iterator as $filename => $path_object)
        {
            if(is_file($filename))
            {
                $zip_filename = substr($filename, $remove_chars);
                $zip->addFile($filename, $zip_filename);
            }
        }
        
        $lang_path = realpath(FCPATH.'templates/'.$this->settings['template'].'/language/');
        $remove_chars = strlen(realpath(FCPATH))+1;
        $directory_iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($lang_path));
        foreach($directory_iterator as $filename => $path_object)
        {
            if(is_file($filename))
            {
                $zip_filename = substr($filename, $remove_chars);
                $zip->addFile($filename, $zip_filename);
            }
        }

        $ret = $zip->close();
        
        if($ret == true)
        {
            $this->load->helper('download');
            $data = file_get_contents(FCPATH.$filename_zip); // Read the file's contents
            force_download($filename_zip, $data);
        }
        else
        {
            echo 'failed';
        }
    }
    
    public function get_level_values_select($lang_id=NULL, $field_id=NULL, $parent_id=0, $level=0)
    {
        //load language files
        $this->load->model('language_m');
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        $parameters = json_encode($_POST);
        
        
        $this->load->model('treefield_m');
        
        $values_arr = $this->treefield_m->get_level_values ($lang_id, $field_id, $parent_id, $level);
        
        $generate_select = '';
        foreach($values_arr as $key=>$value)
        {
            $generate_select.= "<option value=\"$key\">$value</option>\n";
        }
        
        $this->data['generate_select'] = $generate_select;
        $this->data['values_arr'] = $values_arr;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($this->data);
        exit();
    }
    
    public function get_treefield($lang_id, $field_id)
    {
        $this->load->model('language_m');
        $this->load->model('file_m');
        
        if(!is_numeric($lang_id))
        {
            $lang_id = $this->language_m->get_id($lang_id);
        }
        
        if(empty($lang_id))exit("Wrong lang_code / id");
        
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');        
        
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $_POST;
        $parameters = json_encode($_POST);
        
        $this->load->model('treefield_m');
        $values_arr = $this->treefield_m->get_table_tree($lang_id, $field_id, NULL, TRUE, '_lang.value', ', repository_id, font_icon_code');
        
        $this->data['levels'] = $this->treefield_m->get_max_level($field_id);
        
        /* images */
        foreach ($values_arr as $key => $val) {
            $files_list = array();
            $image = '';
            $marker_image = '';
            
            if(!empty($val->repository_id))
            {
                $files_r = $this->file_m->get_by(array('repository_id' => $val->repository_id),FALSE, 5,'id ASC');
                if(!empty($files_r)){
                    if(isset($files_r[0]) and file_exists(FCPATH.'files/thumbnail/'.$files_r[0]->filename)) {
                        $image = base_url('files/'.$files_r[0]->filename);
                    }
                    if(isset($files_r[1]) and file_exists(FCPATH.'files/thumbnail/'.$files_r[1]->filename)) {
                        $marker_image = base_url('files/'.$files_r[1]->filename);
                    }
                    foreach ($files_r as $key => $value) {
                        if(file_exists(FCPATH.'files/thumbnail/'.$value->filename)) {
                            $files_list[] = base_url('files/'.$value->filename);
                        }
                    }
                }
            }
            /* generate marker basic on default marker and marker icon */
            if(!empty($marker_image)){
                $marker_image=$this->_generate_map_marker($files_r[1]->filename);
            }
            
            $values_arr[$val->id]->image = $image;
            $values_arr[$val->id]->marker_image = $marker_image;
            $values_arr[$val->id]->files_list = $files_list;
            
        }
        
        /* end images */
        
        $this->data['values_arr'] = $values_arr;
        
        echo json_encode($this->data);
        exit();
    }
    
    private function _generate_map_marker($icon_basename=NULL, $cache_time_sec = 86400) {
        $icon = FCPATH.'files/thumbnail/'.$icon_basename;
        $marker = FCPATH."templates/".$this->settings['template']."/assets/img/markers/default.png";
        $path_cache = FCPATH."templates/".$this->settings['template']."/assets/img/markers/markers_cache/";
        
        if(empty($icon_basename)) return false;
        if(!file_exists($icon)) return false;
        if(!file_exists($marker)) return false;
        
        /* check if already generated */
        if(file_exists($path_cache.'/'.$icon_basename))
            if(filemtime($path_cache.'/'.$icon_basename) > time()-$cache_time_sec) {
                return  base_url("templates/".$this->settings['template']."/assets/img/markers/markers_cache/".$icon_basename);
            }
        
        if (!file_exists($path_cache)) {
            mkdir($path_cache, 0777, true);
        }

        $type_icon = exif_imagetype($icon); // [] if you don't have exif you could use getImageSize() 
        $type_marker = exif_imagetype($marker); // [] if you don't have exif you could use getImageSize() 

        if($type_icon!=3 || $type_marker!=3) return false;
            
        if($type_marker=='3') {
            $icon_dest = imagecreatefrompng($icon);
        }

        if($type_icon=='3') {
            $marker_dest = imagecreatefrompng($marker);
        }
        
        $image_info = @getimagesize($marker);
        $width = $image_info[0];
        $height = $image_info[1];

        $maxWidth = 0.8*$width; 
        $maxHeight = 0.45*$height;

        $imageDimensions = @getimagesize($icon);
        $imageWidth = $imageDimensions[0];
        $imageHeight = $imageDimensions[1];
        $imageSize['width'] = $imageWidth;
        $imageSize['height'] = $imageHeight;
        if($imageWidth > $maxWidth || $imageHeight > $maxHeight)
        {
            if ( $imageWidth > $imageHeight ) {
            $imageSize['height'] = floor(($imageHeight/$imageWidth)*$maxWidth);
                $imageSize['width']  = $maxWidth;
            } else {
                $imageSize['width']  = floor(($imageWidth/$imageHeight)*$maxHeight);
                $imageSize['height'] = $maxHeight;
            }
        }

        /* create new image */
        $icon_dest = imagescale($icon_dest, $imageSize['width'], $imageSize['height'],  IMG_BICUBIC_FIXED);

        $dest_image = imagecreatetruecolor($width, $height);

        //make sure the transparency information is saved
        imagesavealpha($dest_image, true);

        //create a fully transparent background (127 means fully transparent)
        $trans_background = imagecolorallocatealpha($dest_image, 0, 0, 0, 127);

        //fill the image with a transparent background
        imagefill($dest_image, 0, 0, $trans_background);

        //copy each png file on top of the destination (result) png
        imagecopy($dest_image, $marker_dest, 0, 0, 0, 0, $width, $height);
        $icon_x =($width - $imageSize['width'])/2+0.5;
        imagecopy($dest_image, $icon_dest, $icon_x, 6, 0, 0, $imageSize['width'], $imageSize['height']);
        //send the appropriate headers and output the image in the browser
        imagepng($dest_image, $path_cache.'/'.$icon_basename);

        //destroy all the image resources to free up memory
        imagedestroy($marker_dest);
        imagedestroy($icon_dest);
        imagedestroy($dest_image);
        
        return base_url("templates/".$this->settings['template']."/assets/img/markers/markers_cache/".$icon_basename);
    }
    
    
    
    public function rss($lang_code=NULL, $limit_properties=20, $offset_properties=0)
    {
        $this->load->model('language_m');
        $this->load->model('option_m');
        $this->load->model('estate_m');
        $this->load->model('file_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        if(empty($this->settings['websitetitle']))$this->settings['websitetitle'] = 'Title not defined';
        
        $this->data['listing_uri'] = config_item('listing_uri');
        if(empty($this->data['listing_uri']))$this->data['listing_uri'] = 'property';
        
        //Fetch last 20 properties
        //$options = $this->option_m->get_options($lang_id);
        
        $where = array();
        $search_array = array();
        $where['language_id']  = $lang_id;
        $where['is_activated'] = 1;
        
        $estates = $this->estate_m->get_by($where, false, $limit_properties, 'property.id DESC', $offset_properties);
        
        // Fetch all files by repository_id
//        $files = $this->file_m->get();
//        $rep_file_count = array();
//        $this->data['page_images'] = array();
//        foreach($files as $key=>$file)
//        {
//            $file->thumbnail_url = base_url('admin-assets/img/icons/filetype/_blank.png');
//            $file->url = base_url('files/'.$file->filename);
//            if(file_exists(FCPATH.'files/thumbnail/'.$file->filename))
//            {
//                $file->thumbnail_url = base_url('files/thumbnail/'.$file->filename);
//                $this->data['images_'.$file->repository_id][] = $file;
//            }
//        }
        
        // Set website details
        $generated_xml = '<?xml version="1.0" encoding="UTF-8" ?>';
        $generated_xml.= '<rss version="2.0">
                            <channel>
                              <title><![CDATA[ '.strip_tags($this->settings['websitetitle']).' ]]></title>
                              <link>'.site_url().'</link>
                              <description>'.$this->settings['phone'].', '.$this->settings['email'].'</description>';
        
        
        // Add listings to rss feed     
        foreach($estates as $key=>$row){
            $title_slug=$title='';
            $value = $this->estate_m->get_field_from_listing($row, 10);
            if(!empty($value))
            {
                $title = $value;
                $title_slug = url_title_cro($value);
            }
            $url = slug_url($this->data['listing_uri'].'/'.$row->id.'/'.$lang_code.'/'.$title_slug);

            $description = 'Description field removed';
            $value = $this->estate_m->get_field_from_listing($row, 8);
            if(!empty($value))
            {
                $description = $value;
            }
            
            // Thumbnail
            $thumbnail_url = '';
            if(isset($row->image_filename))
            {
                $thumbnail_url = base_url('files/thumbnail/'.$row->image_filename);
                $thumbnail_url = '<img align="left" hspace="5" src="'.$thumbnail_url.'" />';
            }
            
            $pubDate= date("r", strtotime($row->date));
            
            $generated_xml.=  '<item>
                                <title>'.strip_tags($title).'</title>
                                <link>'.$url.'</link>
                                <pubDate>'.$pubDate.'</pubDate>
                                <description>
                                    <![CDATA['.$thumbnail_url.$description.']]>
                                </description>
                              </item>';
        }

        // Close rss  
        $generated_xml.= '</channel></rss>';

        echo $generated_xml;
        exit();
    }
    
    
    public function newsrss ($lang_code=NULL, $limit_properties=20, $offset_properties=0)
    {
        header('Content-Type: application/rss+xml; charset=utf-8');
        $this->load->model('language_m');
        $this->load->model('option_m');
        $this->load->model('estate_m');
        $this->load->model('page_m');
        $this->load->model('file_m');
        $this->load->helper('text_helper');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        if(empty($this->settings['websitetitle']))$this->settings['websitetitle'] = 'Title not defined';
        
        $this->data['listing_uri'] = config_item('listing_uri');
        if(empty($this->data['listing_uri']))$this->data['listing_uri'] = 'property';
        
        //Fetch last 20 properties
        //$options = $this->option_m->get_options($lang_id);
        
         /* {MODULE_NEWS} */
        
        $cat_merge = '';
        // Fetch all pages
        $news_module_all = $this->page_m->get_lang(NULL, FALSE, $lang_id, array('type'=>'MODULE_NEWS_POST'), null, '', 'date_publish DESC');
        
        /* {/MODULE_NEWS} */
        
        
        // Fetch all files by repository_id
        
        // Set website details
        $generated_xml = '<?xml version="1.0" encoding="UTF-8" ?>';
        $generated_xml.= '<rss version="2.0">
                            <channel>
                              <title><![CDATA[ '.strip_tags($this->settings['websitetitle']).' ]]></title>
                              <link>'.site_url().'</link>
                              <description>'.$this->settings['phone'].', '.$this->settings['email'].'</description>';
        
        
        // Add listings to rss feed     
        foreach($news_module_all as $key=>$row){
            $title_slug=$title='';
            $value = $row->title;
            if(!empty($value))
            {
                $title = $value;
                $title_slug = url_title_cro($value);
            }
            $url = slug_url($lang_code.'/'.$row->id.'/'.$title_slug);

            $description = 'Description field removed';
            $value = character_limiter(strip_tags($row->body), 150);
            if(!empty($value))
            {
                $description = $value;
            }
            // Thumbnail
            $thumbnail_url = '';
            if(isset($row->image_filename))
            {
                $thumbnail_url = base_url('files/thumbnail/'.rawurlencode($row->image_filename));
                $thumbnail_url = '<img align="left" hspace="5" src="'.$thumbnail_url.'" />';
            }
            
            $pubDate= date("r", strtotime($row->date));
            
            $generated_xml.=  '<item>
                                <title>'.strip_tags($title).'</title>
                                <link>'.$url.'</link>
                                <pubDate>'.$pubDate.'</pubDate>
                                <description>
                                    <![CDATA['.$thumbnail_url.$description.']]>
                                </description>
                              </item>';
        }

        // Close rss  
        $generated_xml.= '</channel></rss>';

        echo $generated_xml;
        exit();
    }
    
    /*
        Example call: index.php/api/json/en?
        Supported uri parameters, for pagination:
        $limit_properties=20
        $offset_properties=0
        
        Supported query parameters:
        options_hide
        v_rectangle_ne=46.3905, 16.8329
        v_rectangle_sw=45.9905, 15.999
        search={"search_option_smart":"yellow","v_search_option_2":"Apartment"}
        
        Complete example:
        index.php/api/json/en/20/0?options_hide&search={"search_option_smart":"cestica"}&v_rectangle_ne=46.3905, 16.8329&v_rectangle_sw=45.9905, 15.999
        Example for "from":
        {"v_search_option_36_from":"60000"}
        Example for indeed value:
        {"v_search_option_4":"Sale and Rent"}
        Example for featured:
        {"v_search_option_is_featured":"trueIs Featured"}
    */
    public function json($lang_code=null, $limit_properties=20, $offset_properties=0)
    {
        if($lang_code == NULL)
            exit('Wrong API call!');

        $this->load->model('estate_m');
        $this->estate_m->apply_visitor_owned_visibility();
        
        $this->data['message'] = lang_check('No message returned!');
        $this->data['parameters'] = $search = $this->input->get_post('search');
        $options_hide = $this->input->get_post('options_hide');
        
        
        $this->load->model('language_m');
        $this->load->model('option_m');
        $this->load->model('file_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        if(empty($this->settings['websitetitle']))$this->settings['websitetitle'] = 'Title not defined';
        
        $data_tmp['listing_uri'] = config_item('listing_uri');
        if(empty($data_tmp['listing_uri']))$data_tmp['listing_uri'] = 'property';
        
        $search_array = array();
        if(!empty($search))
        {
            $search_array = json_decode($search);

            if(empty($search_array) && is_string($search))
            {
                $search_array['v_search_option_smart'] = $search;
            }
        }
        
        if(is_object($search_array))
            $search_array = (array) $search_array;
        
        $purpose = "";
        if(is_array($search_array) && isset($search_array['v_search_option_4']))
        {
            $purpose = $search_array['v_search_option_4'];
        }
        
        $order_by = NULL;
        $options_order = $this->input->get_post('order');
        
        if(!empty($options_order))
        {
            $order_by = $options_order;
            
            if(strpos($purpose, lang_check('Rent')) !== FALSE)
            {
                $order_by = str_replace("price", "field_37_int", $order_by);
            }
            
            $order_by = str_replace("price", "field_36_int", $order_by);
        }
        
        // Rent price support
        if(strpos($purpose, lang_check('Rent')) !== FALSE)
        {
            if(isset($search_array['v_search_option_36_from']))
                $search_array['v_search_option_37_from'] = $search_array['v_search_option_36_from'];
            if(isset($search_array['v_search_option_36_to']))
                $search_array['v_search_option_37_to'] = $search_array['v_search_option_36_to'];
            unset($search_array['v_search_option_36_from'], $search_array['v_search_option_36_to']);
        }
        if ($this->input->get_post('is_visible')) {
            $where = array('is_visible' => 1, 'is_activated' => 1, 'property_lang.language_id' => $lang_id);
        } else {
            $where = array('is_activated' => 1, 'language_id' => $lang_id);
        }
        if(isset($this->settings['listing_expiry_days']))
        {
            if(is_numeric($this->settings['listing_expiry_days']) && $this->settings['listing_expiry_days'] > 0)
            {
                 $where['property.date_modified >']  = date("Y-m-d H:i:s" , time()-$this->settings['listing_expiry_days']*86400);
            }
        }

        //Fetch last 20 properties
        //$options = $this->option_m->get_options($lang_id);
        $type = $this->input->get_post('type');
        
        $this->data['total_results'] = $this->estate_m->count_get_by($where, false, NULL, NULL, NULL, $search_array, NULL, FALSE, $type);
        $limit = 0;
        if ($type) {
            $limit = $limit_properties;
            $limit_properties = NULL;
        }
        $estates = $this->estate_m->get_by($where, false, $limit_properties, $order_by, $offset_properties, $search_array, NULL, FALSE, TRUE, $type);
        
        $this->data['field_details'] = NULL;
        if(!empty($options_hide))
        {
            $this->data['field_details'] = $this->option_m->get_lang(NULL, FALSE, $lang_id);

            $this->load->model('treefield_m');
            
            foreach($this->data['field_details'] as $row)
            {
                if($row->type == 'TREE')
                {
                    $levels = $this->treefield_m->get_max_level($row->id);
                    $tree   = $this->treefield_m->get_table_tree($lang_id, $row->id);
                    
                    $new_tree = array();
                    foreach($tree as $row_tree)
                    {
                        $new_tree[] = $row_tree;
                    }
                    
                    $this->data['tree_'.$row->id]['levels'] = $levels+1;
                    $this->data['tree_'.$row->id]['tree']   = $new_tree;
                }
            }
        }
        
        // Set website details
        $json_data = array();
        // Add listings to rss feed     
        $i = 1;
        foreach($estates as $key=>$row){
            if(!$row->date_active_expired) {
                continue;
            }
            if($row->date_active_expired && strtotime($row->date_active_expired) < strtotime(date('Y-m-d H:i:s'))) {
                continue;
            }
            if ($type && $i > $limit) {
                break;
            }
            $estate_date = array();
            $title = $this->estate_m->get_field_from_listing($row, 10);
            $url = site_url($data_tmp['listing_uri'].'/'.$row->id.'/'.$lang_code.'/'.url_title_cro($title));
            
            $row->json_object = json_decode($row->json_object);
            $row->image_repository = json_decode($row->image_repository);
            $estate_date['url'] = $url;
            $estate_date['listing'] = $row;
            
            $json_data[] = $estate_date;
            $i++;
        }
        
        $this->data['results'] = $json_data;
        
        echo json_encode($this->data);
        exit();
    }

    public function get_city()
    {
        $country = $this->input->get_post('country');
        $city = array();
        $query = $this->db->query("SELECT * FROM city WHERE country='".$country."'");
        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row)
           {
                $city[] = $row->city;
           }
        }
        $this->data['city'] = $city;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($this->data);
        exit();
    }
    
    public function google_login($lang_id = NULL)
    {
		
	$this->load->library('session');
        
        if (version_compare(phpversion(), '5.5.0', '>=')) {
        } else {
            exit('PHP version 5.5 is required for google login');
        }
        
        if(!file_exists(APPPATH.'libraries/Glogin.php'))
        {
            exit('Google login modul is not available');
        }

        $this->load->model('language_m');
        
        if(!empty($lang_id)){
            $this->session->set_userdata('lang_id', $lang_id);
        } elseif($this->session->userdata('lang_id')) {
            $lang_id = $this->session->userdata('lang_id');
        }
        
        if(empty($lang_id))
            $lang_id = $this->language_m->get_default_id();
        
        $lang_code = $this->language_m->get_code($lang_id);
        $lang_name = $this->language_m->get_name($lang_id);
        
        $this->load->library('Glogin');

        $provider = $this->glogin->getProvider();
        
        if (!empty($_GET['error'])) {
            // Got an error, probably user denied access
            exit('Got error: ' . $_GET['error']);
        
        } elseif (empty($_GET['code'])) {
        
            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            $this->session->set_flashdata('oauth2state', $provider->getState());
            
            header('Location: ' . $authUrl);
            exit;
        
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $this->session->flashdata('oauth2state'))) {
        
            // State is invalid, possible CSRF attack in progress
            //unset($_SESSION['oauth2state']);
            
            $this->user_m->logout();
            
            exit('Invalid state');
        
        } else {
        
            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', array(
                'code' => $_GET['code']
            ));
        
            // Optional: Now you have a token you can look up a users profile data
            try {
                // We got an access token, let's now get the owner details
                $ownerDetails = $provider->getResourceOwner($token);
//array(5) {
//  ["emails"]=>
//  array(1) {
//    [0]=>
//    array(1) {
//      ["value"]=>
//      string(22) ""
//    }
//  }
//  ["id"]=>
//  string(21) ""
//  ["displayName"]=>
//  string(12) ""
//  ["name"]=>
//  array(2) {
//    ["familyName"]=>
//    string(6) ""
//    ["givenName"]=>
//    string(5) ""
//  }
//  ["image"]=>
//  array(1) {
//    ["url"]=>
//    string(98) ""
//  }
//}
                $user_array = $ownerDetails->toArray();
                $user_email = $ownerDetails->getEmail();
                $user_namesurname = $ownerDetails->getFirstName();
                $user_avatar = $ownerDetails->getAvatar();
                
          
                // Register / Login
                $user_get = $this->user_m->get_by(array('password'=>$this->user_m->hash($user_array['id']), 
                                                        'username'=>$user_email), true);
                
                if(sw_count($user_get) == 0)
                {
                    // Check if email already exists
                    if($this->user_m->if_exists($user_email) === TRUE)
                    {
                        exit('Email already exists in database, please contact administrator or reset password');
                    }
                    
                    // Register user
                    $data_f = array();
                    $data_f['username'] = $user_email;
                    $data_f['mail'] = $user_email;
                    $data_f['password'] = $this->user_m->hash($user_array['id']);
                    $data_f['facebook_id'] = '';
                    $data_f['type'] = 'USER';
                    $data_f['name_surname'] = $user_namesurname;
                    $data_f['activated'] = '1';
                    $data_f['description'] = '';
                    $data_f['language'] = $lang_name;
                    $data_f['registration_date'] = date('Y-m-d H:i:s');
                    $data_f['mail_verified'] = 0;
                    $data_f['phone_verified'] = 0;               
                    $data_f['is_password_locked'] = 1;               

                    if($this->config->item('def_package') !== FALSE)
                    {
                        $data_f['package_id'] = $this->config->item('def_package');
                        
                        $this->load->model('packages_m');
                        $package = $this->packages_m->get($data_f['package_id']);
                        
                        if(is_object($package))
                        {
                            $days_extend = $package->package_days;
                        
                            if($days_extend > 0)
                                $data_f['package_last_payment'] = date('Y-m-d H:i:s', time() + 86400*intval($days_extend));
                        }
                    }      

                    $user_id = $this->user_m->save($data_f, NULL);
										
							
                    if(!empty($user_avatar)){
                        $user_avatar = str_replace('?sz=50', '', $user_avatar);
                        $this->load->model('repository_m');
                        $this->load->model('file_m');
                        $this->load->library('uploadHandler', array('initialize'=>FALSE));

                        $user_data = $this->user_m->get($user_id);
                        // Fetch file repository
                        $repository_id = $user_data->repository_id;
                        if(empty($repository_id))
                        {
                            // Create repository
                            $repository_id = $this->repository_m->save(array('name'=>'user_m'));
                            // Update with new repository_id
                            $this->user_m->save(array('repository_id'=>$repository_id), $user_data->id);
                        }

                        $file_name = '';
                        
                        $handle   = curl_init($user_avatar);
                        curl_setopt($handle, CURLOPT_HEADER, false);
                        curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
                        curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 3);
                        $file = curl_exec($handle);
                        ##print $connectable;
                        curl_close($handle);
                        $image_info = getimagesizefromstring($file);
											
                        $extension ='';
                        switch ($image_info['mime']) {
                            case 'image/gif':
                                            $extension = '.gif';
                                            break;
                            case 'image/jpeg':
                                            $extension = '.jpg';
                                            break;
                            case 'image/png':        
                                            $extension = '.png';
                                            break;
                            default:
                                            // handle errors
                                            break;
                        }
                        $new_file_name=time().rand(000, 999).$extension;
                        file_put_contents(FCPATH.'/files/'.$new_file_name, $file);
                        /* create thumbnail */
                        $this->uploadhandler->regenerate_versions($new_file_name);
                        /* end create thumbnail */
                        $file_name= $new_file_name;
                        $next_order=0;
                        $file_id = $this->file_m->save(array(
                        'repository_id' => $repository_id,
                        'order' => $next_order,
                        'filename' => $file_name,
                        )); 
                        $next_order++;
                    }
									
                }
                
                // Login :: AUTO
                if($this->user_m->login($user_email, $user_array['id']) == TRUE)
                {
                    if(!empty($user_id) && 
                        config_item('registration_interest_enabled') === TRUE && 
                        config_item('tree_field_enabled') === TRUE)
                    {
                        redirect('fresearch/treealerts/'.$lang_code.'/'.$user_id.'/'.md5($user_id.config_item('encryption_key')));
                    }
                    
                    redirect('frontend/myproperties/'.$lang_code);
                    exit();
                }
                else
                {
                    $this->session->set_flashdata('error', 
                            lang_check('That email/password combination does not exists'));
                    redirect('frontend/login/'.$lang_code); 
                    exit();
                }
        
            } catch (Exception $e) {
        
                // Failed to get user details
                exit('Something went wrong: ' . $e->getMessage());
        
            }
        
            // Use this to interact with an API on the users behalf
            // echo $token->accessToken;
        
            // Use this to get a new access token if the old one expires
            //echo $token->refreshToken;
        
            // Number of seconds until the access token will expire, and need refreshing
            //echo $token->expires;
        }
        
        exit();
    }
    
    /* 
     * Use for add property to compare list, use with Controller propertycompare.php
     * 
     */
    public function add_to_compare ($lang_code='en') {
        
        $this->load->model('language_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
                
        /* config */
        $max_properties=4;   
        /* end  config */
        
        $this->load->library('session');
        $this->load->model('option_m');
        $this->load->model('language_m');
        $json_data['success'] = false;
        /*$ses=$this->session->userdata('property_compare');
        // if max property
        if(sw_count($ses)>=$max_properties) {
            $json_data['message'] = lang_check('Added max property');
            echo json_encode($json_data);
            exit();
        }*/
       
        /* data */
        
        $this->data['post'] = $_POST;
        // lang id and code
        if(empty($lang_code)) $lang_code= $this->language_m->get_default();
        $lang_id = $this->language_m->get_id($lang_code);
        
        $title_option_id=10;
        /* end data */
        
        $json_data=array();
            
        $id_property= trim($this->data['post']['property_id']);
        if(empty($id_property)) {
            $json_data['message'] = lang_check('Parameters not defined!');
            echo json_encode($json_data);
            exit();
        }
        
        // get title
        $title= $this->option_m->get_property_value($lang_id, $id_property, $title_option_id);
        if(empty($title)) {
            $json_data['message'] = lang_check('Parameters not defined!');
            echo json_encode($json_data);
            exit();
        }
        $this->data['listing_uri'] = 'property';
        if(config_item('listing_uri'))
            $this->data['listing_uri'] = config_item('listing_uri');
        //get other compare in session
        $data_sess['property_compare'] = $this->session->userdata('property_compare');
        $data_sess['property_compare'][$id_property] = $title;
        
         $json_data['remove_first']=false;
        if(sw_count($data_sess['property_compare'])>$max_properties) {
            reset($data_sess['property_compare']);
            unset($data_sess['property_compare'][key($data_sess['property_compare'])]);
            $json_data['remove_first']=true;
        }
        
        $this->session->set_userdata($data_sess);
        
        // answere
        $json_data['message'] = lang_check('Property added to compare');
        $json_data['property'] = $id_property.', '.$title;
        $json_data['property_id'] = $id_property;
        $json_data['property_url'] = slug_url($this->data['listing_uri'].'/'.$id_property.'/'.$lang_code.'/'.url_title_cro($title));
        $json_data['success'] = true;
              //  print_r($this->session->userdata('property_compare'));
       echo json_encode($json_data);
    exit();
   } 
    
    /* 
     * Use for remove property from compare list, use with Controller propertycompare.php
     * 
     */
    public function remove_from_compare($lang_code='en') {
        $this->load->model('language_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        /* data */
        $this->load->library('session');
        $this->data['post'] = $_POST;
        /* end data */
        $this->data['success'] = false;
        $json_data=array();
        $this->load->model('option_m');
        $this->load->model('language_m');
            
        $id_property= trim($this->data['post']['property_id']);
        if(empty($id_property)) {
            $json_data['message'] = lang_check('Parameters not defined!');
            $json_data['success'] = true;
            return false;
        }
        
        
        //get other compare in session
        $data_sess['property_compare'] = $this->session->userdata('property_compare');
        unset($data_sess['property_compare'][$id_property]);
        $this->session->set_userdata($data_sess);
        // answere
        $json_data['message'] = lang_check('Property remove from compare');
        $json_data['property_id'] = $id_property;
        $json_data['success'] = true;
       echo json_encode($json_data);
    exit();
   } 
    
  public function pdf_export($property_id = '', $lang_code = 'en') {
        
        $this->load->model('language_m');
        $lang_id = $this->language_m->get_id($lang_code);
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        if(empty($property_id)) {
           exit(lang_check('Listing not found'));
        }
        if(false) {
            $this->load->library('pdf');
            $this->pdf->generate_by_property($property_id, $lang_code, $this->mapquest_api_key);
        } else {
            $this->load->library('m_pdf');
            $this->m_pdf->generate_by_property($property_id, $lang_code, $this->mapquest_api_key,$lang_id);
        }
    }
    
    public function save_weather_cache ($property_id = NULL, $lang_code = 'en')  {
        $json_data['success'] = false;
        
        $this->load->model('language_m');
        $lang_id=$this->language_m->get_id($lang_code);
        $value = $_POST['value'];
        $weather_api = $_POST['weather_api'];
        echo $weather_api;
        $this->load->model('weathercacher_m');
        if($this->weathercacher_m->cache($property_id, $lang_id, $value, $weather_api)) {
            $json_data['success'] = true;
            echo json_encode($json_data);
        }
        else {
            $json_data['success'] = false;
            echo json_encode($json_data);
        }
        
    exit();   
    }
    
    public function get_all_counters($lang_id, $form_id=NULL)
    {
        //load language files
        $this->load->model('language_m');
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        $this->data['message'] = lang_check('No message returned!');
        
        unset($_POST['v_undefined']);
        
        $this->data['parameters'] = $_POST;
        $parameters = json_encode($_POST);
        
        $this->data['parameters']['is_activated'] = 1;
        
        // Fetch all fields in search form
        $all_ids = array();
        if(!empty($form_id)){
            $this->load->model('forms_m');  
            $form = $this->forms_m->get($form_id);
            $fields_value_json_1 = $form->fields_order_primary;
            $fields_value_json_1 = htmlspecialchars_decode($fields_value_json_1);

            $obj_widgets = json_decode($fields_value_json_1);

            if(is_object($obj_widgets->PRIMARY))
            {
                foreach($obj_widgets->PRIMARY as $key=>$obj)
                {
                    if($obj->type == 'CHECKBOX')
                    {
                        $all_ids[$obj->id] = $obj->id;
                    }
                }
            }

            if(is_object($obj_widgets->SECONDARY))
            {
                foreach($obj_widgets->SECONDARY as $key=>$obj)
                {
                    if($obj->type == 'CHECKBOX')
                    {
                        $all_ids[$obj->id] = $obj->id;
                    }
                }
            }

            $category_id = 80;

            $CI = &get_instance();
            $CI->load->model('option_m');
            $category = $CI->option_m->get_by(array('parent_id'=>$category_id));

            if(!empty($category)):
                foreach($category as $key=>$item): 
                    $all_ids[$item->id] = $item->id;
                endforeach;
            endif;
        } else {
            $CI = &get_instance();
            $CI->load->model('option_m');
            $category = $CI->option_m->get_by(array('type'=>'CHECKBOX'));

            if(!empty($category)):
                foreach($category as $key=>$item): 
                    $all_ids[$item->id] = $item->id;
                endforeach;
            endif;
        }
        
        $this->data['all_ids'] = $all_ids; // for test
        
        $this->load->model('estate_m');
        
        $this->data['lang_id'] = $lang_id;
        
        $this->data['counters'] = $this->estate_m->get_all_counters($lang_id, $all_ids, $this->data['parameters']);
        
        echo json_encode($this->data);
        exit();
    }
    
    public function xml2u ($lang_code = 'en', $limit_properties=NULL, $offset_properties=0) {
        $this->load->library('session');
        if(!file_exists(APPPATH.'libraries/Xml2u.php') && $this->session->userdata('type') && $this->session->userdata('type')=='ADMIN') {
            exit('XML2U modul is not installed');
        }
        
        $this->load->library('xml2u');

        header("Content-type: text/xml");
        echo $this->xml2u->export($lang_code, $limit_properties, $offset_properties);
        exit();
    }
    
    public function facebook_feed_sale ($lang_code = 'en', $limit_properties=NULL, $offset_properties=0) {
        $this->load->library('session');
        if(!file_exists(APPPATH.'libraries/Facebook_feed.php')) {
            exit('Facebook_feed modul is not installed');
        }


        $this->load->library('facebook_feed');

        header("Content-type: text/xml");
        echo $this->facebook_feed->export($lang_code, $limit_properties, $offset_properties, 'sale');
        exit();
    }
    
    public function facebook_feed_rent ($lang_code = 'en', $limit_properties=NULL, $offset_properties=0) {
        $this->load->library('session');
        if(!file_exists(APPPATH.'libraries/Facebook_feed.php')) {
            exit('Facebook_feed modul is not installed');
        }
        
        $this->load->library('facebook_feed');

        header("Content-type: text/xml");
        echo $this->facebook_feed->export($lang_code, $limit_properties, $offset_properties, 'rent');
        exit();
    }
    
    function abuse ($listing_id = NULL, $lang_code = 'en') {
        $this->data['message'] = '';
        $this->data['success'] = false;
        $error ='';
        
        //load language files
        $this->load->model('language_m');
        $lang_name = $this->language_m->get_name($lang_code);
        if($lang_name != NULL)
            $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        // Check login and fetch user id
        $this->load->library('session');
        $this->load->model('user_m');
        /*
        if($this->user_m->loggedin() == TRUE)
        {
            $user_id = $this->session->userdata('id');
        }
        else
        {
            $this->data['message'] = lang_check('Login required!');
            echo json_encode($this->data);
            exit();
        }*/
        
        if($listing_id === NULL) {
            $this->data['message'] = lang_check('Missing listing_id');
            echo json_encode($this->data);
            exit();
        }
        /* from GET DATA */
        $_POST['property_id'] = $listing_id;
        
        
        $this->load->model('reports_m');
        $this->load->model('estate_m');
        
        $listing= $this->estate_m->get_dynamic($_POST['property_id']);

        if($listing){
            $_POST['agent_id'] = $listing->agent;
        }
        $_POST = array_merge($_POST, $_GET);
        
        //Validation
        $this->load->library('form_validation');
        $rules = $this->reports_m->rules_agent;
        $this->form_validation->set_rules($rules);
        
        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            $data = $this->reports_m->array_from_post(array('property_id', 'agent_id', 'name', 
                                                         'phone', 'email', 'message', 'allow_contact', 'date_submit'));
            
            // Save to database
            $data['date_submit'] = date('Y-m-d H:i:s');
            $this->reports_m->save($data);
            
            // Save to session
            $this->load->library('session');
            $data_sess = $data;
            $data_sess['reported'] = $this->session->userdata('reported');
            $data_sess['reported'][] = $data_sess['property_id'];
            $this->session->set_userdata($data_sess);
            
            // Send mail
            if(!empty($this->settings['email']))
            {
                // Send email to agent/user
                $this->load->library('email');
                $config_mail['mailtype'] = 'html';
                $this->email->initialize($config_mail);
                
                $this->email->from($this->settings['noreply'], lang_check('Web page'));
                $this->email->to($this->settings['email']);
                
                $this->email->subject(lang_check('Reporte from real-estate web'));
                
                $message = $this->load->view('email/report_submission', array('data'=>$data), TRUE);
                
                $this->email->message($message);
                if ( ! $this->email->send())
                {
                    $this->session->set_flashdata('email_sent', 'email_sent_false');
                    //echo 'problem sending email';
                }
                else
                {
                    $this->session->set_flashdata('email_sent', 'email_sent_true');
                    //echo 'successfully';
                }
            }
            
        }
        else
        {
            $error .= validation_errors();
        }
        
        $this->data['message'] = $error;
        
        if(empty($this->data['message'])) {
            $this->data['message'] = lang_check('Thanks on your abuse report');
            $this->data['success'] = true;
        }
        
        echo json_encode($this->data);
        exit();
        
    }
    
    function submit_visit($listing_id = NULL, $lang_code = 'en') {
        $this->data['message'] = '';
        $this->data['success'] = false;
        $error ='';
        
        //load language files
        $this->load->model('language_m');
        $lang_name = $this->language_m->get_name($lang_code);
        if($lang_name != NULL)
            $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        // Check login and fetch user id
        $this->load->library('session');
        $this->load->model('user_m');
        
        if($this->user_m->loggedin() == TRUE)
        {
            $user_id = $this->session->userdata('id');
        }
        else
        {
            $this->data['message'] = lang_check('Login required!');
            echo json_encode($this->data);
            exit();
        }
        
        if($listing_id === NULL) {
            $this->data['message'] = lang_check('Missing listing_id');
            echo json_encode($this->data);
            exit();
        }
        /* from GET DATA */
        $_POST['property_id'] = $listing_id;
        
        
        $this->load->model('visits_m');
        $this->load->model('estate_m');
        
        $listing= $this->estate_m->get_dynamic($_POST['property_id']);

        if($listing){
            $_POST['agent_id'] = $listing->agent;
        }
        
        $_POST = array_merge($_POST, $_GET);
        
        //Validation
        $this->load->library('form_validation');
        $rules = $this->visits_m->rules_client;
        $this->form_validation->set_rules($rules);
        $_POST['client_id'] = $this->session->userdata('id');
        
        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            $data = $this->visits_m->array_from_post(array('property_id', 'date_visit', 'client_id', 'message'));
            
            // Save to database
            $data['date_created'] = date('Y-m-d H:i:s');
            $data['date_visit'] = date('Y-m-d H:i:s',strtotime($data['date_visit']));
            $this->visits_m->save($data);
            
        }
        else
        {
            $error .= validation_errors();
        }
        
        $this->data['message'] = $error;
        
        if(empty($this->data['message'])) {
            $this->data['message'] = lang_check('Thanks on submit visit');
            $this->data['success'] = true;
        }
        
        echo json_encode($this->data);
        exit();
        
    }
        
    public function date_valid($date){
        if((bool)strtotime($date)) {
            return true;
        }
        
        $this->form_validation->set_message('date_valid', 'The Date field must date');
        return false;
    }
    
        
    public function login_form($lang_code = 'en') {
        $this->_immobilgolf_cors_headers();

        $this->data['success'] = false;
        $this->load->model('user_m');
        $this->load->library('session');
        $this->load->model('language_m');
        $this->load->library('form_validation');
        if($lang_code != NULL){
            $lang_name = $this->language_m->get_name($lang_code);
            $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        }
        
        $error='';
        $redirect=false;

        // Set form
        $rules = $this->user_m->rules;
        $this->form_validation->set_rules($rules);

        // Process form
        if($this->form_validation->run() == TRUE)
        {
            $candidate = $this->user_m->get_by_credentials();
            if (is_object($candidate) && $this->user_m->is_registration_license_expired($candidate))
            {
                $this->load->model('registration_pending_m');
                $token = $this->registration_pending_m->create_renew_pending($candidate);
                echo json_encode(array(
                    'success' => false,
                    'license_expired' => true,
                    'message' => 'La licenza è scaduta. Devi rinnovarla per continuare.',
                    'token' => $token,
                    'licenses_url' => site_url('api/registration_licenses/'.$lang_code.'?token='.rawurlencode($token).'&mode=renew'),
                    'errors' => '<p class="alert alert-danger">La licenza è scaduta. Devi rinnovarla per continuare.</p>',
                ));
                exit();
            }

            // We can login and redirect
            if($this->user_m->login() == TRUE)
            {

                if(file_exists(APPPATH.'controllers/admin/booking.php') && 
                   $this->config->item('reservations_disabled') === FALSE &&
                   $this->config->item('user_login_to_reservations') === TRUE)
                {
                    $redirect = site_url('frontend/myreservations/'.$lang_code);
                }

                $this->data['success'] = true;
                $session_type = $this->session->userdata('type');
                if ($session_type === 'USER')
                    $redirect = site_url('frontend/myproperties/'.$lang_code);
                else
                    $redirect = site_url('admin/dashboard');
            }   
            else
            {
                $error .= '<p class="alert alert-danger">'.lang_check('That email/password combination does not exist').'</p>';
            }
        }
        else
        {
            $error .= validation_errors();
        }
        
            
        $this->data['redirect'] = $redirect;
        $this->data['errors'] = $error;
        echo json_encode($this->data);
        exit();
    }

    /**
     * Check portal session for WordPress auth widget (CORS + credentials).
     */
    public function check_login($lang_code = 'en') {
        $this->_immobilgolf_cors_headers();

        $this->load->model('user_m');
        $this->load->library('session');

        $logged_in = ($this->user_m->loggedin() == TRUE);
        $type = $logged_in ? $this->session->userdata('type') : '';
        $name = $logged_in ? $this->session->userdata('name_surname') : '';

        // Drop session if registration license already expired
        if ($logged_in)
        {
            $uid = (int) $this->session->userdata('id');
            $user = $uid ? $this->user_m->get($uid) : FALSE;
            if (is_object($user) && $this->user_m->is_registration_license_expired($user))
            {
                $this->load->model('registration_pending_m');
                $token = $this->registration_pending_m->create_renew_pending($user);
                $this->user_m->logout();
                $logged_in = FALSE;
                $type = '';
                $name = '';
                echo json_encode(array(
                    'success' => true,
                    'logged_in' => false,
                    'license_expired' => true,
                    'message' => 'La licenza è scaduta. Devi rinnovarla per continuare.',
                    'token' => $token,
                    'licenses_url' => site_url('api/registration_licenses/'.$lang_code.'?token='.rawurlencode($token).'&mode=renew'),
                    'name' => '',
                    'type' => '',
                    'admin_url' => '',
                    'logout_url' => site_url('frontend/logout/'.$lang_code),
                ));
                exit();
            }
        }

        // Staff (Admin/Agent/Visitor) -> admin dashboard; User -> my properties
        if ($logged_in && $type === 'USER')
        {
            $admin_url = site_url('frontend/myproperties/'.$lang_code);
        }
        else
        {
            $admin_url = site_url('admin/dashboard');
        }

        $this->data = array(
            'success'    => true,
            'logged_in'  => $logged_in,
            'name'       => $name,
            'type'       => $type,
            'admin_url'  => $admin_url,
            'logout_url' => site_url('frontend/logout/'.$lang_code),
        );

        echo json_encode($this->data);
        exit();
    }

    /**
     * Destroy portal session for WordPress auth widget (CORS + credentials).
     */
    public function logout_form($lang_code = 'en') {
        $this->_immobilgolf_cors_headers();

        $this->load->model('user_m');
        $this->load->library('session');
        $this->user_m->logout();

        $this->data = array(
            'success'   => true,
            'logged_in' => false,
        );

        echo json_encode($this->data);
        exit();
    }

    /**
     * Create pending registration from WordPress (before license/payment).
     */
    public function registration_pending($lang_code = 'en')
    {
        $this->_immobilgolf_cors_headers();

        $payload = array(
            'name' => $this->input->post('name'),
            'surname' => $this->input->post('surname'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'coupon' => $this->input->post('coupon'),
            'password' => $this->input->post('password'),
            'tipo' => $this->input->post('tipo'),
            'provincia' => $this->input->post('provincia'),
            'club' => $this->input->post('club'),
            'address' => trim((string) $this->input->post('address')),
            'city' => trim((string) $this->input->post('city')),
            'postal_code' => trim((string) $this->input->post('postal_code')),
            'codice_fiscale' => strtoupper(trim((string) $this->input->post('codice_fiscale'))),
        );

        if (empty($payload['name']) || empty($payload['surname']) || empty($payload['email']) || empty($payload['password'])
            || empty($payload['address']) || empty($payload['city']) || empty($payload['postal_code']) || empty($payload['codice_fiscale']))
        {
            echo json_encode(array('success' => false, 'message' => 'Compila tutti i campi obbligatori.'));
            exit();
        }

        if (!filter_var($payload['email'], FILTER_VALIDATE_EMAIL))
        {
            echo json_encode(array('success' => false, 'message' => 'Email non valida.'));
            exit();
        }

        if (strlen($payload['password']) < 6)
        {
            echo json_encode(array('success' => false, 'message' => 'La password deve contenere almeno 6 caratteri.'));
            exit();
        }

        $this->load->model('user_m');
        if ($this->user_m->if_exists($payload['email']))
        {
            echo json_encode(array('success' => false, 'message' => 'Questa email è già registrata sul portale.'));
            exit();
        }

        // Never store plain password long-term: hash now
        $payload['password_hash'] = $this->user_m->hash($payload['password']);
        unset($payload['password']);

        $this->load->model('registration_pending_m');
        $this->load->model('registration_free_date_m');
        $this->load->model('registration_license_m');
        $token = $this->registration_pending_m->create_pending($payload);

        // Free registration window: create user immediately, skip license popup.
        $free_promo = $this->registration_free_date_m->get_active();
        if ($free_promo)
        {
            $this->db->where('active', 1);
            $this->db->order_by('duration_months', 'ASC');
            $licenses = $this->registration_license_m->get();
            $license = !empty($licenses) ? $licenses[0] : FALSE;

            if (!$license)
            {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Nessuna licenza disponibile per la registrazione gratuita.',
                ));
                exit();
            }

            $pending = $this->registration_pending_m->get_by_token($token);
            $payload['free_date_promo'] = 1;
            $payload['free_months'] = (int) $free_promo->free_months;

            $this->registration_pending_m->save(array(
                'payload' => json_encode($payload),
                'license_id' => (int) $license->id,
            ), $pending->id);

            $pending = $this->registration_pending_m->get_by_token($token);
            $invoice = ((int) $license->id).'_REG_'.$token.'_0_'.date('w');
            $user_id = $this->registration_pending_m->finalize_paid($pending, $license, $invoice);

            if (empty($user_id))
            {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Impossibile completare la registrazione gratuita. Riprova o contatta il supporto.',
                ));
                exit();
            }

            $this->load->model('payments_m');
            $currency = !empty($license->currency_code) ? $license->currency_code : 'EUR';
            $this->payments_m->save(array(
                'invoice_num' => $invoice,
                'date_paid' => date('Y-m-d H:i:s'),
                'data_post' => serialize(array(
                    'type' => 'registration_free_date',
                    'token' => $token,
                    'license_id' => (int) $license->id,
                    'license_name' => $license->license_name,
                    'mode' => 'register',
                    'user_id' => (int) $user_id,
                    'final_price' => 0,
                    'original_price' => round((float) $license->price, 2),
                    'duration_months' => (int) $free_promo->free_months,
                    'free_date_promo' => 1,
                    'free_months' => (int) $free_promo->free_months,
                )),
                'payer_id' => '',
                'txn_id' => 'FREE_'.$token,
                'paid' => '0.00',
                'currency_code' => $currency,
                'payer_email' => isset($payload['email']) ? $payload['email'] : '',
                'payment_gateway' => 'free',
            ));

            echo json_encode(array(
                'success' => true,
                'token' => $token,
                'free_register' => true,
                'paid' => true,
                'user_id' => (int) $user_id,
                'free_months' => (int) $free_promo->free_months,
            ));
            exit();
        }

        echo json_encode(array(
            'success' => true,
            'token' => $token,
            'licenses_url' => site_url('api/registration_licenses/'.$lang_code.'?token='.$token),
        ));
        exit();
    }

    /**
     * Apply coupon to pending registration (used from licenses iframe).
     */
    public function registration_apply_coupon($lang_code = 'en')
    {
        header('Content-Type: application/json; charset=utf-8');

        $token = trim((string) $this->input->post('token'));
        $coupon_code = trim((string) $this->input->post('coupon'));

        $this->load->model('registration_pending_m');
        $this->load->model('registration_coupon_m');
        $this->load->model('registration_license_m');

        $pending = $this->registration_pending_m->get_by_token($token);
        if (!$pending || !empty($pending->paid))
        {
            echo json_encode(array('success' => false, 'message' => 'Sessione registrazione non valida.'));
            exit();
        }

        if ($coupon_code === '')
        {
            echo json_encode(array('success' => false, 'message' => 'Inserisci un codice coupon.'));
            exit();
        }

        $coupon = $this->registration_coupon_m->get_by_code($coupon_code);
        $reason = '';
        if (!$coupon || !$this->registration_coupon_m->is_valid($coupon, $reason))
        {
            $messages = array(
                'not_found' => 'Coupon non trovato.',
                'inactive' => 'Coupon non attivo.',
                'exhausted' => 'Coupon esaurito (quantità terminata).',
                'not_started' => 'Coupon non ancora valido (data inizio).',
                'expired' => 'Coupon scaduto.',
            );
            if (!$coupon)
                $reason = 'not_found';
            $msg = isset($messages[$reason]) ? $messages[$reason] : 'Coupon non valido o scaduto.';
            echo json_encode(array('success' => false, 'message' => $msg, 'reason' => $reason));
            exit();
        }

        $payload = json_decode($pending->payload, TRUE);
        if (!is_array($payload))
            $payload = array();
        $payload['coupon'] = $coupon->coupon_code;
        $this->registration_pending_m->save(array(
            'payload' => json_encode($payload),
        ), $pending->id);

        $this->db->where('active', 1);
        $this->db->order_by('duration_months', 'ASC');
        $licenses = $this->registration_license_m->get();
        $prices = array();
        foreach ($licenses as $license)
        {
            $original = (float) $license->price;
            $price = $original;
            if ($coupon->discount_type === 'percent')
                $price = $price - ($price * ((float)$coupon->discount_value / 100));
            else
                $price = $price - (float)$coupon->discount_value;
            if ($price < 0)
                $price = 0;
            $price = round($price, 2);
            $currency = !empty($license->currency_code) ? $license->currency_code : 'EUR';
            $prices[] = array(
                'id' => (int) $license->id,
                'price' => $price,
                'original_price' => $original,
                'price_text' => $price.' '.$currency,
                'original_text' => $original.' '.$currency,
            );
        }

        echo json_encode(array(
            'success' => true,
            'message' => 'Coupon applicato correttamente.',
            'coupon' => $coupon->coupon_code,
            'discount_label' => $this->registration_coupon_m->format_discount($coupon),
            'prices' => $prices,
        ));
        exit();
    }

    /**
     * Embeddable registration licenses list for WordPress iframe popup.
     */
    public function registration_licenses($lang_code = 'en')
    {
        header('Content-Security-Policy: frame-ancestors https://immobilgolf.com https://www.immobilgolf.com http://immobilgolf.com http://www.immobilgolf.com');
        header_remove('X-Frame-Options');

        $token = trim((string) $this->input->get('token'));
        $mode = strtolower(trim((string) $this->input->get('mode')));
        $source = strtolower(trim((string) $this->input->get('source')));
        $is_renew = ($mode === 'renew');
        $source_qs = ($source !== '') ? '&source='.rawurlencode($source) : '';

        $this->load->model('registration_license_m');
        $this->load->model('registration_free_date_m');
        $this->db->where('active', 1);
        $this->db->order_by('duration_months', 'ASC');
        $licenses = $this->registration_license_m->get();
        // Free-date promo applies to new registration only, not renew.
        $free_promo = $is_renew ? FALSE : $this->registration_free_date_m->get_active();
        $free_months = $free_promo ? (int) $free_promo->free_months : 0;

        $title = $is_renew ? 'Renew license' : 'Registration licenses';
        $empty = 'No licenses available';
        $month_label = 'month';
        $months_label = 'months';
        $step1 = $is_renew ? '1. Select a license to renew' : '1. Select a license';
        $step2 = '2. Select payment method';
        $pay_label = 'Pay now';
        $free_label = $is_renew ? 'Renew now' : 'Register now';
        $paypal_label = 'PayPal';
        $stripe_label = 'Stripe';
        $free_payment_label = 'License Free';
        $coupon_label = 'Coupon code';
        $coupon_placeholder = 'Enter coupon code';
        $coupon_apply = 'Apply';
        $apply_url = site_url('api/registration_apply_coupon/'.$lang_code);
        $stripe_enabled = (config_item('stripe_enabled') === TRUE || config_item('stripe_enabled') === true);

        if ($lang_code === 'it')
        {
            $title = $is_renew ? 'Rinnova licenza' : 'Licenze di registrazione';
            $empty = 'Nessuna licenza disponibile';
            $month_label = 'mese';
            $months_label = 'mesi';
            $step1 = $is_renew ? '1. Seleziona una licenza da rinnovare' : '1. Seleziona una licenza';
            $step2 = '2. Seleziona il metodo di pagamento';
            $pay_label = 'Paga ora';
            $free_label = $is_renew ? 'Rinnova ora' : 'Registrati ora';
            $free_payment_label = 'Licenza gratuita';
            $coupon_label = 'Codice coupon';
            $coupon_placeholder = 'Inserisci il codice coupon';
            $coupon_apply = 'Applica';
        }

        echo '<!DOCTYPE html><html lang="'.htmlspecialchars($lang_code, ENT_QUOTES, 'UTF-8').'"><head>';
        echo '<meta charset="utf-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
        echo '<title>'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'</title>';
        echo '<style>
            *{box-sizing:border-box}
            html{scroll-behavior:smooth}
            body{margin:0;font-family:Arial,Helvetica,sans-serif;background:#f7f7f7;color:#333;padding:24px 16px}
            .ig-wrap{max-width:640px;width:100%;margin:0 auto}
            h1{margin:0 0 18px;font-size:22px;font-weight:700;color:#222}
            .ig-step{margin:0 0 10px;font-size:14px;font-weight:700;color:#444}
            .ig-coupon{
                background:#fff;border:1px solid #e5e5e5;border-radius:8px;padding:14px 16px;margin:0 0 16px;
                box-shadow:0 1px 2px rgba(0,0,0,.04)
            }
            .ig-coupon__label{display:block;margin:0 0 8px;font-size:13px;font-weight:700;color:#555}
            .ig-coupon__row{display:flex;gap:8px;align-items:stretch}
            .ig-coupon__input{
                flex:1;min-width:0;padding:10px 12px;border:1px solid #ccc;border-radius:6px;font-size:14px
            }
            .ig-coupon__btn{
                padding:10px 16px;border:0;border-radius:6px;background:#4b4b4b;color:#fff;
                font-size:14px;font-weight:700;cursor:pointer;white-space:nowrap
            }
            .ig-coupon__btn:hover{background:#333}
            .ig-coupon__btn:disabled{opacity:.6;cursor:not-allowed}
            .ig-coupon__msg{margin:8px 0 0;font-size:13px;display:none}
            .ig-coupon__msg.is-visible{display:block}
            .ig-coupon__msg.is-ok{color:#1b7a3d}
            .ig-coupon__msg.is-err{color:#b71c1c}
            .ig-licenses{display:grid;gap:12px;margin-bottom:18px}
            .ig-license{
                background:#fff;border:2px solid #e5e5e5;border-radius:8px;padding:14px 16px;
                display:flex;align-items:center;justify-content:space-between;gap:12px;
                box-shadow:0 1px 2px rgba(0,0,0,.04);cursor:pointer;transition:border-color .15s,box-shadow .15s
            }
            .ig-license:hover{border-color:#c8c8c8}
            .ig-license.is-selected{border-color:#e26824;box-shadow:0 0 0 1px #e26824}
            .ig-license__name{font-size:16px;font-weight:700;margin:0 0 4px}
            .ig-license__meta{margin:0;font-size:13px;color:#666}
            .ig-license__price-wrap{text-align:right}
            .ig-license__price{font-size:18px;font-weight:700;color:#4b4b4b;white-space:nowrap}
            .ig-license__price-old{display:none;font-size:12px;color:#999;text-decoration:line-through;margin-bottom:2px}
            .ig-license__price-old.is-visible{display:block}
            .ig-payments{display:none;margin-bottom:18px}
            .ig-payments.is-visible{display:block}
            .ig-payment-list{display:grid;gap:10px}
            .ig-payment{
                background:#fff;border:2px solid #e5e5e5;border-radius:8px;padding:12px 14px;
                display:flex;align-items:center;gap:10px;cursor:pointer;transition:border-color .15s
            }
            .ig-payment:hover{border-color:#c8c8c8}
            .ig-payment.is-selected{border-color:#e26824;box-shadow:0 0 0 1px #e26824}
            .ig-payment.is-hidden{display:none}
            .ig-payment input{margin:0}
            .ig-payment__label{font-size:15px;font-weight:700}
            .ig-actions{display:none;margin-top:4px}
            .ig-actions.is-visible{display:block}
            .ig-pay-btn{
                display:inline-block;width:100%;padding:12px 16px;border:0;border-radius:6px;
                background:#e26824;color:#fff;font-size:15px;font-weight:700;cursor:pointer
            }
            .ig-pay-btn:hover{background:#c9571b}
            .ig-pay-btn:disabled{opacity:.55;cursor:not-allowed}
            .ig-empty{padding:30px;text-align:center;color:#777;background:#fff;border-radius:8px}
            .ig-error{padding:12px 14px;margin-bottom:14px;background:#fdecea;color:#b71c1c;border:1px solid #f5c2c0;border-radius:6px;font-size:14px;line-height:1.45}
            .ig-notice{padding:12px 14px;margin:0 0 16px;background:#fdecea;color:#b71c1c;border:1px solid #e26824;border-radius:6px;font-size:14px;line-height:1.45;font-weight:600}
            @media (max-width:560px){
                .ig-license{flex-direction:column;align-items:flex-start}
                .ig-license__price-wrap{text-align:left}
                .ig-coupon__row{flex-direction:column}
            }
        </style></head><body>';
        echo '<div class="ig-wrap">';
        echo '<h1>'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'</h1>';

        if ($is_renew)
        {
            $renew_notice = ($lang_code === 'it')
                ? 'La licenza è scaduta. Devi rinnovarla per poter effettuare il login.'
                : 'Your license has expired. You must renew it to log in.';
            echo '<div class="ig-notice" role="alert">'.htmlspecialchars($renew_notice, ENT_QUOTES, 'UTF-8').'</div>';
        }

        if ($free_promo)
        {
            $free_notice = ($lang_code === 'it')
                ? 'Registrazione gratuita attiva: '.$free_months.' '.($free_months === 1 ? 'mese' : 'mesi').'.'
                : 'Free registration active: '.$free_months.' '.($free_months === 1 ? 'month' : 'months').'.';
            echo '<div class="ig-notice" role="status" style="background:#e8f5e9;color:#1b7a3d;border-color:#81c784">'.htmlspecialchars($free_notice, ENT_QUOTES, 'UTF-8').'</div>';
        }

        if ($token === '')
        {
            echo '<div class="ig-error">Sessione registrazione mancante. Chiudi e riprova.</div>';
            echo '</div></body></html>';
            exit();
        }

        if (empty($licenses))
        {
            echo '<div class="ig-empty">'.htmlspecialchars($empty, ENT_QUOTES, 'UTF-8').'</div>';
        }
        else
        {
            echo '<p class="ig-step" id="ig-step-license">'.htmlspecialchars($step1, ENT_QUOTES, 'UTF-8').'</p>';

            echo '<div class="ig-coupon" id="ig-coupon" data-token="'.htmlspecialchars($token, ENT_QUOTES, 'UTF-8').'" data-apply-url="'.htmlspecialchars($apply_url, ENT_QUOTES, 'UTF-8').'">';
            echo '<label class="ig-coupon__label" for="ig-coupon-input">'.htmlspecialchars($coupon_label, ENT_QUOTES, 'UTF-8').'</label>';
            echo '<div class="ig-coupon__row">';
            echo '<input type="text" class="ig-coupon__input" id="ig-coupon-input" placeholder="'.htmlspecialchars($coupon_placeholder, ENT_QUOTES, 'UTF-8').'" autocomplete="off">';
            echo '<button type="button" class="ig-coupon__btn" id="ig-coupon-apply">'.htmlspecialchars($coupon_apply, ENT_QUOTES, 'UTF-8').'</button>';
            echo '</div>';
            echo '<p class="ig-coupon__msg" id="ig-coupon-msg"></p>';
            echo '</div>';

            echo '<div class="ig-licenses" id="ig-licenses">';
            foreach ($licenses as $license)
            {
                $months = $free_promo ? $free_months : (int) $license->duration_months;
                $duration_text = $months.' '.($months === 1 ? $month_label : $months_label);
                $price = $free_promo ? 0.0 : (float) $license->price;
                $currency = !empty($license->currency_code) ? $license->currency_code : 'EUR';
                $price_text = $free_promo ? '0 '.$currency : ($license->price.' '.$currency);
                $checkout = site_url('api/registration_checkout/'.$lang_code.'/'.(int)$license->id.'?token='.rawurlencode($token).$source_qs);

                echo '<div class="ig-license" role="button" tabindex="0" data-id="'.(int)$license->id.'" data-price="'.htmlspecialchars((string)$price, ENT_QUOTES, 'UTF-8').'" data-original-price="'.htmlspecialchars((string)(float)$license->price, ENT_QUOTES, 'UTF-8').'" data-currency="'.htmlspecialchars($currency, ENT_QUOTES, 'UTF-8').'" data-checkout="'.htmlspecialchars($checkout, ENT_QUOTES, 'UTF-8').'">';
                echo '<div>';
                echo '<p class="ig-license__name">'.htmlspecialchars($license->license_name, ENT_QUOTES, 'UTF-8').'</p>';
                echo '<p class="ig-license__meta">'.htmlspecialchars($duration_text, ENT_QUOTES, 'UTF-8').'</p>';
                echo '</div>';
                echo '<div class="ig-license__price-wrap">';
                if ($free_promo && (float) $license->price > 0)
                {
                    echo '<div class="ig-license__price-old is-visible">'.htmlspecialchars($license->price.' '.$currency, ENT_QUOTES, 'UTF-8').'</div>';
                }
                else
                {
                    echo '<div class="ig-license__price-old"></div>';
                }
                echo '<div class="ig-license__price">'.htmlspecialchars($price_text, ENT_QUOTES, 'UTF-8').'</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';

            echo '<div class="ig-payments" id="ig-payments">';
            echo '<p class="ig-step" id="ig-step-payment">'.htmlspecialchars($step2, ENT_QUOTES, 'UTF-8').'</p>';
            echo '<div class="ig-payment-list">';
            echo '<label class="ig-payment ig-payment--paypal" data-method="paypal">';
            echo '<input type="radio" name="ig_payment_method" value="paypal">';
            echo '<span class="ig-payment__label">'.htmlspecialchars($paypal_label, ENT_QUOTES, 'UTF-8').'</span>';
            echo '</label>';
            if ($stripe_enabled)
            {
                echo '<label class="ig-payment ig-payment--stripe" data-method="stripe">';
                echo '<input type="radio" name="ig_payment_method" value="stripe">';
                echo '<span class="ig-payment__label">'.htmlspecialchars($stripe_label, ENT_QUOTES, 'UTF-8').'</span>';
                echo '</label>';
            }
            echo '<label class="ig-payment ig-payment--free is-hidden" data-method="free">';
            echo '<input type="radio" name="ig_payment_method" value="free">';
            echo '<span class="ig-payment__label">'.htmlspecialchars($free_payment_label, ENT_QUOTES, 'UTF-8').'</span>';
            echo '</label>';
            echo '</div>';
            echo '</div>';

            echo '<div class="ig-actions" id="ig-actions">';
            echo '<button type="button" class="ig-pay-btn" id="ig-pay-btn" disabled data-pay-label="'.htmlspecialchars($pay_label, ENT_QUOTES, 'UTF-8').'" data-free-label="'.htmlspecialchars($free_label, ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($pay_label, ENT_QUOTES, 'UTF-8').'</button>';
            echo '</div>';
        }

        echo '<script>
            (function(){
                var selectedLicense = null;
                var selectedPayment = null;
                var licenses = document.getElementById("ig-licenses");
                var payments = document.getElementById("ig-payments");
                var actions = document.getElementById("ig-actions");
                var payBtn = document.getElementById("ig-pay-btn");
                var couponBox = document.getElementById("ig-coupon");
                var couponInput = document.getElementById("ig-coupon-input");
                var couponBtn = document.getElementById("ig-coupon-apply");
                var couponMsg = document.getElementById("ig-coupon-msg");
                var paypalOpt = document.querySelector(".ig-payment--paypal");
                var stripeOpt = document.querySelector(".ig-payment--stripe");
                var freeOpt = document.querySelector(".ig-payment--free");
                if(!licenses || !payBtn) return;

                function isFreePrice(){
                    return selectedLicense && parseFloat(selectedLicense.getAttribute("data-price") || "0") <= 0;
                }

                function setPaymentOptions(free){
                    if(paypalOpt) paypalOpt.classList.toggle("is-hidden", !!free);
                    if(stripeOpt) stripeOpt.classList.toggle("is-hidden", !!free);
                    if(freeOpt) freeOpt.classList.toggle("is-hidden", !free);
                    Array.prototype.forEach.call(document.querySelectorAll(\'input[name="ig_payment_method"]\'), function(r){ r.checked = false; });
                    Array.prototype.forEach.call(document.querySelectorAll(".ig-payment"), function(el){ el.classList.remove("is-selected"); });
                    if(free && freeOpt){
                        var input = freeOpt.querySelector(\'input[type="radio"]\');
                        if(input) input.checked = true;
                        freeOpt.classList.add("is-selected");
                        selectedPayment = "free";
                    } else {
                        selectedPayment = null;
                    }
                }

                function updateUI(){
                    var free = isFreePrice();
                    if(selectedLicense){
                        payments.classList.add("is-visible");
                        setPaymentOptions(free);
                        if(free){
                            actions.classList.add("is-visible");
                            payBtn.disabled = false;
                            payBtn.textContent = payBtn.getAttribute("data-free-label") || "Registrati ora";
                            return;
                        }
                        actions.classList.remove("is-visible");
                        payBtn.disabled = true;
                        payBtn.textContent = payBtn.getAttribute("data-pay-label") || "Paga ora";
                    } else {
                        payments.classList.remove("is-visible");
                        actions.classList.remove("is-visible");
                        payBtn.disabled = true;
                    }
                }

                function showPayIfReady(){
                    var free = isFreePrice();
                    if(!selectedLicense) return;
                    if(free || selectedPayment){
                        actions.classList.add("is-visible");
                        payBtn.disabled = false;
                        payBtn.textContent = free
                            ? (payBtn.getAttribute("data-free-label") || "Registrati ora")
                            : (payBtn.getAttribute("data-pay-label") || "Paga ora");
                        scrollToEl(actions);
                    } else {
                        actions.classList.remove("is-visible");
                        payBtn.disabled = true;
                    }
                }

                function scrollToEl(el){
                    if(!el) return;
                    setTimeout(function(){
                        try {
                            el.scrollIntoView({behavior:"smooth", block:"start"});
                        } catch (err) {
                            el.scrollIntoView(true);
                        }
                    }, 60);
                }

                function selectLicense(el){
                    Array.prototype.forEach.call(document.querySelectorAll(".ig-license"), function(card){
                        card.classList.toggle("is-selected", card === el);
                    });
                    selectedLicense = el;
                    updateUI();
                    if(isFreePrice() && actions){
                        scrollToEl(actions);
                    } else if(payments){
                        scrollToEl(payments);
                    }
                }

                function showCouponMsg(text, ok){
                    if(!couponMsg) return;
                    couponMsg.textContent = text || "";
                    couponMsg.classList.add("is-visible");
                    couponMsg.classList.toggle("is-ok", !!ok);
                    couponMsg.classList.toggle("is-err", !ok);
                }

                function applyPrices(priceList){
                    if(!priceList || !priceList.length) return;
                    var map = {};
                    priceList.forEach(function(p){ map[String(p.id)] = p; });
                    Array.prototype.forEach.call(document.querySelectorAll(".ig-license"), function(card){
                        var p = map[String(card.getAttribute("data-id"))];
                        if(!p) return;
                        card.setAttribute("data-price", String(p.price));
                        var priceEl = card.querySelector(".ig-license__price");
                        var oldEl = card.querySelector(".ig-license__price-old");
                        if(priceEl) priceEl.textContent = p.price_text;
                        if(oldEl){
                            if(p.price < p.original_price){
                                oldEl.textContent = p.original_text;
                                oldEl.classList.add("is-visible");
                            } else {
                                oldEl.textContent = "";
                                oldEl.classList.remove("is-visible");
                            }
                        }
                    });
                    if(selectedLicense) updateUI();
                }

                if(couponBtn && couponBox){
                    couponBtn.addEventListener("click", function(){
                        var code = (couponInput && couponInput.value || "").trim();
                        if(!code){
                            showCouponMsg("Inserisci un codice coupon.", false);
                            return;
                        }
                        couponBtn.disabled = true;
                        var body = "token=" + encodeURIComponent(couponBox.getAttribute("data-token") || "")
                            + "&coupon=" + encodeURIComponent(code);
                        fetch(couponBox.getAttribute("data-apply-url"), {
                            method: "POST",
                            headers: {"Content-Type": "application/x-www-form-urlencoded"},
                            body: body
                        })
                        .then(function(r){ return r.json(); })
                        .then(function(res){
                            if(res && res.success){
                                showCouponMsg(res.message || "Coupon applicato.", true);
                                applyPrices(res.prices || []);
                            } else {
                                showCouponMsg((res && res.message) || "Coupon non valido.", false);
                            }
                        })
                        .catch(function(){
                            showCouponMsg("Errore di rete. Riprova.", false);
                        })
                        .then(function(){
                            couponBtn.disabled = false;
                        });
                    });
                    if(couponInput){
                        couponInput.addEventListener("keydown", function(e){
                            if(e.key === "Enter"){
                                e.preventDefault();
                                couponBtn.click();
                            }
                        });
                    }
                }

                licenses.addEventListener("click", function(e){
                    var card = e.target.closest(".ig-license");
                    if(!card) return;
                    selectLicense(card);
                });

                licenses.addEventListener("keydown", function(e){
                    if(e.key !== "Enter" && e.key !== " ") return;
                    var card = e.target.closest(".ig-license");
                    if(!card) return;
                    e.preventDefault();
                    selectLicense(card);
                });

                document.addEventListener("change", function(e){
                    if(!e.target || e.target.name !== "ig_payment_method") return;
                    selectedPayment = e.target.value;
                    Array.prototype.forEach.call(document.querySelectorAll(".ig-payment"), function(el){
                        el.classList.toggle("is-selected", el.getAttribute("data-method") === selectedPayment);
                    });
                    showPayIfReady();
                });

                document.addEventListener("click", function(e){
                    var payment = e.target.closest(".ig-payment");
                    if(!payment || payment.classList.contains("is-hidden")) return;
                    var input = payment.querySelector(\'input[type="radio"]\');
                    if(input){
                        input.checked = true;
                        input.dispatchEvent(new Event("change", {bubbles:true}));
                    }
                });

                payBtn.addEventListener("click", function(){
                    if(!selectedLicense || payBtn.disabled) return;
                    var free = isFreePrice();
                    if(!free && !selectedPayment) return;
                    var url = selectedLicense.getAttribute("data-checkout");
                    if(!url) return;
                    if(!free && selectedPayment && selectedPayment !== "free"){
                        url += (url.indexOf("?") >= 0 ? "&" : "?") + "method=" + encodeURIComponent(selectedPayment);
                    }
                    // Stripe form stays inside popup iframe; PayPal / free use parent navigation.
                    if(!free && selectedPayment === "stripe"){
                        window.location.href = url;
                        return;
                    }
                    if(window.parent && window.parent !== window){
                        window.parent.postMessage({type:"immobilgolf_license_checkout", checkoutUrl:url, method: selectedPayment || "free"}, "*");
                    } else {
                        window.location.href = url;
                    }
                });
            })();
        </script>';
        echo '</div></body></html>';
        exit();
    }

    /**
     * Start PayPal checkout for selected registration license.
     */
    public function registration_checkout($lang_code = 'en', $license_id = NULL)
    {
        $token = trim((string) $this->input->get('token'));
        $license_id = (int) $license_id;
        $source = strtolower(trim((string) $this->input->get_post('source')));

        $this->load->model('registration_pending_m');
        $this->load->model('registration_license_m');
        $this->load->model('registration_coupon_m');
        $this->load->model('registration_free_date_m');
        $this->load->model('settings_m');

        $pending = $this->registration_pending_m->get_by_token($token);
        $license = $license_id ? $this->registration_license_m->get($license_id) : FALSE;

        if (!$pending || !empty($pending->paid) || !$license || empty($license->active))
        {
            echo 'Registrazione non valida o già completata.';
            exit();
        }

        $payload = json_decode($pending->payload, TRUE);
        if (!is_array($payload))
        {
            echo 'Dati registrazione non validi.';
            exit();
        }

        $original_price = round((float) $license->price, 2);
        $price = $original_price;
        $currency = !empty($license->currency_code) ? $license->currency_code : 'EUR';
        $duration_months = is_object($license) ? (int) $license->duration_months : 0;
        $is_renew = (!empty($payload['mode']) && $payload['mode'] === 'renew');
        // Free-date promo is for new registrations only.
        $free_promo = $is_renew ? FALSE : $this->registration_free_date_m->get_active();
        $coupon_meta = array(
            'coupon' => '',
            'coupon_discount_type' => '',
            'coupon_discount_value' => '',
            'coupon_discount_label' => '',
            'discount_amount' => 0,
            'original_price' => $original_price,
            'duration_months' => $duration_months,
            'free_date_promo' => 0,
            'free_months' => 0,
        );

        // Free registration campaign: force price 0 and grant free_months.
        if ($free_promo)
        {
            $price = 0;
            $duration_months = (int) $free_promo->free_months;
            $payload['free_date_promo'] = 1;
            $payload['free_months'] = $duration_months;
            $coupon_meta['free_date_promo'] = 1;
            $coupon_meta['free_months'] = $duration_months;
            $coupon_meta['duration_months'] = $duration_months;
            $coupon_meta['discount_amount'] = $original_price;
            $this->registration_pending_m->save(array(
                'payload' => json_encode($payload),
            ), $pending->id);
        }
        else
        {
            // Clear stale free-promo flags so paid license duration is used.
            if (!empty($payload['free_months']) || !empty($payload['free_date_promo']))
            {
                unset($payload['free_months'], $payload['free_date_promo']);
                $this->registration_pending_m->save(array(
                    'payload' => json_encode($payload),
                ), $pending->id);
            }

            // Apply coupon discount if present
            if (!empty($payload['coupon']))
            {
                $coupon = $this->registration_coupon_m->get_by_code($payload['coupon']);
                if ($coupon && $this->registration_coupon_m->is_valid($coupon))
                {
                    if ($coupon->discount_type === 'percent')
                        $price = $price - ($price * ((float)$coupon->discount_value / 100));
                    else
                        $price = $price - (float)$coupon->discount_value;

                    if ($price < 0)
                        $price = 0;

                    $price = round($price, 2);
                    $coupon_meta['coupon'] = $coupon->coupon_code;
                    $coupon_meta['coupon_discount_type'] = $coupon->discount_type;
                    $coupon_meta['coupon_discount_value'] = $coupon->discount_value;
                    $coupon_meta['coupon_discount_label'] = $this->registration_coupon_m->format_discount($coupon);
                    $coupon_meta['discount_amount'] = round(max(0, $original_price - $price), 2);
                }
            }
            else
            {
                $price = round($price, 2);
            }
        }

        $this->registration_pending_m->save(array(
            'license_id' => $license_id,
        ), $pending->id);

        // Free license: complete immediately + log payment
        if ($price <= 0)
        {
            $invoice = $license_id.'_REG_'.$token.'_0_'.date('w');
            // Reload pending so free_months / coupon payload is current for finalize_paid.
            $pending = $this->registration_pending_m->get_by_token($token);
            $user_id = $this->registration_pending_m->finalize_paid($pending, $license, $invoice);

            if (empty($user_id))
            {
                echo 'Impossibile completare la registrazione. Riprova o contatta il supporto.';
                exit();
            }

            $this->load->model('payments_m');
            $this->payments_m->save(array(
                'invoice_num' => $invoice,
                'date_paid' => date('Y-m-d H:i:s'),
                'data_post' => serialize(array_merge($coupon_meta, array(
                    'type' => !empty($coupon_meta['free_date_promo']) ? 'registration_free_date' : 'registration_license_free',
                    'token' => $token,
                    'license_id' => $license_id,
                    'license_name' => is_object($license) ? $license->license_name : '',
                    'mode' => !empty($payload['mode']) ? $payload['mode'] : 'register',
                    'user_id' => (int) $user_id,
                    'final_price' => 0,
                ))),
                'payer_id' => '',
                'txn_id' => 'FREE_'.$token,
                'paid' => '0.00',
                'currency_code' => $currency,
                'payer_email' => isset($payload['email']) ? $payload['email'] : '',
                'payment_gateway' => 'free',
            ));

            $return = 'https://immobilgolf.com/home-tee-time/?ig_reg='.rawurlencode($token);
            if ($source === 'admin')
            {
                $this->_registration_login_user_id((int) $user_id);
                $this->registration_pending_m->consume_claim_token($pending);
                $return = site_url('admin/dashboard');
            }
            header('Location: '.$return);
            exit();
        }

        $method = strtolower(trim((string) $this->input->get_post('method')));
        if ($method === '' || $method === 'paypal')
        {
            $this->_registration_paypal_checkout($lang_code, $pending, $license, $payload, $token, $license_id, $price, $currency, $source);
            exit();
        }

        if ($method === 'stripe')
        {
            $this->_registration_stripe_checkout($lang_code, $pending, $license, $payload, $token, $license_id, $price, $currency, $source);
            exit();
        }

        echo 'Payment method not supported.';
        exit();
    }

    private function _registration_paypal_checkout($lang_code, $pending, $license, $payload, $token, $license_id, $price, $currency, $source = '')
    {
        $this->load->model('settings_m');
        $settings = $this->settings_m->get_fields();
        $business = isset($settings['paypal_email']) ? $settings['paypal_email'] : '';
        if (empty($business))
        {
            echo 'PayPal email address missing';
            exit();
        }

        // invoice: licenseId_REG_token_price_weekday
        $invoice = $license_id.'_REG_'.$token.'_'.$price.'_'.date('w');

        $this->registration_pending_m->save(array(
            'payment_invoice' => $invoice,
        ), $pending->id);

        $config = array();
        $config['business'] = $business;
        $config['cpp_header_image'] = '';
        if ($source === 'admin')
        {
            $config['return'] = site_url('api/registration_finish/'.$lang_code.'?token='.rawurlencode($token).'&source=admin');
            $config['cancel_return'] = site_url('api/registration_licenses/'.$lang_code.'?token='.rawurlencode($token).'&mode=renew&source=admin');
        }
        else
        {
            $config['return'] = 'https://immobilgolf.com/home-tee-time/?ig_reg='.rawurlencode($token);
            $config['cancel_return'] = 'https://immobilgolf.com/home-tee-time/?ig_reg_cancel=1';
        }
        $config['notify_url'] = site_url('frontend/notify_payment/'.$lang_code);
        $config['production'] = (ENVIRONMENT == 'production');
        $config['invoice'] = $invoice;
        $config['currency_code'] = $currency;
        if (!empty($payload['email']))
            $config['payer_email'] = $payload['email'];

        $this->load->library('paypal', $config);
        $this->paypal->add('Licenza registrazione '.$license->license_name, $price, 1);
        $this->paypal->pay();
        exit();
    }

    private function _registration_stripe_checkout($lang_code, $pending, $license, $payload, $token, $license_id, $price, $currency, $source = '')
    {
        header('Content-Security-Policy: frame-ancestors https://immobilgolf.com https://www.immobilgolf.com http://immobilgolf.com http://www.immobilgolf.com');
        header_remove('X-Frame-Options');

        if (config_item('stripe_enabled') !== TRUE && config_item('stripe_enabled') !== true)
        {
            echo 'Stripe payments is disabled';
            exit();
        }

        $this->load->library('MY_Composer');
        $this->load->model('registration_pending_m');
        $this->load->model('payments_m');

        $api_hash_secret = config_db_item('strip_api_hash_secret');
        $api_hash_public = config_db_item('strip_api_hash_public');
        if (empty($api_hash_secret) || empty($api_hash_public))
        {
            echo lang_check('https://stripe.com not configured');
            exit();
        }

        $price_fmt = number_format((float) $price, 2, '.', '');
        $invoice = $license_id.'_REG_'.$token.'_'.$price_fmt.'_'.date('w');
        $description = 'Registration license '.$license->license_name;
        $source_qs = ($source !== '') ? '&source='.rawurlencode($source) : '';
        $return_url = ($source === 'admin')
            ? site_url('admin/dashboard')
            : 'https://immobilgolf.com/home-tee-time/?ig_reg='.rawurlencode($token);
        $action_url = site_url('api/registration_checkout/'.$lang_code.'/'.$license_id.'?token='.rawurlencode($token).'&method=stripe'.$source_qs);
        $licenses_back_url = site_url('api/registration_licenses/'.$lang_code.'?token='.rawurlencode($token).(!empty($payload['mode']) && $payload['mode'] === 'renew' ? '&mode=renew' : '').$source_qs);
        $name_default = trim((isset($payload['name']) ? $payload['name'] : '').' '.(isset($payload['surname']) ? $payload['surname'] : ''));
        $phone_default = isset($payload['phone']) ? $payload['phone'] : '';

        $this->registration_pending_m->save(array(
            'payment_invoice' => $invoice,
        ), $pending->id);

        $this->load->library('form_validation');
        $this->form_validation->set_rules(array(
            'stripeToken' => array('field'=>'stripeToken', 'label'=>'stripeToken', 'rules'=>'trim|required'),
        ));

        if ($this->form_validation->run() == TRUE)
        {
            $gateway = Omnipay\Omnipay::create('Stripe');
            $gateway->setApiKey($api_hash_secret);

            $stripe_token = $this->input->post('stripeToken');
            $response = $gateway->purchase(array(
                'amount' => $price_fmt,
                'currency' => $currency,
                'transactionId' => $invoice,
                'description' => $description,
                'returnUrl' => $return_url,
                'token' => $stripe_token,
            ))->send();

            if ($response->isSuccessful())
            {
                $data = $response->getData();
                $txn_id = isset($data['id']) ? $data['id'] : $invoice;

                $pending = $this->registration_pending_m->get_by_token($token);
                $user_id = $this->registration_pending_m->finalize_paid($pending, $license, $invoice);

                if (empty($user_id))
                {
                    echo 'Pagamento ricevuto ma registrazione non completata. Contatta il supporto.';
                    exit();
                }

                $this->payments_m->save(array(
                    'invoice_num' => $invoice,
                    'date_paid' => date('Y-m-d H:i:s'),
                    'data_post' => serialize(array(
                        'type' => 'registration_license_stripe',
                        'token' => $token,
                        'license_id' => $license_id,
                        'license_name' => is_object($license) ? $license->license_name : '',
                        'mode' => !empty($payload['mode']) ? $payload['mode'] : 'register',
                        'user_id' => (int) $user_id,
                        'coupon' => !empty($payload['coupon']) ? $payload['coupon'] : '',
                        'stripe' => $data,
                    )),
                    'payer_id' => '',
                    'txn_id' => $txn_id,
                    'paid' => $price_fmt,
                    'currency_code' => $currency,
                    'payer_email' => isset($payload['email']) ? $payload['email'] : '',
                    'payment_gateway' => 'stripe.com',
                ));

                if ($source === 'admin')
                {
                    $this->_registration_login_user_id((int) $user_id);
                    $this->registration_pending_m->consume_claim_token($pending);
                    header('Location: '.site_url('admin/dashboard'));
                    exit();
                }

                // Inside popup iframe: notify parent WordPress page instead of navigating away.
                echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Payment ok</title></head><body style="font-family:Arial,sans-serif;padding:24px;text-align:center;">';
                echo '<p>Pagamento completato. Attendere…</p>';
                echo '<script>
                    (function(){
                      var payload = {type:"immobilgolf_registration_paid", token:'.json_encode($token).'};
                      var targets = ["https://immobilgolf.com", "https://www.immobilgolf.com"];
                      try {
                        if (window.parent && window.parent !== window) {
                          for (var i = 0; i < targets.length; i++) {
                            window.parent.postMessage(payload, targets[i]);
                          }
                          return;
                        }
                      } catch (e) {}
                      window.location.href = '.json_encode($return_url).';
                    })();
                </script></body></html>';
                exit();
            }
            elseif ($response->isRedirect())
            {
                $response->redirect();
                exit();
            }

            echo $response->getMessage();
            exit();
        }

        $name_js = json_encode($name_default);
        $output = '<!DOCTYPE html><html lang="it"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
        $output .= '<title>Stripe payment</title>';
        $output .= '<script src="https://js.stripe.com/v3/"></script>';
        $output .= '<style>
            html,body{height:100%;margin:0}
            *{box-sizing:border-box;font-family:Arial,Helvetica,sans-serif}
            body{
              background:#034f28;color:#fff;width:100%;height:100%;
              overflow:auto;-webkit-overflow-scrolling:touch;
              padding:28px 48px 32px;font-size:16px;
            }
            .blocco_payment{
              width:100%;max-width:520px;min-height:calc(100% - 8px);margin:0 auto;
              display:flex;flex-direction:column;justify-content:flex-start;
              background:transparent;border-radius:0;padding:0;
            }
            .logo-immobilgolf-payment{text-align:center;margin:0 0 18px}
            .logo-immobilgolf-payment img{width:170px;max-width:55%;height:auto}
            .logo-immobilgolf-payment strong{
              display:block;margin-top:10px;font-size:18px;font-weight:700;
              letter-spacing:.03em;line-height:1.3
            }
            form{width:100%;margin:0;flex:0 0 auto}
            .group{
              background:#fff;border-radius:10px;margin-bottom:14px;
              box-shadow:0 2px 10px rgba(0,0,0,.14);overflow:hidden
            }
            .group .row{display:flex;align-items:center;min-height:52px;border-bottom:1px solid #F0F5FA;padding:0 4px 0 0}
            .group .row:last-child{border-bottom:0}
            .group .row > span{
              width:78px;flex:0 0 78px;text-align:right;color:#6b7c90;
              font-weight:600;font-size:15px;padding-right:12px
            }
            .group .row .field{
              flex:1;min-width:0;background:transparent;border:0;color:#31325F;
              height:52px;outline:0;font-weight:500;font-size:16px;padding:0 14px;width:100%
            }
            #card-element{padding:14px;min-height:52px;height:auto}
            .StripeElement{width:100%}
            button[type="submit"]{
              display:block;width:100%;height:52px;outline:0;background:#e26824;color:#fff;
              border-radius:8px;border:0;margin-top:6px;font-weight:700;font-size:17px;cursor:pointer
            }
            button[type="submit"]:hover,button[type="submit"]:focus{background:#c9571b}
            .ig-back{
              display:block;width:100%;margin-top:14px;padding:14px 16px;
              border:1px solid rgba(255,255,255,.6);border-radius:8px;background:transparent;
              color:#fff;font-size:15px;font-weight:700;text-align:center;text-decoration:none;cursor:pointer
            }
            .ig-back:hover{background:rgba(255,255,255,.12);color:#fff;text-decoration:none}
            .outcome{padding-top:8px;min-height:22px;text-align:center}
            .error,.success{display:none;font-size:14px}
            .error.visible,.success.visible{display:inline}
            .error{color:#ffb4ae}.success{color:#b8f0c8}
            .logo-immobilgolf-text{
              text-align:center;margin:18px auto 0;line-height:1.5;font-size:14px;
              color:rgba(255,255,255,.92);max-width:100%
            }
            .logo-immobilgolf-text img{width:140px;max-width:50%;height:auto;margin-bottom:8px}
            .field::-webkit-input-placeholder{color:#CFD7E0}
            .field::-moz-placeholder{color:#CFD7E0}
            @media (max-width:560px){
              body{padding:20px 22px 24px;font-size:15px}
              .blocco_payment{max-width:100%}
              .logo-immobilgolf-payment strong{font-size:16px}
              .group .row > span{width:68px;flex-basis:68px;font-size:14px}
              .group .row .field,button[type="submit"]{font-size:15px}
              .logo-immobilgolf-text{font-size:13px}
            }
        </style></head><body>';
        $output .= '<div class="blocco_payment">';
        $output .= '<div class="logo-immobilgolf-payment"><img src="/files/logo-immobilgolf-white.png" alt="Immobilgolf"><strong>PAGA IN MODO SICURO</strong></div>';
        $output .= '<form method="post" action="'.htmlspecialchars($action_url, ENT_QUOTES, 'UTF-8').'" autocomplete="off">';
        $output .= '<div class="group">';
        $output .= '<div class="row"><span>Name</span><input name="cardholder-name" class="field" placeholder="Mario Rossi" autocomplete="cc-name" value="'.htmlspecialchars($name_default, ENT_QUOTES, 'UTF-8').'" /></div>';
        $output .= '<div class="row"><span>Phone</span><input class="field" placeholder="+39 333 123456" type="tel" autocomplete="tel" value="'.htmlspecialchars($phone_default, ENT_QUOTES, 'UTF-8').'" /></div>';
        $output .= '</div>';
        $output .= '<div class="group"><div class="row"><span>Card</span><div id="card-element" class="field"></div></div></div>';
        $output .= '<button type="submit">Pay '.$currency.$price_fmt.'</button>';
        $output .= '<div class="outcome"><div class="error" role="alert"></div><div class="success">Your payment send</div></div>';
        $output .= '</form>';
        $output .= '<a class="ig-back" href="'.htmlspecialchars($licenses_back_url, ENT_QUOTES, 'UTF-8').'">&larr; Torna alle licenze</a>';
        $output .= '<div class="logo-immobilgolf-text"><img src="/files/powered-stripe.svg" alt="Stripe"><br>Pagamento sicuro garantito da Stripe. I tuoi dati sono protetti con crittografia SSL.</div>';
        $output .= '</div>';
        $output .= "<script>
            var stripe = Stripe('".htmlspecialchars($api_hash_public, ENT_QUOTES, 'UTF-8')."', {locale: 'it'});
            var elements = stripe.elements();
            var card = elements.create('card', {
              hidePostalCode: true,
              style: {
                base: {
                  iconColor: '#e26824',
                  color: '#31325F',
                  lineHeight: '24px',
                  fontWeight: 500,
                  fontFamily: 'Arial, Helvetica, sans-serif',
                  fontSize: '16px',
                  '::placeholder': { color: '#CFD7E0' }
                }
              }
            });
            card.mount('#card-element');
            function setOutcome(result){
              var successElement = document.querySelector('.success');
              var errorElement = document.querySelector('.error');
              successElement.classList.remove('visible');
              errorElement.classList.remove('visible');
              if (result.token) {
                successElement.classList.add('visible');
                var f = document.createElement('form');
                f.setAttribute('method','post');
                f.setAttribute('action', ".json_encode($action_url).");
                f.style.display='none';
                var i = document.createElement('input');
                i.setAttribute('type','hidden');
                i.setAttribute('name','stripeToken');
                i.setAttribute('value', result.token.id);
                f.appendChild(i);
                document.body.appendChild(f);
                f.submit();
              } else if (result.error) {
                errorElement.textContent = result.error.message;
                errorElement.classList.add('visible');
              }
            }
            card.on('change', function(event){
              var errorElement = document.querySelector('.error');
              if (event.error) {
                errorElement.textContent = event.error.message;
                errorElement.classList.add('visible');
              } else {
                errorElement.classList.remove('visible');
              }
            });
            document.querySelector('form').addEventListener('submit', function(e){
              e.preventDefault();
              var form = document.querySelector('form');
              var name = form.querySelector('input[name=cardholder-name]').value || ".$name_js.";
              stripe.createToken(card, {name: name}).then(setOutcome);
            });
        </script></body></html>";

        echo $output;
        exit();
    }

    /**
     * Status check for WordPress after payment return.
     */
    public function registration_status($lang_code = 'en')
    {
        $this->_immobilgolf_cors_headers();

        $token = trim((string) $this->input->get_post('token'));
        $this->load->model('registration_pending_m');
        $pending = $this->registration_pending_m->get_by_token($token);

        if (!$pending)
        {
            echo json_encode(array('success' => false, 'paid' => false));
            exit();
        }

        $payload = json_decode($pending->payload, TRUE);
        if (is_array($payload))
            unset($payload['password_hash']);

        echo json_encode(array(
            'success' => true,
            'paid' => !empty($pending->paid),
            'user_id' => (int) $pending->user_id,
            'license_id' => (int) $pending->license_id,
            'payload' => $payload,
        ));
        exit();
    }

    /**
     * After payment return: login portal session using paid registration token.
     */
    public function registration_claim($lang_code = 'en')
    {
        $this->_immobilgolf_cors_headers();
        $this->load->library('session');
        $this->load->model('registration_pending_m');
        $this->load->model('user_m');

        $token = trim((string) $this->input->get_post('token'));
        $pending = $this->registration_pending_m->get_by_token($token);

        if (!$pending || empty($pending->paid) || empty($pending->user_id))
        {
            echo json_encode(array('success' => false, 'message' => 'Payment not completed'));
            exit();
        }

        if (!empty($pending->claimed))
        {
            echo json_encode(array('success' => false, 'message' => 'Sessione già utilizzata. Accedi con email e password.'));
            exit();
        }

        $user = $this->user_m->get((int) $pending->user_id);
        if (!is_object($user))
        {
            echo json_encode(array('success' => false, 'message' => 'User not found'));
            exit();
        }

        $this->_registration_login_user($user);
        $this->registration_pending_m->consume_claim_token($pending);

        $admin_url = site_url('frontend/myproperties/'.$lang_code);
        if ($user->type === 'ADMIN' || $user->type === 'AGENT' || $user->type === 'VISITOR')
            $admin_url = site_url('admin/dashboard');

        echo json_encode(array(
            'success' => true,
            'logged_in' => true,
            'name' => $user->name_surname,
            'admin_url' => $admin_url,
            'logout_url' => site_url('api/logout_form/'.$lang_code),
        ));
        exit();
    }

    /**
     * Browser return after admin renew payment (PayPal): wait/claim then go to admin.
     */
    public function registration_finish($lang_code = 'en')
    {
        $this->load->library('session');
        $this->load->model('registration_pending_m');
        $this->load->model('user_m');

        $token = trim((string) $this->input->get_post('token'));
        $source = strtolower(trim((string) $this->input->get_post('source')));
        $pending = $this->registration_pending_m->get_by_token($token);
        $dest = ($source === 'admin')
            ? site_url('admin/dashboard')
            : 'https://immobilgolf.com/home-tee-time/';

        if ($pending && !empty($pending->paid) && !empty($pending->user_id))
        {
            $this->_registration_login_user_id((int) $pending->user_id);
            if (empty($pending->claimed))
                $this->registration_pending_m->consume_claim_token($pending);
            header('Location: '.$dest);
            exit();
        }

        $status_url = site_url('api/registration_status/'.$lang_code.'?token='.rawurlencode($token));
        $claim_url = site_url('api/registration_claim/'.$lang_code);
        $retry_url = site_url('api/registration_finish/'.$lang_code.'?token='.rawurlencode($token).($source !== '' ? '&source='.rawurlencode($source) : ''));
        echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Completing…</title></head>';
        echo '<body style="font-family:Arial,sans-serif;padding:32px;text-align:center;">';
        echo '<p id="ig-msg">Pagamento in elaborazione…</p>';
        echo '<p id="ig-retry" style="display:none;margin-top:16px;"><a href="'.htmlspecialchars($retry_url, ENT_QUOTES, 'UTF-8').'">Riprova</a></p>';
        echo '<script>
          (function(){
            var tries = 0;
            var statusUrl = '.json_encode($status_url).';
            var claimUrl = '.json_encode($claim_url).';
            var token = '.json_encode($token).';
            var dest = '.json_encode($dest).';
            function done(){ window.location.href = dest; }
            function fail(){
              var msg = document.getElementById("ig-msg");
              var retry = document.getElementById("ig-retry");
              if(msg) msg.textContent = "Pagamento non ancora confermato. Attendi e riprova.";
              if(retry) retry.style.display = "block";
            }
            function poll(){
              tries++;
              fetch(statusUrl, {credentials:"include"}).then(function(r){return r.json();}).then(function(res){
                if(res && res.paid){
                  return fetch(claimUrl, {
                    method:"POST",
                    credentials:"include",
                    headers:{"Content-Type":"application/x-www-form-urlencoded"},
                    body:"token="+encodeURIComponent(token)
                  }).then(function(){ done(); });
                }
                if(tries < 40) setTimeout(poll, 2000);
                else fail();
              }).catch(function(){
                if(tries < 40) setTimeout(poll, 2000);
                else fail();
              });
            }
            poll();
          })();
        </script></body></html>';
        exit();
    }

    private function _registration_login_user_id($user_id)
    {
        $this->load->model('user_m');
        $this->load->library('session');
        $user = $this->user_m->get((int) $user_id);
        if (is_object($user))
            $this->_registration_login_user($user);
    }

    private function _registration_login_user($user)
    {
        $this->load->library('session');
        $this->db->where('id', $user->id);
        $this->db->update('user', array('last_login' => date('Y-m-d H:i:s')));

        $data = array(
            'name_surname' => $user->name_surname,
            'username' => $user->username,
            'remember' => TRUE,
            'id' => $user->id,
            'lang' => $user->language,
            'last_login' => $user->last_login,
            'loggedin' => TRUE,
            'type' => $user->type,
            'profile_image' => '',
            'last_activity' => time(),
        );
        $this->session->set_userdata($data);
    }

    private function _immobilgolf_cors_headers()
    {
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        $allowed_origins = array(
            'https://immobilgolf.com',
            'https://www.immobilgolf.com',
            'http://immobilgolf.com',
            'http://www.immobilgolf.com',
        );
        if (in_array($origin, $allowed_origins, TRUE))
        {
            header('Access-Control-Allow-Origin: '.$origin);
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
            header('Vary: Origin');
        }
        if (isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) === 'OPTIONS')
        {
            exit;
        }
    }
    
    public function register_form($lang_code = 'en') {
        $this->data['success'] = false;
        $this->load->model('user_m');
        $this->load->library('session');
        $this->load->model('language_m');
        $this->load->library('form_validation');
        if($lang_code != NULL){
            $lang_name = $this->language_m->get_name($lang_code);
            $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        }
        
        $error='';
        $redirect=false;

        $this->data['is_registration'] = true;

        /* [CAPTCHA Helper] */
        
        if(config_item('recaptcha_site_key') !== FALSE)
        {
            $this->config->set_item('captcha_disabled', TRUE);
        }
        
        if(config_item('captcha_disabled') === FALSE)
        {
            $this->load->helper('captcha');
            $captcha_hash = substr(md5(rand(0, 999).time()), 0, 5);
            $captcha_hash_old = $this->session->userdata('captcha_hash');
            if(isset($_POST['captcha_hash']))
                $captcha_hash_old = $_POST['captcha_hash'];
            
            $this->data['captcha_hash_old'] = $captcha_hash_old;
            $this->session->set_userdata('captcha_hash', $captcha_hash);

            $vals = array(
                'word' => substr(md5($captcha_hash.config_item('encryption_key')), 0, 5),
                'img_path' => FCPATH.'files/captcha/',
                'img_url' => base_url('files/captcha').'/',
                'font_path' => FCPATH.'admin-assets/font/verdana.ttf',
                'img_width' => 120,
                'img_height' => 35,
                'expiration' => 7200
                );

            $this->data['captcha'] = create_captcha($vals);
            $this->data['captcha_hash'] = $captcha_hash;
        }
        /* [/CAPTCHA Helper] */
        
        $rules = $this->user_m->rules_admin;
        $rules['name_surname']['label'] = 'lang:FirstLast';
        $rules['password']['rules'] .= '|required';
        $rules['type']['rules'] = 'trim';
        $rules['language']['rules'] = 'trim';
        $rules['mail']['label'] = 'lang:Email';
        $rules['mail']['rules'] .= '|valid_email';
        if($this->config->item('register_reduced') == TRUE)
        {
            $rules['name_surname']['rules'] = 'trim|xss_clean';
            $rules['username']['rules'] = 'trim|xss_clean';

            $e_mail = $this->input->post('mail');
            if(!empty($e_mail))
            {
                if(empty($_POST['username']))
                    $_POST['username'] = $e_mail;
                if(empty($_POST['name_surname']))
                    $_POST['name_surname'] = $e_mail;
            }
        }

        if(isset($_POST['password']))
            $_POST['password_confirm'] = $_POST['password'];

        if($this->config->item('captcha_disabled') === FALSE)
            $rules['captcha'] = array('field'=>'captcha', 'label'=>'lang:Captcha', 
                                      'rules'=>'trim|required|callback_captcha_check|xss_clean');
        
        if($this->config->item('recaptcha_site_key') !== FALSE)
            $rules['g-recaptcha-response'] = array('field'=>'g-recaptcha-response', 'label'=>'lang:Recaptcha', 
                                                    'rules'=>'trim|required|callback_captcha_check|xss_clean');

        $this->form_validation->set_rules($rules);

        // Process the form
        if($this->form_validation->run() == TRUE)
        {

            $data = $this->user_m->array_from_post(array('name_surname', 'mail', 'password', 'username',
                                                         'address', 'description', 'mail', 'phone','type', 'language', 'activated'));
            
            /*dump($_POST);
            dump($data);*/
            if($data['password'] == '')
            {
                unset($data['password']);
            }
            else
            {
                $data['password'] = $this->user_m->hash($data['password']);
            }

            if($data['type'] == 'AGENT')
            {
                $data['type'] = 'AGENT';
            }
            else
            {
                $data['type'] = 'USER';
            }
            
            $data['activated'] = '1';
            if(config_db_item('email_activation_enabled') === TRUE)
                $data['activated'] = '0';

            $data['description'] = '';
            $data['registration_date'] = date('Y-m-d H:i:s');
            $data['mail_verified'] = 0;
            $data['phone_verified'] = 0;

            if(empty($data['phone']))$data['phone'] = '';
            if(empty($data['phone2']))$data['phone2'] = '';
            if(empty($data['address']))$data['address'] = '';

            if($this->config->item('def_package') !== FALSE && $data['type'] == 'USER')
            {
                $data['package_id'] = $this->config->item('def_package');

                $this->load->model('packages_m');
                $package = $this->packages_m->get($data['package_id']);

                if(is_object($package))
                {
                    $days_extend = $package->package_days;

                    if($days_extend > 0)
                        $data['package_last_payment'] = date('Y-m-d H:i:s', time() + 86400*intval($days_extend));
                }
            }

            if($this->config->item('def_package_agent') !== FALSE && $data['type'] == 'AGENT')
            {
                $data['package_id'] = $this->config->item('def_package_agent');

                $this->load->model('packages_m');
                $package = $this->packages_m->get($data['package_id']);

                if(is_object($package))
                {
                    $days_extend = $package->package_days;

                    if($days_extend > 0)
                        $data['package_last_payment'] = date('Y-m-d H:i:s', time() + 86400*intval($days_extend));
                }
            }

            $user_id = $this->user_m->save($data, NULL);
            $message_mail = '';

            if(!empty($data['mail']) && config_db_item('email_activation_enabled') === TRUE)
            {
                $data['mail_verified'] = 0;
                // [START] Activation email

                //if(ENVIRONMENT != 'development')
                $this->load->library('email');
                $config_mail['mailtype'] = 'html';
                $this->email->initialize($config_mail);
                $this->email->from($this->settings['noreply'], lang_check('Web page'));
                $this->email->to($data['mail']);

                $this->email->subject(lang_check('Activate your account'));

                $new_hash = substr($this->user_m->hash($data['mail'].$user_id), 0, 5);

                $data_m = array();
                $data_m['name_surname'] = $data['name_surname'];
                $data_m['username'] = $data['username'];
                $data_m['activation_link'] = '<a href="'.site_url('admin/user/verifyemail/'.$user_id.'/'.$new_hash).'">'.lang_check('Activate your account').'</a>';
                $data_m['login_link'] = '<a href="'.site_url('frontend/login/').'?username='.$data['username'].'#content">'.lang_check('login_link').'</a>';

                $message = $this->load->view('email/email_activation', array('data'=>$data_m), TRUE);

                $this->email->message($message);
                if ( ! $this->email->send())
                {
                    $message_mail = ', '.lang_check('Problem sending email to user');
                }
                // [END] Activation email
            }

            if(!empty($data['phone']) && !empty($user_id) &&
               (config_db_item('clickatell_api_id') != FALSE || config_db_item('clickatell_api_key') != FALSE) && config_db_item('phone_verification_enabled') === TRUE &&
               file_exists(APPPATH.'libraries/Clickatellapi.php'))
            {
                $data['phone_verified'] = 0;

                //Send SMS for phone verification
                $new_hash = substr($this->user_m->hash($data['phone'].$user_id), 0, 5);

                $message='';
                $message.=lang_check('Your code').": \n";
                $message.=$new_hash."\n";
                $message.=lang_check('Verification link').": \n";
                $message.=site_url('admin/user/verifyphone/'.$user_id.'/'.$new_hash);

                $this->load->library('clickatellapi');
                $return_sms = $this->clickatellapi->send_sms($message, $data['phone']);

                if(substr_count($return_sms, 'successnmessage') == 0)
                {
                    // nginx causing error 502
                    // $this->session->set_flashdata('error_sms', $return_sms);
                }
            }

            if(config_db_item('email_activation_enabled') !== FALSE)
            {
                $this->data['message'] =
                        lang_check('Thanks on registration, please check and activate your email to login').$message_mail;
            }
            else
            {
                $this->data['message'] =
                        lang_check('Thanks on registration, you can login now').$message_mail;
            }

            if(!empty($user_id) && 
                config_item('registration_interest_enabled') === TRUE && 
                config_item('tree_field_enabled') === TRUE)
            {
                $redirect = site_url('fresearch/treealerts/'.$this->data['lang_code'].'/'.$user_id.'/'.md5($user_id.config_item('encryption_key')));
            }

            $this->data['success'] = true;
        }
        else {
            $error .= validation_errors();
        }
            
        $this->data['redirect'] = $redirect;
        $this->data['errors'] = $error;
        echo json_encode($this->data);
        exit();
    }

    public function _unique_mail($str)
    {
        // Do NOT validate if mail alredy exists
        // UNLESS it's the mail for the current user
        $this->load->model('user_m');
        $id = $this->session->userdata('id');
        $this->db->where('mail', $this->input->post('mail'));
        !$id || $this->db->where('id !=', $id);
        
        $user = $this->user_m->get();
        
        if(sw_count($user))
        {
            $this->form_validation->set_message('_unique_mail', '%s '.lang_check('should be unique'));
            return FALSE;
        }
        
        return TRUE;
    }

    public function captcha_check($str)
    {
        if($this->config->item('recaptcha_site_key') !== FALSE)
        {
            if(valid_recaptcha() === TRUE)
            {
                return TRUE;
            }
            else
            {
                $this->form_validation->set_message('captcha_check', lang_check('Robot verification failed'));
                return FALSE;
            }
        }

        if ($str != substr(md5($this->data['captcha_hash_old'].config_item('encryption_key')), 0, 5))
        {
                $this->form_validation->set_message('captcha_check', lang_check('Wrong captcha'));
                return FALSE;
        }
        else
        {
                return TRUE;
        }
    }
    
    public function get_all_counters_by_id($lang_id, $option_id=2)
    {
        //load language files
        $this->load->model('language_m');
        $this->load->model('option_m');
        $lang_name = $this->language_m->get_name($lang_id);
        $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        
        $this->data['message'] = lang_check('No message returned!');
        
        unset($_POST['v_undefined']);
        
        $this->data['parameters'] = $_POST;
        $parameters = json_encode($_POST);
        
        $this->data['parameters']['is_activated'] = 1;
        $f_name = 'v_search_option_'.$option_id;
        if(isset($this->data['parameters'][$f_name]))
            unset($this->data['parameters'][$f_name]);
        
        $this->load->model('estate_m');
        
        $this->data['lang_id'] = $lang_id;
        
        $this->data['counters'] = $this->estate_m->get_all_counters($lang_id, array(), $this->data['parameters'],$option_id);
        
        /* if fields type == TREE */
        $check_option= $this->option_m->get_by(array('id'=>$option_id));
        if($check_option[0]->type=='TREE')
        {
            function recursion_calc_sw_count ($result_count, $tree_listings, $parent_title, $id, &$ariesInfo, &$deprecated_categories){
                if (isset($tree_listings[$id]) && sw_count($tree_listings[$id]) > 0){
                    foreach ($tree_listings[$id] as $key => $_child) {
                        $options = $tree_listings[$_child->parent_id][$_child->id];

                        $_parent_title = $parent_title.' - '.$options->value;

                        if(isset($result_count[$_parent_title.' -'])) {
                            $ariesInfo[$_parent_title.' -']['count']=$result_count[$_parent_title.' -'];
                        } else {
                            $ariesInfo[$_parent_title.' -']['count']=0;
                        }
                        /* deprecated categories */
                        if(isset($deprecated_categories[$_parent_title.' -'])) {
                            unset($deprecated_categories[$_parent_title.' -']);
                        }
                        /* end deprecated categories */
                        if (isset($tree_listings[$_child->id]) && sw_count($tree_listings[$_child->id]) > 0){    
                            recursion_calc_sw_count($result_count, $tree_listings, $_parent_title, $_child->id, $ariesInfo, $deprecated_categories);
                        }
                    }
                }
            };
            
            
            $this->load->model('treefield_m');
            $tree_listings = $this->treefield_m->get_table_tree($lang_id, $option_id, NULL, FALSE, '.order');
            if(!empty($tree_listings)){
                $result_count = array();
                foreach ($this->data['counters'] as $key => $value) {
                    if(!empty($value->value))
                        $result_count[$value->value]= $value->count;
                }
                $deprecated_categories = $result_count;
                
                $_treefields = $tree_listings[0];
                $ariesInfo = array();
                foreach ($_treefields as $val) {
                    $options = $tree_listings[0][$val->id];
                    $treefield = array();
                    $field_name = 'value' ;
                    $treefield['id'] = $val->id;
                    $treefield['title'] = $options->$field_name;

                    if(isset($result_count[$treefield['title'].' -'])) {
                        $ariesInfo[$treefield['title'].' -']['count']=$result_count[$treefield['title'].' -'];
                    } else {
                        $ariesInfo[$treefield['title'].' -']['count']=0;
                    }
                    /* deprecated categories only */
                    if(isset($deprecated_categories[$treefield['title'].' -'])) {
                        unset($deprecated_categories[$treefield['title'].' -']);
                    }
                    /* end deprecated categories  */
                    
                    if(isset($tree_listings[$val->id]) && sw_count($tree_listings[$val->id]) > 0){
                        $parent_title = $treefield['title'];
                        recursion_calc_sw_count($result_count, $tree_listings, $parent_title, $val->id, $ariesInfo, $deprecated_categories);
                    }     
                }
               
                /* deprecated categories only */
                foreach ($_treefields as $val) {
                    foreach ($deprecated_categories as $k => $v) {
                        if(stripos($k, $val->value)===0 && $k != $val->value) {
                            if(isset($ariesInfo[$val->value.' -']['count']))
                                $ariesInfo[$val->value.' -']['count'] += (int)$v;
                        }
                    }
                }
                /* end deprecated categories only */
                
                $count = array();
                foreach ($ariesInfo as $key => $value) {
                    $_count = $value['count'];
                    foreach ($ariesInfo as $k => $v) {
                        if(stripos($k, $key)===0 && $k != $key) {
                            $_count +=$v['count'];
                        }
                    }
                    $item= new stdClass();
                    $item->value = $key;
                    $item->count = $_count;
                    $count[]= $item;
                }
                $this->data['counters'] = $count;  
            }
        }
        
        /* end if fields type == TREE */
        
        echo json_encode($this->data);
        exit();
    }
    
    public function twitter_login($lang_id = NULL)
    {
		
	$this->load->library('session');
        $this->load->model('user_m');
        $this->load->model('language_m');
        $this->load->library('Twlogin');
        
        if(!file_exists(APPPATH.'libraries/Twlogin.php'))
        {
            exit('Twitter login modul is not available');
        }
        
        if(!empty($lang_id)){
            $this->session->set_userdata('lang_id', $lang_id);
        } elseif($this->session->userdata('lang_id')) {
            $lang_id = $this->session->userdata('lang_id');
        }
        
        if(empty($lang_id))
            $lang_id = $this->language_m->get_default_id();
        
        $lang_code = $this->language_m->get_code($lang_id);
        $lang_name = $this->language_m->get_name($lang_id);
        
        /* new user */
        if (!isset($_GET['oauth_token'])) {
        
            // create a new twitter connection object
            $connection  = new Twlogin();
            // get the token from connection object
            $request_token = $connection->getRequestToken(); 
            // if request_token exists then get the token and secret and store in the session
            if($request_token){
                    $token = $request_token['oauth_token'];
                    $this->session->set_flashdata('request_token', $token);
                    $this->session->set_flashdata('request_token_secret', $request_token['oauth_token_secret']);
                    
                    // get the login url from getauthorizeurl method
                    $login_url = $connection->getAuthorizeURL($token);
                    header('Location: ' . $login_url);
                    exit;
            } else {
                /* try againe (not conntect with twitter, check config)*/
                $this->session->set_flashdata('error', 
                    lang_check("Can't connect with twitter please try again or contact with support"));
                redirect('frontend/login/'.$lang_code); 
                exit();
            }
                redirect('frontend/login/'.$lang_code); 
            exit();
        } elseif (isset($_GET['oauth_token'])) {
            
            // create a new twitter connection object with request token
            
            $connection = new Twlogin( $this->session->flashdata('request_token'),  $this->session->flashdata('request_token_secret'));
            // get the access token from getAccesToken method
            $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
            if($access_token){	
                    // set the parameters array with attributes include_entities false
                    $params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');
                    // get the data
                    $data = $connection->get('account/verify_credentials',$params);
                    if($data){
                        // store the data in the session
                        $user_array = (array)$data;
                        $user_email =  _ch($user_array['email'],$user_array['screen_name'].'@twitter.com');
                        $user_namesurname = _ch($user_array['name'],'');
                        $user_avatar = _ch($user_array['profile_image_url'],'');
                        
                        // Register / Login
                        $user_get = $this->user_m->get_by(array('password'=>$this->user_m->hash($user_array['id_str']), 
                                                                'username'=>$user_email), true);

                        if(sw_count($user_get) == 0)
                        {

                            // Check if email already exists
                            if($this->user_m->if_exists($user_email) === TRUE)
                            {
                                exit('Email already exists in database, please contact administrator or reset password');
                            }

                            // Register user
                            $data_f = array();
                            $data_f['username'] = $user_email;
                            $data_f['mail'] = $user_email;
                            $data_f['password'] = $this->user_m->hash($user_array['id_str']);
                            $data_f['facebook_id'] = '';
                            $data_f['type'] = 'USER';
                            $data_f['name_surname'] = $user_namesurname;
                            $data_f['activated'] = '1';
                            $data_f['description'] = '';
                            $data_f['language'] = $lang_name;
                            $data_f['registration_date'] = date('Y-m-d H:i:s');
                            $data_f['mail_verified'] = 0;
                            $data_f['phone_verified'] = 0;               

                            if($this->config->item('def_package') !== FALSE)
                            {
                                $data_f['package_id'] = $this->config->item('def_package');

                                $this->load->model('packages_m');
                                $package = $this->packages_m->get($data_f['package_id']);

                                if(is_object($package))
                                {
                                    $days_extend = $package->package_days;

                                    if($days_extend > 0)
                                        $data_f['package_last_payment'] = date('Y-m-d H:i:s', time() + 86400*intval($days_extend));
                                }
                            }      

                            $user_id = $this->user_m->save($data_f, NULL);
                            if(empty($user_id))
                            {
                                echo 'QUERY: '.$this->db->last_query().PHP_EOL;
                                echo '<br />';
                                echo 'ERROR: '.$this->db->_error_message().PHP_EOL;
                                echo '<br />';
                                echo 'Please contact with administrator and send errors';
                                exit();
                            }

                            if(!empty($user_avatar)){
                                $user_avatar=str_replace('_normal', '_400x400', $user_avatar);
                                
                                $this->load->model('repository_m');
                                $this->load->model('file_m');
                                $this->load->library('uploadHandler', array('initialize'=>FALSE));

                                $user_data = $this->user_m->get($user_id);
                                // Fetch file repository
                                $repository_id = $user_data->repository_id;
                                if(empty($repository_id))
                                {
                                    // Create repository
                                    $repository_id = $this->repository_m->save(array('name'=>'user_m'));
                                    // Update with new repository_id
                                    $this->user_m->save(array('repository_id'=>$repository_id), $user_data->id);
                                }

                                $file_name = '';

                                $handle   = curl_init($user_avatar);
                                curl_setopt($handle, CURLOPT_HEADER, false);
                                curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
                                curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox
                                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
                                curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 3);
                                $file = curl_exec($handle);
                                ##print $connectable;
                                curl_close($handle);
                                $image_info = getimagesizefromstring($file);

                                $extension ='';
                                switch ($image_info['mime']) {
                                    case 'image/gif':
                                                    $extension = '.gif';
                                                    break;
                                    case 'image/jpeg':
                                                    $extension = '.jpg';
                                                    break;
                                    case 'image/png':        
                                                    $extension = '.png';
                                                    break;
                                    default:
                                                    // handle errors
                                                    break;
                                }
                                $new_file_name=time().rand(000, 999).$extension;
                                file_put_contents(FCPATH.'/files/'.$new_file_name, $file);
                                /* create thumbnail */
                                $this->uploadhandler->regenerate_versions($new_file_name);
                                /* end create thumbnail */
                                $file_name= $new_file_name;
                                $next_order=0;
                                $file_id = $this->file_m->save(array(
                                'repository_id' => $repository_id,
                                'order' => $next_order,
                                'filename' => $file_name,
                                )); 
                                $next_order++;
                            }
                        }
                        
                        // Login :: AUTO
                        if($this->user_m->login($user_email, $user_array['id']) == TRUE)
                        {
                            if(!empty($user_id) && 
                                config_item('registration_interest_enabled') === TRUE && 
                                config_item('tree_field_enabled') === TRUE)
                            {
                                redirect('fresearch/treealerts/'.$lang_code.'/'.$user_id.'/'.md5($user_id.config_item('encryption_key')));
                            }

                            redirect('frontend/myproperties/'.$lang_code);
                            exit();
                        }
                        else
                        {
                            $this->session->set_flashdata('error', 
                                    lang_check('That email/password combination does not exists'));
                            redirect('frontend/login/'.$lang_code); 
                            exit();
                        }
                        
                        
                    } else {
                        /* try againe (not conntect with twitter, check config)*/
                        $this->session->set_flashdata('error', 
                             lang_check("Twitter oAuth cant get data. Please try againe or contact with support"));
                        redirect('frontend/login/'.$lang_code); 
                        exit();
                    }
            } else {
                /* try againe (not conntect with twitter, check config)*/
                $this->session->set_flashdata('error', 
                    lang_check("Twitter oAuth Invalid request token. Please try againe or contact with support"));
                redirect('frontend/login/'.$lang_code); 
                exit();
            }
            exit();
        }
        exit();
    }


    public function treefieldid($output="", $atts=array(), $instance=NULL)
    {
        $language_id = $this->input->post('language_id', true);
        $this->load->model('language_m');
        $this->load->library('form_validation');

        if($language_id != NULL){
            $lang_name = $this->language_m->get_name($language_id);
            $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        }

        $ajax_output = array();
        $ajax_output['message'] = lang_check('No message returned!', 'sw_win');
        $results = array();
        
        $parameters = $_POST;
        
        $table = $this->input->post('table', true);
        $table_name = $table;
        
        if(empty($parameters['empty_value']))
            $parameters['empty_value'] = ' - ';
        
        if(empty($parameters['limit']))
            $parameters['limit'] = 10;
            
        if(empty($parameters['offset']))
            $parameters['offset'] = 0;
            
        if(empty($parameters['attribute_id']))
            $parameters['attribute_id'] = 'id';
            
        if(empty($parameters['attribute_value']))
            $parameters['attribute_value'] = 'address';
            
        if(empty($parameters['field_id']))
            $parameters['field_id'] = 1;
            
        if(empty($parameters['offset']))
            $parameters['offset'] = 0;
        
        $start_id = '';
        if(isset($parameters['start_id']))
            $start_id = $parameters['start_id'];
        
        if($parameters['offset'] == 0) // currently don't have load_more functionality'
        if(!empty($parameters['empty_value']))
        {
            $results[0]['key'] = '';
            $results[0]['value'] = $parameters['empty_value'];
        }

        if(substr($table,-2, 2) == '_m')
        {
            // it's model
            $table_name = substr($table,0, -2);
            $attr_id = $parameters['attribute_id'];
            $attr_val = $parameters['attribute_value'];
            $attr_search = $parameters['search_term'];
            $skip_id = $parameters['skip_id'];
            
            $id_part="";
            if(is_numeric($attr_search))
                $id_part = "$attr_id=$attr_search OR ";
        
            $this->load->model($table);
            
            $where = array();
            
            if(!empty($attr_search))
                $where["($id_part $attr_val LIKE '%$attr_search%')"] = NULL;
            
            //get_by($where, $single = FALSE, $limit = NULL, $order_by = NULL, $offset = NULL, 
            //$search = array(), $where_in = NULL, $check_user = FALSE, $fetch_user_details=FALSE)
            
            
            $q_results=array();
            if($table == 'treefield_m')
            {
                //if(!empty($skip_id))
                //    $where["( id$table_name != $skip_id )"] = NULL;
                
                //if(!empty($parameters['language_id']))
                //    $where["lang_id"] = $parameters['language_id'];
                    
                $table_name = 'sw_'.$table_name;
                    
                
//                $this->db->join($table_name.'_lang', $table_name.'.idtreefield = '.$table_name.'_lang.treefield_id');
//                $this->db->where('lang_id', current_language_id());
//                $this->db->where('field_id', $parameters['field_id']);
                
//                $q_results = $this->$table->get_by($where, FALSE, $parameters['limit'], 
//                                                    "$attr_id DESC", $parameters['offset'],
//                                                    array(), NULL, TRUE);
                
                //var_dump($q_results);

                //echo $this->db->last_query();
                //exit();
                
                
                if(!empty($parameters['filter_ids'])) {
                    $parameters['filter_ids'] = explode(',', $parameters['filter_ids']);
                    $str = '';
                    foreach ($parameters['filter_ids'] as $v) {
                        if(stripos($v, 'fetch_child') !== FALSE){
                            $pos = strrpos($v, "_fetch_child");
                            $v = substr($v,0,$pos);
                            $v = trim($v, ' -');
                            $v = $this->treefield_m->id_by_path($parameters['field_id'], $language_id, $v);
                            if(!empty($v)){
                                $childs = array();
                                $this->treefield_m->get_all_childs($v,$parameters['field_id'], $childs);
                                if(empty($str)) 
                                    $str.='(';
                                else
                                    $str.=' OR ';
                                $str .= ' parent_id = '.$v.' OR  treefield.id = '.$v.'';
                                
                                if($childs)foreach($childs  as $child ) {
                                    $str.=' OR ';
                                    $str .= ' parent_id = '.$child.' OR  treefield.id = '.$child.'';
                                }
                            }
                            continue;
                        }
                        $v = trim($v, ' -');
                        $v = $this->treefield_m->id_by_path($parameters['field_id'], $language_id, $v);
                        if($v){
                        if(empty($str)) 
                            $str.='(';
                        else
                            $str.=' OR ';
                        $str .= ' parent_id = '.$v.' OR  treefield.id = '.$v.'';
                        }
                    }
                    if(!empty($str)){
                    $str.=')';
                    $where[$str] = NULL;
                    }
                    unset($results[0]);
                }
                
                if($parameters['offset'] == 0){ // currently don't have load_more functionality'
                   if(!empty($attr_search))
                    $q_results = $this->$table->get_table_tree($language_id, $parameters['field_id'], $skip_id, true, '_lang.value', ', treefield_lang.value_path', $where);
                   else
                    $q_results = $this->$table->get_table_tree($language_id, $parameters['field_id'], $skip_id, true, '_lang.value', ', treefield_lang.value_path', $where);
                    //$q_results = $this->$table->get_treefield($language_id, $parameters['field_id'],  NULL, NULL, $where);
                }
                
                
                //var_dump($q_results);

                //echo $this->db->last_query();
                //exit();
            }
            else
            {
                $q_results = $this->$table->get_by($where, FALSE, $parameters['limit'], 
                                                    "$attr_id DESC", $parameters['offset']);
            }
            $ind_order=1;
            foreach ($q_results as $key=>$row)
            {
                $set_index = $ind_order;
                
                
                $level_gen='';
                if(empty($attr_search) ){
                    $_set_attr_id = $attr_id;
                    
                    if(is_numeric($start_id))
                        $_set_attr_id = 'id';
                    
                    if(empty($row->{$attr_id})) continue;
                    if(!empty($start_id) && ($start_id == $row->{$_set_attr_id}.' -'  || $start_id == $row->{$_set_attr_id} ) && isset($parameters['sub_empty_value']) && !empty($parameters['sub_empty_value'])){$row->{$parameters['attribute_value']} = $parameters['sub_empty_value'];$set_index=0;}
                    elseif(!empty($start_id) && ($start_id == $row->{$_set_attr_id}.' -'  || $start_id == $row->{$_set_attr_id} )) {$row->{$parameters['attribute_value']} = $parameters['empty_value'];$set_index=0;}
               
                }
                
                if(empty($attr_search) && $row->level > 0){
                    $level_gen = str_pad('', $row->level*12, '&nbsp;').'|-';
                }
                
                if($attr_id =='value_path') {
                    $results[$set_index]['key'] = $row->{$attr_id}.' -';
                } else {
                    $results[$set_index]['key'] = $row->{$attr_id};
                }
                
                $results[$set_index]['value'] = $level_gen
                                          ._ch($row->{$parameters['attribute_value']});
                                          //.', '.$row->{$parameters['attribute_id']};
                                          
                $ind_order++;
            }
                            
                //echo $this->db->last_query();
            // get current value by ID
            $row=NULL;
            
            if($table == 'treefield_m' && $attr_id =='value_path')
                $parameters['curr_id'] = $this->$table->id_by_path($parameters['field_id'], $language_id, trim(trim($parameters['curr_id']),' -'));
            
            $start_id_db = $start_id;
            if(!is_numeric($start_id_db))
                $start_id_db = $this->$table->id_by_path($parameters['field_id'], $language_id, trim(trim($start_id),' -'));
            if(!empty($parameters['curr_id']))
                $row = $this->$table->get_lang($parameters['curr_id'], $language_id);
                
            if(is_object($row))
            {
                $level_gen = str_pad('', $row->level*12, '&nbsp;').'|-';
                
                $this->data['curr_val'] = $level_gen
                                          ._ch($row->{$parameters['attribute_value'].'_'.$language_id});
                                          //.', '.$row->{$parameters['attribute_id']};
                if(!empty($start_id_db) && $start_id_db == $parameters['curr_id'] && isset($parameters['sub_empty_value']) && !empty($parameters['sub_empty_value'])) $this->data['curr_val'] = _ch($parameters['sub_empty_value'], ' - ');
                elseif(!empty($start_id_db) && $start_id_db == $parameters['curr_id']) $this->data['curr_val'] = $parameters['empty_value'];
            } 
            elseif(isset($parameters['city'])) $this->data['curr_val'] = $parameters['sub_empty_value'];
            else
            {
                $this->data['curr_val'] = $parameters['empty_value'];
            }
            $ajax_output['curr_val'] = $this->data['curr_val'];
        
        }
        
        $ajax_output['results'] = $results;
        
        $json_output = json_encode($ajax_output);

        //$length = mb_strlen($json_output);
        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache');
        header('Content-Type: application/json; charset=utf8');
        //header('Content-Length: '.$length); // special characters causing troubles

        echo $json_output;
        
        exit();
    }
    
     public function treefieldidalt($output="", $atts=array(), $instance=NULL)
    {
        $language_id = $this->input->post('language_id', true);
        $this->load->model('language_m');
        $this->load->library('form_validation');

        if($language_id != NULL){
            $lang_name = $this->language_m->get_name($language_id);
            $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        }

        $ajax_output = array();
        $ajax_output['message'] = lang_check('No message returned!', 'sw_win');
        $results = array();
        
        $parameters = $_POST;
        
        $table = $this->input->post('table', true);
        $table_name = $table;
        
        if(empty($parameters['empty_value']))
            $parameters['empty_value'] = ' - ';
        
        if(empty($parameters['limit']))
            $parameters['limit'] = 10;
            
        if(empty($parameters['offset']))
            $parameters['offset'] = 0;
            
        if(empty($parameters['attribute_id']))
            $parameters['attribute_id'] = 'id';
            
        if(empty($parameters['attribute_value']))
            $parameters['attribute_value'] = 'address';
            
        if(empty($parameters['field_id']))
            $parameters['field_id'] = 1;
            
        if(empty($parameters['offset']))
            $parameters['offset'] = 0;
        
        $start_id = '';
        if(isset($parameters['start_id']))
            $start_id = $parameters['start_id'];
        
        if($parameters['offset'] == 0) // currently don't have load_more functionality'
        if(!empty($parameters['empty_value']))
        {
            $results[0]['key'] = '';
            $results[0]['value'] = $parameters['empty_value'];
        }
        $first_value = '';
        if(!empty($parameters['curr_id'])){
            $pos = strpos($parameters['curr_id'], " -");
            $first_value = substr($parameters['curr_id'],0,$pos+2);
            if(isset($parameters['level']) && $parameters['level'] == 1) {
            } else{
                $parameters['curr_id'] = $first_value;
            }
        }
        if(substr($table,-2, 2) == '_m')
        {
            // it's model
            $table_name = substr($table,0, -2);
            $attr_id = $parameters['attribute_id'];
            $attr_val = $parameters['attribute_value'];
            $attr_search = _ch($parameters['search_term'], '');
            $skip_id = $parameters['skip_id'];
            
            $id_part="";
            if(is_numeric($attr_search))
                $id_part = "$attr_id=$attr_search OR ";
        
            $this->load->model($table);
            
            $where = array();
            
            if(!empty($attr_search))
                $where["($id_part $attr_val LIKE '%$attr_search%')"] = NULL;
            
            //get_by($where, $single = FALSE, $limit = NULL, $order_by = NULL, $offset = NULL, 
            //$search = array(), $where_in = NULL, $check_user = FALSE, $fetch_user_details=FALSE)
            
            
            $q_results=array();
            if($table == 'treefield_m')
            {
                //if(!empty($skip_id))
                //    $where["( id$table_name != $skip_id )"] = NULL;
                
                //if(!empty($parameters['language_id']))
                //    $where["lang_id"] = $parameters['language_id'];
                    
                $table_name = 'sw_'.$table_name;
                    
                
//                $this->db->join($table_name.'_lang', $table_name.'.idtreefield = '.$table_name.'_lang.treefield_id');
//                $this->db->where('lang_id', current_language_id());
//                $this->db->where('field_id', $parameters['field_id']);
                
//                $q_results = $this->$table->get_by($where, FALSE, $parameters['limit'], 
//                                                    "$attr_id DESC", $parameters['offset'],
//                                                    array(), NULL, TRUE);
                
                //var_dump($q_results);

                //echo $this->db->last_query();
                //exit();
                
                
                if(!empty($parameters['filter_ids'])) {
                    $parameters['filter_ids'] = explode(',', $parameters['filter_ids']);
                    $str = '';
                    foreach ($parameters['filter_ids'] as $v) {
                        if(stripos($v, 'fetch_child') !== FALSE){
                            $pos = strpos($v, " -");
                            $v = substr($v,0,$pos);
                            $v = trim($v, ' -');
                            $v = $this->treefield_m->id_by_path($parameters['field_id'], $language_id, $v);
                            if(!empty($v)){
                                $childs = array();
                                $this->treefield_m->get_all_childs($v,$parameters['field_id'], $childs);
                                if(empty($str)) 
                                    $str.='(';
                                else
                                    $str.=' OR ';
                                $str .= ' parent_id = '.$v.' OR  treefield.id = '.$v.'';
                                
                                if($childs)foreach($childs  as $child ) {
                                    $str.=' OR ';
                                    $str .= ' parent_id = '.$child.' OR  treefield.id = '.$child.'';
                                }
                            }
                            continue;
                        }
                        $v = trim($v, ' -');
                        $v = $this->treefield_m->id_by_path($parameters['field_id'], $language_id, $v);
                        if($v){
                        if(empty($str)) 
                            $str.='(';
                        else
                            $str.=' OR ';
                        $str .= ' parent_id = '.$v.' OR  treefield.id = '.$v.'';
                        }
                    }
                    if(!empty($str)){
                    $str.=')';
                    $where[$str] = NULL;
                    }
                    unset($results[0]);
                }
                
                if(isset($parameters['level'])) {
                    
                    if($parameters['level'] == 1) {
                        $where['level !='] = 0;
                    } else {
                        $where['level'] = 0;
                    }
                }
                
                if($parameters['offset'] == 0){ // currently don't have load_more functionality'
                   if(!empty($attr_search))
                    $q_results = $this->$table->get_table_tree($language_id, $parameters['field_id'], $skip_id, true, '_lang.value', ', treefield_lang.value_path', $where);
                   else
                    $q_results = $this->$table->get_table_tree($language_id, $parameters['field_id'], $skip_id, true, '_lang.value', ', treefield_lang.value_path', $where);
                    //$q_results = $this->$table->get_treefield($language_id, $parameters['field_id'],  NULL, NULL, $where);
                }
                
                                
                if(isset($parameters['level']) && $parameters['level'] == 1 && empty($str)) {
                    $q_results =[];
                }
                
                //var_dump($q_results);

                //echo $this->db->last_query();
                //exit();
            }
            else
            {
                $q_results = $this->$table->get_by($where, FALSE, $parameters['limit'], 
                                                    "$attr_id DESC", $parameters['offset']);
            }
            $ind_order=1;
            foreach ($q_results as $key=>$row)
            {
                $set_index = $ind_order;
                
                
                $level_gen='';
                if(empty($attr_search) ){
                    $_set_attr_id = $attr_id;
                    
                    if(is_numeric($start_id))
                        $_set_attr_id = 'id';
                    
                    if(empty($row->{$attr_id})) continue;
                    if(!empty($start_id) && ($start_id == $row->{$_set_attr_id}.' -'  || $start_id == $row->{$_set_attr_id} ) && isset($parameters['sub_empty_value']) && !empty($parameters['sub_empty_value'])){$row->{$parameters['attribute_value']} = $parameters['sub_empty_value'];$set_index=0;}
                    elseif(!empty($start_id) && ($start_id == $row->{$_set_attr_id}.' -'  || $start_id == $row->{$_set_attr_id} )) {$row->{$parameters['attribute_value']} = $parameters['empty_value'];$set_index=0;}
               
                }
                
                if(empty($attr_search) && $row->level > 0){
                    $level_gen = str_pad('', $row->level*12, '&nbsp;').'|-';
                }
                
                if($attr_id =='value_path') {
                    $results[$set_index]['key'] = $row->{$attr_id}.' -';
                } else {
                    $results[$set_index]['key'] = $row->{$attr_id};
                }
                
                $results[$set_index]['value'] = $level_gen
                                          ._ch($row->{$parameters['attribute_value']});
                                          //.', '.$row->{$parameters['attribute_id']};
                                          
                $ind_order++;
            }
            
            
                            
                //echo $this->db->last_query();
            // get current value by ID
            $row=NULL;
            
            if($table == 'treefield_m' && $attr_id =='value_path')
                $parameters['curr_id'] = $this->$table->id_by_path($parameters['field_id'], $language_id, trim(trim($parameters['curr_id']),' -'));
            
            $start_id_db = $start_id;
            if(!is_numeric($start_id_db))
                $start_id_db = $this->$table->id_by_path($parameters['field_id'], $language_id, trim(trim($start_id),' -'));
            if(!empty($parameters['curr_id']))
                $row = $this->$table->get_lang($parameters['curr_id'], $language_id);
            $replace_def = true;
            if(substr_count($start_id, ' -')>1)
                $replace_def = false;
            
            if(is_object($row))
            {
                $level_gen = str_pad('', $row->level*12, '&nbsp;').'|-';
                
                $this->data['curr_val'] = $level_gen
                                          ._ch($row->{$parameters['attribute_value'].'_'.$language_id});
                                          //.', '.$row->{$parameters['attribute_id']};
                                          
                if($replace_def){               
                    if(!empty($start_id_db) && $start_id_db == $parameters['curr_id'] && isset($parameters['sub_empty_value']) && !empty($parameters['sub_empty_value'])) $this->data['curr_val'] = _ch($parameters['sub_empty_value'], ' - ');
                    elseif(!empty($start_id_db) && $start_id_db == $parameters['curr_id']) $this->data['curr_val'] = $parameters['empty_value'];
                }
            } 
            elseif(isset($parameters['city'])) $this->data['curr_val'] = $parameters['sub_empty_value'];
            else
            {
                $this->data['curr_val'] = $parameters['empty_value'];
            }
            $ajax_output['curr_val'] = $this->data['curr_val'];
        
        }
        
        if(isset($parameters['level']) && $parameters['level'] == 1 && $parameters['offset'] == 0) {
            $results[0] = [
                "key" => $first_value,
                "value" => $parameters['sub_empty_value']
            ];
        }
        //dump($results);
        //exit();
        $ajax_output['results'] = $results;
        
        $json_output = json_encode($ajax_output);

        //$length = mb_strlen($json_output);
        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache');
        header('Content-Type: application/json; charset=utf8');
        //header('Content-Length: '.$length); // special characters causing troubles

        echo $json_output;
        
        exit();
    }
    
    
    public function treefielddropdownid($output="", $atts=array(), $instance=NULL)
    {
        $language_id = $this->input->post('language_id', true);
        $this->load->model('language_m');
        $this->load->library('form_validation');

        if($language_id != NULL){
            $lang_name = $this->language_m->get_name($language_id);
            $this->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$this->settings['template'].'/');
        }

        $ajax_output = array();
        $ajax_output['message'] = lang_check('No message returned!');
        $ajax_output['next_parent_id'] = 0;
        $results = array();
        
        $parameters = $_POST;
        
        $table = $this->input->post('table', true);
        $table_name = $table;
        
        if(empty($parameters['empty_value']))
            $parameters['empty_value'] = ' - ';
        
        if(empty($parameters['limit']))
            $parameters['limit'] = 10;
            
        if(empty($parameters['offset']))
            $parameters['offset'] = 0;
            
        if(empty($parameters['attribute_id']))
            $parameters['attribute_id'] = 'id';
            
        if(empty($parameters['attribute_value']))
            $parameters['attribute_value'] = 'address';
            
        if(empty($parameters['field_id']))
            $parameters['field_id'] = 1;
            
        if($parameters['offset'] == 0) // currently don't have load_more functionality'
        if(!empty($parameters['empty_value']))
        {
            $results[0]['key'] = '';
            $results[0]['value'] = $parameters['empty_value'];
        }

        if(substr($table,-2, 2) == '_m')
        {
            // it's model
            $table_name = substr($table,0, -2);
            $attr_id = $parameters['attribute_id'];
            $attr_val = $parameters['attribute_value'];
            $attr_search = _ch($parameters['search_term']);
            $skip_id = _ch($parameters['skip_id'], '');
            
            $parent_id = $parameters['pare_id'];
            $current_id = $parameters['curr_id'];
            
            $id_part="";
            if(is_numeric($attr_search))
                $id_part = "$attr_id=$attr_search OR ";
        
            $this->load->model($table);
            
            $where = array();
            
            if(!empty($attr_search))
                $where["($id_part $attr_val LIKE '%$attr_search%')"] = NULL;
            
            //get_by($where, $single = FALSE, $limit = NULL, $order_by = NULL, $offset = NULL, 
            //$search = array(), $where_in = NULL, $check_user = FALSE, $fetch_user_details=FALSE)
            
            
            $q_results=array();
            if($table == 'treefield_m')
            {
                //if(!empty($skip_id))
                //    $where["( id$table_name != $skip_id )"] = NULL;
                
                //if(!empty($parameters['language_id']))
                //    $where["lang_id"] = $parameters['language_id'];
                    
                $table_name = 'sw_'.$table_name;
                    
                
//                $this->db->join($table_name.'_lang', $table_name.'.idtreefield = '.$table_name.'_lang.treefield_id');
//                $this->db->where('lang_id', current_language_id());
//                $this->db->where('field_id', $parameters['field_id']);
                
//                $q_results = $this->$table->get_by($where, FALSE, $parameters['limit'], 
//                                                    "$attr_id DESC", $parameters['offset'],
//                                                    array(), NULL, TRUE);
                
               
                
              /*  
                if($parameters['offset'] == 0) // currently don't have load_more functionality'
                    $q_results = $this->$table->get_table_tree($language_id, $parameters['field_id'], $skip_id, true, '_lang.value', ', treefield_lang.value_path', $where);
            */
                
            if(!empty($current_id))
            {
                $parent_id_temp = -1;
                $path_table = array();

                //if(!empty($parent_id))
                //    $current_id == $parent_id;
                $current_id_id = $this->$table->id_by_path($parameters['field_id'], $language_id, trim(trim($current_id),' -'));
                $element = $this->$table->get($current_id_id);
                if(!empty($element))
                {
                    $parent_id_temp = $element->parent_id;
                    $path_table[$element->parent_id] = $element->id;
                }

                while($parent_id_temp>0)
                {
                    $element = $this->$table->get($parent_id_temp);

                    if(empty($element))break;

                    $path_table[$element->parent_id] = $element->id;
                    $parent_id_temp = $element->parent_id;
                }

                /*
                array(2) {
                    [113] => string(2) "99"
                    [99] => string(1) "0"
                }
                */

                if(isset($path_table[$parent_id_temp]))
                    $ajax_output['next_parent_id'] = $path_table[$parent_id_temp];
            }
            
            $where = array();
            
            if(!empty($parent_id) || TRUE)
            {
                $where["parent_id"] = $parent_id;

                if($ajax_output['next_parent_id'] == $parent_id)$ajax_output['next_parent_id'] = 0;
            }
                
            
            //get_by($where, $single = FALSE, $limit = NULL, $order_by = NULL, $offset = NULL, 
            //$search = array(), $where_in = NULL, $check_user = FALSE, $fetch_user_details=FALSE)
            
            
            $q_results=array();
            
            $q_results = $this->$table->get_table_tree($language_id, $parameters['field_id'], $skip_id, true, '_lang.value', ', treefield_lang.value_path', $where);
           // $q_results = $this->$table->get_table_tree($language_id, $parameters['field_id'], $skip_id, false, NULL, '', $where);
                
                
               // var_dump($q_results);

                //echo $this->db->last_query();
                //exit();
            }
            else
            {
                $q_results = $this->$table->get_by($where, FALSE, $parameters['limit'], 
                                                    "$attr_id DESC", $parameters['offset']);
            }
        
            $ind_order=1;
            foreach ($q_results as $key=>$row)
            {
                $level_gen='';
                if(empty($attr_search) && $row->level > 0)
                    $level_gen = str_pad('', $row->level*12, '&nbsp;').'|-';
                
                if($attr_id =='value_path') {
                    $results[$ind_order]['key'] = $row->{$attr_id}.' -';
                } else {
                    $results[$ind_order]['key'] = $row->{$attr_id};
                }
                
                $results[$ind_order]['value'] = $level_gen
                                          ._ch($row->{$parameters['attribute_value']});
                                          //.', '.$row->{$parameters['attribute_id']};
                                          
                $ind_order++;
            }
            
            // get current value by ID
            $row=NULL;
            
            if($table == 'treefield_m' && $attr_id =='value_path')
                $parameters['curr_id'] = $this->$table->id_by_path($parameters['field_id'], $language_id, trim(trim($parameters['curr_id']),' -'));
            
            if(!empty($parameters['curr_id']))
                $row = $this->$table->get_lang($parameters['curr_id'], $language_id);
                
            if(is_object($row))
            {
                $level_gen = str_pad('', $row->level*12, '&nbsp;').'|-';
                
                $this->data['curr_val'] = $level_gen
                                          ._ch($row->{$parameters['attribute_value'].'_'.$language_id});
                                          //.', '.$row->{$parameters['attribute_id']};
                //$this->data['curr_val'] = "United States -";
            }
            else
            {
                $this->data['curr_val'] = $parameters['empty_value'];
            }
            
            $ajax_output['curr_val'] = $this->data['curr_val'];
            
            $this->data['success'] = true;
        
        }
        
        $ajax_output['results'] = $results;
        
        $json_output = json_encode($ajax_output);

        //$length = mb_strlen($json_output);
        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache');
        header('Content-Type: application/json; charset=utf8');
        //header('Content-Length: '.$length); // special characters causing troubles

        echo $json_output;
        
        exit();
    }

    
    public function get_coordinates($address='') {
        
        $ajax_output['success'] = true;
        $ajax_output['result'] = false;
        
        $ajax_output['api'] = false;
        if(config_db_item('map_version') != 'open_street')
            $ajax_output['api'] = 'google';
        else 
            $ajax_output['api'] = 'openstreet';
            
        $this->load->library('ghelper');
        
        $result = $this->ghelper->getCoordinates($address);
        
        if(empty($result['lat']))
            $ajax_output['success'] = false;
        
        $ajax_output['result'] = $result;
        
        echo json_encode($ajax_output);
        exit();
    }
    
    
    public function subscribe() {
        $ajax_output = array();
        
        $ajax_output['success'] = false;
        $ajax_output['message'] = '';
        
        $post = $_POST;
        
        $apiKey = config_db_item('mailchimp_api_key');
        $listId = config_db_item('mailchimp_list_id');
        
        if(empty($apiKey) && empty($listId)) {
            $ajax_output['message'] = lang_check('Subscribe API not configured, please contact with administrator'); 
        }
        else if( filter_var($post['subscriber_email'], FILTER_VALIDATE_EMAIL)) {
        
        $data = [
            'email'     => $post['subscriber_email'],
            'status'    => 'subscribed',
        ];
        

        $memberId = md5(strtolower($data['email']));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;
        
        $json = json_encode([
            'apikey' => $apiKey,
            'email_address' => $data['email'],
            'status'        => $data['status'], // "subscribed","unsubscribed","cleaned","pending"
        ]);

        $httpCode=0;
        $result = $this->mailchimp_post($url, $apiKey, $httpCode, $json);
        if($httpCode == 200) {
            $ajax_output['success'] = true;
            $ajax_output['message'] = lang_check('Your e-mail').' '. $post['subscriber_email'] .' '.lang_check(' has been added to our mailing list!'); 
        } else {
            $ajax_output['message'] = lang_check('There was a problem with your e-mail').' '.$post['subscriber_email']; 
        }
        
        } else {
           $ajax_output['message'] = lang_check('There was a problem with your e-mail').' '.$post['subscriber_email']; 
        }
        
        echo json_encode($ajax_output);
        exit();
    }
    
    private function mailchimp_post($url, $apiKey, &$httpCode, $json)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $result;
    }

    public function claim($lang_code = 'en')
    {
        $this->load->model('claim_m');
	$this->load->library('session');
        $this->load->model('user_m');
        $this->load->model('language_m');
        $this->load->library('form_validation');
        
        $ajax_output = array();
    
        $ajax_output['success'] = false;
        $ajax_output['message'] = '';
        $redirect = '';
        $error = '';
        
        $post = $_POST;
        
        
        /* [CAPTCHA Helper] */
        if(config_item('recaptcha_site_key') !== FALSE)
        {
            $this->config->set_item('captcha_disabled', TRUE);
        }
        
        if(config_item('captcha_disabled') === FALSE)
        {
            $this->load->helper('captcha');
            $captcha_hash = substr(md5(rand(0, 999).time()), 0, 5);
            $captcha_hash_old = $this->session->userdata('captcha_hash');
            if(isset($_POST['captcha_hash']))
                $captcha_hash_old = $_POST['captcha_hash'];
            
            $this->data['captcha_hash_old'] = $captcha_hash_old;
            $this->session->set_userdata('captcha_hash', $captcha_hash);

            $vals = array(
                'word' => substr(md5($captcha_hash.config_item('encryption_key')), 0, 5),
                'img_path' => FCPATH.'files/captcha/',
                'img_url' => base_url('files/captcha').'/',
                'font_path' => FCPATH.'admin-assets/font/verdana.ttf',
                'img_width' => 120,
                'img_height' => 35,
                'expiration' => 7200
                );

            $this->data['captcha'] = create_captcha($vals);
            $this->data['captcha_hash'] = $captcha_hash;
        }
        /* [/CAPTCHA Helper] */
        
        //Validation
        $rules = $this->claim_m->rules_agent;

        if($this->config->item('captcha_disabled') === FALSE)
            $rules['captcha'] = array('field'=>'captcha', 'label'=>'lang:Captcha', 
                                      'rules'=>'trim|required|callback_captcha_check|xss_clean');

        if($this->config->item('recaptcha_site_key') !== FALSE)
            $rules['g-recaptcha-response'] = array('field'=>'g-recaptcha-response', 'label'=>'lang:Recaptcha', 
                                                    'rules'=>'trim|required|callback_captcha_check|xss_clean');
        
        $this->form_validation->set_rules($rules);
        
        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            $data = $this->claim_m->array_from_post(array('model', 'model_id', 'name', 'surname','repository_id',
                                                         'phone', 'email', 'message', 'allow_contact', 'date_submit'));
            
            // Save to database
            $data['date_submit'] = date('Y-m-d H:i:s');
            
            if(!$data['repository_id'])
                unset($data['repository_id']);
                
            $this->claim_m->save($data);
            // Save to session
            $this->load->library('session');
            $data_sess = $data;
            $data_sess['claim'] = $this->session->userdata('claim');
            $data_sess['claim'][] = $data_sess['model'].'_'.$data_sess['model_id'];
            $this->session->set_userdata($data_sess);
            
            // Send mail
            if(!empty($this->data['settings_email']))
            {
                // Send email to agent/user
                $this->load->library('email');
                $config_mail['mailtype'] = 'html';
                $this->email->initialize($config_mail);
                
                $this->email->from($this->data['settings_noreply'], lang_check('Web page'));
                $this->email->to($this->data['settings_email']);
                
                $this->email->subject(lang_check('Claim from real-estate web'));
                
                if(isset($data['repository_id'])) {
                    $file_rep = $this->file_m->get_by(array('repository_id'=>$data['repository_id']));
                    if(sw_count($file_rep)) {
                        foreach($file_rep as $k => $file_r)
                        {
                            $data['attached_file_'.($k+1)]= '<a href="'.base_url('files/'.$file_r->filename).'">'.base_url('files/'.$file_r->filename).'</a>';
                        }
                    }
                    unset($data['repository_id']);
                }
                 
                $message = $this->load->view('email/report_submission', array('data'=>$data), TRUE);
                
                $this->email->message($message);
                if ( ! $this->email->send())
                {
                    $this->session->set_flashdata('email_sent', 'email_sent_false');
                    $ajax_output['message'] = lang_check('Problem with mail send');
                    //echo 'problem sending email';
                }
                else
                {
                    $this->session->set_flashdata('email_sent', 'email_sent_true');
                    //echo 'successfully';
                }
            }
            if(empty($this->data['message']))
                $ajax_output['message'] = lang_check('Thanks, your claim sent');
            
            $ajax_output['success'] = true;
        }
        else
        {
            $error .= validation_errors();
        }
    
        $ajax_output['redirect'] = $redirect;
        $ajax_output['errors'] = $error;    
        echo json_encode($ajax_output);
        exit();

        exit();
    }
    
    
}


