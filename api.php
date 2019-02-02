<?php
 

header('content-type: application/json');

      $request=$_SERVER['REQUEST_METHOD'];

   switch ( $request) {
   	case 'GET':
   		getmethod();
   	break;
   	case 'PUT':
          $data=json_decode(file_get_contents('php://input'),true);
         putmethod($data);
   	break;
   	case 'POST':
   		$data=json_decode(file_get_contents('php://input'),true);
         postmethod($data);
   	break;
   	case 'DELETE':
   		$data=json_decode(file_get_contents('php://input'),true);
         deletemethod($data);
   	break;
   	
   	default:
   		echo '{"name": "data not found"}';
   		break;
   }
//data read part are here
function getmethod(){
  include "db.php";
  $sql = "SELECT * FROM learnhunter";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
       $rows=array();
       while ($r = mysqli_fetch_assoc($result)) {

          $rows["result"][] = $r;
       }

       echo json_encode($rows);
  }  else{
      echo '{"result": "no data found"}';
    }
}
//data insert part are here
function postmethod($data){
   include "db.php";
   $name=$data["name"];
   $email=$data["email"];

   $sql= "INSERT INTO learnhunter(name,email,created_at) VALUES ('$name' , '$email', NOW())";

   if (mysqli_query($conn , $sql)) {
      echo '{"result": "data inserted"}';
   } else{

      echo '{"result": "data not inserted"}';
   }



}

//data edit part are here
function putmethod($data){
   include "db.php";
   $id=$data["id"];
   $name=$data["name"];
   $email=$data["email"];

   $sql= "UPDATE learnhunter SET name='$name', email='$email', created_at=NOW() where id='$id'  ";

   if (mysqli_query($conn , $sql)) {
      echo '{"result": "Update Succesfully"}';
   } else{

      echo '{"result": "not updated"}';
   }



}
//delete method are here,,,,,,,,,,,,,,
function deletemethod($data){
   include "db.php";

   $id=$data["id"];
   


   $sql= "DELETE FROM learnhunter where id=$id";

   if (mysqli_query($conn , $sql)) {
      echo '{"result": "delete Succesfully"}';
   } else{

      echo '{"result": "not deleted"}';
   }
}
?>
