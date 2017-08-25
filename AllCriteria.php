<?php
class AllCriteria {

  public $allResponseCriterias;
    
	public function __construct()
  {
		$this->$allResponseCriterias = array(
    		"telljoke" => array(
    			array("tell", "joke"),
 				array("tell","funny")
    		),
    		"hello" => array(
    			array("hello"),
    			array("greeting"),
    			array("what","up"),
    			array("hey")
    		),
    		"morning" => array(
    			array("good mornin"),
    			array("goodmornin")
    		),
    		"afternoon" => array(
    			array("good afternoon"),
    			array("goodafternoon")
    		),
    		"evening" => array(
    			array("good evenin"),
    			array("goodevenin")
    		),
    		"night" => array(
    			array("good night"),
    			array("goodnight")
    		),
    		"bye" => array(
    			array("bye"),
    			array("see you"),
    			array("see ya"),
    			array("farewell")
    		),
    		"thank" => array(
    			array("thanks"),
    			array("thank you"),
    			array("thankyou")
    		),
    		"help" => array(
    			array("help"),
    			array("can you", "help")
    		),
    		"whatyourname" => array(
    			array("what", "your", "name"),
    			array("wat", "your", "name")
    		),
    		"whatyoudo" => array(
    			array("what", "you", "do"),
    			array("wat", "you", "do")
    		),
    		"whatareyou" => array(
    			array("what", "you", "are"),
    			array("wat", "you", "are")
    		),
    		"what" => array(
    			array("what"),
    			array("wat")
    		),
    		"whereyoulive" => array(
    			array("where", "you", "live")
    		),
    		"where" => array(
    			array("where")
    		),
    		"whenyoudie" => array(
    			array("when", "you", "die")
    		),
    		"when" => array(
    			array("when")
    		),
    		"whyyoustupid" => array(
    			array("why", "you","stupid")
    		),
    		"why" => array(
    			array("why")
    		),
    		"whoareyou" => array(
    			array("who", "are","you")
    		),
    		"who" => array(
    			array("who")
    		),
    		"howareyou" => array(
    			array("how", "are","you"),
    			array("how", "do","you"),
    			array("how", "is","it","goin")
    		),
    		"how" => array(
    			array("how")
    		),
    		"canyou" => array(
    			array("can you"),
    			array("could you"),
    			array("may you")
    		),
    		"youwantto" => array(
    			array("you", "wanna"),
    			array("you", "want to")
    		),
    		"youhaveto" => array(
    			array("you", "have to"),
    			array("you", "must")
    		),
    		"cani" => array(
    			array("can i"),
    			array("could i"),
    			array("i", "wanna"),
    			array("i", "want to"),
    			array("may i")
    		)
    	);
  }
}

?> 