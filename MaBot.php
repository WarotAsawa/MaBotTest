<?php
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;

$access_token = 'tYLkTfUwWhH5WVunO5G0QhjUYgiAH4Bd0Bb+oFw0pfis0E0cibf6U73f7gdZid4cUcAURkLMr3D3qW3CfRbuFw3XubbKtHHY14ncqIhRpOwaB5c0BFol/ca78jdM5uCj+bDPDMfEA8bOT/cC0AAV8gdB04t89/1O/w1cDnyilFU=';
$channel_id = '1529179895';
$channel_secret = '29834a3e45690862a8876a576bac2172';
$userid = 'Ua9222d61b45ff88cc7315440f4f285f3';
$httpClient = new LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channel_secret]);

$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

try {
    $events = $bot->parseEventRequest($req->getBody(), $signature[0]);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  echo 'parseEventRequest failed. InvalidSignatureException';
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  echo 'parseEventRequest failed. UnknownEventTypeException';
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  echo 'parseEventRequest failed. UnknownMessageTypeException' ;
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  echo 'parseEventRequest failed. InvalidEventRequestException';
}
foreach ($events as $event) {
  // Postback Event
  if (($event instanceof \LINE\LINEBot\Event\PostbackEvent)) {
    continue;
  }
  // Location Event
  if  ($event instanceof \LINE\LINEBot\Event\MessageEvent\LocationMessage) {
    //$outputText = new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder("Why sent me your location. Huh!?", $event->getLatitude(), $event->getLongitude());
    $outputText = $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("How dare you sent me your location");
    $response = $bot->replyText($event->getReplyToken(), $outputText);
    continue;
  }
  
  // Message Event = TextMessage
  
  if (($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
		$messageText=strtolower(trim($event->getText()));
		switch ($messageText) {
		case "text" : 
			$messageText=strtolower(trim($event->getText()));
			$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("Na na na na na na Batman !!!!");
			break;
		case "location" :
			$outputText = new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder("Eiffel Tower", "Champ de Mars, 5 Avenue Anatole France, 75007 Paris, France", 48.858328, 2.294750);
			break;
		case "image" :
			$img_url = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRpF37MicznKpvrBvb0syRnKTnb1iEmhUOiEiSQHqHoUCayICQ9frR9Xg";
			$outputText = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);
			break;	
		default :
			$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("demo command: text, location, button, confirm to test message template");	
			break;
		}

		$response = $bot->replyText($event->getReplyToken(), $outputText);
	}
}  