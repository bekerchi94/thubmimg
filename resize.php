<?php

class imgresize
{

private function resizefile($filename,$w,$h)  // функция для сжатие изображения
{
	// определение формата изображения
	if((preg_match('/.(.jpg)$/',$filename)) | (preg_match('/.(.jpeg)$/',$filename)))  
	{
		$im=imagecreatefromjpeg($path.$filename);
		$format='jpg';
	}
	else
	if(preg_match('/.(.png)$/',$filename))
	{
		$im=imagecreatefrompng($filename);
		$format='png';
	}else
		$format='x';
	// если изображения имеет формат jpg или png то обработываем
	if(($format=='jpg')|($format=='png'))
	{
		// определение первоначального размера
		$width=imagesx($im); 
		$height=imagesy($im);
		
	// если изображения больше сжимаемых размеров то сжимаем иначе пишем что меньше
		if(($w<$width)||($h<$height))
		{
			$nm=imagecreatetruecolor($w,$h);	//создаем пустое изображение по размеру
			imagecopyresized($nm,$im,0,0,0,0,$w,$h,$width,$height); // копирием изменение из источника 
			// сохроняем с соответствии с форматом
			if($format=='jpg')
			{
				imagejpeg($nm,$path.$filename);
			}
			if($format=='png')
			{
				imagepng($nm,$path.$filename);
			}
			echo" изображения $filename успешно сжат до размеров $w x $h\n";
		}
		else echo "изображения $filename имеет размер меньший или равный чем $w x $h\n";
	}else echo "изображения $filename имеет не поддерживаюший формат или это не файл изображений\n";
}

private function resizepath($path,$w,$h,$req)    //функция обработки папки
{
	if(file_exists($path) && is_dir($path)) //если директория существует
	{ 
		$res=scandir($path);
		$files=array_diff($res,array('.','..')); //сканиреум папку
		if(count($files)>0) // если в директории имеется файлы
		{ 
			foreach($files as $file)
			{  
				if(is_file("$path/$file")) 
				{ 
					if (preg_match('/.(jpg|png|jpeg)$/',"$path/$file"))
					{
						$this->resizefile("$path/$file",$w,$h);//если файл изображений то обработываем
					}
				}
				else
				if(is_dir("$path/$file"))
				{ // если это папка и рекурсия включена то обработываем тоже
					if($req==true)
					{ 
						$this->resizepath("$path/$file",$w,$h,$req);
					}
				}
			}
		}
		else echo "Директория $path не содержит файлов\n";
	}else echo "Директория $path не существует\n";
}

public function resize($file,$wd,$hg,$req) // функция сжатия аргументы: имя и путь и файлу, ширина, высота, рекурсия 
{
	if($file!==null)
	{
		if($wd===null)
		{
			$wd=1200;
		}
		if($hg===null)
		{
			$hg=800;
		}
		if($req===null)
		{
			$req=false;
		}
		if(is_file($file))
		{
			$this->$path='';
			$this->resizefile($file,$wd,$hg);
		}else
		if(is_dir($file))
		{ 
			$this->resizepath($file,$wd,$hg,$req);
		}
	}else
	{
		echo "Для изменение должны ввести минимум 1 параметр:  путь к папке или файлу\n";
		echo "1-параметр путь или путь и название сжимаемого файла\n 2-параметр ширина изменения после сжатия(если не задать то примет 1200)\n";
		echo"3-параметр высота изображения после сжатия(если не задать то примет 800)\n 4-параметр true или false рекурсия (обработка дочерных папок, если не задать то примет false)";
	}
}



}

?>