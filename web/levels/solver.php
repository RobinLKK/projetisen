<?php
header('Content-Type: application/json');

if (isset($_POST['niveau'])) {
    // Envoie le niveau via stdin au solver
    $niveau = $_POST['niveau'];
    $cmd = 'grp06.exe resoudre 2>&1';
    $descriptorspec = [
        0 => ["pipe", "r"], // stdin
        1 => ["pipe", "w"], // stdout
        2 => ["pipe", "w"]  // stderr
    ];
    $process = proc_open($cmd, $descriptorspec, $pipes);
    if (is_resource($process)) {
        fwrite($pipes[0], $niveau);
        fclose($pipes[0]);
        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        $err = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        proc_close($process);
        echo $output ?: json_encode(['error' => $err ?: 'Erreur inconnue']);
    } else {
        echo json_encode(['error' => 'Impossible de lancer le solveur']);
    }
} else {
    echo json_encode(['error' => 'Aucun niveau fourni']);
}
?>