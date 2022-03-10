<?php

// Archivo de conexion
include("db.php");

// Recibo la accion de enviar y todos los objetos que traiga
if (isset($_POST['save_vehicle'])) {

     // Recibo el valor de cada objeto con su respectivo name y lo guardo en una variable. 
     // El name es una propiedad que se le asigna a una etiqueta del input
     $_code = $_POST['code'];
     $_type = $_POST['type'];
     $_model = $_POST['model'];
     $_license_plate = $_POST['license_plate'];
     $_color = $_POST['color'];
     $_num_passengers = $_POST['num_passengers'];
     $_photo = $_POST['photo'];
     $_fuel_type = $_POST['fuel_type'];


     // Valido si en la consulta la columna photo tiene una url o no
     // Es decir, verifico que efectivamente haya una imagen en ese campo
     if ($_photo["photo"] == "") {
          // Si el resultado de la consulta no arroja un resultado con imagen, 
          // entonces le dibujo una imagen por defecto a esa fila                              
          echo '<img src="http://localhost/DTPS_G5/img/defecto.png" class="img-responsive" width="200px">';
     } else {
          // Si por el contrario, encontró una imagen, entonces leo la url y la dibujo 
          echo '<img src="http://localhost/DTPS_G5/' . $_photo["photo"] . '" class="img-responsive" width="200px">';
     }
     // La ruta de la imagen va a ser igual a la informacion que haya de la foto
     $rutaImg = $_photo;


     // verifico si el campo enviado es de tipo archivo/flie
     if (isset($_FILES["photoVehicle"]["tmp_name"]) && !empty($_FILES["photoVehicle"]["tmp_name"])) {
          // si el archivo es diferente a vacio/si trae un dato, limpio los datos del nombre de la imagen
          if (!empty($_POST["imgActual"])) {
               unlink($_POST["imgActual"]);
          }



          // Verifico si el archivo enviado es de tipo imagen en formato png
          if ($_FILES["photoVehicle"]["type"] == "image/png") {

               //Genero un número aleatorio
               $nombre = mt_rand(100, 999);

               /*Asigno la ruta para la imagen, como ya limpie los datos del nombre del archivo debo generar uno nuevo
               El nombre que se va a generar va a ser de la siguiente manera: 
               (carpeta del proyecto + numero aleatorio generado arriba y fializa con .png)
                 */
               $rutaImg = "img/vehicles" . $nombre . ".png";

               // Creo la imagen con el formato png
               $foto = imagecreatefrompng($_FILES["photoVehicle"]["tmp_name"]);

               imagepng($foto, $rutaImg);
          }

          // Verifico si el archivo enviado es de tipo imagen en formato png
          if ($_FILES["photoVehicle"]["type"] == "image/jpeg") {

               //Genero un número aleatorio
               $nombre = mt_rand(100, 999);

               /*Asigno la ruta para la imagen, como ya limpie los datos del nombre del archivo debo generar uno nuevo
                    El nombre que se va a generar va a ser de la siguiente manera: 
                    (carpeta del proyecto + numero aleatorio generado arriba y fializa con .jpg)
                      */
               $rutaImg = "img/vehicles" . $nombre . ".jpg";

               // Creo la imagen con el formato png
               $foto = imagecreatefromjpeg($_FILES["photoVehicle"]["tmp_name"]);

               imagejpeg($foto, $rutaImg);
          }
     }

     // Ejectuco la consulta de mysql con los datos recibidos por el post
     $query = "INSERT INTO vehicles(code,type,model,license_plate,color,num_passengers,photo,fuel_type) values ('$_code','$_type','$_model','$_license_plate','$_color','$_num_passengers','$rutaImg','$_fuel_type')";
     $result = mysqli_query($conn, $query);

     if (!$result) {
		echo '<script>
			window.location = "index.php";
			</script>';
          die("No se realizó el registro");
     }

     // Mensaje a enviar por la sesion y que se muestre cuando se crea un registro
     $_SESSION['message'] = 'Se ha ingresado un nuevo vehículo al sistema';
     // Tipo de mensaje a enviar cuando se realiza el registro
     $_SESSION['message_type'] = 'success';

     



     header("Location: index.php");
}
