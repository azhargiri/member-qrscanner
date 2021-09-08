<?php $id ?>
<!-- <a href="<?= make_route_of_path('/') ?>">Kembali</a> -->
<?php
$nama = "";
$slogan = "";

$data = [
    '12345' => [
        'nama' => 'Feryzal',
        'slogan' => 'Better Visuals',
        'facebook_nickname' => 'feryzal',
        'twitter_nickname' => '@feryzal',
    ],
    '54321' => [
        'nama' => 'Azhar',
        'slogan' => 'Singkong rebus, rujak uleg',
        'facebook_nickname' => 'Azhar+...',
        'twitter_nickname' => '@azhar+...',
    ]

];

$people = array_key_exists($id, $data) ? $data[$id] : null;

// if($id == "12345"){
//     $nama= "Feryzal";
//     $slogan = 'Better Visuals';
// } else if($id == "54321") {
//     $nama= "Azhar";
//     $slogan = 'Open new tab';
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halo, ...</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<aside class="profile-card">
  <header>
    <!-- here’s the avatar -->
    <a target="_blank" href="#">
      <img src="http://lorempixel.com/150/150/people/" class="hoverZoomLink">
    </a>

    <!-- the username -->
    <h1>
            <?= $people ? $people['nama'] : '-' ?>
          </h1>

    <!-- and role or location -->
    <h2>
            <?= $people ? $people['slogan'] : '-' ?>
          </h2>

  </header>

  <!-- bit of a bio; who are you? -->
  <div class="profile-bio">

    <p>
      It takes monumental improvement for us to change how we live our lives. Design is the way we access that improvement.
    </p>

  </div>

  <!-- some social links to show off -->
  <ul class="profile-social-links">
    <?php foreach(['facebook_nickname', 'twitter_nickname', 'instagram_nickname'] as $social_media): ?>
        <?php if (isset($people[$social_media])): ?>
        <li>
          <a target="_blank" href="https://www.<?= substr($social_media, 0, strpos($social_media, '_'))?>.com/<?= $people[$social_media] ?>">
              <i class="bi-<?= substr($social_media, 0, strpos($social_media, '_'))?>"></i>
          </a>
        </li>
        <?php endif; ?>
    <?php endforeach; ?>
    <!--
    <li>
      <a target="_blank" href="https://twitter.com/<?= $people ? $people['fb_nickname'] : '-'?>">
        <i class="fa fa-twitter"></i>
      </a>
    </li>
    <li>
      <a target="_blank" href="https://github.com/vipulsaxena">
        <i class="fa fa-github"></i>
      </a>
    </li>
    <li>
      <a target="_blank" href="https://www.behance.net/vipulsaxena">
       
        <i class="fa fa-behance"></i>
      </a>
    </li>
    -->
  </ul>
</aside>
<a href="<?= make_route_of_path('/')?>" class="scan-button" onclick="openscanner()">
  <i class="bi-upc-scan"></i>
</a>
<script src="js.js"></script>
</body>
</html>
