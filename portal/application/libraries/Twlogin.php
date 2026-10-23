<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * https://github.com/packetcode/twitter-login
 * 
 */

require_once(APPPATH . 'libraries/twitter/OAuth.php');
require_once(APPPATH . 'libraries/twitter/twitteroauth.php');

class Twlogin extends TwitterOAuth {
    private $consumerKey    = ''; /*InsertYourConsumerKey*/
    private $consumerSecret = ''; /*InsertYourConsumerSecret*/
    private $redirectURL    =  ''; /*OAUTH_CALLBACK*/
    
    public function __construct($oauthToken = NULL, $oauthTokenSecret = NULL)
    {
        $this->redirectURL = site_url('api/twitter_login');
        return parent::__construct($this->consumerKey, $this->consumerSecret, $oauthToken,  $oauthTokenSecret);
    }
    
    public function getRequestToken($arg=''){
        return parent::getRequestToken($this->redirectURL);
    }
    
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        } else {
            return false;
        }
    }
    
}

?>