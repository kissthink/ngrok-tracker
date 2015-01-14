<?php

require_once('config.php'); 

date_default_timezone_set($GLOBALS['timezone']);

// index helpers

function auth() {
  if (!isset($_SERVER['PHP_AUTH_USER']) || 
      $_SERVER['PHP_AUTH_USER'] != $GLOBALS['username'] ||
      !isset($_SERVER['PHP_AUTH_PW']) || 
      $_SERVER['PHP_AUTH_PW'] != $GLOBALS['password']) {
    header('WWW-Authenticate: Basic realm="Ngrok Tracker"');
    header('HTTP/1.0 401 Unauthorized');
    exit;
  }
}

function render() {
  $data = load_csv();
  if (!$data || count($data) < 1) {
    return;
  }
  ksort($data, SORT_STRING);
  foreach ($data as $key => $attrs) {
    echo "<tr>";
    echo "<td>" . $GLOBALS['keys'][$key] . "</td>";
    echo "<td>" . $attrs['uri'] . "</td>";
    echo "<td>" . $attrs['timestamp'] . "</td>";
    echo "</tr>";
  }
}

// csv helpers

function load_csv() {
  $file = fopen($GLOBALS['csv'], 'r');
  if (!$file) {
    return;
  }
  $data = array();
  while(!feof($file)) {
    $line = fgetcsv($file);
    if (count($line) == 3 && isset($GLOBALS['keys'][$line[0]])) {
      $data[$line[0]] = array('uri' => $line[1],
                              'timestamp' => $line[2]);
    }
  }
  fclose($file);
  return $data;
}

function save_csv($data) {
  $file = fopen($GLOBALS['csv'], 'w');
  if (!$file) {
    return;
  }
  foreach ($data as $key => $attrs) {
    fputcsv($file, array($key, $attrs['uri'], $attrs['timestamp']));
  }
  fclose($file);
}

?>
