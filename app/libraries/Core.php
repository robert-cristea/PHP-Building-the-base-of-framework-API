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

        if($_GET['url'] == "api")
        {
            header("Location: ".URLROOT."/api/");
            exit();
        }

      $url = $this->getUrl();

      //Look in 'controllers' for first value, ucwords will capitalize first letter
      if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
        //Will set a new controller
        $this->currentController = ucwords($url[0]);
        unset($url[0]);
      }

      //Require the controller
      $this->currentController = new $this->currentController;

    if (!isset($url[1])) {
        $apiCont = new Api();
        $apiCont->documentation();
    }
    else {

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
//                    call_user_func_array(["Api", "login"], $this->params);
                    }
                    else {
                        http_response_code(500);

                        print_r($data);
                    }
                }
                break;
            case "update":
                if($_SERVER['REQUEST_METHOD'] == "POST")
                {

                    $getHeaders = apache_request_headers();

                    $authorize = $getHeaders['Authorization'];

                    $sessionClass = new Session();

                    $flag = $this->checkAuth($authorize);

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
                }

                break;

            case "delete-session":

                if($_SERVER['REQUEST_METHOD'] == "POST")
                {

                    $getHeaders = apache_request_headers();

                    $authorize = $getHeaders['Authorization'];

                    $sessionClass = new Session();

                    $flag = $this->checkAuth($authorize);

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
                }

                break;

            case "room-sessions":

                $getHeaders = apache_request_headers();

                $authorize = $getHeaders['Authorization'];

                $sessionClass = new Session();

                $flag = $this->checkAuth($authorize);

                if($flag > 0) {
                    $roomId = $_POST['roomId'];
                    $data = $sessionClass->roomContent($roomId);
                    echo $data;
                }
                else{
                    http_response_code(401);

                    echo json_encode(array("message" => "Unauthorized"));
                }

                break;

            case "total-count":
                $getHeaders = apache_request_headers();

                $authorize = $getHeaders['Authorization'];

                $sessionClass = new Session();

                $flag = $this->checkAuth($authorize);

                if($flag > 0) {
                    $sessionClass->totalContentCount();
                }
                else{
                    http_response_code(401);
                    echo json_encode(array("message" => "Unauthorized"));
                }

                break;

            case "show-session":
                $getHeaders = apache_request_headers();

                $authorize = $getHeaders['Authorization'];

                $sessionClass = new Session();

                $flag = $this->checkAuth($authorize);

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

                break;

            case "search-item":
                $getHeaders = apache_request_headers();

                $authorize = $getHeaders['Authorization'];

                $sessionClass = new Session();

                $flag = $this->checkAuth($authorize);

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

                break;

            case "list":
                $apiCont = new Api();
                $apiCont->documentation();
                break;

            case "dashboard":
                $apiCont = new Api();
                $apiCont->index();
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