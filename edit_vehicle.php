<!-- 
     Vehiculo
     Atributos
     Code           -> Number, es un identificador interno autoincrementable
     Type           -> Select, define el tipo de vehiculo (carro, autobus, moto,...)
     Model          -> Text, almacena el modelo del vehiculo
     License_plate  -> Texto, almacena la matricula del vehiculo
     Color          -> Tipo Color, se refiere al color del vehiculo se guarda en HEX
     Num_Passengers -> Number, se refiere al numero de asientos de un vehiculo
     Fuel_type      -> Select, define el tipo de combustible que usa un vehiculo
-->
<?php
//Traemos la conexion a la db
include("db.php");

$photoV = null;
//Verificamos que el contenido recibido por GET no sea nulo o vacio
if (isset($_GET['code'])) {
     $code = $_GET['code'];
     $query = "SELECT * FROM vehicles WHERE code=$code";
     $result = mysqli_query($conn, $query);
     //si existe lo asignamos a sus variables
     if (mysqli_num_rows($result) == 1) {
          $row = mysqli_fetch_array($result);
          $type = $row['type'];
          $model = $row['model'];
          $license_plate = $row['license_plate'];
          $color = $row['color'];
          $num_passengers = $row['num_passengers'];
          $fuel_type = ucfirst($row['fuel_type']);
     }
}
/* 
     Funcion encargada de actualizar un vehiculo
     Está encargada de escuchar por post si hubo algun evento button update
     Verifica que no sea un dato nulo o vacio
*/
if (isset($_POST['update'])) {
     //asignamos el contenido enviado por post en sus variables
     $code = $_GET['code'];
     $type = $_POST['type'];
     $model = $_POST['model'];
     $license_plate = $_POST['license_plate'];
     $color = $_POST['color'];
     $num_passengers = $_POST['num_passengers'];
     $photoV = $_POST["imgVehicle"];
     $fuel_type =  ucfirst($_POST['fuel_type']);

     // Valido si en la consulta la columna photo tiene una url o no
     // Es decir, verifico que efectivamente haya una imagen en ese campo
     if ($photoV == "") {
          // Si el resultado de la consulta no arroja un resultado con imagen, 
          // entonces le dibujo una imagen por defecto a esa fila                              
          echo '<img src="http://localhost/DTPS_G5/img/defecto.png" class="img-responsive" width="200px">';
     } else {
          // Si por el contrario, encontró una imagen, entonces leo la url y la dibujo 
          echo '<img src="http://localhost/DTPS_G5/' . $photoV["imgVehicle"] . '" class="img-responsive" width="200px">';
     }
     // La ruta de la imagen va a ser igual a la informacion que haya de la foto
     $rutaImg = $photoV;


     // verifico si el campo enviado es de tipo archivo/flie
     if (isset($_FILES["imgVehicle"]["tmp_name"]) && !empty($_FILES["imgVehicle"]["tmp_name"])) {
          // si el archivo es diferente a vacio/si trae un dato, limpio los datos del nombre de la imagen
          if (!empty($_POST["imgActual"])) {
               unlink($_POST["imgActual"]);
          }



          // Verifico si el archivo enviado es de tipo imagen en formato png
          if ($_FILES["imgVehicle"]["type"] == "image/png") {

               //Genero un número aleatorio
               $nombre = mt_rand(100, 999);

               /*Asigno la ruta para la imagen, como ya limpie los datos del nombre del archivo debo generar uno nuevo
               El nombre que se va a generar va a ser de la siguiente manera: 
               (carpeta del proyecto + numero aleatorio generado arriba y fializa con .png)
                 */
               $rutaImg = "img/vehicles/vehicle-" . $nombre . ".png";

               // Creo la imagen con el formato png
               $foto = imagecreatefrompng($_FILES["imgVehicle"]["tmp_name"]);

               imagepng($foto, $rutaImg);
          }

          // Verifico si el archivo enviado es de tipo imagen en formato png
          if ($_FILES["imgVehicle"]["type"] == "image/jpeg") {

               //Genero un número aleatorio
               $nombre = mt_rand(100, 999);

               /*Asigno la ruta para la imagen, como ya limpie los datos del nombre del archivo debo generar uno nuevo
                    El nombre que se va a generar va a ser de la siguiente manera: 
                    (carpeta del proyecto + numero aleatorio generado arriba y fializa con .jpg)
                      */
               $rutaImg = "img/vehicles/vehicle-" . $nombre . ".jpg";

               // Creo la imagen con el formato png
               $foto = imagecreatefromjpeg($_FILES["imgVehicle"]["tmp_name"]);

               imagejpeg($foto, $rutaImg);
          }
     }

     //realizamos un prepared statement para ser enviado al sgdb
     $query = "UPDATE vehicles SET type = '$type', model = '$model', license_plate = '$license_plate', color = '$color', num_passengers = '$num_passengers', photo ='$rutaImg', fuel_type = '$fuel_type' WHERE code = $code";
     mysqli_query($conn, $query);
     //dependieno de la salida actualizamos la session para mostrar estado en index
     $_SESSION['message'] = 'Vehicle Updated Successfully'; 
     $_SESSION['message_type'] = 'info';
     header('Location: index.php');
}
?>
<!-- traemos el compomponente header -->
<?php include("includes/header.php") ?>

<div class="content-wrapper">
     <section class="content">
          <div class="box">
               <div class="box-body">
                    <form action="edit_vehicle.php?code=<?php echo $_GET['code']; ?>" method="POST" role="form" enctype="multipart/form-data">
                         <div class="row">
                              <div class="col-md-6 col-xs-12">
                                   <!--
                    creamos un formulario que va a recibir los datos 
                    y permitirá modificarlos para enviarlos por post 
                    -->

                                   <input name="code" type="hidden" class="input-lg" value="<?php echo $code; ?>" disabled>

                                   <h3>Tipo de vehiculo</h3>
                                   <select name="type" required class="input-lg">
                                        <option selected value="<?php echo $type; ?>"><?php echo $type; ?></option>
                                        <option value="Autobus">Autobus</option>
                                        <option value="Carro">Carro</option>
                                        <option value="Camion">Camion</option>
                                        <option value="Camioneta">Camioneta</option>
                                        <option value="Microbus">Microbus</option>
                                        <option value="Motocicleta">Moto</option>
                                   </select>
                                   <!--<input name="type" type="text" class="input-lg" value="<?php echo $type; ?>" placeholder="Update Model">-->

                                   <h3>Modelo del vehiculo</h3>
                                   <input name="model" type="text" class="input-lg" value="<?php echo $model; ?>" placeholder="Update Model" required>

                                   <h3>Placa del vehiculo</h3>
                                   <input name="license_plate" type="text" class="input-lg" value="<?php echo $license_plate; ?>" placeholder="Update Plate" required>
                              </div>

                              <div class="col-md-6 col-xs-12">
                                   <h3>Color del vehiculo</h3>
                                   <input type="color" name="color" class="input-lg" value="<?php echo $color; ?>">

                                   <h3>Numero de pasajeros</h3>
                                   <input name="num_passengers" type="number" class="input-lg" value="<?php echo $num_passengers; ?>" placeholder="Update passengers" required>

                                   <h3>Tipo de Combustible</h3>

                                   <select name="fuel_type" required class="input-lg">
                                        <option selected value="<?php echo $fuel_type; ?>"><?php echo $fuel_type; ?></option>
                                        <option value="gasolina">Gasolina</option>
                                        <option value="diesel">Diésel</option>
                                        <option value="etanol">Etanol</option>
                                        <option value="hidrogeno">Hidrógeno</option>
                                        <option value="biodiesel">Biodiesel</option>
                                        <option value="electricidad">Electricidad</option>
                                        <option value="metanol">Metanol</option>
                                        <option value="gas_natural">Gas Natural</option>
                                        <option value="GLP">GLP</option>
                                   </select>
                                   <br>
                                   <br>
                                   <input type="file" name="imgVehicle" >
                                   <?php
                                   // Valido si en la consulta la columna photo tiene una url o no
                                   // Es decir, verifico que efectivamente haya una imagen en ese campo
                                   if ($row["photo"] == "") {
                                        // Si el resultado de la consulta no arroja un resultado con imagen, 
                                        // entonces le dibujo una imagen por defecto a esa fila                              
                                        echo '<img src="http://localhost/DTPS_G5/img/defecto.png" class="img-responsive" width="200px">';
                                   } 
                                   ?>
                                   <br><img src="http://localhost/DTPS_G5/<?php echo $row["photo"] ?>" class="img-responsive" width="200px">
                                   <input type="hidden" name="imgActual" value="<?php echo $row["photo"] ?>">
                                   <br><br>
                                   <button class="btn btn-success" name="update">Update </button>
                                   <input type="button" class="btn btn-danger" onclick="window.location.href='index.php';" value="Cancel">
                              </div>

                         </div>
                    </form>
               </div>
          </div>
</div>
</div>
</div>
</div>
<!-- traemos el compomponente footer -->
<?php include("includes/footer.php") ?>