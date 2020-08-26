<?php
function showCode ($mixvar) {
  echo "<pre>";
  print_r ($mixvar);
  echo "</pre>";
}
function sanitizeThis ($text) {
  $cleanString = trim ($text);
  return $cleanString;
}
?>