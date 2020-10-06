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

function search_usuarios ($clue) {
	require_once "conn.php";
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

function search_clientes ($clue, $start=0) {
	include "conn.php";
	$mysqli = mysqli_conn();
	$clientes = array();
	$q = "SELECT * FROM clientes WHERE cliente LIKE '%".$clue."%' ORDER BY cliente";
	if ($clue == '') $q .= " LIMIT ".$start.", 15";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$clientes[] = $fila;
		}
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $clientes;
	}
}

function user_by_id ($id) {
  require_once "conn.php";
	$mysqli = mysqli_conn();
	$q = "SELECT * FROM usuarios WHERE usuario_id=".$id;
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		$usuario = mysqli_fetch_assoc($resultado);
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $usuario;
	}
}

function search_cx ($medico = '',
										$vendedor = '',
										$institucion = '',
										$acreedor = '',
										$financiador = '',
										$estado,
										$mescxd,
										$anocxd,
										$mescxh,
										$anocxh,
										$meslqd,
										$anolqd,
										$meslqh,
										$anolqh) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$cirugias = array();

	$q = "SELECT cx.*, DATE_FORMAT(cx.fecha_cx, '%d-%m-%Y') as fecha_cx_h, cx.descripcion as producto, med.medico, (cx.cantidad * cx.precio_venta) as subtotal
				FROM cirugias cx
				INNER JOIN medicos med ON cx.cod_medico = med.id_medico
				WHERE 1";
	if ($medico != '') $q .= " AND med.medico LIKE '%".$medico."%'";
	if ($vendedor != '') $q .= " AND cx.nombre_vendedor LIKE '%".$vendedor."%'";
	// if ($financiador != '') $q .= " AND cli.cliente LIKE '%".$financiador."%'";
	// if ($institucion != '') $q .= " AND cx.institucion LIKE '%".$institucion."%'";
	if ($mescxd != 'NC' && $anocxd != 'NC' && $mescxh != 'NC' && $anocxh != 'NC') {
		$cxd = $anocxd."-".$mescxd."-01";
		$cxh = $anocxh."-".$mescxh."-31";
		$q .= " AND cx.fecha_cx BETWEEN '".$cxd."' AND '".$cxh."'";
	}
	$q .= " ORDER BY fecha_cx";
	
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$cirugias[] = $fila;
		}
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $cirugias;
	}
}
function data_cx ($nro_cx) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$q = "SELECT SUM(precio_venta*cantidad) as total FROM cirugias WHERE nro_cirugia='".$nro_cx."'";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		$data = mysqli_fetch_assoc($resultado);
		$total = $data['total'];
		$q = "SELECT cx.nombre_paciente, DATE_FORMAT(cx.fecha_cx, '%d-%m-%Y') as fecha_cx_h, med.medico FROM cirugias cx LEFT JOIN medicos med ON cx.cod_medico = med.id_medico WHERE cx.nro_cirugia='".$nro_cx."' LIMIT 1 ";
		$resultado = mysqli_query($mysqli , $q);
		if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
		else {
			$data = mysqli_fetch_assoc($resultado);
			$cx['paciente'] = $data['nombre_paciente'];
			$cx['fecha_cx'] = $data['fecha_cx_h'];
			$cx['medico'] = $data['medico'];
			$cx['monto'] = $total;
			mysqli_free_result($resultado);
			mysqli_close($mysqli);
			return $cx;
		}
	}
}
?>
