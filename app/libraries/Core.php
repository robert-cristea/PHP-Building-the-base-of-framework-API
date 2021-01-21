<?php
//router Controller
require "../vendor/autoload.php";
use Firebase\JWT\JWT;
require_once '../app/controllers/Api.php';

  class Core {
    protected $currentController = 'Api';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {

        if(!isset($_GET['url'])) {
            $apiCont = new Api();
            $apiCont->index();
            return true;
        }

      $url = $this->getUrl();

    if (!isset($url[1])) {

        switch($_GET['url']) {

            case 'index.php':
                $apiCont = new Api();
                $apiCont->index();
                return true;

            case 'index':
                $apiCont = new Api();
                $apiCont->index();
                return true;

            case 'documentation/':
                $apiCont = new Api();
                $apiCont->documentation();
                break;

            case 'documentation.php':
                header("Location: ".URLROOT."/documentation/");
                exit();
                break;
//                $apiCont = new Api();
//                $apiCont->documentation();
//                break;

            case 'documentation':
                header("Location: ".URLROOT."/documentation/");
                exit();
                break;

            case 'about':
                $apiCont = new Api();
                $apiCont->about();
                break;

            case 'about.php':
                $apiCont = new Api();
                $apiCont->about();
                break;

            case 'api':
                header('Content-Type: application/json');

                print_r (json_encode(array(
                    "status" => 200,
                    "message" => "Welcome",
                    "author" => "Ben",
                    "api" => array(
                        "/api"=> "returns api endpoints and basic info",
                        "/api/login" => array(
                            "return"=> "a JSON Web Token if the login is successful",
                            "authentication"=> "username and password from a post form"
                        ),
                        "/api/update" => array(
                            "return" => "updates the title of a session id the JSON Web Token used is correct",
                            "authentication" => "JSON Web Token and the updated title of the session"
                        ),
                        "api/delete-session" => array(
                            "input" => "sessionId to be deleted from post",
                            "authentication" => "JSON Web Token and the delete session"
                        ),
                        "api/room-sessions" => array(
                            "input" => "roomId to get roomSession from post",
                            "return" => "roomSession object",
                            "authentication" => "JSON Web Token and the roomSession"
                        ),
                        "api/total-count" => array(
                            "return" => "count fo sessions",
                            "authentication" => "required JSON Web Token"
                        ),
                        "api/show-session" => array(
                            "input" => "sessionId to get session info",
                            "return"=> "info of selected session",
                            "authentication" => "required JSON Web Token"
                        ),
                        "api/search-item?keyword" => array(
                            "return"=>"result of search",
                            "authentication" => "required JSON Web Token"
                        )
                    )
                )));
                break;
            default:
                header("Location: ".URLROOT);
                exit();
                break;
        }
    }
    else {
        header('Content-Type: application/json');
        switch ($url[1]) {
            case "login":
                if($_SERVER['REQUEST_METHOD'] == "POST")
                {
                    $userName = $_POST['username'];
                    $password = $_POST['password'];
                    $data['message'] = "Not valid";

                    if($userName && $password) {
                        $pagesClass = new Api();
                        $data = $pagesClass->login($userName, $password);
                    }
                    else {
                        http_response_code(500);
                        print_r($data);
                    }
                }
                else{
                    http_response_code(405);
                    echo json_encode(array("message" => "Get method is not allowed!"));
                }
                break;
            case "update":
                if($_SERVER['REQUEST_METHOD'] == "POST")
                {

                    $getHeaders = apache_request_headers();

                    $flag = 0;

                    if(!isset($getHeaders['Authorization'])) {
                        $flag = 0;
                    }
                    else {
                        $authorize = $getHeaders['Authorization'];
                        $sessionClass = new Session();
                        $flag = $this->checkAuth($authorize);
                    }


                    if($flag > 0) {
                        if($flag == 2) {
                            $contentId = $_POST['sessionId'];
                            $name = $_POST['name'];

                            $data = $sessionClass->updateContent($contentId, $name);

                            echo $data;
                        }
                        else {
                            http_response_code(500);

                            echo json_encode(array("message" => "Not Admin"));
                        }
                    }
                    else{
                        http_response_code(401);
                        echo json_encode(array("message" => "Unauthorized"));
                    }
                }else{
                    http_response_code(405);
                    echo json_encode(array("message" => "Get method is not allowed!"));
                }

                break;

            case "delete-session":

                if($_SERVER['REQUEST_METHOD'] == "POST")
                {

                    $getHeaders = apache_request_headers();

                    $flag = 0;

                    if(!isset($getHeaders['Authorization'])) {
                        $flag = 0;
                    }
                    else {
                        $authorize = $getHeaders['Authorization'];
                        $sessionClass = new Session();
                        $flag = $this->checkAuth($authorize);
                    }

                    if($flag > 0) {
                        if($flag == 2) {
                            $contentId = $_POST['sessionId'];
                            $data = $sessionClass->deleteContent($contentId);
                            echo $data;
                        }
                        else {
                            http_response_code(500);

                            echo json_encode(array("message" => "Not Admin"));
                        }
                    }
                    else{
                        http_response_code(401);

                        echo json_encode(array("message" => "Unauthorized"));
                    }
                }else{
                        http_response_code(405);
                        echo json_encode(array("message" => "Get method is not allowed!"));
                }

                break;

            case "room-sessions":

                if($_SERVER['REQUEST_METHOD'] == "POST"){

                    $getHeaders = apache_request_headers();

                    $flag = 0;

                    if(!isset($getHeaders['Authorization'])) {
                        $flag = 0;
                    }
                    else {
                        $authorize = $getHeaders['Authorization'];
                        $sessionClass = new Session();
                        $flag = $this->checkAuth($authorize);
                    }

                    if($flag > 0) {
                        $roomId = $_POST['roomId'];
                        $data = $sessionClass->roomContent($roomId);
                        echo $data;
                    }
                    else{
                        http_response_code(401);

                        echo json_encode(array("message" => "Unauthorized"));
                    }
                }else{
                    http_response_code(405);
                    echo json_encode(array("message" => "Get method is not allowed!"));
                }
                break;

            case "total-count":
                if ($_SERVER['REQUEST_METHOD'] == "GET"){
                    $getHeaders = apache_request_headers();
                    $flag = 0;

                    if(!isset($getHeaders['Authorization'])) {
                        $flag = 0;
                    }
                    else {
                        $authorize = $getHeaders['Authorization'];
                        $sessionClass = new Session();
                        $flag = $this->checkAuth($authorize);
                    }

                    if($flag > 0) {
                        $sessionClass->totalContentCount();
                    }
                    else{
                        http_response_code(401);
                        echo json_encode(array("message" => "Unauthorized"));
                    }

                }else{
                    http_response_code(405);
                    echo json_encode(array("message" => "POST method is not allowed!"));
                }

                break;

            case "show-session":
                if ($_SERVER["REQUEST_METHOD"] == "GET"){
                    $getHeaders = apache_request_headers();
                    $flag = 0;

                    if(!isset($getHeaders['Authorization'])) {
                        $flag = 0;
                    }
                    else {
                        $authorize = $getHeaders['Authorization'];
                        $sessionClass = new Session();
                        $flag = $this->checkAuth($authorize);
                    }

                    if($flag > 0) {
                        if(isset($_GET['sessionname'])) {
                            $data = $sessionClass->showContent($_GET['sessionId']);
                            echo $data;
                        }
                        else {
                            http_response_code(500);
                            echo json_encode(array("message" => "Cannot get sessionId"));
                        }

                    }
                    else{
                        http_response_code(401);
                        echo json_encode(array("message" => "Unauthorized"));
                    }
                }else{
                    http_response_code(405);
                    echo json_encode(array("message" => "Post method is not allowed!"));
                }

                break;

            case "search-item":
                if ($_SERVER['REQUEST_METHOD'] == "GET"){
                    $getHeaders = apache_request_headers();
                    $flag = 0;

                    if(!isset($getHeaders['Authorization'])) {
                        $flag = 0;
                    }
                    else {
                        $authorize = $getHeaders['Authorization'];
                        $sessionClass = new Session();
                        $flag = $this->checkAuth($authorize);
                    }

                    if($flag > 0) {
                        if(isset($_GET['keyword'])) {
                            $data = $sessionClass->searchContent($_GET['keyword']);
                            echo $data;
                        }
                        else {
                            $data = $sessionClass->searchContent("");
                            echo $data;
                        }

                    }
                    else{
                        http_response_code(401);
                        echo json_encode(array("message" => "Unauthorized"));
                    }

                }else{
                    http_response_code(405);
                    echo json_encode(array("message" => "Post method is not allowed!"));
                }
                break;

            default:
                $apiCont = new Api();
                $apiCont->documentation();
                break;
        }
    }

    }

    public function getUrl() {
      if(isset($_GET['url'])) {
        $url = rtrim($_GET['url'], '/');
        // Allows you to filter variables as string/number
        $url = filter_var($url, FILTER_SANITIZE_URL);
        //Breaking it into an array
        $url = explode('/', $url);
        return $url;
      }
    }

      public function checkAuth($authHeader) {

          $arr = explode(" ", $authHeader);

          $jwt = $arr[1];
          if($jwt){

              try {

                  $secret_key = "benuniwork1";

                  $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

                  $array_decoded = (array) $decoded;

                  if($array_decoded['data']->admin == 1)
                  {
                      return 2;
                  }
                  return 1;

              }catch (Exception $e){
                  return 0;
              }
          }

          return 0;
      }
  }