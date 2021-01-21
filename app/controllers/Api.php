<?php

class Api extends Controller {
  public function __construct() {
    $this->userModel = $this->model('User');
    $this->authorModel = $this->model('Author');
  }

  //dashboard page
  public function index() {
      
      $this->view('index');
  }

  public function login($userName, $password) {

      $response = $this->userModel->login($userName, $password);
      print_r($response);
  }

  public function about() {
    $data = [
      'title' => 'About Page',
    ];
    
    $this->view('about', $data);
  }

  //show api list
  public function documentation() {

      $this->view('documentation');
  }


}