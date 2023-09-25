<?php

function writeToLog($message) {
    $logFile = 'logs/log.txt';

    $logMessage = date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;

    $fileHandle = fopen($logFile, 'a');

    fwrite($fileHandle, $logMessage);

    fclose($fileHandle);
}

?>
