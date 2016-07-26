<?php

function newline() {
	echo nl2br ("\n");
};

function logEvent($message) {
	global $logPath, $logType;

    if ($message != '') {
        // Add a timestamp to the start of the $message
        $message = gmDate(DATE_ATOM) . ': ' . $logType . ' ' . $message;
        // todo: move this logic to settings.php ? 
		$fp = fopen($logPath, 'a');
        fwrite($fp, $message."\n");
        fclose($fp);
        return "$message";
    }
}

?>