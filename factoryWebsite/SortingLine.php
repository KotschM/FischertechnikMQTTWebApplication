<html>
	<head>
		<title>
			Sorting Line
		</title>
	</head>
	<body>
		<h2>
			Zurück zur Übersicht!
		</h2>
		<input type="button" onclick="location.href='index.php';" value="Übersicht" />
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
