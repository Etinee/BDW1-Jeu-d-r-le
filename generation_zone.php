<!--
Projet LIFBDW1 2020
Eglantine Kremer-Cochet p1811188
Kevin Anguelov p1702375
-->

<!DOCTYPE html>
<html>


  <head>
    <meta charset="utf-8">
    <title>Jeu d'rôle</title>
    <link rel="shortcut icon" type="image/png" href="img/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/template.css">
    <link rel="stylesheet" type="text/css" href="css/body.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>


  <body>
    <!-- Header -->
    <?php include('static/header.html') ?>

    <!-- Menu -->
    <?php include('static/nav.html') ?>

    <div class="contenu">

      <h2>Générer une zone</h2>

      <!-- Formulaire -->
      <form class="param_zone" action="generation_zone.php" method="post">

        <!-- Formulaire environnement -->
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Environnement</label>
          </div>
          <select class="custom-select" name="Environnement" id="inputGroupSelect01">
            <option selected>Choose...</option>
            <option value="0">Donjon en ruine</option>
            <option value="1">Colline</option>
            <option value="2">Plaine</option>
            <option value="3">Océan</option>
            <option value="4">Montagne</option>
            <option value="5">Urbain</option>
            <option value="6">Sous-terrain</option>
            <option value="7">Marais</option>
            <option value="8">Désert</option>
          </select>
        </div>

        <!-- Formulaire Dimensions -->
        <table>
          <tr>
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Dimensions </span>
                </div>
                <input type="number" name="dim_x" min="1" max="20" placeholder="horizontal" class="form-control" value="<?php if (isset($_POST['dim_x'])){echo $_POST['dim_x'];}else{echo "12";} ?>">
                <input type="number" name="dim_y" min="1" max="20" placeholder="vertical" class="form-control" value="<?php if (isset($_POST['dim_y'])){echo $_POST['dim_y'];}else{echo "8";} ?>">
              </div>
            </td>
            <td>

              <!-- Formulaire équipements -->
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Équipements </span>
                </div>
                <!-- peut être cool de faire un count de la bdd et de mettre cette variable en max -->
                <input type="number" name="equipement_min" min="1" max="20" placeholder="min" class="form-control" value="<?php if (isset($_POST['equipement_min'])){echo $_POST['equipement_min'];}else{echo "1";} ?>">
                <input type="number" name="equipement_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['equipement_max'])){echo $_POST['equipement_max'];}else{echo "10";} ?>">
              </div>
            </td>
          </tr>

          <!-- Formualaire mobiliers -->
          <tr>
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Mobiliers </span>
                </div>
                <input type="number" name="mobilier_min" min="1" max="20" placeholder="min" class="form-control" value="<?php if (isset($_POST['mobilier_min'])){echo $_POST['mobilier_min'];}else{echo "1";} ?>">
                <input type="number" name="mobilier_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['mobilier_max'])){echo $_POST['mobilier_max'];}else{echo "10";} ?>">
              </div>
            </td>

            <!-- Formulaire pièges -->
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Pièges </span>
                </div>
                <input type="number" name="piege_min" min="1" max="20" placeholder="min" class="form-control" value="<?php if (isset($_POST['piege_min'])){echo $_POST['piege_min'];}else{echo "1";} ?>">
                <input type="number" name="piege_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['piege_max'])){echo $_POST['piege_max'];}else{echo "10";} ?>">
              </div>
            </td>
          </tr>

          <!-- Formulaire créatures -->
          <tr>
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Créatures </span>
                </div>
                <input type="number" name="creature_min" min="1" max="20" placeholder="min" class="form-control" value="<?php if (isset($_POST['creature_min'])){echo $_POST['creature_min'];}else{echo "1";} ?>">
                <input type="number" name="creature_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['creature_max'])){echo $_POST['creature_max'];}else{echo "10";} ?>">
              </div>
            </td>

            <!-- Formulaire PNJ -->
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">PNJ </span>
                </div>
                <input type="number" name="pnj_min" min="1" max="20" placeholder="min" class="form-control" value="<?php if (isset($_POST['pnj_min'])){echo $_POST['pnj_min'];}else{echo "1";} ?>">
                <input type="number" name="pnj_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['pnj_max'])){echo $_POST['pnj_max'];}else{echo "10";} ?>">
              </div>
            </td>
          </tr>
        </table>

        <!-- Formulaire description -->
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Description</span>
          </div>
          <input type="text" name="description" class="form-control" maxlength="250" size="50"
           placeholder="Rédiger une courte description de la zone que vous souhaitez créer. "
           aria-label="Username" aria-describedby="basic-addon1" value="<?php if (isset($_POST['description'])){echo $_POST['description'];} ?>">
        </div>
        <br>

        <!-- Bouton de soumission du formulaire -->
        <input type="submit" name="submit" value="Générer la zone" class="btn btn-dark">
      </form>
      <br>

      <!-- Fin du formulaire -->


      <?php
      include('php/fonctions.php');

      if(isset($_POST['submit'])){

        // Calcul du nombre pour chacun des éléments, compris dans la fourchette soumise dans le formulaire
        $nb_equipements=rand((int)$_POST['equipement_min'],(int)$_POST['equipement_max']);
        $nb_mobiliers=rand((int)$_POST['mobilier_min'],(int)$_POST['mobilier_max']);
        $nb_pieges=rand((int)$_POST['piege_min'],(int)$_POST['piege_max']);
        $nb_creatures=rand((int)$_POST['creature_min'],(int)$_POST['creature_max']);
        $nb_pnj=rand((int)$_POST['pnj_min'],(int)$_POST['pnj_max']);

        // Vérification qu'il y a suffisamment de cases sur la carte pour tous les éléments
        $nb_cases=$_POST['dim_x']*$_POST['dim_y'];
        $somme=$nb_pnj+$nb_pieges+$nb_creatures+$nb_mobiliers+$nb_equipements;
        if($somme>$nb_cases){
          echo "<p>Il y a trop d'éléments dans la zone. Entrez de nouvelles valeurs. </p>";
        }else{

          $bd="p1811188";
          $connexion=connectBD($bd);
          $idZone=generation_zone($_POST['dim_x'], $_POST['dim_y'], $_POST['description'], $_POST['Environnement'],$_POST ,$connexion);
          mysqli_close($connexion);
        }
      }

      ?>
    </div>
    <?php include('static/footer.html') ?>
  </body>
</html>
