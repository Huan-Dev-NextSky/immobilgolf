<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session
{
	function sess_update ()
	{
		// Listen to HTTP_X_REQUESTED_WITH
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
			// This is NOT an ajax call
			parent::sess_update();
		}
	}

	/**
	 * Cross-site cookies for WordPress (immobilgolf.com → portal.immobilgolf.com).
	 * SameSite=None; Secure is required for credentialed XHR/fetch.
	 */
	function _set_cookie($cookie_data = NULL)
	{
		if (is_null($cookie_data))
		{
			$cookie_data = $this->userdata;
		}

		$cookie_data = $this->_serialize($cookie_data);

		if ($this->sess_encrypt_cookie == TRUE)
		{
			$cookie_data = $this->CI->encrypt->encode($cookie_data);
		}
		else
		{
			$cookie_data = $cookie_data.md5($cookie_data.$this->encryption_key);
		}

		$expire = ($this->sess_expire_on_close === TRUE) ? 0 : $this->sess_expiration + time();
		$secure = TRUE; // site is HTTPS; required with SameSite=None

		if (PHP_VERSION_ID >= 70300)
		{
			setcookie($this->sess_cookie_name, $cookie_data, array(
				'expires'  => $expire,
				'path'     => $this->cookie_path,
				'domain'   => $this->cookie_domain,
				'secure'   => $secure,
				'httponly' => FALSE,
				'samesite' => 'None',
			));
			return;
		}

		// PHP < 7.3 fallback via header()
		$cookie = rawurlencode($this->sess_cookie_name).'='.rawurlencode($cookie_data);
		if ($expire > 0)
			$cookie .= '; expires='.gmdate('D, d-M-Y H:i:s T', $expire);
		$cookie .= '; path='.$this->cookie_path;
		if ($this->cookie_domain != '')
			$cookie .= '; domain='.$this->cookie_domain;
		$cookie .= '; Secure; SameSite=None';
		header('Set-Cookie: '.$cookie, FALSE);
	}

	function sess_destroy()
	{
		if ($this->sess_use_database === TRUE && isset($this->userdata['session_id']))
		{
			$this->CI->db->where('session_id', $this->userdata['session_id']);
			$this->CI->db->delete($this->sess_table_name);
		}

		if (PHP_VERSION_ID >= 70300)
		{
			setcookie($this->sess_cookie_name, addslashes(serialize(array())), array(
				'expires'  => ($this->now - 31500000),
				'path'     => $this->cookie_path,
				'domain'   => $this->cookie_domain,
				'secure'   => TRUE,
				'httponly' => FALSE,
				'samesite' => 'None',
			));
		}
		else
		{
			parent::sess_destroy();
			return;
		}

		$this->userdata = array();
	}
    
    // nginx fix
	function _flashdata_mark1()
    {
            $userdata = $this->all_userdata();
            $newUserData = array();
            $userDataToUnset = array();
            foreach ($userdata as $name => $value)
            {
                    $parts = explode(':new:', $name);
                    if (is_array($parts) && sw_count($parts) === 2)
                    {
                            $new_name = $this->flashdata_key.':old:'.$parts[1];
                            $newUserData[$new_name] = $value;
                            $userDataToUnset[$name] = '';
                            //if we call these for each flash key we end up with a TON of set-cookie headers
                            //this is dumb, and causes problems with loadbalancers etc.
                            //$this->set_userdata($new_name, $value);
                            //$this->unset_userdata($name);
                    }
            }

            if ( sw_count($newUserData) > 0 ) {
              $this->set_userdata($newUserData);
              $this->unset_userdata($userDataToUnset);
              
              //echo 'T1';
              //var_dump($newUserData);
            }
    }
        
        
}