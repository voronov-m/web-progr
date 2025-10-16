<?php

$xmlPath = __DIR__ . '/book.xml';

if (isset($_GET['id']) == false)
{
    header('Location: index.php');
    exit;
}
$id = $_GET['id'];

$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->load($xmlPath);
$books = $dom->getElementsByTagName('book');

$found = false;
for ($i = 0; $i < $books->length; $i++) 
{
    $b = $books->item($i);
    if ($b->getAttribute('id') === $id)
    {
        $b->parentNode->removeChild($b);
        $found = true;
        break;
    }
}
if ($found) $dom->save($xmlPath);
header('Location: index.php');
exit;

?>