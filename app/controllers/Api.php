<?php

class Api extends Controller {
  public function __construct() {
    $this->userModel = $this->model('User');
    $this->authorModel = $this->model('Author');
  }

  //dashboard page
  public function index() {

    $view = 'pages/index';
      if (file_exists('../app/views/' . $view . '.php')) {
          require_once '../app/views/' . $view . '.php';
      } else {
          die("View does not exists.");
      }
  }

  public function login($userName, $password) {

      $response = $this->userModel->login($userName, $password);
      print_r($response);
  }

  public function about() {
    $data = [
      'title' => 'About Page',
    ];
    
    $this->view('pages/about', $data);
  }

  //show api list
  public function documentation() {

      $view = 'pages/documentation';
      if (file_exists('../app/views/' . $view . '.php')) {
          require_once '../app/views/' . $view . '.php';
      } else {
          die("View does not exists.");
      }
  }


}