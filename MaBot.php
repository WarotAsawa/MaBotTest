<?php

require_once './vendor/autoload.php';

use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Event\MessageEvent\TextMessageBuilder;
use LINE\LINEBot\Event\MessageEvent\LocationMessage;
use LINE\LINEBot\Event\MessageEvent\ImageMessage;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
$logger = new Logger('LineBot');
$logger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
$access_token = 'tYLkTfUwWhH5WVunO5G0QhjUYgiAH4Bd0Bb+oFw0pfis0E0cibf6U73f7gdZid4cUcAURkLMr3D3qW3CfRbuFw3XubbKtHHY14ncqIhRpOwaB5c0BFol/ca78jdM5uCj+bDPDMfEA8bOT/cC0AAV8gdB04t89/1O/w1cDnyilFU=';
$channel_id = '1529179895';
$channel_secret = '29834a3e45690862a8876a576bac2172';
$userid = 'Ua9222d61b45ff88cc7315440f4f285f3';
$httpClient = new LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channel_secret]);

$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

$logger = new Logger('LineBot');
$logger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));

try {
    $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
	error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
	error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
	error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
	error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
}
foreach ($events as $event) {
  // Postback Event
  	if (($event instanceof \LINE\LINEBot\Event\PostbackEvent)) {
		$logger->info('Postback message has come');
		continue;
	}
	// Location Event
	if  ($event instanceof LINE\LINEBot\Event\MessageEvent\LocationMessage) {
		//$outputText = new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder("Why sent me your location. Huh!?", $event->getLatitude(), $event->getLongitude());
   		$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("How dare you sent me your location");
    	$response = $bot->replyText($event->getReplyToken(), $outputText);
		$logger->info("location -> ".$event->getLatitude().",".$event->getLongitude());
		continue;
	}

    if  ($event instanceof LINE\LINEBot\Event\MessageEvent\ImageMessage) {
		//$outputText = new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder("Why sent me your location. Huh!?", $event->getLatitude(), $event->getLongitude());
   		$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("How dare you sent me your image.");
    	$response = $bot->replyText($event->getReplyToken(), $outputText);
    	$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("Here is an image of a random sloth");
    	$response = $bot->replyText($event->getReplyToken(), $outputText);
		$img_url = "https://media.treehugger.com/assets/images/2016/07/sloth-3.jpg.662x0_q70_crop-scale.jpg";
		$outputText = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);
    	$response = $bot->replyText($event->getReplyToken(), $outputText);
		continue;
	}
  // Message Event = TextMessage
  
  	if (($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
		$messageText=strtolower(trim($event->getText())); 
		$outputText = $messageText;
		$response = $bot->replyText($event->getReplyToken(), $outputText);
		$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($messageText);
		$response = $bot->replyText($event->getReplyToken(), $outputText);
		$outputText = 'helo helo';
		$response = $bot->replyText($event->getReplyToken(), $outputText);
		/*
		if ($messageText== "text") {
			$messageText=strtolower(trim($event->getText()));
			$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("Na na na na na na Batman !!!!");
		}
		else if ($messageText== "location") {
			$outputText = new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder("Eiffel Tower", "Champ de Mars, 5 Avenue Anatole France, 75007 Paris, France", 48.858328, 2.294750);
		} else if ($messageText=="image") {
			$img_url = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRpF37MicznKpvrBvb0syRnKTnb1iEmhUOiEiSQHqHoUCayICQ9frR9Xg";
			$outputText = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);
		} else {
			$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("demo command: text, location, button, confirm to test message template");	
		}

		$response = $bot->replyText($event->getReplyToken(), $outputText);
		*/
	}
}  