<?php

require_once('../../../wp-load.php');

if(is_user_logged_in() != 1)
{
	echo __('Vous devez &ecirc;tre connect&eacute; !','rentabads');
	exit;
}

if(!empty($_GET['m']))
{


	if($_GET['m'] == 'config')
	{

		if(isset($_POST['rentabads_allow_upload'])){ $rentabads_allow_upload = 'yes'; }else{ $rentabads_allow_upload = 'no'; }
		if(isset($_POST['rentabads_display_price'])){ $rentabads_display_price = 'yes'; }else{ $rentabads_display_price = 'no'; }

		mysql_query("UPDATE " . RENTABADS_TABLE_CONFIG . " SET allow_upload='$rentabads_allow_upload', display_price='$rentabads_display_price'");

		$msg = __('Rentabiliweb Ads a correctement &eacute;t&eacute; modifi&eacute; !','rentabads');
		header("Location: ../../../wp-admin/options-general.php?page=rentabads_config&d=" . base64_encode($msg));
		exit;

	}


	if($_GET['m'] == 'del_espace')
	{

		global $display_name, $user_email, $user_ID;
		get_currentuserinfo();

		$rentabads_data = htmlentities(trim($_GET['data']));

		$resnb_rentabads_campagne = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE espace_data='" . $rentabads_data . "'"));
		if($resnb_rentabads_campagne == 0)
		{
			mysql_query("DELETE FROM " . RENTABADS_TABLE_SPACES . " WHERE data='" . $rentabads_data . "'");

			$msg = __("L'espace de ventes a &eacute;t&eacute; supprim&eacute; !",'rentabads');
			header("Location: ../../../wp-admin/admin.php?page=rentabads_espace_ventes&d=" . base64_encode($msg));
			exit;
		}
		else
		{
			$msg = "L'espace de ventes ne peut pas être supprim&eacute; car il n'est pas vide !";
			header("Location: ../../../wp-admin/admin.php?page=rentabads_espace_ventes&d=" . base64_encode($msg));
			exit;
		}

	}


	if($_GET['m'] == 'del_campagne')
	{

		global $display_name, $user_email, $user_ID;
		get_currentuserinfo();

		$rentabads_data = htmlentities(trim($_GET['data']));

		mysql_query("DELETE FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE user_id='" . $user_ID . "' AND data='" . $rentabads_data . "'");

		$msg = __("La campagne a &eacute;t&eacute; supprim&eacute; !",'rentabads');
		header("Location: ../../../wp-admin/admin.php?page=rentabads_campagnes&d=" . base64_encode($msg));
		exit;

	}


	if($_GET['m'] == 'del_campagne_admin')
	{

		if(current_user_can('administrator') == 1)
		{

		global $display_name, $user_email, $user_ID;
		get_currentuserinfo();

		$rentabads_data = htmlentities(trim($_GET['data']));

		mysql_query("DELETE FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE data='" . $rentabads_data . "'");

		}

		$msg = __("La campagne a &eacute;t&eacute; supprim&eacute; !",'rentabads');
		header("Location: ../../../wp-admin/admin.php?page=rentabads_campagnes&d=" . base64_encode($msg));
		exit;

	}


	if($_GET['m'] == 'edit_campagne_admin')
	{

		global $display_name, $user_email, $user_ID;
		get_currentuserinfo();

		$rentabads_data = htmlentities(trim($_POST['rentabads_data']));
		$rentabads_campagne_link = htmlentities(trim($_POST['rentabads_campagne_link']));
		$rentabads_campagne_image = htmlentities(trim($_POST['rentabads_campagne_image']));

		$extension = strrchr($_FILES['rentabads_upload']['name'], '.');
		$extension = substr($extension, 1);
		$extension = strtolower($extension);

		if(!empty($_FILES['rentabads_upload']['tmp_name']))
		{
			if($_FILES['rentabads_upload']['error'])
			{
				switch($_FILES['rentabads_upload']['error'])
				{

					case 1:
						$msg = __("Le fichier d&eacute;passe la limite autoris&eacute;e par le serveur !",'rentabads');
					break;

					case 2:
						$msg = __("Le fichier d&eacute;passe la limite autoris&eacute;e dans le formulaire HTML !",'rentabads');
					break;

					case 3:
						$msg = __("L'envoi du fichier a &eacute;t&eacute; interrompu pendant le transfert !",'rentabads');
					break;

					case 4:
						$msg = __("Le fichier que vous avez envoy&eacute; a une taille nulle !",'rentabads');
					break;

				}

				header("Location: ../../../wp-admin/admin.php?page=rentabads_campagnes&d=" . base64_encode($msg));
				exit;
			}
			elseif(!in_array($extension, $array_file_allow))
			{
				$msg = __("Veuillez s&eacute;lectionner un type d'image diff&eacute;rent !",'rentabads');
				header("Location: ../../../wp-admin/admin.php?page=rentabads_campagnes&d=" . base64_encode($msg));
				exit;
			}
			else
			{

				$repertoire = 'upbans/';

				if((isset($_FILES['rentabads_upload']['tmp_name']) && ($_FILES['rentabads_upload']['error'] == UPLOAD_ERR_OK)))
				{
					$link_banniere = $repertoire . time() . rand() . '_' . $_FILES['rentabads_upload']['name'];
					move_uploaded_file($_FILES['rentabads_upload']['tmp_name'], $link_banniere);
					$rentabads_campagne_image = DIRECTORY_PLUGIN . $link_banniere;
				}

			}
		}

		mysql_query("UPDATE " . RENTABADS_TABLE_CAMPAIGNS . " SET link='" . $rentabads_campagne_link . "', image='" . $rentabads_campagne_image . "' WHERE data='" . $rentabads_data . "'");

		$msg = __("La campagne a &eacute;t&eacute; &eacute;dit&eacute; !",'rentabads');
		header("Location: ../../../wp-admin/admin.php?page=rentabads_campagnes&d=" . base64_encode($msg));
		exit;

	}


	if($_GET['m'] == 'edit_campagne')
	{

		global $display_name, $user_email, $user_ID;
		get_currentuserinfo();

		$rentabads_data = htmlentities(trim($_POST['rentabads_data']));
		$rentabads_campagne_link = htmlentities(trim($_POST['rentabads_campagne_link']));
		$rentabads_campagne_image = htmlentities(trim($_POST['rentabads_campagne_image']));

		$extension = strrchr($_FILES['rentabads_upload']['name'], '.');
		$extension = substr($extension, 1);
		$extension = strtolower($extension);

		if(!empty($_FILES['rentabads_upload']['tmp_name']))
		{
			if($_FILES['rentabads_upload']['error'])
			{
				switch($_FILES['rentabads_upload']['error'])
				{

					case 1:
						$msg = __("Le fichier d&eacute;passe la limite autoris&eacute;e par le serveur !",'rentabads');
					break;

					case 2:
						$msg = __("Le fichier d&eacute;passe la limite autoris&eacute;e dans le formulaire HTML !",'rentabads');
					break;

					case 3:
						$msg = __("L'envoi du fichier a &eacute;t&eacute; interrompu pendant le transfert !",'rentabads');
					break;

					case 4:
						$msg = __("Le fichier que vous avez envoy&eacute; a une taille nulle !",'rentabads');
					break;

				}

				header("Location: ../../../wp-admin/admin.php?page=rentabads_campagnes&d=" . base64_encode($msg));
				exit;
			}
			elseif(!in_array($extension, $array_file_allow))
			{
				$msg = __("Veuillez s&eacute;lectionner un type d'image diff&eacute;rent !",'rentabads');
				header("Location: ../../../wp-admin/admin.php?page=rentabads_campagnes&d=" . base64_encode($msg));
				exit;
			}
			else
			{

				$repertoire = 'upbans/';

				if((isset($_FILES['rentabads_upload']['tmp_name']) && ($_FILES['rentabads_upload']['error'] == UPLOAD_ERR_OK)))
				{
					$link_banniere = $repertoire . time() . rand() . '_' . $_FILES['rentabads_upload']['name'];
					move_uploaded_file($_FILES['rentabads_upload']['tmp_name'], $link_banniere);
					$rentabads_campagne_image = DIRECTORY_PLUGIN . $link_banniere;
				}

			}
		}

		mysql_query("UPDATE " . RENTABADS_TABLE_CAMPAIGNS . " SET link='" . $rentabads_campagne_link . "', image='" . $rentabads_campagne_image . "' WHERE user_id='" . $user_ID . "' AND data='" . $rentabads_data . "'");

		$msg = __("La campagne a &eacute;t&eacute; &eacute;dit&eacute; !",'rentabads');
		header("Location: ../../../wp-admin/admin.php?page=rentabads_campagnes&d=" . base64_encode($msg));
		exit;

	}


	if($_GET['m'] == 'edit_espace')
	{
		$rentabads_data = htmlentities(trim($_POST['rentabads_data']));
		$rentabads_name = htmlentities(utf8_decode(trim($_POST['rentabads_name'])));
		$rentabads_duration = htmlentities(trim($_POST['rentabads_duration']));
		$rentabads_width = htmlentities(trim($_POST['rentabads_width']));
		$rentabads_height = htmlentities(trim($_POST['rentabads_height']));
		$rentabads_doc_id = htmlentities(trim($_POST['rentabads_doc_id']));
		$rentabads_site_id = htmlentities(trim($_POST['rentabads_site_id']));
		$rentabads_price = trim($_POST['rentabads_price']);

		mysql_query("UPDATE " . RENTABADS_TABLE_SPACES . " SET espace_name='" . $rentabads_name . "', duration='" . $rentabads_duration . "', size_width='" . $rentabads_width . "', size_height='" . $rentabads_height . "', doc_id='" . $rentabads_doc_id . "', site_id='" . $rentabads_site_id . "', price='" . $rentabads_price . "' WHERE data='" . $rentabads_data . "'");

		$msg = __("L'espace de ventes a &eacute;t&eacute; &eacute;dit&eacute; !",'rentabads');
		header("Location: ../../../wp-admin/admin.php?page=rentabads_espace_ventes&d=" . base64_encode($msg));
		exit;

	}


	if($_GET['m'] == 'add_espace')
	{
		$random_espace = substr(md5(rand()), 0, 10);
		mysql_query("INSERT INTO " . RENTABADS_TABLE_SPACES . " (espace_name,data,size_width,size_height,duration) VALUES('" . __("Nouvel espace de ventes",'rentabads') . "', '" . $random_espace . "', '468', '60', '30')");

		$msg = __("L'espace de ventes a &eacute;t&eacute; ajout&eacute; !",'rentabads');
		header("Location: ../../../wp-admin/admin.php?page=rentabads_espace_ventes&espace_edit=" . $random_espace . "&d=" . base64_encode($msg));
		exit;

	}
	
	
}

?>