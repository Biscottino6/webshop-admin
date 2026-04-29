<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>IT-Notdienst BW</title>
  <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>
<header>
  <h1>IT-Notdienst BW</h1>
  <nav>
    <a href="index.php?page=home">Home</a> |
    <a href="index.php?page=shop">Shop</a> |
    <?php if (!empty($_SESSION['user_id'])): ?>
      <a href="index.php?page=account">Konto</a> |
      <a href="index.php?page=logout">Logout</a>
    <?php else: ?>
      <a href="index.php?page=login">Login</a> |
      <a href="index.php?page=register">Registrieren</a>
    <?php endif; ?>
  </nav>
</header>
<main>
