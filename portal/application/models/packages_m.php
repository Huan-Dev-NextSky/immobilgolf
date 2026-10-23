<?php

class Packages_m extends MY_Model {
    
    protected $_table_name = 'packages';
    protected $_order_by = 'id';

    public $rules_admin = array(
        'package_name' => array('field'=>'package_name', 'label'=>'lang:Package name', 'rules'=>'trim|required'),
        'package_price' => array('field'=>'package_price', 'label'=>'lang:Package price lifetime', 'rules'=>'trim|required|numeric|xss_clean'),
        'currency_code' => array('field'=>"currency_code", 'label'=>'lang:Currency code', 'rules'=>'trim|required|xss_clean'),
        'type_property' => array('field'=>"type_property", 'label'=>'lang:Type property', 'rules'=>'trim|xss_clean'),
        'package_price_1_month' => array('field'=>"package_price_1_month", 'label'=>'lang:Package price 1 month', 'rules'=>'trim|numeric|xss_clean'),
        'package_price_3_month' => array('field'=>"package_price_3_month", 'label'=>'lang:Package price 3 month', 'rules'=>'trim|numeric|xss_clean'),
        'package_price_6_month' => array('field'=>"package_price_6_month", 'label'=>'lang:Package price 6 month', 'rules'=>'trim|numeric|xss_clean'),
        'package_price_12_month' => array('field'=>"package_price_12_month", 'label'=>'lang:Package price 12 month', 'rules'=>'trim|numeric|xss_clean')
    );
    
    public $rules_lang = array();
   
	public function __construct(){
		parent::__construct();
	}

    public function get_new()
	{
        $item = new stdClass();
        $item->date_created = date('Y-m-d H:i:s');
        $item->date_modified = NULL;
        $item->package_name = '';
        $item->num_listing_limit = 0;
        $item->package_price = '0.00';
        $item->package_days = 0;
        $item->currency_code = 'NULL';
        $item->show_private_listings = 1;
        $item->user_type = '';
        $item->auto_activation = 0;
        $item->num_images_limit = 1000;
        $item->num_amenities_limit = 1000;
        $item->num_featured_limit = 0;
        
        return $item;
	}
    
    public function get_curr_listings($where = NULL)
    {
        $listings_count = array();
        
        $this->db->select('user_id, COUNT(*) as properties_count');
        
        if($where != NULL)$this->db->where($where);
        
        $this->db->group_by(array('user_id'));

        $query = $this->db->get('property_user');
        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row)
           {
                $listings_count[$row->user_id] = $row->properties_count;
           }
        } 
        
        return $listings_count;
    }
    
    public function get_user_package($user_id = NULL)
    {
        if($user_id === NULL)
        {
            // Check if user is logged
            $user_id = $this->session->userdata('id');
        }
        if(empty($user_id))return NULL;
        
        // Fetch user data
        $this->load->model('user_m');
        $user = $this->user_m->get($user_id);
        if(empty($user->package_id)) return NULL;
        
        $package = $this->get($user->package_id);
        if(empty($package)) return NULL;
        
        if($package->package_days > 0 && strtotime($user->package_last_payment)<=time())
            return NULL;
        
        return $package;
    }
    
    public function get_available_featured($user_id = NULL, $exception_property_id = NULL)
    {
        if($user_id === NULL)
        {
            // Check if user is logged
            $user_id = $this->session->userdata('id');
        }
        if(empty($user_id))return 0;
        
        // Fetch user package and check if is active
        $user_package = $this->get_user_package($user_id);
        if(empty($user_package))return 0;

        // Get current featured listings
        $this->db->select('property.*');
        $this->db->from('property_user');
        $this->db->join('property', 'property_user.property_id = property.id', 'left');
        $this->db->where(array('property.is_featured'=>1, 'property_user.user_id'=>$user_id));
        
        if($exception_property_id !== NULL)
        {
            $this->db->where('property.id !=', $exception_property_id);
        }
        
        $query = $this->db->get();
        $num_available = $query->num_rows();

        if (is_int($num_available))
        {
           return ($user_package->num_featured_limit - $num_available);
        }
        
        return 0;
    }
    
    public function delete($id)
    {      
        parent::delete($id);
    }

}


