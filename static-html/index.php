<!doctype html>
<html lang="en-US">
<?php require_once('blocks/services/head.html'); ?>
<?php $path_content = count($_GET) > 0 ? 'blocks/pages/' . $_GET['f'] : 'blocks/pages/sitemap.html' ?>
<body>

        <?php require_once('blocks/partials/header.html'); ?>

        <?php require_once($path_content); ?>

        <?php require_once('blocks/partials/footer.html'); ?>

</body>
</html>
