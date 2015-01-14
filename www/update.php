<?php

require_once('inc.php'); 

if (!isset($_POST['k']) || !isset($_POST['v']) ||
    !isset($GLOBALS['keys'][$_POST['k']])) {
  exit;
}

$data = load_csv();
$data[$_POST['k']] = array('uri' => $_POST['v'], 'timestamp' => date('r'));
save_csv($data);

?>
