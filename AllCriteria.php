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
    			array("wat", "your", "name"),
          array("what", " ur ", "name"),
          array("wat", " ur ", "name")
    		),
    		"whatyoudo" => array(
    			array("what", "you", "do"),
    			array("wat", "you", "do"),
          array("what", " u ", "do"),
          array("wat", " u ", "do")
    		),
    		"whatareyou" => array(
    			array("what", "you", "are"),
    			array("wat", "you", "are"),
          array("what", " u", "are"),
          array("wat", " u", "are")
    		),
    		"what" => array(
    			array("what"),
    			array("wat")
    		),
    		"whereyoulive" => array(
    			array("where", "you", "live"),
          array("where", " u ", "live")
    		),
    		"where" => array(
    			array("where")
    		),
    		"whenyoudie" => array(
    			array("when", "you", "die"),
          array("when", " u ", "die")
    		),
    		"when" => array(
    			array("when")
    		),
    		"whyyoustupid" => array(
    			array("why", "you","stupid"),
          array("why", " u ","stupid")
    		),
    		"why" => array(
    			array("why")
    		),
    		"whoareyou" => array(
    			array("who", "are","you"),
          array("who", "are u")
    		),
    		"who" => array(
    			array("who")
    		),
    		"howareyou" => array(
    			array("how", "are","you"),
    			array("how", "do","you do"),
    			array("how", "is","it","goin"),
          array("how", "are u"),
          array("how", "do u do")
    		),
        "how" => array(
    			array("how")
    		),
    		"canyou" => array(
    			array("can you"),
    			array("could you"),
    			array("may you"),
          array("can u"),
          array("could u"),
          array("may u")
    		),
    		"youwantto" => array(
    			array("you", "wanna"),
    			array("you", "want to"),
          array("u ", "wanna"),
          array("u ", "want to")
    		),
    		"youhaveto" => array(
    			array("you", "have to"),
    			array("you", "must"),
          array(" u ", "have to"),
          array(" u ", "must")
    		),
        "youhaveto" => array(
          array("you", "have to"),
          array("you", "must"),
          array("u", "have to"),
          array("u", "must")
        ),
    		"cani" => array(
    			array("can i"),
    			array("could i"),
    			array("i", "wanna"),
    			array("i", "want to"),
    			array("may i")
    		),
        "really" => array(
          array("really"),
          array("is it")
        )
    	);
  }
}

?> 