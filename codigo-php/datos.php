<?php
  if(empty($_SESSION['username'])) { // si no está logueado, pal login!
    header("Refresh: 0; url=index.php");
    die();
  }

  if(!empty($_GET['edit']) || !empty($_POST['id'])){
    require("edit.php"); //manda al archivo edit.php tanto el get como el post para procesarlo dentro
  } else if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST['username'])) {
    // si es un post PEEEERO no es el post del USERNAME.
    require("connect.php"); // pedimos por favor que nos de la conexión SQL
    if (!empty($_POST['titulo']) || !empty($_POST['n_pag']) || !empty($_POST['autor']) || !empty($_POST['edit'])) {
      // Si están todos los campos rellenos (no debería ser tan estricto pero YOLO)
      $sql = $enlace->prepare("INSERT INTO libros(id, titulo, n_pag, autor, editorial) VALUES (NULL, :titulo, :n_pag, :autor, :editorial)");
      $sql->bindParam(':titulo', $_POST['titulo']);
      $sql->bindParam(':n_pag', $_POST['n_pag']);
      $sql->bindParam(':autor', $_POST['autor']);
      $sql->bindParam(':editorial', $_POST['edit']);

      $sql->execute();
      $enlace->query($sql);
      $enlace = null;
    }
    unset($_POST); //limpiamos el post (por si se hace F5 para que no inserte de nuevo)
    header("Location: " . $_SERVER['PHP_SELF']); // reload
  }

  if(!empty($_GET['remove'])) {
    // si llega el remove, muestra el modal del borrar
    echo '<section id="modalborrar">
      <div class="container" id="fondo">
        <h2>¿Estás seguro que quieres borrarlo?</h2>
        <p>¡Una vez borrado no puedes volver atrás!</p>
        <div class="container-row noresp">
          <a href="?remove-surely='.$_GET['remove'].'" class="boton delete">Sí</a>
          <a onclick="cerrarModal(\'modalborrar\')" class="boton">No</a>
        </div>
      </div>
    </section>';
  }

  if(!empty($_GET['remove-surely'])) {
    // en el caso de que se mande este get, hacemos el borrado (normalmente viene del remove previo)
    require("connect.php");
    $sql = $enlace->prepare("DELETE FROM libros where id = :id");
    $sql->bindParam(':id', $_GET['remove-surely']);
    $sql->execute();
    $enlace->query($sql);
    $enlace = null;
  }

  if(!empty($_GET['logout'])) { // cerramos la sesión
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    session_destroy();
    header("Refresh: 0; url=index.php");
  }
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Tus datos</title>
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
          rel="stylesheet">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="/img/wokis.png" sizes="128x128">
  </head>
  <body>
    <header>
      <h1>Tus datos</h1>
      <nav>
        <a class="boton" onclick="mostrarModal();"><i class="far fa-plus-square"></i> Nuevo dato</a>
        <a class="boton" id="left" href="?logout=true"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
      </nav>
    </header>
    <main>
      <section id="modal">
        <form class="" action="." method="post" id="modalform">
          <div class="container-row noresp">
            <h2>Nuevo registro</h2>
            <a onclick="cerrarModal()" id="cerrarModal"><i class="far fa-times-circle"></i></a>
          </div>

          <label for="titulo">Título</label><br>
          <input type="text" id="titulo" name="titulo" value=""><br>

          <label for="n_pag">Número de páginas</label><br>
          <input type="number" id="n_pag" name="n_pag" min="0" value=""><br>

          <label for="autor">Autor</label><br>
          <input type="text" id="autor" name="autor" value=""><br>

          <label for="edit">Editorial</label><br>
          <input type="text" name="edit" id="edit" value=""><br>

          <input type="submit" class="boton" id="enviar" value="Añadir">
        </form>
      </section>

      <section>
        <table>
          <thead>
            <tr>
              <th>Título</th>
              <th>Número de páginas</th>
              <th>Autor</th>
              <th>Editorial</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              require("connect.php");
              $sql = "SELECT * FROM libros";
              $rs = $enlace->query($sql);
              $enlace = null;
              foreach ($rs as $datos) {
                // cada elemento en el query lo mostramos dentro de la pantalla
                echo "<tr>";
                echo "<td data='Título'>" . $datos[1] . "</td>";
                echo "<td data='Número de páginas'>" . $datos[2] . "</td>";
                echo "<td data='Autor'>" . $datos[3] . "</td>";
                echo "<td data='Editorial'>" . $datos[4] . "</td>";
                echo "<td data='Opciones'><a href=?edit=" . $datos[0] . "><i class='far fa-edit'></i></a> <a href=?remove=" . $datos[0] . "><i class='far fa-trash-alt'></i></a></td>";
                echo "</tr>";
              }
            ?>
          </tbody>
        </table>
      </section>
    </main>
    <footer>
      Esta aplicación web ha sido <i class="fas fa-code"></i> con <i class="fas fa-heart"></i> por Cristan.<br>
      Copyright © 2020 Cristian Andrades.<br>
      <a href="https://wokis.es">Web personal.</a>
    </footer>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <script defer src="./js/script.js"></script>
  </body>
</html>
