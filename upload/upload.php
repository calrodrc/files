<?php
	$error = "";
	$msg = "";
	$fileElementName = 'fileToUpload';
	
	function eliminarDir($carpeta)
		{
		foreach(glob($carpeta . "/*") as $archivos_carpeta)
		{
			if (is_dir($archivos_carpeta))
			{eliminarDir($archivos_carpeta);}
			else
			{unlink($archivos_carpeta);}
		}
		rmdir($carpeta);
	}
	
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{
			case '1':
				$error = 'Ha excedido el tamaño del archivo';
			break;
			
			case '2':
				$error = 'Ha excedido el tamaño del archivo';
			break;
			
			case '3':
				$error = 'El archivo ha sido parcialmente subido';
			break;
			
			case '4':
				$error = 'No Hay Archivo para Subir';
			break;
			
			case '6':
				$error = 'Se ha perdido la carpeta temporal';
			break;
			
			case '7':
				$error = 'Error al escribir en disco';
			break;
			
			case '8':
				$error = 'No es una extension de imagen Valida';
			break;
			
			case '999':
				$error = 'Consulte al administrador del Sistema';
			break;				
				
		}
	}
	

	elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
	{
		$error = 'No Hay Archivo para Subir...';
	}
	
	else {
	
	$type = $_FILES['fileToUpload']['type']; //tipo de archivo
		
	if(eregi('image/', $type)) {
	 $a = 0 ;
 	 $b = 0 ;
	 
	  if(!eregi('image/png', $type)) 
		{		
		$a = 1;
		 }
	
	   if(!eregi('image/jpeg', $type)) {
		$b = 1;
		}	
		
		if($a == 1 && $b != 0){
			$error = 'No es un archivo de imagen valido\n Seleccione un archivo PNG o JPG...';		
		}
		if($b == 1 && $a != 0){
			$error = 'No es un archivo de imagen valido\n Seleccione un archivo PNG o JPG...';	
		}

			
	
	
	if($a == '0' || $b == '0'){	
	
			$imagen = $_FILES['fileToUpload']['tmp_name'];
			$pix = getimagesize("$imagen"); 
			$ancho = $pix[0];
			$alto = $pix[1];  

			$afiliado = $_REQUEST['docafi'];
			$beneficiario = $_REQUEST['docbene'];
			
			$uploaddir = "./../images/afiliado/".$afiliado."/";
			
			mkdir($uploaddir,0777,true);
		
			$names = $_FILES['fileToUpload']['name'];
		
			$name = ($beneficiario.''.strrchr($names, '.'));
			$uploadfile = $uploaddir.basename($name);
			
			$ruta = 'images/afiliado/'.$afiliado.'/';
		
			if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile)){
		
					//eliminarDir($uploaddir);
					
					$msg .= $ruta.$name;
			
					@unlink($_FILES['fileToUpload']);	
					
			}
	
		}
			
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"width: '" . $ancho . "',\n";
	echo				"height: '" . $alto . "',\n";
	echo				"names: '" . $name . "',\n";
	echo				"ruta: '" . $ruta . "',\n";
	echo				"msg: '".$msg."'\n";
	echo "}";
	
	}
	else{
		$error = 'No es un archivo de imagen valido\n Seleccione un archivo PNG o JPG...';	
	}
	}
	
	
?>