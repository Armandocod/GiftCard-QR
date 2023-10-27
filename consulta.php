<?php
get_header();
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="icon" href="logo.png">
   <title>Verificación de Código</title>
   <style>
      h1.titulo
      {
         text-align: center;
         font-family: Arial, Helvetica, sans-serif;
         font-size: 80px;
      }
      .img_tecnica
      {
         width: 100%; /* La imagen ocupará el 100% del ancho disponible */
         height: auto; /* La altura se ajustará proporcionalmente */
         max-width: 400px; /* Establece un tamaño máximo para la imagen */
         margin: 10px;
         /* Agrega aquí más estilos según tus necesidades */
         display: block; /* Asegura que la imagen se comporte como un bloque */
         margin-left: auto; /* Margen izquierdo automático */
         margin-right: auto; /* Margen derecho automático */
      }
      .info
      {
         font-family: Arial, Helvetica, sans-serif;
         font-size: 60px;
         text-align: center;
      }
      .btn_utilizar
      {
         display: block;
         margin: 20px auto;
         padding: 10px 20px;
         background-color: #4CAF50;
         color: white;
         border: none;
         border-radius: 10px;
         cursor: pointer;
         font-size: 50px;
      }
   </style>
</head>
<body>
   <h1 class ="titulo">Verificación de Código</h1>

   <?php
   // Obtener el dato enviado desde el formulario
   if (isset($_POST['codigo'])) {
      $dato = $_POST['codigo'];

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

      // Escapar el dato para prevenir inyecciones SQL (opcional, dependiendo del contexto)
      $dato = $conn->real_escape_string($dato);

      // Realizar la consulta en la base de datos
      $sql = "SELECT codigo, Utilizado,Tecnica,Fecha,Vencido FROM `BD` WHERE codigo = '$dato'";
      $result = $conn->query($sql);

      // Verificar si se encontraron resultados
      if ($result !== false && $result->num_rows > 0) {
         // Existe un valor en la columna "codigo"
         $row = $result->fetch_assoc();
         $codigo = $row["codigo"];
         $utilizado = $row["Utilizado"];
         $tecnica = $row["Tecnica"];
         $fecha = $row["Fecha"];
         $vencido = $row ["Vencido"];


         if($utilizado === 'Si')
         {
            echo "<script>alert('Esta Gift Card ya se utilizo'); window.location.href = 'index.html';</script>";
         }
         else if($vencido === 'Si')
         {
            echo "<script>alert('Esta Gift Card a Vencido'); window.location.href = 'index.html';</script>";
         }

         // Mostrar el valor actual en la columna "Utilizado"
         echo "<p class='info'>Código: " . $codigo . "</p>";
         echo "<p class='info'>Utilizado: " . $utilizado . "</p>";
         echo "<p class='info'>Fecha de Compra: " . $fecha . "</p>";
         echo "<p class='info'>Tecnica: " . $tecnica . "</p>";
         echo '<img src="' . $img . '" alt="Imagen" class="img_tecnica" style="max-width: 70%; height: auto;">';

         // Mostrar el botón para cambiar el valor en la columna "Utilizado"
         echo '<form action="actualizado.php" method="post">';
         echo '<input type="hidden" name="codigo" value="' . $codigo . '">';
         echo '<input type="submit" class="btn_utilizar" value="Utilizar">';
         echo '</form>';
      } else {
         // No se encontró un valor en la columna "codigo"
         echo "<p>El valor no existe en la base de datos.</p>";
      }

      // Cerrar la conexión a la base de datos
      $conn->close();
   }
   ?>
</body>
</html>

<?php
get_footer();
?>