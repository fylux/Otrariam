

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mensajería</title>
<?php
include("class/class.php");
include("class/mapa.php");
$ald=new Aldea();
$ald->comprobar_recursos('no');
$map=new Mapa();
?>

<!-- Estilos CSS -->
<link rel="stylesheet" type="text/css" href="estilos/aldea.css" />

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
-->

</head>
<body>



<div id="wrap">
<div id="wrap_center">


<div id="top">
    
    <div id="logo">
        
    </div>

    <div id="menu">
        <?php include("include/menu.php"); ?>
    </div>

</div>


<div id="bottom">

    <div id="left">
        <?php include("include/left.php");?>
    </div>

    <div id="right">

        <div id="wrap_aldea">
        
        <div id="wrap_centro">
            En la Roma en que nos encontramos, lo único que mantiene con esperanza a los hombres son los tres tesoros de los Muhan.<br /><br />
            Cuenta la leyenda que estos tres tesoros son <b>La Espada de Rómulo</b>, <b>Las Memorias de Remo</b> y <b>El Amuleto de Marte</b>. Quien reuna estos tres tesoros conseguirá todo el poder del Imperio.
            <br /><br />
            ¡Cuidado! Las naciones se preparan arrebatar estos tesoros a los Muhan o a quien se los robe, no olvides cual es tu objetivo, consigue todos los tesoros a cualquier costa, sin importar que poblados haya que quemar, o alianzas destruir.
            <hr />
            <br />
            <span style="font-size:20px">
    			<?php
                $map->tesoros();
    			?>
            </span>


        </div><!--/#wrap_centro-->


        </div><!--/#wrap_aldea-->

    </div><!--/#right-->


</div><!--/#bottom-->


</div>
</div><!--/#wrap-->



</body>

</html>
<?php
?>