<?php include('haut.php'); ?>
<div class="align-accueil"><h3>Ajouter une fortune</h3></div>
<?php
if(isset($_POST['envoi']) AND $_POST['envoi'] == 1)
{
	$titre = htmlspecialchars($_POST['titre'], ENT_QUOTES);
	$fortune = nl2br(htmlspecialchars($_POST['fortune'], ENT_QUOTES));

	if(isset($_SESSION['co']) && $_SESSION['co'] == 1)
	{
		$ajout1 = ', proprio';
		$ajout2 = ',"'.$_SESSION['id'].'"';
	} else {
		$ajout1 = ', proprio, code';
		$lettres_chiffres = 'ABCDEF0123456789'; //Liste caracteres
		$lettres_chiffres_melanges = str_shuffle($lettres_chiffres.$lettres_chiffres.$lettres_chiffres.$lettres_chiffres.$lettres_chiffres); //On touille bien
		$alea = substr($lettres_chiffres_melanges, 1, 16);
		$ajout2 = ', 0, "'.$alea.'"';
		$code = ' Le code pour modifier cette fortune est : <b>'.$alea.'</b>';
	}
	mysql_query('INSERT INTO '.$bdd_prefixe.'fortunes (titre, contenu, date'.$ajout1.') VALUES ("'.$titre.'", "'.$fortune.'", "'.time().'"'.$ajout2.')');
	echo '<div class="align-accueil"><p><i>Votre fortune a été ajouté avec succès.'.$code.'</i></p></div>';
}
?>
<div class="align-accueil"><form action="ajout.php" method="post">
Titre : <input style="width: 442px;" name="titre" /><br />
<textarea style="width: 500px; height: 150px;" name="fortune"></textarea><br />
<input type="hidden" name="envoi" value="1" />
<input type="submit" value="Envoyer" />
</form></div>
<?php include('bas.php'); ?>