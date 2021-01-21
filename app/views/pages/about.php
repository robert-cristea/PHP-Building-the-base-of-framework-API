<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  private $db;
  public function __construct() {
    $this->db = Database::getConnect();
  }

  //Instantiate author
  $author = new Author($db);

  $author->authorId = issent($_GET['id']) ? $_GET['id'] : die();
  $author->get_author();

  $author_arr = array(
    'authorId' => $author->authorId,
    'name' => $author->name,
    'authorInst' => $author->authorInst,
    'bookTitle' => $author->bookTitle,
    'award' => $author->award
  );

  //Make a json
  print_r(json_encode($author_arr));