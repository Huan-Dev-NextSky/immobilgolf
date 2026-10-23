<?php

class Registration_coupon_m extends MY_Model {

    protected $_table_name = 'registration_coupon';
    protected $_order_by = 'id ASC';

    public $discount_types = array();

    public $rules = array(
        'code_name' => array('field'=>'code_name', 'label'=>'lang:Code Name', 'rules'=>'trim|required|xss_clean'),
        'coupon_code' => array('field'=>'coupon_code', 'label'=>'lang:Coupon code', 'rules'=>'trim|required|xss_clean|callback__check_unique_code'),
        'discount_type' => array('field'=>'discount_type', 'label'=>'lang:Discount type', 'rules'=>'trim|required|xss_clean'),
        'discount_value' => array('field'=>'discount_value', 'label'=>'lang:Discount value', 'rules'=>'trim|required|numeric|greater_than[0]|callback__check_discount_value'),
        'quantity' => array('field'=>'quantity', 'label'=>'lang:Quantity', 'rules'=>'trim|required|numeric'),
        'date_start' => array('field'=>'date_start', 'label'=>'lang:Date Start', 'rules'=>'trim|required|xss_clean'),
        'date_end' => array('field'=>'date_end', 'label'=>'lang:Date End', 'rules'=>'trim|required|xss_clean|callback__check_date'),
        'active' => array('field'=>'active', 'label'=>'lang:Active', 'rules'=>'trim'),
    );

    public function __construct()
    {
        parent::__construct();

        $this->discount_types = array(
            'percent' => lang_check('Percent %'),
            'fixed' => lang_check('Fixed price'),
        );

        $this->ensure_table();
    }

    public function ensure_table()
    {
        $this->load->dbforge();

        if (!$this->db->table_exists($this->_table_name))
        {
            $this->dbforge->add_field(array(
                'id' => array('type'=>'INT', 'constraint'=>11, 'unsigned'=>TRUE, 'auto_increment'=>TRUE),
                'code_name' => array('type'=>'VARCHAR', 'constraint'=>200, 'null'=>FALSE),
                'coupon_code' => array('type'=>'VARCHAR', 'constraint'=>100, 'null'=>FALSE),
                'discount_type' => array('type'=>'VARCHAR', 'constraint'=>20, 'null'=>FALSE, 'default'=>'percent'),
                'discount_value' => array('type'=>'DECIMAL', 'constraint'=>'10,2', 'null'=>FALSE, 'default'=>'0.00'),
                'quantity' => array('type'=>'INT', 'constraint'=>11, 'null'=>FALSE, 'default'=>0),
                'used' => array('type'=>'INT', 'constraint'=>11, 'null'=>FALSE, 'default'=>0),
                'date_start' => array('type'=>'DATETIME', 'null'=>TRUE),
                'date_end' => array('type'=>'DATETIME', 'null'=>TRUE),
                'active' => array('type'=>'TINYINT', 'constraint'=>1, 'null'=>FALSE, 'default'=>1),
                'date_created' => array('type'=>'DATETIME', 'null'=>TRUE),
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($this->_table_name, TRUE);
            return;
        }

        if (!$this->db->field_exists('discount_type', $this->_table_name))
        {
            $this->dbforge->add_column($this->_table_name, array(
                'discount_type' => array('type'=>'VARCHAR', 'constraint'=>20, 'null'=>FALSE, 'default'=>'percent'),
            ));
        }

        if (!$this->db->field_exists('discount_value', $this->_table_name))
        {
            $this->dbforge->add_column($this->_table_name, array(
                'discount_value' => array('type'=>'DECIMAL', 'constraint'=>'10,2', 'null'=>FALSE, 'default'=>'0.00'),
            ));
        }
    }

    public function get_new()
    {
        $item = new stdClass();
        $item->code_name = '';
        $item->coupon_code = '';
        $item->discount_type = 'percent';
        $item->discount_value = '';
        $item->quantity = 1;
        $item->used = 0;
        $item->date_start = date('Y-m-d');
        $item->date_end = date('Y-m-d', strtotime('+1 year'));
        $item->active = 1;
        $item->date_created = '';
        return $item;
    }

    public function format_discount($coupon)
    {
        $type = isset($coupon->discount_type) ? $coupon->discount_type : 'percent';
        $value = isset($coupon->discount_value) ? $coupon->discount_value : 0;

        if ($type === 'fixed')
            return number_format((float) $value, 2, '.', '').' '.lang_check('fixed');

        return rtrim(rtrim(number_format((float) $value, 2, '.', ''), '0'), '.').'%';
    }

    public function get_by_code($code = '')
    {
        $code = trim((string) $code);
        if ($code === '')
            return FALSE;

        $this->db->where('LOWER(coupon_code)', strtolower($code));
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() > 0)
            return $query->row();

        return FALSE;
    }

    public function is_valid($coupon, &$reason = NULL)
    {
        $reason = '';

        if (empty($coupon))
        {
            $reason = 'not_found';
            return FALSE;
        }

        if ((int) $coupon->active !== 1)
        {
            $reason = 'inactive';
            return FALSE;
        }

        if ((int) $coupon->quantity <= 0 || (int) $coupon->used >= (int) $coupon->quantity)
        {
            $reason = 'exhausted';
            return FALSE;
        }

        $now = time();
        $start_ts = $this->_coupon_day_start($coupon->date_start);
        $end_ts = $this->_coupon_day_end($coupon->date_end);

        if ($start_ts !== FALSE && $now < $start_ts)
        {
            $reason = 'not_started';
            return FALSE;
        }

        if ($end_ts !== FALSE && $now > $end_ts)
        {
            $reason = 'expired';
            return FALSE;
        }

        return TRUE;
    }

    private function _coupon_day_start($value)
    {
        if ($value === NULL || $value === '')
            return FALSE;

        $day = substr(trim((string) $value), 0, 10);
        $ts = strtotime($day.' 00:00:00');
        return $ts === FALSE ? FALSE : $ts;
    }

    private function _coupon_day_end($value)
    {
        if ($value === NULL || $value === '')
            return FALSE;

        $day = substr(trim((string) $value), 0, 10);
        $ts = strtotime($day.' 23:59:59');
        return $ts === FALSE ? FALSE : $ts;
    }

    public function increment_used($id)
    {
        $this->db->set('used', 'used+1', FALSE);
        $this->db->where('id', $id);
        $this->db->update($this->_table_name);
    }
}
