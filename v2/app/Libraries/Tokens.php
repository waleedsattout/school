<?php

namespace App\Libraries;

class Tokens
{
    private $secret_key = "w9JE4cpjgwjP0mlzBchyyCXk9jlZZ4Ca8iae0STC9hNpttf4Ou6JxfQfj3txUNI";
    private $issuer_claim;
    private $issuedat_claim;
    private $notbefore_claim;
    private $expire_claim;
    public $token;
    public $jwt;
    public function __construct()
    {
        $this->issuer_claim = base_url('');
        $this->token = [
            "iss" => $this->issuer_claim,
            "iat" => $this->issuedat_claim,
            "nbf" => $this->notbefore_claim,
            "exp" => $this->expire_claim,
            "data" => [
                "id" => session()->get('user_id'),
                "logged_in" => session()->get('logged_in'),
                "role" => session()->get('role'),
                "session_exp" => $this->expire_claim,
            ]
        ];
    }

    public function setToken()
    {
        $this->issuedat_claim = time(); // issued at
        $this->notbefore_claim = $this->issuedat_claim + 10; //not before in seconds
        $this->expire_claim = $this->issuedat_claim + 600; // expire time in seconds
        $this->jwt = JWT::encode($this->token, $this->secret_key, 'HS256');
        $return = json_encode(
            [
                "message" => "Successful login",
                "status" => "ok",
                "jwt" => $this->jwt,
                "expireAt" => $this->expire_claim . '000'
            ]
        );
        echo $return;
        return $return;
    }

    public function checkToken()
    {
        $jwt = false;
        $keys = array_keys($_GET);
        foreach ($keys as $key)
            if ($key == 'JWT')
                $jwt = $_GET['JWT'];
        if ($jwt) {
            $decoded = @JWT::decode($jwt, new Key($this->secret_key, 'HS256'));
            if ($decoded->data->id == session()->get('user_id')) {
                return true;
            }
            if (!empty($_GET['ssms']) && $_GET['ssms'] == true)  return true;
        }
        return false;
    }

    public function getToken()
    {
        return JWT::encode($this->token, $this->secret_key, 'HS256');
    }
}
