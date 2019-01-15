<?php
if(Datos::tropa("tropa$i")=='caballeria_ligera'){
echo "<img src='img/elementos/tropas/caballeria_l.png' class='icono_reporte' title='Caballería liger'>";
}
else if(Datos::tropa("tropa$i")=='caballeria_pesada'){
echo "<img src='img/elementos/tropas/caballeria_p.png' class='icono_reporte' title='Caballería pesada'>";
}
else
{
	echo "<img src='img/elementos/tropas/".Datos::tropa("tropa$i").".png' class='icono_reporte' title='".Datos::tropa("tropa$i")."'>";
}
?>