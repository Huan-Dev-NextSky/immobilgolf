<?php

class Registration_pending_m extends MY_Model {

    protected $_table_name = 'registration_pending';
    protected $_order_by = 'id DESC';

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
                'token' => array('type'=>'VARCHAR', 'constraint'=>64, 'null'=>FALSE),
                'payload' => array('type'=>'TEXT', 'null'=>FALSE),
                'license_id' => array('type'=>'INT', 'constraint'=>11, 'null'=>TRUE, 'default'=>0),
                'paid' => array('type'=>'TINYINT', 'constraint'=>1, 'null'=>FALSE, 'default'=>0),
                'payment_invoice' => array('type'=>'VARCHAR', 'constraint'=>255, 'null'=>TRUE),
                'user_id' => array('type'=>'INT', 'constraint'=>11, 'null'=>TRUE, 'default'=>0),
                'claimed' => array('type'=>'TINYINT', 'constraint'=>1, 'null'=>FALSE, 'default'=>0),
                'date_created' => array('type'=>'DATETIME', 'null'=>TRUE),
                'date_paid' => array('type'=>'DATETIME', 'null'=>TRUE),
                'date_claimed' => array('type'=>'DATETIME', 'null'=>TRUE),
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('token');
            $this->dbforge->create_table($this->_table_name, TRUE);
            return;
        }

        if (!$this->db->field_exists('claimed', $this->_table_name))
        {
            $this->dbforge->add_column($this->_table_name, array(
                'claimed' => array('type'=>'TINYINT', 'constraint'=>1, 'null'=>FALSE, 'default'=>0),
            ));
        }

        if (!$this->db->field_exists('date_claimed', $this->_table_name))
        {
            $this->dbforge->add_column($this->_table_name, array(
                'date_claimed' => array('type'=>'DATETIME', 'null'=>TRUE),
            ));
        }
    }

    public function create_pending($payload)
    {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $data = array(
            'token' => $token,
            'payload' => is_string($payload) ? $payload : json_encode($payload),
            'license_id' => 0,
            'paid' => 0,
            'date_created' => date('Y-m-d H:i:s'),
        );
        $this->save($data);
        return $token;
    }

    public function create_renew_pending($user)
    {
        if (!is_object($user) || empty($user->id))
            return FALSE;

        $parts = preg_split('/\s+/', trim((string) $user->name_surname), 2);
        $payload = array(
            'mode' => 'renew',
            'user_id' => (int) $user->id,
            'email' => $user->mail,
            'name' => isset($parts[0]) ? $parts[0] : '',
            'surname' => isset($parts[1]) ? $parts[1] : '',
            'phone' => isset($user->phone) ? $user->phone : '',
        );

        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $data = array(
            'token' => $token,
            'payload' => json_encode($payload),
            'license_id' => 0,
            'paid' => 0,
            'user_id' => (int) $user->id,
            'date_created' => date('Y-m-d H:i:s'),
        );
        $this->save($data);
        return $token;
    }

    public function get_by_token($token)
    {
        if ($token === '')
            return FALSE;

        $this->db->where('token', $token);
        $this->db->limit(1);
        $query = $this->db->get($this->_table_name);
        if ($query->num_rows() > 0)
            return $query->row();

        return FALSE;
    }

    public function finalize_paid($pending, $license, $invoice_num)
    {
        $CI =& get_instance();
        $CI->load->model('registration_coupon_m');
        $CI->load->model('user_m');

        if (!empty($pending->paid) && !empty($pending->user_id))
            return (int) $pending->user_id;

        $payload = json_decode($pending->payload, TRUE);
        if (!is_array($payload))
            return FALSE;

        // Renew existing VISITOR license
        if (!empty($payload['mode']) && $payload['mode'] === 'renew')
        {
            $user_id = !empty($payload['user_id']) ? (int) $payload['user_id'] : (int) $pending->user_id;
            $user = $user_id ? $CI->user_m->get($user_id) : FALSE;
            if (!is_object($user))
                return FALSE;

            $months = is_object($license) ? (int) $license->duration_months : 0;
            // Honor free months only when this payment was an explicit free-date promo.
            if (!empty($payload['free_date_promo']) && !empty($payload['free_months']))
                $months = (int) $payload['free_months'];
            $from_time = time();
            if (!empty($user->package_last_payment) && strtotime($user->package_last_payment) > $from_time)
                $from_time = strtotime($user->package_last_payment);

            $package_last_payment = NULL;
            if ($months > 0)
                $package_last_payment = date('Y-m-d H:i:s', $from_time + 86400 * 30 * $months);

            $CI->user_m->save(array(
                'package_last_payment' => $package_last_payment,
                'activated' => '1',
            ), $user_id);

            // Do not burn coupons on free-date promo completions.
            if (!empty($payload['coupon']) && empty($payload['free_date_promo']))
            {
                $coupon = $CI->registration_coupon_m->get_by_code($payload['coupon']);
                if ($coupon && $CI->registration_coupon_m->is_valid($coupon))
                    $CI->registration_coupon_m->increment_used($coupon->id);
            }

            $this->save(array(
                'paid' => 1,
                'date_paid' => date('Y-m-d H:i:s'),
                'payment_invoice' => $invoice_num,
                'user_id' => $user_id,
                'license_id' => is_object($license) ? (int) $license->id : (int) $pending->license_id,
            ), $pending->id);

            return $user_id;
        }

        if (empty($payload['email']) || empty($payload['password_hash']))
            return FALSE;

        // Fail closed: never attach payment / claim to an unrelated existing account.
        if ($CI->user_m->if_exists($payload['email']))
            return FALSE;

        $username_base = preg_replace('/[^a-zA-Z0-9_\.\-]/', '', current(explode('@', $payload['email'])));
        if ($username_base === '')
            $username_base = 'user';
        $username = $username_base;
        $i = 1;
        while ($CI->user_m->if_exists($username))
        {
            $username = $username_base.$i;
            $i++;
        }

        $months = is_object($license) ? (int) $license->duration_months : 0;
        if (!empty($payload['free_date_promo']) && !empty($payload['free_months']))
            $months = (int) $payload['free_months'];
        $package_last_payment = NULL;
        if ($months > 0)
            $package_last_payment = date('Y-m-d H:i:s', time() + 86400 * 30 * $months);

        $data = array(
            'username' => $username,
            'password' => $payload['password_hash'],
            'mail' => $payload['email'],
            'name_surname' => trim($payload['name'].' '.$payload['surname']),
            'phone' => isset($payload['phone']) ? $payload['phone'] : '',
            'type' => 'VISITOR',
            'activated' => '1',
            'description' => '',
            'registration_date' => date('Y-m-d H:i:s'),
            'mail_verified' => 0,
            'phone_verified' => 0,
            'address' => isset($payload['address']) ? trim((string) $payload['address']) : '',
            'city' => isset($payload['city']) ? trim((string) $payload['city']) : '',
            'zip_city' => isset($payload['postal_code']) ? trim((string) $payload['postal_code']) : '',
            'codice_fiscale' => isset($payload['codice_fiscale']) ? strtoupper(trim((string) $payload['codice_fiscale'])) : '',
            'package_last_payment' => $package_last_payment,
            'reg_tipo' => isset($payload['tipo']) ? trim((string) $payload['tipo']) : '',
            'reg_provincia' => isset($payload['provincia']) ? trim((string) $payload['provincia']) : '',
            'reg_club' => isset($payload['club']) ? trim((string) $payload['club']) : '',
            'custom_fields' => $this->_build_registration_custom_fields($payload),
        );

        $user_id = $CI->user_m->save($data, NULL);
        if (empty($user_id))
            return FALSE;

        if (!empty($payload['coupon']) && empty($payload['free_date_promo']))
        {
            $coupon = $CI->registration_coupon_m->get_by_code($payload['coupon']);
            if ($coupon && $CI->registration_coupon_m->is_valid($coupon))
                $CI->registration_coupon_m->increment_used($coupon->id);
        }

        $this->save(array(
            'paid' => 1,
            'date_paid' => date('Y-m-d H:i:s'),
            'payment_invoice' => $invoice_num,
            'user_id' => $user_id,
            'license_id' => is_object($license) ? (int) $license->id : (int) $pending->license_id,
        ), $pending->id);

        // Same activation email as api/register_form (email_activation template).
        $this->_send_registration_activation_email($user_id, $data);

        return $user_id;
    }

    private function _build_registration_custom_fields($payload)
    {
        $CI =& get_instance();
        $CI->load->helper('form');

        if (!function_exists('build_dati_fiscali_custom_fields_json'))
            return json_encode(new stdClass());

        return build_dati_fiscali_custom_fields_json(array(
            'address' => isset($payload['address']) ? $payload['address'] : '',
            'postal_code' => isset($payload['postal_code']) ? $payload['postal_code'] : '',
            'city' => isset($payload['city']) ? $payload['city'] : '',
            'codice_fiscale' => isset($payload['codice_fiscale']) ? $payload['codice_fiscale'] : '',
            'provincia' => isset($payload['provincia']) ? $payload['provincia'] : '',
        ));
    }

    /**
     * Invalidate claim token after successful login (one-time use).
     */
    public function consume_claim_token($pending)
    {
        if (!is_object($pending) || empty($pending->id))
            return FALSE;

        $payload = json_decode($pending->payload, TRUE);
        if (!is_array($payload))
            $payload = array();
        unset($payload['password_hash']);

        $old_token = (string) $pending->token;
        $new_token = 'used_'.substr(hash('sha256', $old_token.'|'.microtime(TRUE).'|'.mt_rand()), 0, 40);

        return $this->save(array(
            'claimed' => 1,
            'date_claimed' => date('Y-m-d H:i:s'),
            'token' => $new_token,
            'payload' => json_encode($payload),
        ), $pending->id);
    }

    /**
     * Mirror api/register_form activation mail for WP VISITOR registrations.
     * Account stays activated=1 (already paid) so claim auto-login still works;
     * link sets mail_verified=1 via admin/user/verifyemail.
     */
    private function _send_registration_activation_email($user_id, $data)
    {
        if (empty($user_id) || empty($data['mail']))
            return;

        if (config_db_item('email_activation_enabled') !== TRUE)
            return;

        $CI =& get_instance();

        $CI->load->model('settings_m');
        $settings = $CI->settings_m->get_fields();
        $noreply = !empty($settings['noreply']) ? $settings['noreply'] : 'noreply@immobilgolf.com';

        // Ensure lang strings exist (same keys as register_form).
        if (isset($CI->language_m))
        {
            $lang_id = $CI->language_m->get_default_id();
            $lang_name = $CI->language_m->get_name($lang_id);
            if (!empty($settings['template']) && !empty($lang_name))
            {
                $CI->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$settings['template'].'/');
            }
        }
        else
        {
            $CI->load->model('language_m');
            $lang_id = $CI->language_m->get_default_id();
            $lang_name = $CI->language_m->get_name($lang_id);
            if (!empty($settings['template']) && !empty($lang_name))
            {
                $CI->lang->load('frontend_template', $lang_name, FALSE, TRUE, FCPATH.'templates/'.$settings['template'].'/');
            }
        }

        $CI->load->library('email');
        $config_mail = array('mailtype' => 'html');
        $CI->email->initialize($config_mail);
        $CI->email->from($noreply, lang_check('Web page'));
        $CI->email->to($data['mail']);
        $CI->email->subject(lang_check('Activate your account'));

        $new_hash = substr($CI->user_m->hash($data['mail'].$user_id), 0, 5);
        $data_m = array(
            'name_surname' => $data['name_surname'],
            'username' => $data['username'],
            'activation_link' => '<a href="'.site_url('admin/user/verifyemail/'.$user_id.'/'.$new_hash).'">'.lang_check('Activate your account').'</a>',
            'login_link' => '<a href="'.site_url('frontend/login/').'?username='.rawurlencode($data['username']).'#content">'.lang_check('login_link').'</a>',
        );

        $message = $CI->load->view('email/email_activation', array('data' => $data_m), TRUE);
        $CI->email->message($message);
        $CI->email->send();
    }
}
