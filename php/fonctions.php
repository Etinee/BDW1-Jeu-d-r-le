<?php

//fonction pour se connecter à la bd
function ConnectBD($bd) {
  $server ="localhost"; // serveur sur lequel tourne le SGBD
  $user ="p1811188"; // utilisatrice du SGBD
  $mdp ="shudder"; // mot de passe de l’utilisatrice
  $connexion =mysqli_connect($server, $user, $mdp, $bd);
  if(mysqli_connect_errno()) {
    printf("Échec de la connexion: %s\n", mysqli_connect_error());
    exit();
  }
  mysqli_query($connexion,'SET NAMES UTF8');
  return $connexion;
}

//fonction qui génère une zone et renvoie l'idZone correspondant
function generation_zone($dim_x, $dim_y, $description, $idEnvironnement,$post ,$connexion){

  //idZone servira au remplissage des différentes tables avec une clé étrangère idZone, ainsi que pour l'ajout de la zone à sa propre table.
  $requete_select="SELECT MAX(`idZone`) AS `idZone` FROM `Zone`";
  $idZone=mysqli_query($connexion, $requete_select);
  foreach ($idZone as $ligne) {
    $idZone=(int)$ligne['idZone'];
  }
  $idZone++;

  // Calcul du nombre pour chacun des éléments, compris dans la fourchette soumise dans le formulaire
  $nb_cases=$dim_x*$dim_y;

  do {
    $nb_equipements=rand((int)$post['equipement_min'],(int)$post['equipement_max']);
    $nb_mobiliers=rand((int)$post['mobilier_min'],(int)$post['mobilier_max']);
    $nb_pieges=rand((int)$post['piege_min'],(int)$post['piege_max']);
    $nb_creatures=rand((int)$post['creature_min'],(int)$post['creature_max']);
    $nb_pnj=rand((int)$post['pnj_min'],(int)$post['pnj_max']);

    // Vérification qu'il y a suffisamment de cases sur la carte pour tous les éléments, et on recalcule les nombres d'éléments
    $somme=$nb_pnj+$nb_pieges+$nb_creatures+$nb_mobiliers+$nb_equipements;
  } while ($somme>$nb_cases);

  // $vide est un tableau contenant toutes les cases du tableau.
  // S'il est à true, c'est que la case est vide, et s'il est à false, c'est que la case est occupée par un élément.
  for($i=0; $i<$dim_x; $i++){
    for($j=0; $j<$dim_y; $j++){
      // on l'initialise totalement vide
      $vide[$i][$j]=TRUE;
    }
  }

  // ATTRIBUTION DES POSITIONS DES ÉLÉMENTS PRÉSENTS SUR LA ZONE ET AJOUT À LA BDD

  // $idContient servira au remplissage de la table Contient, c'est une valeur qui s'incrémentera à chaque ajout
  $requete_select="SELECT MAX(`idContient`) AS `idContient` FROM `Contient`";
  $resultat=mysqli_query($connexion, $requete_select);
  foreach ($resultat as $ligne) {
    $idContient=(int)$ligne['idContient'];
  }


  // POSITION DES ÉQUIPEMENTS
  for($i=0; $i<$nb_equipements; $i++){
    //on sélectionne un équipement aléatoirement dans la table
    $requete_select="SELECT `idEquipement` FROM `Equipement` ORDER BY RAND() LIMIT 1 ";
    $idEquipement=mysqli_query($connexion, $requete_select);
    foreach ($idEquipement as $ligne) {
      $idEquipement=(int)$ligne['idEquipement'];
    }
    // on lui attribue une position aléatoire
    $pos_x=rand(0, ($dim_x-1));
    $pos_y=rand(0, ($dim_y-1));
    //on vérifie si la position n'est pas déjà occupée
    while ($vide[$pos_x][$pos_y]==FALSE) {
      $pos_x=rand(0, ($dim_x-1));
      $pos_y=rand(0, ($dim_y-1));
    }
    //on ajoute notre équipement à la bdd
    $idContient++;
    $requete_select="INSERT INTO `Contient`(`idContient`, `type`, `idZone`, `idEquipement`, `pos_x`, `pos_y`) VALUES('".$idContient."', 'Equipement', '".$idZone."', '".$idEquipement."', '".$pos_x."','".$pos_y."')";
    $resultat=mysqli_query($connexion, $requete_select);
    //on indique que la case est maintenant occupée
    if($resultat==TRUE){
      $vide[$pos_x][$pos_y]=FALSE;
    }
  }
  // POSITION DU MOBILIER
  //On commence par voir dans quel environnement on est pour adapter le mobilier
  $in_or_out;
  if($idEnvironnement==0 || $idEnvironnement==6){ //si l'environnement correspond à RuinsDungeons ou Underground
    $in_or_out="interieur";
  }else if($idEnvironnement==3){ //si l'environnement correspond à aquatic
    $in_or_out="aquatic";
  }else{
    $in_or_out="exterieur";
  }
  //on refait la même chose que pour les équipements
  for($i=0; $i<$nb_mobiliers; $i++){

    $requete_select="SELECT `idMobilier` FROM `Mobilier` WHERE `environnement`='".$in_or_out."' ORDER BY RAND() LIMIT 1 ";
    $idMobilier=mysqli_query($connexion, $requete_select);
    foreach ($idMobilier as $ligne) {
      $idMobilier=(int)$ligne['idMobilier'];
    }

    do {
      $pos_x=rand(0, ($dim_x-1));
      $pos_y=rand(0, ($dim_y-1));
    } while ($vide[$pos_x][$pos_y]==FALSE);
    $idContient++;
    $requete_select="INSERT INTO `Contient`(`idContient`, `type`, `idZone`, `idMobilier`, `pos_x`, `pos_y`) VALUES('".$idContient."', 'Mobilier', '".$idZone."', '".$idMobilier."', '".$pos_x."','".$pos_y."')";
    $resultat=mysqli_query($connexion, $requete_select);
    if($resultat==TRUE){
      $vide[$pos_x][$pos_y]=FALSE;
    }
  }
  // POSITION DES PIÈGES
  for($i=0; $i<$nb_pieges; $i++){

    $requete_select="SELECT `idPiege` FROM `Piege` ORDER BY RAND() LIMIT 1 ";
    $idPiege=mysqli_query($connexion, $requete_select);
    foreach ($idPiege as $ligne) {
      $idPiege=(int)$ligne['idPiege'];
    }

    while ($vide[$pos_x][$pos_y]==FALSE) {
      $pos_x=rand(0, ($dim_x-1));
      $pos_y=rand(0, ($dim_y-1));
    }
    $idContient++;
    $requete_select="INSERT INTO `Contient`(`idContient`, `type`, `idZone`, `idPiege`, `pos_x`, `pos_y`) VALUES('".$idContient."', 'Piege', '".$idZone."', '".$idPiege."', '".$pos_x."','".$pos_y."')";
    $resultat=mysqli_query($connexion, $requete_select);
    if($resultat==TRUE){
      $vide[$pos_x][$pos_y]=FALSE;
    }
  }

  // $idRencontre servira au remplissage de la table Rencontre, c'est une valeur qui s'incrémentera à chaque ajout
  $requete_select="SELECT MAX(`idRencontre`) AS `idRencontre` FROM `Rencontre`";
  $resultat=mysqli_query($connexion, $requete_select);
  foreach ($resultat as $ligne) {
    $idRencontre=(int)$ligne['idRencontre'];
  }

  // POSITION DES CRÉATURES
  //on récupère le nom de l'environnement de la zone
  $requete_select="SELECT `nom` FROM `Environnement` WHERE `idEnvironnement`='".$idEnvironnement."'";
  $environnement=mysqli_query($connexion, $requete_select);
  foreach ($environnement as $ligne) {
    $environnement=$ligne['nom'];
  }
  for($i=0; $i<$nb_creatures; $i++){
    $requete_select="SELECT `idCreature` FROM `Creature` WHERE `environnement`='".$environnement."' ORDER BY RAND() LIMIT 1 ";
    $idCreature=mysqli_query($connexion, $requete_select);
    foreach ($idCreature as $ligne) {
      $idCreature=(int)$ligne['idCreature'];
    }
    while ($vide[$pos_x][$pos_y]==FALSE) {
      $pos_x=rand(0, ($dim_x-1));
      $pos_y=rand(0, ($dim_y-1));
    }
    $idRencontre++;
    $requete_select="INSERT INTO `Rencontre`(`idRencontre`, `type`, `idZone`, `idCreature`, `pos_x`, `pos_y`) VALUES('".$idRencontre."', 'Creature', '".$idZone."', '".$idCreature."', '".$pos_x."','".$pos_y."')";
    $resultat=mysqli_query($connexion, $requete_select);
    if($resultat==TRUE){
      $vide[$pos_x][$pos_y]=FALSE;
    }
  }
  // POSITION DES PNJ
  //d'abord on test si on n'est pas dans la mer
  if($idEnvironnement!=3){
    for($i=0; $i<$nb_pnj; $i++){

      $requete_select="SELECT `idPNJ` FROM `PNJ` ORDER BY RAND() LIMIT 1 ";
      $idPNJ=mysqli_query($connexion, $requete_select);
      foreach ($idPNJ as $ligne) {
        $idPNJ=(int)$ligne['idPNJ'];
      }
      while ($vide[$pos_x][$pos_y]==FALSE) {
        $pos_x=rand(0, ($dim_x-1));
        $pos_y=rand(0, ($dim_y-1));
      }
      $idRencontre++;
      $requete_select="INSERT INTO `Rencontre`(`idRencontre`, `type`, `idZone`, `idPNJ`, `pos_x`, `pos_y`) VALUES('".$idRencontre."', 'PNJ', '".$idZone."', '".$idPNJ."', '".$pos_x."','".$pos_y."')";
      $resultat=mysqli_query($connexion, $requete_select);
      if($resultat==TRUE){
        $vide[$pos_x][$pos_y]=FALSE;
      }
    }
  }

  // Récupération des éléments présents sur la zone et leurs positions
  $requete_select="SELECT * FROM `Contient` WHERE `idZone`='".$idZone."'";
  $contient=mysqli_query($connexion, $requete_select);
  $requete_select="SELECT * FROM `Rencontre` WHERE `idZone`='".$idZone."'";
  $rencontre=mysqli_query($connexion, $requete_select);

  // Affichage de la zone
  echo "<div class='carte'>";
  echo"<table>";
  for($i=0; $i<$dim_y; $i++){
    echo "<tr>";
    for($j=0; $j<$dim_x; $j++){

      echo "<td>";

              // Pour chaque case, on teste s'il y a déjà un objet dessus ou non.
      if($vide[$j][$i]==FALSE){
        // s'il y en a un, on cherche dans nos variables $contient et $rencontre quel élément est sur la case
        foreach ($contient as $ligne) {
          if($ligne['pos_x']==$j && $ligne['pos_y']==$i){
            // Une fois qu'on a trouvé l'élément en question, on récupère son id pour le chercher dans sa table et permettre son affichage
            $requete_select="SELECT `id".$ligne['type']."` FROM `Contient` WHERE `idZone`='".$idZone."' AND `pos_x`='".$j."' AND `pos_y`='".$i."'";
            $id=mysqli_query($connexion, $requete_select);
            foreach ($id as $row) {
              $id=$row['id'.$ligne['type']];
            }
            $requete_select="SELECT * FROM ".$ligne['type']." WHERE id".$ligne['type']."='".$id."'";
            $elem=mysqli_query($connexion, $requete_select);
           foreach ($elem as $tuple) {
              echo "<img src='img/".$tuple['image']."' alt='".$tuple['nom']."' width='50' height='50' title='".$ligne['type']." : ".$tuple['nom']."'>";
          }
         }
        }

        foreach ($rencontre as $ligne) {
          if($ligne['pos_x']==$j && $ligne['pos_y']==$i){
            $requete_select="SELECT `id".$ligne['type']."` FROM `Rencontre` WHERE `idZone`='".$idZone."' AND `pos_x`='".$j."' AND `pos_y`='".$i."'";
            $id=mysqli_query($connexion, $requete_select);
            foreach ($id as $row) {
              $id=$row['id'.$ligne['type']];
            }
            $requete_select="SELECT * FROM `".$ligne['type']."` WHERE `id".$ligne['type']."`='".$id."'";
            $elem=mysqli_query($connexion, $requete_select);
            foreach ($elem as $tuple) {
              echo "<img src='img/".$tuple['image']."' alt='".$tuple['nom']."' width='50' height='50' title='".$ligne['type']." : ".$tuple['nom']."'>";
            }
          }
        }
      }else{
        //si la case est vide, on affiche la tuile correspondant à l'environnement de la zone
        $requete_select="SELECT * FROM `Environnement` WHERE `idEnvironnement`='".$idEnvironnement."'";
        $environnement=mysqli_query($connexion, $requete_select);
        foreach ($environnement as $gpudidee) {
          echo "<img src='img/".$gpudidee['image']."' alt='".$gpudidee['nom']."' width='50' height='50' title='case vide : ".$gpudidee['nom']."'>";
        }
      }
      echo "</td>";
    }
    echo "</tr>";
  }
  echo"</table>";
  echo"</div>";

  // On ajoute la zone à la bdd
  $requete_select="INSERT INTO `Zone`(`idZone`, `description`, `dim_x`, `dim_y`, `nbCases`, `idEnv`) VALUES('".$idZone."', '".$description."', '".$dim_x."', '".$dim_y."', '".$nb_cases."', '".$idEnvironnement."')";
  $zone=mysqli_query($connexion, $requete_select);

  // on retourne l'id de la zone qui vient d'être générée
  return $idZone;
}

// fonction qui génère une carte et renvoie l'idCarte correspondant
function generation_carte($zone_min, $zone_max, $environnement, $dim_x_min, $dim_x_max, $dim_y_min, $dim_y_max, $nom, $descriptionCarte, $post, $connexion){

  // Récupération de l'idCarte suivant
  $requete_select="SELECT MAX(`idCarte`) AS `idCarte` FROM `Carte`";
  $idZone=mysqli_query($connexion, $requete_select);
  foreach ($idZone as $ligne) {
    $idCarte=(int)$ligne['idCarte'];
  }
  $idCarte++;

  //on compte le nombre d'environnements, variable qui nous servira dans la boucle du remplissage du tableau
  $nb_environnement=count($environnement);

  // calcul du nombre de zones présentes sur la carte
  $nb_zone=rand((int)$zone_min, (int)$zone_max);

  // pour chaque zone,calcul des dimensions et génération des zones dans un tableau avec 2 lignes et $nb_zone/2 colonnes
  $nb_ligne=(int)$nb_zone/2;

  // Remplissage du tableau de zone
  echo "<div class='carte'>";
  echo "<table>";
  for($h=0; $h<$nb_ligne; $h++){
    echo "<tr>";
    for($i=0; $i<2; $i++){
      // GÉNÉRATION D'UNE ZONE
      echo "<td>";
      // calcul des dimensions de la zone
      $dim_x=rand((int)$dim_x_min, (int)$dim_x_max);
      $dim_y=rand((int)$dim_y_min, (int)$dim_y_max);
      // attribution d'une description
      $description="Zone".($h+$i);
      // attribution d'un environnement (et utilisation de $nb_environnement calculé au dessus de la boucle)
      $idEnvironnement=$environnement[rand(0, $nb_environnement-1)];
      // génération de la zone
      $idZone=generation_zone($dim_x, $dim_y, $description, $idEnvironnement, $post, $connexion);
      // ajout de l'id de la carte en clé étrangère à la zone
      $requete_select="UPDATE `Zone` SET `idCarte`='".$idCarte."' WHERE `idZone`='".$idZone."'";
      $resultat=mysqli_query($connexion, $requete_select);
      echo "</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
  echo "</div>";

  // ENREGISTREMENT DE LA CARTE DANS LA BDD
  $date=date('Y-m-d');
  $requete_select="INSERT INTO `Carte`(`idCarte`, `nom`, `description`, `dateCrea`) VALUES('".$idCarte."', '".$nom."', '".$descriptionCarte."', '".$date."')";
  $carte=mysqli_query($connexion, $requete_select);

  // ENREGISTREMENT DES PARAMÈTRES DANS LA BDD

  // d'abord on récupère l'id du dernier paramètre pour pouvoir incrémenter
  $requete_select="SELECT MAX(`idParam`) AS `idParam` FROM `Parametre`";
  $resultat=mysqli_query($connexion, $requete_select);
  foreach ($resultat as $ligne) {
    $idParam=(int)$ligne['idParam'];
  }
  $idParam++;

  // puis insertion des paramètres dans la bdd
  $requete_select="INSERT INTO `Parametre` VALUES('".$idParam."', 'zone_min', '".$zone_min."', '".$idCarte."')";
  $resultat=mysqli_query($connexion, $requete_select);
  $idParam++;
  $requete_select="INSERT INTO `Parametre` VALUES('".$idParam."', 'zone_max', '".$zone_max."', '".$idCarte."')";
  $resultat=mysqli_query($connexion, $requete_select);
  $idParam++;
  $requete_select="INSERT INTO `Parametre` VALUES('".$idParam."', 'dim_x_min', '".$dim_x_min."', '".$idCarte."')";
  $resultat=mysqli_query($connexion, $requete_select);
  $idParam++;
  $requete_select="INSERT INTO `Parametre` VALUES('".$idParam."', 'dim_x_max', '".$dim_x_max."', '".$idCarte."')";
  $resultat=mysqli_query($connexion, $requete_select);
  $idParam++;
  $requete_select="INSERT INTO `Parametre` VALUES('".$idParam."', 'dim_y_min', '".$dim_y_min."', '".$idCarte."')";
  $resultat=mysqli_query($connexion, $requete_select);
  $idParam++;
  $requete_select="INSERT INTO `Parametre` VALUES('".$idParam."', 'dim_y_max', '".$dim_y_max."', '".$idCarte."')";
  $resultat=mysqli_query($connexion, $requete_select);

  // on retourne l'id de la carte générée
  return $idCarte;
}

function transfert_bdd($bd1, $bd2) {
  $connexion1=connectBD($bd1);
  $connexion2=connectBD($bd2);

  //INSERTION DES PIÈGES

  $requete_select="SELECT * FROM `DonneesFournies` WHERE type LIKE 'pi%ge';";
  $pieges=mysqli_query($connexion1, $requete_select);
  if($pieges == FALSE){
    echo "erreur";
    exit();
  }else {
	  $cptLigne=0;
	  // pieges : array contenant tout les tuples
	  foreach($pieges as $ligne){
		  // ligne : array correspondant à un tuple
		  // variables : array contenant chaque attribut d'un piège
      $ligne['attributs']=str_replace(", ","&",$ligne['attributs']);
      parse_str($ligne['attributs'],$variables);
      echo $ligne['nom'].'<br/>';
      foreach($variables as $key => $value){
        echo $key." ==> ".$value;
        echo '<br/>';
		  }
		  $requete_insert="INSERT INTO `Piege`(`idPiege`,`nom`,`image`,`detecter`,`desamorcer`,`esquiver`) VALUES (".$ligne['id'].",'".$ligne['nom']."','".$variables['image']."','".$variables['detecter']."','".$variables['desamorcer']."','".$variables['esquiver']."')";
      $bool=mysqli_query($connexion2, $requete_insert);
      if($bool == FALSE){
        echo "<p>echec du remplissage. </p>";
      }else {
        echo "<p>remplissage réussi. </p>";
      }
      echo '<br/>';
    }
  }

  // INSERTION DES CRÉATURES

  $requete_select="SELECT * FROM `DonneesFournies` WHERE type LIKE 'cr%ature';";
  $creatures=mysqli_query($connexion1, $requete_select);
  if($creatures == FALSE){
    echo "erreur";
    exit();
  }else {
	  $cptLigne=0;
	  // creatures : array contenant tout les tuples
	  foreach($creatures as $ligne){
		  // ligne : array correspondant à un tuple
		  // variables : array contenant chaque attribut d'un piège
      $ligne['attributs']=str_replace(", ","&",$ligne['attributs']);
      parse_str($ligne['attributs'],$variables);
      echo $ligne['nom'].'<br/>';
      foreach($variables as $key => $value){
        echo $key." ==> ".$value;
        echo '<br/>';
		  }

		  $requete_insert="INSERT INTO `Creature`(`idCreature`,`nom`,`nbOr`,`pa`,`pv`,`climat`,`environnement`,`image`) VALUES ('".$ligne['id']."','".$ligne['nom']."','".$variables['pieces']."','".$variables['attaque']."','".$variables['vie']."','".$variables['climat']."','".$variables['environnement']."' ,'monstre.gif')";
      $bool=mysqli_query($connexion2, $requete_insert);
      if($bool == FALSE){
        echo "<p>echec du remplissage. </p>";
      }else {
        echo "<p>remplissage réussi. </p>";
      }
      $resultat=mysqli_query($connexion2, $requete_insert);

      echo '<br/>';
    }
  }

  // INSERTION DU MOBILIER

  $requete_select="SELECT * FROM `DonneesFournies` WHERE type='mobilier';";
  $mobilier=mysqli_query($connexion1, $requete_select);
  if($mobilier == FALSE){
    echo "erreur";
    exit();
  }else {
    $cptLigne=0;
    // mobilier : array contenant tout les tuples
    foreach($mobilier as $ligne){
      // ligne : array correspondant à un tuple
      // variables : array contenant chaque attribut d'un piège
      $ligne['attributs']=str_replace(", ","&",$ligne['attributs']);
      parse_str($ligne['attributs'],$variables);
      echo $ligne['nom'].'<br/>';
      foreach($variables as $key => $value){
        echo $key." ==> ".$value;
        echo '<br/>';
      } //
      //
      $requete_insert="INSERT INTO `Mobilier`(`idMobilier`,`nom`,`image`,`deplacable`, `environnement`) VALUES ('".$ligne['id']."','".$ligne['nom']."','".$variables['image']."','".$variables['deplacable']."', 'interieur')";
      $bool=mysqli_query($connexion2, $requete_insert);
      if($bool == FALSE){
        echo "<p>echec du remplissage. </p>";
      }else {
        echo "<p>remplissage réussi. </p>";
      }
      echo '<br/>';
    }
  }
  mysqli_close($connexion1);
  mysqli_close($connexion2);
}


 ?>
