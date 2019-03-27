<?php //PHP ADODB document - made with PHAkt 2.8.0?>

 <SCRIPT language="JavaScript1.2" event="onkeypress" for="document">
	{		

		if (!event.srcElement.type_letra)
			return true;
        
		switch(event.srcElement.type_letra) {
			case 'L':
				if ((((window.event.keyCode<97) || (window.event.keyCode>122))&&((window.event.keyCode<65)||(window.event.keyCode>90))) && (window.event.keyCode!=32) )
				 {  
				  return false;
				 }
				break;
			case 'N':
				if (((window.event.keyCode<48)|| (window.event.keyCode>57))&& (window.event.keyCode!=46))
                {
					return false;
				}
				break;
			case 'E':
				if ((window.event.keyCode<48)|| (window.event.keyCode>57))
                {
				       
					return false;
				}
				break;	
             case 'U':
                 if (((window.event.keyCode>=33) && (window.event.keyCode<=39)) || (window.event.keyCode>=123))
                  {
					return false;
					break;
				  }

                 if ((window.event.keyCode>=97) && (window.event.keyCode<=122))
                  {
				    window.event.keyCode= window.event.keyCode-32 ; 
					return true;
				  }				       				       				 
				break;
		}
	}

	</SCRIPT>
	
	<script language="JavaScript" type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+' Debe ser un Numero Entre : ['+min+' y '+max+']\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('El Siguiente Error a Ocurrido  :\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
function pregunta(){ 
    if (confirm('¿Estas seguro  que desea eliminar este o estos registros?')){ 
       document.formulario.submit() 
    } 
} 

function preguntam(mensa){ 
    if (confirm(mensa)){ 
       document.formulario.submit() 
    } 
} 

function pasar_parametro(){ 
       document.formulario.submit() 
} 

function alerta(mensa){ 
alert(mensa);
} 

function touppercase(o){
    o.value=o.value.toUpperCase().replace(/([^0-9A-Z \r\n ])/g,"");
}

//-->
</script>

