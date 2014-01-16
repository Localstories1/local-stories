#!/php -q
<?php  /*  >php -q server.php  */
ini_set('default_socket_timeout', 10);
include_once('WebSocketHandshake.class.php');

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

$master  = WebSocket('localhost',11345);
$sockets = array($master);
$debug   = true;

while(true){
	$changed = $sockets;
	$expect = $sockets;
	socket_select($changed,$write=NULL,$expect,0,1000000);

	foreach($changed as $socket){
		if($socket==$master){
			$client=socket_accept($master);
			if($client<0){ console("socket_accept() failed"); continue; }
			else{
				socket_set_option($client,SOL_SOCKET, SO_KEEPALIVE, 1) or die('Can not set keepalive');
				connect($client);
			}
		}
		else{
			$bytes = @socket_recv($socket,$buffer,2048,0);
			if($bytes==0){ disconnect($socket); }
			else{
				send($buffer);
			}
		}
	}
}

function send($msg){

	console("< ".$msg);

	$mots 		= json_decode($msg);
	$mots 		= explode(' ', $mots);
	$sources	= glob('suppliers/*');
	$users		= array();

	foreach($sources as $source){

		$id 				= str_replace('.csv', '', basename($source));
		$source				= file_get_contents($source);
		$data				= explode(';', $source);
		$source_mots 			= str_replace(';', '', $source);
		$match				= array_intersect($mots, $source_mots);
		$users[count($math)][$id]	= $data;
	}
	ksort($users);

	return socket_write(json_encode($users));
}
function WebSocket($address,$port){
	$master=socket_create(AF_INET, SOCK_STREAM, SOL_TCP)     or die("socket_create() failed");
	socket_set_option($master, SOL_SOCKET, SO_REUSEADDR, 1)  or die("socket_option() failed");
	socket_bind($master, $address, $port)                    or die("socket_bind() failed");
	socket_listen($master,20)                                or die("socket_listen() failed");
	echo "Server Started : ".date('Y-m-d H:i:s')."\n";
	echo "Master socket  : ".$master."\n";
	echo "Listening on   : ".$address." port ".$port."\n\n";
	return $master;
}
function connect($socket){
	global $sockets;
	array_push($sockets,$socket);
	console($socket." CONNECTED!");
}

function disconnect($socket){
	global $sockets;
	$index = array_search($socket,$sockets);
	socket_close($socket);
	console($socket." DISCONNECTED!");
	if($index>=0){ array_splice($sockets,$index,1); }
}
function dohandshake($user,$buffer){
	console("\nRequesting handshake...");
	console($buffer);
	list($resource,$host,$origin) = getheaders($buffer);
	console("Handshaking...");

	$handshake = WebSocketHandshake($buffer);
	socket_write($user->socket,$handshake,strlen($handshake));

	$user->handshake=true;
	console($handshake);
	console("Done handshaking...");
	return true;
}

function getheaders($req){
	$r=$h=$o=null;
	if(preg_match("/GET (.*) HTTP/"   ,$req,$match)){ $r=$match[1]; }
	if(preg_match("/Host: (.*)\r\n/"  ,$req,$match)){ $h=$match[1]; }
	if(preg_match("/Origin: (.*)\r\n/",$req,$match)){ $o=$match[1]; }
	return array($r,$h,$o);
}

/**
 * 		Processing functions from javascript
 */

/**
 * 		Usefull functions
 */

function     say($msg=""){ echo $msg."\n"; }
function    wrap($msg=""){ return chr(0).$msg.chr(255); }
function  unwrap($msg=""){ return substr($msg,1,strlen($msg)-2); }
function console($msg=""){ global $debug; if($debug){ echo $msg."\n"; } }

?>
