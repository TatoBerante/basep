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

function showall ($vble) {
	echo "<p><pre>";
	print_r ($vble);
	echo "</pre></p>";
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
	require_once "conn.php";
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

function cliente_by_id ($id) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$clientes = array();
	$q = "SELECT * FROM clientes WHERE id_cliente_sys = ".$id;
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		$cliente = mysqli_fetch_assoc($resultado);
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $cliente;
	}
}

function search_medicos ($clue, $start=0) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$medicos = array();
	$q = "SELECT * FROM medicos WHERE medico LIKE '%".$clue."%' ORDER BY medico";
	if ($clue == '') $q .= " LIMIT ".$start.", 15";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$medicos[] = $fila;
		}
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $medicos;
	}
}

function medico_by_id ($id) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$medico = array();
	// Datos genéricos:
	$q = "SELECT * FROM medicos WHERE id_medico_sys = ".$id;
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		$medico = mysqli_fetch_assoc($resultado);
		// Total pendiente:
		$q = "SELECT SUM(cx.precio_venta) AS total_pendientes FROM cirugias cx
					WHERE cx.cod_medico = '".$medico['id_medico']."' AND estado = 1";
		$resultado = mysqli_query($mysqli , $q);
		$fila = mysqli_fetch_assoc($resultado);
		$medico['total_pendientes'] = $fila['total_pendientes'];
		// Total preparado:
		$q = "SELECT SUM(cx.precio_venta) AS total_preparados FROM cirugias cx
					WHERE cx.cod_medico = '".$medico['id_medico']."' AND estado = 2";
		$resultado = mysqli_query($mysqli , $q);
		$fila = mysqli_fetch_assoc($resultado);
		$medico['total_preparados'] = $fila['total_preparados'];
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $medico;
	}
}

function search_10_regalias ($idm) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$regalias = array();
	$q = "SELECT *, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha_h FROM regalias WHERE id_medico_sys = ".$idm." ORDER BY fecha DESC, id_regalia DESC LIMIT 10";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$regalias[] = $fila;
		}
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $regalias;
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

	$q = "SELECT cx.*, DATE_FORMAT(cx.fecha_cx, '%d-%m-%Y') as fecha_cx_h, cx.descripcion as producto, med.medico, (cx.cantidad * cx.precio_venta) as subtotal, cli.cliente, rem.id_remito
				FROM cirugias cx
				LEFT JOIN medicos med ON cx.cod_medico = med.id_medico
				INNER JOIN clientes cli ON cx.id_cliente = cli.id_csv
				LEFT JOIN remitos rem ON cx.id_remito = rem.id_remito
				WHERE 1";
	if ($medico != '') $q .= " AND med.medico LIKE '%".$medico."%'";
	if ($vendedor != '') $q .= " AND cx.nombre_vendedor LIKE '%".$vendedor."%'";
	if ($financiador != '') $q .= " AND cli.cliente LIKE '%".$financiador."%'";
	if ($estado != '0') $q .= " AND cx.estado = ".$estado;
	if ($institucion != '') $q .= " AND cx.institucion LIKE '%".$institucion."%'";
	if ($acreedor != '') $q .= " AND med.medico LIKE '%".$acreedor."%'";

	if ($mescxd != 'NC' && $anocxd != 'NC' && $mescxh != 'NC' && $anocxh != 'NC') {
		// Leap year issue
		if ($mescxh == '01' || $mescxh == '03' || $mescxh == '05' || $mescxh == '07' || $mescxh == '08' || $mescxh == '10' || $mescxh == '12') $lastdh = '31';
		else {
			if ($mescxh != '02') $lastdh = '30';
			else { // Feb
				$leap = date('L', mktime(0, 0, 0, 1, 1, $anocxd));
				$lastdh = ($leap) ? '29' : '28';
			}
		}
		$cxd = $anocxd."-".$mescxd."-01";
		$cxh = $anocxh."-".$mescxh."-".$lastdh;
		$q .= " AND cx.fecha_cx BETWEEN '".$cxd."' AND '".$cxh."'";
	}
	if ($meslqd != 'NC' && $anolqd != 'NC' && $meslqh != 'NC' && $anolqh != 'NC') {
		// Leap year issue
		if ($meslqh == '01' || $meslqh == '03' || $meslqh == '05' || $meslqh == '07' || $meslqh == '08' || $meslqh == '10' || $meslqh == '12') $lastdh = '31';
		else {
			if ($meslqh != '02') $lastdh = '30';
			else { // Feb
				$leap = date('L', mktime(0, 0, 0, 1, 1, $anolqd));
				$lastdh = ($leap) ? '29' : '28';
			}
		}
		$lqd = $anolqd."-".$meslqd."-01";
		$lqh = $anolqh."-".$meslqh."-".$lastdh;
		$q .= " AND rem.fecha_liquidado BETWEEN '".$lqd."' AND '".$lqh."'";
	}
	$q .= " ORDER BY cx.fecha_cx, cx.nro_cirugia";
	//showall($q);
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
		$q = "SELECT cx.id_cirugia_sys, cx.nombre_paciente, DATE_FORMAT(cx.fecha_cx, '%d-%m-%Y') as fecha_cx_h, med.medico, cli.cliente, cli.aplicable, cx.estado, cx.id_remito, cx.nombre_vendedor, cx.cod_vendedor
					FROM cirugias cx
					INNER JOIN clientes cli ON cx.id_cliente = cli.id_csv
					LEFT JOIN medicos med ON cx.cod_medico = med.id_medico
					WHERE cx.nro_cirugia='".$nro_cx."' LIMIT 1";
		$resultado = mysqli_query($mysqli , $q);
		if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
		else {
			$data = mysqli_fetch_assoc($resultado);
			$cx['id_cirugia_sys'] = $data['id_cirugia_sys'];
			$cx['paciente'] = $data['nombre_paciente'];
			$cx['fecha_cx'] = $data['fecha_cx_h'];
			$cx['medico'] = $data['medico'];
			$cx['monto'] = $total;
			$cx['cliente'] = $data['cliente'];
			$cx['aplicable'] = $data['aplicable'];
			$cx['estado'] = $data['estado'];
			$cx['id_remito'] = $data['id_remito'];
			$cx['vendedor'] = $data['nombre_vendedor'];
			$cx['cod_vendedor'] = $data['cod_vendedor'];
			mysqli_free_result($resultado);
			mysqli_close($mysqli);
			return $cx;
		}
	}
}

function data_cx_detalle ($nro_cx) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$q = "SELECT cx.id_cirugia_sys, DATE_FORMAT(cx.fecha_cx, '%d-%m-%Y') AS fecha_cx_h, cx.nro_cirugia,
				cx.nombre_paciente, cx.nombre_vendedor, cx.id_remito, rem.monto_total, rem.monto_ctacte,
				rem.saldo_ctacte_previo, DATE_FORMAT(rem.fecha_preparado, '%d-%m-%Y') AS fecha_prep_h,
				DATE_FORMAT(rem.fecha_liquidado, '%d-%m-%Y') AS fecha_liq_h,
				ven.vendedor as portador, acr.medico as acreedor,
				CONCAT (cx.producto, ' - ', cx.descripcion) AS producto,
				cx.cantidad, cx.precio_venta, med.medico, cli.cliente, cli.aplicable,
				(cx.cantidad * cx.precio_venta) AS subtotal,
				(((cx.cantidad * cx.precio_venta) * cli.aplicable) / 100) AS pagable, cx.monto_a_pagar,
				(rem.monto_total - rem.monto_ctacte) as pagado
				FROM cirugias cx
				INNER JOIN clientes cli ON cx.id_cliente = cli.id_csv
				LEFT JOIN medicos med ON cx.cod_medico = med.id_medico
				LEFT JOIN remitos rem ON cx.id_remito = rem.id_remito
				LEFT JOIN vendedores ven ON rem.id_portador = ven.id_vendedor_sys
				LEFT JOIN medicos acr ON rem.id_acreedor = acr.id_medico_sys
				WHERE cx.nro_cirugia = '".$nro_cx."'
				ORDER BY cx.producto";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		$cxs = array ();
		while ($data = mysqli_fetch_assoc($resultado)) {
			$cxs[] = $data;
		/*
			$cx['paciente'] = $data['nombre_paciente'];
			$cx['fecha_cx'] = $data['fecha_cx_h'];
			$cx['medico'] = $data['medico'];
			$cx['monto'] = $total;
			$cx['cliente'] = $data['cliente'];
			$cx['aplicable'] = $data['aplicable'];
			$cx['estado'] = $data['estado'];
			$cx['id_remito'] = $data['id_remito'];
		*/
		}
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $cxs;
	}
}

function data_remito ($id_remito) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$remito = array();
	$q = "SELECT r.*, m.id_medico_sys, m.medico, DATE_FORMAT(r.fecha_preparado, '%d-%m-%Y') as fecha_prep_h,
				v.vendedor as retira, c.nro_cirugia, DATE_FORMAT(c.fecha_cx, '%d-%m-%Y') as fecha_cx_h,
				c.nombre_paciente as paciente, DATE_FORMAT(r.fecha_liquidado, '%d/%m/%y') as fecha_lq_h
				FROM remitos r
				INNER JOIN medicos m ON r.id_acreedor = m.id_medico_sys
				LEFT JOIN vendedores v ON r.id_portador = v.id_vendedor_sys
				INNER JOIN cirugias c ON r.id_remito = c.id_remito
				WHERE r.id_remito = ".$id_remito;
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		$remito = mysqli_fetch_assoc($resultado);
		return $remito;
	}
}

function lista_medicos () {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$medicos = array();
	$q = "SELECT * FROM medicos ORDER BY medico";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$medicos[] = $fila;
		}
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $medicos;
	}
}

function lista_vendedores () {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$vendedores = array();
	$q = "SELECT * FROM vendedores ORDER BY vendedor";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$vendedores[] = $fila;
		}
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $vendedores;
	}
}

function cxs_en_remito ($id_remito) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$cxs = array();
	$q = "SELECT DISTINCT cx.nro_cirugia, date_format(cx.fecha_cx, '%d-%m-%Y') AS fecha_cx_h,
				cx.nombre_paciente, med.medico as cirujano, rem.*, (rem.monto_total - rem.monto_ctacte) AS total,
				cx.institucion
				FROM cirugias cx
				INNER JOIN remitos rem ON cx.id_remito = rem.id_remito
				LEFT JOIN medicos med ON cx.cod_medico = med.id_medico
				WHERE cx.id_remito = '".$id_remito."'";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$cxs[] = $fila;
		}
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $cxs;
	}
}

function cx_subtotal ($nro_cx) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$q = "SELECT SUM(monto_a_pagar) as total FROM cirugias WHERE nro_cirugia = '".$nro_cx."'";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		$fila = mysqli_fetch_assoc($resultado);
		$total = $fila['total'];
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $total;
	}
	return 999;
}

function search_remitos ($medico = '',
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
	$remitos = array();
//  date_format(cx.fecha_cx, '%d-%m-%Y') AS fecha_cx_h
	$q = "SELECT rem.id_remito, rem.monto_total, rem.monto_ctacte, (rem.monto_total - rem.monto_ctacte) AS total,
				date_format(rem.fecha_preparado, '%d-%m-%Y') AS fecha_preparado_h, rem.saldo_ctacte_previo as saldo_pre,
				cx.nro_cirugia, med.medico as acreedor, cj.medico as cirujano, ven.vendedor as retira,
				cx.descripcion as producto, cx.cantidad, cx.nombre_paciente as paciente,
				date_format(cx.fecha_cx, '%d-%m-%Y') AS fecha_cx_h, cx.monto_a_pagar,
				cx.nombre_vendedor as vendedor, cli.cliente as financiador
				FROM remitos rem
				INNER JOIN medicos med ON rem.id_acreedor = med.id_medico_sys
				LEFT JOIN vendedores ven ON rem.id_portador = ven.id_vendedor_sys 
				INNER JOIN cirugias cx ON rem.id_remito = cx.id_remito
				INNER JOIN medicos cj ON cx.cod_medico = cj.id_medico
				INNER JOIN clientes cli ON cx.id_cliente = cli.id_csv
				WHERE 1";
	if ($medico != '') $q .= " AND cj.medico LIKE '%".$medico."%'";
	if ($vendedor != '') $q .= " AND cx.nombre_vendedor LIKE '%".$vendedor."%'";
	if ($financiador != '') $q .= " AND cli.cliente LIKE '%".$financiador."%'";
	if ($estado != '0') $q .= " AND cx.estado = ".$estado;
	if ($institucion != '') $q .= " AND cx.institucion LIKE '%".$institucion."%'";
	if ($acreedor != '') $q .= " AND med.medico LIKE '%".$acreedor."%'";

	if ($mescxd != 'NC' && $anocxd != 'NC' && $mescxh != 'NC' && $anocxh != 'NC') {
		// Leap year issue
		if ($mescxh == '01' || $mescxh == '03' || $mescxh == '05' || $mescxh == '07' || $mescxh == '08' || $mescxh == '10' || $mescxh == '12') $lastdh = '31';
		else {
			if ($mescxh != '02') $lastdh = '30';
			else { // Feb
				$leap = date('L', mktime(0, 0, 0, 1, 1, $anocxd));
				$lastdh = ($leap) ? '29' : '28';
			}
		}
		$cxd = $anocxd."-".$mescxd."-01";
		$cxh = $anocxh."-".$mescxh."-".$lastdh;
		$q .= " AND cx.fecha_cx BETWEEN '".$cxd."' AND '".$cxh."'";
	}
	if ($meslqd != 'NC' && $anolqd != 'NC' && $meslqh != 'NC' && $anolqh != 'NC') {
		// Leap year issue
		if ($meslqh == '01' || $meslqh == '03' || $meslqh == '05' || $meslqh == '07' || $meslqh == '08' || $meslqh == '10' || $meslqh == '12') $lastdh = '31';
		else {
			if ($meslqh != '02') $lastdh = '30';
			else { // Feb
				$leap = date('L', mktime(0, 0, 0, 1, 1, $anolqd));
				$lastdh = ($leap) ? '29' : '28';
			}
		}
		$lqd = $anolqd."-".$meslqd."-01";
		$lqh = $anolqh."-".$meslqh."-".$lastdh;
		$q .= " AND rem.fecha_liquidado BETWEEN '".$lqd."' AND '".$lqh."'";
	}

	$q .= " ORDER BY rem.fecha_preparado, rem.id_remito, cx.nro_cirugia";
	//showall($q);
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$remitos[] = $fila;
		}
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		return $remitos;
	}
}
function detalle_remito ($id_remito) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$remito = array();	
	$q = "SELECT cx.nro_cirugia, cx.nombre_paciente AS paciente, cx.institucion,
				acr.medico AS acreedor, por.vendedor AS retira,
				rem.id_remito, rem.monto_total AS total_remito, rem.monto_ctacte AS descuento,
				rem.saldo_ctacte_previo AS saldo_previo,
				med.medico, cli.cliente as financiador,
				DATE_FORMAT(rem.fecha_preparado, '%d-%m-%Y') AS fecha_preparado_h,
				DATE_FORMAT(rem.fecha_liquidado, '%d-%m-%Y') AS fecha_liquidado_h,
				DATE_FORMAT(cx.fecha_cx, '%d-%m-%Y') AS fecha_cx_h
				FROM remitos rem
				INNER JOIN cirugias cx ON rem.id_remito = cx.id_remito
				INNER JOIN medicos acr ON rem.id_acreedor = acr.id_medico_sys
				INNER JOIN vendedores por ON rem.id_portador = por.id_vendedor_sys
				LEFT JOIN medicos med ON cx.cod_medico = med.id_medico
				INNER JOIN clientes cli ON cx.id_cliente = cli.id_csv
				WHERE rem.id_remito = $id_remito
				GROUP BY cx.nro_cirugia, cx.nombre_paciente, cx.fecha_cx, cx.cod_medico, cli.cliente, cx.institucion";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		while ($fila = mysqli_fetch_assoc($resultado)) {
			$remito[] = $fila;
		}
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		//showall($q);
		return $remito;
	}
}
function total_cx ($nro_cirugia) {
	require_once "conn.php";
	$mysqli = mysqli_conn();
	$q = "SELECT SUM(monto_a_pagar) as total FROM cirugias WHERE nro_cirugia = '".$nro_cirugia."'";
	$resultado = mysqli_query($mysqli , $q);
	if (!$resultado) echo "<p>Fallo al ejecutar la consulta: (".mysqli_errno($mysqli).") ".mysqli_error($mysqli)."</p><pre>".$q."</pre>";
	else {
		$fila = mysqli_fetch_assoc($resultado);
		$total = $fila['total'];
		mysqli_free_result($resultado);
		mysqli_close($mysqli);
		
		return $total;
	}
}
?>
