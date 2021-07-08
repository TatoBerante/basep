<?php
session_start();

date_default_timezone_set('Etc/GMT+3');

if (!isset ($_REQUEST['idm']) || $_REQUEST['idm'] == '') {
    header ('location:../v/default.php?page=pnlmed&error=nomedbloq');
}
else {
    $idm = $_REQUEST['idm'];
    
    require_once "funcs/conn.php";
    $mysqli = mysqli_conn();

    if (!$mysqli) {
        header ('location:../v/default.php?page=pnlmed&error=nosqlmedbloq');
    }
    else {
        $q = "SELECT estado FROM medicos WHERE id_medico_sys = ".$idm;
        $r = mysqli_query($mysqli, $q);
        if (mysqli_num_rows ($r) < 1) { // El idm recibido no existe en la BD
            header ('location:../v/default.php?page=pnlmed&error=medbloqna');
        }
        else {
            $fila = mysqli_fetch_assoc($r);
            $old_estado = $fila['estado'];

            $new_estado = ($old_estado == '1') ? 2 : 1;

            if ($old_estado == 1) {
                // El médico NO está bloqueado
                $new_estado = 2;
                $mssg = "blked";
            }
            else {
                // El médico ESTÁ bloqueado
                $new_estado = 1;
                $mssg = "ublked";
            }
            
            $sql = "UPDATE medicos SET estado = ? WHERE id_medico_sys = ?";
            $stmt = mysqli_stmt_init ($mysqli);
            if (!mysqli_stmt_prepare ($stmt, $sql)) print_r (mysqli_stmt_error($stmt));
            else {
                mysqli_stmt_bind_param ($stmt, "ii", $new_estado, $idm);
                mysqli_stmt_execute ($stmt);
                mysqli_stmt_close($stmt);
                mysqli_free_result($r);
                mysqli_close($mysqli);

                header ('location:../v/default.php?page=bloqmedconfirm&'.$mssg.'=1&idm='.$idm);
            }
        }
    }
}