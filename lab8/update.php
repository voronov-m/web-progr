<?php

$xmlPath = __DIR__ . '/book.xml';

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    header('Location: index.php');
    exit;
}
$id = $_POST['id'] ?? '';
$name = trim($_POST['name'] ?? '');
$author = trim($_POST['author'] ?? '');
$year = trim($_POST['year'] ?? '');

$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->load($xmlPath);
$books = $dom->getElementsByTagName('book');

$found = false;
for ($i=0; $i<$books->length; $i++)
{
    $b = $books->item($i);
    if ($b->getAttribute('id') === $id)
    {
        foreach (['name','author','year'] as $tag)
        {
            $nodes = $b->getElementsByTagName($tag);
            if ($nodes->length)
            {
                $nodes->item(0)->nodeValue = ${$tag};
            }
            else
            {
                $b->appendChild($dom->createElement($tag, ${$tag}));
            }
        }
        $found = true;
        break;
    }
}
if ($found == true) 
{
    $dom->save($xmlPath);
}
header('Location: index.php');
exit;

?>