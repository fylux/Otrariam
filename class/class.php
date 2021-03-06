<?php
ob_start();
include ('./FirePHPCore/FirePHP.class.php'); //FirePHP para poder debuguear
include ('init.php');				//Constantes y la session
include ('seguridad.php');			//Funciones de seguridad
include ('datos_auxiliares.php');	//Funciones para obtener datos concretos
include ('mercado.php');			//Funciones del mercado
include ('tropas.php');				//Funciones para las tropas
include ('motor_tropas.php');		//Motor para procesar tropas
include ('mysqli.php');

class Aldea
{
	private $x;				//La coordenada X del mapa
	private $y;				//La coordenada Y del mapa
	private $ps_edificio;	//Lo que produce un edificio por segundo
	private $p_edificio;	//Lo que produce un edificio en una actualizacion
	private $t_transcurrido;//Tiempo pasado desde que se mando construir el edificio hasta ahora
	private $t_actual;		//Hora actual
	private $id_ciudad;		//Id de la capital
	private $id_usuario;	//Id del usuario que ha iniciado sesion
	private $usuario;		//Usuario que ha iniciado sesion
	private $last_update;	//Ultima vez que actualizo
	private $capacidad;		//Capacidad del almacen
	private $mysqli;		//Para conectar a la base de datos
	private $construira_almacen=0; //Hora a la que se construira el almacen
	private $tiempo_almacen;	//Tiempo que le queda al almacen para construirse
	private $firephp;		//Para hacer debugueos
	private $mercado;		//Clase que tiene las funciones del mercado
	private $tropas;		//Clase que tiene las funciones de las tropas
	private $mTropas;		//Clase que tiene el motor del juego

	public function __construct($a=null,$requerir=null) //Comprobamos que ha iniciado sesion
	{
		$this->firephp = FirePHP::getInstance(true);	//Con true decimos que si se ejecuten los debugueos

		if (!isset($_SESSION["ju_nom"]))	//Sino esta logueado
		{
			header("Location:login.php");
		}

		if (isset($_SESSION["ju_nom"]))	//Si esta todo en orden
		{
			$this->mysqli=DB::Get();
			$this->usuario=$_SESSION["ju_nom"];
			$this->id_usuario=Datos::id($this->usuario);
			$this->id_ciudad=$_SESSION['ju_ciudad'];
			$this->t_actual=strtotime(date('Y-m-d H:i:s'));
			$sql="select produccion from edificios_aldea where id_ciudad=$this->id_ciudad and edificio = 'Almacen' limit 1";
			$res=$this->mysqli->query($sql);
			$reg=$res->fetch_array();
			$this->capacidad=$reg['produccion'];
			$this->ciudad=Datos::ciudad($this->id_ciudad);
			$sql="select x,y from mapa where id_casilla = $this->id_ciudad";
			$res=$this->mysqli->query($sql);
			$reg=$res->fetch_array();
			$this->x=$reg['x'];
			$this->y=$reg['y'];
			$this->mercado=new Mercado();
			$this->tropas=new Tropas();
			$this->mTropas=new MotorTropas();
			$this->comerciantes_disponibles=$this->mercado->comerciantesDisponibles();
		}
	}

	public function produccion_hora($edificio)	//Muestra la produccion por hora del edificio seleccionado
	{
		$edificio=utf8_encode($edificio);
		$sql="select produccion from edificios_aldea where id_ciudad = $this->id_ciudad and edificio = '$edificio' limit 1";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();
		if ($edificio == 'granja') //Si el edificio es la granja le restamos el consumo de cereal
		{
			$nTropas=Datos::consumoTropas($this->id_ciudad);
			echo $reg['produccion']-$nTropas;
		}
		else
		{
			echo $reg['produccion'];
		}
	}
	
	public function slot()
	{
		$sql="select edificio from edificios_aldea where id_ciudad=$this->id_ciudad and nivel=0";
		$res=$this->mysqli->query($sql);
		while($reg=$res->fetch_array())
		{
			$this->muestra_edificio($reg['edificio']);
		}
	}


	public function mostrar_edificios()
	{
		$j=1;
		$slot=0;
		$c=0;
		$edificiosSlot=array();
		$sql="select edificio,slot from edificios_aldea where id_ciudad = $this->id_ciudad order by slot";
		$res=$this->mysqli->query($sql);
		while($reg=$res->fetch_array())
		{
			$edificioSlot[]=array($reg['edificio'],$reg['slot']);
		}

		$sql="select * from eventos where id_ciudad = $this->id_ciudad";
		$res=$this->mysqli->query($sql);
		while($reg=$res->fetch_array())
		{
			?>
			<div id="solar<?php echo $reg['slot']; ?>" class="solar">
				<a href="edificio.php?s=<?php echo $reg['slot'];?>">
				<img src="img/elementos/edificios/construyendo.png" title="Construyendo" class="img_solar">
				</a>
			</div>
			<?php
		}

		$nEdificioSlot=count($edificioSlot);

		for ($i=0;$i<$nEdificioSlot;$i++)
		{
			for ($j=0;$j<$nEdificioSlot;$j++)
			{

				if ($edificioSlot[$j][1]==$i+1)
				{
					$slot=$edificioSlot[$j][0];
				}

			}
			if ($slot===0)
			{
				?>
				<a href="construir.php?s=<?php echo $i+1;?>">				
					<img src="img/elementos/aldea/solar.png" id="solar<?php echo $i+1; ?>" class="slot" title="Construir edificio">
				</a>
				<?php
			}
			else
			{
				$this->datos_edificios($slot);
			}
			$slot=0;
		}
	}

	public function datos_edificios($edificio) //Muestra el edificio en la aldea
	{
		$sql="select * from edificios_aldea where id_ciudad = $this->id_ciudad and edificio = '$edificio' limit 1";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();
			?>

				<div id="solar<?php echo $reg['slot']; ?>" class="solar">
				<a href="edificio.php?s=<?php echo $reg['slot'];?>">
					<?php
					if ($edificio=='leñador')
					{
						?>
						<img src="img/elementos/edificios/lenador.png" title="Leñador" class="img_solar">
						<?php
					}
					else
					{
					?>
						<img src="img/elementos/edificios/<?php echo $edificio;?>.png" title="<?php echo $edificio;?>" class="img_solar">
					<?php
					}
					?>
					<div class="nivel_edificio"><?php echo $reg['nivel'];?></div>

				</a>
				</div>

			<?php
		
	}

	public function mostrarEmbajada() //Muestra embajada
	{
		?>
		<div id="mostrar_embajada">
		<?php
		$sql="select id_alianza,estado from miembros_alianzas where id_usuario=$this->id_usuario order by estado desc limit 1";
		$res=$this->mysqli->query($sql);
		if ($res->num_rows > 0)
		{
			while($reg=$res->fetch_array())
			{
				if ($reg['estado']==1)
				{
					?>
						<b>Perteneces a la alianza:</b> <a href='alianza.php?i=<?php echo $reg['id_alianza']; ?>' class="peticion_alianza"><?php echo Datos::nombreAlianza($reg['id_alianza']) ?></a>
					<?php
					break;
				}
				else
				{
					?>
					<p>Actualmente no perteneces a ninguna alianza.</p><br/>
					<p><b>Fundar una alianza</b></p>
					<img src="img/elementos/recursos/madera.png" class="recurso_coste" title="Madera"> 500 |
					<img src="img/elementos/recursos/ladrillo.png" class="recurso_coste" title="Ladrillo"> 500 |
					<img src="img/elementos/recursos/hierro.png" class="recurso_coste" title="Hierro"> 500 |
					<img src="img/elementos/recursos/cereal.png" class="recurso_coste" title="Cereal"> 500
					
					<form name="form_fundar" method="post" action="procesa_alianza.php?a=4">
						<input type="text" name="nombre" class="input_enviar" required/>
						<input type="submit" value="Fundar Alianza" class="boton"/>
					</form>
					<p><b>Peticiones</b></p>
					<hr />
					
					<a href="alianza.php?i=<?php echo $reg['id_alianza']; ?>" class="peticion_alianza"><?php echo Datos::nombreAlianza($reg['id_alianza']); ?></a> 

					<a href='procesa_alianza.php?i=<?php echo $reg['id_alianza']; ?>&a=1' class="boton">Aceptar</a>  
					<a href='procesa_alianza.php?i=<?php echo $reg['id_alianza']; ?>&a=2' class="boton">Rechazar</a><br />

				<?php
				}
			}
		}
		else
		{
			?>
			<p>Actualmente no perteneces a ninguna alianza.</p><br/>
			<p><b>Fundar una alianza</b></p>
			<img src="img/elementos/recursos/madera.png" class="recurso_coste" title="Madera"> 500 |
			<img src="img/elementos/recursos/ladrillo.png" class="recurso_coste" title="Ladrillo"> 500 |
			<img src="img/elementos/recursos/hierro.png" class="recurso_coste" title="Hierro"> 500 |
			<img src="img/elementos/recursos/cereal.png" class="recurso_coste" title="Cereal"> 500 

			<form name="form_fundar" method="post" action="procesa_alianza.php?a=4">
						<input type="text" name="nombre" class="input_enviar" required/>
						<input type="submit" value="Fundar Alianza" class="boton"/>
					</form>
			<p><b>Peticiones</b></p>
			Actualmente no tienes peticiones.
			<?php
		}

		?>
		</div>
		<?php
	}

	public function muestra_mercado() //Muestra el mercado
	{
		?>
		
		<div id="info_mercado">
		<p>Comerciantes disponibles:<strong> <?php echo $this->comerciantes_disponibles;?></strong></p>
		<p>Recursos que puede transportar cada comerciante:<strong> 500 </strong></p>
		</div>

		<?php
		if ($this->comerciantes_disponibles > 0) //Si hay comerciantes disponibles
		{
			?>

			<div style="float:left;width:100%;">

			<div id="mercado2">
			<form name="form_ofrecer" method="post" action="procesa_comercio.php">
			<p>Crear oferta:</p>
			<div class="tipo_comercio">Ofrezco:</div> <input type="text" name="ofrezco" class="input_comercio"> de 
			<select name="recurso_ofrezco">
				<option value="madera">Madera</option>
				<option value="barro">Barro</option>
				<option value="hierro">Hierro</option>
				<option value="cereal">Cereal</option>
			</select>
			<br>
			<div class="tipo_comercio">Busco:</div> <input type="text" name="busco" class="input_comercio"> de 
			<select name="recurso_busco">
				<option value="madera">Madera</option>
				<option value="barro">Barro</option>
				<option value="hierro">Hierro</option>
				<option value="cereal">Cereal</option>
			</select>
			<br />
			¿Solo alianza? <input type="checkbox" name="alianza"/>
			<br /><br>
			<input type="hidden" value="ofertar" name="accion" />
			<input type="submit" value="Ofertar" class="boton">
			</form>

			</div><!--Mercado2-->


			<div id="mercado3">

			<form name="form_enviar" action="procesa_comercio.php" method="post">
				<p>Enviar recursos:</p>
				<img src="img/elementos/recursos/madera.png" class="recurso_coste" title="Madera"><input type="text" name="madera" value="0" class="input_mercado" required/> 
				<img src="img/elementos/recursos/ladrillo.png" class="recurso_coste" title="Ladrillo"> <input type="text" name="barro" value="0" class="input_mercado" required/>
				<img src="img/elementos/recursos/hierro.png" class="recurso_coste" title="Hierro"> <input type="text" name="hierro" value="0" class="input_mercado" required/> 
				<img src="img/elementos/recursos/cereal.png" class="recurso_coste" title="Cereal"> <input type="text" name="cereal" value="0" class="input_mercado" required/>
				
				<br /><br>
				<?php
				//Si nos dicen que enviemos a una ciudad concreta le mostramos los input llenos
				if (isset($_GET['x']) and isset($_GET['y']) and is_numeric($_GET['x']) and is_numeric($_GET['y'])) //Si hemos seleccionado una ciudad para enviarle recursos
				{
					?>
					Coordenadas de la ciudad: X <input type="text" name="x_ciudad" value="<?php echo $_GET['x'];?>" class="input_mercado" required />
					 Y <input type="text" name="y_ciudad" value="<?php echo $_GET['y'];?>" class="input_mercado" required/>
					<?php
				}
				else
				{
					?>
					Coordenadas de la ciudad: X <input type="text" name="x_ciudad" class="input_mercado" required /> 
					Y <input type="text" name="y_ciudad" class="input_mercado" required/>
					<?php
				}
				?>
				
				<br /><br>
				<input type="hidden" name="accion" value="enviar" />
				<input type="submit" value="Enviar recursos" class="boton">
			</form>

			</div>

			</div><!--Mercado3-->


			<div id="mercado4">
			<?php
			$this->mercado->mostrar_ofertas(); //Mostramos las ofertas
			?>
			</div><!--Mercado4-->
			<?php
		}
		$this->mercado->mostrar_ofertas('mias'); //Mostramos las ofertas
	}

	public function muestraPalacio()
	{
		if (Datos::nivelEdificio('palacio',$this->id_ciudad)==3)
		{
			echo "<hr />";
			$sql="select * from planos where id_ciudad=$this->id_ciudad";
			$res=$this->mysqli->query($sql);
			if ($res->num_rows>0)
			{
				$reg=$res->fetch_array();
				if ($this->t_actual < $reg['tiempo']+259200)
				{
					echo "Los planos se están diseñando, (tardan tres dias)";
				}
				else
				{
					echo "Tienes un plano que te permite fundar una aldea";
					//echo ($reg['tiempo']+259200)." ".$this->t_actual;
				}
			}
			else
			{
				?>
				Para fundar una ciudad necesitas un plano. Cuesta 5000|5000|5000|5000 <br />
				<?php
				if (Datos::recursosSuficientes($this->id_ciudad,'500-500-500-500')==1)
				{
					?>
					<a href="procesa_plano.php">Producir Plano</a>
					<?php
				}
				else
				{
					echo "No tienes suficientes recursos";
				}
			}
			?>
			<?php
		}
		?>
		<div style='float:left;width:100%;margin-bottom:40px;'>

		<hr />
		Actualmente tu imperio está formado por las ciudades:
		<br />
		<?php
		$sql="select * from mapa where id_usuario=$this->id_usuario";
		$res=$this->mysqli->query($sql);
		while($reg=$res->fetch_array())	
		{
			echo $reg['nombre']."<br />";
		}
		?>
		</div>
		<?php
	}

	public function producirPlanos()
	{
		if (Datos::recursosSuficientes($this->id_ciudad,'500-500-500-500')==1)
		{
			$sql="insert into planos values(null,$this->t_actual,$this->id_ciudad)";
			$res=$this->mysqli->query($sql);
			$sql="update mapa set madera=madera-500,barro=barro-500,hierro=hierro-500,cereal=cereal-500 where
			id_casilla=$this->id_ciudad";
			$res=$this->mysqli->query($sql);
			header("location:edificio.php?s=".Datos::slotPorEdificio('palacio'));
		}
	}

	public function muestraCuartel() //Muestra el edificio del cuartel
	{

		$j=0; //Contador para mostrar el numero de la tropa
		$mostrar=1;
		$tropa_no_disponible=0;

		$sql="select * from datos_tropas";
		$res=$this->mysqli->query($sql);
		while($reg=$res->fetch_array())	//Buscamos que unidades podemos reclutar de infanteria
		{
			$j++;
			$requisitos=explode('|',$reg['requisitos']);
			$temp=count($requisitos);
			for($i=0;$i<$temp;$i++)
			{
				$requisitos2=explode('_',$requisitos[$i]);
				$sql="select * from edificios_aldea where edificio = '$requisitos2[0]' and nivel >= $requisitos2[1] and id_ciudad = $this->id_ciudad limit 1";
				$resp=$this->mysqli->query($sql);
				
				if ($resp->num_rows == 0)
				{
					$tropa_no_disponible=1;
				}
			}
			unset($temp);

			if ($tropa_no_disponible==0)
			{
				?>
				<form name="form_tropas" action="reclutar.php" method="post" class="form_edificio">
					<?php
					if ($reg['parte_ejercito'] =='infanteria' || $reg['parte_ejercito'] =='artilleria')
					{
						if ($reg['tropa']=='tropa9')
						{
							$colonos=Datos::tropasReclutandose($this->id_ciudad,'tropa9')+$this->tropas->tropas_ciudad($this->id_ciudad)[8];
							if ($colonos<3)
							{
								?>
								<p><img src='img/elementos/tropas/<?php echo $reg['nombre'];?>.png' class='icono_tropa' title='<?php echo $reg['nombre'];?>'>
								<strong><?php echo $reg['nombre'];?>: </strong>
								<?php
							}
							else
							{
								$mostrar=0;
							}
						}
						else
						{
						?>
							<p><img src='img/elementos/tropas/<?php echo $reg['nombre'];?>.png' class='icono_tropa' title='<?php echo $reg['nombre'];?>'>
							<strong><?php echo $reg['nombre'];?>: </strong>
						<?php
						}
					}
					else if ($reg['parte_ejercito'] == 'caballeria')
					{
						if ($reg['nombre']=='caballeria_ligera')
						{
							?>
							<p><img src='img/elementos/tropas/caballeria_l.png' class='icono_tropa'><strong><?php echo str_replace("_", " ",$reg['nombre']);?>:</strong>
							<?php
						}
						else if ($reg['nombre']=='caballeria_pesada')
						{
							?>
							<p><img src='img/elementos/tropas/caballeria_p.png' class='icono_tropa'><strong><?php echo str_replace("_", " ",$reg['nombre']);?>:</strong>
							<?php
						}
						else
						{
						?>
							<p><img src='img/elementos/tropas/general.png' class='icono_tropa'><strong><?php echo str_replace("_", " ",$reg['nombre']);?>:</strong>
						<?php
						}
					}
					//Pasar el recurso Tiempo a un formato horario
					$segundos = $reg["tiempo"];
					$horas = intval($segundos/3600);
					$restoSegundos = $segundos%3600;
					$recurso_tiempo = $horas.':'.date("i:s",mktime (0,0,$restoSegundos,0,0,0));

					if ($mostrar==1)
					{
						?>
						<img src='img/elementos/recursos/madera.png' class='recurso_coste' title='Madera'><?php echo $reg['madera']; ?>
				 		| <img src='img/elementos/recursos/ladrillo.png' class='recurso_coste' title='Ladrillo'><?php echo $reg['barro']; ?>
				 		| <img src='img/elementos/recursos/hierro.png' class='recurso_coste' title='Hierro'> <?php echo $reg['hierro']; ?>
				 		| <img src='img/elementos/recursos/cereal.png' class='recurso_coste' title='Cereal'><?php echo $reg['cereal']; ?>
				 		| <img src='img/elementos/recursos/tiempo.png' class='recurso_coste' title='Tiempo'><?php echo $recurso_tiempo; ?>

						<input type="text" name="n_tropa<?php echo $j;?>" />
						</p>
						<?php
					}
			}
			$tropa_no_disponible=0;

		}
		$mostrar=1;
		?>		

			<p id="mostrar_reclutamiento">
			<?php $this->tropas->mostar_reclutamiento(); ?>
			<input type="submit" value="Reclutar" class="boton">
			</p>
			

		</form>


		<?php
	}
	
	public function muestra_edificio($edificio,$cuentaNivel=null) //Para mostrar los datos del edificio que se esta viendo
	{
		if (is_numeric($edificio))
		{
			$sql="select edificio,nivel,produccion from edificios_aldea where id_ciudad = $this->id_ciudad and slot = $edificio limit 1";
		}
		else
		{
			$sql="select edificio,nivel,produccion from edificios_aldea where id_ciudad = $this->id_ciudad and edificio = '$edificio' limit 1";
		}
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array(); 
		if (isset($cuentaNivel) && $reg['nivel']==0)
		{
			header("Location:index.php");
			exit;
		}

		else if ($reg['edificio'] == "mercado" and $reg['nivel']>0) //Si el edificio es el mercado
		{
		?>
			<div class="nombre_edificio"><strong>Mercado</strong> - Nivel <?php echo $reg["nivel"];?></div>

			<div class="edificio_descripcion">
			El Mercado sirve para intercambiar recursos con otras aldeas, pudiendo vender tus excendentes a cambio de aquellos recursos que solicites.
			</div>

			<div id="mercado1">

			<img src="img/elementos/edificios/mercado.png" class="img_recurso" title="Mercado">

			<div class="edificio_costes">
			<p>Subir a nivel <?php echo $reg["nivel"]+1; ?></p>
			<div class="subir_nivel"><?php $this->coste_ampliacion($reg["edificio"],$reg["nivel"]); ?></div>
			</div>

			</div>

			<?php
			$this->muestra_mercado();
		}

		else if ($reg['edificio'] == 'embajada')
		{
			?>
			<div class="nombre_edificio"><strong>Embajada</strong> - Nivel <?php echo $reg["nivel"];?></div>

			<div class="edificio_descripcion">
			La embajada acoge diplomáticos de otras ciudades, con lo que podrás fundar una alianza o unirte a una ya existente.
			</div>

			<img src="img/elementos/edificios/embajada.png" class="img_recurso" title="Embajada">

			<div class="edificio_costes">
			<p>Subir a nivel <?php echo $reg["nivel"]+1; ?></p>
			<div class="subir_nivel"><?php $this->coste_ampliacion($reg["edificio"],$reg["nivel"]); ?></div>
			</div>

			<?php
			if ($reg['nivel']>0)
			{
				$this->mostrarEmbajada();
			}
		}
		else if ($reg['edificio'] == 'palacio')
		{
			?>
				<div class="nombre_edificio"><strong>Palacio</strong> - Nivel <?php echo $reg["nivel"];?></div>

				<div class="edificio_descripcion">
				En el Palacio vive el gobernador de la ciudad. Con el puedes conseguir colonos y diseñar planos para fundar nuevas ciudades. Necesitas 3 colonos y un plano para fundar una ciudad.
				</div>

				

				<img src="img/elementos/edificios/palacio.png" class="img_recurso" title="Palacio">

				<div class="edificio_costes">
				<p>Subir a nivel <?php echo $reg["nivel"]+1; ?></p>
				<div class="subir_nivel"><?php $this->coste_ampliacion($reg["edificio"],$reg["nivel"]); ?></div>
				</div>
				<br /> <br /><br /> <br /><br /> <br /><br /> <br /><br /> <br /><br /> <br />
				<?php
				if ($reg['nivel']>0)
				{
					$this->muestraPalacio();
				}
				?>
				<br />
				<?php
		}
		else //Si es otro
		{
			?>
			<div class="nombre_edificio"><strong><?php echo $edificio;?></strong> - Nivel <?php echo $reg["nivel"];?></div>

			<div class="edificio_descripcion">
			<?php echo $this->descripcionEdificio($edificio,$reg["produccion"]);
			?>
			</div>

			<img src="img/elementos/edificios/<?php echo str_replace("ñ","n",$edificio);?>.png" class="img_recurso" title="<?php echo $edificio;?>">

			<div class="edificio_costes">
			<p>Subir a nivel <?php echo $reg["nivel"]+1; ?></p>
			<div class="subir_nivel"><?php $this->coste_ampliacion($reg["edificio"],$reg["nivel"]); ?></div>
			</div>
			<?php
		}
	}

	public function descripcionEdificio($edificio,$produccion)
	{
		switch ($edificio)
		{
		 	case 'palacio':
		 		return "En el Palacio vive el gobernador de la ciudad. Con el puedes conseguir colonos y diseñar planos para fundar nuevas ciudades. Necesitas 3 colonos y un plano para fundar una ciudad.";
		 		break;
		 	
		 	case 'escondite':
		 		return "El escondite te permite proteger tus recursos de los atracos. Como mas grande sea más recursos podra proteger.";
		 		break;

		 	case 'taller':
		 		return "En el Taller se crean las maquinas de asedio. Cuanto más se amplíe, más tipos de maquinas podran crearse.";
		 		break;

		 	case 'establo':
		 		return "En el Establo se forman tropas de caballeria listas para formar parte de tu ejército. Cuanto más se amplíe, más tipos de tropas podrán formarse.";
		 		break;

		 	case 'foro':
		 		return "El Foro es el centro de la ciudad, y agiliza los tiempos de construcción. Al tener el foro a este nivel los edificios tardarán un  <b>$produccion</b> menos en construirse.";
		 		break;

		 	case 'almacen':
		 		return "El Almacén aumenta la capacidad de tu aldea para guardar los recursos.";
		 		break;

		 	case 'granja':
		 		return "La Granja produce Cereal con el que abastecer a tus poblaciones y ejércitos y seguir creciendo.";
		 		break;

		 	case 'mina':
		 		return "La mina te permite extraer Hierro, que puede ser empleada en la construcción del ejército.";
		 		break;

		 	case 'ladrillar':
		 		return "En el ladrillar se fabrican Ladrillos, que suponen la unidad básica de construcción de edificios.";
		 		break;

		 	case 'leñador':
		 		return "El leñador te permite extraer madera, útil para la construcción de edificios.";
		 		break;

		 	case 'cuartel':
		 		return "En el Cuartel se forman tropas de infantería listas para formar parte de tu ejército. Cuanto más se amplíe, más tipos de tropas podrán formarse.";
		 		break;

		 	case 'mercado':
		 		return "El Mercado sirve para intercambiar recursos con otras aldeas, pudiendo vender tus excendentes a cambio de aquellos recursos que solicites.";
		 		break;

		 	default:
		 		return "Error";
		 		break;
		 } 
	}
//********************************************************************************************************************
//***********************FUNCIONES AMPLIAR****************************************************************************
//********************************************************************************************************************
	public function coste_ampliacion($edificio,$nivel) //Muestra los costes de ampliacion del edificio que se está viendo
	{
		$edificio=safe_edificio($edificio);

		$sql="select madera,barro,hierro,cereal,tiempo from costes_construcciones where edificio = '$edificio' and nivel = $nivel+1 limit 1";
		$res=$this->mysqli->query($sql);

		if($reg=$res->fetch_array()) //Muestra los recursos necesarios
		{

			//Pasar el recurso Tiempo a un formato horario
			$segundos = $reg["tiempo"];
			$horas = intval($segundos/3600);
			$restoSegundos = $segundos%3600;
			$recurso_tiempo = $horas.':'.date("i:s",mktime (0,0,$restoSegundos,0,0,0));

			//Mostramos los recursos
			echo "<img src='img/elementos/recursos/madera.png' class='recurso_coste' title='Madera'> ".$reg["madera"]."
			 | <img src='img/elementos/recursos/ladrillo.png' class='recurso_coste' title='Ladrillo'> ".$reg["barro"]."
			 | <img src='img/elementos/recursos/hierro.png' class='recurso_coste' title='Hierro'> ".$reg["hierro"]."
			 | <img src='img/elementos/recursos/cereal.png' class='recurso_coste' title='Cereal'> ".$reg["cereal"]."
			 | <img src='img/elementos/recursos/tiempo.png' class='recurso_coste' title='Tiempo'> ".$recurso_tiempo;
			//Comprueba si tiene los recursos suficientes
			$sql="select * from mapa where id_usuario = $this->id_usuario and madera >=".$reg["madera"]." and barro >=".$reg["barro"]."
			and hierro>=".$reg["hierro"]." and cereal>=".$reg["cereal"]." limit 1";
			$res=$this->mysqli->query($sql);
			echo "<br />";
			if ($res->num_rows > 0) //Si tiene recursos sufientes
			{
				$sql="select * from eventos where id_ciudad = $this->id_ciudad";
				$res=$this->mysqli->query($sql);
				if ($res->num_rows > 0) //Comprueba que no hay construcciones en curso
				{
					echo "</br>Ya se está construyendo otro edificio.";
				}
				else if (Datos::edificioDisponible($edificio,$this->id_ciudad)==0)
				{
					echo "<br />No cumples los requisitos para construir este edificio.";
				}
				else if (Datos::edificioDisponible($edificio,$this->id_ciudad)==1)
				{
					echo "</br><a href='procesa_construir.php?edificio=$edificio&s=".$_GET['s']."'>Construir</a>";
				}
				
			}
			else
			{
				echo "</br>No tienes suficientes recursos.";
			}
		}
		else
		{
			echo "</br>Este edificio no puede ampliarse más.";
		}

	}

	public function ordenar_ampliar($edificio) //Da la orden de ampliar y cobra los recursos
	{
		$edificio=safe_edificio($edificio);

		$sql="select COUNT(*) from eventos where id_ciudad = $this->id_ciudad";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();
		if ($reg[0]>0) //Comprueba que no hay construcciones en curso
		{
			header("Location:index.php");
			exit;
		}
		
		$slot=$_GET['s'];

		if ($slot==0||$slot>13) //Si el slot no es correcto
		{
			header("Location:index.php");
			exit;
		}

		//Cogemos los datos del foro
		$sql="select produccion from edificios_aldea where edificio='foro' and id_ciudad=$this->id_ciudad limit 1";
		$res=$this->mysqli->query($sql);
		$red=$res->fetch_array();

		//Cogemos los datos del edificio a ampliar
		$sql="select edificio,nivel from edificios_aldea where edificio = '$edificio' and id_ciudad = $this->id_ciudad limit 1";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();

		//Buscamos sus costes_construcciones de ampliacon
		$sql="select barro,madera,hierro,cereal,tiempo from costes_construcciones where edificio = '".$reg['edificio']."' and nivel = ".$reg['nivel']."+1 limit 1";
		$res=$this->mysqli->query($sql);
		$ret=$res->fetch_array();

		if (Datos::recursosSuficientes($this->id_ciudad,$ret["madera"]."-".$ret["barro"]."-".$ret["hierro"]."-".$ret["cereal"])==0)
		{
			header("Location:index.php");
			exit;
		}

		//Cobra los recursos del edificio
		$sql="update mapa set madera = madera-".$ret["madera"].", barro = barro-".$ret["barro"].",hierro = hierro-".$ret["hierro"].",cereal = cereal-".$ret["cereal"]." where id_usuario = $this->id_usuario";
		$res=$this->mysqli->query($sql);

		$bono_foro=$red['produccion']*$ret['tiempo']/100; //Descuento de tiempo por el nivel del foro

		$sql="insert into eventos values (null,'$edificio',$this->t_actual-$bono_foro,$slot,$this->id_ciudad)"; //Pone la construccion
		$res=$this->mysqli->query($sql);

		header("Location:index.php");
	}

	public function ampliar($edificio) //Amplia un edificio
	{
		$edificio=safe_edificio($edificio);

		$sql="select slot from eventos where edificio='$edificio' and id_ciudad=$this->id_ciudad limit 1";
		$res=$this->mysqli->query($sql);
		$rem=$res->fetch_array();

		$slot=$rem['slot'];

		//Cogemos los datos del edificio a amplair
		$sql="select edificio,nivel,habitantes from edificios_aldea where edificio = '$edificio' and id_ciudad = $this->id_ciudad limit 1";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();

		//Miramos los costes_construcciones de su ampliacon
		$sql="select produccion,habitantes from costes_construcciones where edificio = '".$reg['edificio']."' and nivel = ".$reg['nivel']."+1 limit 1";
		$res=$this->mysqli->query($sql);
		$ret=$res->fetch_array();

		//Amplia el edificio
		$sql="update edificios_aldea set slot=$slot,nivel = nivel+1, produccion = ".$ret['produccion'].", habitantes = ".$ret['habitantes']." where id_ciudad = $this->id_ciudad and edificio = '$edificio'";
		$res=$this->mysqli->query($sql);
		$crecimiento_habitantes = $ret["habitantes"]-$reg["habitantes"];

		//Aumenta los habitantes
		$sql="update mapa set habitantes = habitantes+$crecimiento_habitantes where id_casilla = $this->id_ciudad ";
		$res=$this->mysqli->query($sql);

		//Se quita la construccion
		$sql="DELETE FROM eventos WHERE id_ciudad = $this->id_ciudad";
		$res=$this->mysqli->query($sql);

	}
//********************************************************************************************************************
//*************************FUNCIONES MOTOR**************************************************************************
//********************************************************************************************************************
	public function almacen() //Da valor a las variables del almacen
	{
		//Cogemos los datos de nuestro almacen
		$sql="select nivel from edificios_aldea where id_ciudad = $this->id_ciudad and edificio = 'almacen' limit 1";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();

		//Miramos si se esta construyendo el almacen
		$sql="select * from eventos where id_ciudad = $this->id_ciudad and edificio = 'almacen' limit 1";
		$res=$this->mysqli->query($sql);

		if ($res->num_rows>0) //Si se esta construyendo el almacen
		{
			$ret=$res->fetch_array();

			//Cogemos los datos del proximo almacen
			$sql="select * from costes_construcciones where edificio = 'almacen' and nivel = ".$reg["nivel"]."+1 limit 1";
			$res=$this->mysqli->query($sql);
			$rel=$res->fetch_array();

			$ta_construira = $rel["tiempo"]; //Tiempo que dura la construccion
			$ta_orden=$ret["tiempo"]; //Hora a la que se ordeno construir
			$ta_diferencia = $this->t_actual-$ta_orden;	//El tiempo que ha pasado desde que se ordeno construir
			$ta_cuando = $ta_construira+$ta_orden; //Hora la que se construira

			if ($ta_diferencia-$ta_construira>0) //Si ha pasado la cola de espera del edificio
			{
				$this->construira_almacen=$ta_cuando; //Hora a la que se construira el almacen
				$this->tiempo_almacen=$this->construira_almacen-$this->last_update; //Tiempo que queda para que se amplie el almacen
			}
		}
	}

	public function calcular_reclutamiento() //Reclutamos las unidades cuyo tiempo de reclutamiento ha pasado
	{
		$sql="select * from cola_produccion where id_ciudad=$this->id_ciudad";
		$resp=$this->mysqli->query($sql);
		if ($resp->num_rows>0) //Si se esta reclutando alguna
		{
			while($reg=$resp->fetch_array())
			{
				$tropas_restantes=$reg['n_tropas']-$reg['n_tropas_reclutadas']; //Tropas que quedan por reclutar

				$sql="select tiempo from datos_tropas where tropa = '".$reg['tropa']."' limit 2";
				$res=$this->mysqli->query($sql);
				$red=$res->fetch_array();

				$tp_tropa=$red['tiempo']; 				//Tiempo que tarda en producirse una tropa
				$tt_tropa=$tp_tropa*$reg['n_tropas']; 	//Tiempo que tardan en producirse todas
				$t_terminara=$tt_tropa+$reg['fecha'];	 //Hora a la que terminara de reclutarse todo

				//Tiempo pasado desde que ordene reclutar hasta ahora
				$t_transcurrido=$this->t_actual-($tp_tropa*$reg['n_tropas_reclutadas']+$reg['fecha']);
				$tropas_reclutan=floor($t_transcurrido/$tp_tropa); //Para no reclutar de mas redondeamos hacia abajo
				if ($tropas_reclutan>$reg['n_tropas']) //Si las tropas que se reclutan intentasen superar las ordenadas se iguala
				{
					$tropas_reclutan=$reg['n_tropas'];
				}
				//Restamos las tropas reclutadas
				$sql="update cola_produccion set n_tropas_reclutadas=n_tropas_reclutadas+$tropas_reclutan where tropa = '".$reg['tropa']."' and id_ciudad=$this->id_ciudad";
				$res=$this->mysqli->query($sql);
				//Las añadimos a nuestra ciudad
				$sql="update tropas set ".$reg['tropa']." = ".$reg['tropa']."+$tropas_reclutan where id_ciudad = $this->id_ciudad";
				$res=$this->mysqli->query($sql);
				//Eliminamos los reclutamientos completados
				$sql="delete from cola_produccion where n_tropas<=n_tropas_reclutadas";
				$res=$this->mysqli->query($sql);
			}
			
		}
	}

	public function calcularRecursos($edificio,$mostrar) //Calcula los recursos producidos
	{
		//*****************************************************************************************
		//Cogemos los datos del edificio seleccionado
		$sql="select produccion,recurso,edificio,nivel FROM edificios_aldea WHERE id_ciudad = $this->id_ciudad AND edificio='$edificio' limit 1";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();
		
		//Miramos si este se esta construyendo
		$sql="select tiempo from eventos where id_ciudad = $this->id_ciudad and edificio = '$edificio' limit 1";
		$res=$this->mysqli->query($sql);

		if ($res->num_rows>0) //Si hay una construccion
		{
			$ret=$res->fetch_array();

			//Miramos los costes_construcciones del edificio
			$sql="select tiempo from costes_construcciones where edificio = '".$reg["edificio"]."' and nivel = ".$reg["nivel"]."+1 limit 1";
			$res=$this->mysqli->query($sql);
			$rel=$res->fetch_array();

			$t_construira = $rel["tiempo"]; //Tiempo que dura la construccion
			$t_orden=$ret["tiempo"]; //Hora a la que se ordeno construir
			$t_diferencia = $this->t_actual-$t_orden;	//El tiempo que ha pasado desde que se ordeno construir
			$t_cuando = $t_construira+$t_orden; //Hora la que se construira

			//Miramos los costes_construcciones del edificio a construir
			$sql="select tiempo from costes_construcciones where edificio = '".$reg["edificio"]."' and nivel = ".$reg["nivel"]."+1 limit 1";
			$res=$this->mysqli->query($sql);
			$rug=$res->fetch_array();
		
			if ($t_diferencia-$t_construira>0) //Si ha pasado la cola de espera del edificio
			{
				$t1=$t_cuando-$this->last_update; 			//Tiempo que ha pasado desde la hora a la que se actualizara y la ultima vez que actualizaste
				if ($edificio == 'granja')
				{
					$nTropas=Datos::consumoTropas($this->id_ciudad);
					$p_edificio1=($reg['produccion']-$nTropas)/3600*$t1; 	//Lo que ha producido el edificio antes de la construccion
				}
				else
				{
					$p_edificio1=$reg['produccion']/3600*$t1; 	//Lo que ha producido el edificio antes de la construccion
				}
				$this->ampliar($edificio); 					//Ampliamos el edificio
				//Comprobamos los datos del edificio ampliado
				$sql="select produccion FROM edificios_aldea WHERE id_ciudad = $this->id_ciudad AND edificio='$edificio' limit 1";
				$res=$this->mysqli->query($sql);
				$reg=$res->fetch_array();

				$t2= $this->t_actual-$t_cuando; 			//Tiempo que ha pasado desde ahora hasta que se construyo
				if ($edificio == 'granja')
				{
					$nTropas=Datos::consumoTropas($this->id_ciudad);
					$p_edificio2=($reg['produccion']-$nTropas)/3600*$t2; 	//Lo que ha producido el edificio antes de la construccion
				}
				else
				{
					$p_edificio2=$reg['produccion']/3600*$t2; 	//Lo que ha producido el edificio antes de la construccion
				}

				$this->p_edificio = $p_edificio1+$p_edificio2; 	//Lo que se ha producido en total
				if ($edificio == 'granja')
				{
					$nTropas=Datos::consumoTropas($this->id_ciudad);
					$this->ps_edificio=($reg['produccion']-$nTropas)/3600; 	//Lo que producimos por segundo
				}
				else
				{
					$this->ps_edificio=$reg['produccion']/3600; 	//Lo que producimos por segundo
				}
			}

			else //Si aun no se ha construido
			{
				if ($edificio == 'granja')
				{
					$nTropas=Datos::consumoTropas($this->id_ciudad);
					$this->p_edificio=($reg['produccion']-$nTropas)/3600*$this->t_transcurrido; //Lo producido
					$this->ps_edificio=($reg['produccion']-$nTropas)/3600; //Lo que producimos por segundo
				}
				else
				{
					$this->p_edificio=$reg['produccion']/3600*$this->t_transcurrido; //Lo producido
					$this->ps_edificio=$reg['produccion']/3600; //Lo que producimos por segundo
				}
				$tiempos=-($t_diferencia-$rug["tiempo"]);	//Tiempo restante para la ampliacion
				$tiempos = (string)$tiempos;				//Lo hacemos cadena para poder trabajarlo

				if ($mostrar == "si")//Si queremos que se muestre el timer
				{
				?>
					<div id="tiempo_ampliacion">
					<script type="text/javascript" language="javascript">
					var tiempos = <?php echo $tiempos?>;

					function tiempo() //Para mostrar el tiempo
					{
						if (tiempos==0) //Si ha pasado el tiempo actualizamos
						{
							location.reload();
						}
						else 
						{
							//Restamos un segundo y lo mostramos
							tiempos--;
							document.getElementById("tiempo").innerHTML=" <i class='icon-time' title='Tiempo restante'></i> Tiempo restante para la ampliación "+fecha(tiempos);
						}
					}
					tiempo();
					setInterval('tiempo()',1000); //Cada segundo se actualizara el timer
					</script>
					</div>
					<?php
				}
			}
		
		}
		else //Sino no se esta construyendo el edificio
		{
			$this->almacen(); //Declaramos las variables de almacen
			if ($this->construira_almacen!=0) //Si se esta construyendo el almacen
			{
				if ($edificio == 'granja')
				{	
					$nTropas=Datos::consumoTropas($this->id_ciudad);
					$p_1=($reg['produccion']-$nTropas)/3600*$this->tiempo_almacen; //Lo que se produce antes de que se contruya el almacen
				}
				else
				{
					$p_1=$reg['produccion']/3600*$this->tiempo_almacen; //Lo que se produce antes de que se contruya el almacen
				}

				if ($edificio == 'leñador' || $edificio == 'mina' || $edificio == 'ladrillar' || $edificio == 'granja') //Si es un edificio de produccion el seleccionado
				{
					$sql="select madera,barro,hierro,cereal from mapa where id_casilla = $this->id_ciudad limit 1";
					$res=$this->mysqli->query($sql);
					$rez=$res->fetch_array();

					if ($p_1+$rez[$reg['recurso']]>$this->capacidad) //Si al sumar la produccion se supera la capacidad
					{
						$p_1=$this->capacidad-$rez[$reg['recurso']];	//Producimos lo que hace falta para llenar el almacen
					}
					
					if ($edificio == 'granja')
					{
						$nTropas=Datos::consumoTropas($this->id_ciudad);
						$t2=$this->t_actual-$this->construira_almacen; //Tiempo que ha pasado desde que se amplio el almacen hasta ahora
						$p_2=($reg['produccion']-$nTropas)/3600*$t2;	//Produccion desde que se amplio el almacen

						$this->p_edificio=$p_1+$p_2; //Lo producido
						$this->ps_edificio=($reg['produccion']-$nTropas)/3600; //Lo que producimos por segundo
					}
					else
					{
						$t2=$this->t_actual-$this->construira_almacen; //Tiempo que ha pasado desde que se amplio el almacen hasta ahora
						$p_2=$reg['produccion']/3600*$t2;	//Produccion desde que se amplio el almacen

						$this->p_edificio=$p_1+$p_2; //Lo producido
						$this->ps_edificio=$reg['produccion']/3600; //Lo que producimos por segundo
					}
				}
				/*echo "<br />Edificio: $edificio
				<br />P1: $p_1
				<br />P2: $p_2
				<br />Produccion: ".$reg['produccion']."
				<br />Tiempo Almacen: $this->tiempo_almacen
				<br />Capacidad: $this->capacidad
				<br />T1: $t1
				<br />T2: $t2
				<br />p_edificio: $this->p_edificio
				<br />ps_edificio: $this->ps_edificio";
				exit;*/
			}
			else //Sino se esta construyendo el almacen
			{
				$sql = "select produccion FROM edificios_aldea WHERE id_ciudad = $this->id_ciudad AND edificio='$edificio' limit 1";
				$res=$this->mysqli->query($sql);
				$reg=$res->fetch_array();
				
				if ($edificio == 'granja') //Si el edificio es la granja le restamos el consumo de las tropas
				{
					$nTropas=Datos::consumoTropas($this->id_ciudad);
					$this->p_edificio=($reg['produccion']-$nTropas)/3600*$this->t_transcurrido; //Lo producido
					$this->ps_edificio=($reg['produccion']-$nTropas)/3600; //Lo que producimos por segundo
				}
				else
				{
					$this->p_edificio=$reg['produccion']/3600*$this->t_transcurrido; //Lo producido
					$this->ps_edificio=$reg['produccion']/3600; //Lo que producimos por segundo
				}
			}		
		}
		
	}

	public function comprobar_recursos($mostrar,$procesar_tropas=null,$id_ciudad=null,$time=null) //Es el motor del juego
	{
		if (isset($id_ciudad)) //Si queremos que se calcule otra ciudad
		{
			$tempI=$this->id_ciudad;
			$this->id_ciudad=$id_ciudad;
		}
		if (isset($time))
		{
			$tempT=$this->t_actual;
			$this->t_actual=$time;
		}
		//Datos de nuestra ciudad
		$sql="select * from mapa where id_casilla = $this->id_ciudad limit 1";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();

		$this->last_update=$reg["last_update"];
		$this->t_transcurrido=$this->t_actual-$this->last_update; //Tiempo que ha pasado desde la ultima vez que actualizamos

		//Calculamos los recursos de cada edificio
		//*****************************************************************************************
		$this->calcularRecursos("leñador",$mostrar);
		$p_leñador=$this->p_edificio;
		$ps_leñador=$this->ps_edificio;

		//*****************************************************************************************
		$this->calcularRecursos("granja",$mostrar);
		$p_granja=$this->p_edificio;
		$ps_granja=$this->ps_edificio;

		//*****************************************************************************************
		$this->calcularRecursos("ladrillar",$mostrar);
		$p_ladrillar=$this->p_edificio;
		$ps_ladrillar=$this->ps_edificio;

		//*****************************************************************************************
		$this->calcularRecursos("mina",$mostrar);
		$p_mina=$this->p_edificio;
		$ps_mina=$this->ps_edificio;

		//*****************************************************************************************
		$this->calcularRecursos("foro",$mostrar);
		//*****************************************************************************************
		$this->calcularRecursos("almacen",$mostrar);
		//*****************************************************************************************
		$this->calcularRecursos("mercado",$mostrar);
		//*****************************************************************************************
		$this->calcularRecursos("cuartel",$mostrar);
		//*****************************************************************************************
		$this->calcularRecursos("establo",$mostrar);
		//*****************************************************************************************
		$this->calcularRecursos("embajada",$mostrar);
		//*****************************************************************************************
		$this->calcularRecursos("escondite",$mostrar);
		//*****************************************************************************************
		$this->calcularRecursos("taller",$mostrar);
		//*****************************************************************************************
		$this->calcularRecursos("palacio",$mostrar);
		//*****************************************************************************************
		$this->calcular_reclutamiento(); //Reclutamos las tropas

		//Se producen los movimientos de tropas
		if (!isset($procesar_tropas))
		{
			$this->mTropas->procesar_movimiento_tropas(null,null,$this->t_actual);
		}
		else
		{
			$this->mTropas->procesar_movimiento_tropas($this->id_ciudad,'si',$this->t_actual);
		}
		//Actualizamos los recursos
		$sql="update mapa set last_update = $this->t_actual, cereal = cereal+$p_granja, madera = madera+$p_leñador, barro = barro+$p_ladrillar, hierro = hierro+$p_mina where id_casilla = '$this->id_ciudad'";
		$res=$this->mysqli->query($sql);

		//Comprobamos de nuevo los datos de la ciudad
		$sql="select * from mapa where id_casilla = $this->id_ciudad limit 1";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();

		$this->last_update=$reg['last_update']; //Nuevo last_update
		$this->tiempo_almacen=0;				//Quitamos las variables del almacen pues ya se ha comprobado
		$this->construira_almacen=0;

		//Datos del almacen
		$sql="select produccion from edificios_aldea where id_ciudad=$this->id_ciudad and edificio = 'Almacen' limit 1";
		$res=$this->mysqli->query($sql);
		$rem=$res->fetch_array();

		$this->capacidad=$rem['produccion'];//Capacidad del almacen

		//Hacemos que no supere la cantidad al limite de la capacidad
		if ($reg['madera']>$this->capacidad)
		{
			$sql="update mapa set madera = $this->capacidad where id_casilla = $this->id_ciudad";
			$res=$this->mysqli->query($sql);
		}
		if ($reg['barro']>$this->capacidad)
		{
			$sql="update mapa set barro = $this->capacidad where id_casilla = $this->id_ciudad";
			$res=$this->mysqli->query($sql);
		}
		if ($reg['hierro']>$this->capacidad)
		{
			$sql="update mapa set hierro = $this->capacidad where id_casilla = $this->id_ciudad";
			$res=$this->mysqli->query($sql);
		}
		if ($reg['cereal']>$this->capacidad)
		{
			$sql="update mapa set cereal = $this->capacidad where id_casilla = $this->id_ciudad";
			$res=$this->mysqli->query($sql);
		}

		//Comprobamos de nuevo los datos de la ciudad
		$sql="select * from mapa where id_casilla = $this->id_ciudad limit 1";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();

		//Mostramos los recursos
		?>
		<script type="text/javascript" language="javascript">
		//Pasamos las variables PHP a Js
		var madera = <?php echo $reg['madera'];?>; 	//Cantidad de madera
		var barro = <?php echo $reg['barro'];?>;	//Cantidad de barro
		var hierro = <?php echo $reg['hierro'];?>;	//Cantidad de hierro
		var cereal = <?php echo $reg['cereal'];?>;	//Cantidad de cereal
		var ps_leñador = <?php echo $ps_leñador?>;	//Produccion por segundo de madera
		var ps_ladrillar = <?php echo $ps_ladrillar?>;	//Produccion por segundo de barro
		var ps_mina = <?php echo $ps_mina?>;		//Produccion por segundo de hierro
		var ps_granja = <?php echo $ps_granja?>;	//Produccion por segundo de cereal
		var capacidad = <?php echo $this->capacidad?>;;	//Capacidad del almacen

		actualiza_recursos();

		function actualiza_recursos() //Esto actualizara los recursos de acuerdo a la produccion
		{
			//Lo muestra redondeado a la baja
			document.getElementById("r1").innerHTML=Math.floor(madera);
			document.getElementById("r2").innerHTML=Math.floor(barro);
			document.getElementById("r3").innerHTML=Math.floor(hierro);
			document.getElementById("r4").innerHTML=Math.floor(cereal);

			//Aumenta los recursos de acuerdo a la produccion
			madera += ps_leñador;
			barro += ps_ladrillar;
			hierro += ps_mina;
			cereal += ps_granja;

			//Si se supera la capacidad del almacen
			if (madera>capacidad)
			{
				madera = capacidad;
			}
			if (barro>capacidad)
			{
				barro = capacidad;
			}
			if (hierro>capacidad)
			{
				hierro = capacidad;
			}
			if (cereal>capacidad)
			{
				cereal = capacidad;
			}
		}
		setInterval('actualiza_recursos()', 1000); //Se actualizaran los recursos una vez por segundo
		</script>
		<?php
		//Comprobamos los intercambios comerciales
		$this->mercado->procesar_comercio();
		if (isset($id_ciudad)) //Si queremos que se calcule otra ciudad
		{
			$this->id_ciudad=$tempI;
		}
		if (isset($time))
		{

			$this->t_actual=$tempT;
		}
	}


	public function ir_mapa() //Crea un link para ir al mapa en tu posicion
	{
		//Links al mapa
		echo "<a href='mapa.php?x=$this->x&y=$this->y'> 
		<img src='img/elementos/menu/mapa.png'>
		</a>";
	}

	public function costesEdificios()
	{
		$sql="select * from costes_construcciones order by edificio";
		$res=$this->mysqli->query($sql);
		?>
		<table class="tabla_reportes">
			<tr>
				<td>Edificio</td>
				<td>Nivel</td>
				<td>Produccion</td>
				<td>Habitantes</td>
				<td>Tiempo</td>
				<td>Requisitos</td>
			</tr>
		<?php
		while($reg=$res->fetch_array())
		{
			?>
			<tr>
				<td><?php echo $reg['edificio'];?></td>
				<td><?php echo $reg['nivel'];?></td>
				<td><?php echo $reg['produccion'];?></td>
				<td><?php echo $reg['habitantes'];?></td>
				<td><?php echo $reg['tiempo'];?></td>
				<td><?php echo str_replace("_"," ",str_replace("|"," ",$reg['requisitos']));?></td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	}

	public function enviarFundar()
	{
		$sql="update tropas set tropa9=tropa9-3 where id_ciudad=$this->id_ciudad";
		$res=$this->mysqli->query($sql);
		$sql="insert into ataques values
		(null,'fundar',$this->id_ciudad,".Datos::idCiudadPorCoordenadas($_GET['x'],$_GET['y']).",0,0,0,0,0,0,0,0,3,0,'',$this->t_actual)";
		$res=$this->mysqli->query($sql);
		header("location:index.php");
	}

	public function listaAldeas()
	{
		$sql="select * from mapa where id_usuario=$this->id_usuario";
		$res=$this->mysqli->query($sql);
		while ($reg=$res->fetch_array())
		{
			echo "<a href='cambiar_aldea.php?i=".$reg['id_casilla']."'><li><i>".$reg['nombre']."</li></i></a><br />";
		}
	}

	public function cambiarAldea()
	{
		$sql="select * from mapa where id_usuario=$this->id_usuario and id_casilla=".$_GET['i'];
		$res=$this->mysqli->query($sql);
		if ($res->num_rows>0)
		{
			$_SESSION['ju_ciudad']=$_GET['i'];
			header("location:index.php");
		}
	}

}

?>
