<!doctype html>
<html>
    <head>
      <meta charset="utf-8">
        <title>FilesByDc</title>
<!---css<link rel="stylesheet" type="text/css" href="lightbox/css/jquery.lightbox-0.5.css" media="screen" />-->
    <link type="text/css" href="css/metro.css" rel="stylesheet" >
   	<link href="upload/css/ajaxfileupload.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="crop/css/imgareaselect-animated.css">
	
    <!----jquery<script type="text/javascript" src="script/jquery.min.js"></script>
    <script type="text/javascript" src="lightbox/js/jquery.lightbox-0.5.js"></script>----->
  	<script type="text/javascript" src="script/jquery-1.8.0.min.js"></script>
   	<script type="text/javascript" src="script/jquery-ui-1.8.23.custom.min.js"></script>
		
  	<script type="text/javascript" src="crop/js/jquery.imgareaselect.js"></script><!----crop----->
    <script type="text/javascript"  src="upload/js/ajaxfileupload.js"></script><!----upload----->
	
	
     
     
<script type="text/javascript">
//jquery ui
	$(function(){
	// Dialog			
	        $('#content').dialog({
	            autoOpen: false,
	            width: 600,
				modal:true,
				closeOnEscape: true,
				position:['top',10],
				resizable:false,
	            
				buttons: [
        			  {
						text:"Guardar",
						"id": "cropImage",
						click: function(){
							$('#cropImage').fadeOut(500);
							
					  }
											  
					  },
					  
					   {
				
					text: "Seleccionar",
			        "id": "buttonUpload",
			        click: function(e){
            
					var documents = document.getElementById('inputs').value;	
							if(documents != ''){
								e.preventDefault();
								$('#fileToUpload').click();
										
								}
								else{window.alert("Ingrese un Documento Valido")};
					  }},
					  
					  {
						text:"Aceptar",
						"id": "cerrarButton",
						
						click:function () {
							
							$('#buttonUpload').fadeIn(500);
													
							var rutatemporal = document.getElementById('image_ruta').value;
							var rutafinal = document.getElementById('rutatemporal').value;
							
							$("#buttonUpload").attr("disabled",false);
							
							$("#thumbs").remove();
							$("#divImagenesCargadas").remove();
							$("#photos").remove();
							
							$("#content").empty();

							$("#animation").remove();
							
					
							$("#content").html('<div><input type="text" id="inputs" name="inputs"' + 
								'value="19440740"><input id="fileToUpload" type="file" name="fileToUpload"' +
								'accept="image/jpeg, image/x-png"'+
								'onChange="if(!this.value.length){return false;}'+
					          	'else {return ajaxFileUpload();}" ><div id="divImagenesCargadas"></div>'+
								'<div id="thumbs"></div>');
							$("#thumbs").html("");
							
					
							$("#retorno").html("<img src='"+rutafinal+"'"+
								"style='box-shadow: 5px 5px 5px #888888;border-radius:5px;" +
								"width:250px;height:300px' >");
		               	    $(this).dialog("close");
        		       	 }
					  
					  },
					  
					  ],
			       
												    
				  				
	            
	        });	
			
					
	 		$('#openDialog').click(function () {
		            $('#content').dialog('open');
					$('#cropImage').hide();
					$('#cerrarButton').hide();
					
	        });		
 
  
	/*//funcion cuando se hace click en boton de subir imagen valida documento y lanza evento click de input file				
	$('#buttonUpload').click(function(e){
		
		var documents = document.getElementById('inputs').value;	
			if(documents != ''){
				e.preventDefault();
				$('#fileToUpload').click();
			}
	
			else{window.alert("Ingrese un Documento Valido");}
	
		}
	  );*/
	
	
	
	});
	
	
//funciones de uploadfile
	
	function ajaxFileUpload()
	{
	var documento = document.getElementById('inputs').value;
	
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
	
		$.ajaxFileUpload
		(
		
			{
	
				url:'upload/upload.php',
				secureuri:false,
				cache:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				data:{name:'logan', id:'id', docafi:'19440740', docbene:documento  },
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
					 if(data.error != ''){alert(data.error);}
					 
					 else
					{
						
					$('#buttonUpload').fadeOut(0);
					$('#cropImage').fadeIn(500);
					$('#cerrarButton').fadeIn(500);	
						
					var ancho = 250;	// Tamanio maximo de imagen
					var alto = 300;	//Tamanio maximo de altura
						
					var x = (ancho/data.width); 
					var y = (alto/data.height); 
					var w = Math.round(data.width * x);
					var h = Math.round(data.height * y);
					
					campo = "<table width='35%' border='0'><tr><td align='center' valign='top' width='10%'><table border='0'><tr><td align='center'></td></tr><tr><td><div id='photos'></div></td></tr></table><td align='center'><img src='"+data.msg+"' style='border-radius:5px;width:"+w+"px;height:"+h+"px;box-shadow: 5px 5px 5px #888888;' id=\"photo\"><input type='hidden' id='H_alto' value='"+data.height+"'><input type='hidden' id='H_ancho' value='"+data.width+"'></td></tr></table><input type='hidden' name='image_name' id='image_name' value='"+data.names+"' ><input type='hidden' name='image_ruta' id='image_ruta' value='"+data.msg+"' >";
					$("#divImagenesCargadas").append(campo);
					$("#buttonUpload").attr("disabled",true);
	
			
				
				
//funciones de crop

//animacion de seleccion
$.extend($.imgAreaSelect.prototype, {
    animateSelection: function (x1, y1, x2, y2, duration) {
        var fx = $.extend($('<div/>')[0], {
            id: 'animation',
			ias: this,
            start: this.getSelection(),
            end: { x1: x1, y1: y1, x2: x2, y2: y2 }
        });

        $(fx).animate({
            cur: 1
        },
        {
            duration: duration,
            step: function (now, fx) {
                var start = fx.elem.start, end = fx.elem.end,
                    curX1 = Math.round(start.x1 + (end.x1 - start.x1) * now),
                    curY1 = Math.round(start.y1 + (end.y1 - start.y1) * now),
                    curX2 = Math.round(start.x2 + (end.x2 - start.x2) * now),
                    curY2 = Math.round(start.y2 + (end.y2 - start.y2) * now);
                fx.elem.ias.setSelection(curX1, curY1, curX2, curY2);
                fx.elem.ias.update();
            }
        });
    }
});

function preview(img, selection) {
   	//colocar de valor fijo el tamanio que se coloco en el thumbnail preview
    var scaleX = 125 / (selection.width || 1);
    var scaleY = 150 / (selection.height || 1);
  
    $('#photos + div > img').css({
       	//width de imagen de origen en valor a multiplicar
	    width: Math.round(scaleX * 250) + 'px',
        //height de imagen de origen en valor a multiplicar
		height: Math.round(scaleY * 300) + 'px',
        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
	
}


function getSizes(im,obj)
	{
		var exten = document.getElementById('image_name').value;
		var extens = exten.length-3;
		var extension = exten.substr(extens, 3);
		var H_alto = document.getElementById('H_alto').value;
		var H_ancho = document.getElementById('H_ancho').value;		
		var x_axis = obj.x1;
		var x2_axis = obj.x2;
		var y_axis = obj.y1;
		var y2_axis = obj.y2;
		var thumb_width = obj.width;
		var thumb_height = obj.height;
		if(thumb_width > 0)
			{
						$.ajax({
							type:"GET",
							url:"crop/crop.php?"+
							    "id=1"+
								"&img="+$("#image_name").val()+
								"&extension="+extension+
								"&ruta=../"+data.ruta+
								"&rutareturn="+data.ruta+
								"&ancho="+H_ancho+
								"&tancho="+thumb_width+
								"&cancho="+x_axis+
								"&alto="+H_alto+
								"&talto="+thumb_height+
								"&calto="+y_axis+"",

							cache:false,
							
							success:function(rsponse)
								{
								$(".imgareaselect-border1").remove();
								$(".imgareaselect-border2").remove();
								$(".imgareaselect-border3").remove();
								$(".imgareaselect-border4").remove();
								$(".imgareaselect-handle ").remove();
								$(".imgareaselect-outer").remove();
								$(".imgareaselect-selection").remove();
								$("#divpreview").remove();
								$("#thumbs").hide();
								$("#thumbs").fadeIn(500);
								$("#thumbs").html("");
								$("#thumbs").css({
							            float: 'left',
							            position: 'relative',
        							    overflow: 'hidden',
							            width: '260px',
										height:'310px',
							           	top: '-13px',
										left: '30%',
			
						        });
					$("#thumbs").prepend("<img src='"+rsponse+"'"+
					"style='box-shadow: 5px 5px 5px #888888;border-radius:5px;" +
					"width:250px;height:300px' ><input type='hidden' id='rutatemporal' value='"+rsponse+"'>");
		
					$("#photo").hide();
								}
						});
					
			}
		
	}

$(function () {
	//imagen preview
    $('<div id="divpreview" style="box-shadow: 5px 5px 5px #888888;border-radius:5px;">'+
	  '<img src="'+data.msg+'" style="position:relative; width:125px; height:150px;"></div>')
        .css({
            float: 'left',
            position: 'relative',
            overflow: 'hidden',
            width: '125px',
            height: '150px',
			
        })
     
	    .insertAfter($('#photos'));
	

    ias = $('img#photo').imgAreaSelect({ fadeSpeed: 400, handles: true,
        instance: true, onSelectChange: preview/* onSelectEnd: getSizes*/});

    $('#cropImage').click(function () {
	   getSizes(1,ias.getSelection());
    });
		   
	$('#rectangle').click(function () {
	   // If nothing's selected, start with a tiny area in the center
      if (!ias.getSelection().width)
		
        ias.setOptions({ show: true, x1: 199, y1: 149, x2: 200, y2: 150 });
        ias.animateSelection(100, 75, 300, 225, 'slow');
    });
});
		
					}
				  }
				},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
		
		return false;
	
	}
//fin de funciones de uploadfile


</script>	   
    </head>

<body>
<a href="javascript:void(0);" id="openDialog">Agregar Imagenes</a>
<div id="retorno"></div>
  <div id="content" align="center" title="Agregar Imagenes">
  
	 <input type="hidden" id="inputs" name="inputs" value="19440740">
        <input id="fileToUpload" type="file" name="fileToUpload" 
         accept="image/jpeg, image/png" onChange="if(!this.value.length){return false;}
          	 else {return ajaxFileUpload();}" >
            
        <div id="divImagenesCargadas"></div>
		<div id="thumbs"></div>	
  </div>	
  
</body>




</html>