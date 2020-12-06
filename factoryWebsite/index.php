<!DOCTYPE html>
<html>
    <head>
        <Title>Fischertechnik 4.0</Title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    </head>

    <body>
        <!-- HEADER -->
        <header>
            <div id="logo">
                <a href="#">
                    <img src="img/avatar.png">
                </a>
            </div>

            <nav id="main-nav">
                <ul>
                    <li><a href="#overview">Übersicht</a></li>
                    <li><a href="#street">Straße</a></li>
                    <li><a href="#production">Fertigung</a></li>
                    <li><a href="#warehouse">Lager</a></li>
                </ul>
            </nav>
        </header>

        <!-- OVERVIEW -->

        <section id="overview">
            <hr>
            <h1>Fischertechnik 4.0</h1>
            <h2>DHBW Stuttgart Campus Horb</h2>
            <a href="#street">
                <img src="img/pfeil.png">
            </a>
        </section>

        <!-- STREET -->

        <section id="street">
            <h3>Sortierstraße</h3>
            <hr>
            <h4>
                Steuerung der Druckluft!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonCompressorSortingLine">Druckluft</button>
                </p>
            </form>
            <h4>
                Steuerung der Schieber!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonWhiteSortingLine">Weiß</button>
                    <button name="buttonRedSortingLine">Rot</button>
                    <button name="buttonBlueSortingLine">Blau</button>
                </p>
            </form>
            <h4>
                Steuerung der Kette!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonBeltSortingLine">Förderkette</button>
                </p>
            </form>
        </section>

        <!-- PRODUCTION -->

        <section id="production">
            <h3>Fertigungsstraße</h3>
            <hr>
            <h4>
			Steuerung der Druckluft!
            </h4>
            <form method="post" target="frame">
                <p>
                    <!--
                        <button id="b2" onclick="myFunction()" name="buttonCompressor">Druckluft</button>
                    -->
                        <button id="b1" name="buttonCompressorProcessingStation">Druckluft</button>
                </p>
            </form>
            <h4>
                Steuerung des Ofens!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonOvenLightProcessingStation">Licht des Ofens</button>
                    <button name="buttonOvenGateProcessingStation">Tür des Ofens</button>
                </p>
            </form>
            <h4>
                Steuerung der Kette!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonBeltProcessingStation">Förderkette</button>
                </p>
            </form>
            <h4>
                Steuerung der Säge!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonSawProcessingStation">Säge</button>
                </p>
            </form>
        </section>

        <!-- WAREHOUSE -->

        <section id="warehouse">
            <h3>Hochregallager</h3>
            <hr>
            <h4>
                ToDo...
            </h4>
        </section>
    
        <!-- FOOTER -->

        <footer>
            <p>
                &copy; 2020 / Moris Kotsch / DHBW Stuttgart Campus Horb
            </p>
        </footer>
        <iframe name="frame"></iframe>
    </body>
</html>

<?php   
    // Sorting Line
	if (isset($_POST['buttonCompressorSortingLine']))
	{
        $topic = "/factory/sortingLine";
		$text = "AirCompressor";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonWhiteSortingLine']))
	{
        $topic = "/factory/sortingLine";
		$text = "White";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonRedSortingLine']))
	{
        $topic = "/factory/sortingLine";
		$text = "Red";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonBlueSortingLine']))
	{
        $topic = "/factory/sortingLine";
		$text = "Blue";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonBeltSortingLine']))
	{
        $topic = "/factory/sortingLine";
		$text = "Belt";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
		shell_exec($cmd);
    }

    //Processing Station
    if (isset($_POST['buttonSawProcessingStation']))
	{
        $topic = "/factory/processingStation";
		$text = "Saw";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonCompressorProcessingStation']))
	{
        $topic = "/factory/processingStation";
		$text = "AirCompressor";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
		shell_exec($cmd);
		
		myFunction();
	}
	if (isset($_POST['buttonBeltProcessingStation']))
	{
        $topic = "/factory/processingStation";
		$text = "Belt";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonOvenLightProcessingStation']))
	{
        $topic = "/factory/processingStation";
		$text = "OvenLight";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonOvenGateProcessingStation']))
	{
        $topic = "/factory/processingStation";
		$text = "OvenGate";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SendToFactory.py "'.$topic.'" "'.$text.'"';
		shell_exec($cmd);
	}
?>