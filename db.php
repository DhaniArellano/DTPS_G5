 <?php

session_start();


 $servidor = "localhost";
 $usuario ="root" ;
 $pass = "";
 $db= "db_vehicles";

 $conn = mysqli_connect(
      $servidor,
      $usuario,
      $pass,
      $db
 );


 

?>