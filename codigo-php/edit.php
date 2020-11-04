<?php
  if(empty($_SESSION['username'])) {
    header("Refresh: 0; url=index.php");
    die();
  }

  try {
      require("connect.php");

      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // si es por post, hacemos los cambios en la base
        $sql = $enlace->prepare("UPDATE libros SET titulo = :titulo, n_pag = :n_pag, autor = :autor, editorial = :editorial WHERE id = :id");
        $sql->bindParam(':id', $_POST['id']);
        $sql->bindParam(':titulo', $_POST['titulo']);
        $sql->bindParam(':n_pag', $_POST['n_pag']);
        $sql->bindParam(':autor', $_POST['autor']);
        $sql->bindParam(':editorial', $_POST['edit']);

        $sql->execute();
        $rs = $enlace->query($sql);
      } else if(!empty($_GET['edit'])) {
        // Si lo recibimos por get, mostramos el formulario con las cosas ya escritas
        $sql = "SELECT * FROM libros where id = " . $_GET['edit'];
        $rs = $enlace->query($sql);
        foreach ($rs as $libro) {
          echo '
          <section id="modal2">
            <form class="" action="." method="post" id="modalform">
              <div class="container-row noresp">
                <h2>Editar registro</h2>
                <a onclick="cerrarModal(\'modal2\')"><i class="far fa-times-circle"></i></a>
              </div>
              <input type="text" id="invisible" name="id" style="display:none" value="' . $libro[0] . '">
              <label for="titulo">Título</label><br>
              <input type="text" id="titulo" name="titulo" value="' . $libro[1] . '"><br>

              <label for="n_pag">Número de páginas</label><br>
              <input type="number" id="n_pag" name="n_pag" min="0" value="' . $libro[2] . '"><br>

              <label for="autor">Autor</label><br>
              <input type="text" id="autor" name="autor" value="' . $libro[3] . '"><br>

              <label for="edit">Editorial</label><br>
              <input type="text" name="edit" id="edit" value="' . $libro[4] . '"><br>

              <input type="submit" class="boton" id="enviar" value="Editar">
            </form>
          </section>
          ';
        }
      }

  } catch(PDOException $e) {
      die('Error: ' . $e->getMessage());
  }
  $enlace = null;
 ?>
