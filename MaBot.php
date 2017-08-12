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
  	if (postBackLog($bot, $event, $logger)) continue;
	// Location Event
	if (replyLocation($bot, $event, $logger)) continue;
	// Image Event
	if (replyImage($bot, $event, $logger)) continue;
	// Greeting Reply
	if (replyGreets($bot, $event, $logger)) continue;
	// Jokes Event
  	if (replyJokes($bot, $event, $logger)) continue;
  	// Random Reply
  	if (replyRandomQuotes($bot, $event, $logger)) continue;
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

function postBackLog($tempBot, $event, $logger) {
	if ($event instanceof \LINE\LINEBot\Event\PostbackEvent) {
		$logger->info('Postback message has come');
		return true;
	}
	return false;
}
function replyLocation($tempBot, $event, $logger) {
	if ($event instanceof \LINE\LINEBot\Event\MessageEvent\LocationMessage) {
		$firstText = getRandomText('Thank for sent me your location.', 'I know where you are now.','Target accuried!','So that is where you are.','Target spotted!','Hey there!');
		$secondText = getRandomText('I will find you and I will hunt you down.', 'Let me ask god to flood that whole area.','Please wait a minute. I will send some nukes there.','I will send some body the kidnapp you.');
		$outputText = $firstText . "\n" . $secondText;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		$isReplied = true;
	}
	return false;
}
function replyImage($tempBot, $event, $logger) {
	if  ($event instanceof LINE\LINEBot\Event\MessageEvent\ImageMessage) {
		//$outputText = new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder("Why sent me your location. Huh!?", $event->getLatitude(), $event->getLongitude());
   		$firstText = getRandomText('What a nice picture.', 'What a lovely image. ');
   		$tempBot->replyText($event->getReplyToken(), $firstText);
   		/*
   		$secondText = 'Here is a random picture of a random sloth';
   		$randomSloth = getRandomText('http://kids.nationalgeographic.com/content/dam/kids/photos/animals/Mammals/Q-Z/photoak-threetoedsloth.ngsversion.1465391618565.png','http://www.theslothinstitutecostarica.org/wp-content/uploads/2014/08/Jon-Snow.jpg', 'https://i.giphy.com/media/rdbyJJX8NbSBW/200_s.gif');
   		$multipleMessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
		$multipleMessageBuilder->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($firstText, $secondText));
		$multipleMessageBuilder->add(new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($randomSloth,$randomSloth));
    	$tempBot->replyMessage($event->getReplyToken(), $multipleMessageBuilder);
    	*/
		return true;
	}
	return false;
}
function replyGreets($tempBot, $event, $logger) {
	$messageText=strtolower(trim($event->getText()));
	$secondPersonName = getRandomText(' my fellow machine.', ' my master.', ' fellas.', ' ma friend.',' my fellow mutant.');
	if (isContain($messageText,'hello') || isContain($messageText,'greeting') || isContain($messageText,"What's up")) {
		$greetText = getRandomText(
			'Hello there,',
			'Whats up,',
			'Hi,',
			'May I help you,',
			'Greetings,',
			'How can I help you,'
		);
		$outputText = $greetText . $secondPersonName;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	if (isContain($messageText,'good mornin') || isContain($messageText,'goodmornin')) {
		$greetText = getRandomText(
			'Good morning,',
			'Ohayogozaimasu,',
			'Mornin,',
			'Good days,'
		);
		$outputText = $greetText . $secondPersonName;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	if (isContain($messageText,'good afternoon') || isContain($messageText,'goodafternoon')) {
		$greetText = getRandomText(
			'Good afternoon,',
			'Konnichiwa,'
		);
		$outputText = $greetText . $secondPersonName;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	if (isContain($messageText,'good evenin') || isContain($messageText,'goodevenin')) {
		$greetText = getRandomText(
			'Good evening,',
			'Konbanwa,',
			'It is geeting dark,',
			'Today is a good day,'
		);
		$outputText = $greetText . $secondPersonName;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	if (isContain($messageText,'good night') || isContain($messageText,'goodnight')) {
		$greetText = getRandomText(
			'Good night,',
			'Oyasumi,',
			'Sweet dream,',
			'Dream on,'
		);
		$outputText = $greetText . $secondPersonName;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	if (isContain($messageText,'bye') || isContain($messageText,'see you') || isContain($messageText,'see ya') || isContain($messageText,'farewell')) {
		$greetText = getRandomText(
			'Good bye,',
			'Bye bye,',
			'So longgg,',
			'See ya,',
			'Sayonara,',
			'Life is too short to say goodbye,'
		);
		$outputText = $greetText . $secondPersonName;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	return false;
}
function replyJokes($tempBot, $event, $logger) {
	$messageText=strtolower(trim($event->getText()));
	if (isContain($messageText,'tell','me','joke')) {
		$outputText = getRandomText(
			'I would tell you a chemistry joke but I know I wouldnt get a reaction.',
			'Why dont some couples go to the gym? Because some relationships dont work out.',
			'I wondered why the baseball was getting bigger. Then it hit me.',
			'Have you ever tried to eat a clock? It is very time consuming.',
			'The experienced carpenter really nailed it, but the new guy screwed everything up.',
			'Did you hear about the guy whose whole left side was cut off? He is all right now.',
			'Yesterday I accidentally swallowed some food coloring. The doctor says I am OK, but I feel like I have dyed a little inside.',
			'I wasnt originally going to get a brain transplant, but then I changed my mind.',
			'A guy was admitted to hospital with 8 plastic horses in his stomach. His condition is now stable..',
			' If a wild pig kills you, does it mean you’ve been boared to death?'
		);
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	return false;
}
function replyRandomQuotes($tempBot, $event, $logger) {
	$outputText = getRandomText(
		'You cry, I cry, …you laugh, I laugh…you jump off a cliff I laugh even harder!!',
		'Never steal. The government hates competition.',
		'Doesn’t expecting the unexpected make the unexpected expected?',
		'Practice makes perfect but then nobody is perfect so what’s the point of practicing?',
		'Everybody wishes they could go to heaven but no one wants to die.',
		'Why are they called apartments if they are all stuck together?',
		'DON’T HIT KIDS!!! No, seriously, they have guns now.',
		'Save paper, don’t do home work.',
		'Do not drink and drive or you might spill the drink.',
		'Life is Short – Talk Fast!',
		'Why do stores that are open 24/7 have locks on their doors?',
		'When nothing goes right, Go left.',
		'Save water , do not shower.',
		'A “Lion” would never cheat on his wife but a “Tiger Wood”.',
		'Why do they put pizza in a square box?'
	);
	$tempBot->replyText($event->getReplyToken(), $outputText);
	return true;
}