<?php
//Session Model
  class Session {
    // database connection and table name
    private $db;
    private $table_name = "sessions";

    public $admin;
    public function __construct() {
      $this->db = Database::getConnect();

    }

    public function updateContent($id, $name) {
        try {

            $this->db->query("SELECT * FROM sessions WHERE sessionId=" . $id);
            $result = $this->db->resultSet();
            $num = count($result);

            if($num > 0) {
                $this->db->query("UPDATE sessions SET name='" . $name . "' WHERE sessionId=" . $id);
                $this->db->execute();
                http_response_code(200);
                return json_encode(array("message" => "Update successfully"));
            }
            else {
                http_response_code(500);
                return json_encode(array("message" => "Cannot find session as sessionId is " . $id));
            }


        } catch (Exception $e)
        {
            http_response_code(500);
            return json_encode(array("message" => "Update failed."));
        }
    }

      public function deleteContent($id) {
          try {

              $this->db->query("SELECT * FROM sessions WHERE sessionId=" . $id);
              $result = $this->db->resultSet();
              $num = count($result);

              if($num > 0) {
                  $this->db->query("DELETE FROM sessions WHERE sessionId=" . $id);
                  $this->db->execute();
                  http_response_code(200);
                  return json_encode(array("message" => "Delete session successfully"));
              }
              else {
                  http_response_code(500);
                  return json_encode(array("message" => "Cannot find session as sessionId is " . $id));
              }


          } catch (Exception $e)
          {
              http_response_code(500);
              return json_encode(array("message" => $e->getMessage()));
          }
      }

      public function roomContent($id) {
          try {

              $this->db->query("SELECT * FROM sessions WHERE roomId=".$id);
              $result = $this->db->resultSet();

              http_response_code(200);
              return json_encode(array("message" => "Success", "roomSession" => $result));

          } catch (Exception $e)
          {
              http_response_code(500);
              return json_encode(array("message" => $e->getMessage()));
          }
      }

      public function totalContentCount() {
          try {

              $this->db->query("SELECT COUNT(sessionId) AS totalCount FROM sessions ");
              $result = $this->db->resultSet();

              http_response_code(200);
              return json_encode(array("message" => "Success", "count" => $result));


          } catch (Exception $e)
          {
              http_response_code(500);
              return json_encode(array("message" => $e->getMessage()));
          }
      }

      public function showContent($id) {
          try {

              $this->db->query("SELECT * FROM sessions WHERE sessionId=".$id);
              $result = $this->db->resultSet();
              $num = count($result);

              if($num > 0) {
                  http_response_code(200);
                  return json_encode(array("message" => "Success", "selectedSession" => $result));
              }
              else {
                  http_response_code(500);
                  return json_encode(array("message" => "Cannot find session as sessionId is " . $id, "selectedSession" => null));
              }

          } catch (Exception $e)
          {
              http_response_code(500);
              return json_encode(array("message" => $e->getMessage()));
          }
      }

      public function searchContent($name){

          try {
              if($name) {
                  $this->db->query("SELECT * FROM sessions WHERE name LIKE '%".$name."%'");
              }
              else {
                  $this->db->query("SELECT * FROM sessions");
              }

              $result = $this->db->resultSet();

              http_response_code(200);
              return json_encode(array("message" => "Success", "searchResult" => $result));

          } catch (Exception $e)
          {
              http_response_code(500);
              return json_encode(array("message" => $e->getMessage()));
          }
      }

  }