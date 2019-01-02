<?php

function placecall($from, $to, $say = false, $account = false, $MaxRetries = 0, $RetryTime = 10, $WaitTime = 10) {
    global $defaultTrunk;
    if(!isset($defaultTrunk)) return 'No Trunk';

    $body  = "";
    $body .= "Channel: SIP/$trunk/$to\n";
    $body .= "CallerID: $from\n";
    $body .= $say ? "Application: Playback\nData: $say\n" : "Application: Hangup\n";
    $body .= "MaxRetries: $MaxRetries\n";
    $body .= "RetryTime: $RetryTime\n";
    $body .= "WaitTime: $WaitTime\n";
    if($account)
        $body .= "Account: $account\n";
    $body .= "Set: CDR(userfield)=$to\n";

    $filename = md5(uniqid(rand(), true)) .'.call';
    file_put_contents("/tmp/$filename", $body);
    rename("/tmp/$filename", "/var/spool/asterisk/outgoing/$filename");
}

function formatNumber($number) {
    if(substr($number, 0, 1) == 0 AND strlen($number) == 9 OR strlen($number) == 10)
        $number = '00972' . substr($number, 1);
    return $number;
}
