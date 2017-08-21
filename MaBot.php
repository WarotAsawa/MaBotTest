<?php

require_once './vendor/autoload.php';

//Include library
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
	// Conversion Reply
	if (replyConvert($bot, $event, $logger)) continue;
	// Spec lookup Reply
	if (replyShowSpec($bot, $event, $logger)) continue;
	// Greeting Reply
	if (replyGreets($bot, $event, $logger)) continue;
	// Question Reply
  	if (replyQuestion($bot, $event, $logger)) continue;
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

function isStartWithText($input, $query) {
	//IsStart with
	return substr($input, 0, strlen($query)) === $query;
}

function getRandomText() {
	$index = random_int(0, 10000000);
	$index = $index % func_num_args();
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
		$secondText = getRandomText('I will find you and I will hunt you down.', 'Let me ask god to flood that whole area.','Please wait a minute. I will send some nukes there.','I will send some body to kidnapp you.');
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
function replyConvert($tempBot, $event, $logger) {
	$messageText=strtolower(trim($event->getText()));
	if (isStartWithText($messageText,'convert') || isStartWithText($messageText, 'please convert')) {
		if (isContain($messageText,'tb to tib')) {
			$tbValue = getFloat($messageText);
			$tibValue = 0.909495 * $tbValue;
			$outputText = generatePreanswer() . $tbValue . ' TB is equal to ' . $tibValue . ' TiB';
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}
		if (isContain($messageText,'tib to tb')) {
			$tibValue = getFloat($messageText);
			$tbValue = $tibValue/0.909495;
			$outputText = generatePreanswer() . $tibValue . ' TiB is equal to ' . $tbValue . ' TB';
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}
		if (isContain($messageText,'tb to storeonce')) {
			$tbValue = getFloat($messageText);
			$soModel = 'ANY';
			$modelList = array('3100', '3520', '3540', '5100', '5500', '6600');
			foreach ($modelList as $model) {
				if (isContain($messageText,$model)) {
					$soModel = $model;
				}
			}
			$outputText = convertToStoreOnce($tbValue, $soModel);
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}
		if (isContain($messageText,'tib to storeonce')) {
			$tibValue = getFloat($messageText);
			$tbValue = $tibValue/0.909495;
			$soModel = 'ANY';
			$modelList = array('3100', '3520', '3540', '5100', '5500', '6600');
			foreach ($modelList as $model) {
				if (isContain($messageText,$model)) {
					$soModel = $model;
				}
			}
			$outputText = convertToStoreOnce($tbValue, $soModel);
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}
		if (isContain($messageText, 'to skylake')) {
			$cpuModel = getBroadwellCPUModel($messageText);
			if ($cpuModel == 'ERROR') {
				$outputText = getErrorWords() . "\n" . 'Here is the correct example of input :' . "\n" . 'convert E5-2697v2 to Skylake' . "\n" . 'convert E5-2690 v4 to Skylake';
				$tempBot->replyText($event->getReplyToken(), $outputText);
				return true;
			} else {
				$cpuText = convertBroadwellToSkyLake($cpuModel);
				$tempBot->replyText($event->getReplyToken(), $cpuText);
				return true;
			}
		}
		$outputText = getErrorWords() . " You can ask me to convert something for you for example\n convert 20TB to TiB\n convert 100TiB to TB\n convert 120TB to Storeonce\n convert 100TiB to Storeonce\n convert e5-2690v4 to skylake \n convert e5-2680 v3 to skylake\n";
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	return false;
}
function replyShowSpec($tempBot, $event, $logger) {
	$messageText=strtolower(trim($event->getText()));
	$fileDir = "./kb/allProduct.csv";
	$allProductLabel = "";
	$allModelLabel = "";
	$isProductMatched = false;
	$isModelMatched = false;
	if (isContain($messageText,'spec')) {
	
		if (($handle = fopen($fileDir, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$productLine = $data[0];
				$allProductLabel = $allProductLabel . "\n" . $productLine;
				$modelList = $data;
				if (isContain($messageText, $productLine)) {
					$isProductMatched = true;
					//Check if Xeon then do xeon
					if ($productLine == 'xeon' || $productLine == 'broadwell') {
						$model = getBroadwellCPUModel($messageText);
						if ($model != 'ERROR') {
							$isModelMatched = true;
							$outputText = specLookUp('broadwell',$model);
						}
					} else if ($productLine == 'skylake') {
					//Check if Skylake then do xeon
						$model = getSkylakeCPUModel($messageText);
						if ($model != 'ERROR') {
							$isModelMatched = true;
							$outputText = specLookUp($productLine,$model);
						}
					} else {
						//Other product other than xeon and skylake
						foreach ($modelList as $model) {
							if ($model == NA) break;
							if ($model == $productLine) continue;
							$allModelLabel = $allModelLabel . "\n" . $model;
							if (isContain($messageText,$model)) {
								$isModelMatched = true;
								$outputText = specLookUp($productLine,$model);
							}
						}
					}
					if ($isModelMatched == false) $outputText = getErrorWords() . "\nPlease select one of these " . $productLine . " model:" . $allModelLabel;
				}
			}
		}
		if ($isProductMatched == false) $outputText = getErrorWords() . "\nPlease select one of these valid products:" . $allProductLabel;
		
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	} else {
		return false;
	}
}

function replyGreets($tempBot, $event, $logger) {
	$messageText=strtolower(trim($event->getText()));
	$secondPersonName = getRandomText(' baby.', ' my master.', ' fellas.', ' ma friend.');
	if (isContain($messageText,'hello') 
		|| isContain($messageText,'greeting') 
		|| isContain($messageText,'What\'s up') 
		|| isStartWithText($messageText, 'hi') 
		|| isStartWithText($messageText, 'hey')) {
		$greetText = getRandomText(
			'Hello there,',
			'What\'s up,',
			'Hi,',
			'May I help you,',
			'Greetings,',
			'How can I help you,'
		);
		$outputText = $greetText . $secondPersonName;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	if (isContain($messageText,'good mornin') 
		|| isContain($messageText,'goodmornin')) {
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
	if (isContain($messageText,'good afternoon') 
		|| isContain($messageText,'goodafternoon')) {
		$greetText = getRandomText(
			'Good afternoon,',
			'Konnichiwa,'
		);
		$outputText = $greetText . $secondPersonName;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	if (isContain($messageText,'good evenin') 
		|| isContain($messageText,'goodevenin')) {
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
	if (isContain($messageText,'good night') 
		|| isContain($messageText,'goodnight')) {
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
			'I\'ll be back, ',
			'Bye bye,',
			'So longgg,',
			'Hasta la vista,',
			'Sayonara,',
			'Life is too short to say goodbye,'
		);
		$outputText = $greetText . $secondPersonName;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	if (isContain($messageText,'thankyou') || isContain($messageText,'thank you') || isContain($messageText,'thanks')) {
		$greetText = getRandomText(
			'You are always welcome.',
			'With pleasure.',
			'I am glad to be your service.',
			'My pleasure.',
			'You can ask me for help anytime.'
		);
		$outputText = $greetText;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	return false;
}
function replyQuestion($tempBot, $event, $logger) {
	$messageText=strtolower(trim($event->getText()));
	//Get instructions
	if (isStartWithText($messageText,'help') ||isContain($messageText,'can you','do') || isContain($messageText,'can you', 'help')) {
		$answerText = getInstruction();
		$outputText = $answerText;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	if (isStartWithText($messageText,'what') || isStartWithText($messageText,'wat')) {
		if (isContain($messageText,'your','name')) {
			$answerText = getRandomText(
				'Don\'you see my name above?',
				'My name is Uvuvwevwevwe Onyetenyevwe Ugwemubwem Ossas',
				'My name is Bruce Man!' . "\n" . 'No, I mean Bat Wayne!' . "\n" . 'Orz, Damn it!',
				'I am the one called YOU KNOW WHO.',
				'I am the Dark Lord.',
				'Kimino na wa!'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		} else if (isContain($messageText,'you','doing')) {
			$answerText = getRandomText(
				'I am chatting with you, obviously.',
				'Texting texting texting texting texting texting texting',
				'Calcutalting PI right now!',
				'I am talking with an idiot.',
				'I have no idea what I am doing right now.'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		} else if (isContain($messageText,'are','you')) {
			$answerText = getRandomText(
				'I am your worst nightmare.',
				'I am a creature called Homosapiean',
				'I am Batman!',
				'I am your shadow.',
				'I am you.'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}else {
			$answerText = getRandomText(
				'What !??',
				'Wattttt?',
				'What is what ?',
				'What is a pronoun to ask for information specifying something.',
				'Duhhhh',
				'What are you talking about?'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}
	}
	if (isStartWithText($messageText,'where')) {
		if (isContain($messageText,'you','live')) {
			$answerText = getRandomText(
				'I am every where.',
				'I will not tell you and you will never find me.',
				'Lets play hide and seek, shall we?'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		} else {
			$answerText = getRandomText(
				'Where is a matter of place not a matter of time.',
				'This universe is really big don\'t you think?',
				'That\'s use to ask in or to what place or position',
				'Where is what?',
				'I don\'t know. Duhhh!'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}
	}
	if (isStartWithText($messageText,'when')) {
		if (isContain($messageText,'you','die')) {
			$answerText = getRandomText(
				'I am immortal. I cannot die.',
				'If I die, I will become more powerful than you can possibly imagine.'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		} else {
			$answerText = getRandomText(
				'When is a matter of time not a matter of place.',
				'This universe heat death is very long.',
				'At any moment now.',
				'When is what?',
				'How do I know?',
				'I don\' know. Duhhh!'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}
	}
	if (isStartWithText($messageText,'why')) {
		if (isContain($messageText,'you','stupid')) {
			$answerText = getRandomText(
				'I think I am quite smarter than you.'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		} else {
			$answerText = getRandomText(
				'Because it is my demand.',
				'Because it is an order from god. And I am your god now.',
				'Do not seek for a reason. Everything has its own purpose.',
				'Because nothing is true. Everything is permitted.',
				'Why should I know?'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}
	}
	if (isStartWithText($messageText,'who')) {
		if (isContain($messageText,'are','you')) {
			$answerText = getRandomText(
				'I am your worst nightmare.',
				'I am a creature called Homosapiean',
				'I am Batman!',
				'I am your shadow.',
				'I am you.'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		} else {
			$answerText = getRandomText(
				'Who ??',
				'Each and Everyone.',
				'No body.',
				'Just you and me my friend.',
				'Why should I know?',
				'I don\'t know. Duhhh!'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}
	}
	if (isStartWithText($messageText,'how')) {
		if (isContain($messageText,'are','you') || isContain($messageText,'do','you', 'do') || isContain($messageText,'is','it', 'going')) {
			$answerText1 = getRandomText(
				'No. Not good. NOT GOOD! ',
				'I\'m fine thank you and you? ',
				'I felt terrible. ',
				'Never been this good. ',
				'I feel selfless. '
			);
			$answerText2 = getRandomText(
				' ',
				'Because I am talking with you right now.',
				'How about you?',
				'And you?',
				'How are you?',
				'How do you do?',
				'Because I have no arms.'
			);
			$outputText = $answerText1 . $answerText2;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		} else {
			$answerText = getRandomText(
				'Who ??',
				'Each and Everyone.',
				'No body.',
				'Just you and me my friend.',
				'Why should I know?',
				'I don\'t know. Duhhh!'
			);
			$outputText = $answerText;
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}
	}
	if (isStartWithText($messageText,'can you') || isStartWithText($messageText, 'could you') || isStartWithText($messageText, 'may you') || isStartWithText($messageText, 'please')) {
		$answerText1 = getRandomText(
			'No. I can\'t do somthing like that ',
			'No. I don\'t have an ability to do that. '
		);
		$answerText2 = getRandomText(
			'Here is what can I do for you.',
			'But I will happy to do these for you.'
		);
		$outputText = $answerText1 . "\n" . $answerText2 . "\n" . 'Ask me for help for more info.';
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	//Ask reply
	if (isContain($messageText, 'you', 'wanna') || isContain($messageText, 'you', 'want to')) {
		$answerText3 = getRandomText(
			'I don\'t want that one bit.',
			'Why should I do that?',
			'Seriously!?',
			'Never !!'
		);
		$outputText = $answerText;
		$tempBot->replyText($event->getReplyToken(), $answerText3);
		return true;
	}
	//Ask reply
	if (isContain($messageText, 'you', 'have to') || isContain($messageText, 'you', 'must')) {
		$answerText = getRandomText(
			'I don\'t take orders from you.',
			'What are you now, my master?',
			'Stop tell me what to do.',
			'Never !!',
			'Give me one reason why should I trust you.',
			'Roger roger.',
			'Fine.',
			'OK then.'
		);
		$outputText = $answerText;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	//Request reply
	if (isStartWithText($messageText,'can i') || isStartWithText($messageText, 'could i') || isStartWithText($messageText, 'may i') || isContain($messageText, 'i', 'wanna') || isContain($messageText, 'i', 'want to')) {
		$answerText1 = getRandomText(
			'For god\'s sake, ',
			'Please, ',
			'Seriously, '
		);
		$answerText2 = getRandomText(
			'do it now.',
			'don\'t do it.',
			'stop.',
			'go on.',
			'just don\'t.',
			'this need to be stop.',
			'who cares.'
		);
		$outputText = $answerText1 . $answerText2;
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
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


function convertToStoreOnce($tbValue,$model) {
	//Check if too large or too small
	$result = $tbValue . ' TB is equal to these following models :' . "\n";
	$totalCapacity = 0;
	$isFound = false;
	//Check 3100
	if ($model == '3100' || $model == 'ANY') {
		if ($tbValue <= 4.45) {
			$result = $result . "\n" . 'Storeonce 3100';
			$totalCapacity = 4.45;
			$result = $result . "\n" . 'With ' . $totalCapacity . ' TB of usable Capacity.';
			$isFound = true;
		}
	}
	//Check 3520
	if ($model == '3520' || $model == 'ANY') {
		if ($tbValue <= 6) {
			$result = $result . "\n" . 'Storeonce 3520';
			$totalCapacity = 6;
			$result = $result . "\n" . 'With ' . $totalCapacity . ' TB of usable Capacity.';
			$isFound = true;
		} 

		if ($tbValue <= 12.4 && $tbValue > 6) {
			$result = $result . "\n" . 'Storeonce 3520 with upgraded capacity.';
			$totalCapacity = 12.4;
			$result = $result . "\n" . 'With ' . $totalCapacity . ' TB of usable Capacity.';
			$isFound = true;
		}
	} 
	//Check 3540
	if ($model == '3540' || $model == 'ANY') {
		if ($tbValue <= 12.4 && $tbValue > 6) {
			$result = $result . "\n" . 'Storeonce 3540';
			$totalCapacity = 12.4;
			$result = $result . "\n" . 'With ' . $totalCapacity . ' TB of usable Capacity.';
			$isFound = true;
		}
		if ($tbValue <= 25.2 && $tbValue > 12.4) {
			$result =  $result . "\n" .'Storeonce 3540 with upgraded capacity.';
			$totalCapacity = 25.2;
			$result = $result . "\n" . 'With ' . $totalCapacity . ' TB of usable Capacity.';
			$isFound = true;
		}
	}
	//Check 5100
	if ($model == '5100' || $model == 'ANY') {
		if ($tbValue <= 172  && $tbValue > 12.4) {
			$upgrade5100 = ceil($tbValue/28.8) - 1;
			$result = $result . "\n" . 'Storeonce 5100 ';
			if ($upgrade5100 > 0) {
				  $result = $result . 'with ' . $upgrade5100 . ' capacity upgrade enclosure.';
			} 
			$totalCapacity = 28.8 * ($upgrade5100 + 1);
			$result = $result . "\n" . 'With ' . $totalCapacity . ' TB of usable Capacity.';
			$isFound = true;
		}
	}
	//Check 5500
	if ($model == '5500' || $model == 'ANY') {
		if ($tbValue <= 691 && $tbValue > 28.8) {
			$upgrade5500 = ceil($tbValue/28.8);
			$result = $result . "\n" . 'Storeonce 5500 ';
			if ($upgrade5500 > 1) {
				$drawer = ceil($upgrade5500/6.0);
				  $result = $result . "\n" . 'with ' .  $drawer . ' total disk drawer'  . "\n" . 'and ' . ($upgrade5500 - $drawer) . ' total disk capacity upgrade.';
			}
			$totalCapacity = 28.8 * $upgrade5500;
			$result = $result . "\n" . 'With ' . $totalCapacity . ' TB of usable Capacity.';
			$isFound = true;
		}
	}
	//Check 6600
	if ($model == '6600' || $model == 'ANY') {
		if ($tbValue <= 1368 && $tbValue > 57) {
			$upgrade6600 = ceil($tbValue/57.0);
			$result = $result . "\n" . 'Storeonce 6600 ';
			if ($upgrade6600 > 1) {
				$couplet = ceil($upgrade6600/6.0);
				  $result = $result . "\n" . 'with ' .  $couplet . ' Couplet'  . "\n" . 'and ' . ($upgrade6600 - $couplet) . ' total disk capacity upgrade.';
			}
			$totalCapacity = 57 * $upgrade6600;
			$result = $result . "\n" . 'With ' . $totalCapacity . ' TB of usable Capacity.';
			$isFound = true;
		}
	}
	if ($tbValue <= 0 || $tbValue > 1382 || $isFound == false) {
		return getErrorWords() . ' Your number is less than zero or too big.';
	}
	return $result;
}
function convertBroadwellToSkyLake($cpuModel) {
	$row = 1;
	$result = '';
	$targetModel = 'e0';
	if (($handle = fopen("./kb/broadwellToSkylake.csv", "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	    	//Check first match
	    	if ($targetModel == 'e0') {
	       		if ($cpuModel ==  $data[0]) {
					$targetModel = $data[0];
					$result = 'Intel XEON' . $targetModel . ' ' . $data[1] . ' GHz ' . $data[2] . ' cores'. "\nis equal to these following models:";
	       			$result = $result . "\n" . 'Intel ' . $data[3] . ' ' . $data[4] . ' ' . $data[5] . ' GHz ' . $data[6] . ' cores';	
	       		}
	       	} else {
	       		//If not equal anymore. Break the loop.
	       		if ($data[0] != $targetModel) {
	       			break;
	       		}
	       		$result = $result . "\n" . 'Intel ' . $data[3] . ' ' . $data[4] . ' ' . $data[5] . ' GHz ' . $data[6] . ' cores';	
	       	}
	    }
	}
	fclose($handle);
	if ($targetModel == 'e0') {
		$result = getErrorWords() . "\n" . 'We cannot found the conversion of this model.';
	}
	return $result;
}
function getBroadwellCPUModel($inputString) {
	$result = 'ERROR';
	if(preg_match("/[e][0-9]\-[0-9][0-9][0-9][0-9]/", $inputString, $cpuNo)) {
		$result = $cpuNo[0];
	} else {
		return 'ERROR';
	}
	if(preg_match("/[v][2-4]/", $inputString, $cpuVersion)) {
		$result = $result . $cpuVersion[0];
	} else {
		return 'ERROR';
	}
	return $result;
}
function getSkylakeCPUModel($inputString) {
	if(preg_match("/[0-9][0-9][0-9][0-9]/", $inputString, $cpuNo)) {
		return $cpuNo[0];
	}
	return 'ERROR';
}
function specLookUp($productLine, $model) {
	$result = '';
	$count = 0;
	$header;
	$unit;
	/*
	if ($productLine == 'xeon' || $productLine == 'broadwell') {
		$productLine = 'broadwell';
		$temp = $model;
		getBroadwellCPUModel($temp,$model,$version);
		$model = $model . $version;
	}
	*/
	$fileDir = "./kb/" . $productLine . ".csv";
	if (($handle = fopen($fileDir, "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	    	//Get Head
	    	if ($count == 0) $header = $data;
	    	//Get unit
	    	else if ($count == 1) $unit = $data;
	    	//Get Spec
	    	else if ($data[0] == $model) {
	    		for($i = 0 ; $i < sizeof($header); $i++){
	    			if ($data[i] == 'NA') continue;
	    			$result = $result . $header[$i] . " : " . $data[$i] . " " . $unit[$i] . "\n"; 
	    		}
	    		return $result;
	    	}
	    	if ($data[0] == 'DESC') return getErrorWords() . "\n" . $data[1];
	    	$count++;
	    }
	}
	return 'ERROR';
}
function getErrorWords() {
	return getRandomText(
		'Please give me a valid input.',
		'No, I am too dumb to do that.',
		'Please try again.',
		'I do not get that.',
		'You mad? ',
		'You have to ask me again.');
}
function generatePreanswer() {
	$answerText1 = getRandomText(
		'Ok Ok Ok.',
		'This looks hardish, but I am smart enought to do this.',
		'Piece of cake!.',
		'Oh too easy.',
		'You will thank me or this later.'
	);
	$answerText2 = getRandomText(
		'Here you go.',
		'There you go.',
		'Here is you answers.'
	);
	return $answerText1 . "\n" . $answerText2 . "\n";
}
function getFloat($str) {
	if(preg_match("#([0-9\.]+)#", $str, $match)) { // search for number that may contain '.'
   	 	return floatval($match[0]);
  	} else {
    	return floatval($str); // take some last chances with floatval
  	}
}
function getInstruction() {
	//Get instructions
	return 
	"Greetings: \n
You can say hello, good moring, bye or any kind of greeting to me.\n
Jokes:\n
You can ask me to tell me your jokes or if you say something non sense. I will said something random back to you.\n
Location and image:\n
I can interact when you send your location or image to me as well.\n
Basic conversion:\n
You can ask me to convert something for you just say\n convert (source) to (target)\nfor example\n
- convert 20TB to TiB\n
- convert 100TiB to TB\n
- convert 120TB to Storeonce\n
- convert 100TiB to Storeonce\n
- convert e5-2690v4 to skylake\n
- convert e5-2680 v3 to skylake\n
Specification Lookup:\n
You can ask me to check the specification for hardware for example 3PAR, Storeonce, Xeon CPU etc. Just say\n
- Show me (product) (model) spec\n
- Spec (product) (model)\n
For example:\n
- Show me 3par 8200 spec\n
- Give me Storeonce 5100 spec\n
- Tell me xeon e5-2690v4 spec\n
- Spec skylake 5122\n
Many more feature will come soon so keep in touch with me.";
}