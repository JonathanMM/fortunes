<?php
include('haut.php');
if(!isset($_SESSION['co']) || $_SESSION['co'] == 0)
{
	if($_POST['envoi'] == 1)
	{
		if($_POST['chan'] == '#nolife')
		{
			$pseudo = htmlspecialchars($_POST['pseudo'], ENT_QUOTES);
			if($_POST['mdp'] == $_POST['mdp2'])
			{
				$mdp = hash('sha512', $_POST['mdp']);
				$requete = mysql_query('SELECT * FROM '.$bdd_prefixe.'membre WHERE pseudo = "'.$pseudo.'"');
				if(mysql_num_rows($requete) == 0)
				{
					mysql_query('INSERT INTO '.$bdd_prefixe.'membre (pseudo, mdp) VALUES ("'.$pseudo.'", "'.$mdp.'")');
					echo '<div class="align-accueil"><p><i>Inscription effectué.</i><br /><a href="membre.php">[Se connecter]</a></p></div>';
				} else
				      echo '<div class="align-accueil"><p><i>Le pseudo est déjà pris.</i><br /><a href="inscription.php">[Retentez sa chance]</a></p></div>';
			} else
				echo '<div class="align-accueil"><p><i>Les mots de passe sont différents.</i><br /><a href="inscription.php">[Retentez sa chance]</a></p></div>';
		} else
			echo '<div class="align-accueil"><p><i>Le nom du chan est incorrect.</i><br /><a href="inscription.php">[Retentez sa chance]</a></p></div>';
	} else {
	?>
	<div class="align-accueil"><h3>Inscription</h3></div>
	<form action="inscription.php" method="post">
	<div class="align-accueil">
		<span style="padding-right: 51px;">Pseudo : </span><input name="pseudo" /><br />
		Mot de passe : <input type="password" name="mdp" /><br />
		<span style="padding-right: 13px;">De nouveau : </span><input type="password" name="mdp2" /><br />
		<span style="padding-right: 2px;">Nom du chan : </span><input name="chan" value="#" /><br />
		<input type="hidden" name="envoi" value="1" />
		<input type="submit" value="Se connecter" />
	</div>
	</form>
<?php }
} else
	echo '<div class="align-accueil"><p><i>Déjà inscrit ;)</i><br /><a href="accueil.php">[Avoir honte]</a></p></div>';
include('bas.php');
?>