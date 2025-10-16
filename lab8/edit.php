<?php

function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}
$xmlPath = __DIR__ . '/book.xml';

if (isset($_GET['id']) == false) 
{
  header('Location: index.php');
  exit;
}
$id = $_GET['id'];

$dom = new DOMDocument();
$dom->load($xmlPath);
$books = $dom->getElementsByTagName('book');

$book = null;

for ($i=0; $i<$books->length; $i++)
{
    $b = $books->item($i);
    if ($b->getAttribute('id') === $id) 
    { 
      $book = $b;
      break;
    }
}

if ($book == false) 
{ 
  echo "Книга не знайдена";
  exit;
}

$name = $book->getElementsByTagName('name')->item(0)->nodeValue ?? '';
$author= $book->getElementsByTagName('author')->item(0)->nodeValue ?? '';
$year = $book->getElementsByTagName('year')->item(0)->nodeValue ?? '';

?>


<!doctype html>

<html lang="uk">
<head><meta charset="utf-8"><title>Редагувати книгу</title></head>
<body>
<h1>Редагувати книгу</h1>
<form method="post" action="update.php">
  <input type="hidden" name="id" value="<?=h($id)?>">
  <label>Назва:<br><input type="text" name="name" required value="<?=h($name)?>"></label><br><br>
  <label>Автор:<br><input type="text" name="author" required value="<?=h($author)?>"></label><br><br>
  <label>Рік:<br><input type="number" name="year" value="<?=h($year)?>"></label><br><br>
  <button type="submit">Оновити</button>
</form>
<p><a href="index.php">Повернутись</a></p>
</body>

</html>