<?php require 'head.php' ?>
<?php
    $novcanica = $_POST['novcanica'];
    $kolicina = $_POST['kolicina'];
    if($kolicina<0) {
      header("Location: admin.php");
      return;
    }
    $sql = "SELECT * FROM `novcanice` WHERE novcanica =". $novcanica;
    $query = mysqli_query($db, $sql);
    $result = mysqli_fetch_assoc($query);
    if($result==NULL) {
      $sql = "INSERT INTO novcanice (novcanica, kolicina) VALUES (".$novcanica.", ".$kolicina.")";
      $query = mysqli_query($db,$sql);
    }
    else {
      $sql = "UPDATE novcanice SET kolicina = kolicina +". $kolicina ." WHERE novcanica =".$novcanica;
      $query = mysqli_query($db,$sql);
    }
    header("Location: admin.php");
 ?>
<?php require 'bottom.php' ?>
