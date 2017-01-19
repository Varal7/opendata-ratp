<?php
include ('WSIVMissionsNextRequest.php');
$request = new WSIVMissionsNextRequest("RB", "Lozere", "A");
header('Content-Type: application/json');
echo json_encode($request->getReturn());
 ?>
