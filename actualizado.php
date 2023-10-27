<?php
// Obtener el código enviado desde el formulario
if (isset($_POST['codigo'])) {
   $codigo = $_POST['codigo'];

   // Realizar la conexión a la base de datos
   $servername = "127.0.0.1";
   $username = "root";
   $password = "";
   $dbname = "BD";

   $conn = new mysqli($servername, $username, $password, $dbname);

   // Verificar la conexión
   if ($conn->connect_error) {
      die("Error en la conexión a la base de datos: " . $conn->connect_error);
   }

   $fecha = date("d/m/Y");
   // Actualizar el valor en la columna "Utilizado"
   $sql = "UPDATE bbl_GiftCards SET Utilizado = 'Si', Fecha_u = '" . $fecha . "' WHERE codigo = '$codigo'";
   $result = $conn->query($sql);

   if ($result === true) {
      echo "<script>alert('Esta GiftCard se Valido Correctamente'); window.location.href = 'index.html';</script>";
      
   } else {
      echo "Comunicar el error al Administrador: " . $conn->error;
   }

   // Cerrar la conexión a la base de datos
   $conn->close();
}
?>