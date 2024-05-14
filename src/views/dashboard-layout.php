<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="/public/css/dashboard/main.css">

</head>
<body>
    <?php include  "./public/html/dashboard/header.html" ?>
   <main>
    <?php include  "./public/html/dashboard/nav.html" ?>
    <?php require_once "./src/views/pages/dashboard-pages/".$data['page'].".php" ?>
   </main>
</body>
</html>
