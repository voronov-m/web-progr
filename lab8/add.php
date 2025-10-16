<?php

$xmlPath = __DIR__ . '/book.xml';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
{
    header('Location: index.php');
    exit;
}

$title = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');
$year = trim($_POST['year'] ?? '');

if ($title === '' || $author === '') 
{
    header('Location: index.php');
    exit;
}

$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->load($xmlPath);
$books = $dom->documentElement;

$id = time() . rand(100,999);

$book = $dom->createElement('book');
$book->setAttribute('id', $id);

$book->appendChild($dom->createElement('title', $title));
$book->appendChild($dom->createElement('author', $author));
$book->appendChild($dom->createElement('year', $year));

$books->appendChild($book);
$dom->save($xmlPath);

header('Location: index.php');
exit;
