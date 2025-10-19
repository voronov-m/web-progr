<?php

// Розмір та кольори
$width = 800;
$height = 800;

// Створення нового зображення
$image = imagecreatetruecolor($width, $height);

$background_color = imagecolorallocate($image, 0, 0, 0);
$border_color = imagecolorallocate($image, 255, 255, 255);

// Заповнення фону
imagefill($image, 0, 0, $background_color);

// xml
$xml = simplexml_load_file('cols.xml') or die("Error: Cannot create object");






// Налаштування розміру колонок
$center_x = $width / 2;
$center_y = $height / 2;
$cols = count($xml->col);
$x_gap = 20;
$y_gap = 120;
$cols_width = ($width - ($cols + 1) * $x_gap) / $cols;
$cols_max_height = $height - 2 * $y_gap;
$col = $x_gap + $cols_width;
$col_drawing = 0;

// Шрифт
$font_path = __DIR__ . '/arial.ttf';
$font_size = 30;

// Функція щоб знайти центр колонки для тексту
function bbox($text, $col_drawing)
{
    global $font_path, $font_size, $cols_width, $x_gap;
    $boundingbox = imagettfbbox($font_size, 0, $font_path, $text);
    $text_width = $boundingbox[2] - $boundingbox[0];
    $col_center = ($col_drawing * $x_gap + ($col_drawing - 1) * $cols_width) + $cols_width / 2;
    return $col_center - $text_width / 2;
}

// Функція малювання колонки
function draw_col($percent, $col_text, $c1, $c2, $c3)
{
    global $col_drawing, $x_gap, $cols_width, $y_gap, $cols_max_height, $height, $image, $font_size, $border_color, $font_path;
    $col_drawing++;
    
    $percent_text = $percent * 100 . '%';
    
    $percent_text_width = bbox($percent_text, $col_drawing);
    $name_text_width = bbox($col_text, $col_drawing);

    $x1 = $col_drawing * $x_gap + ($col_drawing - 1) * $cols_width;
    $y1 = $y_gap + $cols_max_height * (1 - $percent);
    $x2 = $col_drawing * $x_gap + $col_drawing * $cols_width;
    $y2 = $height - $y_gap;


    $color = imagecolorallocate($image, $c1, $c2, $c3);
    imagefilledrectangle($image, $x1, $y1, $x2, $y2, $color);
    imagettftext($image, $font_size, 0, $percent_text_width, $y1-10, $border_color, $font_path, $percent_text); // percent text
    imagettftext($image, $font_size, 0, $name_text_width, $height - $y_gap / 2, $border_color, $font_path, $col_text); // col name text
}

imagettftext($image, 25, 0, 10, 40, $border_color, $font_path, 'Воронов Микола 451 група'); // Підпис

// Завантаженння колонок з XML та малювання
foreach ($xml->col as $col) 
{
    $name = (string)$col->name;
    $percent = (float)$col->percent;
    $c1 = (int)$col->color['c1'];
    $c2 = (int)$col->color['c2'];
    $c3 = (int)$col->color['c3'];

    draw_col($percent, $name, $c1, $c2, $c3);
}

// Виведення зображення
header('Content-Type: image/png');
imagepng($image);

// Звільнення ресурсів
imagedestroy($image);
?>