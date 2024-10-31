<?php

function rentabads_config()
{
	function rentabads_pages_config()
	{
		echo "<div style=\"padding: 30px 20px 20px 20px; width: 100%; height: 100%;\">";
?>

<?php if(isset($_GET['d'])){ echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>' . base64_decode($_GET['d']) . '</strong></p></div><br />'; } ?>
<?php echo rentabads_get_option(RENTABADS_TABLE_CONFIG, "allow_upload"); ?>
<form method="post" action="<?php echo DIRECTORY_PLUGIN; ?>traitement.php?m=config">
<input type="hidden" value="<?php echo rentabads_get_option(RENTABADS_TABLE_SPACES, "data", "WHERE data='" . $espace_edit . "'"); ?>" name="rentabads_data" />
<table class="form-table">
<tr>
<th><?php echo __("Upload de banni&egrave;res",'rentabads'); ?></th>
<td><label><input type="checkbox" value="yes" <?php if(rentabads_get_option(RENTABADS_TABLE_CONFIG, "allow_upload") == 'yes'){ echo 'checked'; } ?> name="rentabads_allow_upload" /> <?php echo __("Autoriser l'upload des banni&egrave;res sur votre blog",'rentabads'); ?></label></td>
</tr>
<tr>
<td colspan="2"><span class="description"><?php echo __("N'oubliez pas de changer le CHMOD du r&eacute;pertoire <code>rantabiliweb-ads/upbans</code> en <code>0777</code>.",'rentabads'); ?></span></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<th><?php echo __('Affichage du tarif','rentabads'); ?></th>
<td><label><input type="checkbox" value="yes" <?php if(rentabads_get_option(RENTABADS_TABLE_CONFIG, "display_price") == 'yes'){ echo 'checked'; } ?> name="rentabads_display_price" /> <?php echo __("Autoriser l'affichage du tarif dans la liste des espaces de ventes disponible",'rentabads'); ?></label></td>
</tr>
</table>

<br /><br />

<p class="submit"><input type="submit" name="Submit" value="<?php echo __('Sauvegarder les modifications','rentabads') ?>" /></p>
<p><a href="javascript:history.back(-1);"><?php echo __("Retour &agrave; la page pr&eacute;c&eacute;dente",'rentabads'); ?></a></p>

</form>
<?php
		echo "</div>";
	}

	add_meta_box("rentabiliweb-ads", "<div class=\"icon32\" id=\"icon-options-general\" style=\"margin-top: 0;\"></div> " . __("Configuration de Rentabiliweb Ads",'rentabads'), "rentabads_pages_config", "rentabads_box_config");

    echo "<div class=\"metabox-holder\" style=\"margin-top: 20px;\">";
    echo "<div class=\"inner-sidebar1\">";
	do_meta_boxes("rentabads_box_config", "advanced", null);
	echo "</div>";
	echo "</div>";

	function rentabads_pages_install()
	{
		echo "<div style=\"padding: 30px 20px 20px 20px; width: 100%; height: 100%;\">";
?>
<table>
<tr>
<td style="padding-right: 20px; width: 470px;">

<p><?php echo __('Les URL suivantes doivent &ecirc;tre utilis&eacute; pour cr&eacute;er le document n&eacute;cessaire &agrave; <strong>Rentabiliweb Ads</strong>','rentabads'); ?> &#187; <a href="http://www.rentabiliweb.com/fr/admin/micropayment_manage_acte.php" target="_blank"><?php echo __("Cr&eacute;er un nouveau document",'rentabads'); ?> Rentabiliweb.com</a></p>

<p>
<fieldset style="border: 1px solid #C6C6C6; padding: 10px; width: 450px;">
<legend style="padding-left: 10px; padding-right: 10px;"><?php echo __("Url de la page d'acc&egrave;s",'rentabads'); ?> :</legend>
<textarea cols="60" rows="2"><?php echo ADMIN_PAGE_PLUGIN; ?>rentabads_acheter</textarea>
</fieldset><br />

<fieldset style="border: 1px solid #C6C6C6; padding: 10px; width: 450px;">
<legend style="padding-left: 10px; padding-right: 10px;"><?php echo __("Url de la page prot&eacute;g&eacute;e",'rentabads'); ?> :</legend>
<textarea cols="60" rows="2"><?php echo ADMIN_PAGE_PLUGIN; ?>rentabads_acheter&pay_ok</textarea>
</fieldset><br />

<fieldset style="border: 1px solid #C6C6C6; padding: 10px; width: 450px;">
<legend style="padding-left: 10px; padding-right: 10px;"><?php echo __("Url de la page d'erreur",'rentabads'); ?> :</legend>
<textarea cols="60" rows="2"><?php echo ADMIN_PAGE_PLUGIN; ?>rentabads_acheter&pay_error</textarea>
</fieldset>
</p>

</td>
<td style="border-left: 1px solid #C6C6C6; padding-left: 20px; vertical-align: top;">

<p style="width: 500px;"><?php echo __('Pour trouver le <strong>doc_id</strong> et <strong>site_id</strong>, vous devez avoir cr&eacute;&eacute; un document sur <a href="http://www.rentabiliweb.com/" target="_blank">Rentabiliweb.com</a>. Apr&egrave;s la cr&eacute;ation du document, allez sur la page du script de votre document et r&eacute;cup&eacute;rez seulement les num&eacute;ros de code <strong>doc_id</strong> et <strong>site_id</strong> puis collez-les &agrave; gauche sur cette page.','rentabads'); ?></p>
<p><a href="<?php echo DIRECTORY_PLUGIN; ?>images/exemple_code.jpg" target="_blank"><img src="<?php echo DIRECTORY_PLUGIN; ?>images/exemple_code.jpg" width="500px" border="0" /></a></p>

</td>
</tr>
</table>

<br /><br />

<p><strong><?php echo __('Vous pouvez aussi lire ce tutoriel sur l\'installation compl&egrave;te de ce plugin.','rentabads'); ?></strong></p>
<p>&#187; <a href="http://www.maxence-blog.fr/2011/06/01/tutoriel-dinstallation-du-plugin-rentabiliweb-ads-sur-wordpress&help_support_rentabiliweb_ads" target="_blank">http://www.maxence-blog.fr/2011/06/01/tutoriel-dinstallation-du-plugin-rentabiliweb-ads-sur-wordpress</a></p>
<?php
		echo "</div>";
	}

	add_meta_box("rentabiliweb-ads", "<div class=\"icon32\" id=\"icon-options-general\" style=\"margin-top: 0;\"></div> " . __("Informations de Rentabiliweb Ads",'rentabads'), "rentabads_pages_install", "rentabads_box_install");

    echo "<div class=\"metabox-holder\" style=\"margin-top: 20px;\">";
    echo "<div class=\"inner-sidebar1\">";
	do_meta_boxes("rentabads_box_install", "advanced", null);
	echo "</div>";
	echo "</div>";
}

?>