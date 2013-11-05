<?php
//tamanio de imagen destino
$ImagenAncho = 250;
$ImagenAlto = 300;

//hello
if(isset($_GET['id']) and $_GET['id'] == "1")
	{
	extract($_GET);
	$Cx = ceil(($cancho / $ImagenAncho)*$ancho); //coordenada x
	$Cy = ceil(($calto / $ImagenAlto)*$alto); //coordenada y

	$Wx = ceil(($tancho / $ImagenAncho)*$ancho); //ancho de corte imagen origen
	$Wy = ceil(($talto / $ImagenAlto)*$alto); //alto de corte imagen origen
	
	
	
	switch($extension){	
	 case 'jpg':		
	
		$imgDestino = imagecreatetruecolor($ImagenAncho,$ImagenAlto); //tamanio de imagen destino
		$imgOrigen = imagecreatefromjpeg($ruta.$img); //creando imagen a partir de jpg origen
		imagecopyresampled($imgDestino,$imgOrigen,0,0,$Cx,$Cy,$ImagenAncho,$ImagenAlto,$Wx,$Wy);	
		imagejpeg($imgDestino,$ruta.$img,100);
		echo $rutareturn.$img."?".time();
		
	break;
	
	case 'png':	
	
		$imgDestino = imagecreatetruecolor($ImagenAncho,$ImagenAlto);
		$imgOrigen = imagecreatefrompng($ruta.$img);
		imagecopyresampled($imgDestino,$imgOrigen,0,0,$Cx,$Cy,$ImagenAncho,$ImagenAlto,$Wx,$Wy);	
		imagepng($imgDestino,$ruta.$img);
		echo $rutareturn.$img."?".time();
			
	break;

	
		
	 }
	}
	
	?>
