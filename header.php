<html>
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/ico" href="img/favicon.ico">
      <link rel="stylesheet" type="text/css" href="styles.css" title="Default Styles" media="screen">
    <title>Classic Models | <?php echo $title; ?></title>
</head>
<body>
<script src="app.js"></script>
<header>
<a href="index.php"><h1>Classic Cars<span class="color">.</span></h1></a>
<label for="toggle">☰</label>
         <input type="checkbox" id="toggle">
         <nav>
            <ul class="topnav">
               <li class="item"><a class="<?php if ( $page == "home" ) { echo "active"; } ?>" href="index.php">Home</a></li>
               <li class="item"><a class="<?php if ( $page == "offices" ) { echo "active"; } ?>" href="offices.php">Offices</a></li>
               <li class="item"><a class="<?php if ( $page == "payments" ) { echo "active"; } ?>" href="payments.php">Payments</a></li>
            </ul>
         </nav>
</header>
<div class="main">
<!-- end header -->
