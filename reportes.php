
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reportes</title>
<?php
include("class/class.php");
$ald=new Aldea();
$ald->comprobar_recursos('no');
$tro=new Tropas();
$mer=new Mercado();
$ciudad=$_SESSION['ju_ciudad'];
?>


<!-- Estilos CSS -->
<link rel="stylesheet" type="text/css" href="estilos/aldea.css" />

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>

<style type="text/css">
<?php
if (isset($_GET['s']))
{
    if ($_GET['s']==1)
    {
        ?>
        #reportes1
        {
            display: block;
        }
        #reportes2
        {
            display: none;
        }
        <?php
    }
    else if ($_GET['s']==2)
    {
        ?>
        #reportes2
        {
            display: block;
        }
        #reportes1
        {
            display: none;
        }
        <?php
    }
}
?>
</style>

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
        
        <div id="reportes">
            <?php
            if (isset($_GET['r']))
            {
                ?>
                <div class="seccion_edificio"><a href="reportes.php?s=1">Tropas</a></div> 
                <div class="seccion_edificio"><a href="reportes.php?s=2">Comercio</a></div>
                <?php
            }
            else
            {
                ?>
                <div class="seccion_edificio" id="a_reportes1">Tropas</div> 
                <div class="seccion_edificio" id="a_reportes2">Comercio</div>
                <?php
            }
            ?>
			<?php
                    if (isset($_GET['r']))
                    {
                        ?>
                        <div id="reportes1">
                        <?php
                        $tro->mostrar_reporte();
                        ?>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <span id="reportes1">
                        <?php
                        $tro->mostrar_reportes();
                        ?>
                        </span>
                        <?php
                    }
                    if (isset($_GET['r']))
                    {
                        ?>
                        <div id="reportes2">
                        <?php
                        $mer->mostrar_reporte();
                        ?>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div id="reportes2">
                        <?php
                        $mer->mostrar_reportes();
                        ?>
                        </div>
                        <?php
                    }
           /* if (isset($_GET['s']) && $_GET['s']==1)
            {
                ?>
                <script type="text/javascript">
                document.getElementById("reportes1").style.display="block";
                document.getElementById("reportes2").style.display="none";
                </script>
                <?php
            }
            else if (isset($_GET['s']) && $_GET['s']==2)
            {
                ?>
                <script type="text/javascript">
                document.getElementById("reportes1").style.display="none";
                document.getElementById("reportes2").style.display="block";
                </script>
                <?php
            }*/
			?>

        </div><!--/#reportes-->

         <div id="info_aldea">

        </div>
        </div><!--/#wrap_aldea-->

    </div><!--/#right-->


</div><!--/#bottom-->


</div>
</div><!--/#wrap-->



</body>

</html>
<?php
$ald->comprobar_recursos('no');
?>