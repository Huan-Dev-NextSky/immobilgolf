<?php

class Custom_Form_m extends MY_Model {
    
    protected $_table_name = 'custom_form';
    protected $_order_by = 'id ASC';
    
    public $rules = array(
        'first_name' => array('field'=>'first_name', 'label'=>'lang:First Name', 'rules'=>'trim|required|xss_clean'),
        'last_name' => array('field'=>'last_name', 'label'=>'lang:Last Name', 'rules'=>'trim|required|xss_clean'),
        'phone' => array('field'=>'phone', 'label'=>'lang:Phone', 'rules'=>'trim|required|xss_clean'),
        'email' => array('field'=>'email', 'label'=>'lang:Email', 'rules'=>'trim|required|valid_email|xss_clean'),
        'message' => array('field'=>'message', 'label'=>'lang:Message', 'rules'=>'trim'),
        'town' => array('field'=>'town', 'label'=>'lang:Town', 'rules'=>'trim'),
        'address' => array('field'=>'address', 'label'=>'lang:Address', 'rules'=>'trim|required|xss_clean'),
        'year' => array('field'=>'year', 'label'=>'lang:Year', 'rules'=>'trim|required|xss_clean'),
        'category' => array('field'=>'category', 'label'=>'lang:Category', 'rules'=>'trim|required|xss_clean'),

        'date_submit' => array('field'=>'date_submit', 'label'=>'lang:Date Submited', 'rules'=>'trim|xss_clean'),
        'repository_id' => array('field'=>'repository_id', 'label'=>'lang:Repository id', 'rules'=>'trim'),
        'is_readed' => array('field'=>'is_readed', 'label'=>'lang:Readed', 'rules'=>'trim'),
    );

        
    public $rules_settings = array(
        'custom_form_categories_list' => array('field'=>'custom_form_categories_list', 'label'=>'lang:Categories List', 'rules'=>'trim'),
        'custom_form_towns_list' => array('field'=>'custom_form_towns_list', 'label'=>'lang:Towns List', 'rules'=>'trim'),
    );
    
    public $packages_array = array();

    public function __construct(){
        parent::__construct();
    }
    
    public function get_new()
    {
        $item = new stdClass();
        $item->first_name = '';
        $item->last_name = '';
        $item->phone = '';
        $item->email = '';
        $item->message = '';
        $item->phone = '';
        $item->town = '';
        $item->address = '';
        $item->year = '';
        $item->category = '';
        $item->date_submit = '';
        $item->repository_id = '';
        $item->is_readed = '';
        return $item;
    }
    
    public function get($id = NULL, $single = false)
    {
        return parent::get($id,$single);
    }
    
    /* delete all */
    public function delete_all () {
        $this->db->empty_table($this->_table_name);
    }
    

     
    public function get_new_settings()
	{
        $setting = new stdClass();
        $setting->field = '';
        $setting->value = '';
        
        return $setting;
	}
    
    public function get_fields_settings()
    {
        if(($fields_data = $this->cache_temp_load('fields_data_settings')) === FALSE)
        {
            $query = $this->db->get('settings');
    
            $fields_data = array();
            
            if(is_object($query))
            foreach($query->result() as $key=>$setting)
            {
                $fields_data[$setting->field] = $setting->value;
            }
            
            $this->cache_temp_save($fields_data, 'fields_data_settings');
        }

        return $fields_data;
    }
    
    public function get_field_settings($field_name)
    {
        $fields = $this->get_fields_settings();
        
        if(isset($fields[$field_name]))
            return $fields[$field_name];
            
        return NULL;
    }
    
    public function save_settings($post_data)
    {
        $this->delete_fields_settings($post_data);
        
        $data = array();
        foreach($post_data as $key=>$value)
        {
            $data[] = array(
               'field' => $key,
               'value' => $value
            );
        }
      
        $this->db->insert_batch('settings', $data); 
    }
    
    public function delete_fields_settings($fields = array())
    {
        $this->db->where_in('field', array_keys($fields));
        $this->db->delete('settings');
    }
}



