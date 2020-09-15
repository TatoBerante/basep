<?php
function showCode ($mixvar) {
  echo "<pre>";
  print_r ($mixvar);
  echo "</pre>";
}
function sanitizeThis ($text) {
  //$cleanString = trim ($text);
  $not_allowed = array ('\\\'', '\"', ';', '´');
  $cleanString = trim (str_replace ($not_allowed, '', $text));
  return $cleanString;
}
?>