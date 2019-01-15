<?php
include("class/class.php");
include("class/admin.php");
$adm=new Admin();
if (isset($_GET['s']) and $_GET['s']==1)
{
  $adm->notificarError();
  exit;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>


<!-- Estilos CSS -->
<link rel="stylesheet" type="text/css" href="estilos/estilos.css" />

<!--<script type="text/javascript" src="js/jquery.js"></script>-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>

<!--Slider-->
<link rel="stylesheet" type="text/css" href="estilos/slider.css" />


<!--Google Analytics-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39366535-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


</head>
<body>


<?php
include("include/nav.php");
?>


<div id="wrap">

<div id="center_wrap">


    <div id="wrap_notificar">
        <?php
        if (isset($_GET['m']) and $_GET['m']==1)
        {
          echo "<b>Gracias por notificarlo</b>";
        }
        ?>
        <h2>Notificar un error</h2>

        <p>¿Has encontrado un error? <br/>Entendemos que el juego no es perfecto, por eso necesitamos tu ayuda.
            <br/>Ayúdanos a mejorar el juego notificando aquellos errores que encuentres mientras juegas.<br/><br/>
            Cuéntanos el problema que te ha surgido, y qué estabas haciendo mientras. 
            <br/><br/>Además, tras comprobar el error, recibirás <img src="img/elementos/tropas/legionario.png" class="icono_notificar">
            <strong>50 legionarios</strong> de parte del Staff en agradecimiento.
        </p>

        <form name="notificar_error" class="class_form" method="post" action="notificar.php?s=1">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <textarea name="error" required></textarea>
            <input type="submit" value="Notificar error">
        </form>
        <span style="font-size:10px;"><i>La recompensa no se puede usar durante la primer semana de juego</i></span>

    </div>


</div><!--center_wrap-->


</div><!--Wrap-->


<?php
include("include/footer.php");
?>



</body>
</html>
