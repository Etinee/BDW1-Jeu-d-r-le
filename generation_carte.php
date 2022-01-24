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
      <!-- Appel au fichier fonctions.php contenant toutes les fonctions nécessaires -->
      <?php include('php/fonctions.php'); ?>
      <h2>Générer une carte </h2>

      <!-- FORMULAIRE -->
      <form class="param_carte" action="generation_carte.php" method="post">

        <table>
          <tr>
            <!-- Formulaire nom de la carte -->
            <td>
              <div class="input-group">
               <div class="input-group-prepend">
                 <div class="input-group-text">nom</div>
               </div>
               <input type="text" name="nom" class="form-control" id="" placeholder="Nom de la carte" value="<?php if (isset($_POST['nom'])){echo $_POST['nom'];} ?>">
              </div>
            </td>
            <!-- Formulaire contributeur -->
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Contributeur</label>
                </div>
                <select class="custom-select" name="Contributeur" id="inputGroupSelect01">
                  <option selected>Choose...</option>
                  <?php
                  $bd="p1811188";
                  $connexion=connectBD($bd);
                  $requete_select="SELECT `idUser`,`nom`,`prenom` FROM `contributeur`";
                  $resultat=mysqli_query($connexion, $requete_select);
                  foreach ($resultat as $contributeur) {
                    echo "<option value='".$contributeur['idUser']."'>".$contributeur['prenom']." ".$contributeur['nom']."</option>";
                  }
                  mysqli_close($connexion);
                   ?>
                </select>
              </div>
            </td>
          </tr>
          <!-- Formulaire nombre de zones-->
          <tr>
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Nombre de Zones </span>
                </div>
                <input type="number" name="zone_min" min="1" max="20" placeholder="min" class="form-control" value="<?php if (isset($_POST['zone_min'])){echo $_POST['zone_min'];}else {echo "4";} ?>">
                <input type="number" name="zone_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['zone_max'])){echo $_POST['zone_max'];}else {echo "10";} ?>">
              </div>
            </td>
            <!-- Formulaire Dimensions minimales -->
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Dimensions minimales </span>
                </div>
                <!-- peut être cool de faire un count de la bdd et de mettre cette variable en max -->
                <input type="number" name="dim_x_min" min="1" max="20" placeholder="horizontal" class="form-control" value="<?php if (isset($_POST['dim_x_min'])){echo $_POST['dim_x_min'];}else{echo "4";} ?>">
                <input type="number" name="dim_y_min" min="1" max="20" placeholder="vertical" class="form-control" value="<?php if (isset($_POST['dim_y_min'])){echo $_POST['dim_y_min'];}else{echo "4";} ?>">
              </div>
            </td>
          </tr>
          <!-- Formulaire dimensions maximales -->
          <tr>
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Dimensions maximales </span>
                </div>
                <input type="number" name="dim_x_max" min="1" max="20" placeholder="horizontal" class="form-control" value="<?php if (isset($_POST['dim_x_max'])){echo $_POST['dim_x_max'];}else{echo "10";} ?>">
                <input type="number" name="dim_y_max" min="1" max="20" placeholder="vertical" class="form-control" value="<?php if (isset($_POST['dim_y_max'])){echo $_POST['dim_y_max'];}else{echo "10";} ?>">
              </div>
            </td>
            <!-- Formulaire équipement -->
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Équipements </span>
                </div>
                <!-- peut être cool de faire un count de la bdd et de mettre cette variable en max -->
                <input type="number" name="equipement_min" min="1" max="20" placeholder="min" class="form-control" value="<?php if (isset($_POST['equipement_min'])){echo $_POST['equipement_min'];}else{echo "1";} ?>">
                <input type="number" name="equipement_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['equipement_max'])){echo $_POST['equipement_max'];}else{echo "5";} ?>">
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
                <input type="number" name="mobilier_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['mobilier_max'])){echo $_POST['mobilier_max'];}else{echo "5";} ?>">
              </div>
            </td>

            <!-- Formulaire pièges -->
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Pièges </span>
                </div>
                <input type="number" name="piege_min" min="1" max="20" placeholder="min" class="form-control" value="<?php if (isset($_POST['piege_min'])){echo $_POST['piege_min'];}else{echo "1";} ?>">
                <input type="number" name="piege_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['piege_max'])){echo $_POST['piege_max'];}else{echo "5";} ?>">
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
                <input type="number" name="creature_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['creature_max'])){echo $_POST['creature_max'];}else{echo "5";} ?>">
              </div>
            </td>

            <!-- Formulaire PNJ -->
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">PNJ </span>
                </div>
                <input type="number" name="pnj_min" min="1" max="20" placeholder="min" class="form-control" value="<?php if (isset($_POST['pnj_min'])){echo $_POST['pnj_min'];}else{echo "1";} ?>">
                <input type="number" name="pnj_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['pnj_max'])){echo $_POST['pnj_max'];}else{echo "5";} ?>">
              </div>
            </td>
          </tr>

          <!-- Formulaire zones reliées -->
          <!--
          <tr>
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Nombre moyen de zones reliées à une zone donnée </span>
                </div>
                <input type="number" name="reliees_min" min="1" max="4" placeholder="min" class="form-control" value="<?php if (isset($_POST['reliees_min'])){echo $_POST['reliees_min'];} ?>">
                <input type="number" name="reliees_max" min="1" max="4" placeholder="max" class="form-control" value="<?php if (isset($_POST['reliees_max'])){echo $_POST['reliees_max'];} ?>">
              </div>
            </td>
            -->
            <!-- Formulaire passage secret -->
            <!--
            <td>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="">Passages secrets</span>
                </div>
                <input type="number" name="ps_min" min="1" max="20" placeholder="min" class="form-control" value="<?php if (isset($_POST['ps_min'])){echo $_POST['ps_min'];} ?>">
                <input type="number" name="ps_max" min="1" max="20" placeholder="max" class="form-control" value="<?php if (isset($_POST['ps_max'])){echo $_POST['ps_max'];} ?>">
              </div>
            </td>
          </tr>
          -->
        </table>

        <!-- Formulaire description -->
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Description</span>
          </div>
          <input type="text" name="description" class="form-control" maxlength="250" size="50" placeholder="Rédiger une courte description de la zone que vous souhaitez créer. "
                 aria-label="Username" aria-describedby="basic-addon1" value="<?php if (isset($_POST['description'])){echo $_POST['description'];} ?>">
        </div>

        <!-- formulaire objectif -->
        <div class="input-group">
          <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Objectif</label>
          </div>
          <select class="custom-select" name="objectif" id="inputGroupSelect01">
            <option selected value="equipement">Trouver un équipement</option>
            <option value="zone">Atteindre une zone</option>
          </select>
        </div>
        <br>

        <!-- formulaire environnement -->
        <fieldset style="text-align: center">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="0" name="environnement[]" value="0" checked>
            <label class="form-check-label" for="0">Donjon en ruine</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="1" name="environnement[]" value="1" checked>
            <label class="form-check-label" for="1">Colline</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="2" name="environnement[]" value="2" checked>
            <label class="form-check-label" for="2">Plaine</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="3" name="environnement[]" value="3" checked>
            <label class="form-check-label" for="3">Océan</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="4" name="environnement[]" value="4" checked>
            <label class="form-check-label" for="4">Montagne</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="5" name="environnement[]" value="5" checked>
            <label class="form-check-label" for="5">Urbain</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="6" name="environnement[]" value="6" checked>
            <label class="form-check-label" for="6">Souterrain</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="7" name="environnement[]" value="7" checked>
            <label class="form-check-label" for="7">Marais</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="8" name="environnement[]" value="8" checked>
            <label class="form-check-label" for="8">Désert</label>
          </div>
        </fieldset>
        <br>

        <!-- Bouton de soumission du formulaire -->
        <input type="submit" name="submit" value="Générer la carte" class="btn btn-dark">

      </form>
      <br>

      <?php
      //si le formulaire a été soumis
        if (isset($_POST['submit'])) {
          //connexion à la bdd
          $bd="p1811188";
          $connexion=connectBD($bd);
          // on génère la carte
          $idCarte=generation_carte($_POST['zone_min'], $_POST['zone_max'], $_POST['environnement'], $_POST['dim_x_min'], $_POST['dim_x_max'], $_POST['dim_y_min'], $_POST['dim_y_max'], $_POST['nom'], $_POST['description'],$_POST ,$connexion);
          // on se déconnecte de la bdd 
          mysqli_close($connexion);
        }
       ?>
    </div>
    <?php include('static/footer.html') ?>
  </body>
</html>
