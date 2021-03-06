<?php

  class LoginController extends BaseController
  {
  	  public function register_account()
      {
  
        $user_id = $_POST['value'];

        $stmt = $this->db->prepare("INSERT INTO users (user_id) 
        VALUES (:user_id)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        echo "true";

      }

 
      public function login()
      {
         $user_id = $_POST['value'];
         $stmt = $this->db->prepare("SELECT user_id FROM users WHERE user_id = :user_id"); 
         $stmt->bindParam(':user_id', $user_id);
         $stmt->execute();
         $total = $stmt->rowCount();


          if($total>0)
          {
              Session::set("user_id",$user_id);

             $stmt2 = $this->db->prepare("SELECT * FROM favourites WHERE user_id = :user_id"); 
             $stmt2->bindParam(':user_id', $user_id);
             $stmt2->execute();
             $result = $stmt2->fetchAll();

              $my_favourite = array();
              $i = 0;
             foreach($result as $row){

                $new_favourite = array("city"=>$row['city'],"url"=>$row['url']);
                array_push($my_favourite,$new_favourite); 

              }

              Session::set("my_favourite",$my_favourite);


              echo "true";
          }
         else
          {
              echo "false";
          } 

      }      
 
      public function loginChecked()
      {
          echo Session::get("user_id");
      }

 
      public function logout()
      {
         Session::destroy();
      }

  }