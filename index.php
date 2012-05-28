<?
// $filepath = '/home/analogue/public_html/www.glop.org/lineage2/';
$filename = 'cache.txt';

$mtime = filemtime($filename);
$difftime = time() - $mtime;
if ($difftime > 60)
	include('update.php');
?>

<html>
<head>
	<title>Lineage 2 Server Status</title>
	<meta http-equiv="Refresh" content="60;URL=http://www.glop.org/lineage2/" />
	<style type="text/css">
		body {
			font-family: Verdana, sans-serif;
			font-size: 8pt;
			color: white;
			background-color: #0B283B;
		}
		img {
			border: 0;
		}
		td.left {
			padding-left: 1em;
		}
		td.right {
			padding-right: 1em;
			text-align: right;
		}
		table.status {
			background: url("bg.gif");
			width: 192px;
			font-size: 8pt;
			font-weight: bold;
		}
		.yellow {
			color: yellow;
			background-color: transparent;
		}
		.up {
			color: #4f4;
			background-color: transparent;
		}
		.down {
			color: red;
			background-color: transparent;
		}
		td.top {
			padding-bottom: .5em;
		}
		td.full_line {
			text-align: center;
			padding-top: 1em;
			padding-left: 1em;
			padding-right: 1em;
			font-size: 7pt;
		}
		td.full_line_small {
			text-align: center;
			padding-top: 1em;
			padding-left: 1em;
			padding-right: 1em;
			font-size: 6pt;
		}
		a {
			color: #97E6ED;
			background-color: transparent;
			text-decoration: none;
		}
		a:hover {
			color: #D9DEE3;
			background-color: transparent;
			text-decoration: underline;
		}
	</style>
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
	</script>
	<script type="text/javascript">
		_uacct = "UA-107561-2";
		urchinTracker();
	</script>
</head>
<body>

<table width="100%" height="100%" cellspacing="0" cellpadding="0"><tr><td align="center">

<table cellspacing="0" cellpadding="0" class="status" border="0">
	<tr><td colspan="2" class="top"><img src="up.gif" /></td></tr>
	<? include($filename); ?>
	<tr><td colspan="2" class="full_line">Updated <?=$difftime?> second<? if($difftime > 1) echo 's'; ?> ago</td></tr>
	<tr><td colspan="2" class="full_line_small">
		<?/*<a href="history.html">Graph</a> |
		<a href="http://www.glop.org/forum/viewforum.php?id=2">Forum</a> |*/?>
		<a href="backend.txt">Backend</a> |
		<a href="https://www.paypal.com/xclick/business=analogue%40glop.org&item_name=Lineage+2+Server+Status&no_note=1&currency_code=EUR">PayPal</a> |
		<a href="http://flattr.com/thing/6354/Lineage-2-Server-Status">Flattr</a>
		</td></tr>
	<tr><td colspan="2"><img src="down.gif" /></td></tr>
</table>

</td></tr></table>

</body>
</html>
