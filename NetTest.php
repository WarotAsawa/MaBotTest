<?php
class NetTest {

	public static function PingICMP($targetIP,$timeOut = 1) {
		//Ping target using ICMP
		$package = "\x08\x00\x19\x2f\x00\x00\x00\x00\x70\x69\x6e\x67";
		$socket = socket_create(AF_INET, SOCK_RAW, 1);
   
    	/* set socket receive timeout to 1 second */
    	socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => $timeOut, "usec" => 0));
    	/* connect to socket */
    	socket_connect($socket, $targetIP, null);
    	/* record start time */
    	$ts = microtime(true);
        socket_send($socket, $package, strLen($package), 0);
		if (socket_read($socket, 255)) {
		        $result = microtime(true) - $ts;
		} else {
			$result = false;
		}
		socket_close($socket);

		//Generate Result Text
		if ($result == false) {
			$result = "Ping ICMP to " . $host . " timeout!!!";
		} else  {
			$result = "Reply from " . $host . " with " . $result . " ms.";
		}
		return $result;
	}

	public static function PingTCP($targetIP, $targetPort,$timeOut = 1) {
		//Ping target using TCP at target port

	}

	public static function PingUDP($targetIP, $targetPort,$timeOut = 1) {
		//Ping target using UDP at target port

	}
}
?> 