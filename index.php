<?php

require_once(__DIR__ . '/app/config.php');

use MyApp\Database;
use MyApp\Todo;
use MyApp\Utils;

$pdo = Database::getInstance();

$todo = new Todo($pdo);
$todo->processPost();
$todos = $todo->getAll();


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>My Todos</title>
  <link rel="stylesheet" href="css/styles.css?<?php echo date('Ymd-Hi'); ?>">
</head>
<body>
  <main>
  <header>
      <h1>Todos</h1>
      <form action="?action=purge" method="post">
        <span class="purge">Purge</span>
        <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
      </form>
    </header>
    
    <form action="?action=add" method="post">
      <input type="text" name="title" placeholder="Type new todo.">
      <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
    </form>
    <ul>
    <?php foreach ($todos as $todo): ?>
      <li>
        <form action="?action=toggle" method="post">
          <input type="checkbox" <?= $todo->is_done ? 'checked' : ''; ?>>
          <input type="hidden" name="id" value="<?= Utils::h($todo->id); ?>">
          <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
        </form>
        <span class="<?= $todo->is_done ? 'done' : ''; ?>">
          <?= Utils::h($todo->title); ?>
        </span>
        <form action="?action=delete" method="post" class="delete-form">
          <span class="delete">x</span>
          <input type="hidden" name="id" value="<?= Utils::h($todo->id); ?>">
          <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
        </form>
      </li>
      <?php endforeach; ?>
    </ul>
  </main>

  <script src="js/main.js"></script>
</body>
</html>