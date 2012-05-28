<?
define(DEBUG, false);

if(DEBUG)
	echo "<pre>\n";

$servers = array(
//	'Login Server'		=> array('63.110.21.98', '2106', 'login'),
//	'0. Login Server'	=> array('206.127.151.66', '2106', 'login'),
//	'0. Login Server'	=> array('216.107.242.195', '2106', 'login'),
	'0. Login Server'	=> array('216.107.242.199', '2106', 'login'),
//	'1. Bartz'			=> array('63.110.21.67', '7777', 'bartz'),
//	'1. Bartz'			=> array('65.218.204.227', '7777', 'bartz'),
//	'1. Bartz'			=> array('63.110.21.79', '7777', 'bartz'),
//	'1. Bartz'			=> array('206.127.151.6', '7777', 'bartz'),
	'1. Bartz'			=> array('216.107.244.130', '7777', 'bartz'),
//	'2. Sieghardt'		=> array('63.110.21.70', '7777', 'sieghardt'),
//	'2. Sieghardt'		=> array('65.218.204.230', '7777', 'sieghardt'),
//	'2. Sieghardt'		=> array('206.127.151.133', '7777', 'sieghardt'),
//	'2. Sieghardt'		=> array('216.107.244.133', '7777', 'sieghardt'),
//	'2. Sieghardt'		=> array('216.107.242.198', '7777', 'sieghardt'),
//	'2. Sieghardt'		=> array('216.107.244.133', '7777', 'sieghardt'),
	'2. Sayha'			=> array('216.107.244.133', '7777', 'sayha'),
//	'3. Kain'			=> array('63.110.21.73', '7777', 'kain'),
//	'3. Kain'			=> array('206.127.151.9', '7777', 'kain'),
//	'3. Kain'			=> array('216.107.244.136', '7777', 'kain'),
	'3. Aria'			=> array('216.107.244.136', '7777', 'aria'),
//	'4. Lionna'			=> array('63.110.21.76', '7777', 'lionna'),
//	'4. Lionna'			=> array('206.127.151.12', '7777', 'lionna'),
//	'4. Lionna'			=> array('216.107.244.139', '7777', 'lionna'),
//	'5. Erica'			=> array('63.110.21.46', '7777', 'erica'),
//	'5. Erica'			=> array('63.110.21.79', '7777', 'erica'),
//	'5. Erica'			=> array('63.110.21.70', '7777', 'erica'),
//	'5. Erica'			=> array('206.127.151.15', '7777', 'erica'),
//	'5. Erica'			=> array('216.107.244.142', '7777', 'erica'),
//	'6. Gustin'			=> array('65.205.186.99', '7777', 'gustin'),
//	'6. Gustin'			=> array('206.127.155.130', '7777', 'gustin'),
	'4. Phoenix'		=> array('206.127.155.130', '7777', 'phoenix'),
//	'7. Devianne'		=> array('65.205.186.102', '7777', 'devianne'),
	'5. Devianne'		=> array('206.127.155.131', '7777', 'devianne'),
//	'8. Hindemith'		=> array('65.205.186.105', '7777', 'hindemith'),
//	'8. Hindemith'		=> array('206.127.155.132', '7777', 'hindemith'),
//	'9. Teon'			=> array('65.205.186.108', '7777', 'teon'),
//	'9. Teon'			=> array('206.127.155.133', '7777', 'teon'),
	'6. Teon'			=> array('206.127.145.162', '7777', 'teon'),
	'7. Franz'			=> array('206.127.145.163', '7777', 'franz'),
	'8. Luna'			=> array('206.127.145.165', '7777', 'luna'),
//	'A. PTS'			=> array('8.3.0.130', '7777', 'pts')
	'9. PTS'			=> array('216.107.242.201', '7777', 'pts')
//	'B. PTS'			=> array('216.107.242.198', '7777', 'pts')
	);

function getmicrotime()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

function CheckServer($ip, $port, $name)
{
	$time_start = getmicrotime();
	if ($fp = @fsockopen($ip, $port, $errno, $errstr, 1)) {
		$totalTime = getmicrotime() - $time_start;
		fclose($fp);
		if(DEBUG)
			echo $ip.':'.$port.' is up ('.(round($totalTime*1000))." ms)\n";
		//system('/usr/bin/rrdtool update '.$filepath.$name.'.rrd N:'.(round($totalTime*1000)));
		return round($totalTime*1000);
	} else {
		if(DEBUG)
				echo $ip.':'.$port." is down\n";
		//system('/usr/bin/rrdtool update '.$filepath.$name.'.rrd N:INF');
		return false;
	}
}

function WriteHtmlCache() {
	global $servers, $txt_backend;
	foreach($servers as $s => $k) {
		$to_write .= '<td class="left" nowrap>- <span class="yellow">'.$s.'</span></td>';
		$txt_backend .= $k[2] . "\n";
		if ($ms = CheckServer($k[0], $k[1], $k[2])) {
			$to_write .= '<td class="right" nowrap><span class="up">'.$ms.'</span> ms</td>';
			$txt_backend .= $ms . "\n";
		} else {
			$to_write .= '<td class="right" nowrap><span class="down">down</span></td>';
			$txt_backend .= "down\n";
		}
		$to_write .= "</tr>\n";
	}
	return $to_write;
}

//$filepath = '/home/analogue/public_html/www.glop.org/lineage2/';
$filename_tmp = 'cache.tmp';
$filename = 'cache.txt';
$backend = 'backend.txt';

unset($txt_backend);
$to_write = WriteHtmlCache();
if(strlen($to_write) > 0) {
	$handle = @fopen($backend, 'w');
	if($handle)
	{
		fwrite($handle, $txt_backend);
		fclose($handle);
		// touch() ajoutés pour bug date
		touch($backend);
	}
	$handle = @fopen($filename_tmp, 'w');
	if($handle)
	{
		fwrite($handle, $to_write);
		fclose($handle);
		copy($filename_tmp, $filename);
		// touch() ajoutés pour bug date
		touch($filename_tmp);
		touch($filename);
	}
}
//system($filepath.'rrdgraph');

if(DEBUG)
	echo "</pre>\n";
?>
