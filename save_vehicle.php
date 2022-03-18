<?php

// Archivo de conexion
include("db.php");

// Recibo la accion de enviar y todos los objetos que traiga
if (isset($_POST['save_vehicle'])) {

     // Recibo el valor de cada objeto con su respectivo name y lo guardo en una variable. 
     // El name es una propiedad que se le asigna a una etiqueta del input
     $_type = $_POST['type'];
     $_model = $_POST['model'];
     $_license_plate = $_POST['license_plate'];
     $_color = $_POST['color'];
     $_num_passengers = $_POST['num_passengers'];
     $_photo = $_POST['photoVehicle'];
     $_fuel_type = $_POST['fuel_type'];
     

     //Convertir primer catacter en mayusculas
     $fuel_type_Mayus = ucfirst($_fuel_type);


     // Valido si en la consulta la columna photo tiene una url o no
     // Es decir, verifico que efectivamente haya una imagen en ese campo
     if ($_photo["photoVehicle"] == "") {
          // Si el resultado de la consulta no arroja un resultado con imagen, 
          // entonces le dibujo una imagen por defecto a esa fila                              
          echo '<img src="http://localhost/DTPS_G5/img/defecto.png" class="img-responsive" width="200px">';
     } else {
          // Si por el contrario, encontró una imagen, entonces leo la url y la dibujo 
          echo '<img src="http://localhost/DTPS_G5/' . $_photo["photoVehicle"] . '" class="img-responsive" width="200px">';
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
               $rutaImg = "img/vehicles/vehicle-" . $nombre . ".png";

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
               $rutaImg = "img/vehicles/vehicle-" . $nombre . ".jpg";

               // Creo la imagen con el formato png
               $foto = imagecreatefromjpeg($_FILES["photoVehicle"]["tmp_name"]);

               imagejpeg($foto, $rutaImg);
          }
     }



     #region Funciones para validar los mensajes por sesion

     #region Mensaje para mostrar cuando la tarea concluye de manera correcta
     function exitoso()
     {
          // Mensaje a enviar por la sesion y que se muestre cuando se crea un registro
          $_SESSION['message'] = 'Se ha ingresado un nuevo vehículo al sistema';
          // Tipo de mensaje a enviar cuando se realiza el registro
          $_SESSION['message_type'] = 'success';
         
     }
     #endregion

     #region Mensaje para mostrar cuando haya un error con la tarea
     function error()
     {
          // Mensaje a enviar por la sesion y que se muestre cuando se crea un registro
          $_SESSION['message'] = 'Se ha producido un error en el sistema.';
          // Tipo de mensaje a enviar cuando se realiza el registro
          $_SESSION['message_type'] = 'danger';
     }
     #endregion

     #endregion


     #region Valido que los datos recibidos en las variables no sean vacíos
     if ($_code == "" || $_color == "" || $_type == ""|| $_model == ""|| $_license_plate == ""|| $_num_passengers == ""|| $_fuel_type == "" ) {
          error();
     }

     #endregion

     #region Consulta a MySQL con el insert

     // Ejectuco la consulta de mysql con los datos recibidos por el post
     $query = "INSERT INTO vehicles(type,model,license_plate,color,num_passengers,photo,fuel_type) values ('$_type','$_model','$_license_plate','$_color','$_num_passengers','$rutaImg','$fuel_type_Mayus')";
     $result = mysqli_query($conn, $query);

     if ($result == true) {
          exitoso();
          echo '<script>
			window.location = "exito.html";
			</script>';
     } else {
          error();
          echo '<script>
			window.location = "error.html";
			</script>';
          die("No se realizó el registro");
     }

     #endregion

     


}
