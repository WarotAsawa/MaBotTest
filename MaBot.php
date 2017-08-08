<?php

$access_token = 'tYLkTfUwWhH5WVunO5G0QhjUYgiAH4Bd0Bb+oFw0pfis0E0cibf6U73f7gdZid4cUcAURkLMr3D3qW3CfRbuFw3XubbKtHHY14ncqIhRpOwaB5c0BFol/ca78jdM5uCj+bDPDMfEA8bOT/cC0AAV8gdB04t89/1O/w1cDnyilFU='
$channel_id = '1529179895'
$channel_secret = '29834a3e45690862a8876a576bac2172'
$userid = 'Ua9222d61b45ff88cc7315440f4f285f3'
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channel_secret]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$response = $bot->replyMessage('nHuyWiB7yP5Zw52FIkcQobQuGDXCTA', $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

