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
                    <button name="buttonCompressor">Druckluft</button>
                </p>
            </form>
            <h4>
                Steuerung der Schieber!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonWhite">Weiß</button>
                    <button name="buttonRed">Rot</button>
                    <button name="buttonBlue">Blau</button>
                </p>
            </form>
            <h4>
                Steuerung der Kette!
            </h4>
            <form method="post" target="frame">
                <p>
                    <button name="buttonBelt">Förderkette</button>
                </p>
            </form>
        </section>

        <!-- PRODUCTION -->

        <section id="production">
            <h3>Fertigungsstraße</h3>
            <hr>
            <div id="projects">
                <ul>
                    <li><a href="#"><img src="http://placehold.it/280x170" alt="Projekt_01"></a></li>
                    <li><a href="#"><img src="http://placehold.it/280x170" alt="Projekt_02"></a></li>
                    <li><a href="#"><img src="http://placehold.it/280x170" alt="Projekt_03"></a></li>
                    <li><a href="#"><img src="http://placehold.it/280x170" alt="Projekt_04"></a></li>
                    <li><a href="#"><img src="http://placehold.it/280x170" alt="Projekt_05"></a></li>
                    <li><a href="#"><img src="http://placehold.it/280x170" alt="Projekt_06"></a></li>
                    <li><a href="#"><img src="http://placehold.it/280x170" alt="Projekt_07"></a></li>
                </ul>
            </div>
        </section>

        <!-- WAREHOUSE -->

        <section id="warehouse">
            <h3>Contact</h3>
            <hr>

            <form>
                <input class="input_text" type="email" tabindex="1" placeholder="E-Mail"><br>
                <input class="input_text" type="text" tabindex="2" placeholder="Betreff"><br>
                <textarea class="input_text" tabindex="3" placeholder="Nachricht"></textarea><br>
                <input class="button" type="submit">
            </form>
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
	if (isset($_POST['buttonCompressor']))
	{
		$text = "AirCompressor";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SortingLine.py "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonWhite']))
	{
		$text = "White";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SortingLine.py "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonRed']))
	{
		$text = "Red";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SortingLine.py "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonBlue']))
	{
		$text = "Blue";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SortingLine.py "'.$text.'"';
		shell_exec($cmd);
	}
	if (isset($_POST['buttonBelt']))
	{
		$text = "Belt";
		$cmd = 'sudo python /var/www/html/factoryWebsite/SortingLine.py "'.$text.'"';
		shell_exec($cmd);
	}
?>