<html>
	<?php
	# init
	$dbname = 'nfq';
	$dbuser = 'root';
	$dbpass = '*******';
	$dbhost = 'localhost';
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if ($conn->connect_error){
			die("Connection failed: ". $conn->connect_error);
	}
	function prideti($name, $value){
		$params = $_GET;
		unset($params[$name]);
		$params[$name] = $value;
		return basename($_SERVER['PHP_SELF']).'?'.http_build_query($params);
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
					<p class = "title">Užsakymai.</p>
					<div class = "line"></div>
					<table class="search_and_sort" >
						<tr>
							<td colspan = 4 style="line-height: 50px;"> 
								<form action="uzsakymai.php">
									Paieška:
									<select name="s_type">
										<option value="">ieškoti pagal:</option>
										<option value="id">užsakymo numerį </option>
										<option value="vard">vardą</option>
										<option value="addr">adresą</option>
										<option value="amou">užsakymo kiekį</option>
										<option value="kain">kainą</option>
									</select>
									<input type="text" name="s_query"><br>
									Rikiavimas:
									<select name="r_type">
										<option value="">Rikiuoti pagal:</option>
										<option value="id">užsakymo numerį </option>
										<option value="vard">vardą</option>
										<option value="addr">adresą</option>
										<option value="amou">užsakymo dydį</option>
										<option value="kain">kainą</option>
									</select>
									<select name="r_type2">
										<option value="">Pasirinkti rikiavimo tipą</option>
										<option value="desc">didžiausias -> mažiausias</option>
										<option value="asc">mažiausias -> didžiausias</option>
									</select><br>									
									<input type="submit" value="Ieškoti/Rūšiuoti">
								</form>
							</td>
						</tr>
						<tr>
							<td>
								<form action="uzsakymai.php">
									<input type="submit" value="Perkrauti">
								</form>
							</td>
						</tr>
					</table>
					<table class="main_data">
						<tr>
							<td>Užsakymo Numeris</td><td>Kliento Vardas</td><td>Kliento adresas</td><td>Ančių kiekis</td><td>Kaina</td>
						</tr>
						<?php
							#rodome 20 uzsakymu per puslapi
						
							$page = $_GET["page"];
							
							
							$p1 = $page*20;
							
							$limitq = "LIMIT ".$p1.", 20;";
							$query = "SELECT * FROM orders ";
							
							#paieska
							if(isset($_GET["s_type"]) && isset($_GET["s_query"])){
								$option = $_GET["s_type"];
								$search = $_GET["s_query"];
								$search = urldecode($search);
									switch ($option){
											case 'id':
												$query = "SELECT * FROM orders WHERE order_id LIKE '".$search."' ";
												break;
											case 'vard':
												$query = "SELECT * FROM orders WHERE client_name LIKE '".$search."' ";		
												break;
											case 'addr':
												$query = "SELECT * FROM orders WHERE client_addr LIKE '".$search."' ";
												break;		
											case 'amou':
												$query = "SELECT * FROM orders WHERE amount_ordered LIKE '".$search."' ";		
												break;
											case 'kain':
												$query = "SELECT * FROM orders WHERE cost LIKE '".$search."' ";		
												break;																									
									}
								
							}
							#rusiavimas
							if(isset($_GET["r_type"]) && isset($_GET["r_type2"])){
								$option = $_GET["r_type"];
								$option2 = $_GET["r_type2"];
								switch ($option){
										case 'id':
												$sort = " ORDER BY order_id ";
											break;
										case 'vard':
												$sort = " ORDER BY client_name ";
											break;
										case 'addr':
												$sort = " ORDER BY client_addr ";
											break;		
										case 'amou':
												$sort = " ORDER BY amount_ordered" ;
											break;
										case 'kain':
												$sort = " ORDER BY cost ";
											break;																									
								}									
								switch ($option2){
										case 'desc':
												$sort .=" DESC ";
												break;
										case 'asc':
												$sort .=" ASC " ;
												break;
								}
							}
							
							#galutinio query pastatymas
							$fq = $query.$sort.$limitq;
							$result = $conn->query($fq);
							
							#isvestis							
							while($eilute = $result->fetch_assoc()){
								echo "<tr><td>".$eilute["order_id"]."</td><td>".$eilute["client_name"]."</td><td>".$eilute["client_addr"]."</td><td>".$eilute["amount_ordered"]."</td><td>".$eilute["cost"]." Eur</td></tr>";
							}
							
							
							#puslapiavimas
							
							#paimame visus rezultatus be limito ir suskaiciuojame kiek ju bus
							$result = $conn->query($query.$sort);	
							$c = mysqli_num_rows($result);
							
							$d = $c/20;
							$d = ceil($d);
							
							#isvedame puslapius
							echo "<p class=\"pages\"> Puslapiai: ";
							for ($i = 0; $i < $d; $i++){
									$link = prideti("page", $i);
									echo "<a href=\"".$link."\">".($i+1)."</a> ";
							}
							echo "</p>";
							
						?>
					</table>					
					<a href="index.php">Atgal</a>
				</div>
			</div>
		</div>
	</body>


</html>


