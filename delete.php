<?php


 include("db.php");

 if(isset($_POST['delete']))
 
 {

    $code = $_POST['code'];

    $query = "DELETE FROM vehicles WHERE code = '$code'";

    $resultado = mysqli_query($conn, $query);
    if($resultado) {
    
        $_SESSION['message'] = 'Task Removed Successfully';
        $_SESSION['message_type'] = 'danger';

    header('Location: index.php');
  
}else{
    echo '<script> alert("data not delete");</script>';
}

 }

