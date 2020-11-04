<?php
  session_start();
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>CRUD</title>
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
          rel="stylesheet">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="/img/wokis.png" sizes="128x128">
  </head>
  <body>
    <?php
      if (empty($_POST) && empty($_SESSION)) {
        // en caso de no haber sesión y estar el post vacío, muestra el formulario
        echo '<section class="loginbg">
                <div id="cont-bg">
                  <img src="./img/bg.png" alt="Imagen vectorial de fondo" class="bg">
                </div>
                <form class="login" action="." method="post" autocomplete="on">
                  <h1>Inicia sesión</h1>
                  <label for="username">Nombre de usuario</label><br>
                  <input type="text" id="username" name="username" value=""><br>
                  <label for="pass">Contraseña</label><br>
                  <input type="password" id="pass" name="pass" value=""><br>
                  <input type="submit" class="boton" name="" value="Acceder">
                </form>
              </section>';
      } else if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['pass']) && empty($_SESSION)) {
        // Comprobación en caso de que no esté el post vacio ni sus campos.
        // Se hace la comprobación en la base de datos, si los datos están bien
        // se procede a crear los datos de la sesión y acceder al CRUD.
        require("connect.php");
        $sql = "SELECT * FROM users";
        $rs = $enlace->query($sql);
        $correcto = false;

        foreach ($rs as $user) {
          if ($_POST['username'] == $user[1] && $_POST['pass'] == $user[2]) {
            $correcto = true;
          }
        }

        if ($correcto) {
          $_SESSION['username'] = $_POST['username'];
          $_SESSION['passw'] = $_POST['pass'];
          require_once('datos.php');
        } else {
          echo '<img src="./img/bg.png" alt="Imagen vectorial de fondo" class="bg">
                <section class="loginbg">
                  <form class="login" action="." method="post" autocomplete="on">
                    <h1>Inicia sesión</h1>
                    <p class="error">El usuario o la contraseña es incorrecta.</p>
                    <label for="username">Nombre de usuario</label><br>
                    <input type="text" id="username" name="username" value="' . $_POST['username'] . '"><br>
                    <label for="pass">Contraseña</label><br>
                    <input type="password" id="pass" name="pass" value=""><br>
                    <input type="submit" class="boton" name="" value="Acceder">
                  </form>
                </section>
                ';
          unset($_POST);
        }
        $enlace = null;
      } else if (!empty($_SESSION)) {
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
          /*
            Comprueba si ha pasado más de 30 minutos desde la última sesióno
            En caso de ser así, caduca la sesión y recarga la página para que tenga
            que volver a iniciar sesión.
          */
          session_unset(); // limpia $_SESSION
          session_destroy();   // elimina toda la información guardada de la sesión.
          header("Refresh: 0; url=index.php"); // recarga la página.
        } else {
          require_once('datos.php');
        }
        $_SESSION['LAST_ACTIVITY'] = time(); // actualiza la última actividad
      } else {
        unset($_POST);
        header("Location: " . $_SERVER['PHP_SELF']);
      }
    ?>
  </body>
</html>
