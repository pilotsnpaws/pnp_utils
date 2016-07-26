<?php

$environment = 'dev' ;
$configPath  = 'ca_dev/local_config.php' ;
$logPath	= '/dev/null' ; 
// $sgApiKey = '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'; // production key
$sgApiKey = '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';
$sendMailFlag = false;  // send mail for real?
$sendMailRecipients = false; // send mail to real recipients (true) or just to Mike (false)
$notificationEmailSendGridCategory = 'local test'; // category for sendgrid tracking
$sendHoursBack = '60'; // this is how many hours back the send notification will pull topics. it is a safe guard in case the logsend fails

?>
