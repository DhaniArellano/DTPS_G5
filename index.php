<!-- Incluyo el archivo con los datos de conexion, se hace una sola vez -->
<?php include("db.php"); ?>

<!-- Incluyo el archivo especifico para el header -->
<?php include("includes/header.php"); ?>

<!-- zona horaria -->

<?php
// Se configura la zona horaria para mostrar la hora.
date_default_timezone_set('America/Bogota');

?>

<div class="content-wrapper">
     <section class="content-header">
          <div class="center">
               <h1 class="center">
                    <p class="text-center">
                         Sistema para la gestion de Vehículos
                    </p>
               </h1>
          </div>
</div>

<div class="container">

     <section class="content">

          <div class="card text-center">
               <div class="card-body">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#RegistrarVehiculo">
                         Registrar Vehículo
                    </button>
               </div>
               <div class="card-footer text-muted">
                    <?php
                    // Imprimir la fecha calendario actual ejemplo 14/03/2022
                    echo "Fecha actual: " . date("d/m/Y");
                    print "<br>";
                    // Imprime la hora actual del sistema. Se debe configurar de acuerdo al pais (Colombia) 
                    echo "Hora actual: " . date("h:i A");

                    ?>
               </div>
          </div>
          <div class="box">
               <hr>
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

                         </div>

                         <div class="col-md-8">

                         </div>

                    </div>
               </div>
               <div class="box-body">

                    <div class="container-fluid">


                         <table class="table table-bordered table-hover table-striped DT">

                              <thead>
                                   <tr>
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
                                             <td><?php echo $row['type'];  ?> </td>
                                             <td><?php echo $row['model'];  ?> </td>
                                             <td><?php echo $row['license_plate'];  ?> </td>
                                             <td>
                                   <input type="color" name="color" class="input-lg" value="<?php echo $row['color']; ?>" disabled>
                                             </td>
                                             <td><?php echo $row['num_passengers'];  ?> </td>

                                             <?php
                                             // Valido si en la consulta la columna photo tiene una url o no
                                             // Es decir, verifico que efectivamente haya una imagen en ese campo
                                             
                                             if ($row['photo'] == "") {
                                                  // Si el resultado de la consulta no arroja un resultado con imagen, 
                                                  // entonces le dibujo una imagen por defecto a esa fila
                                                  echo '<td> <img src="http://localhost/DTPS_G5/img/defecto.png" class="img-responsive" width="40px"> </td>';
                                             } else {
                                                  echo '<td> <img src="http://localhost/DTPS_G5/' . $row["photo"] . '" class="img-responsive" width="40px"> </td>';
                                                  // Si por el contrario, encontró una imagen, entonces leo la url y la dibujo 
                                             }
                                             // Esta linea puede ser utilizada para hacer el edit del registro
                                             echo '<input type="hidden" name="imgActual" value="' . $row["photo"] . '">'
                                             ?>
                                             <!-- Imprimo el tipo de combustible correspondiente al registro -->
                                             <td><?php echo $row['fuel_type'];  ?> </td>
                                             <td>
                                                  <!-- Aqui se debe realizar los ajustes respectivos para que funcione el editar -->
                                                  <a href="edit_vehicle.php?code=<?php echo $row['code']; ?>" class="btn btn-success">
                                                       <span class="glyphicon glyphicon-edit"></span>
                                                  </a>

                                                  <!-- se captura el numero que identifica cada entrada para proceder a eliminarlo -->
                                              <form action="delete.php" method="post">
                                                       <input type="hidden" name="code" value="<?php echo $row['code'] ?>">
                                                      

                                                       <button type="submit" name="delete" class="btn btn-danger" onclick="return ConfirmDelete()" value="DELETE" class="btn btn-danger">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                       </button>
                                                       
                                                  </form>


                                                  <script type="text/javascript">
                                                       function ConfirmDelete() {
                                                            var respuesta = confirm("El vehiculo se eliminara permanentemente");

                                                            if (respuesta == true) {
                                                                 return true;
                                                            } else {
                                                                 return false;
                                                            }

                                                       }
                                                  </script>



                                             </td>
                                        </tr>

                                   <?php } ?>

                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </section>

</div>


<div class="modal fade" rol="dialog" id="RegistrarVehiculo">

     <div class="modal-dialog">

          <div class="modal-content">

               <!-- Estructura del formulario. Se envía a un archivo 'save_vehicle.php' y es enviado por el metodo post
               además se especifica que va a recibir datos de multiples formas (esto para el manejo de los archivos)-->
               <form action="save_vehicle.php" method="POST" role="form" enctype="multipart/form-data">

                    <div class="modal-body">

                         <div class="box-body">

                              <!-- el form-group es una forma de agrupar los campos de un formulario -->
                              <div class="form-group">
                                   <!-- Lista desplegable con los tipos de vehiculos seleccioandos -->
                                   <label for="vehicles">Seleccionar el tipo de vehículo:</label>
                                   <select name="type" required>
                                        <option value=""></option>
                                        <option value="Autobus">Autobus</option>
                                        <option value="Carro">Carro</option>
                                        <option value="Camion">Camion</option>
                                        <option value="Camioneta">Camioneta</option>
                                        <option value="Microbus">Microbus</option>
                                        <option value="Motocicleta">Moto</option>
                                   </select>
                              </div>
                              <div class="form-group">
                                   <label for="model">Modelo del vehículo</label>
                                   <input type="text" name="model" class="form-control" placeholder="Model" required>
                              </div>
                              <div class="form-group">
                                   <label for="license_plate">Placa del Vehículo</label>
                                   <input type="text" name="license_plate" class="form-control" placeholder="License Plate" required>
                              </div>
                              <div class="form-group">
                                   <label for="color">Color del vehículo</label>
                                   <input type="color" name="color" class="form-control" placeholder="Color" required>
                              </div>
                              <div class="form-group">
                                   <label for="num_passengers">Número de pasajeros</label>
                                   <input type="number" min="1" name="num_passengers" class="form-control" placeholder="Number of passengers" required>
                              </div>
                              <div class="form-group">
                                   <label for="photo">Foto del vehículo</label>
                                   <input type="file" name="photoVehicle" class="form-control" placeholder="Image" required>
                                   <input type="hidden" name="imgActual" class="form-control" placeholder="Image" required>
                              </div>
                              <div class="form-group">
                                   <label for="fuel_type">Tipo de Combustible</label>
                                   <select name="fuel_type" required>
                                        <option value="gasolina">Gasolina</option>
                                        <option value="diesel">Diésel</option>
                                        <option value="etanol">Etanol</option>
                                        <option value="hidrogeno">Hidrógeno</option>
                                        <option value="biodiesel">Biodiesel</option>
                                        <option value="electricidad">Electricidad</option>
                                        <option value="metanol">Metanol</option>
                                        <option value="gas natural">Gas Natural</option>
                                        <option value="GLP">GLP</option>
                                   </select>
                              </div>
                         </div>

                    </div>
                    <div class="modal-footer">
                         <input type="submit" class="btn btn-success" name="save_vehicle" value="Guardar">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>  
                    </div>
               </form>
          </div>
     </div>
</div>
</div>








<!-- Se incluye el archivo correspondiente al footer -->

<?php include("includes/footer.php"); ?>