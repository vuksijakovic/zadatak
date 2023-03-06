<?php require 'head.php' ?>
<?php
    $brojac=0;
    $arr = array();
    function nacinVracanja($preostaliKusur, $indeks, $niz, $ostatakNiza) {
      array_push($ostatakNiza, $niz[$indeks]);
      $preostaliKusur-=$niz[$indeks];
      if(sizeof($GLOBALS['arr'])!=0) {
        if(sizeof($ostatakNiza)>=sizeof($GLOBALS['arr']) && $preostaliKusur!=0) return;
      }
      if($preostaliKusur==0){
         $GLOBALS['brojac']++;
         $GLOBALS['arr'] = $ostatakNiza;
      }

      for($i=$indeks+1; $i<sizeof($niz); $i++) {
        if($preostaliKusur-$niz[$i]>=0) {
          nacinVracanja($preostaliKusur, $i, $niz, $ostatakNiza);
        }
      }
    }
    $novcanica = $_POST['novcanica'];
    $racun = $_POST['racun'];
    if($racun > $novcanica): ?>
    <form action="index.php" method="post" id="formid">
      <input type="hidden" id="fname" name="greska" value="1">
    </form>
    <script type="text/javascript">
    document.getElementById("formid").submit();
    </script>
    <?php endif?>
    <?php if($racun<=$novcanica):?>
      <?php $sql = "SELECT * FROM `novcanice` WHERE kolicina>0 ORDER BY `novcanica` DESC";
      $res = mysqli_query( $db, $sql);
      if(! $res) {
        die('Could not get data: ' . mysql_error());
      }
      $niz = array();
      while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        for($i=0; $i<$row['kolicina']; $i++) {
          array_push($niz, $row['novcanica']);
        }
      }
      $ostatakNiza = array();
      for($i=0; $i<sizeof($niz); $i++) {
        if($niz[$i]<=$novcanica-$racun)
        {
          nacinVracanja($novcanica-$racun, $i, $niz, $ostatakNiza);
        }
      }
      $sql = "SELECT * FROM `novcanice` WHERE novcanica =". $novcanica;
      $query = mysqli_query($db, $sql);
      $result = mysqli_fetch_assoc($query);
      if($result==NULL) {
        $sql = "INSERT INTO novcanice (novcanica, kolicina) VALUES (".$novcanica.", 1)";
        $query = mysqli_query($db,$sql);
      }
      else {
        $sql = "UPDATE novcanice SET kolicina = kolicina + 1 WHERE novcanica =".$novcanica;
        $query = mysqli_query($db,$sql);
      }
      $str="";
      foreach($arr as $n) {
        $str = $str. ', ' .$n;
        $sql = "UPDATE novcanice SET kolicina = kolicina - 1 WHERE novcanica =".$n;
        $query = mysqli_query($db,$sql);
      }
      if(sizeof($arr)==0):?>
      <form action="index.php" method="post" id="formid">
        <input type="hidden" id="fname" name="greska" value="2">
        </form>
        <script type="text/javascript">
        document.getElementById("formid").submit();
        </script>
      <?php endif ?>
      <?php if(sizeof($arr)>0):?>
        <form action="index.php" method="post" id="formid">
          <input type="hidden" id="fname" name="greska" value="3">
          <?php echo '<input type="hidden" id="fname" name="greskaTekst" value="'.$str.'">'; ?>
          </form>
          <script type="text/javascript">
          document.getElementById("formid").submit();
          </script>
        <?php endif ?>
    <?php endif ?>
<?php require 'bottom.php' ?>
