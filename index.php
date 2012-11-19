<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" href="style.css" />
		<title>Mon R&eacute;seau IP</title>
	</head>
	<body>
		<?php
			// Connexion à la base de donnée
			$connection = mysql_connect('localhost','login','password');
			mysql_select_db('nom_de_la_bdd');
			// Nom de la table
			$tablename = 'nom_de_la_table';
			// Tri sur colonne
			$tri_autorises = array('num','ip','hostname');
			$order_by = in_array(isset($_GET['order']),$tri_autorises) ? $_GET['order'] : 'num';
			// Sens du tri
			$order_dir = isset($_GET['inverse']) ? 'DESC' : 'ASC';
			// Préparation de la requête pour la liste
			$sql = "
				SELECT *
				FROM {$tablename}
				ORDER BY {$order_by} {$order_dir}
			";
			$result = mysql_query($sql);
			// Fonction qui affiche les liens
			function sort_link($text, $order=false)
				{
					global $order_by, $order_dir;
					if(!$order)
						$order = $text;
						$link = '<a href="?order=' . $order;
					if($order_by==$order && $order_dir=='ASC')
						$link .= '&inverse=true';
						$link .= '"';
					if($order_by==$order && $order_dir=='ASC')
						$link .= ' class="order_asc"';
					elseif($order_by==$order && $order_dir=='DESC')
						$link .= ' class="order_desc"';
						$link .= '>' . $text . '</a>';
					return $link;
				}
		?>
		<div style="left: 55.5px;" id="menu" class="floating">
			<form action="index.php" method="post">
				<p>
				<table>
					<tr>
						<td>
							<label for="addrip"><b>&nbsp;IP</b></label>
						</td>
						<td>
							<input type="text" name="addrip" id="addrip" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="nomarch"><b>&nbsp;Nom</b></label> 
						</td>
						<td>
							<input type="text" name="nomarch" id="nomarch" />
						</td>
					</tr>
				</table>
				<br />
				<center>
					<input type="submit" value="Modifier" />
				</center>
				</p>
			</form>
			<?php
				// Champs de saisie pour les modifications
				if(isset($_POST['addrip']))      $addrip=$_POST['addrip'];
				else     $addrip="";
				if(isset($_POST['nomarch']))   $nomarch=$_POST['nomarch'];
				else     $nomarch="";
				// On vérifie si les champs sont vides
				if(empty($addrip) OR empty($nomarch))
				{
				}
				else     
				{
					$sql2 = "
					UPDATE {$tablename} 
					SET hostname = '$nomarch'
					WHERE ip = '{$addrip}' 
					LIMIT 1 ;
					";
					mysql_query($sql2) or die('Erreur SQL !'.$sql2.'<br>'.mysql_error());
					header('Location: index.php');
				}
			?>
		</div>
		<table class="tb_annuaire">
			<tr style="background-color:#0B59B2">
				<th><?php echo sort_link('&nbsp;@&nbsp;', 'num') ?></th>
				<th><?php echo sort_link('&nbsp;ADRESSE IP&nbsp;', 'ip') ?></th>
				<th><?php echo sort_link('&nbsp;NOM DE LA MACHINE&nbsp;', 'hostname') ?></th>
			</tr>
		<?php while( $row=mysql_fetch_assoc($result) ) : ?>
			<tr style="background-color:<?php global $i; echo (++$i%2==0 ? "#DDE8F6" : "#FFFFFF"); ?>">
				<td><?php echo $row['num'] ?></td>
				<td><?php echo $row['ip'] ?></td>
				<td><?php echo $row['hostname'] ?></td>
			</tr>
		<?php endwhile ?>
		</table>
		<?php mysql_close($connection); ?>
	</body>
</html>