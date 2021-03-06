<?php
class Datos
{
	private $mysqli;
	private $id_ciudad;

	public static function mysqli()
	{
		$mysqli=new mysqli(DB_HOST,SQL_USER,SQL_PASS,DB_NAME);
		$mysqli->set_charset(DB_CHARSET);
		return $mysqli;
	}

	public static function getIp()
	{
       if (!empty($_SERVER['HTTP_CLIENT_IP']))
       {
       $ip=$_SERVER['HTTP_CLIENT_IP'];
       }
       elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
       {
       $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
       }
       else
       {
       $ip=$_SERVER['REMOTE_ADDR'];
       }
	return $ip;
	}

	//*****************************************************
	//****************ID Y NOMBRES*************************
	public static function id($usuario) //Para obtener el id de un usuario
	{
		$mysqli=DB::Get();
		$usuarioS=safe($usuario);
		$sql="select * from usuarios where nombre = '$usuarioS' limit 1";
		$res=$mysqli->query($sql);
		if ($reg=$res->fetch_array())
		{
			return $reg["id_usuario"];
		}
		else
		{
			return 0;
		}
	}

	public static function usuario($id_usuario) //Para obtener el nombre de un usuario por su id
	{
		$mysqli=DB::Get();
		$sql="select nombre from usuarios where id_usuario = $id_usuario limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg["nombre"];
	}

	public static function id_ciudad($id_usuario) //Para obtener el id de la ciudad de un usuario
	{
		$mysqli=DB::Get();
		$sql="select id_casilla from mapa where id_usuario = $id_usuario and capital = 'si' limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg["id_casilla"];
	}

	public static function id_ciudad_nombre($nombre) //Para obtener el id de la ciudad de un usuario
	{
		$mysqli=DB::Get();
		$sql="select id_casilla from mapa where nombre = '$nombre' limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg["id_casilla"];
	}


	public static function ciudad($id_ciudad) //Para obtener el nombre de una ciudad por su id
	{
		$mysqli=DB::Get();
		$sql="select nombre from mapa where id_casilla = $id_ciudad limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg["nombre"];
	}

	public static function idCiudadPorCoordenadas($x,$y) //Para obtener el nombre de una ciudad por sus coordenadas
	{
		$mysqli=DB::Get();
		$sql="select id_casilla from mapa where x=$x and y=$y limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg["id_casilla"];
	}

	public static function propietario($id_ciudad)
	{
		$mysqli=DB::Get();
		$sql="select id_usuario from mapa where id_casilla = $id_ciudad limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg["id_usuario"];
	}
	//*****************************************************
	//****************DATOS EDIFICIOS**********************
	public static function nivelEdificio($edificio,$id_ciudad) //Nivel del edificio de una ciudad
	{
		$mysqli=DB::Get();
		$sql="select nivel from edificios_aldea where edificio = '$edificio' and id_ciudad = $id_ciudad limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg['nivel'];
	}

	public static function produccionEdificio($edificio,$id_ciudad) //Nivel del edificio de una ciudad
	{
		$mysqli=DB::Get();
		$sql="select produccion from edificios_aldea where edificio = '$edificio' and id_ciudad = $id_ciudad limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg['produccion'];
	}

	public static function recursosSuficientes($id,$recursos)
	{
		$mysqli=DB::Get();
		$sql="select madera,barro,hierro,cereal from mapa where id_casilla=$id limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		$recursos=explode('-', $recursos);
		if ($reg['madera']<$recursos[0] ||$reg['barro']<$recursos[1] || $reg['hierro']<$recursos[2] ||$reg['cereal']<$recursos[3])
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	public static function edificioPorSlot($slot)
	{
		$mysqli=DB::Get();
		$id_ciudad=$_SESSION['ju_ciudad'];
		$sql="select edificio from edificios_aldea where id_ciudad = $id_ciudad and slot = $slot limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg['edificio'];
	}

	public static function slotPorEdificio($edificio)
	{
		$mysqli=DB::Get();
		$id_ciudad=$_SESSION['ju_ciudad'];
		$sql="select slot from edificios_aldea where id_ciudad = $id_ciudad and edificio = '$edificio' limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg['slot'];
	}

	public static function edificioDisponible($edificio,$id_ciudad)
	{
		$mysqli=DB::Get();
		$j=0; //Contador para mostrar el numero de la tropa
		$edificio_no_disponible=0;

		$sql="select * from costes_construcciones where edificio='$edificio'";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();	//Buscamos que unidades podemos reclutar de infanteria
		$j++;
		if ($reg['requisitos']=="")
		{
			return 1;
			exit;
		}
		$requisitos=explode('|',$reg['requisitos']);
		$temp=count($requisitos);
		for($i=0;$i<$temp;$i++)
		{
			$requisitos2=explode('_',$requisitos[$i]);
			$sql="select * from edificios_aldea where edificio = '$requisitos2[0]' and nivel >= $requisitos2[1] and id_ciudad = $id_ciudad limit 1";
			
			$resp=$mysqli->query($sql);
			
			if ($resp->num_rows == 0)
			{
				$edificio_no_disponible=1;
			}
		}
		unset($temp);
		if ($edificio_no_disponible==0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	//*****************************************************
	//****************DATOS TROPAS*************************
	public static function tropa($tropa) //Nombre de una tropa segun su numero
	{
		$mysqli=DB::Get();
		$sql="select nombre from datos_tropas where tropa = '$tropa' limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg["nombre"];
	}
	
	public static function nTropas($id_ciudad) //Numeros de tropas de una ciudad
	{
		$mysqli=DB::Get();
		$sql="select * from tropas where id_ciudad = $id_ciudad limit 1";
		$res=$mysqli->query($sql);
		$rem=$res->fetch_array();
		$nTropas=0;
		for ($i=1;$i<11;$i++)
		{
			$nTropas=$nTropas+$rem['tropa'.$i];
		}
		$sql="select * from tropas_refuerzos where id_ciudad_reforzada = $id_ciudad";
		$res=$mysqli->query($sql);
		while($rem=$res->fetch_array())
		{
			for ($i=1;$i<11;$i++)
			{
				$nTropas=$nTropas+$rem['tropa'.$i];
			}
		}
		$sql="select * from ataques where id_ciudad_atacante = $id_ciudad";
		$res=$mysqli->query($sql);
		while($rem=$res->fetch_array())
		{
			for ($i=1;$i<11;$i++)
			{
				$nTropas=$nTropas+$rem['tropa'.$i];
			}
		}
		$sql="select * from vuelta_ataques where id_ciudad_atacante = $id_ciudad";
		$res=$mysqli->query($sql);
		while($rem=$res->fetch_array())
		{
			for ($i=1;$i<11;$i++)
			{
				$nTropas=$nTropas+$rem['tropa'.$i];
			}
		}
		return $nTropas;
	}

	public static function consumoTropas($id_ciudad)
	{
		$mysqli=DB::Get();
		$sql="select * from tropas where id_ciudad = $id_ciudad limit 1";
		$res=$mysqli->query($sql);
		$rem=$res->fetch_array();
		$nTropas=0;
		for ($i=1;$i<11;$i++)
		{
			$sql="select consumo from datos_tropas where tropa='tropa$i'";
			$res=$mysqli->query($sql);
			$rel=$res->fetch_array();
			$cTropa=$rem['tropa'.$i]*$rel['consumo'];
			$nTropas=$nTropas+$cTropa;
		}
		$sql="select * from tropas_refuerzos where id_ciudad_reforzada = $id_ciudad";
		$res=$mysqli->query($sql);
		while($rem=$res->fetch_array())
		{
			for ($i=1;$i<11;$i++)
			{
				$sql="select consumo from datos_tropas where tropa='tropa$i'";
				$res=$mysqli->query($sql);
				$rel=$res->fetch_array();
				$cTropa=$rem['tropa'.$i]*$rel['consumo'];
				$nTropas=$nTropas+$cTropa;
			}
		}
		$sql="select * from ataques where id_ciudad_atacante = $id_ciudad";
		$res=$mysqli->query($sql);
		while($rem=$res->fetch_array())
		{
			for ($i=1;$i<11;$i++)
			{
				$sql="select consumo from datos_tropas where tropa='tropa$i'";
				$res=$mysqli->query($sql);
				$rel=$res->fetch_array();
				$cTropa=$rem['tropa'.$i]*$rel['consumo'];
				$nTropas=$nTropas+$cTropa;
			}
		}
		$sql="select * from vuelta_ataques where id_ciudad_atacante = $id_ciudad";
		$res=$mysqli->query($sql);
		while($rem=$res->fetch_array())
		{
			for ($i=1;$i<11;$i++)
			{
				$sql="select consumo from datos_tropas where tropa='tropa$i'";
				$res=$mysqli->query($sql);
				$rel=$res->fetch_array();
				$cTropa=$rem['tropa'.$i]*$rel['consumo'];
				$nTropas=$nTropas+$cTropa;
			}
		}
		return $nTropas;
	}
	public static function velocidadEjercito($id_ejercito,$objetivo)
	{
		$velocidad=5000;
		$mysqli=DB::Get();
		if ($objetivo=='ir')
		{
			$sql="select * from ataques where id_ataque=$id_ejercito";
			$res=$mysqli->query($sql);
		}
		if ($objetivo=='volver')
		{
			$sql="select * from vuelta_ataques where id_vuelta=$id_ejercito";
			$res=$mysqli->query($sql);
		}
		$reg=$res->fetch_array();
		for ($y=1;$y<=10;$y++)
		{
			if ($reg['tropa'.$y]>0)
			{
				$sql="select velocidad from datos_tropas where tropa = 'tropa$y'";
				$res=$mysqli->query($sql);
				$red=$res->fetch_array();
				
				if ($red['velocidad']<$velocidad || $velocidad == 0)
				{
					$velocidad=$red['velocidad'];
				}
			}
			else
			{

			}
		}
		return $velocidad;
	}

	public static function tropasReclutandose($id_ciudad,$tropa)
	{
		$mysqli=DB::Get();
		$sql="select * from cola_produccion where id_ciudad=$id_ciudad and tropa='$tropa'";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg["n_tropas"];
	}

	/*public static function tropasPropiasCiudad($id_ciudad)
	{
		$sql="select * from tropas where id_ciudad=$id_ciudad";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();

		//Las tropas que hay en la ciudad
		$tropas=array($reg['tropa1'],$reg['tropa2'],$reg['tropa3'],$reg['tropa4'],$reg['tropa5'],$reg['tropa6'],
		$reg['tropa7'],$reg['tropa8'],$reg['tropa9'],$reg['tropa10']);

		$sql="select * from ataques where id_ciudad_atacante=$id_ciudad";
		$res=$this->mysqli->query($sql);
		while($red=$res->fetch_array()) //Añadimos las tropas que estan como refuerzo
		{
			$refuerzo[0]+=$red['tropa1'];
			$refuerzo[1]+=$red['tropa2'];
			$refuerzo[2]+=$red['tropa3'];
			$refuerzo[3]+=$red['tropa4'];
			$refuerzo[4]+=$red['tropa5'];
			$refuerzo[5]+=$red['tropa6'];
			$refuerzo[6]+=$red['tropa7'];
			$refuerzo[7]+=$red['tropa8'];
			$refuerzo[8]+=$red['tropa9'];
			$refuerzo[9]+=$red['tropa10'];
		}

		return $refuerzo;
	}*/
	//*****************************************************
	//****************DATOS ALIANZA************************
	public static function nombreAlianza($id)
	{
		$mysqli=DB::Get();
		$sql="select nombre from alianzas where id_alianza=$id limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg['nombre'];
	}

	public static function idAlianza($nombre)
	{
		$mysqli=DB::Get();
		$sql="select id_alianza from alianzas where nombre='$nombre' limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg['id_alianza'];
	}

	public static function cargoUsuario($id_usuario)
	{
		$mysqli=DB::Get();
		$sql="select nombre from cargos_alianzas where id_usuario=$id_usuario limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg['nombre'];
	}

	public static function nombreAlianzaUsuario($id_usuario)
	{
		$mysqli=DB::Get();
		$sql="select id_alianza from miembros_alianzas where id_usuario=$id_usuario and estado=1 limit 1";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return Datos::nombreAlianza($reg['id_alianza']);
	}

	public static function idAlianzaUsuario($id_usuario)
	{
		$mysqli=DB::Get();
		$sql="select id_alianza from miembros_alianzas where id_usuario=$id_usuario and estado=1 limit 1";
		$res=$mysqli->query($sql);
		if ($res->num_rows>0)
		{
			$reg=$res->fetch_array();
			return $reg['id_alianza'];
		}
		else
			return 0;
	}

	public static function enlaceAlianza($id_alianza=null)
	{
		if (isset($id_alianza))
		{
			$mysqli=DB::Get();
			$sql="select id_alianza from alianzas where id_alianza=$id_alianza limit 1";
			$res=$mysqli->query($sql);
			if ($res->num_rows>0)
			{
				$reg=$res->fetch_array();
				return '<a href="alianza.php?i='.$reg["id_alianza"].'">'.Datos::nombreAlianza($reg["id_alianza"]).'</a>';
			}
		}
	}

	public static function comprobarCargoUsuario($cargo,$id_usuario)
	{
		$mysqli=DB::Get();
		$sql="select * from cargos_alianzas where id_usuario=$id_usuario and cargo$cargo=1 limit 1";
		$res=$mysqli->query($sql);
		if($res->num_row>0)
			return 1;
		else
			return 0;
	}

	public static function tieneAlianza($id_usuario)
	{
		$mysqli=DB::Get();
		$sql="select id_alianza from miembros_alianzas where id_usuario=$id_usuario and estado=1 limit 1";
		$res=$mysqli->query($sql);
		if ($res->num_rows>0)
			return 1;
		else
			return 0;
	}

	//*****************************************************
	//****************OTROS********************************
	
	public static function mensajesNoLeidos($id)
	{
		$mysqli=DB::Get();
		$sql="select COUNT(*) from mensajes where id_destinatario=$id and leido_destinatario=0";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg[0];
	}

	public static function reportesTropasNoLeidos($id)
	{
		$mysqli=DB::Get();
		$sql="select COUNT(*) from reportes_tropas where (id_ciudad_atacante=$id and leido_atacante=0) or (id_ciudad_atacada=$id and leido_atacada=0)";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg[0];
	}

	public static function reportesComercioNoLeidos($id)
	{
		$mysqli=DB::Get();
		$sql="select COUNT(*) from reportes_comercio where (id_ciudad_ofrece=$id and leido_ofrece=0) or (id_ciudad_busca=$id and leido_busca=0)";
		$res=$mysqli->query($sql);
		$reg=$res->fetch_array();
		return $reg[0];
	}

	public static function existeUsuario($id)
	{
		$mysqli=DB::Get();
		$sql="select * from usuarios where id_usuario=$id ";
		$res=$mysqli->query($sql);
		if ($res->num_rows>0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
}

?>