<?php

require "../vendor/autoload.php";
use Firebase\JWT\JWT;

  class User {
    // database connection and table name
    private $db;
    private $table_name = "users";
 
    // object properties
    public $username;
    public $email;
    public $password;
    public $admin;
    public function __construct() {
      $this->db = Database::getConnect();
    }

    public function login($userName, $password) {
        $this->db->query("SELECT * FROM users WHERE username='" . $userName ."'");
        $result = $this->db->resultSet();
        $num = count($result);

        if($num > 0){
            $row = $result;
            $username = $row[0]->username;
            $admin = $row[0]->admin;
            $email = $row[0]->email;
            $password2 = $row[0]->password;

            if(password_verify($password, $password2))
            {
                $exp_Time = time()+36000;

                $token = array(
                    "exp" => $exp_Time,
                    "data" => array(
                        "username" => $username,
                        "email" => $email,
                        "admin" => $admin,
                    ));

                http_response_code(200);

                $secret_key = "benuniwork1";

                $jwt = JWT::encode($token, $secret_key);

                return  json_encode(
                    array(
                        "message" => "Successful login.",
                        "access_token" => $jwt
                    ));
            }
            else{

                http_response_code(500);
                return json_encode(array("message" => "Login failed."));
            }
        }
        else {
            http_response_code(500);
            return json_encode(array("message" => "Not credentional"));
        }
    }

  }