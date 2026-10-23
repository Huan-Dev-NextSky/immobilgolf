<?php

class Registration_license_m extends MY_Model {

    protected $_table_name = 'registration_license';
    protected $_order_by = 'id ASC';

    public $rules_admin = array(
        'license_name' => array('field'=>'license_name', 'label'=>'lang:License name', 'rules'=>'trim|required|xss_clean'),
        'duration_months' => array('field'=>'duration_months', 'label'=>'lang:Duration months', 'rules'=>'trim|required|is_natural_no_zero|callback__check_unique_duration'),
        'price' => array('field'=>'price', 'label'=>'lang:Price', 'rules'=>'trim|required|numeric|xss_clean'),
        'currency_code' => array('field'=>'currency_code', 'label'=>'lang:Currency code', 'rules'=>'trim|required|xss_clean'),
        'active' => array('field'=>'active', 'label'=>'lang:Active', 'rules'=>'trim'),
    );

    public function __construct()
    {
        parent::__construct();
        $this->ensure_table();
    }

    public function ensure_table()
    {
        $this->load->dbforge();

        if (!$this->db->table_exists($this->_table_name))
        {
            $this->dbforge->add_field(array(
                'id' => array('type'=>'INT', 'constraint'=>11, 'unsigned'=>TRUE, 'auto_increment'=>TRUE),
                'license_name' => array('type'=>'VARCHAR', 'constraint'=>200, 'null'=>FALSE),
                'duration_months' => array('type'=>'INT', 'constraint'=>11, 'null'=>FALSE, 'default'=>1),
                'price' => array('type'=>'DECIMAL', 'constraint'=>'10,2', 'null'=>FALSE, 'default'=>'0.00'),
                'currency_code' => array('type'=>'VARCHAR', 'constraint'=>10, 'null'=>FALSE, 'default'=>'EUR'),
                'active' => array('type'=>'TINYINT', 'constraint'=>1, 'null'=>FALSE, 'default'=>1),
                'date_created' => array('type'=>'DATETIME', 'null'=>TRUE),
                'date_modified' => array('type'=>'DATETIME', 'null'=>TRUE),
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($this->_table_name, TRUE);
            return;
        }

        if (!$this->db->field_exists('duration_months', $this->_table_name))
        {
            $this->dbforge->add_column($this->_table_name, array(
                'duration_months' => array('type'=>'INT', 'constraint'=>11, 'null'=>FALSE, 'default'=>1),
            ));
        }

        if (!$this->db->field_exists('price', $this->_table_name))
        {
            $this->dbforge->add_column($this->_table_name, array(
                'price' => array('type'=>'DECIMAL', 'constraint'=>'10,2', 'null'=>FALSE, 'default'=>'0.00'),
            ));
        }

        if (!$this->db->field_exists('currency_code', $this->_table_name))
        {
            $this->dbforge->add_column($this->_table_name, array(
                'currency_code' => array('type'=>'VARCHAR', 'constraint'=>10, 'null'=>FALSE, 'default'=>'EUR'),
            ));
        }
    }

    public function get_new()
    {
        $item = new stdClass();
        $item->license_name = '';
        $item->duration_months = '';
        $item->price = '0.00';
        $item->currency_code = 'EUR';
        $item->active = 1;
        $item->date_created = '';
        $item->date_modified = '';
        return $item;
    }
}
