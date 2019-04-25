<?php
// definimos un array de valores en php
$GruposCodFam=array(1,1,2);
$GruposCodGrp=array(1,2,1);
$GruposDesc=array("Grupo 1 Fam 1","Grupo 2 Fam 1","Grupo 1 Fam 2");
?>

<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">

var GruposCodFam=<?php echo json_encode($GruposCodFam);?>;
var GruposCodGrp=<?php echo json_encode($GruposCodGrp);?>;
var GruposDesc=<?php echo json_encode($GruposDesc);?>;



function cargarSelect2(familia_seleccionada)
{
    /**
     * Este array contiene los valores sel segundo select
     * Los valores del mismo son:
     *  - hace referencia al value del primer select. Es para saber que valores
     *  mostrar una vez se haya seleccionado una opcion del primer select
     *  - value que se asignara
     *  - testo que se asignara
     */
    var cantgrupos = 1;

    if(familia_seleccionada==0)
    {
        // desactivamos el segundo select
        document.getElementById("select2").disabled=true;
    }else{
        // eliminamos todos los posibles valores que contenga el select2
        document.getElementById("select2").options.length=0;
 
        // añadimos los nuevos valores al select2
        document.getElementById("select2").options[0]=new Option("Selecciona una opcion", "0");
        for(recorre=0;recorre<GruposCodFam.length;recorre++)
        {
            // unicamente añadimos las opciones que pertenecen al id seleccionado
            // del primer select
            if(GruposCodFam[recorre]==familia_seleccionada)
            {
                document.getElementById("select2").options[cantgrupos]=new Option(GruposDesc[recorre], GruposCodGrp[recorre]);
                cantgrupos ++;
            }
        }
 
        // habilitamos el segundo select
        document.getElementById("select2").disabled=false;
    }
}
 
/**
 * Una vez selecciona una valor del segundo selecte, obtenemos la información
 * de los dos selects y la mostramos
 */

function seleccinado_select2(value)
{
    var v1 = document.getElementById("select1");
    var valor1 = v1.options[v1.selectedIndex].value;
    var text1 = v1.options[v1.selectedIndex].text;
    var v2 = document.getElementById("select2");
    var valor2 = v2.options[v2.selectedIndex].value;
    var text2 = v2.options[v2.selectedIndex].text;
 
    alert("Se ha seleccionado el valor "+valor1+" ("+text1+") del primer select y el valor "+valor2+" ("+text2+") del segundo select");
}

</script>

</head>

 <body>

<form>
    <p>
        <select id='select1' onchange='cargarSelect2(this.value);'>
            <option value='0'>Selecciona una opcion</option>
            <option value='1'>FAMILIA 1</option>
            <option value='2'>FAMILIA 2</option>
            <option value='3'>FAMILIA 3</option>
        </select>
    </p>
 
    <p>
        <select id='select2' onchange='seleccinado_select2();' disabled>
            <option value='0'>Selecciona una opcion</option>
        </select>
    </p>
</form>

</body>

</html>