<?php

class Registration_free_date_m extends MY_Model {

    protected $_table_name = 'settings';
    protected $_order_by = 'id ASC';

    const FIELD_START = 'registration_free_date_start';
    const FIELD_END = 'registration_free_date_end';
    const FIELD_MONTHS = 'registration_free_months';
    const FIELD_ACTIVE = 'registration_free_date_active';

    public $rules = array(
        'date_start' => array('field'=>'date_start', 'label'=>'lang:Date Start', 'rules'=>'trim|required|xss_clean'),
        'date_end' => array('field'=>'date_end', 'label'=>'lang:Date End', 'rules'=>'trim|required|xss_clean|callback__check_date'),
        'free_months' => array('field'=>'free_months', 'label'=>'lang:Free months', 'rules'=>'trim|required|is_natural_no_zero'),
        'active' => array('field'=>'active', 'label'=>'lang:Active', 'rules'=>'trim'),
    );

    public function __construct()
    {
        parent::__construct();
    }

    public function get_new()
    {
        $item = new stdClass();
        $item->date_start = date('Y-m-d');
        $item->date_end = date('Y-m-d', strtotime('+1 month'));
        $item->free_months = 1;
        $item->active = 0;
        return $item;
    }

    /**
     * Single global setting (stored in settings table — no extra DB table).
     */
    public function get_settings()
    {
        $CI =& get_instance();
        $CI->load->model('settings_m');
        $fields = $CI->settings_m->get_fields();

        $item = $this->get_new();
        if (isset($fields[self::FIELD_START]) && $fields[self::FIELD_START] !== '')
            $item->date_start = $fields[self::FIELD_START];
        if (isset($fields[self::FIELD_END]) && $fields[self::FIELD_END] !== '')
            $item->date_end = $fields[self::FIELD_END];
        if (isset($fields[self::FIELD_MONTHS]) && $fields[self::FIELD_MONTHS] !== '')
            $item->free_months = (int) $fields[self::FIELD_MONTHS];
        if (isset($fields[self::FIELD_ACTIVE]))
            $item->active = (int) $fields[self::FIELD_ACTIVE];

        return $item;
    }

    public function save_settings($data)
    {
        $CI =& get_instance();
        $CI->load->model('settings_m');

        $payload = array(
            self::FIELD_START => isset($data['date_start']) ? $data['date_start'] : '',
            self::FIELD_END => isset($data['date_end']) ? $data['date_end'] : '',
            self::FIELD_MONTHS => isset($data['free_months']) ? (string) ((int) $data['free_months']) : '1',
            self::FIELD_ACTIVE => !empty($data['active']) ? '1' : '0',
        );

        $CI->settings_m->save_settings($payload);
    }

    /**
     * Active free-registration campaign for today, or FALSE.
     */
    public function get_active()
    {
        $settings = $this->get_settings();
        if (!$this->is_valid($settings))
            return FALSE;

        return $settings;
    }

    public function is_valid($settings, &$reason = NULL)
    {
        $reason = '';

        if (empty($settings))
        {
            $reason = 'not_found';
            return FALSE;
        }

        if ((int) $settings->active !== 1)
        {
            $reason = 'inactive';
            return FALSE;
        }

        if ((int) $settings->free_months <= 0)
        {
            $reason = 'invalid_months';
            return FALSE;
        }

        $now = time();
        $start_ts = $this->_day_start($settings->date_start);
        $end_ts = $this->_day_end($settings->date_end);

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

    private function _day_start($value)
    {
        if ($value === NULL || $value === '')
            return FALSE;

        $day = substr(trim((string) $value), 0, 10);
        $ts = strtotime($day.' 00:00:00');
        return $ts === FALSE ? FALSE : $ts;
    }

    private function _day_end($value)
    {
        if ($value === NULL || $value === '')
            return FALSE;

        $day = substr(trim((string) $value), 0, 10);
        $ts = strtotime($day.' 23:59:59');
        return $ts === FALSE ? FALSE : $ts;
    }
}
