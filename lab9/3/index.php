<html>
<head>
    <title>Lab9, 3</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="upload">Завантажити</button>
    </form>
</html>


<?php
if (isset($_POST['upload']) && isset($_FILES['image'])) 
{
    $file = $_FILES['image']['tmp_name'];

    // Перевірка чи це зображення
    if(getimagesize($file) === false) 
    {
        die('Треба завантажити зображення');
    }

    $image = imagecreatefromstring(file_get_contents($file));
    if($image == false) 
    {
        die('Помилка при створенні зображення');
    }

    // Текст
    $text_color = imagecolorallocate($image, 255, 255, 255);
    $font_path = __DIR__ . '/arial.ttf';
    $font_size = 30;
    $text = 'Воронов Микола 451 група';
    imagettftext($image, $font_size, 0, 10, 40, $text_color, $font_path, $text); // Підпис

    // Вивід та збереження зображення
    $file2 = 'output.png';
    imagepng($image, $file2);
    imagedestroy($image);
    
    echo "<img src='$file2' width='400'><br><br>";
    echo "<a href='$file2' download='output_image.png'><button>Завантажити готове зображення</button></a>";
}

?>