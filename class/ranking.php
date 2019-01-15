<?php

class Ranking
{
	private $mysqli;

	public function __construct()
	{
		$this->mysqli=DB::Get();
		$this->id_usuario=Datos::id($_SESSION["ju_nom"]);
	}

	public function mostrar_ranking() //Muestra el ranking
	{
		$nRegistros=5; //Numero de registros por pagina
		$puntos=0; //Puntos para clasificar

		$sql="select * from usuarios where ip !='muhan'";
		$res=$this->mysqli->query($sql);
		$n_paginas=ceil($res->num_rows/$nRegistros); //Numero de paginas
		$usuarios=array();
		while($reg=$res->fetch_array())
		{
			$sql="select * from mapa where id_usuario=".$reg['id_usuario'];
			$red=$this->mysqli->query($sql);
			$puntos=0;
			while($rem=$red->fetch_array())
			{
				$puntos+=$rem['habitantes'];
			}
			$usuarios[]=array($puntos,$reg['id_usuario'],$reg['nombre']);
		}
		rsort($usuarios);
		$cUsuarios=count($usuarios);
		$posicionPropia=0;

		if (isset($_GET['p']) and is_numeric($_GET['p'])) //Si se solicita una pagina valida
		{
			if ($cUsuarios>$nRegistros) $cUsuarios=4;
			$pagina=ceil($_GET['p']);
			$posicionPropia=($pagina-1)*5;
			//echo $pagina." ".$posicionPropia." ".$cUsuarios;
		}
		else
		{
			for ($i=0;$i<$cUsuarios;$i++)
			{
				if ($usuarios[$i][1]==$this->id_usuario && !isset($_GET['p']))
				{
					$posicionPropia=$i;
				}
			}
			
			if ($posicionPropia<$nRegistros)
			{
				$posicionPropia=0;
				$pagina=1;
			}
			if ($cUsuarios>$nRegistros) $cUsuarios=4;

			if ($posicionPropia!=0)
			{
				$posicionPropia=floor($posicionPropia/$nRegistros)*$nRegistros;
				$pagina=$posicionPropia/$nRegistros+1;
			}

		}
		?>
		<table border="0" cellspacing="0" cellpadding="0" class="tabla_ranking">

			<thead>
			<tr>
			<td>Jugador</td>
			<td>Puntuación</td>
			</tr>
			</thead>

			<tbody>

		<?php
		for($i=$posicionPropia;$i<=$cUsuarios+$posicionPropia;$i++)
		{
			if (!isset($usuarios[$i]))
			{
				$i=($cUsuarios+$posicionPropia)+1;
			}
			else
			{
			?>
			<tr>
				<td><a href='perfil.php?usuario=<?php echo $usuarios[$i][2];?>'><?php echo $usuarios[$i][2];?></a></td>
				<td><?php echo $usuarios[$i][0];?></td>
			</tr>
			<?php
			}
		}
		?>
			
			</tbody>
		</table>


		<table border="0" cellspacing="0" cellpadding="0" class="tabla_flechas">
			<tr>

		<?php
		
		/*Flechas*/

		if ($pagina==1)
		{
			?>
				<td><i class="icon-double-angle-left"></i></td>
				<td><i class="icon-angle-left"></i></td>
			<?php
		}
		else
		{
			?>
				<td><a href="ranking.php?p=1" title="Primero"><i class="icon-double-angle-left"></i></a></td>
				<td><a href="ranking.php?p=<?php echo $pagina-1;?>" title="Anterior"><i class="icon-angle-left"></i></a></td>
			<?php
		}


		if ($pagina==$n_paginas)
		{
			?>
				<td><i class="icon-angle-right"></i></td>
				<td><i class="icon-double-angle-right"></i></td>
			<?php
		}
		else
		{
			?>
				<td><a href="ranking.php?p=<?php echo $pagina+1;?>" title="Siguiente"><i class="icon-angle-right"></i></a></td>
				<td><a href="ranking.php?p=<?php echo $n_paginas;?>" title="Último"><i class="icon-double-angle-right"></i></a></td>
			<?php
		}?>
				</tr>
		</table>
		<?php
	}
}

?>