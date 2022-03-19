<!-- Incluyo el archivo con los datos de conexion, se hace una sola vez -->
<?php
include("db.php");
$type = '';
$model = '';
$license_plate = '';
$color = '';
$num_passengers = '';
$fuel_type = '';


if (isset($_GET['code'])) {
     $code = $_GET['code'];
     $query = "SELECT * FROM vehicles WHERE code=$code";
     $result = mysqli_query($conn, $query);
     if (mysqli_num_rows($result) == 1) {
          $row = mysqli_fetch_array($result);
          $type = $row['type'];
          $model = $row['model'];
          $license_plate = $row['license_plate'];
          $color = $row['color'];
          $num_passengers = $row['num_passengers'];
          $fuel_type = $row['fuel_type'];
     }
}

if (isset($_POST['update'])) {
     $code = $_GET['code'];
     $type = $_POST['type'];
     $model = $_POST['model'];
     $license_plate = $_POST['license_plate'];
     $color = $_POST['color'];
     $num_passengers = $_POST['num_passengers'];
     $fuel_type = $_POST['fuel_type'];

     $query = "UPDATE vehicles SET type = '$type', model = '$model', license_plate = '$license_plate', color = '$color', num_passengers = '$num_passengers', fuel_type = '$fuel_type' WHERE code = $code";
     mysqli_query($conn, $query);
     $_SESSION['message'] = 'Vehicle Updated Successfully';
     $_SESSION['message_type'] = 'warning';
     header('Location: index.php');
}
?>
<?php include("includes/header.php") ?>

<div class="container p-4">
     <div class="row">
          <div class="col-md-4 mx-auto">
               <div class="card card-body">
                    <form action="edit_vehicle.php?code=<?php echo $_GET['code']; ?>" method="POST">
                         <div class="form-group">
                              <label for="code">Codigo</label>
                              <input name="code" type="text" class="form-control" value="<?php echo $code; ?>" disabled>
                         </div>
                         <div class="form-group">
                              <label for="type">Tipo de vehiculo</label>
                              <select name="type" class="form-control" required>
                                        <option selected value="<?php echo $type;?>"><?php echo $type;?></option>
                                        <option value="Autobus">Autobus</option>
                                        <option value="Carro">Carro</option>
                                        <option value="Camion">Camion</option>
                                        <option value="Camioneta">Camioneta</option>
                                        <option value="Microbus">Microbus</option>
                                        <option value="Motocicleta">Moto</option>
                              </select>
                              <!--<input name="type" type="text" class="form-control" value="<?php echo $type; ?>" placeholder="Update Model">-->
                         </div>
                         <div class="form-group">
                              <label for="model">Modelo del vehiculo</label>
                              <input name="model" type="text" class="form-control" value="<?php echo $model; ?>" placeholder="Update Model">
                         </div>
                         <div class="form-group">
                              <label for="license_plate">Placa del vehiculo</label>
                              <input name="license_plate" type="text" class="form-control" value="<?php echo $license_plate; ?>" placeholder="Update Plate">
                         </div>
                         <div class="form-group">
                              <label for="num_passengers">Color del vehiculo</label>
                              <input type="color" name="color" class="form-control" value="<?php echo $color; ?>">
                         </div>
                         <div class="form-group">
                              <label for="num_passengers">Numero de pasajeros</label>
                              <input name="num_passengers" type="text" class="form-control" value="<?php echo $num_passengers; ?>" placeholder="Update passengers">
                         </div>
                         <div class="form-group">
                              <label for="fuel_type">Tipo de Combustible</label>
                              <br>
                              <select name="fuel_type" class="form-control" aria-label="Default select example">
                                   <option selected value="<?php echo $fuel_type;?>"><?php echo $fuel_type;?></option>
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
                              <!--<input name="fuel_type" type="text" class="form-control" value="<?php echo $fuel_type; ?>" placeholder="Update fuel">-->
                         </div>
                         <button class="btn btn-success" name="update">Update</button>
                         <a href="index.php" class="btn btn-danger">Cancel</a>
                         <!--<input type="button" class="btn btn-danger" onclick="window.location.href='index.php';" value="Cancel"-->
                    </form>
               </div>
          </div>
     </div>
</div>
<?php include("includes/footer.php") ?>