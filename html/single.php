<?php
  require_once('../config.php');
  $img_bonus = rand(1,4);

  $id = (int)$_GET['id'];

  $dbh = new PDO($dsn, $dbUsername, $dbPassword);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $dbh->exec("SET CHARACTER SET utf8");
  $tt = $dbh->query("SELECT * FROM cup WHERE id=$id;");
  $creation= $tt->fetch(PDO::FETCH_ASSOC);

  if($creation === false) {
    header("Location: /gallery.php");
    die();
  }
      
  $tt = $dbh->query("SELECT id FROM cup WHERE created_at < '{$creation['created_at']}' ORDER BY created_at DESC LIMIT 1;");
  $prev = $tt->fetch(PDO::FETCH_ASSOC);

  $tt = $dbh->query("SELECT id FROM cup WHERE created_at > '{$creation['created_at']}' ORDER BY created_at ASC LIMIT 1;");
  $next = $tt->fetch(PDO::FETCH_ASSOC);
?>
<?php
if(@$_SERVER['REQUEST_METHOD'] === 'POST') {
  $send = require_once('../mailing.php');
  if($send) {
    header("Location: /single.php?id=".$id.'&from_email');
    die();
  }
}


?>

<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!-- Consider specifying the language of your content by adding the `lang` attribute to <html> -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <?php
    include 'elements/head.html';
  ?>
  <script src="js/jquery.infieldlabel.min.js" type="text/javascript"></script>
  <script src="js/rotation.js"></script>
  <script>
    $(function() {
      $('label').inFieldLabels();
    });
  </script>
</head>

<body>
  <?php
    include 'elements/header.html';
  ?>

  <div class="wrapper">
    <div id="single">
        <div class="container">
        <img src="<?php print($creation['img_big']); ?>" alt="visuel" class="visuel">
        <img src="<?php print($creation['img_big']); ?>" alt="visuel" class="visuel_bis">
        <img src="../img/illus/cache_big.png" alt="cache" class="cache">
      </div>
      <span class="coffee_name"><span><?php if(empty($creation['name'])){print("crosscross");} else {print(htmlspecialchars($creation['name'])); } ?></span></span>
      <h3 class="creator">Par <?php if(empty($creation['twitter'])){print("Anonymous");} else {print(htmlspecialchars($creation['twitter'])); } ?></h3>
      <?php if(isset($prev['id'])): ?>
        <a class="nav_single prev" href="single.php?id=<?php print($prev['id']); ?>"></a>
      <?php endif ?>
      <?php if(isset($next['id'])): ?>
        <a class="nav_single next" href="single.php?id=<?php print($next['id']); ?>"></a>
      <?php endif ?>
    </div>

    <div id="bonus" class="clearfix">
      
      <div id="share">
        <div id="intro" class="clearfix">
          
          <div id="bloc_title">
            <h3>Share this coffee with ur friends !</h3>
            <p>Envoyez cette <span>CROSS:CROSS COFFEE CUP</span> à vos amis, partagez-la sur Facebook, et faites rêver les filles !</p>
          </div>

          <div id="social" class="clearfix">
            <div class="social_btn"><a href="https://twitter.com/share" class="twitter-share-button" data-lang="fr">Tweeter</a></div>
            <div class="social_btn"><div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div></div>
          </div>

        </div>

        <form method="POST" action="">
          <div><label for="friend">Type <span>ur friend</span> e-mail here</label><input type="text" name="mail" value="" id="friend" required="required" /></div>
          <div><label for="you">Type <span>ur name</span></label><input type="text" name="name" value="" id="you" required="required" /></div>
          <span class="submit"><input type="submit" value="Send !"></span>
          <?php if(isset($_GET['from_email'])): ?>
            <span class="email_envoye">L'email a bien été envoyé !</span>
          <?php endif ?>
        </form>
      </div>

      <div id="illus">
        <img src="../img/illus/illus_bonus_<?php print($img_bonus); ?>.jpg" alt="C'est fort de café !">
      </div>
    </div>

    <div class="cta_container make_one">
      <div>
        <a href="/" class="cta">Make one !</a>
      </div>
    </div>
    <div class="push_gallery">
      <a href="gallery.php">Visit teh gallery</a>
      <img src="img/the_gallery.png" alt="">
    </div> 
  </div>
    
  <footer>
    <?php
        include 'elements/footer.html';
    ?>
  </footer>
</body>
</html>