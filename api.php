<?php
include ('WSIVMissionsNextRequest.php');
$line = "RB";
$station = "Lozere";
$direction = "A";
$proxyHost = null;
$proxyPort = null;

if(isset($_GET['line'])) {
    $line = $_GET['line'];
    $station = "";
    $direction = "*";
}
if(isset($_GET['station'])) {
    $station = $_GET['station'];
}
if(isset($_GET['direction'])) {
    $direction = $_GET['direction'];
}
$request = new WSIVMissionsNextRequest($line, $station, $direction, $proxyHost, $proxyPort);
header('Content-Type: application/json');
echo json_encode($request->getReturn());
 ?>
