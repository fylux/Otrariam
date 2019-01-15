<?php
class Mapa
{
	private $id_ciudad;
	private $mysqli;
	private $t_actual;
	private $comerciantes_disponibles;

	public function __construct()
	{
		$this->mysqli=DB::Get();
		$this->id_ciudad=$_SESSION['ju_ciudad'];
		$this->t_actual=strtotime(date('Y-m-d H:i:s'));
		$sql="select x,y from mapa where id_casilla = $this->id_ciudad limit 1";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();
		$this->x=$reg['x'];
		$this->y=$reg['y'];
	}

	public function variables_mapa() //Configura las coordenadas para que no se salgan del mapa
	{
		//

		//
		if (is_numeric($_GET['x']) && is_numeric($_GET['y']))
		{
			$this->x = safe($_GET['x']);
			$this->y = safe($_GET['y']);

			//Si se sale del mapa
			if ($this->x > 8)
			{
				$this->x = 8;
			}
			if ($this->x < 3)
			{
				$this->x = 3;
			}
			if ($this->y > 8)
			{
				$this->y = 8;
			}
			if ($this->y < 3)
			{
				$this->y = 3;
			}
		}

		else
		{
			header("Location:index.php");
		}
	}


	public function mapa()
	{
		$this->variables_mapa(); //Inicia las coordenadas

		for ($i=1;$i<11;$i++) //Hacemos que se muestren 5 filas
		{
			for ($j=1;$j<11;$j++) //Hacemos que se muestren 5 cuadros por fila
			{	
				$sql="select nombre,x,y,tipo,capital from mapa where x =$j and y =$i"; //Comprueba si el terreno esta ocupado
				$res=$this->mysqli->query($sql);
				$reg=$res->fetch_array();
				if ($reg["tipo"]=="Pueblo") //Sino esta ocupado se pone verde
				{
					if ($reg['x']>$this->x+2||$reg['x']<$this->x-2||$reg['y']>$this->y+2||$reg['y']<$this->y-2)
					{
					?>
					<span class="casilla"  style="display:none" id="<?php echo $reg['x']."|".$reg['y'];?>"><a href="aldea.php?x=<?php echo $reg['x'];?>&y=<?php echo $reg['y'];?>"><div class="casilla1" title="<?php echo $reg["nombre"]; ?>"><p><?php echo $reg['x']."-".$reg['y']; ?></p><?php		
					}
					else
					{
					?>
					<span class="casilla"  id="<?php echo $reg['x']."|".$reg['y'];?>" ><a href="aldea.php?x=<?php echo $reg['x'];?>&y=<?php echo $reg['y'];?>"><div class="casilla1" title="<?php echo $reg["nombre"]; ?>"><p><?php echo $reg['x']."-".$reg['y']; ?></p><?php		
					}
				}
				else //Si esta ocupado se pone rojo
				{
					if ($reg['x']>$this->x+2||$reg['x']<$this->x-2||$reg['y']>$this->y+2||$reg['y']<$this->y-2)
					{
						if ($reg['capital']=='tesoro')
						{
						?>
						<span class="casilla"  id="<?php echo $reg['x']."|".$reg['y'];?>" style="display:none"><a href="aldea.php?x=<?php echo $reg['x'];?>&y=<?php echo $reg['y'];?>"><div class="casilla3" title="<?php echo $reg["nombre"]; ?>"><p><?php echo $reg['x']."-".$reg['y']; ?></p><?php		
						}
						else
						{
						?>
						<span class="casilla"  id="<?php echo $reg['x']."|".$reg['y'];?>" style="display:none"><a href="aldea.php?x=<?php echo $reg['x'];?>&y=<?php echo $reg['y'];?>"><div class="casilla2" title="<?php echo $reg["nombre"]; ?>"><p><?php echo $reg['x']."-".$reg['y']; ?></p><?php		
						}
					}
					else
					{
						if ($reg['capital']=='tesoro')
						{
						?>
						<span class="casilla" id="<?php echo $reg['x']."|".$reg['y'];?>"><a href="aldea.php?x=<?php echo $reg['x'];?>&y=<?php echo $reg['y'];?>"><div class="casilla3" title="<?php echo $reg["nombre"]; ?>"><p><?php echo $reg['x']."-".$reg['y']; ?></p><?php	
						}
						else
						{
						?>
						<span class="casilla" id="<?php echo $reg['x']."|".$reg['y'];?>"><a href="aldea.php?x=<?php echo $reg['x'];?>&y=<?php echo $reg['y'];?>"><div class="casilla2" title="<?php echo $reg["nombre"]; ?>"><p><?php echo $reg['x']."-".$reg['y']; ?></p><?php	
						}
					}
				}
				
				?>
				</div>
				</a>
				</span>
				<?php
			}
		}
	}

	public function botones_mapa() //Muestra los botones para navegar por el mapa
	{
		?>
		<div id="tabla_mapa">

			<div id="mapa_up" onclick='mover("arriba")'></div>

			<div id="izquierda"><div id="mapa_left" onclick='mover("izquierda")'></div></div>
			
			<div id="derecha"><div id="mapa_right" onclick='mover("derecha")'></div></div>
			
			<div id="mapa_bottom" onclick='mover("abajo")'></div>

		</div>
		<?php
	}


	public function detalles_aldea()//Datos de la aldea al hacer click en ella en el mapa
	{
		if (is_numeric($_GET['x']) && is_numeric($_GET['y']))
		{
			$x=safe($_GET['x']);
			$y=safe($_GET['y']);
			//Datos de la aldea seleccionada
			$sql="select id_usuario,x,y,habitantes,tipo from mapa where x = $x and y = $y limit 1";
			$res=$this->mysqli->query($sql);
			$reg=$res->fetch_array();
			if ($reg['id_usuario']==0)
			{
				?>
				<h2>Espacio para fundar aldea</h2>
				<div id="perfil_aldea">
				<!--Detalles de la aldea-->
				<p>Eje X: <b><?php echo $reg['x']; ?></b></p>
				<p>Eje Y: <b><?php echo $reg['y']; ?></b></p>

				<p>Sin propietario</p>

				</div>
				<img src="img/elementos/aldea/aldea.png" class="img_aldea" >
				<div id="bottom_perfil_aldea">
				<?php
				$sql="select * from tropas where id_ciudad=$this->id_ciudad";
				$res=$this->mysqli->query($sql);
				$red=$res->fetch_array();
				if ($red['tropa9']>=3)
				{
					$sql="select * from planos where id_ciudad=$this->id_ciudad";
					$res=$this->mysqli->query($sql);
					if ($res->num_rows>0)
					{
						$red=$res->fetch_array();
						if ($this->t_actual < $red['tiempo']+259200)
						{
							echo "No tienes los planos.";
						}
						else
						{
							?>	
							<a href='fundar_aldea.php?x=<?php echo $reg['x'];?>&y=<?php echo $reg['y']; ?>'>Fundar Aldea<i class="icon-double-angle-right"></i></a><br/>
							<?php
						}
					}
					else
					{
						echo "No tienes los planos.";
					}
				}
				else
				{
					echo "No tienes colonos suficientes para fundar la aldea.";
				}
				?>
				</div>
				<?php
			}
			else
			{
				?>
				<div id="perfil_aldea">

				<!--Detalles de la aldea-->
				<p>Eje X: <b><?php echo $reg['x']; ?></b></p>
				<p>Eje Y: <b><?php echo $reg['y']; ?></b></p>

				<p>Propietario: <b><?php echo Datos::usuario($reg['id_usuario']);?></b></p>
				<p>Habitantes: <b><?php echo $reg['habitantes']; ?></b></p>
				</div>
				<?php
				if ($reg['tipo']=='Barbaros')
				{
					?>
					<img src="img/elementos/edificios/fuerte.png" class="img_aldea">
					<?php
				}
				else
				{
					?>
					<img src="img/elementos/aldea/ciudad.png" class="img_aldea">
					<?php
				}
				?>
				<div id="bottom_perfil_aldea">
				<a href='edificio.php?s=<?php echo Datos::slotPorEdificio('mercado');?>&x=<?php echo $reg['x']; ?>&y=<?php echo $reg['y']; ?>'>Enviar Recursos<i class="icon-double-angle-right"></i></a><br />
				<a href='mover_tropas.php?x=<?php echo $reg['x']; ?>&y=<?php echo $reg['y']; ?>'>Enviar Tropas<i class="icon-double-angle-right"></i></a><br/>
				<a href='perfil.php?usuario=<?php echo Datos::usuario($reg['id_usuario']);?>'>Ver Perfil<i class="icon-double-angle-right"></i></a>
				</div>
				<?php
			}
		}

	}

	public function tesoros()
	{
		$sql="select * from tesoros where id_ciudad=$this->id_ciudad";
		$res=$this->mysqli->query($sql);
		if($res->num_rows>1)
		{
			echo "Ya tienes 2 tesoros, no puedes saber donde esta el tercero";
		}
		else
		{
			$sql="select * from tesoros";
			$res=$this->mysqli->query($sql);
			while($reg=$res->fetch_assoc())
			{
				echo "<b>".$reg['nombre']."</b> se encuentra en <b>".Datos::ciudad($reg['id_ciudad'])."</b><br />";
			}
		}
	}
}

?>