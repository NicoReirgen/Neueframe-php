<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config/config.php';
require 'config/functions.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?php page_title(); ?> | <?php site_name(); ?></title>

    <link href="<?php site_url(); ?>/app/dist/styles/main.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php include('app/inc/header.php'); ?>

    <div class="mainContent">
        <?php page_content(); ?>

   
    </div>

    <?php include('app/inc/footer.php'); ?>
</body>

</html>