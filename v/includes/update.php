<h2>Actualización de datos</h2>
<?php
/*
Se recorren las funciones de update de cada tabla necesaria:
1. CLientes
2. Profesionales
3. Vendedores
4. Cirugías

Flow:
1. Levantar archivo relativo a la tabla (ej.: clientes.csv)
2. Comparar contra tabla cada registro. Si existe se omite, si no existe se agrega.
3. Retornar cantidad de datos nuevos (si los hubiese).
4. Pasar al próximo archivo.
5. Repetir hasta finalizar maestros.

Ejemplo de llamado de función:

$clientes = updateClientes();
if ($clientes < 1) echo "No se agregaron clientes.";

Ejemplo de final de operación completa:

Se agregaron 5 clientes.
Se agregaron 3 médicos.
No se agregaron vendedores.
Se agregaron 127 cirugías.
*/
require_once "../c/funcs/updates.php";

$clientes = updateClientes();
$profesionales = updateProfesionales();
$vendedores = updateVendedores();
$cirugias = updateCirugias();
$productos = updateProductos();

if ($clientes < 1) echo "<p><span style='color:red;'>✘</span> No se agregaron clientes.</p>";
else {
  if ($clientes == 1) echo "<p><span style='color:green;'>✔</span> Se agregó ".$clientes." cliente.</p>";
  else echo "<p><span style='color:green;'>✔</span> Se agregaron ".$clientes." clientes.</p>";
}
if ($profesionales < 1) echo "<p><span style='color:red;'>✘</span> No se agregaron médicos.</p>";
else {
  if ($profesionales == 1) echo "<p><span style='color:green;'>✔</span> Se agregó ".$profesionales." profesional.</p>";
  else echo "<p><span style='color:green;'>✔</span> Se agregaron ".$profesionales." médicos.</p>";
}
if ($productos < 1) echo "<p><span style='color:red;'>✘</span> No se agregaron productos.</p>";
else {
  if ($productos == 1) echo "<p><span style='color:green;'>✔</span> Se agregó ".$productos." producto.</p>";
  else echo "<p><span style='color:green;'>✔</span> Se agregaron ".$productos." productos.</p>";
}
if ($vendedores < 1) echo "<p><span style='color:red;'>✘</span> No se agregaron vendedores.</p>";
else {
  if ($vendedores == 1) echo "<p><span style='color:green;'>✔</span> Se agregó ".$vendedores." vendedor.</p>";
  else echo "<p><span style='color:green;'>✔</span> Se agregaron ".$vendedores." vendedores.</p>";
}
if ($cirugias < 1) echo "<p><span style='color:red;'>✘</span> No se agregaron cirugías.</p>";
else {
  if ($cirugias == 1) echo "<p><span style='color:green;'>✔</span> Se agregó ".$cirugias." cirugía.</p>";
  else echo "<p><span style='color:green;'>✔</span> Se agregaron ".$cirugias." cirugías.</p>";
}
?>