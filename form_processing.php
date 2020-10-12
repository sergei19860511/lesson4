<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style type="text/css">
		.photo{
			float: left;
	    width: 20%;
	    padding: 5px;
	    margin-right: 6.365%;
	    margin-bottom: 20px;
		}
	</style>
</head>
<body>

</body>
</html>

<?php

$wayBig = "big/" .$_FILES["photo"]["name"];
$waySmall = "small/";
$tmpPaht = "tmpPaht/";

 function resize($file)
 {
 global $tmpPaht;
 
 // Ограничение по ширине в пикселях
 $max_thumb_size = 250;
 
 // Качество изображения по умолчанию
 if ($quality == null)
 $quality = 75;
 
 // Cоздаём исходное изображение на основе исходного файла
 if ($file['type'] == 'image/jpeg')
 $source = imagecreatefromjpeg($file['tmp_name']);
 elseif ($file['type'] == 'image/png')
 $source = imagecreatefrompng($file['tmp_name']);
 elseif ($file['type'] == 'image/gif')
 $source = imagecreatefromgif($file['tmp_name']);
 else
 return false;
 
 // Поворачиваем изображение
 if ($rotate != null)
 $src = imagerotate($source, $rotate, 0);
 else
 $src = $source;
 
 // Определяем ширину и высоту изображения
 $w_src = imagesx($src); 
 $h_src = imagesy($src);
 
 // В зависимости от типа (эскиз или большое изображение) устанавливаем ограничение по ширине.
 
 $w = $max_thumb_size;
 
 // Если ширина больше заданной
 if ($w_src > $w)
 {
 // Вычисление пропорций
 $ratio = $w_src/$w;
 $w_dest = round($w_src/$ratio);
 $h_dest = round($h_src/$ratio);
 
 // Создаём пустую картинку
 $dest = imagecreatetruecolor($w_dest, $h_dest);
 
 // Копируем старое изображение в новое с изменением параметров
 imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
 
 // Вывод картинки и очистка памяти
 imagejpeg($dest, $tmpPaht . $file['name'], $quality);
 imagedestroy($dest);
 imagedestroy($src);
 
 return $file['name'];
 }
 else
 {
 // Вывод картинки и очистка памяти
 imagejpeg($src, $tmpPaht . $file['name'], $quality);
 imagedestroy($src);
 
 return $file['name'];
 }
 }
 
 $name = resize($_FILES['photo']);

 // Загрузка файла и вывод сообщения
 if (!@copy($tmpPaht . $name, $waySmall . $name))
 echo '<p>Что-то пошло не так.</p>';
 else
 //echo '<p>Загрузка прошла удачно <a href="' . $waySmall . $_FILES['photo']['name'] . '">Посмотреть</a>.</p>';
 
 // Удаляем временный файл
 unlink($tmpPaht . $name);
   
	 move_uploaded_file($_FILES["photo"]["tmp_name"], $wayBig);

		$a = scandir("small/");
		foreach ($a as $value) {
		$result = strstr($value,'.');
		  if ($result==".jpg" || $result==".jpg" || $result==".jpeg") {
				echo "<div class='photo'><a href ='big/".$value."' target = '_blank'><img src='small/".$value."'></a></div>";	
			}
		}
	
	?>