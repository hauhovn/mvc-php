<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'].' - ':'' ?>Mananger</title>
    <link rel="stylesheet" href="/public/css/manager.css">
    <link rel="stylesheet" href="/public/css/manager-header.css">
    <link rel="stylesheet" href="/public/css/manager-nav.css">
    <link rel="stylesheet" href="/public/css/manager-footer.css">
</head>
<body>
        <!-- // Header -->
        <?php require_once "layout-elements/manager/header.php"; ?>
       <main>
         <!-- // Nav -->
        <?php require_once "layout-elements/manager/nav.php"; ?>
        <!-- // Main -->
        <?php require_once isset($data['page'])?"manager/".$data['page'].".php":"manager/home.php"; ?>
       </main>
        <!-- // Footer -->
        <?php require_once "layout-elements/manager/footer.php"; ?>
</body>
</html>