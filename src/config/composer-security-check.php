<?php
return array(
    'mailSubjectSuccess' => env(
        'SECURITY_CHECK_SUBJECT_SUCCESS',
        '[composer-security-check]: Ok - no vulnerabilities detected.'
    ),
    'mailSubjetcAlarm' => env(
        'SECURITY_CHECK_SUBJECT_ALARM',
        '[composer-security-check]: Alarm - vulnerabilities detected.'
    ),
    'mailFrom' => env('SECURITY_CHECK_MESSAGE_FROM', 'info@example.com'),
    'mailFromName' => env('SECURITY_CHECK_MESSAGE_FROM_NAME', 'Info Example'),
    'mailViewName' => env('SECURITY_CHECK_MAIL_VIEW_NAME', 'composer-security-check::mail'),
    'logFilePath' => env('SECURITY_CHECK_LOG_FILE_PATH', storage_path().'/composersecurityCheck.log')
 );
