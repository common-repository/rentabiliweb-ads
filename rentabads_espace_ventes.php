<?php

function rentabads_espace_ventes()
{
	function rentabads_pages_espace_ventes()
	{

		echo "<div style=\"padding: 30px 20px 20px 20px; width: 97%; height: 100%;\">";
		if(!empty($_GET['espace_edit']))
		{
			$espace_edit = @$_GET['espace_edit'];
			$resnb_rentabads_espace = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . " WHERE data='" . $espace_edit . "'"));
			if($resnb_rentabads_espace !== 0)
			{
				$source_rentabads_espace = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . " WHERE data='" . $espace_edit . "'"));
?>
<script type="text/javascript">
function valid_option(formu_predef)
{
	formu = formu_predef.elements['taille_predef'].options[formu_predef.elements['taille_predef'].selectedIndex].value;
	form = formu.split('x');
	form_width = form[0];
	form_height = form[1];

	document.getElementById('rentabads_width_id').value = form_width;
	document.getElementById('rentabads_height_id').value = form_height;
}
</script>
&#187; <a href="http://www.rentabiliweb.com/fr/admin/micropayment_manage_acte.php" target="_blank"><?php echo __("Cr&eacute;er un nouveau document",'rentabads'); ?> Rentabiliweb.com</a><br /><br />

<?php if(isset($_GET['d'])){ echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>' . base64_decode($_GET['d']) . '</strong></p></div><br />'; } ?>

<form method="post" action="<?php echo DIRECTORY_PLUGIN; ?>traitement.php?m=edit_espace">
<input type="hidden" value="<?php echo rentabads_get_option(RENTABADS_TABLE_SPACES, "data", "WHERE data='" . $espace_edit . "'"); ?>" name="rentabads_data" />
<table class="form-table">
<tr>
<th><?php echo __('ID du document','rentabads'); ?> (<strong>doc_id</strong>)</th>
<td><input type="text" value="<?php echo rentabads_get_option(RENTABADS_TABLE_SPACES, "doc_id", "WHERE data='" . $espace_edit . "'"); ?>" name="rentabads_doc_id" size="7" maxlength="7" /></td>
</tr>
<tr>
<td colspan="2"><span class="description"><?php echo __("Vous trouverez cet identifiant apr&egrave;s avoir cr&eacute;&eacute; le document de paiement sur Rentabiliweb.com",'rentabads'); ?></span></td>
</tr>
<tr>
<th><?php echo __('ID du site','rentabads'); ?> (<strong>site_id</strong>)</th>
<td><input type="text" value="<?php echo rentabads_get_option(RENTABADS_TABLE_SPACES, "site_id", "WHERE data='" . $espace_edit . "'"); ?>" name="rentabads_site_id" size="7" maxlength="7" /></td>
</tr>
<tr>
<td colspan="2"><span class="description"><?php echo __("Vous trouverez cet identifiant apr&egrave;s avoir cr&eacute;&eacute; le document de paiement sur Rentabiliweb.com",'rentabads'); ?></span></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<th><?php echo __('Tarif au paiement','rentabads'); ?></th>
<td><input type="text" value="<?php echo rentabads_get_option(RENTABADS_TABLE_SPACES, "price", "WHERE data='" . $espace_edit . "'"); ?>" name="rentabads_price" size="7" maxlength="7" /> (0.00&euro;)</td>
</tr>
<tr>
<td colspan="2"><span class="description"><?php echo __("Vous trouverez ce tarif apr&egrave;s avoir cr&eacute;&eacute; le document de paiement sur Rentabiliweb.com",'rentabads'); ?></span></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<th><?php echo __("Nom de cet espace",'rentabads'); ?></th>
<td><input type="text" value="<?php echo rentabads_get_option(RENTABADS_TABLE_SPACES, "espace_name", "WHERE data='" . $espace_edit . "'"); ?>" name="rentabads_name" size="30" maxlength="30" /></td>
</tr>
<tr>
<td colspan="2"><span class="description"><?php echo __("Le nom de l'espace est un peu comme une mini-description.",'rentabads'); ?></span></td>
</tr>
<tr>
<th><?php echo __("Dur&eacute;e de l'affichage",'rentabads'); ?></th>
<td><input type="text" value="<?php echo rentabads_get_option(RENTABADS_TABLE_SPACES, "duration", "WHERE data='" . $espace_edit . "'"); ?>" name="rentabads_duration" size="4" maxlength="4" /> <?php echo __("jours",'rentabads'); ?></td>
</tr>
<tr>
<td colspan="2"><span class="description"><?php echo __("Dur&eacute;e d'affichage des banni&egrave;res dans l'espace.",'rentabads'); ?></span></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<th><?php echo __("Taille pr&eacute;d&eacute;finie",'rentabads'); ?></th>
<td>
<label><select type="text" name="taille_predef" onchange="valid_option(this.form);" style="width: 200px;"><option value="468x60"><?php echo __("Classique",'rentabads'); ?> : 468x60</option><option value="728x90"><?php echo __("M&eacute;ga Banni&egrave;re",'rentabads'); ?> : 728x90</option><option value="300x250"><?php echo __("Pav&eacute;",'rentabads'); ?> : 300x250</option><option value="250x250"><?php echo __("Carr&eacute;",'rentabads'); ?> : 250x250</option><option value="120x600"><?php echo __("Skyscraper",'rentabads'); ?> : 120x600</option><option value="160x600"><?php echo __("Skyscraper",'rentabads'); ?> : 160x600</option><option value="x" selected><?php echo __("Personnalis&eacute;",'rentabads'); ?></option></select></label>
</td>
</tr>
<tr>
<th><?php echo __("Taille en largueur",'rentabads'); ?></th>
<td>
<label><input type="text" value="<?php echo rentabads_get_option(RENTABADS_TABLE_SPACES, "size_width", "WHERE data='" . $espace_edit . "'"); ?>" name="rentabads_width" size="4" maxlength="4" id="rentabads_width_id" /> <?php echo __("pixels",'rentabads'); ?> (px)</label>
</td>
</tr>
<tr>
<th><?php echo __("Taille en longueur",'rentabads'); ?></th>
<td>
<label><input type="text" value="<?php echo rentabads_get_option(RENTABADS_TABLE_SPACES, "size_height", "WHERE data='" . $espace_edit . "'"); ?>" name="rentabads_height" size="4" maxlength="4" id="rentabads_height_id" /> <?php echo __("pixels",'rentabads'); ?> (px)</label>
</td>
</tr>
</table>

<br /><br />

<p class="submit"><input type="submit" name="Submit" value="<?php echo __('Sauvegarder les modifications','rentabads') ?>" /></p>
<p><a href="javascript:history.back(-1);"><?php echo __("Retour &agrave; la page pr&eacute;c&eacute;dente",'rentabads'); ?></a></p>

</form>

<?php
			}
			else
			{
				echo "<p>" . __("Cet espace n'est pas disponible !",'rentabads') . "</p>";
				echo "<p><a href=\"javascript:history.back(-1);\">" . __("Retour &agrave; la page pr&eacute;c&eacute;dente",'rentabads') . "</a></p>";
			}
		}
		else
		{

?>

<?php if(isset($_GET['d'])){ echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>' . base64_decode($_GET['d']) . '</strong></p></div><br />'; } ?>

<form method="post" action="<?php echo DIRECTORY_PLUGIN; ?>traitement.php?m=add_espace">
<p class="submit"><input type="submit" name="Submit" value="<?php echo __("Ajouter un nouvel espace",'rentabads'); ?>" /></p>
</form>

<table class="widefat" width="500px" cellspacing="0">

<thead>
<tr>
<th scope="col" style="width: 0px;"></th>
<th scope="col" style=""><?php echo __("Titre",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Tarif",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Nombre de campagne",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Int&eacute;grer l'espace &agrave; votre th&egrave;me",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Dimension",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Dur&eacute;e",'rentabads'); ?></th>
</tr>
</thead>

<tfoot>
<tr>
<th scope="col" style=""></th>
<th scope="col" style=""><?php echo __("Titre",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Tarif",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Nombre de campagne",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Int&eacute;grer l'espace &agrave; votre th&egrave;me",'rentabads'); ?></th>
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
<td colspan="6"><?php echo __("Aucun espace trouv&eacute;.",'rentabads'); ?></td>
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
<td></td>
<td style="padding-top: 7px;"><span style="font-weight: bold; color: #21759B;"><?php echo $source_rentabads_espaces['espace_name']; ?></span><div class="row-actions"><span class="edit"><a href="admin.php?page=rentabads_espace_ventes&espace_edit=<?php echo $source_rentabads_espaces['data']; ?>"><?php echo __("Modifier",'rentabads'); ?></a> | </span><span class="trash"><a class="submitdelete" href="javascript:if(confirm('Voulez-vous supprimer cet espace (irr&eacute;versible) ?')){ window.location = '<?php echo DIRECTORY_PLUGIN; ?>traitement.php?m=del_espace&data=<?php echo $source_rentabads_espaces['data']; ?>'; }"><?php echo __("Supprimer",'rentabads'); ?></a></span></div></td>
<td style="padding-top: 14px;"><?php echo $source_rentabads_espaces['price']; ?></td>
<td style="padding-top: 14px;"><?php echo $resnb_rentabads_espace; ?></td>
<td style="padding-top: 14px;"><code>&lt;?php get_rentabads('<?php echo $source_rentabads_espaces['data']; ?>'); ?&gt;</code> ou <code>[rentabads]<?php echo $source_rentabads_espaces['data']; ?>[/rentabads]</code></td>
<td style="padding-top: 14px;"><strong><?php echo $source_rentabads_espaces['size_width']; ?>x<?php echo $source_rentabads_espaces['size_height']; ?></strong></td>
<td style="padding-top: 14px;"><?php echo $nbjour_espace; ?></td>
</tr>

<?php

}

}

?>
</tbody>
</table>

<br />

<?php echo __("<p>Les espaces de ventes sont des espaces o&ugrave; vos lecteurs vont pouvoir payer pour ajouter leur banni&egrave;re.<br />Ils devront renouveller le paiement autant de fois qu'ils veulent ajouter de banni&egrave;re.</p>",'rentabads'); ?>
<?php echo __("<p>Sur cette page, vous pouvez <strong>ajouter</strong>, <strong>modifier</strong>, <strong>supprimer</strong>, des espaces de ventes.</p>",'rentabads'); ?>

<?php

		}

		echo "</div>";
	}

	add_meta_box("rentabiliweb-ads", "<div class=\"icon32\" id=\"icon-options-general\" style=\"margin-top: 0;\"></div> " . __("Vos espaces de ventes",'rentabads'), "rentabads_pages_espace_ventes", "rentabads_box_espace_ventes");

    echo "<div class=\"metabox-holder\" style=\"margin-top: 20px;\">";
    echo "<div class=\"inner-sidebar1\">";
	do_meta_boxes("rentabads_box_espace_ventes", "advanced", null);
	echo "</div>";
	echo "</div>";
}

?>