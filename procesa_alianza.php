<?php
include("class/class.php");
include("class/mensajeria.php");
include("class/alianza.php");

$ali=new Alianza();
if ($_GET['a']==1)
{
	$ali->aceptarInvitacion();
}
else if ($_GET['a']==2)
{
	$ali->rechazarInvitacion();
}
else if ($_GET['a']==3)
{
	$ali->eliminarInvitacion();
}
else if ($_GET['a']==4)
{
	$ali->fundarAlianza();
}
else if ($_GET['a']==5)
{
	$ali->expulsarMiembro();
}
else if ($_GET['a']==6)
{
	$ali->darCargo();
}
else if ($_GET['a']==7)
{
	$ali->declararDiplomacia();
}
else if ($_GET['a']==8)
{
	$ali->aceptarTratado();
}
else if ($_GET['a']==9)
{
	$ali->cambiarDatos();
}
else if ($_GET['a']==10)
{
	$ali->enviarComunicado();
}
?>