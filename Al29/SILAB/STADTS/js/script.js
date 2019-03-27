
var intervalo = 60000; // 600000 milisegundos = 10 minutos
var filtro = {tarea:"T", orden: false};
var aux = true;
var orden = 'ultimo_resultado, fecha_ultima_ejecucion, hora_ultima_ejecucion';
var direccion = "ASC";
var filtro = "Todo";
var categoria = "Todo";
var servidor = parametro('data');

//Ejecutar  solo cuando la página entera esté lista
window.onload = function () {
    refrescar();
    var tabla = $("#tabla");
}

//Ejecutar peticion AJAX cada intervalo de tiempo
function refrescar() {
		var url=window.document.URL;
		var instancia;
		//Ubicar la página que se visualiza para actualizar
		if (url.search("index.php")>-1) // Index
			get_instancias();
		else if (url.search("estatus.php")>-1) {
			get_paquetes();
		} else if (url.search("historia.php")>-1) {
			get_congelados();
		} else get_instancias();
    setTimeout("refrescar()", intervalo); //Refrescar petición luego de cumplir el intervalo
}

function get_instancias() {
  $.ajax({
    url: './layout.php',
    type: "post",
    data: { data : true },
    success: function(respuesta) {
		var instancias = $("#instancias");
		var instanciashtml="";
		var leyenda = $("#serv");
		var leyendahtml="";
		var serv="";
		var myObj = respuesta.substring(1, respuesta.length);
		myObj=JSON.parse(myObj);
		data=myObj.elementos;
		for (i in data) {
			var clasei = "";
			var clases = "";
			if (data[i].estado==0) {clasei = "errori"; clases = "errors";}
			instanciashtml=instanciashtml+(
				'<li class="instancia '+clasei+'">'
			+	'<dl>'
            +       '<dd class="detalle">'
            +            '<h4 class="nombre-instancia">'+data[i].descripcion+'</h4>'
            +            '<p>'+data[i].n_jobs+' Trabajos<br>'+data[i].n_dts+' Paquetes DTS<br>'+data[i].n_respaldo+' Respaldos BD</p>'
            +            '<h5 class="nombre-instancia">'+data[i].nombre+'</h5>'
            +        '</dd>'
            +        '<dd  id="'+data[i].nombre+'" onclick="get_estatus(this.id)" class="servidor '+clases+'" style="background-color:'+data[i].color+';">'
			+        '</dd>'
			+	'</dl>'
			+	'</li>'
			);
			if(serv.search(data[i].servidor)<0){
				serv=serv+data[i].servidor;
				leyendahtml=leyendahtml+(
						'<li class="leyenda_instancia">'
					+    	'<dl>'
					+        	'<dd class="leyenda color" style="background-color:'+data[i].color+';"></dd>'
					+        	'<dd class="nombre-servidor">'+data[i].servidor+'</dd>'
					+    	'</dl>'
					+	'</li>'
				);
			}
		}
		
		instancias.html(instanciashtml);
		leyenda.html(leyendahtml);
		
    },
    error: function() {
      console.log("No se ha podido obtener la información");
    }
  });
}

function get_paquetes() {
  var instancia_nombre = $("#paquete-servidor");
  instancia_nombre.html(servidor);
  $.ajax({
    url: './instancia.php',
    data: { data : servidor, orden : orden, direccion : direccion, tipo : filtro, ocurrencia : categoria},
    success: function(respuesta) {
		var myObj = respuesta.substring(1, respuesta.length);
		myObj=JSON.parse(myObj);
		data=myObj.jobs;
		if(data) {
			var paquetes = $("#paquetes");
			var paqueteshtml="";
			for (i in data) {
				var tiempo_limite='';
				var botonopcion='<input type="button" id="'+data[i].nombre+'::'+servidor+'" class="boton ejecutar" value="[Ejecutar]">';
				if (data[i].estatus.search("Congelado")>-1){
					botonopcion='<input type="button" id="'+data[i].nombre+'::'+servidor+'" class="boton descongelar" value="[Descongelar]">';
					tiempo_limite=' '+data[i].estatus.substring(9, data[i].estatus.length);
					data[i].estatus="Congelado";
				}
				var horario='';
				if (data[i].horario.ocurrencia_detalle && data[i].horario.frecuencia)
					horario= data[i].horario.ocurrencia_detalle+'. '+data[i].horario.frecuencia;
				paqueteshtml=paqueteshtml+(
					'<tr>'
				+            '<th><strong>Nombre:</strong> '+data[i].nombre+'</br><strong>Descripción:</strong> '+data[i].descripcion+'</th>'
				+			 '<th>'+data[i].tipo+'</th>'
				+			 '<th>'+horario+'</th>'
				+			 '<th>'+botonopcion+'</th>'
				+            '<th class="resultado-'+data[i].ultimo_resultado+'">'+data[i].ultimo_resultado+'</th>'
				+            '<th class="resultado-'+data[i].ultimo_resultado+'">'+data[i].fecha_ultima_ejecucion+' '+data[i].hora_ultima_ejecucion+'</th>'
				+            '<th class="estatus-'+data[i].estatus+'">'+data[i].estatus+tiempo_limite+'</th>'
				+   '</tr>'
				);
			}
			paquetes.html(paqueteshtml);
		}
		},
    error: function() {
      console.log("No se ha podido obtener la información");
    }
  });
}

function get_congelados() {
  $.ajax({
    url: './congelados.php',
    data: { data : true },
    success: function(respuesta) {
		var myObj = respuesta.substring(1, respuesta.length);
		myObj=JSON.parse(myObj);
		data=myObj;
		var paquetes = $("#paquetes");
		var paqueteshtml="";
		if(data) {
			for (i in data) {
				botonopcion='<input type="button" id="'+data[i].nombre+'::'+data[i].propietario+'" class="boton descongelar" value="[Descongelar]">';
				tiempo_limite=' '+data[i].estatus.substring(9, data[i].estatus.length);

				paqueteshtml=paqueteshtml+(
					'<tr>'
				+            '<th><strong>Nombre:</strong> '+data[i].nombre+'</th>'
				+			 '<th>'+data[i].tipo+'</th>'
				+			 '<th>'+botonopcion+'</th>'
				+            '<th class="estatus-Congelado">'+data[i].estatus+' desde '+data[i].fecha_ultima_ejecucion+' '+data[i].hora_ultima_ejecucion+'</th>'
				+   '</tr>'
				);
			}
		} else {
			paqueteshtml=(
					'<tr>'
				+            '<th colspan="4">No hay trabajos congelados en este momento.</th>'
				+   '</tr>'
				)
		}
		paquetes.html(paqueteshtml);
		},
    error: function() {
      console.log("No se ha podido obtener la información");
    }
  });
}

function get_estatus(servidor){
	window.open('./estatus.php?data='+servidor,'_self');
}
function ejecutar_job(id){
	var job = id.split('::');
	if (confirm('¿Confirma que desea ejecutar el job\n'
				+job[0]+',\npropiedad de '+job[1]+'?')) {
		$.ajax({
		url: './job.php',
		data: { nombre : job[0], propietario : job[1] , opcion : 1},
		success: function(respuesta) {
			if (respuesta) 
				alert(respuesta);
		},
		error: function() {
		  alert("No se ha podido realizar el pedido.");
		}
	  });
	}
}

function descongelar_job(id){
	var job = id.split('::');
	if (confirm('¿Confirma que desea descongelar el job\n'
				+job[0]+',\npropiedad de '+job[1]+'?')) {
		$.ajax({
		url: './job.php',
		data: { nombre : job[0], propietario : job[1] , opcion : 2 },
		success: function(respuesta) {
			if (respuesta) 
				alert(respuesta);
		},
		error: function() {
		  alert("No se ha podido realizar el pedido.");
		}
	  });
	}
}

function set_orden (orden){
	this.orden=orden;
	set_direccion ();
	if (direccion=="ASC") {
		$('#tipo').removeClass( "headerSortUp" ).addClass( "cabecera" );
		$('#fecha_ultima_ejecucion, hora_ultima_ejecucion').removeClass( "headerSortUp" ).addClass( "cabecera" );
		$('#estatus').removeClass( "headerSortUp" ).addClass( "cabecera" );
		$('#nombre').removeClass( "headerSortUp" ).addClass( "cabecera" );
		$('#'+orden).addClass( "headerSortDown" ); 
	}
	else {
		$('#tipo').removeClass( "headerSortDown" ).addClass( "cabecera" );
		$('#fecha_ultima_ejecucion, hora_ultima_ejecucion').removeClass( "headerSortDown" ).addClass( "cabecera" );
		$('#estatus').removeClass( "headerSortDown" ).addClass( "cabecera" );
		$('#nombre').removeClass( "headerSortDown" ).addClass( "cabecera" );
		$('#'+orden).addClass( "headerSortUp" ); 
	} 
	refrescar();
}

function set_direccion (){
	if (direccion=="ASC")
		this.direccion="DESC";
	else this.direccion="ASC";
}

function set_filtro (){

}

$(document).on('click', '.ejecutar', function () { 
	ejecutar_job(this.id);
	refrescar();
}); 

$(document).on('click', '.descongelar', function () { 
	descongelar_job(this.id);
	refrescar();
}); 

$(document).on('click', '.filtrar', function () { 
	filtro=$("#filtro :selected").val();
	categoria=$("#categoria :selected").val();
	refrescar();
}); 

function parametro(nombre) { 
	return (location.search.split(nombre + '=')[1] || '').split('&')[0]; 
} 
