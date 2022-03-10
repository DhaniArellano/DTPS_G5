<!-- Incluyo el archivo con los datos de conexion, se hace una sola vez -->
<?php include("db.php"); ?>

<!-- Incluyo el archivo especifico para el header -->
<?php include("includes/header.php"); ?>


<!-- Dibujo un div contenedor con un padding (espaciado/distancia a cada lado) de 4 pixeles -->
<div class="container p-4">
     <div class="row">
          <div class="col-md-4">
               <?php
               /*  
               En esta línea recibo por sesión un mensaje siempre y cuando exista la sesion
               Luego de recibir el mensaje muestro su respectivo texto, además se dibua un div con un boton
               Cuando tenga el mensaje, debo mostrar la notificacion con un color, verde es satisfactorio 
               Si por ejemplo hay un error se pone de color rojo
               */
               if (isset($_SESSION['message'])) {
               ?>
                    <!-- Mustro un div de tipo alert, muestro el tipo de mensaje -->
                    <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible">
                         <!-- con el mensaje mostrado, se dibuja una equis para cerrar la notificación -->
                         <button type="button" class="close" data-dismiss="alert">&times;</button>
                         <?= $_SESSION['message'] ?>
                    </div>
                    <!-- Con esta linea limpio los datos de la sesion (Si se va a manejar otro dipo de sesion, 
                    como login se debe cambiar la forma de manipular la sesion, sino, el sistema se cierra) -->
               <?php session_unset();
               } ?>

               <!-- DIbujo un div con estilo de carta/tarjeta para mostrar el formulario -->
               <div class="card card-body">
                    <!-- Estructura del formulario. Se envía a un archivo 'save_vehicle.php' y es enviado por el metodo post
               además se especifica que va a recibir datos de multiples formas (esto para el manejo de los archivos)-->
                    <form action="save_vehicle.php" method="post" enctype="multipart/form-data">
                         <!-- el form-group es una forma de agrupar los campos de un formulario -->
                         <div class="form-group">
                              <input type="text" name="code" class="form-control" placeholder="Code" autofocus>
                         </div>
                         <div class="form-group">
                              <!-- Lista desplegable con los tipos de vehiculos seleccioandos -->
                              <label for="vehicles">Seleccionar el tipo de vehículo:</label>
                              <select name="type">
                                   <option value="car">Carro</option>
                                   <option value="motorcycle">Moto</option>
                                   <!-- <option value="bicycle">Bicicleta</option> -->
                                   <option value="truck">Camion</option>
                              </select>
                         </div>
                         <div class="form-group">
                              <label for="model">Modelo del vehículo</label>
                              <input type="text" name="model" class="form-control" placeholder="Model" autofocus>
                         </div>
                         <div class="form-group">
                              <label for="license_plate">Placa del Vehículo</label>
                              <input type="text" name="license_plate" class="form-control" placeholder="License Plate" autofocus>
                         </div>
                         <div class="form-group">
                              <label for="color">Color del vehículo</label>
                              <input type="color" name="color" class="form-control" placeholder="Color" autofocus>
                         </div>
                         <div class="form-group">
                              <label for="num_passengers">Número de pasajeros</label>
                              <input type="number" min="1" max="4" name="num_passengers" class="form-control" placeholder="Number of
passengers" autofocus>
                         </div>
                         <div class="form-group">
                              <label for="photo">Foto del vehículo</label>
                              <input type="file" name="photoVehicle" class="form-control" placeholder="Image" autofocus>
                              <input type="hidden" name="imgActual" class="form-control" placeholder="Image" autofocus>
                         </div>
                         <div class="form-group">
                              <label for="fuel_type">Tipo de Combustible</label>
                              <input type="text" name="fuel_type" class="form-control" placeholder="Fuel Type">
                         </div>
                         <input type="submit" class="btn btn-success btn-block" name="save_vehicle" value="Save Vehicle">
                    </form>
               </div>
          </div>

          <div class="col-md-8">
               <table class="table table-bordered">
                    <thead>
                         <tr>
                              <th>Code</th>
                              <th>Tipo de vehiculo</th>
                              <th>Modelo</th>
                              <th>Placa</th>
                              <th>Color</th>
                              <th>Numero de pasajeros</th>
                              <th>Foto</th>
                              <th>Tipo Combustible</th>
                              <th>Editar/Borrar</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                         // Consulta hacia la tabla vehicles para traer todos los campos de la tabla
                         $query = "SELECT * FROM vehicles";
                         // Peticion para que se realice la consulta, primero envio la conexion y luego la consulta
                         $resultado = mysqli_query($conn, $query);

                         // Luego de realizar la consulta la guardo en la variable $resultado y recorro los resultados como un arreglo 
                         // Esta instruccion se puede entender como "mientras encuentre datos, almacenelos en un arreglo en la variable $row"
                         while ($row = mysqli_fetch_array($resultado)) { ?>

                              <tr>
                                   <!-- Cuando ya tengo la consulta, empiezo a recorrer el arreglo con el respectivo nombre de la columna
                              que necesite, esta columna es la de la base de datos -->
                                   <!-- Cuando ya he realizado eso, entonces lo dibujo como un td=table data/ dato de una tabla o más bien
                         por una fila dentro de una tabla. Por cada objeto o dato que encuentre, me va a dibujar una fila  -->
                                   <td><?php echo $row['code'];  ?> </td>
                                   <td><?php echo $row['type'];  ?> </td>
                                   <td><?php echo $row['model'];  ?> </td>
                                   <td><?php echo $row['license_plate'];  ?> </td>
                                   <td><?php echo $row['color'];  ?> </td>
                                   <td><?php echo $row['num_passengers'];  ?> </td>

                                   <?php
                                   // Valido si en la consulta la columna photo tiene una url o no
                                   // Es decir, verifico que efectivamente haya una imagen en ese campo
                                   if ($row['photo'] == "") {
                                        // Si el resultado de la consulta no arroja un resultado con imagen, 
                                        // entonces le dibujo una imagen por defecto a esa fila
                                        echo '<td> <img src="http://localhost/DTPS_G5/img/defecto.png" class="img-responsive" width="40px"> </td>';
                                   } else {
                                        // Si por el contrario, encontró una imagen, entonces leo la url y la dibujo 
                                        echo '<td> <img src="http://localhost/DTPS_G5/' . $row["photo"] . '" class="img-responsive" width="40px"> </td>';
                                   }
                                   // Esta linea puede ser utilizada para hacer el edit del registro
                                   echo '<input type="hidden" name="imgActual" value="' . $row["photo"] . '">'
                                   ?>
                                   <!-- Imprimo el tipo de combustible correspondiente al registro -->
                                   <td><?php echo $row['fuel_type'];  ?> </td>
                                   <td>
                                        <!-- Aqui se debe realizar los ajustes respectivos para que funcione el editar -->
                                        <a href="aqui_debe_ir_el_archivo_editar.php" class="btn btn-success">
                                             <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <!-- Aqui se debe realizar los ajustes respectivos para que funcione el borrar -->
                                        <a href="aqui_debe_ir_el_archivo_eliminar.php" class="btn btn-danger">
                                             <span class="glyphicon glyphicon-trash"></span>
                                        </a>

                                   </td>
                              </tr>

                         <?php } ?>

                    </tbody>

               </table>
          </div>

     </div>
</div>








<!-- Se incluye el archivo correspondiente al footer -->

<?php include("includes/footer.php"); ?>