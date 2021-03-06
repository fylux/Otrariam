

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ejército</title>
<?php
include("class/class.php");
$ald=new Aldea();
$ald->comprobar_recursos('no');
$tro=new Tropas();
$ciudad=$_SESSION['ju_ciudad'];
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

        <div id="recursos">
            <?php include("include/recursos.php"); ?>
        </div>

        <div id="wrap_aldea">
        
        <div id="wrap_ejercito">

            <div id="seccion_cuartel">
                <div class="seccion_edificio" id="a_cuartel1">Reclutar</div>
                <div class="seccion_edificio" id="a_cuartel2">Movimientos</div>
                <div class="seccion_edificio" id="a_cuartel3">Refuerzos</div>
                <div class="seccion_edificio" id="a_cuartel4">Tropas</div>
                <div class="seccion_edificio" id="a_cuartel5">Edificios</div>
            </div>

            <br/><br/>
            
            <div id="cuartel1">
            <h3>Reclutar tropas</h3>
            
            <?php
            $ald->muestraCuartel();
            ?>
            </div>


            <div id="cuartel2">
            <h3>Movimientos del ejército</h3>
            <br/>

            <?php
            $tro->mostrar_movimientos_tropas();
            ?>
            </div>


            <div id="cuartel3">
            <h3>Refuerzos militares</h3>
            <br/>
            
            <b>Refuerzos recibidos en esta aldea</b><br />
            <hr />
            <?php
            $tro->mostrar_refuerzos('aqui');
            ?>
            <b>Refuerzos enviados a otras aldeas</b><br />
            <hr />
            <?php
            $tro->mostrar_refuerzos('alli');
            ?>
            </div>

            <div id="cuartel4">
            <h3>Tropas</h3>
            <?php
            echo $tro->datosTropas();
            ?>
            </div>

            <div id="cuartel5">
            <h3>Edificios</h3>
            <?php
            echo $ald->costesEdificios();
            ?>
            </div>

        </div><!--/#wrap_ejercito-->


        <div id="info_tropas">
        <?php
        $tro->mostrar_tropas();
        ?>
        </div>


        </div><!--/#wrap_aldea-->

    </div><!--/#right-->


</div><!--/#bottom-->


</div>
</div><!--/#wrap-->




</body>
</html>
<?php
$ald->comprobar_recursos('si');
?>