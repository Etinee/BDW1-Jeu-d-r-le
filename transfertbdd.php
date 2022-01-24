<!--
Projet LIFBDW1 2020
Eglantine Kremer-Cochet p1811188
Kevin Anguelov p1702375
-->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>map generator</title>
    <link rel="shortcut icon" type="image/png" href="img/logo.png">
    <link rel="stylesheet" type="text/css" href="css/template.css">
    <link rel="stylesheet" type="text/css" href="css/body.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
  <body>
    <?php include('static/header.html') ?>
    <?php include('static/nav.html') ?>
    <div class="contenu">
      <h2>Remplissage de la base de données</h2>
      <?php
        include("php/fonctions.php");
        $bd_dataset ="dataset";
        $ma_bd ="p1811188";
        transfert_bdd($bd_dataset, $ma_bd);
         ?>

    </div>
    <?php include('static/footer.html') ?>
  </body>
</html>
