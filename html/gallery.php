<?php
  require_once('../config.php');

  $dbh = new PDO($dsn, $dbUsername, $dbPassword);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->exec("SET CHARACTER SET utf8");


  // Total
  $total = 0;
  $tt = $dbh->query("SELECT count(*) as total FROM cup;");
  if ($ttt = $tt->fetch(PDO::FETCH_ASSOC)) {
    $total = $ttt['total'];
  }
    
  // Start
  $start = (isset($_GET['start'])) ? (int) $_GET['start'] : 0;
  $next = $start + 6;
  $prev = ($start > 5) ? $start - 6 : 0;
  $total_page = ceil($total/6);
  $current_page = $start/6 + 1;

  $tt = $dbh->query("SELECT * FROM cup ORDER BY created_at DESC LIMIT ".$start.",6;");
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
  <script src="js/rotation.js"></script>
  <script>
    $(function() {
      $('#grid li:nth-child(3)').addClass('last');
      $('#grid li').last().addClass('last');
    });
  </script>
</head>

<body>
  <?php
    include 'elements/header.html';
  ?>
  
  <div class="wrapper">
    <ul id="grid">
      <?php while ($creation = $tt->fetch(PDO::FETCH_ASSOC)): ?>
      <li>
        <div class="container">
          <img src="<?php print($creation['img_big']); ?>" alt="visuel" class="visuel">
          <img src="<?php print($creation['img_big']); ?>" alt="visuel" class="visuel_bis">
          <img src="../img/illus/cache_small.png" alt="cache" class="cache">
        </div>
        <a href="single.php?id=<?php print($creation['id']); ?>" class="coffee_name"><span><?php if(empty($creation['name'])){print("crosscross");} else {print(htmlspecialchars($creation['name'])); } ?></span></a>
        <h3 class="creator">Par <?php if(empty($creation['twitter'])){print("Anonymous");} else {print(htmlspecialchars($creation['twitter'])); } ?></h3>
      </li>
      <?php endwhile; ?>
    </ul>

    <div class="cta_container make_one">
      <div>
        <a href="/" class="cta">Make one !</a>
      </div>
    </div>

    <div id="pager">
      <div>
        <?php if($start == 0): ?>
          <span>Page précédente</span>
        <?php else: ?>
          <a href="gallery.php?start=<?php print($prev); ?>">Page précédente</a>
        <?php endif ?>
      </div>
      
      <p>Page <?php print($current_page); ?> sur <?php print($total_page); ?></p>

      <div>
        <?php if($start+6 >= $total): ?>
          <span>Page suivante</span>
        <?php else: ?>
          <a href="gallery.php?start=<?php print($next); ?>">Page suivante</a>
        <?php endif ?>
      </div>
    </div>
  </div>

  <footer>
    <?php
      include 'elements/footer.html';
    ?>
  </footer>
</body>
</html>