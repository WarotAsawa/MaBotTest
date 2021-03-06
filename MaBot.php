<?php

require_once './vendor/autoload.php';
require_once './AllResponse.php';
require_once './AllCriteria.php';
require_once './Calculator.php';

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

$allResponse = new AllResponse();
$allCriteria = new AllCriteria();

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
  	// Sticker Event
	if (replySticker($bot, $event, $logger)) continue;
	// Location Event
	if (replyLocation($bot, $event, $logger)) continue;
	// Image Event
	if (replyImage($bot, $event, $logger)) continue;
	// Conversion Reply
	if (replyConvert($bot, $event, $logger)) continue;
	// Spec lookup Reply
	if (replyShowSpec($bot, $event, $logger)) continue;
	// Calulation Reply
	if (replyCalculator($bot, $event, $logger)) continue;
	// Sizing Reply
	if (replySize($bot, $event, $logger)) continue;
	// Lookup Reply
	if (replyLookup($bot, $event, $logger)) continue;
	// Greeting Reply
	if (replySpeech($bot, $event, $logger,$allResponse,$allCriteria)) continue;
  	// Random Reply
  	//if (replyRandomQuotes($bot, $event, $logger)) continue;
}  

function isContain($input) {
    for ($i = 1; $i < func_num_args(); $i++) {
    	if (strpos(func_get_arg(0), func_get_arg($i)) === false) {
    		return false;
    	} 
    }
    return true;
}
function isContainFromArray($input, $array) {
    foreach ($array as $text) {
    	if (strpos($input, $text) === false) {
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
function getRandomTextFromArray($array) {
	$index = random_int(0, 10000000);
	$index = $index % sizeof($array);
	return $array[$index];
}
function postBackLog($tempBot, $event, $logger) {
	if ($event instanceof \LINE\LINEBot\Event\PostbackEvent) {
		$logger->info('Postback message has come');
		return true;
	}
	return false;
}
function replySticker($tempBot, $event, $logger) {
	if ($event instanceof \LINE\LINEBot\Event\MessageEvent\StickerMessage) {
		$outputText =getRandomText("I can't send Sticker. I don't have arms", 
			"Sticker is for kids. Emoji is for adults. Text is for legends.",
			"Why do you send me your sticker? I hate sticker.",
			"How dare you? The sticker is my eternal foes!");

		$tempBot->replyText($event->getReplyToken(), $outputText);
		$isReplied = true;
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
	if (isContain($messageText,'help')) return false;
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
		if (isContain($messageText,'gb to gib')) {
			$tbValue = getFloat($messageText);
			$tibValue = 0.931323 * $tbValue;
			$outputText = generatePreanswer() . $tbValue . ' GB is equal to ' . $tibValue . ' GiB';
			$tempBot->replyText($event->getReplyToken(), $outputText);
			return true;
		}
		if (isContain($messageText,'gib to gb')) {
			$tibValue = getFloat($messageText);
			$tbValue = $tibValue/0.931323;
			$outputText = generatePreanswer() . $tibValue . ' GiB is equal to ' . $tbValue . ' GB';
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
				$outputText = generateErrorWords() . "\n" . 'Here is the correct example of input :' . "\n" . 'convert E5-2697v2 to Skylake' . "\n" . 'convert E5-2690 v4 to Skylake';
				$tempBot->replyText($event->getReplyToken(), $outputText);
				return true;
			} else {
				$cpuText = convertBroadwellToSkyLake($cpuModel);
				$tempBot->replyText($event->getReplyToken(), $cpuText);
				return true;
			}
		}
		if (isContain($messageText, 'to xeon') || isContain($messageText, 'to broadwell')) {
			$cpuModel = getSkylakeCPUModel($messageText);
			if ($cpuModel == 'ERROR') {
				$outputText = generateErrorWords() . "\n" . 'Here is the correct example of input :' . "\n" . 'convert 5118 to xeon' . "\n" . 'convert 4110 to broadwell';
				$tempBot->replyText($event->getReplyToken(), $outputText);
				return true;
			} else {
				$cpuText = convertSkylakeToBroadwell($cpuModel);
				$tempBot->replyText($event->getReplyToken(), $cpuText);
				return true;
			}
		}
		$outputText = generateErrorWords() . " You can ask me to convert something for you for example\n convert 20TB to TiB\n convert 100TiB to TB\n convert 120TB to Storeonce\n convert 100TiB to Storeonce\n convert e5-2690v4 to skylake \n convert e5-2680 v3 to skylake\n";
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	}
	return false;
}
function replyShowSpec($tempBot, $event, $logger) {
	$messageText=strtolower(trim($event->getText()));
	if (isContain($messageText,'help')) return false;
	$fileDir = "./kb/allProduct.csv";
	$allProductLabel = "";
	$allModelLabel = "";
	$isProductMatched = false;
	$isModelMatched = false;
	if (isContain($messageText,'spec')) {
	
		if (($handle = fopen($fileDir, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$productLine = $data[0];
				$productLine = strtolower($productLine);
				$allProductLabel = $allProductLabel . "\n" . $productLine;
				$modelList = $data;
				if (isContain($messageText, $productLine)) {
					$isProductMatched = true;
					//Check if Xeon then do xeon
					if ($productLine == 'xeon' || $productLine == 'broadwell') {
						$allModelLabel = " E7-8880v3 or E5-2697v4";
						$model = getBroadwellCPUModel($messageText);
						if ($model != 'ERROR') {
							$isModelMatched = true;
							$outputText = specLookUp('broadwell',$model);
						}
					} else if ($productLine == 'skylake') {
					//Check if Skylake then do xeon
						$model = getSkylakeCPUModel($messageText);
						$allModelLabel = " 4112 or 6128";
						if ($model != 'ERROR') {
							$isModelMatched = true;
							$outputText = specLookUp($productLine,$model);
						}
					} else {
						//Other product other than xeon and skylake
						foreach ($modelList as $model) {
							$model = strtolower($model);
							if ($model == "na") break;
							if (strtolower($model) == $productLine) continue;
							$allModelLabel = $allModelLabel . "\n" . $model;
							if (isContain($messageText,$model)) {
								$isModelMatched = true;
								$outputText = specLookUp($productLine,$model);
							}
						}
					}
					if ($isModelMatched == false) $outputText = generateErrorWords() . "\nPlease select one of these " . $productLine . " model:" . $allModelLabel;
				}
			}
		}
		if ($isProductMatched == false) $outputText = generateErrorWords() . "\nPlease select one of these valid products:" . $allProductLabel;
		
		$tempBot->replyText($event->getReplyToken(), $outputText);
		return true;
	} else {
		return false;
	}
}
function replySpeech($tempBot, $event, $logger,$allResponse, $allCriteria) {
	$messageText=strtolower(trim($event->getText()));
	$allQuestion = $allCriteria->$allResponseCriterias;
	$allQuestionType = array_keys($allQuestion);
	$allAnswer = $allResponse->$allResponseResponse;
	$allAnswerType = array_keys($allAnswer);
	$outputText = "";
	$isFound = false;
	foreach ($allQuestionType as $question) {
		if ($isFound) break;
		$criteriaList = $allQuestion[$question];

		foreach ($criteriaList as $criteria) {
			if ($isFound) break;
			
			if (isContainFromArray($messageText, $criteria)) {
				//$logger->info($question);
				$outputText = getRandomTextFromArray($allAnswer[$question]);
				$random_int = random_int(0, 10000000);
				if ($random_int % 3 == 0)
					$userName = getRandomTextFromArray($allAnswer["secondPerson"]);
				else
					$userName = getUserName($event, $tempBot);
				$outputText = preg_replace("/([@][P])/", $userName, $outputText);
				$isFound = true;
			}
		}
	}
	if ($isFound == false) $outputText = getRandomTextFromArray($allAnswer["random"]) . "\n\nHint:\n" . getRandomTextFromArray($allAnswer["helphint"]);
	$tempBot->replyText($event->getReplyToken(), $outputText);
	return true;
}
function replyCalculator($tempBot, $event, $logger) {
	$messageText=strtolower(trim($event->getText()));
	if (isContain($messageText,'help')) return false;
	if (isContain($messageText,"cal") == false)
		return false;
	
	$tempText = preg_replace("/([c][a][l])/", "", $messageText);
	$tempArray = Calculator::CalculateEquation($tempText);
	$postFix = Calculator::InfixToPostfix($tempText);
	foreach ($postFix as $key) {
		$logger->info($key);
	}
	$ans = $tempArray[0];
	$result = "";
	if (isContain($ans,"ERROR")) {
		$result = generateErrorWords() . "\n" . $ans;
	} else {
		$result = generatePreanswer() . "\n" . $ans;
	}
	$tempBot->replyText($event->getReplyToken(), $result);
	return true;
}
function replySize($tempBot, $event, $logger) {
	//Precheck input
	$messageText=strtolower(trim($event->getText()));
	if (isContain($messageText,'help')) return false;
	$result = "";
	$errorStatus = "NONE";
	if (isContain($messageText,"size") == false)
		return false;
	//Explode Text and check if product line is input
	$inputArray = explode(" ", $messageText);
	if (sizeof($inputArray) < 2) {
		$result = "Please input correct product to size:\n- 3par";
		$tempBot->replyText($event->getReplyToken(), $result);
		return true;
	}
	//Check Product line sizer
	$product = $inputArray[1];
	if ($product == "3par") {
		$result = size3PAR($inputArray);
	} else {
		$result = "Please input correct product to size:\n- 3par";
		$tempBot->replyText($event->getReplyToken(), $result);
		return true;
	}
	//Check if sizer result is error or not.
	if (isContain($result,"ERROR")) {
		$tempArray = explode("_", $result);
		$result = generateErrorWords() . "\n" . $tempArray[1];
	} else {
		$result = generatePreanswer() . "\n" . $result;
	}
	$tempBot->replyText($event->getReplyToken(), $result);
	return true;
}
function replyLookup($tempBot, $event, $logger) {
	$messageText=strtolower(trim($event->getText()));
	if (isContain($messageText,'help')) return false;
	if (isStartWithText($messageText,'lookup')) {
		// Lookup CPU spec
		$result = "";
		if (isContain($messageText,'cpu')) {
			$result = generatePreanswer() . cpuLookup($messageText);
			if (isContain($result,"ERROR")) {
				$result = generateErrorWords() . "\nPlease input valid request:\n- lookup cpu clock 1.7 core 6 etc.";
			} else if (isContain($result,"NOANS")) {
				$result = generateErrorWords() . "\nI cannot find the requested spec.";
			}
		} else {
			$result = generateErrorWords() . "\nPlease input valid lookup:\n- lookup cpu clock 1.7 core 6 etc.";
		}
		$tempBot->replyText($event->getReplyToken(), $result);
	}
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
		return generateErrorWords() . ' Your number is less than zero or too big.';
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
					$result = 'Intel XEON ' . $targetModel . ' ' . $data[1] . ' GHz ' . $data[2] . ' cores'. "\nis equal to these following models:";
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
		$result = generateErrorWords() . "\n" . 'We cannot found the conversion of this model.';
	}
	return $result;
}
function convertSkylakeToBroadwell($cpuModel) {
	$row = 1;
	$result = '';
	$targetModel = '5555';
	if (($handle = fopen("./kb/SkylakeToBroadwell.csv", "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	    	//Check first match
	    	if ($targetModel == '5555') {
	       		if ($cpuModel ==  $data[0]) {
					$targetModel = $data[0];
					$result = 'Intel Skylake ' . $targetModel . ' ' . $data[1] . ' ' . $data[2] . ' GHz ' . $data[3] . ' cores'. "\nis equal to these following models:";
	       			$result = $result . "\n" . 'Intel Xeon ' . $data[4] . ' ' . $data[5] . ' GHz ' . $data[6] . ' cores';	
	       		}
	       	} else {
	       		//If not equal anymore. Break the loop.
	       		if ($data[0] != $targetModel) {
	       			break;
	       		}
	       		$result = $result . "\n" . 'Intel Xeon ' . $data[4] . ' ' . $data[5] . ' GHz ' . $data[6] . ' cores';	
	       	}
	    }
	}
	fclose($handle);
	if ($targetModel == '5555') {
		$result = generateErrorWords() . "\n" . 'We cannot found the conversion of this model.';
	}
	return $result;
}
function cpuLookup($input) {
	$inputArray = explode(" ", $input);
	$clock = 0;
	$core = 0;
	$resultCount = 0;
	$result = "";
	//Check clock
	for ($i = 2; $i<sizeof($inputArray); $i++) {
		if ($inputArray[$i] == 'clock') {
			$clock = (string)getFloat($inputArray[$i+1]);
		}
	}
	//Check core
	for ($i = 2; $i<sizeof($inputArray); $i++) {
		if ($inputArray[$i] == 'core' || $inputArray[$i] == 'cores') {
			$core = (string)getFloat($inputArray[$i+1]);
		}
	}
	//Check invalid input
	if ($clock == 0 && $core == 0) {
		return "ERROR";
	}
	if ($clock != 0 && $core != 0) {
		$fileDir = "./kb/broadwell.csv";
		if (($handle = fopen($fileDir, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		    	//Check Clock
		    	if ($clock == $data[1] && $core == $data[2]) {
		    		$result = $result . "\nXeon " . $data[0] . " Clock: " . $data[1] . " Cores: " . $data[2];
		    		$resultCount = $resultCount + 1;
		    	}
		    }
		}
		$fileDir = "./kb/skylake.csv";
		if (($handle = fopen($fileDir, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		    	//Check Clock
		    	if ($clock == $data[2] && $core == $data[3]) {
		    		$result = $result . "\nSkylake " . $data[0] . " " . $data[1] . " Clock: " . $data[2] . " Cores: " . $data[3];
		    		$resultCount = $resultCount + 1;
		    	}
		    }
		}
	} else if ($core != 0) {
		$fileDir = "./kb/broadwell.csv";
		if (($handle = fopen($fileDir, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		    	//Check Clock
		    	if ($core == $data[2]) {
		    		$result = $result . "\nXeon " . $data[0] . " Clock: " . $data[1] . " Cores: " . $data[2];
		    		$resultCount = $resultCount + 1;
		    	}
		    }
		}
		$fileDir = "./kb/skylake.csv";
		if (($handle = fopen($fileDir, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		    	//Check Clock
		    	if ($core == $data[3]) {
		    		$result = $result . "\nSkylake " . $data[0] . " " . $data[1] . " Clock: " . $data[2] . " Cores: " . $data[3];
		    		$resultCount = $resultCount + 1;
		    	}
		    }
		}
	} else if ($clock != 0) {
		$fileDir = "./kb/broadwell.csv";
		if (($handle = fopen($fileDir, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		    	//Check Clock
		    	if ($clock == $data[1]) {
		    		$result = $result . "\nXeon " . $data[0] . " Clock: " . $data[1] . " Cores: " . $data[2];
		    		$resultCount = $resultCount + 1;
		    	}
		    }
		}
		$fileDir = "./kb/skylake.csv";
		if (($handle = fopen($fileDir, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		    	//Check Clock
		    	if ($clock == $data[2]) {
		    		$result = $result . "\nSkylake " . $data[0] . " " . $data[1] . " Clock: " . $data[2] . " Cores: " . $data[3];
		    		$resultCount = $resultCount + 1;
		    	}
		    }
		}
	}
	if ($resultCount == 0) return "NOANS";
	//return ($inputArray[2] . " " . $inputArray[3] . " " . $inputArray[4] . " " . $inputArray[5] . $clock . $cores . $result . $resultCount);
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
			$tempModel=strtolower(trim($data[0]));
	    	//Get Head
	    	if ($count == 0) $header = $data;
	    	//Get unit
	    	else if ($count == 1) $unit = $data;
	    	//Get Spec

	    	else if ($tempModel == $model) {
	    		for($i = 0 ; $i < sizeof($header); $i++){
	    			if ($data[i] == 'NA' || $data[i] == 'N/A') continue;
	    			$result = $result . $header[$i] . " : " . $data[$i] . " " . $unit[$i] . "\n"; 
	    		}
	    		return $result;
	    	}
	    	if ($data[0] == 'DESC') return generateErrorWords() . "\n" . $data[1];
	    	$count++;
	    }
	}
	return 'ERROR';
}
function generateErrorWords() {
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
function size3PAR($inputArray) {
	if (sizeof($inputArray) < 5) {
		$result = "ERROR_Please input correct input format:\nsize 3par [No of disk] [size of disk] [Raid] [Raidset]\n[No of disk] =  Number of required disk\n[size of disk] = Size of each HDD size in TB or GB. Do not input the unit.\n[RAID] = Type of RAID. Input using R1 R5 or R6\n[Raidset]=Number of disk in a raid group. Input 4 for 3+1 in Raid5 or Input 8 for 6+2 in Raid6. Do not input this in Raid1\n\nFor example:\n\nsize 3par 48 3.82 r5 4\nsize 3par 16 480 r1\nsize 3par 32 6 r6 16";
		return result;
	}
	$diskNo = intval($inputArray[2]);
	$diskSize = floatval($inputArray[3]);
	$raidType = $inputArray[4];
	if ($raidType == "r1" && sizeof($inputArray) == 5) {
		array_push($inputArray, 2);
	} else if ($raidType == "r5" && sizeof($inputArray) == 5) {
		array_push($inputArray, 4);
	} else if ($raidType == "r6" && sizeof($inputArray) == 5) {
		array_push($inputArray, 8);
	}
	$raidSet = intval($inputArray[5]);
	$raidRatio = 1.0;
	$raidDes = "";
	$unit = "TB";
	//Set raid Ratio
	if ($raidType == "r5") {
		if ($raidSet < 3 || $raidSet > 9)
			return "ERROR_Please input correct RAID set for RAID 5:\nFrom 3 to 9.";
		$raidRatio = ($raidSet-1)/$raidSet;
		$raidDes = "RAID 5 : " . ($raidSet-1) . " + 1";
	} else if ($raidType == "r6") {
		if ($raidSet != 6 && $raidSet != 8 && $raidSet != 10 && $raidSet != 12 && $raidSet != 16)
			return "ERROR_Please input correct RAID set for RAID 6:\n6, 8, 12, 16.";
		$raidRatio = ($raidSet-2)/$raidSet;
		$raidDes = "RAID 6 : " . ($raidSet-2) . " + 2";
	} else if ($raidType == "r1") {
		$raidRatio = 0.5;
		$raidDes = "RAID 1";
	} else {
		return "ERROR_Please input each of these following available raid type:\nR1 R5 R6.";
	}
	//Check disk number
	if ($diskNo % $raidSet != 0 || $diskNo < 6) {
		return "ERROR_The input number of disk did not follow 3PAR best Practice.";
	}
	if ($diskSize > 16) {
		$diskSize /= 1000;
		$unit = "GB";
	}
	$rawTiB = $diskNo * $diskSize * 0.909495;
	$useTiB =  $diskNo * $diskSize * $raidRatio * 22 * 0.909495 * 1.01 / 24;

	$preanswer = "Capacity of 3PAR with " . $diskNo . " x " . $diskSize . $unit . "\nUsing " . $raidDes;
	return $preanswer . "\n\n" . $rawTiB . " TiB Raw Capacity.\n" . $useTiB . " TiB Usable Capacity.";
}
function getUserName($event, $tempBot) {
	$userId = $event->getUserId();
	$response = $tempBot->getProfile($userId);
	if ($response->isSucceeded()) {
    	$profile = $response->getJSONDecodedBody();
    	return $profile['displayName'];
    } else {
    	return 'stranger';
    }
}