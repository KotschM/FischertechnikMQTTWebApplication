<html>
	<head>
		<title>
			Fischertechnik 4.0
		</title>
	</head>
	<body>
		<h4>
			Steuerung der Druckluft!
		</h4>
		<form method="post">
			<p>
				<button name="buttonCompressor">Druckluft</button>
			</p>
		</form>
		<h4>
			Steuerung der Schieber!
		</h4>
		<form method="post">
			<p>
				<button name="buttonWhite">Weiß</button>
				<button name="buttonRed">Rot</button>
				<button name="buttonBlue">Blau</button>
			</p>
		</form>
		<p>
			<?php
				$result = exec('python CompressorStats.py');
				echo date("Y/m/d") . " => " . $result;
			?>
		</p>
	</body>
</html>

<?php
	if (isset($_POST['buttonCompressor']))
	{
		$text = "AirCompressor";
		$cmd = 'sudo python /var/www/html/CompressorOnOff/Compressor.py "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonWhite']))
	{
		$text = "White";
		$cmd = 'sudo python /var/www/html/CompressorOnOff/Compressor.py "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonRed']))
	{
		$text = "Red";
		$cmd = 'sudo python /var/www/html/CompressorOnOff/Compressor.py "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonBlue']))
	{
		$text = "Blue";
		$cmd = 'sudo python /var/www/html/CompressorOnOff/Compressor.py "'.$text.'"';
		shell_exec($cmd);
	}
?>
