<?php
class Perfil
{
	private $mysqli;
	private $usuario;
	private $id_usuario;

	public function __construct()
	{
		$this->mysqli=DB::Get();
		$this->usuario=$_SESSION["ju_nom"];
		$this->id_usuario=Datos::id($this->usuario);
	}

	public function mostrar_pefil() //Muestra el perfil
	{
		$puntos=0;
		if (isset($_GET['usuario'])) //Si pedimos el perfil de un usuario lo mostramos
		{
			$usuario=$_GET['usuario'];
			$id_usuario=Datos::id($usuario);
			if ($id_usuario==0)
			{
				$usuario=$this->usuario;
				$id_usuario=$this->id_usuario;
			}
		}
		else
		{
			$usuario=$this->usuario;
			$id_usuario=$this->id_usuario;
		}

		$sql="select * from usuarios where id_usuario=$id_usuario limit 1";
		$res=$this->mysqli->query($sql);
		$reg=$res->fetch_array();
		?>
		Nombre: <strong><?php echo $reg['nombre'];?></strong>
		<br />
		<div id="puntos"></div>
		Alianza: <strong><?php echo Datos::enlaceAlianza(Datos::idAlianzaUsuario($reg['id_usuario']));?></strong>
		<h3>Perfil</h3>
		<?php
		if (!isset($_GET['s'])) //Si lo estamos viendo
		{
			echo $reg['perfil'];
		}
		else //Si lo estamos editando
		{
			?>
			<form name="form_perfil" action="procesa_cuenta.php" method="post">
			<textarea name="perfil" id="edit_perfil"><?php echo $reg['perfil'];?></textarea>
			<?php
		}
		echo "<hr />";

		$sql="select * from mapa where id_usuario=$id_usuario";
		$res=$this->mysqli->query($sql);
		echo "<h3>Ciudades</h3>";
		while($red=$res->fetch_array()) //Mostramos las ciudades que tiene el usuario
		{
			echo "<a href='aldea.php?x=".$red["x"]."&y=".$red["y"]."' class='enlace_aldea'><b>".$red['nombre']."</b></a>  |  Habitantes: <b>".$red['habitantes']."</b>";
			$puntos=$puntos+$red['habitantes'];
			echo "<br />";
		}
		echo "<hr/>";
		?>

		<script type="text/javascript">
		$("#puntos").html("Puntos: "+<?php echo $puntos;?>);
		</script>
		<?php
		if ($usuario == $this->usuario) //Si miramos nuestro propio perfil
		{
			if (!isset($_GET['s']))
			{
				?><br/><a href="perfil.php?s=1" class="boton">Editar perfil</a><?php
			}
			else
			{
				?>
				<br/><input type="submit" class="boton" value="Guardar perfil" />
				<input type="hidden" value="1" name="s" />
				</form>
				<?php
			}
		}
		else
		{
			?>
			<br/><a href='redactar_mensaje.php?usuario=<?php echo $reg['nombre'];?>' class="boton">Enviar Mensaje</a>
			<?php
		}

	}

	public function cambiar_perfil()
	{

		$cambiar_perfil = $_POST['perfil'];

		$cambiar_perfil = htmlentities($cambiar_perfil,ENT_QUOTES);
		$cambiar_perfil = strip_tags($cambiar_perfil,"<br>,<hr>");


		$sql="update usuarios set perfil = '".$cambiar_perfil."' where id_usuario = $this->id_usuario";
		$res=$this->mysqli->query($sql);
		header("Location:perfil.php");
	}

	public function cambiar_password()
	{

	}

	public function cambiar_correo()
	{

	}

	public function cambiar_nombre()
	{

	}

	public function cambiar_nombre_aldea()
	{

	}

	public function eliminar_cuenta()
	{

	}
}

?>