<?php

function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}
$xmlPath = __DIR__ . '/book.xml';
$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
if (file_exists($xmlPath) == false)
{
    $dom->loadXML('<?xml version="1.0" encoding="UTF-8"?><books></books>');
    $dom->save($xmlPath);
}
$dom->load($xmlPath);
$books = $dom->getElementsByTagName('book');

?>


<!doctype html>

<html lang="uk">
<head>
<meta charset="utf-8">
<title>Каталог книг (XML)</title>
<style>
  body{font-family: Arial; padding:20px}
  table{border-collapse:collapse; width:100%; max-width:900px}
  td{border:1px solid #ccc; padding:8px; text-align:left}
  th{border:1px solid #ccc; padding:8px; text-align:left; background:#f0f0f0}
  form{margin-top:20px; max-width:900px}
  input[type=number]{width:100%; padding:6px}
  input[type=text]{width:100%; padding:6px}
  .actions a{margin-right:8px}
</style>
</head>
<body>
<h1>Каталог книг (XML)</h1>

<h2>Список книг</h2>

<table>

<tr><th>ID</th><th>Назва</th><th>Автор</th><th>Рік</th><th>Дії</th></tr>

<?php

foreach ($books as $book):
  $id = $book->getAttribute('id');
  $name = $book->getElementsByTagName('name')->item(0)->nodeValue ?? '';
  $author= $book->getElementsByTagName('author')->item(0)->nodeValue ?? '';
  $year = $book->getElementsByTagName('year')->item(0)->nodeValue ?? '';

?>

<tr>
  <td><?=h($id)?></td>
  <td><?=h($name)?></td>
  <td><?=h($author)?></td>
  <td><?=h($year)?></td>
  <td class="actions">
    <a href="edit.php?id=<?=urlencode($id)?>">Редагувати</a>
    <a href="delete.php?id=<?=urlencode($id)?>" onclick="return confirm('Видалити книгу?')">Видалити</a>
  </td>
</tr>

<?php endforeach; ?>

</table>

<h2>Додати нову книгу</h2>

<form method="post" action="add.php">

  <label>Назва:<br><input type="text" name="name" required></label><br><br>
  <label>Автор:<br><input type="text" name="author" required></label><br><br>
  <label>Рік:<br><input type="number" name="year" min="0"></label><br><br>

  <button type="submit">Додати</button>

</form>

</body>
</html>