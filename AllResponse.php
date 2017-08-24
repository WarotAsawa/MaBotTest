<?php
class AllResponse {

    public $allResponseCriterias = array(
    	"telljoke" => array(
    		array("tell", "joke"),
 			array("tell","funny")
    	),
    	"hello" => array(
    		array("hello"),
    		array("greeting"),
    		array("what\'s up"),
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
    	),
    );
   	public $allResponseResponse = array(
   		"errorWord" => array(
   			'Please give me a valid input.',
			'No, I am too dumb to do that.',
			'Please try again.',
			'I do not get that.',
			'You mad? ',
			'You have to ask me again.'
   		),
   		"preAnswer1" => array(
   			'Ok Ok Ok.',
			'This looks hardish, but I am smart enought to do this.',
			'Piece of cake!.',
			'Oh too easy.',
			'You will thank me or this later.'
   		),
   		"preAnswer2" => array(
   			'Here you go.',
			'There you go.',
			'Here is you answers.'
   		),
   		"secondPerson" => array(
   			' baby.',
   			' my master.',
   			' fellas.',
   			' ma friend.'
   		),
   		"telljoke" => array(
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
   		),
   		"random" => array(
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
    	),
   		"hello" => array(
    		'Hello there,',
			'What\'s up,',
			'Hi,',
			'May I help you,',
			'Greetings,',
			'How can I help you,'
   		),
   		"morning" => array(
    		'Good morning,',
			'Ohayogozaimasu,',
			'Mornin,',
			'Good days,'
   		),
   		"afternoon" => array(
    		'Good afternoon,',
			'Konnichiwa,'
   		),
   		"evening" => array(
    		'Good evening,',
			'Konbanwa,',
			'It is geeting dark,',
			'Today is a good day,'
   		),
   		"night" => array(
    		'Good night,',
			'Oyasumi,',
			'Sweet dream,',
			'Dream on,'
   		),
   		"bye" => array(
   			'I\'ll be back, ',
			'Bye bye,',
			'So longgg,',
			'Hasta la vista,',
			'Sayonara,',
			'Life is too short to say goodbye,'
		),
		"thank" => array(
   			'You are always welcome.',
			'With pleasure.',
			'I am glad to be your service.',
			'My pleasure.',
			'You can ask me for help anytime.'
		),
		"help" => array(
   			$instruction
		),
		"whatyourname" => array(
   			'Don\'you see my name above?',
			'My name is Uvuvwevwevwe Onyetenyevwe Ugwemubwem Ossas',
			'My name is Bruce Man!' . "\n" . 'No, I mean Bat Wayne!' . "\n" . 'Orz, Damn it!',
			'I am the one called YOU KNOW WHO.',
			'I am the Dark Lord.',
			'Kimino na wa!'
		),
		"whatyoudo" => array(
   			'I am chatting with you, obviously.',
			'Texting texting texting texting texting texting texting',
			'Chit chat! I am Chit-chatting.',
			'I am talking with an idiot.',
			'I have no idea what I am doing right now.'
		),
		"whatareyou" => array(
   			'I am your worst nightmare.',
			'I am a creature called Homosapiean',
			'I am Batman!',
			'I am your shadow.',
			'I am you.'
		),
		"what" => array(
   			'What !??',
			'Wattttt?',
			'What is what ?',
			'What is a pronoun to ask for information specifying something.',
			'Duhhhh',
			'What are you talking about?'
		),
		"where" => array(
   			'Where is a matter of place not a matter of time.',
			'This universe is really big don\'t you think?',
			'That\'s use to ask in or to what place or position',
			'Where is what?',
			'I don\'t know. Duhhh!'
		),
		"whenyoudie" => array(
   			'I am immortal. I cannot die.',
			'If I die, I will become more powerful than you can possibly imagine.'
		),
		"when" => array(
   			'When is a matter of time not a matter of place.',
			'This universe heat death is very long.',
			'At any moment now.',
			'When is what?',
			'How do I know?',
			'I don\' know. Duhhh!'
		),
		"whyyoustupid" => array(
   			'I think I am quite smarter than you.',
   			'You are smart. Figure it out!'
		),
		"why" => array(
   			'Because it is my demand.',
			'Because it is an order from god. And I am your god now.',
			'Do not seek for a reason. Everything has its own purpose.',
			'Because nothing is true. Everything is permitted.',
			'Why should I know?'
		),
		"whoareyou" => array(
   			'I am your worst nightmare.',
			'I am a creature called Homosapiean',
			'I am Batman!',
			'I am your shadow.',
			'I am you.'
		),
		"who" => array(
   			'Who ??',
			'Each and Everyone.',
			'No body.',
			'Just you and me my friend.',
			'Why should I know?',
			'I don\'t know. Duhhh!'
		),
		"howareyou" => array(
   			'No. Not good. NOT GOOD! ',
			'I\'m fine thank you and you? ',
			'I felt terrible. ',
			'Never been this good. ',
			'I feel selfless. '
		),
		"how" => array(
   			'I do not know how.',
			'How sould I know?',
			'No idea. Duhhh'
		),
		"canyou" => array(
    		'No. I can\'t do somthing like that. Here is what can I do for you.' . "\n" . $instruction,
			'No. I don\'t have an ability to do that. But I will happy to do these for you.' . "\n" . $instruction
    	),
    	"youwantto" => array(
    		'I don\'t want that one bit.',
			'Why should I do that?',
			'Seriously!?',
			'Never !!'
    	),
    	"youhaveto" => array(
    		'I don\'t take orders from you.',
			'What are you now, my master?',
			'Stop tell me what to do.',
			'Never !!',
			'Give me one reason why should I trust you.',
			'Roger roger.',
			'Fine.',
			'OK then.'
    	),
    	"cani" => array(
    		'For god\'s sake, DON\'T',
			'Please.',
			'Seriously, don\'t',
			'Do it now.',
			'Don\'t do it.',
			'Stop. STOPPPPPPP',
			'Go on',
			'Just don\'t.',
			'Just do it',
			'This need to be stop.',
			'Who cares.',
			'It\'s now or never.'
    	)
   	);
   	);
   
   public $instruction = "Greetings: \n
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

?> 