<?php  
  try {
      $enlace = new PDO("mysql:host=db;dbname=ejerciciosphp", "alumnado", "pestillo");
      $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
      die('Error: ' . $e->getMessage());
  }

?>
