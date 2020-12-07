<div class='home-h2'><h2>Home</h2>
<?php
//showCode ($_SESSION['basep']);
?>
<span><a href='default.php?page=update' class='buttons'>Actualizar datos</a></span>
</div>
<?php
/*
$year = 2019;
$leap = date('L', mktime(0, 0, 0, 1, 1, $year));
$leap = date ('L', 2020);
echo "<p>".$leap."</p>";
echo $year . ' ' . ($leap ? 'is' : 'is not') . ' a leap year.';
*/
?>
<h3 class='subtitulo'>Manual de Procesos</h3>
<div class='inst-pics'>
  <span class='proc-step'><img src="img/prepare.png" alt="preparar"><br>preparar</span>
  <span class='proc-step'><img src="img/next.png" alt="siguiente" class='sig'></span>
  <span class='proc-step'><img src="img/pay.png" alt="liquidar"><br>liquidar</span>
  <span class='proc-step'><img src="img/next.png" alt="siguiente" class='sig'></span>
  <span class='proc-step'><img src="img/print.png" alt="imprimir"><br>imprimir</span>
  <span class='proc-step'><img src="img/next.png" alt="siguiente" class='sig'></span>
  <span class='proc-step'><img src="img/audit.png" alt="auditar"><br>auditar</span>
</div>
<h4>Preparar</h4>
<p class='normal-caps'>
  El proceso PREPARAR se inicia en en el Panel de Cirugías.
  <ul class='manop'>
    <li>Utilizar los filtros para dar con los resultados deseados. Es importante en este paso verificar que en el filtro MOSTRAR se encuentre seleccionada la opción PENDIENTES.</li>
    <li>Tildar las cirugías que se desean incluír en el nuevo documento. Es obligatoria la selección de al menos una cirugía para poder continuar con el proceso.</li>
    <li>Revisar que las cirugías a incluír en el nuevo documento hayan sido seleccionadas y hacer click en CONTINUAR al final de la lista de resultados.</li>
    <li>Ya en la página PREPARAR el sistema mostrará el detalle de los productos que componen cada cirugía previamente seleccionada. Completar los valores en la columna PAGAR de cada uno de estos. Tener en cuenta que se agregarán al documento final sólo las cirugías tildadas en esta instancia.</li>
    <li>Seleccionar el ACREEDOR correspondiente, indicar el monto a descontar del saldo del ACREEDOR (el saldo actual se indica junto al nombre en el cuadro de selección) y finalmente quien retira, campo que por default se completa con el vendedor asociado, pero puede ser editado en este punto.</li>
    <li>Tanto los totales del documento preparado como la actualización del saldo del acreedor son calculados y registrados por la plataforma de manera automática al finalizar este proceso.</li>
    <li>Con todos los datos completados, click en REGISTRAR al final del formulario (en caso de error en el envío de datos el sistema informará al usuario para su corrección).</li>
    <li>El sistema debería mostrar un mensaje de registro exitoso. Las cirugías seleccionadas ya forman parte de un documento listo para liquidar.</li>
  </ul>
</p>
<h4>Liquidar</h4>
<p class='normal-caps'>
  El proceso LIQUIDAR también se inicia en el Panel de Cirugías, pero no opera sobre cirugías, sino sobre documentos registrados en el proceso PREPARAR.
  <ul class='manop'>
    <li>Utilizar los filtros para dar con los resultados deseados. Es importante en este paso verificar que en el filtro MOSTRAR se encuentre seleccionada la opción PREPARADAS.</li>
    <li>Tildar los documentos que se deseen liquidar y hacer click en CONTINUAR al final de la lista de resultados. Es obligatoria la selección de al menos un documento para poder continuar con el proceso.</li>
    <li>Ya en la página LIQUIDAR se mostrarán los documentos seleccionados. Ningún monto es editable en esta etapa. Todos los registros de montos, acreedor y retira son exclusivos del proceso PREPARAR.</li>
    <li>Verificar que los documentos mostrados sean los que realmente se desea liquidar. Si así no lo fuese, presionar CANCELAR para volver al Panel de Cirugías y corregir la selección (los filtros usados previamente no se perderán).</li>
    <li>Si todo está en orden, hacer click en LIQUIDAR.</li>
    <li>El sistema debería informar un mensaje de liquidación exitosa. Los documentos liquidados ya son imprimibles y pueden ser auditados individualmente.</li>
  </ul>
</p>
<h4>Imprimir</h4>
<p class='normal-caps'>
  La impresión de documentos liquidados se efectúa también desde el Panel de Cirugías
  <ul class='manop'>
    <li>Utilizar los filtros para dar con los resultados deseados. Es importante en este paso verificar que en el filtro MOSTRAR se encuentre seleccionada la opción FINALIZADAS.</li>
    <li>Tildar los documentos que se deseen imprimir y hacer click en CONTINUAR al final de la lista de resultados. Es obligatoria la selección de al menos un documento para poder continuar con el proceso.</li>
    <li>Ya en la página IMPRIMIR se mostrarán los documentos seleccionados. Si los documentos mostrados no son los deseados hacer click en CANCELAR para volver al Panel de Cirugías y corregir la selección (los filtros usados previamente no se perderán).</li>
    <li>Si la selección es correcta, hacer click en IMPRIMIR.</li>
    <li>El sistema mostrará los documentos en versión imprimible. Es importante marcar que a pesar de que en pantalla los documentos se muestren uno a continuación de otro, al imprimirse en papel cada documento se iniciará en una hoja nueva.</li>
    <li>Hacer Ctrl+P para imprimir. Para una correcta impresión es importante verificar las opciones de impresión en el navegador web utilizado para operar con la plataforma.</li>
  </ul>
</p>
<h4>Auditar</h4>
<p class='normal-caps'>
  Todo documento liquidado puede auditarse.
  <ul class='manop'>
    <li>En el Panel de Cirugías ingresar el número del documento en el filtro REMITO. Tener en cuenta que al ingresar este dato ignora cualquier otro filtro utilizado.</li>
    <li>El panel mostrará el detalle completo de fechas de preparación y liquidación, acreedor, quién retiró, saldos y máximo detalle de los productos incluídos en cada cirugía que compone el documento.</li>
    <li>Si no se sabe el número exacto de documento, se puede utilizar una combinación de filtros mostrando FINALIZADAS. Al mostrar los resultados cada documento mostrará un botón VER REMITO para poder acceder al detalle.</li>
  </ul>
</p>