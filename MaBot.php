<?php

$access_token = 'tYLkTfUwWhH5WVunO5G0QhjUYgiAH4Bd0Bb+oFw0pfis0E0cibf6U73f7gdZid4cUcAURkLMr3D3qW3CfRbuFw3XubbKtHHY14ncqIhRpOwaB5c0BFol/ca78jdM5uCj+bDPDMfEA8bOT/cC0AAV8gdB04t89/1O/w1cDnyilFU=';
$channel_id = '1529179895';
$channel_secret = '29834a3e45690862a8876a576bac2172';
$userid = 'Ua9222d61b45ff88cc7315440f4f285f3';
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channel_secret]);

try {
	$events = $bot->parseEventRequest($req->getBody(), $signature[0]);
} 
foreach ($events as $event) {
	if (!($event instanceof MessageEvent)) {
	    $logger->info('Non message event has come');
	    continue;
	}
	if (!($event instanceof TextMessage)) {
	    $logger->info('Non text message has come');
	    continue;
	}
	$replyText = $event->getText();
	$logger->info('Reply text: ' . $replyText);
	$resp = $bot->replyText($event->getReplyToken(), $replyText);
	$logger->info($resp->getHTTPStatus() . ': ' . $resp->getRawBody());
}	


