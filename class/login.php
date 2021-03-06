<?php
require_once('./FirePHPCore/FirePHP.class.php');
require_once("init.php");
require_once('seguridad.php');
require_once('datos_auxiliares.php');
require_once('mysqli.php');

class Login
{
	private $edificios=array();
	private $recursos=array();
	private $mysqli;
	private $firephp;

	public function __construct()
	{
		$this->mysqli=DB::Get();
		$this->firephp = FirePHP::getInstance(true);
	}
	public function login($nombre=0, $password=0)
	{
		if (isset($_POST["nombre"]) && isset($_POST["password"])) //Si se ha enviado el formulario
		{
				$nombre = safe($_POST["nombre"]);
				$password = safe($_POST["password"]);
		}
		else if ($nombre != 0 && $password != 0)
		{

		}
		else
		{
			header("Location:login.php?m=2");
			exit;
		}


		$sql="select * from usuarios where nombre = '$nombre' and password = '$password'"; //Comprobamos el usuario y la contraseña
		$res=$this->mysqli->query($sql);
		if ($res->num_rows >0)
		{
			$reg=$res->fetch_array();
			$_SESSION["ju_nom"] = $reg["nombre"];	//Creamos la sesion
			$id_usuario=Datos::id($nombre);

			$sql="select * from mapa where id_usuario = $id_usuario and capital = 'si'";
			$res=$this->mysqli->query($sql);
			$reg=$res->fetch_array();

			$_SESSION['ju_ciudad']=$reg['id_casilla'];
			$this->firephp->log($_SESSION['ju_nom'],'Usuario');
			$this->firephp->log($_SESSION['ju_ciudad'],'id_ciudad');
			header("Location:index.php"); //Le llevamos a su ciudad
			exit;
		}
		else
		{
			header("Location:login.php?m=2");
			exit;
		}
			
	}

	public function registro()
	{
		if (isset($_POST["nombre"]) && isset($_POST["password"]) && isset($_POST["correo"])) //Comprobamos que se ha enviado el formulario
		{
			$nombre = safe($_POST["nombre"]);
			$password = safe($_POST["password"]);
			$correo = safe($_POST["correo"]);
			$tiempo = strtotime(date('Y-m-d H:i:s'));
			$ip=Datos::getIp();

			//Comprobamos que esta disponible el nombre y el correo
			$sql="select * from usuarios where nombre = '$nombre'";
			$res=$this->mysqli->query($sql);
			if ($res->num_rows >0)
			{
				header("Location:login.php?m=3");
				exit;
			}

			$sql="select * from usuarios where correo = '$correo'";
			$res=$this->mysqli->query($sql);
			if ($res->num_rows >0)
			{
				header("Location:login.php?m=4");
				exit;
			}
			if (strlen($nombre)>25||strlen($correo)>100||strlen($password)>105)
			{
				header("Location:login.php?m=6");
				exit;
			}
			//*******************************************************/

			$sql="insert into usuarios values (null,'$nombre','$password','$correo','',now(),'$ip')";
			$res=$this->mysqli->query($sql);
			$id_usuario=Datos::id($nombre);
			//********************
			$x = rand(1,10);
			$y = rand(1,10);
			$sql="select * from mapa where x = $x and y = $y and id_usuario !=0"; //Comprobamos que no esta ocupada la casilla de la ciudad
			$res=$this->mysqli->query($sql);

			while ($res->num_rows >0) //Mientras este ocupada la casilla seguimos comprobando
			{
				$x = rand(1,10);
				$y = rand(1,10);
				$sql="select * from mapa where x = $x and y = $y and id_usuario !=0";
				$res=$this->mysqli->query($sql);
			}

			//Creamos la ciudad
			$sql="update mapa set nombre = 'Pueblo de $nombre',tipo = 'Pueblo', id_usuario = $id_usuario, habitantes = 8, madera = 500,barro=500,hierro=500,cereal=500,capital = 'si', last_update = $tiempo  where x = $x and y = $y";
			$res=$this->mysqli->query($sql);
			//************************
			$id_ciudad = Datos::id_ciudad($id_usuario);

			$sql="insert into edificios_aldea values 
			(null,'foro',0,'ninguno',0,0,0,$id_ciudad),
			(null,'granja',0,'cereal',3,2,0,$id_ciudad),
			(null,'leñador',0,'madera',3,2,0,$id_ciudad),
			(null,'ladrillar',0,'barro',3,2,0,$id_ciudad),
			(null,'mina',0,'hierro',3,2,0,$id_ciudad),
			(null,'almacen',0,'capacidad',800,0,0,$id_ciudad),
			(null,'mercado',0,'comercio',0,0,0,$id_ciudad),
			(null,'cuartel',0,'tropas',0,0,0,$id_ciudad),
			(null,'establo',0,'tropas',0,0,0,$id_ciudad),
			(null,'taller',0,'tropas',0,0,0,$id_ciudad),
			(null,'embajada',0,'miembros',0,0,0,$id_ciudad),
			(null,'palacio',0,'expansion',0,0,0,$id_ciudad),
			(null,'escondite',0,'escondidos',0,0,0,$id_ciudad)";
			$res=$this->mysqli->query($sql);

			$sql="insert into tropas values (null,0,0,0,0,0,0,0,0,0,0,$id_ciudad)";
			$res=$this->mysqli->query($sql);
			$this->login($nombre,$password);
			//header("Location:login.php?m=2");
			exit;
		}
		header("Location:registro.php?m=1");
	}

	public function interpretaError()
	{
		if (isset($_GET['m']))
		{
			if ($_GET['m']==1)
			{
				echo "Ha ocurrido un error";
			}
			elseif ($_GET['m']==2)
			{
				echo "Te has registrado con exito";
			}
			elseif ($_GET['m']==3)
			{
				echo "El nombre de usuario esta en uso";
			}
			elseif ($_GET['m']==4)
			{
				echo "La direccion de correo esta en uso";
			}
			elseif ($_GET['m']==5)
			{
				echo "Ya tienes una cuenta activa";
			}
			elseif ($_GET['m']==6)
			{
				echo "Tu nombre, contrase&ntilde;a, o correo es muy largo";
			}
		}
	}
}
?>