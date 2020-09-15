<?php
function logThis ($desc) {
	include "DBconnect.php";
	$sql = "INSERT INTO syslogs (id_usuario, descripcion)
          VALUES (?, ?)";
	$stmt = mysqli_stmt_init ($conn);
	if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
	else {
		$idu = $_SESSION['iris']['id_user_iris'];
		mysqli_stmt_bind_param ($stmt, "is", $idu, $desc);
		mysqli_stmt_execute ($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
}

function searchUsuarios ($clue) {
	include "conn.php";
	$mysqli = mysqli_conn();
  $usuarios = array();
	$q = "SELECT * FROM usuarios WHERE usuario_apellido LIKE '%".$clue."%' ORDER BY usuario_apellido, usuario_nombre";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$usuarios[] = $fila;
		}
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $usuarios;
	}
}

function lista_transportistas () {
  
}

function transportista_by_id ($id) {
  include "DBconnect.php";
	$q = "SELECT CONCAT(apellido, ' ' ,nombre) as transportista FROM transportistas WHERE id_transportista = ".$id;
	$resultado = mysqli_query($conn , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($conn).") ".mysqli_error($conn)."</p><pre>".$q."</pre>";
	else {
		$fila = mysqli_fetch_assoc($resultado);
		$transportista = $fila['transportista'];
		mysqli_free_result($resultado);
		mysqli_close($conn);
		return $transportista;
	}
}
?>
