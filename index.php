<?php
/**
 * Created by PhpStorm.
 * User: morteza
 * Date: 9/16/2018
 * Time: 1:19 PM
 */

class telegram
{
    public $proxy = false, $proxy_user, $proxy_pass, $proxy_port, $proxy_uri, $proxy_type = CURLPROXY_HTTP, $api_key;

    public function setProxy($proxy_url, $proxy_port, $username, $password, $proxy_type = CURLPROXY_HTTP)
    {
        $this->proxy_pass = $password;
        $this->proxy_user = $username;
        $this->proxy_port = $proxy_port;
        $this->proxy_type = $proxy_type;
        $this->proxy_uri = $proxy_url;
        $this->proxy = true;
    }
    
    public function __construct($token)
    {
        $this->api_key = $token;
    }

    public function curl($method, $datas = [])
    {
        $url = "https://api.telegram.org/bot" . $this->api_key . "/" . $method;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($this->proxy) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy_uri . ":" . $this->proxy_port);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_user . ":" . $this->proxy_pass);
            curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_type);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
        $res = curl_exec($ch);
        if (curl_error($ch)) {
            var_dump(curl_error($ch));
        } else {
            return json_decode($res);
        }
        return $res;
    }
}
