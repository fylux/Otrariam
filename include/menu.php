
<div class="circulo"><div class="circulo2 menu1" title="Aldea">
	<a href="index.php"><img src="img/elementos/menu/ciudad.png"></a>
</div></div>

<div class="circulo"><div class="circulo2 menu2" title="Ejército">
	<a href="militar.php"><img src="img/elementos/menu/campamento.png"></a>
</div></div>

<div class="circulo"><div class="circulo2 menu3" title="Mapa">
	<?php $ald->ir_mapa(); ?>
</div></div>

<div class="circulo"><div class="circulo2 menu4" title="Reportes">
	<a href="reportes.php"><img src="img/elementos/menu/vigia.png"></a>
	<?php
	$reportesNoLeidos=Datos::reportesTropasNoLeidos($_SESSION['ju_ciudad']);
	if ($reportesNoLeidos>0)
	{
		?><div id="detalle_menu" style="border-radius:2px;color:blue;font-weight:bold;margin-top:-30px;float:left;margin-left:-10px;height:20px;background:grey;opacity:0.8;padding:0px 5px 0px 5px;">
		<?php echo $reportesNoLeidos;?></div><?php
	}
	$reportesNoLeidos=Datos::reportesComercioNoLeidos($_SESSION['ju_ciudad']);
	if ($reportesNoLeidos>0)
	{
		?><div id="detalle_menu" style="border-radius:2px;color:blue;font-weight:bold;margin-top:-30px;float:left;margin-left:70px;height:20px;background:grey;opacity:0.8;padding:0px 5px 0px 5px;">
		<?php echo $reportesNoLeidos;?></div><?php
	}
	?>
</div></div>

