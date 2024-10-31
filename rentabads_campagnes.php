<?php

function rentabads_campagnes()
{

if(isset($_GET['d'])){ echo '<br /><br /><div id="setting-error-settings_updated" class="updated settings-error"><p><strong>' . base64_decode($_GET['d']) . '</strong></p></div>'; }

	function rentabads_pages_campagnes()
	{

		global $display_name, $user_email, $user_ID;
		get_currentuserinfo();

		echo "<div style=\"padding: 30px 20px 20px 20px; width: 97%; height: 100%;\">";

		if(!empty($_GET['campagne_edit']))
		{
			$resnb_rentabads_campagnes = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE user_id='" . $user_ID . "' AND data='" . $_GET['campagne_edit'] . "'"));
			if($resnb_rentabads_campagnes !== 0)
			{
				$source_rentabads_campagne = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE user_id='" . $user_ID . "' AND data='" . $_GET['campagne_edit'] . "'"));
				$source_rentabads_espaces = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . " WHERE data='" . $source_rentabads_campagne['espace_data'] . "' ORDER BY espace_name ASC"))
?>
<form method="post" action="<?php echo DIRECTORY_PLUGIN; ?>traitement.php?m=edit_campagne" enctype="multipart/form-data">
<input type="hidden" value="<?php echo $_GET['campagne_edit']; ?>" name="rentabads_data" />
<table class="form-table">
<tr>
<th><strong><?php echo __('Espace de ventes','rentabads'); ?></strong></th>
<td>&#171; <span class="description"><?php echo $source_rentabads_espaces['espace_name']; ?> : <?php echo $source_rentabads_espaces['size_width']; ?>x<?php echo $source_rentabads_espaces['size_height']; ?></span> &#187;</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<th scope="row" valign="top"><strong><?php echo __('URL de votre site','rentabads'); ?></strong></th>
<td><input type="text" value="<?php echo $source_rentabads_campagne['link']; ?>" name="rentabads_campagne_link" id="campagne_link" size="70" /> <a style="cursor: pointed;" onclick="window.open(document.getElementById('campagne_link').value);">&#187; <?php echo __("Visiter",'rentabads'); ?></a></td>
</tr>
<tr>
<th scope="row" valign="top"><strong><?php echo __('URL de la banni&egrave;re','rentabads'); ?></strong></th>
<td><input type="text" value="<?php echo $source_rentabads_campagne['image']; ?>" name="rentabads_campagne_image" id="campagne_image" size="70" /> <a style="cursor: pointed;" onclick="window.open(document.getElementById('campagne_image').value);">&#187; <?php echo __("Visiter",'rentabads'); ?></a></td>
</tr>
<?php if(rentabads_get_option(RENTABADS_TABLE_CONFIG, "allow_upload") == 'yes') { ?><tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2"><span class="description"><?php echo __("Vous pouvez h&eacute;berger votre banni&egrave;re sur ce blog si elle n'est pas sur votre serveur.",'rentabads'); ?></span></td>
</tr>
<tr>
<th scope="row" valign="top"><strong><?php echo __('Banni&egrave;re sur votre PC','rentabads'); ?></strong></th>
<td>
<input type="file" name="rentabads_upload" size="60" />
</td>
</tr><?php } ?>
</table>

<br /><br />

<p class="submit"><input type="submit" name="Submit" value="<?php echo __('Sauvegarder les modifications','rentabads'); ?>" /></p>

</form>

<br /><br /><br /><br />

<?php
			}
			else
			{
				echo __("Cette campagne n'existe pas",'rentabads') . ".<br /><br />&#187; <a href=\"" . ADMIN_PAGE_PLUGIN . "rentabads_campagnes\">" . __("Acc&egrave;s &agrave; votre/vos campagne(s)",'rentabads') . "</a>";
			}
		}
		elseif(!empty($_GET['campagne_edit_admin']))
		{
			if(current_user_can('administrator') == 1)
			{
				$resnb_rentabads_campagnes = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE data='" . $_GET['campagne_edit_admin'] . "'"));
				if($resnb_rentabads_campagnes !== 0)
				{
					$source_rentabads_campagne = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE data='" . $_GET['campagne_edit_admin'] . "'"));
					$source_rentabads_espaces = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . " WHERE data='" . $source_rentabads_campagne['espace_data'] . "' ORDER BY espace_name ASC"))
?>
<form method="post" action="<?php echo DIRECTORY_PLUGIN; ?>traitement.php?m=edit_campagne_admin" enctype="multipart/form-data">
<input type="hidden" value="<?php echo $_GET['campagne_edit_admin']; ?>" name="rentabads_data" />
<table class="form-table">
<tr>
<th><strong><?php echo __('Espace de ventes','rentabads'); ?></strong></th>
<td>&#171; <span class="description"><?php echo $source_rentabads_espaces['espace_name']; ?> : <?php echo $source_rentabads_espaces['size_width']; ?>x<?php echo $source_rentabads_espaces['size_height']; ?></span> &#187;</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<th scope="row" valign="top"><strong><?php echo __('URL de votre site','rentabads'); ?></strong></th>
<td><input type="text" value="<?php echo $source_rentabads_campagne['link']; ?>" name="rentabads_campagne_link" id="campagne_link" size="70" /> <a style="cursor: pointed;" onclick="window.open(document.getElementById('campagne_link').value);">&#187; <?php echo __("Visiter",'rentabads'); ?></a></td>
</tr>
<tr>
<th scope="row" valign="top"><strong><?php echo __('URL de la banni&egrave;re','rentabads'); ?></strong></th>
<td><input type="text" value="<?php echo $source_rentabads_campagne['image']; ?>" name="rentabads_campagne_image" id="campagne_image" size="70" /> <a style="cursor: pointed;" onclick="window.open(document.getElementById('campagne_image').value);">&#187; <?php echo __("Visiter",'rentabads'); ?></a></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2"><span class="description"><?php echo __("Vous pouvez h&eacute;berger votre banni&egrave;re sur ce blog si elle n'est pas sur votre serveur.",'rentabads'); ?></span></td>
</tr>
<tr>
<th scope="row" valign="top"><strong><?php echo __('Banni&egrave;re sur votre PC','rentabads'); ?></strong></th>
<td>
<input type="file" name="rentabads_upload" size="60" />
</td>
</tr>
</table>

<br /><br />

<p class="submit"><input type="submit" name="Submit" value="<?php echo __('Sauvegarder les modifications','rentabads'); ?>" /></p>

</form>

<br /><strong><?php echo __("Attention! Si votre banni&egrave;re ne respecte pas les dimensions de l'espace de ventes du blog, elle sera d&eacute;form&eacute; et s'affichera mal !",'rentabads'); ?></strong>

<br /><br /><br /><br />

<?php
				}
				else
				{
					echo __("Cette campagne n'existe pas",'rentabads') . ".<br /><br />&#187; <a href=\"" . ADMIN_PAGE_PLUGIN . "rentabads_campagnes\">" . __("Acc&egrave;s &agrave; votre/vos campagne(s)",'rentabads') . "</a>";
				}
			}
			else
			{
				echo __("Cette campagne n'existe pas",'rentabads') . ".<br /><br />&#187; <a href=\"" . ADMIN_PAGE_PLUGIN . "rentabads_campagnes\">" . __("Acc&egrave;s &agrave; votre/vos campagne(s)",'rentabads') . "</a>";
			}
		}
		else
		{

?>

<table class="widefat" cellspacing="0">

<thead>
<tr>
<th scope="col" style="width: 100px;"></th>
<th scope="col" style=""><?php echo __("Titre",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Dimension",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Nombre d'affichage",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Nombre de clic",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Date de cr&eacute;ation",'rentabads'); ?></th>
</tr>
</thead>

<tfoot>
<tr>
<th scope="col" style="width: 100px;"></th>
<th scope="col" style=""><?php echo __("Titre",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Dimension",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Nombre d'affichage",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Nombre de clic",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Date de cr&eacute;ation",'rentabads'); ?></th>
</tr>
</tfoot>

<tbody>
<?php

$resnb_rentabads_campagnes = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE user_id='" . $user_ID . "'"));

if($resnb_rentabads_campagnes == 0)
{

?>

<tr>
<td colspan="6"><?php echo __("Vous n'avez pas encore de campagnes",'rentabads'); ?> &#187; <a href="<?php echo ADMIN_PAGE_PLUGIN; ?>rentabads_acheter"><?php echo __('Ajoutez-en une','rentabads'); ?></a>.</td>
</tr>

<?php

}
else
{

$reponses_rentabads_campagnes = mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE user_id='" . $user_ID . "' ORDER BY id DESC");
while($source_rentabads_campagnes = mysql_fetch_array($reponses_rentabads_campagnes))
{

$source_rentabads_espaces = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . " WHERE data='" . $source_rentabads_campagnes['espace_data'] . "'"));

$resnb_rentabads_espace = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE espace_data='" . $source_rentabads_campagnes['data'] . "'"));
$resnb_rentabads_espace = ($resnb_rentabads_espace > 1) ? $resnb_rentabads_espace . ' campagnes' : $resnb_rentabads_espace . ' campagne';

$nblecture = ($source_rentabads_campagnes['nb_lecture'] > 1) ? $source_rentabads_campagnes['nb_lecture'] . ' ' . __('affichages','rentabads') : $source_rentabads_campagnes['nb_lecture'] . ' ' . __('affichage','rentabads');
$nbclic = ($source_rentabads_campagnes['nb_clic'] > 1) ? $source_rentabads_campagnes['nb_clic'] . ' ' . __('clics','rentabads') : $source_rentabads_campagnes['nb_clic'] . ' ' . __('clic','rentabads');

$image_banniere = $source_rentabads_campagnes['image'];
if(strlen($image_banniere) > 40){
$image_banniere = substr($image_banniere, 0, 20) . '[...]' . substr($image_banniere, -10, 100); }

$link_banniere = $source_rentabads_campagnes['link'];
if(strlen($link_banniere) > 40){
$link_banniere = substr($link_banniere, 0, 20) . '[...]' . substr($link_banniere, -10, 100); }

$ifexpire = (time() >= ($source_rentabads_campagnes['time']+(60*60*24*$source_rentabads_espaces['duration']))) ? '<br /><span style="font-weight: bold; color: #FF0000;">' . __('Campagne expir&eacute;e','rentabads') . '</span>' : '';

if(empty($source_rentabads_campagnes['image']) OR empty($source_rentabads_campagnes['link']) OR empty($source_rentabads_campagnes['espace_data']))
{

?>

<tr style="height: 40px;">
<td style="padding: 8px;"><a href="admin.php?page=rentabads_campagnes&campagne_edit=<?php echo $source_rentabads_campagnes['data']; ?>"><img src="<?php echo DIRECTORY_PLUGIN; ?>images/modifier_espace.png" style="width: 32px; height: 32px; border: 0;"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm('<?php echo __('Voulez-vous supprimer cette campagne (irr&eacute;versible) ?','rentabads'); ?>')){ window.location = '<?php echo DIRECTORY_PLUGIN; ?>traitement.php?m=del_campagne&data=<?php echo $source_rentabads_campagnes['data']; ?>'; }"><img src="<?php echo DIRECTORY_PLUGIN; ?>images/supprimer_espace.png" style="width: 32px; height: 32px; border: 0;"></a></td>
<td style="padding-top: 16px;" colspan="2"><span style="font-weight: bold; color: #FF0000;"><?php echo __('Campagne non configur&eacute;e','rentabads'); ?></span></td>
<td style="padding-top: 16px;"><?php echo $nblecture; ?></td>
<td style="padding-top: 16px;"><?php echo $nbclic; ?></td>
<td style="padding-top: 16px;"><?php echo date('d-m-Y H:i:s', $source_rentabads_campagnes['time']); ?></td>
</tr>

<?php

}
else
{

?>

<tr style="height: 40px;">
<td style="padding: 8px;"><a href="admin.php?page=rentabads_campagnes&campagne_edit=<?php echo $source_rentabads_campagnes['data']; ?>"><img src="<?php echo DIRECTORY_PLUGIN; ?>images/modifier_espace.png" style="width: 32px; height: 32px; border: 0;"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm('<?php echo __('Voulez-vous supprimer cette campagne (irr&eacute;versible) ?','rentabads'); ?>')){ window.location = '<?php echo DIRECTORY_PLUGIN; ?>traitement.php?m=del_campagne&data=<?php echo $source_rentabads_campagnes['data']; ?>'; }"><img src="<?php echo DIRECTORY_PLUGIN; ?>images/supprimer_espace.png" style="width: 32px; height: 32px; border: 0;"></a></td>
<td style="padding-top: 9px;"><a href="<?php echo $source_rentabads_campagnes['link']; ?>" target="_blank"><strong><?php echo $link_banniere; ?></strong></a><br /><a href="<?php echo $source_rentabads_campagnes['image']; ?>" target="_blank"><?php echo $image_banniere; ?></a></td>
<td style="padding-top: 16px;"><strong><?php echo $source_rentabads_espaces['size_width']; ?>x<?php echo $source_rentabads_espaces['size_height']; ?></strong></td>
<td style="padding-top: 16px;"><?php echo $nblecture; ?></td>
<td style="padding-top: 16px;"><?php echo $nbclic; ?></td>
<td style="padding-top: 16px;"><?php echo date('d-m-Y H:i:s', $source_rentabads_campagnes['time']) . $ifexpire; ?></td>
</tr>

<?php

}

}

}

?>
</tbody>
</table>

<?php

			echo "</div>";

		}
	}

	add_meta_box("rentabiliweb-ads", "<div class=\"icon32\" id=\"icon-options-general\" style=\"margin-top: 0;\"></div> " . __('Vos espaces de ventes achet&eacute;s','rentabads'), "rentabads_pages_campagnes", "rentabads_box_campagnes");

    echo "<div class=\"metabox-holder\" style=\"margin-top: 20px;\">";
    echo "<div class=\"inner-sidebar1\">";
	do_meta_boxes("rentabads_box_campagnes", "advanced", null);
	echo "</div>";
	echo "</div>";

if(current_user_can('administrator') == 1 AND !isset($_GET['campagne_edit']) AND !isset($_GET['campagne_edit_admin']))
{
	function rentabads_pages_ventes()
	{

		echo "<div style=\"padding: 30px 20px 20px 20px; width: 97%; height: 100%;\">";
?>
<table class="widefat" cellspacing="0">

<thead>
<tr>
<th scope="col" style="width: 100px;"></th>
<th scope="col" style=""><?php echo __("Titre",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Dimension",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Utilisateur",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Nombre d'affichage",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Nombre de clic",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Date de cr&eacute;ation",'rentabads'); ?></th>
</tr>
</thead>

<tfoot>
<tr>
<th scope="col" style="width: 100px;"></th>
<th scope="col" style=""><?php echo __("Titre",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Dimension",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Utilisateur",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Nombre d'affichage",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Nombre de clic",'rentabads'); ?></th>
<th scope="col" style=""><?php echo __("Date de cr&eacute;ation",'rentabads'); ?></th>
</tr>
</tfoot>

<tbody>
<?php

$resnb_rentabads_campagnes = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . ""));

if($resnb_rentabads_campagnes == 0)
{

?>

<tr>
<td colspan="6"><?php echo __("Vous n'avez pas encore de campagnes",'rentabads'); ?> &#187; <a href="<?php echo ADMIN_PAGE_PLUGIN; ?>rentabads_acheter"><?php echo __("Ajoutez-en une",'rentabads'); ?></a>.</td>
</tr>

<?php

}
else
{

$reponses_rentabads_campagnes = mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " ORDER BY id DESC");
while($source_rentabads_campagnes = mysql_fetch_array($reponses_rentabads_campagnes))
{

$user_info_espaces = get_userdata($source_rentabads_campagnes['user_id']);
$utilisateur = $user_info_espaces->user_login;

$source_rentabads_espaces = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . " WHERE data='" . $source_rentabads_campagnes['espace_data'] . "'"));

$resnb_rentabads_espace = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE espace_data='" . $source_rentabads_campagnes['data'] . "'"));
$resnb_rentabads_espace = ($resnb_rentabads_espace > 1) ? $resnb_rentabads_espace . ' campagnes' : $resnb_rentabads_espace . ' campagne';

$nblecture = ($source_rentabads_campagnes['nb_lecture'] > 1) ? $source_rentabads_campagnes['nb_lecture'] . ' ' . __('affichages','rentabads') : $source_rentabads_campagnes['nb_lecture'] . ' ' . __('affichage','rentabads');
$nbclic = ($source_rentabads_campagnes['nb_clic'] > 1) ? $source_rentabads_campagnes['nb_clic'] . ' ' . __('clics','rentabads') : $source_rentabads_campagnes['nb_clic'] . ' ' . __('clic','rentabads');

$link_banniere = $source_rentabads_campagnes['link'];
if(strlen($link_banniere) > 40){
$link_banniere = substr($link_banniere, 0, 20) . '[...]' . substr($link_banniere, -10, 100); }

$image_banniere = $source_rentabads_campagnes['image'];
if(strlen($image_banniere) > 40){
$image_banniere = substr($image_banniere, 0, 20) . '[...]' . substr($image_banniere, -10, 100); }

$ifexpire = (time() >= ($source_rentabads_campagnes['time']+(60*60*24*$source_rentabads_espaces['duration']))) ? '<br /><span style="font-weight: bold; color: #FF0000;">' . __('Campagne expir&eacute;e','rentabads') . '</span>' : '';

if(empty($source_rentabads_campagnes['image']) OR empty($source_rentabads_campagnes['link']) OR empty($source_rentabads_campagnes['espace_data']))
{

?>

<tr style="height: 40px;">
<td style="padding: 8px;"><a href="admin.php?page=rentabads_campagnes&campagne_edit_admin=<?php echo $source_rentabads_campagnes['data']; ?>"><img src="<?php echo DIRECTORY_PLUGIN; ?>images/modifier_espace.png" style="width: 32px; height: 32px; border: 0;"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm('Voulez-vous supprimer cette campagne (irr&eacute;versible) ?')){ window.location = '<?php echo DIRECTORY_PLUGIN; ?>traitement.php?m=del_campagne_admin&data=<?php echo $source_rentabads_campagnes['data']; ?>'; }"><img src="<?php echo DIRECTORY_PLUGIN; ?>images/supprimer_espace.png" style="width: 32px; height: 32px; border: 0;"></a></td>
<td style="padding-top: 16px;" colspan="2"><span style="font-weight: bold; color: #FF0000;"><?php echo __("Campagne non configur&eacute;e",'rentabads'); ?></span></td>
<td style="padding-top: 16px;"><a href="<?php echo ADMIN_PAGE; ?>user-edit.php?user_id=<?php echo $source_rentabads_campagnes['user_id']; ?>"><strong><?php echo $utilisateur; ?></strong></a></td>
<td style="padding-top: 16px;"><?php echo $nblecture; ?></td>
<td style="padding-top: 16px;"><?php echo $nbclic; ?></td>
<td style="padding-top: 16px;"><?php echo date('d-m-Y H:i:s', $source_rentabads_campagnes['time']); ?></td>
</tr>

<?php

}
else
{

?>

<tr style="height: 40px;">
<td style="padding: 8px;"><a href="admin.php?page=rentabads_campagnes&campagne_edit_admin=<?php echo $source_rentabads_campagnes['data']; ?>"><img src="<?php echo DIRECTORY_PLUGIN; ?>images/modifier_espace.png" style="width: 32px; height: 32px; border: 0;"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm('Voulez-vous supprimer cette campagne (irr&eacute;versible) ?')){ window.location = '<?php echo DIRECTORY_PLUGIN; ?>traitement.php?m=del_campagne_admin&data=<?php echo $source_rentabads_campagnes['data']; ?>'; }"><img src="<?php echo DIRECTORY_PLUGIN; ?>images/supprimer_espace.png" style="width: 32px; height: 32px; border: 0;"></a></td>
<td style="padding-top: 9px;"><a href="<?php echo $source_rentabads_campagnes['link']; ?>" target="_blank"><strong><?php echo $link_banniere; ?></strong></a><br /><a href="<?php echo $source_rentabads_campagnes['image']; ?>" target="_blank"><?php echo $image_banniere; ?></a></td>
<td style="padding-top: 16px;"><strong><?php echo $source_rentabads_espaces['size_width']; ?>x<?php echo $source_rentabads_espaces['size_height']; ?></strong></td>
<td style="padding-top: 16px;"><a href="<?php echo ADMIN_PAGE; ?>user-edit.php?user_id=<?php echo $source_rentabads_campagnes['user_id']; ?>"><strong><?php echo $utilisateur; ?></strong></a></td>
<td style="padding-top: 16px;"><?php echo $nblecture; ?></td>
<td style="padding-top: 16px;"><?php echo $nbclic; ?></td>
<td style="padding-top: 16px;"><?php echo date('d-m-Y H:i:s', $source_rentabads_campagnes['time']) . $ifexpire; ?></td>
</tr>

<?php

}

}

}

?>
</tbody>
</table>
<?php

		echo "</div>";
	}

	add_meta_box("rentabiliweb-ads", "<div class=\"icon32\" id=\"icon-options-general\" style=\"margin-top: 0;\"></div> " . __("Les ventes effectu&eacute;s sur ce blog",'rentabads'), "rentabads_pages_ventes", "rentabads_box_ventes");

    echo "<div class=\"metabox-holder\" style=\"margin-top: 20px;\">";
    echo "<div class=\"inner-sidebar1\">";
	do_meta_boxes("rentabads_box_ventes", "advanced", null);
	echo "</div>";
	echo "</div>";
}

}

?>