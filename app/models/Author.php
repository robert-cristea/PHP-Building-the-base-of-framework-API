<?php
//Author model
  class Author {
    // database connection and table name
    private $db;
    private $table_name = "authors";

    // Author Properties
    public $authorId;
    public $name;
    public $authorInst;
    public $bookTitle;
    public $award;

    // Constructor with DB
    public function __construct() {
      $this->db = Database::getConnect();
    }

    // Get Authors
    public function get_authors() {
      // create query
      $sql = 'SELECT 
          a.authorId, 
          a.[name],
          ca.authorInst,
          c.title as bookTitle,
          c.award 
          FROM 
          ' . $this->table_name . ' a 
          LEFT JOIN
            content_authors ca ON a.authorId = ca.authorId
          LEFT JOIN
            content c ON ca.contentId = c.contentId
          ORDER BY a.[name] ASC';

      // Prepare statement
      $this->db->query($sql);

      $result = $this->db->resultSet();

      return $result;
  
    }

    public function get_author() {
      $query = 'SELECT 
        a.authorId, 
        a.[name],
        ca.authorInst,
        c.title,
        c.award 
        FROM 
        authors a 
        LEFT JOIN
          content_authors ca ON a.authorId = ca.authorId
        LEFT JOIN
          content c ON ca.contentId = c.contentId
        WHERE a.authorId = ? LIMIT 1';


      // Prepare statement
      $stmt = $this->db->query($query);
      //binding param
      $stmt->bindParam(1, $this->authorId);
      // Execute query
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      $this->authorId = $row['authorId'];
      $this->name = $row['name'];
      $this->authorInst = $row['authorInst'];
      $this->title = $row['title'];
      $this->award = $row['award'];

    }
  }
?>