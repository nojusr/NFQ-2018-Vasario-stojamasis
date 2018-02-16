<html>
	<?php
	# init
	$dbname = 'nfq';
	$dbuser = 'root';
	$dbpass = '******';
	$dbhost = 'localhost';
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if ($conn->connect_error){
			die("Connection failed: ". $conn->connect_error);
	}
	?>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">		
		<link rel="stylesheet" href="global.css">
		<link href="https://fonts.googleapis.com/css?family=Cabin|Roboto" rel="stylesheet"> 
		<title>Guminės antys.</title>
	</head>
	<body>
		<div class = "background-tint">
			<div class="wrapper">
				<div class = "main">
					<p class = "title">Guminės antys.</p>
					<div class = "line"></div>
					<p>Pristatome naują guminių ančių pardavimo puslapį! Mes šį puslapį sukūrėme tenkinti didžiulį guminių ančių poreikį. Daugiau nereikės brautis tarp praeivių maksimoje! Dabar jus galėsite sėdėti ant pečiaus, kai mes jums vešime gumines antis. Šios antys yra  lygiai tokio pačio modelio, kurį galima rasti bet kokioje parduotuvėje, tad dėl kokybės galite nesijaudinti. Pirkite dabar!</p>
					<?php
						$query = "SELECT * FROM variables";
						$result = $conn->query($query);
						$prices = $result->fetch_assoc();

						echo "<p  style=\"text-decoration: underline\" >Vienos anties kaina: ".$prices["duck_price"]." Eur</p>";
						echo "<p  style=\"text-decoration: underline\" >Vežimo kaina: ".$prices["shipping_price"]." Eur</p>";
						echo "<div style= \"display: none\" id=\"an_kaina\">".$prices["duck_price"]."</div>";
						echo "<div style= \"display: none\" id=\"s_kaina\">".$prices["shipping_price"]."</div>";;
					?>
					<p>Pirkimo forma:</p>
					<form class="buying_form" action="buy_ducks.php" method="post">
						<table>
							<tr><td>Jusų pilnas vardas:</td><td> <input type="text" id="nam" name="name" required></td></tr>
							<tr><td>Jusų adresas:</td><td> <input type="text" id="adr"  name="addr" required></td></tr>
							<tr><td>Kiek ančių norite pirkti?:</td><td> <input type="number" id="amo" name="amount" required></td></tr>
							<tr><td><input type="submit" value="pirkti!" ></td></tr>
						</table>
					</form>


					<p id="kainos">Galutinė kaina: 0 Eur</p>
					<script type="text/javascript">
						var d_k, s_k, f_k, a, k;
						setInterval(function(){
							d_k = document.getElementById("an_kaina");
							s_k = document.getElementById("s_kaina");
							a = document.getElementById("amo").value;
							f_k = Number(d_k.innerHTML)*a+Number(s_k.innerHTML);
							out = "Galutinė kaina: "+f_k+" Eur";
							k = document.getElementById("kainos");
							k.innerHTML = out;
						}, 1000);
					</script>					
					
					<a href="uzsakymai.php">Užsakymai</a>
				</div>
			</div>
		</div>
	</body>


</html>

