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

class ChatBot {
	//Response and query object
   	public $allResponse;
	public $allCriteria;

	//LINE API connector
	private $logger;
	private $access_token;
	private $channel_id;
	private $channel_secret;
	private $userid;
	private $httpClient;
	private $bot;

	// LINE BOT Construtor
   	public function __construct() {
   		//Declare 
   		$this->allResponse = new AllResponse();
		$this->allCriteria = new AllCriteria();
		$this->logger = new Logger('LineBot');
		$this->logger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
		$this->access_token = 'tYLkTfUwWhH5WVunO5G0QhjUYgiAH4Bd0Bb+oFw0pfis0E0cibf6U73f7gdZid4cUcAURkLMr3D3qW3CfRbuFw3XubbKtHHY14ncqIhRpOwaB5c0BFol/a78jdM5uCj+bDPDMfEA8bOT/		cC0AAV8gdB04t89/1O/w1cDnyilFU=';
		$this->channel_id = '1529179895';
		$this->channel_secret = '29834a3e45690862a8876a576bac2172';
		$this->userid = 'Ua9222d61b45ff88cc7315440f4f285f3';
		$this->httpClient = new LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
		$this->bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channel_secret]);
		$this->allResponse = new AllResponse();
		$this->allCriteria = new AllCriteria();
		$this->signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
		$this->logger = new Logger('LineBot');
		$this->logger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
   	}

   	public function SendMessage($event,$outputText) {
   		$this->bot->replyText($event->getReplyToken(), $outputText);
   	}
   	public function LogMessage($message) {
   		$this->logger->info($message);
   	}
   	public function BotEventListen() {
   		try {
			$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
			return events;
		} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
			error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
		} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
			error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
		} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
			error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
		} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
			error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
		}
		return null;
	}
}

?> 