<?php include_once '_core/Main.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--v2.0.1-->
    <title>localhost</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link rel="shortcut icon" href="./_core/img/favicon.ico" type="image/x-icon">
    <link href="./_core/css/main.css" type="text/css" rel="stylesheet"/>
    <script>
        var config = {};
        <?php Main::setJsConstant(); ?>
    </script>
</head>
<body>
<nav class="nav container"><?php Main::printNav(); ?></nav>
<main class="container">
    <?php if (isset($_POST['path'])) Main::printMassage('succes', Functions::index_fixer()); ?>
    <div class="row">
        <?php Main::printProjects(); ?>
    </div>
</main>
<div class="pagination"><?php Main::printPagination(); ?></div>
<script type="text/javascript" src="./_core/js/main.js"></script>
</body>
</html>
