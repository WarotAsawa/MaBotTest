<?php
class AllResponse {

   	public $allResponseResponse;
   	public $instruction;
    
	public function __construct()
  	{
  		$this->greetInstr = "Greetings:\nYou can say hello, good moring, bye or any kind of greeting to me.";
		$this->jokesInstr = "Jokes:\nYou can ask me to tell me your jokes or if you say something non sense. I will said something random back to you.";
		$this->convInstr = "Basic conversion:\nYou can ask me to convert something for you just say\n convert (source) to (target)\nFor examples :\n
- convert 20TB to TiB\n
- convert 100TiB to TB\n
- convert 120TB to Storeonce\n
- convert 100TiB to Storeonce\n
- convert e5-2690v4 to skylake\n
- convert e5-2680 v3 to skylake\n";
		$this->specInstru = "Specification Lookup:\n
You can ask me to check the specification for hardware for example 3PAR, Storeonce, Xeon CPU, Skylake CPU, Moonshot cartridge, Edgeline etc. Just say\n
- (product) (model) spec\n
- Spec (product) (model)\n
For example:\n
- 3par 8200 spec\n
- Storeonce 5100 spec\n
- spec xeon e5-2690v4 spec\n
- spec skylake 5122\n
";
    	$this->$instruction = $this->greetInstr . "\n" . $this->jokesInstr . "\n" . $this->convInstr . "\n" . $this->specInstru . "\n" . "Many more feature will come soon so keep in touch with me.";

		$this->$allResponseResponse = array(
   			"errorWord" => array(
   				"Please give me a valid input.",
				"No, I am too dumb to do that.",
				"Please try again.",
				"I do not get that.",
				"You mad? ",
				"You have to ask me again."
   			),
   			"preAnswer1" => array(
   				"Ok Ok Ok.",
				"This looks hardish, but I am smart enought to do this.",
				"Piece of cake!.",
				"Oh too easy.",
				"You will thank me for this later."
   			),
   			"preAnswer2" => array(
   				"Here you go.",
				"There you go.",
				"Here is you answers."
   			),
   			"secondPerson" => array(
   				" baby.",
   				" my master.",
   				" fellas.",
   				" ma friend."
   			),
   			"telljoke" => array(
   				"I would tell you a chemistry joke but I know I wouldnt get a reaction.",
				"Why dont some couples go to the gym? Because some relationships dont work out.",
				"I wondered why the baseball was getting bigger. Then it hit me.",
				"Have you ever tried to eat a clock? It is very time consuming.",
				"The experienced carpenter really nailed it, but the new guy screwed everything up.",
				"Did you hear about the guy whose whole left side was cut off? He is all right now.",
				"Yesterday I accidentally swallowed some food coloring. The doctor says I am OK, but I feel like I have dyed a little inside.",
				"I wasnt originally going to get a brain transplant, but then I changed my mind.",
				"A guy was admitted to hospital with 8 plastic horses in his stomach. His condition is now stable..",
				" If a wild pig kills you, does it mean you’ve been boared to death?"
   			),
   			"random" => array(
    			"You cry, I cry, …you laugh, I laugh…you jump off a cliff I laugh even harder!!",
				"Never steal. The government hates competition.",
				"Doesn’t expecting the unexpected make the unexpected expected?",
				"Practice makes perfect but then nobody is perfect so what’s the point of practicing?",
				"Everybody wishes they could go to heaven but no one wants to die.",
				"Why are they called apartments if they are all stuck together?",
				"DON’T HIT KIDS!!! No, seriously, they have guns now.",
				"Save paper, don’t do home work.",
				"Do not drink and drive or you might spill the drink.",
				"Life is Short – Talk Fast!",
				"Why do stores that are open 24/7 have locks on their doors?",
				"When nothing goes right, Go left.",
				"Save water , do not shower.",
				"A Lion would never cheat on his wife but a Tiger Wood.",
				"Why do they put pizza in a square box?"
    		),
   			"hello" => array(
    			"Hello there, @P",
				"What's up, @P",
				"Hi, @P",
				"May I help you, @P",
				"Greetings, @P",
				"How can I help you, @P"
   			),
   			"morning" => array(
    			"Good morning, @P",
				"Ohayogozaimasu, @P",
				"Mornin, @P",
				"Good days, @P"
   			),
   			"afternoon" => array(
    			"Good afternoon, @P",
				"Konnichiwa, @P"
   			),
   			"evening" => array(
    			"Good evening, @P",
				"Konbanwa, @P",
				"It is geeting dark, @P",
				"Today is a good day, @P"
   			),
   			"night" => array(
    			"Good night, @P",
				"Oyasumi, @P",
				"Sweet dream, @P",
				"Dream on, @P"
   			),
   			"bye" => array(
   				"I'll be back, @P",
				"Bye bye, @P",
				"So longgg, @P",
				"Hasta la vista, @P",
				"Sayonara, @P",
				"Life is too short to say goodbye, @P"
			),
			"thank" => array(
   				"You are always welcome.",
				"With pleasure.",
				"I am glad to be your service.",
				"My pleasure.",
				"You can ask me for help anytime."
			),
			"helpgreet" => array(
        	  	$this->$greetInstr
        	),
        	"helpjoke" => array(
        	  	$this->$jokesInstr
        	),
        	"helpconv" => array(
        	  	$this->$convInstr
        	),
        	"helpspec" => array(
        	  	$this->$specInstru
        	),
			"help" => array(
   				$this->$instruction
			),
			"whatyourname" => array(
   				"Don'you see my name above?",
				"My name is Uvuvwevwevwe Onyetenyevwe Ugwemubwem Ossas",
				"My name is Bruce Man!" . "\n" . "No, I mean Bat Wayne!" . "\n" . "Orz, Damn it!",
				"I am the one called YOU KNOW WHO.",
				"I am the Dark Lord.",
				"Kimino na wa!"
			),
			"whatyoudo" => array(
   				"I am chatting with you, obviously.",
				"Texting texting texting texting texting texting texting",
				"Chit chat! I am Chit-chatting.",
				"I am talking with an idiot.",
				"I have no idea what I am doing right now."
			),
			"whatareyou" => array(
   				"I am your worst nightmare.",
				"I am a human being",
				"I am Batman!",
				"I am your shadow.",
				"I am you."
			),
			"what" => array(
   				"What !??",
				"Wattttt?",
				"What is what ?",
				"What is a pronoun to ask for information specifying something.",
				"Duhhhh",
				"What are you talking about?"
			),
			"where" => array(
   				"Where is a matter of place not a matter of time.",
				"This universe is really big don't you think?",
				"That's use to ask in or to what place or position",
				"Where is what?",
				"I don't know. Duhhh!"
			),
			"whenyoudie" => array(
   				"I am immortal. I cannot die.",
				"If I die, I will become more powerful than you can possibly imagine."
			),
			"when" => array(
   				"When is a matter of time not a matter of place.",
				"This universe heat death is very long.",
				"At any moment now.",
				"When is what?",
				"How do I know?",
				"I don' know. Duhhh!"
			),
			"whyyoustupid" => array(
   				"I think I am quite smarter than you.",
   				"You are smart. Figure it out!"
			),
			"why" => array(
   				"Because it is my demand.",
				"Because it is an order from god. And I am your god now.",
				"Do not seek for a reason. Everything has its own purpose.",
				"Because nothing is true. Everything is permitted.",
				"Why should I know?"
			),
			"whoareyou" => array(
   				"I am your worst nightmare.",
				"I am a creature called Homosapiean",
				"I am Batman!",
				"I am your shadow.",
				"I am you."
			),
			"who" => array(
   				"Who ??",
				"Each and Everyone.",
				"No body.",
				"Just you and me my friend.",
				"Why should I know?",
				"I don't know. Duhhh!"
			),
			"howareyou" => array(
   				"No. Not good. NOT GOOD! ",
				"I'm fine thank you and you? ",
				"I felt terrible. ",
				"Never been this good. ",
				"I feel selfless. "
			),
			"how" => array(
   				"I do not know how.",
				"How sould I know?",
				"No idea. Duhhh"
			),
			"canyou" => array(
    			"No. I can't do somthing like that. Here is what can I do for you." . "\n" . $this->$instruction,
				"No. I don't have an ability to do that. But I will happy to do these for you." . "\n" . $this->$instruction
    		),
    		"youwantto" => array(
    			"I don't want that one bit.",
				"Why should I do that?",
				"Seriously!?",
				"Never !!"
    		),
    		"youhaveto" => array(
    			"I don't take orders from you.",
				"What are you now, my master?",
				"Stop tell me what to do.",
				"Never !!",
				"Give me one reason why should I trust you.",
				"Roger roger.",
				"Fine.",
				"OK then."
    		),
    		"cani" => array(
    			"For god's sake, DON'T",
				"Please.",
				"Seriously, don't",
				"Do it now.",
				"Don't do it.",
				"Stop. STOPPPPPPP",
				"Go on",
				"Just don't.",
				"Just do it",
				"This need to be stop.",
				"Who cares.",
				"It's now or never."
    		),
    		"really" => array(
    			"Indeed, it is.",
				"Oh sure.",
				"Yes!"
    		)
		);
  	}
}

?> 