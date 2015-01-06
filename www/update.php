<?php

require_once('inc.php'); 

if (!isset($_POST['k']) || !isset($_POST['v']) ||
    !array_key_exists($_POST['k'], $GLOBALS['keys'])) {
  exit;
}

$data = load_csv();
$alias = $GLOBALS['keys'][$_POST['k']];
$data[$alias] = array('uri' => $_POST['v'], 'timestamp' => date('r'));
save_csv($data);

?>
