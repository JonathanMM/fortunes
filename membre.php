<?php
include('haut.php');
if($_POST['envoi'] == 1)
{
	$pseudo = htmlspecialchars($_POST['pseudo'], ENT_QUOTES);
	$mdp = hash('sha512', $_POST['mdp']);
	$requete = mysql_query('SELECT * FROM '.$bdd_prefixe.'membre WHERE pseudo = "'.$pseudo.'"');
	$donnees = mysql_fetch_array($requete);
	if($pseudo == $donnees['pseudo'] && $mdp == $donnees['mdp'])
	{
		echo '<div class="align-accueil"><p><i>Connexion réussite.</i></p></div>';
		$_SESSION['co'] = 1;
		$_SESSION['id'] = $donnees['id'];
	}
}

if(isset($_SESSION['co']) && $_SESSION['co'] == 1)
{
?>
<div class="align-accueil"><p>
<a href="deco.php">[Se deconnecter]</a>
</p></div>
<?php
} else {
?>
<div class="align-accueil"><h3>Connexion</h3></div>
<form action="membre.php" method="post">
<div class="align-accueil">
	<span style="padding-right: 51px;">Pseudo : </span><input name="pseudo" /><br />
	Mot de passe : <input type="password" name="mdp" /><br />
	<input type="hidden" name="envoi" value="1" />
	<input type="submit" value="Se connecter" />
</div>
</form>
<div class="align-accueil"><a href="inscription.php">[S'inscrire]</a></div>
<?php
}
include('bas.php');
?>