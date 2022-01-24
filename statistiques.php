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
      <h2>Statistiques</h2>
      <h3>Les éléments les plus utilisés</h3>
      <?php
      include('php/fonctions.php');
      $bd="p1811188";
      $connexion=connectBD($bd);
      /*
      $requete="SELECT COUNT(idPiege) AS nbPiege, detecter FROM Piege GROUP BY detecter ";
      $resultat=mysqli_query($connexion, $requete);
      foreach ($resultat as $ligne) {
        echo $ligne['nbPiege']." : ".$ligne['detecter']."<br>";
      }
      */

      ?>
      <div class="statistiques">

        <table>
          <tr>
            <td>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">TOP</th>
                    <th scope="col">Équipements</th>
                    <th scope="col">Nombre</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $requete="SELECT nom, COUNT(c.idContient) AS nb FROM `Contient` AS c NATURAL JOIN `Equipement` GROUP BY c.idEquipement ORDER BY nb DESC LIMIT 5 ";
                  $resultat=mysqli_query($connexion, $requete);
                  $i=1;
                  foreach ($resultat as $ligne) {
                    echo "<tr>";
                    echo "<th scope='row'>".$i."</th>";
                    echo "<td>".$ligne['nom']."</td>";
                    echo "<td>".$ligne['nb']."</td>";
                    echo "</tr>";
                    $i++;
                  }
                   ?>
                </tbody>
              </table>
            </td>

            <td>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">TOP</th>
                    <th scope="col">Mobiliers</th>
                    <th scope="col">Nombre</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $requete="SELECT nom, COUNT(c.idContient) AS nb FROM `Contient` AS c NATURAL JOIN `Mobilier` GROUP BY c.idMobilier ORDER BY nb DESC LIMIT 5 ";
                  $resultat=mysqli_query($connexion, $requete);
                  $i=1;
                  foreach ($resultat as $ligne) {
                    echo "<tr>";
                    echo "<th scope='row'>".$i."</th>";
                    echo "<td>".$ligne['nom']."</td>";
                    echo "<td>".$ligne['nb']."</td>";
                    echo "</tr>";
                    $i++;
                  }
                   ?>
                </tbody>
              </table>
            </td>

            <td>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">TOP</th>
                    <th scope="col">Pièges</th>
                    <th scope="col">Nombre</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $requete="SELECT nom, COUNT(c.idContient) AS nb FROM `Contient` AS c NATURAL JOIN `Piege` GROUP BY c.idPiege ORDER BY nb DESC LIMIT 5 ";
                  $resultat=mysqli_query($connexion, $requete);
                  $i=1;
                  foreach ($resultat as $ligne) {
                    echo "<tr>";
                    echo "<th scope='row'>".$i."</th>";
                    echo "<td>".$ligne['nom']."</td>";
                    echo "<td>".$ligne['nb']."</td>";
                    echo "</tr>";
                    $i++;
                  }
                   ?>
                </tbody>
              </table>
            </td>
          </tr>
        </table>

        <table>
          <tr>
            <td>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">TOP</th>
                    <th scope="col">Créatures</th>
                    <th scope="col">Nombre</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $requete="SELECT nom, COUNT(r.idRencontre) AS nb FROM `Rencontre` AS r NATURAL JOIN `Creature` GROUP BY r.idCreature ORDER BY nb DESC LIMIT 5 ";
                  $resultat=mysqli_query($connexion, $requete);
                  $i=1;
                  foreach ($resultat as $ligne) {
                    echo "<tr>";
                    echo "<th scope='row'>".$i."</th>";
                    echo "<td>".$ligne['nom']."</td>";
                    echo "<td>".$ligne['nb']."</td>";
                    echo "</tr>";
                    $i++;
                  }
                   ?>
                </tbody>
              </table>
            </td>

            <td>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">TOP</th>
                    <th scope="col">PNJ</th>
                    <th scope="col">Nombre</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $requete="SELECT nom, COUNT(r.idRencontre) AS nb FROM `Rencontre` AS r NATURAL JOIN `PNJ` GROUP BY r.idPNJ ORDER BY nb DESC LIMIT 5 ";
                  $resultat=mysqli_query($connexion, $requete);
                  $i=1;
                  foreach ($resultat as $ligne) {
                    echo "<tr>";
                    echo "<th scope='row'>".$i."</th>";
                    echo "<td>".$ligne['nom']."</td>";
                    echo "<td>".$ligne['nb']."</td>";
                    echo "</tr>";
                    $i++;
                  }
                   ?>
                </tbody>
              </table>
            </td>
          </tr>
        </table>

      </div>
    </div>
    <?php include('static/footer.html') ?>
  </body>
</html>
