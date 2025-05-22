<?php
header('Content-Type: application/json');
$output = shell_exec('grp06.exe generer 2>&1');
echo $output;
?>