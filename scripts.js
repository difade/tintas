var patron = new Array(2,2,4)
var patron2 = new Array(1,3,3,3,3)
function mascara(d,sep,pat,nums){
if(d.valant != d.value){
	val = d.value
	largo = val.length
	val = val.split(sep)
	val2 = ''
	for(r=0;r<val.length;r++){
		val2 += val[r]	
	}
	if(nums){
		for(z=0;z<val2.length;z++){
			if(isNaN(val2.charAt(z))){
				letra = new RegExp(val2.charAt(z),'g')
				val2 = val2.replace(letra,'')
			}
		}
	}
	val = ''
	val3 = new Array()
	for(s=0; s<pat.length; s++){
		val3[s] = val2.substring(0,pat[s])
		val2 = val2.substr(pat[s])
	}
	for(q=0;q<val3.length; q++){
		if(q ==0){
			val = val3[q]
		}
		else{
			if(val3[q] != ''){
				val += sep + val3[q]
				}
		}
	}
	d.value = val
	d.valant = val
	}
}

function esFechaValida(fecha){
    if (fecha != undefined && fecha.value != '' ){
        if (!/^\d{2}\/\d{2}\/\d{4}$/.test(fecha.value)){
            alert('formato de fecha no valido (dd/mm/aaaa)');
            return false;
        }
        var dia  =  parseInt(fecha.value.substring(0,2),10);
        var mes  =  parseInt(fecha.value.substring(3,5),10);
        var anio =  parseInt(fecha.value.substring(6),10);
 
    switch(mes){
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            numDias=31;
            break;
        case 4: case 6: case 9: case 11:
            numDias=30;
            break;
        case 2:
            if (comprobarSiBisisesto(anio)){ numDias=29 }else{ numDias=28};
            break;
        default:
            alert('Fecha introducida erronea');
            return false;
    }
 
        if (dia>numDias || dia==0){
            alert('Fecha introducida erronea');
            return false;
        }
        return true;
    }
}
 
function comprobarSiBisisesto(anio){
if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) {
    return true;
    }
else {
    return false;
    }
}

function limita(obj,elEvento, maxi)
{
  var elem = obj;

  var evento = elEvento || window.event;
  var cod = evento.charCode || evento.keyCode;

    // 37 izquierda
	// 38 arriba
	// 39 derecha
	// 40 abajo
	// 8  backspace
	// 46 suprimir

  if(cod == 37 || cod == 38 || cod == 39
  || cod == 40 || cod == 8 || cod == 46)
  {
	return true;
  }

  if(elem.value.length < maxi )
  {
    return true;
  }

  return false;
}

function cuenta(obj,evento,maxi,div)
{
	var elem = obj.value;
	var info = document.getElementById(div);

	info.innerHTML = maxi-elem.length;
} 


////////////////////////// VERIFICA HORAS Y APLICA MASCARA
function valida_horas(edit, ev)
{
    li = new Array(':');

    if(edit.value.length == 2)
    edit.value += ":";
}

function verifica_horas(obj)
{
    if(obj.value.length < 5)
        obj.value = '';
    else
    {
        hr = parseInt(obj.value.substring(0,2));
        mi = parseInt(obj.value.substring(3,5));
        if((hr < 0 || hr > 23) || (mi < 0 || mi > 59))
        {
            obj.value = '';
            alert('Hora no valida');
        }
    }
}
