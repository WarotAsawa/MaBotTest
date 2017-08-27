<?php
class Calculator {

	public static function CalculateEquation($string) {
		$postfix =  Calculator::InfixToPrefix($string);
		$result = Calculator::CalculatePostfix($postfix);
		return $result;
	}
	private static function InfixToPrefix($string) {
		$lastCharType = "NONE";
		$postFix = array();
		$operatorStack = array();
		$infix = Calculator::EliminateWhiteSpace($string);
		$infix = Calculator::ConvertPercentToMultiply($infix);
		$infixArray = Calculator::EquationExplode($infix);

		for($i = 0; $i < sizeof($infixArray); $i++) {
			//If Paren
			if ($infixArray[$i] == '(') {
				array_push($operatorStack, $infixArray[$i]);
			} else if ($infixArray[$i] == ')') {
				while(end($operatorStack) != '(' && sizeof($operatorStack) > 0) {
						//Check unbalance parent
						if (sizeof($operatorStack) == 1 && end($operatorStack) != '(') 
							return array(')');
						$temp = array_pop($operatorStack);
						array_push($postFix, $temp);
					}
					$temp = array_pop($operatorStack);
			} 
			// Check if it is operator
			else if (Calculator::IsOperator($infixArray[$i])) {
				//Check if higher class operator, push into stack
				if (Calculator::CompareOperator($infixArray[$i], end($operatorStack) == "HIGHER")) {
					array_push($operatorStack, $infixArray[$i]);
				} else {
					while(sizeof($operatorStack) > 0) {
						if (end($operatorStack) == '(') break;
						if (Calculator::CompareOperator($infixArray[$i], end($operatorStack) == "HIGHER")) break;
						$temp = array_pop($operatorStack);
						array_push($postFix, $temp);
					}
					array_push($operatorStack, $infixArray[$i]);
				}
			} else {
				//Check unbalance parent
				array_push($postFix, $infixArray[$i]);
			}
		}
		while(sizeof($operatorStack) > 0) {
			if (end($operatorStack) == '(') return array('(');
			$temp = array_pop($operatorStack);
			array_push($postFix, $temp);
		}
		return $postFix;
	}
	private static function CalculatePostfix($input) {
		$resultStack = array();
		if ($input[0] == '(' || $input[0] == ')') {
			return "ERROR: Unbalanced parenthesis";
		}
		for ($i = 0; $i < sizeof($input) ; $i++) {
			if (Calculator::IsOperator($input[$i])) {
				if (sizeof($resultStack) < 2) {
					return "ERROR: Please input the equation correctly.";
				}
				$b = floatval(array_pop($resultStack));
				$a = floatval(array_pop($resultStack));
				if ($input[$i] == '+') {
					array_push($resultStack, $a+$b);
				} else if ($input[$i] == '-') {
					array_push($resultStack, $a-$b);
				} else if ($input[$i] == '*' || $input[$i] == 'x') {
					array_push($resultStack, $a-$b);
				} else if ($input[$i] == '/') {
					array_push($resultStack, $a-$b);
				} else if ($input[$i] == '^') {
					array_push($resultStack, pow($a, $b));
				}
			} else {
				array_push($resultStack, $input[$i]);
			}
		}
		//if (sizeof($resultStack)>0) return "ERROR: Please input the equation correctly.";
		return $resultStack[0];
	}	
	private static function ConvertPercentToMultiply($input) {
		$result = preg_replace("/([%])/", "*0.01", $input);
		return $result;
	}
	private static function EliminateWhiteSpace($input) {
		$result = preg_replace("/([ ,_,\n,\t,\',\"])/", "", $input);
		return $result;
	}
	private static function EquationExplode($input) {
		$result = array();
		$pushString = "";
		for ($i=0; $i<strlen($input); $i++) {
			if (is_numeric($input[$i]) || $input[$i] == '.') {
				$pushString = $pushString . $input[$i];
			} else if ($input[$i] == '+' || $input[$i] == '-' || $input[$i] == '*' || $input[$i] == '/' || $input[$i] == '^' || $input[$i] == '(' || $input[$i] == ')' || $input[$i] == 'x') {
				if ($pushString != "")
						array_push($result, $pushString);
				$pushString = "";
				array_push($result, $input[$i]);
			} else {
				//return array("ERROR");
			}
		}
		if ($pushString != "")
			array_push($result, $pushString);
		return $result;
	}
	private static function CompareOperator($a, $b) {
		if ($b == '(' || $b == ')') return "HIGHER";
		if ($a == '+' || $a == '-') {
			return "LOWER";
		} else if ($a == '*' || $a == '/'  || $a == 'x' || $a == '^') {
			if ($b == '+' || $b == '-') {
				return "HIGHER";
			} else {
				return "LOWER";
			}
		}
		return "LOWER";
	}
	private static function IsOperator($input) {
		if ($input[$i] == '+' || $input[$i] == '-' || $input[$i] == '*' || $input[$i] == '/' || $input[$i] == '^' || $input[$i] == 'x') {
			return true;
		} else {
			return false;
		}
	}
}
?> 