<?php

function rentabads_acheter()
{
	function rentabads_pages_acheter()
	{

		echo "<div style=\"padding: 30px 20px 20px 20px; width: 97%; height: 100%;\">";

		if(!empty($_GET['camp']))
		{
			$resnb_rentabads_espace = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . " WHERE data='" . $_GET['camp'] . "'"));
			if($resnb_rentabads_espace == 0)
			{
				echo __("Cette campagne n'existe pas sur ce blog.",'rentabads');
			}
			else
			{
				$tableau_espace = array(@$_GET['camp'], time());
				$data_espace = serialize($tableau_espace);
				$data_espace = base64_encode($data_espace);

				echo "<span class=\"description\">" . __("Vous allez payer la campagne",'rentabads') . " &#171; " . rentabads_get_option(RENTABADS_TABLE_SPACES, "espace_name", "WHERE data='" . $_GET['camp'] . "'") . " &#187; " . __("et afficher votre banni&egrave;re pour une dur&eacute;e de",'rentabads') . " &#171; " . rentabads_get_option(RENTABADS_TABLE_SPACES, "duration", "WHERE data='" . $_GET['camp'] . "'") . " " . __("jours",'rentabads') . " &#187;.</span><br /><br />";
				echo "<iframe src=\"http://payment.rentabiliweb.com/form/acte/form_fb.php?docId=" . rentabads_get_option(RENTABADS_TABLE_SPACES, "doc_id", "WHERE data='" . $_GET['camp'] . "'") . "&siteId=" . rentabads_get_option(RENTABADS_TABLE_SPACES, "site_id", "WHERE data='" . $_GET['camp'] . "'") . "&cnIso=geoip&data=" . $data_espace . "\" frameborder=\"0\" width=\"580\" height=\"330\"></iframe>";
				echo "<br /><span class=\"description\">" . __("Une fois que la transaction sera effectu&eacute;e, vous pourrez configurer votre banni&egrave;re et le lien de votre site/blog.",'rentabads') . "</span>";
				echo "<br /><br />&#187; <a href=\"" . ADMIN_PAGE_PLUGIN . "rentabads_acheter\">" . __("Choisir un autre espace de ventes",'rentabads') . "</a>";
			}
		}
		else
		{

		echo __("Augmentez le trafic de votre site/blog en utilisant un espace de ventes sur ce blog. Les banni&egrave;res s'afficheront sur le blog et les visiteurs pourront cliquer dessus.",'rentabads') . "<br /><br /><br />&#187; <a href=\"" . ADMIN_PAGE_PLUGIN . "rentabads_campagnes\">" . __("Acc&egrave;s &agrave; votre/vos campagne(s)",'rentabads') . "</a><br /><br /><br />";
		echo "<strong>" . __("Liste des espaces publicitaire sur ce blog",'rentabads') . " :</strong><br /><br /><br />";

?>

<table class="widefat" width="500px" cellspacing="0">

<thead>
<tr>
<th scope="col" style=""><?php echo __("Acheter",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Titre",'rentabads'); ?></th>
<?php if(rentabads_get_option(RENTABADS_TABLE_CONFIG, "display_price") == 'yes') { ?><th scope="col" style=""><?php echo __("Tarif",'rentabads'); ?></th><?php } ?>
<th scope="col" style=""><?php echo __("Nombre de campagne",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Dimension",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Dur&eacute;e",'rentabads'); ?></th>
</tr>
</thead>

<tfoot>
<tr>
<th scope="col" style=""><?php echo __("Acheter",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Titre",'rentabads'); ?></th>
<?php if(rentabads_get_option(RENTABADS_TABLE_CONFIG, "display_price") == 'yes') { ?><th scope="col" style=""><?php echo __("Tarif",'rentabads'); ?></th><?php } ?>
<th scope="col" style=""><?php echo __("Nombre de campagne",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Dimension",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Dur&eacute;e",'rentabads'); ?></th>
</tr>
</tfoot>

<tbody>
<?php

$resnb_rentabads_espace = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . ""));

if($resnb_rentabads_espace == 0)
{

?>

<tr>
<td colspan="7"><?php echo __("Aucun espace trouv&eacute;.",'rentabads'); ?></td>
</tr>

<?php

}
else
{

$reponses_rentabads_espaces = mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . " ORDER BY espace_name ASC");
while($source_rentabads_espaces = mysql_fetch_array($reponses_rentabads_espaces))
{

$resnb_rentabads_espace = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE espace_data='" . $source_rentabads_espaces['data'] . "'"));
$resnb_rentabads_espace = ($resnb_rentabads_espace > 1) ? $resnb_rentabads_espace . ' ' . __('campagnes','rentabads') : $resnb_rentabads_espace . ' ' . __('campagne','rentabads');

$nbjour_espace = ($source_rentabads_espaces['duration'] > 1) ? $source_rentabads_espaces['duration'] . ' ' . __('jours','rentabads') : $source_rentabads_espaces['duration'] . ' ' . __('jours','rentabads');

?>

<tr style="height: 40px;">
<td style="padding: 8px;"><a href="admin.php?page=rentabads_acheter&camp=<?php echo $source_rentabads_espaces['data']; ?>"><img src="<?php echo DIRECTORY_PLUGIN; ?>images/acheter_espace.png" style="width: 32px; height: 32px; border: 0;"></a></td>
<td style="padding-top: 14px;"><a href="admin.php?page=rentabads_acheter&camp=<?php echo $source_rentabads_espaces['data']; ?>"><strong><?php echo $source_rentabads_espaces['espace_name']; ?></strong></a></td>
<?php if(rentabads_get_option(RENTABADS_TABLE_CONFIG, "display_price") == 'yes') { ?><td style="padding-top: 14px;"><?php echo $source_rentabads_espaces['price']; ?></td><?php } ?>
<td style="padding-top: 14px;"><?php echo $resnb_rentabads_espace; ?></td>
<td style="padding-top: 14px;"><strong><?php echo $source_rentabads_espaces['size_width']; ?>x<?php echo $source_rentabads_espaces['size_height']; ?></strong></td>
<td style="padding-top: 14px;"><?php echo $nbjour_espace; ?></td>
</tr>

<?php

}

}

?>
</tbody>
</table>

<?php

		echo "</div>";

		}

	}

	function rentabads_pages_acheter_config()
	{

		global $display_name, $user_email, $user_ID;
		get_currentuserinfo();

		$data_espace = htmlentities(trim(@$_GET['data']));
		$data_espace = base64_decode($data_espace);
		$tableau_espace = unserialize($data_espace);

		// Identifiants de votre document
		$docId = rentabads_get_option(RENTABADS_TABLE_SPACES, "doc_id", "WHERE data='" . $tableau_espace[0] . "'");
		$siteId = rentabads_get_option(RENTABADS_TABLE_SPACES, "site_id", "WHERE data='" . $tableau_espace[0] . "'");

		// PHP5 avec register_long_arrays désactivé?
		if (!isset($HTTP_GET_VARS)) {
			$HTTP_SESSION_VARS = $_SESSION;
			$HTTP_SERVER_VARS = $_SERVER;
			$HTTP_GET_VARS = $_GET;
		}

		// Construction de la requête pour vérifier le code

		$query = 'http://payment.rentabiliweb.com/checkcode.php?';
		$query .= 'docId='.$docId;
		$query .= '&siteId='.$siteId;
		$query .= '&code='.$HTTP_GET_VARS['code'];
		$query .= "&REMOTE_ADDR=".$HTTP_SERVER_VARS['REMOTE_ADDR'];
		$result = @file($query);

		if(trim($result[0]) !== "OK") {
			echo "<div style=\"padding: 30px 20px 20px 20px; width: 100%; height: 100%;\">";
			echo __("Patientez...",'rentabads');
			echo "<script type=\"text/javascript\"> window.location = '" . ADMIN_PAGE_PLUGIN . "rentabads_acheter&pay_error'; </script>";
			echo "<meta http-equiv=\"refresh\" content=\"0;url=" . ADMIN_PAGE_PLUGIN . "rentabads_acheter&pay_error\">";
			echo "</div>";
			exit;
		}


			// Accès à votre page protégée

			$title_mail = "[" . get_bloginfo('name') . "] " . __("Voici le r&eacute;sum&eacute; de votre espace publicitaire",'rentabads');
			$message_mail = __("Bonjour,\n\nVous venez d'acheter un espace publicitaire sur",'rentabads') . " " . get_bloginfo('name') . ".\n\n" . __("Voici un rappel de votre espace publicitaire",'rentabads') . " : " . ADMIN_PAGE_PLUGIN . "rentabads_campagnes.\n\n" . __("Cordialement",'rentabads') . ",\n" . get_bloginfo('name');

			mail($user_email, $title_mail, $message_mail);

			$random_campagne = substr(md5(rand()), 0, 10);

			mysql_query("INSERT INTO " . RENTABADS_TABLE_CAMPAIGNS . " (data,user_id,espace_data,time,expire) VALUES('" . $random_campagne . "','" . $user_ID . "','" . rentabads_get_option(RENTABADS_TABLE_SPACES, "data", "WHERE data='" . $tableau_espace[0] . "'") . "','" . time() . "','no')");

			echo "<div style=\"padding: 30px 20px 20px 20px; width: 100%; height: 100%;\">";
			echo __("Merci, votre paiement s'est correctement effectu&eacute;!",'rentabads') . "<br /><br />" . __("Le syst&egrave;me vous a envoy&eacute; le lien de votre espace publicitaire &agrave; cette adresse Email",'rentabads') . " : <strong>" . $user_email . "</strong>.<br /><br />&#187; <a href=\"" . ADMIN_PAGE_PLUGIN . "rentabads_campagnes\">" . __("Acc&egrave;s &agrave; votre/vos campagne(s)",'rentabads') . "</a>";
			echo "</div>";
	}

	function rentabads_pages_acheter_erreur()
	{
		echo "<div style=\"padding: 30px 20px 20px 20px; width: 100%; height: 150px;\">";
		echo "<img src=\"" . DIRECTORY_PLUGIN . "images/erreur_paiement.png\" style=\"width: 128px; height: 128px; float: right; margin-right: 50px;\">";
		echo __("Une erreur est survenue lors de l'achat de l'espace de ventes.",'rentabads') . "<br /><br /><br />" . __("Veuillez contacter",'rentabads') . " :<br /><br /><ul><li type=\"circle\">" . __("l'administrateur de ce blog",'rentabads') . " | <a href=\"" . get_option('siteurl') . "\" target=\"blank\">" . get_option('blogname') . "</a></li><li type=\"circle\">" . __("le service de Micro-paiement",'rentabads') . " | <a href=\"http://www.rentabiliweb.com/\" target=\"blank\">Rentabiliweb.com</a></li><li type=\"circle\">" . __("le cr&eacute;ateur de ce service",'rentabads') . " | <a href=\"http://www.maxence-blog.fr/2011/05/30/plugin-wordpress-rentabiliweb-ads/\" target=\"blank\">Le Blog de Maxence</a></li></ul><br /><a href=\"javascript:history.back(-1);\">" . __("Retour &agrave; la page pr&eacute;c&eacute;dente",'rentabads') ."</a>";
		echo "</div>";
	}

	if(isset($_GET['pay_ok']))
	{
		add_meta_box("rentabiliweb-ads", "<div class=\"icon32\" id=\"icon-options-general\" style=\"margin-top: 0;\"></div> " . __("Configurez votre espace publicitaire",'rentabads'), "rentabads_pages_acheter_config", "rentabads_box_acheter");
	}
	elseif(isset($_GET['pay_error']))
	{
		add_meta_box("rentabiliweb-ads", "<div class=\"icon32\" id=\"icon-options-general\" style=\"margin-top: 0;\"></div> " . __("Une erreur est survenue",'rentabads'), "rentabads_pages_acheter_erreur", "rentabads_box_acheter");
	}
	else
	{
		add_meta_box("rentabiliweb-ads", "<div class=\"icon32\" id=\"icon-options-general\" style=\"margin-top: 0;\"></div> " . __("Acheter un espace publicitaire sur ce blog",'rentabads'), "rentabads_pages_acheter", "rentabads_box_acheter");
	}

    echo "<div class=\"metabox-holder\" style=\"margin-top: 20px;\">";
    echo "<div class=\"inner-sidebar1\">";
	do_meta_boxes("rentabads_box_acheter", "advanced", null);
	echo "</div>";
	echo "</div>";
}

?>