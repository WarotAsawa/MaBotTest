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

//Check if bot has already reply or not

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
	$alreadyReplied = false;
  	// Postback Event
  	postBackLog();
	// Location Event
	$alreadyReplied = replyLocation($bot, $alreadyReplied);

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
		if (isContain($messageText,'hello','world')) {
			$outputText = getRandomText('Good day ma master', 'Say hello to the world', 'I fell so tired. I am going back to sleep');
		}
		
		$response = $bot->replyText($event->getReplyToken(), $outputText);

		$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($messageText);
		$response = $bot->replyText($event->getReplyToken(), $outputText);
		$outputText = 'helo helo';
		$response = $bot->replyText($event->getReplyToken(), $outputText);
	}
}  

function isContain($input) {
    for ($i = 1; $i < func_num_args(); $i++) {
    	if (strpos(func_get_arg(0), func_get_arg($i)) === false) {
    		return false;
    	} 
    }
    return true;
}

function getRandomText() {
	$index = rand(0, func_num_args()-1);
	return func_get_arg($index);
}

function postBackLog() {
	if ($event instanceof \LINE\LINEBot\Event\PostbackEvent) {
		$logger->info('Postback message has come');
		continue;
	}
}
function replyLocation($tempBot, $isReplied) {
	if ($isReplied) return $isReplied;
	if ($event instanceof \LINE\LINEBot\Event\MessageEvent\LocationMessage) {
		$outputText = 'Thank for sent me your location.\n I will find you and I will hunt you down.';
		$tempBot->replyText($event->getReplyToken(), $outputText);
		$isReplied = true;
	}
	return $isReplied;
}