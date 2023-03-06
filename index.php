<?php require 'head.php' ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item  active">
        <a class="nav-link" href="index.php">User <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin.php">Admin</a>
      </li>
    </ul>
  </div>
</nav>
<div class="container"  style="margin-top:10px">
  <div class="row">
    <div class="col-lg-4 col-md-6">
      <form method="post" action="plati.php">
    <div class="form-group">
      <label for="formInput1">Račun</label>
      <input type="number" class="form-control" id="formInput1" name="racun"step="any" required>
    </div>
    <div class="form-group">
      <label for="formInput2">Novčanica kojom se plaća</label>
      <input type="number" class="form-control" id="formInput2" name="novcanica" step="any" required>
    </div>
    <button type="submit" class="btn btn-primary mb-2">Plati</button>
  </form>
    </div>
    <div class="col-lg-2 col-md-0"></div>
    <div class="col-lg-6 col-md-6">

      <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Novčanica</th>
        <th scope="col">Količina na raspolaganju</th>
      </tr>
    </thead>
    <tbody>
      <?php
          $sql = "SELECT * FROM `novcanice` WHERE kolicina>0 ORDER BY `novcanica` ASC";
        $res = mysqli_query( $db, $sql);
        if(! $res) {
          die('Could not get data: ' . mysql_error());
        }

        while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
          echo '<tr><td>'.$row['novcanica']. '</td><td> '. $row['kolicina']. '</td></tr>';
  }
       ?>
    </tbody>
  </table>

    </div>
  </div>

</div>
<?php
if(isset($_POST["greska"]) && $_POST['greska']==1) {
  echo '<script>alert("Vrijednost novčanice kojom se plaća mora biti veća od vrijednosti računa")</script>';
}
if(isset($_POST["greska"]) && $_POST['greska']==2) {
  echo '<script>alert("Nije moguće vratiti kusur od ponuđenih novčanica")</script>';
}
if(isset($_POST["greska"]) && $_POST['greska']==3) {
  echo '<script>alert("Kusur može biti vraćen u novčanicama '.$_POST['greskaTekst'].'")</script>';
}
?>
<?php
require 'bottom.php' ?>
