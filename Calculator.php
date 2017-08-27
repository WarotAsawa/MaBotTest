<?php
class Calulator {

	public static function CalculateEquation($string) {
		return InfixToPrefix($string);

	}
	private static function InfixToPrefix($string) {
		$lastCharType = "NONE";
		$result = "ERROR";
		$infix = strtolower(trim($string));
		$infix = EliminateWhiteSpace($infix);
		$infix = ConvertPercentToMultiply($input);
		$result = EquationExplode($infix);
		return $result;
	}
	private static function ConvertPercentToMultiply($input) {
		$result = preg_replace("/([%])/", "x0.01", $input);
		return $result;
	}
	private static function EliminateWhiteSpace($input) {
		$result = preg_replace("/([ ,_,\n,\t,\',\"])/", "", $input);
		return $result;
	}
	private static EquationExplode($input) {
		$result = array();
		$pushString = "";
		for ($i=0; $i<sizeof($input); $i++) {
			if (is_numeric($input[$i]) || $input[$i] == '.') {
				$pushString = $pushString . $input[$i];
			} else if ($input[$i] == '+' || $input[$i] == '-' || $input[$i] == '*' || $input[$i] == '/' || $input[$i] == '^' || $input[$i] == '(' || $input[$i] == ')') {
				array_push($result, $pushString);
				$pushString = "";
				array_push($result, $input[$i]);
			} else {
				return array("ERROR");
			}
		}
		if ($pushString != "")
			array_push($result, $pushString);
		return $result;
	}
}
?> 