<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Guia</title>


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
        
        <h2>Guía</h2>

        <p>
        ¡Bienvenido a <b>Otrariam</b>!
        </p>

        <p>
            Otrariam es un juego de navegador sobre la Antigua Roma donde puede jugar
            miles de jugadores con el objetivo de desarrollar el imperio más poderoso.
        </p>

        <p>
            Para esto tendrás que desarrollar una economía, comerciar, formar un buen ejército, conseguir aliados, establecer relaciones diplomáticas...
        </p>

        <p>
            Existe la tribu de los Muhan y el juego lo ganará el jugador que consiga hacerse con sus tres tesoros.
        </p>

        <hr />

        <h3>Guía</h3>

        <p>
            En todas las páginas del juego encontrarás dos menús, el menú superior:
            <br />
            <img src="img/guia/menu_superior.png" width="450" height="100"/>
            <br/>
            La primera casilla te lleva a la visión general de la aldea, la segunda a la visión militar, la tercera al mapa y la cuarta a los reportes.
            <br />
            <br />
            Y el menú lateral
            <br />
            <img src="img/guia/menu_lateral.png" width="150" height="150"/>
            <br />
            Puedes acceder a tu perfil, la mensajería, tu alianza, el ranking, los tesoros y cerrar sesión.
            <br />
            <br />
            En la parte derecha de la interfaz te saldrán los ataques o refuerzos que envíes o recibas para que lo puedas saber en cada momento.
        </p>

        <h4>Visión General</h4>

        <p>
        Esta es la visión general de tu ciudad:<br />
        <img src="img/guia/vision_general1.png" width="800" height="550"/>
        <br />
        Desde aquí puedes ver los edificios que tienes construidos, tu producción de recursos por hora y los edificios que se están construyendo.
        Si haces click en un solar vacío de tu aldea te mostrará todos los edificios que puedes construir:
        <br />
        <img src="img/guia/construir.png" width="200" height="220"/>
        <br />
        Si tienes suficientes recursos y cumples los requisitos te dará la opción de "Construir", solo tienes que hacer click y comenzará la construcción.
        <br />
        Si haces click en un edificio que has construido te mostrará una página con sus datos y la opción de subirlo de nivel:
        <br />
        <img src="img/guia/lenador.png" width="350" height="180"/>
        </p>

        <h4>Visión Militar</h4>
        <p>
        Esta es la visión militar de tu ciudad:<br />
        <img src="img/guia/reclutar.png" width="800" height="550"/>
        <br />
        En esta vista te aparecen las distintas tropas que puedes reclutar, cada tropa tiene un coste en recursos, consume una cantidad de cereal y tiene un tiempo de reclutamiento .Seguramente la primera vez que te metas no podrás reclutar ninguna pues no tendrás los edificios necesarios.
        <br />
        <br />
        En la parte superior hay un menú que te permite reclutar, ver los ataques que envías, ver los refuerzos que tienes, ver los datos de las tropas y los datos de los edificios.
        <br />
        <br />
        <span style="display:inline-block;">
            Si entras en movimientos verás lo siguiente:
            <br />
            <img src="img/guia/ataques.png" width="350" height="220"/>
        </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <span style="display:inline-block;">
            Si entras en refuerzos verás lo siguiente:
            <br />
            <img src="img/guia/refuerzos.png" width="350" height="220"/>
        </span>
        <br />
        Desde los movimientos puedes ver los ataques que estás enviando o recibiendo además de los refuerzos que envías o recibes. Ten en cuenta que no podrás saber la cantidad de tropas con las que te atacan o refuerzan hasta que lleguen a tu aldea.
        <br />
        <br />
        Desde los refuerzos puedes ver los refuerzos que han enviado otros jugadores a tu aldea o los refuerzos que tu has enviado a otras, y los puedes retirar o devolver.
        <br />
        <br />
        <br />
        Además está la parte de "Tropas" donde podrás ver las características de las tropas existentes.
        <br />
        <img src="img/guia/tropas.png" width="350" height="220"/>
        <br />
        <br />
        Finalmente encontramos la parte "Edificios" donde se muestran las características que tendrán los edificios en cada uno de sus niveles<br />
        <img src="img/guia/edificios.png" width="350" height="220"/>
        </p>

        <h4>Mapa</h4>
        <p>
            El mapa te permite saber tu posición y la del resto de jugadores. Si sistema es muy sencillo, usa las flechas de navegación para moverte por él y haz click en una aldea para saber más sobre ella.<br />
            <img src="img/guia/mapa.png" width="350" height="220"/>
        </p>

        <h4>Reportes</h4>
        <p>
            Los reportes son informes que se producen después de cada batalla, refuerzo o intercambio comercial. Si es una batalla mostrará las tropas que lucharon, los edificios destruidos, el botín y si se consiguió un tesoro. Si es un refuerzo se mostrarán las tropas que se reciben como refuerzo. Y si es un intercambio comercial dirá si es un envió, recibo o intercambio de ofertas.<br />
            Si tienes reportes sin leer te saldrá un número al lado de su icono y el reporte en negrita.
            <br />
            <br />
            Aquí se ve el listado de reportes (en este caso militares)
            <br />
            <img src="img/guia/reportes.png" width="650" height="220"/>
            <br />
            Al hacer click en un reporte veremos algo como esto:
            <br />
            <img src="img/guia/reporte.png" width="350" height="250"/>
        </p>

        <h4>Perfil</h4>
        <p>
            Tu perfil te muestra a ti y al resto de jugadores tu puntuación, tu alianza, tus aldeas, tu descripción y la opción de enviarte un mensaje.
            <br />
            <br />
            <img src="img/guia/perfil.png" width="600" height="250"/>
            <br />
            Para dar una buena impresión al resto de jugadores te recomendamos que pongas una buena descripción.
        </p>

        <h4>Mensajería</h4>
        <p>
            El sistema de mensajería es realmente sencillo. Los mensajes sin leer se te muestran como un número en el menú. Puedes redactar un mensaje desde la misma mensajería o haciendo desde el perfil de un jugador. Para contestar un mensaje solo tienes que leerlo y te permitirá reemitir una contestación:
            <br />
            <br />
            <span style="display:inline-block;">
            Si entras en mensajería veras tus mensajes:
            <br />
            <img src="img/guia/mensajeria.png" width="600" height="170"/>
            </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span style="display:inline-block;">
                Si haces click en un mensaje te mostrará esto:
                <br />
                <img src="img/guia/mensaje.png" width="600" height="170"/>
            </span>
        </p>

        <h4>Alianza</h4>
        <p>
            Una Alianza es una unión de jugadores con el objetivo de luchar por un objetivo común. Es muy útil formar parte de una alianza porque te da apoyo cuando lo necesitas. Para formar parte de una Alianza debes construir la embajada, podrás recibir una invitación de una alianza o fundar la tuya propia por 500 de cada materia. Según el nivel de tu embajada en tu alianza podrán hacer un número concreto de jugadores.
            <br />
            <img src="img/guia/alianza.png" width="600" height="250"/>
            <br />
            Cuando entres en tu Alianza lo primero que verás será algo como esto. En la parte de arriba se muestra un menú con lo que puedes hacer que dependerá de los cargos que tengas.<br />
            Si tienes una alianza puedes: invitar a jugadores, expulsarlos, darles cargos, declarar tratados o guerras con otras alianzas, enviar comunicados a los miembros o añadir una descripción a esta. Además en el mercado tendrás la opción de ofrecer ofertas solo a miembros de tu alianza.
        </p>

        <h4>Comercio</h4>
        <p>
            Para poder realizar actividades comerciales necesitas el mercado. Por cada nivel que amplíes el mercado recibirás un comerciante más, cada comerciante puede transporta un máximo de 500 recursos en total. Desde el mercado puedes hacer ofertas de un recurso por otro, o enviar recursos a otros jugadores. Si ves que tu oferta no da fruto siempre la puedes cancelar. Cualquier intercambio comercial que hagas será mostrado en un reporte.
        </p>

        <h4>Fundar Aldeas</h4>
        <p>
            Un jugador puede fundar aldeas para aumentar la grandeza de su imperio. Para poder fundar una aldea necesita el Palacio a nivel 3, lo cual te permitirá:<br />
            Reclutar 3 colonos en el cuartel que son necesarios para fundar tu nueva aldea<br />
            <img src="img/guia/colonos.png" width="400" height="150"/>
            <br />
            Además podrás producir unos planos en el palacio que tardan cuatro días en producirse. Son esenciales para poder fundar la nueva aldea:
            <br />
            <img src="img/guia/planos.png" width="400" height="250"/>
            <br />
            Una vez tengas 3 colonos y los planos busca una casilla vacía en el mapa y selecciónala, si cumples los requisitos te saldrá lo siguiente:
            <br />
            <img src="img/guia/fundar.png" width="350" height="220"/>
            <br />
            Ya solo queda esperar que los colonos lleguen a dicha ciudad y podrás empezar a levantarla.

        </p>
        <br />
        <br />
        <hr />
        <h3>Recursos</h3>

        <p>
        Existen cuatro edificios de producción: Leñador, Barrera, Mina y Granja.
        </p>

        <h3>Tropas</h3>

        <p>
            Existen varios tipos de tropas, cada uno con sus características. Las tropas tienen un consumo de cereal.<br />
            Los onagros sirven para destruir edificios, necesitas enviar tantos onagros como el nivel del edificio que quieras dañar, un ejemplo: si quieres hacer que un edificio pase del nivel 7 al 5 debes enviar 7+6=13 onagros, porque cada nivel que quieras bajar requiere que envíes su número de onagros. Los onagros hacen el doble de daño si no van a destruir.
        </p>

        <h3>Tesoros</h3>

        <p>
            Existen tres ciudades que perteneces a la tribu de los Muhan. Estas ciudades están defendidas y si eres capaz de destruir todas las tropas que hay en ellas puedes llevarte su tesoro. Puedes ver la localización de los tesoros en el apartado "tesoros" del menu de la izquierda.
            <br />
            Cuando un jugador consigue un tesoro este pasa a su aldea por lo que si otro jugador lo quiere conseguir deberá vencer en una batalla en su aldea.
            <br />
            Finalmente ganará el jugador que reúna los tres tesoros y los defienda al menos un día.
        </p>


    </div>


</div><!--center_wrap-->


</div><!--Wrap-->


<?php
include("include/footer.php");
?>



</body>
</html>
