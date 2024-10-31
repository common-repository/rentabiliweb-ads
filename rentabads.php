<?php


/*
Plugin Name: Rentabiliweb Ads
Plugin URI: http://www.maxence-blog.fr/2011/05/29/plugin-wordpress-rentabiliweb-ads
Description: <strong>English</strong> : <strong>Rentabiliweb Ads</strong> uses the service Micropayement <a href="http://www.rentabiliweb.com/" target="_blank">Rentabiliweb.com</a> to offer your visitors/readers the sales areas for buy on your blog so they can display their banner. You can use one or more widget to display your sales areas or use the function <strong>&lt;?php get_rentabads('ID'); ?&gt; </strong> of your plugin for integrated sales areas in your theme. | <strong>Fran&ccedil;ais</strong> : <strong>Rentabiliweb Ads</strong> utilise le service de Micro-Paiement <a href="http://www.rentabiliweb.com/" target="_blank">Rentabiliweb.com</a> pour proposer &agrave; vos visiteurs/lecteurs d'acheter un espace publicitaire sur votre blog afin qu'ils puissent afficher leur(s) banni&egrave;re(s). Vous pouvez utiliser un ou plusieurs widget(s) pour afficher vos espaces de vente ou bien utiliser la fonction <strong>&lt;?php get_rentabads('ID'); ?&gt;</strong> du plugin pour int&eacute;gr&eacute; vos espaces de vente dans votre th&egrave;me.
Author: Maxence Rose
Version: 3.4
Author URI: http://www.maxence-blog.fr/
*/

global $wpdb;
$table_prefix_rentabads = $wpdb->prefix;

define('ADMIN_PAGE', get_option('siteurl') . '/wp-admin/');
define('ADMIN_PAGE_PLUGIN', admin_url('admin.php?page='));
define('DIRECTORY_PLUGIN', rentabads_path());
define('RENTABADS_VERSION', '3.4');
define('RENTABADS_TABLE_PREFIX', $table_prefix_rentabads . 'rentabads_');
define('RENTABADS_TABLE_CONFIG', RENTABADS_TABLE_PREFIX . 'configuration');
define('RENTABADS_TABLE_CAMPAIGNS', RENTABADS_TABLE_PREFIX . 'campaigns');
define('RENTABADS_TABLE_SPACES', RENTABADS_TABLE_PREFIX . 'spaces');


$array_file_allow = array('png', 'jpg', 'gif', 'jpeg'); // <= Vous pouvez ajouter des extensions d'images ici.


function rentabads_path()
{
	$plugin_path = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
	return $plugin_path;
}



function custom_login_message()
{

	$message = "<p class=\"message\" style=\"margin: 20px 0 40px 0; font-size: 14px; text-align: center;\">" . __("Pour ajouter votre banni&egrave;re sur ce blog, vous devez &ecirc;tre connect&eacute;.",'rentabads') . " <a href=\"wp-login.php?action=register\">" . __("Inscrivez-vous",'rentabads') . "</a> " . __("si vous n'avez pas encore de compte",'rentabads') . ".</p>";
	return $message;

}
add_filter('login_message', 'custom_login_message');



function get_rentabads($data, $link_active = 'Your banner here ?', $position = 'bottom-right')
{

	global $wpdb;
	$table_prefix = $wpdb->prefix;

	$resnb_rentabads_campagne = mysql_num_rows(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE espace_data='" . $data . "' AND expire='no'"));
	if($resnb_rentabads_campagne == 0)
	{
		$text_get_rentabads = '<br /><a href="' . ADMIN_PAGE_PLUGIN . 'rentabads_acheter" class="link_get_rentabads">' . $link_active . '</a>';
	}
	else
	{

		$source_banniere_config = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . " WHERE data='" . $data . "'"));
		$source_banniere_random = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE espace_data='" . $data . "' AND expire='no' AND image!='' AND link!='' AND espace_data!='' ORDER BY RAND() LIMIT 1"));

		if($position == 'top-right')
		{
			$position_div = 'top: 0px; right: 0px;';
			$position_margin = 'margin: 2px 2px 0 0;';
		}
		elseif($position == 'top-left')
		{
			$position_div = 'top: 0px; left: 0px;';
			$position_margin = 'margin: 2px 0 0 2px;';
		}
		elseif($position == 'bottom-left')
		{
			$position_div = 'bottom: 0px; left: 0px;';
			$position_margin = 'margin: 0 0 2px 2px;';
		}
		else // bottom-right
		{
			$position_div = 'bottom: 0px; right: 0px;';
			$position_margin = 'margin: 0 2px 2px 0;';
		}

		$random_id_esp = rand();
		$text_get_rentabads = '<div id="Rentabiliweb-Ads-' . rand() . '" style="width: ' . $source_banniere_config['size_width'] . '; height: ' . $source_banniere_config['size_height'] . '; position: relative;"><span style="position: absolute; ' . $position_div . ' margin: 0px; padding: 3px; -moz-opacity: 0.80; KhtmlOpacity: 0.80; opacity: 0.80; background-color: #333333; border-radius: 10px; -moz-border-radius: 3px; -webkit-border-radius: 3px; ' . $position_margin . '" onmouseover="document.getElementById(\'spaninfo_' . $random_id_esp . '\').style.display = \'\';" onmouseout="document.getElementById(\'spaninfo_' . $random_id_esp . '\').style.display = \'none\';"><img src="' . DIRECTORY_PLUGIN . 'images/info_ban.png" width="16" height="16" border="0" align="middle" /><span id="spaninfo_' . $random_id_esp . '" style="display: none; padding: 0 5px 0 5px; font-size: 12px; font-family: arial;"><a href="' . ADMIN_PAGE_PLUGIN . 'rentabads_acheter" target="_blank" style="color: #FFFFFF; text-decoration: none;" class="img_get_rentabads">' . $link_active . '</a></span></span><a rel="" href="' . DIRECTORY_PLUGIN . 'banaction.php?b=c&d=' . $source_banniere_random['data'] . '" target="_blank"><img src="' . DIRECTORY_PLUGIN . 'banaction.php?b=a&d=' . $source_banniere_random['data'] . '" width="' . $source_banniere_config['size_width'] . '" height="' . $source_banniere_config['size_height'] . '" border="0" /></a></div>';

	}

	echo $text_get_rentabads;

}


function rentabads_activate()
{

	$sql = "CREATE TABLE IF NOT EXISTS `" . RENTABADS_TABLE_CONFIG . "` (
	`allow_upload` set('yes','no') NOT NULL DEFAULT 'yes',
	`display_price` set('yes','no') NOT NULL DEFAULT 'yes'
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	mysql_query($sql);

	mysql_query("TRUNCATE TABLE `" . RENTABADS_TABLE_CONFIG . "`");
	mysql_query("INSERT INTO `" . RENTABADS_TABLE_CONFIG . "` (`allow_upload`,`display_price`) VALUES ('yes', 'yes')");

	$sql = "CREATE TABLE IF NOT EXISTS `" . RENTABADS_TABLE_CAMPAIGNS . "` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`data` varchar(255) NOT NULL,
	`user_id` bigint(20) NOT NULL DEFAULT '1',
	`link` varchar(255) NOT NULL,
	`image` varchar(255) NOT NULL,
	`espace_data` varchar(255) NOT NULL,
	`nb_lecture` bigint(20) NOT NULL DEFAULT '0',
	`nb_clic` bigint(20) NOT NULL DEFAULT '0',
	`time` bigint(20) NOT NULL DEFAULT '0',
	`expire` set('yes','no') NOT NULL DEFAULT 'no',
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	mysql_query($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `" . RENTABADS_TABLE_SPACES . "` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`espace_name` varchar(255) NOT NULL,
	`data` varchar(255) NOT NULL,
	`size_width` varchar(255) NOT NULL,
	`size_height` varchar(255) NOT NULL,
	`doc_id` bigint(20) NOT NULL DEFAULT '0',
	`site_id` bigint(20) NOT NULL DEFAULT '0',
	`price` varchar(20) NOT NULL DEFAULT '1.91&euro;',
	`duration` bigint(20) NOT NULL DEFAULT '30',
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	mysql_query($sql);

}
register_activation_hook(__FILE__, 'rentabads_activate');

function rentabads_table_maj()
{
	rentabads_activate();
}


function rentabads_add_version_plugin()
{

	add_option('rentabads_version', '');

	if(get_option('rentabads_version') !== RENTABADS_VERSION)
	{
		delete_option('rentabads_doc_id');
		delete_option('rentabads_site_id');
		update_option('rentabads_version', RENTABADS_VERSION);
		rentabads_table_maj();
	}

}
add_action('init', 'rentabads_add_version_plugin');


function rentabiliweb_link($links, $file)
{

    if($file == plugin_basename(__FILE__))
	{
        $rentabiliweb_link = '<a href="http://www.rentabiliweb.com/" target="_blank">Rentabiliweb.com</a>';
        $links[] = $rentabiliweb_link;
    }

    return $links;

}
add_filter('plugin_row_meta', 'rentabiliweb_link', 10, 2);



function rentabads_delete_bdd()
{
	mysql_query("DROP TABLE `" . RENTABADS_TABLE_CONFIG . "`, `" . RENTABADS_TABLE_CAMPAIGNS . "`, `" . RENTABADS_TABLE_SPACES . "`");
}
register_uninstall_hook(__FILE__, 'rentabads_delete_bdd');



function bbcode_rentabads($content) {
    $content = preg_replace('/\[rentabads]*(.*?)(\[\/rentabads)?\]/ei', 'get_rentabads(\'$1\')', $content);
    return $content;
}
add_filter('the_content', 'bbcode_rentabads');



function rentabads_plugin_action_links($links, $file)
{

	static $this_plugin;

	if(!$this_plugin)
	{
		$this_plugin = plugin_basename(__FILE__);
	}

	if($file == $this_plugin)
	{
		$settings_link = '<a href="options-general.php?page=rentabads_config">' . __("R&eacute;glages",'rentabads') . '</a>';
		array_unshift($links, $settings_link);
	}

	return $links;

}
add_filter('plugin_action_links', 'rentabads_plugin_action_links', 10, 2 );



function rentabads_get_option($table, $valeur, $options = null)
{

	$source_get_option = mysql_fetch_array(mysql_query("SELECT * FROM " . $table . " " . $options . ""));

	return $source_get_option[$valeur];

}



function widget_rentabads()
{
	register_widget("widget_rentabads");
}
add_action('widgets_init', 'widget_rentabads');



class widget_rentabads extends WP_widget
{



	function widget_rentabads(){
		$options = array(
			"classname" => "widget-rentabads",
			"description" => __("Affichage des espaces de ventes Rentabiliweb Ads. Rendez-vous dans \"Rentab. Ads / Espaces de ventes\" pour ajouter des espaces de ventes.",'rentabads')
		);

		$this->WP_widget("widget-rentabads", __("Espace Rentabiliweb Ads",'rentabads'), $options);
	}



	function widget($args, $d)
	{

		$defaut = array(
			"titre" => __("Sponsor de mon blog",'rentabads'),
			"texte" => __("Votre banni&egrave;re ici ?",'rentabads'),
			"position" => "bottom-right",
			"style" => "margin-top: 20px; text-align: center;",
			"format_data" => ""
		);
		$d = wp_parse_args($d, $defaut);

		global $wpdb;
		$table_prefix = $wpdb->prefix;

		extract($args);

		echo $before_widget;
		echo $before_title . $d['titre'] . $after_title;
		echo '<p style="' . $d['style'] . '">';
		get_rentabads($d['format_data'], $d['texte'], $d['position']);
		echo '</p>';
		echo $after_widget;

	}



	function update($new, $old)
	{
		return $new;
	}



	function form($d)
	{

		$defaut = array(
			"titre" => __("Sponsor de mon blog",'rentabads'),
			"texte" => __("Votre banni&egrave;re ici ?",'rentabads'),
			"position" => "bottom-right",
			"style" => "margin-top: 20px; text-align: center;",
			"format_data" => ""
		);
		$d = wp_parse_args($d, $defaut);

		global $wpdb;
		$table_prefix = $wpdb->prefix;

		?>
		<p>
		<label for="<?php echo $this->get_field_id('titre'); ?>"><?php echo __('Titre du widget','rentabads'); ?> :</label><br />
		<input value="<?php echo $d['titre']; ?>" name="<?php echo $this->get_field_name('titre'); ?>" id="<?php echo $this->get_field_id('titre'); ?>" type="text" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('texte'); ?>"><?php echo __('Texte (Votre banni&egrave;re ici)','rentabads'); ?> :</label><br />
		<input value="<?php echo $d['texte']; ?>" name="<?php echo $this->get_field_name('texte'); ?>" id="<?php echo $this->get_field_id('texte'); ?>" type="text" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('position'); ?>"><?php echo __('Position','rentabads'); ?> :</label><br />
		<input value="<?php echo $d['position']; ?>" name="<?php echo $this->get_field_name('position'); ?>" id="<?php echo $this->get_field_id('position'); ?>" type="text" /><br />
		<span class="description">top-left, top-right, bottom-left, bottom-right</span>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('style'); ?>"><?php echo __('Style du widget','rentabads'); ?> :</label><br />
		<input value="<?php echo $d['style']; ?>" name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>" type="text" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('format_data'); ?>"><?php echo __('Format de votre espace','rentabads'); ?> :</label><br />
		<select name="<?php echo $this->get_field_name('format_data'); ?>" id="<?php echo $this->get_field_id('format_data'); ?>">
		<?php
		$result_list_rentabads_espaces = mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . " ORDER BY espace_name ASC");
		while($source_list_rentabads_espaces = mysql_fetch_array($result_list_rentabads_espaces))
		{
		?>
		<option value="<?php echo $source_list_rentabads_espaces['data']; ?>" <?php if($d['format_data'] == $source_list_rentabads_espaces['id']){ echo 'selected'; }?>>
		<?php echo $source_list_rentabads_espaces['espace_name']; ?> : <?php echo $source_list_rentabads_espaces['size_width']; ?>x<?php echo $source_list_rentabads_espaces['size_height']; ?>
		</option>
		<?php
		}
		?>
		</select>
		</p>
		<p>
		<a href="admin.php?page=rentabads_espace_ventes" target="_blank"><?php echo __('Cliquez-ici','rentabads'); ?></a> <?php echo __('pour ajouter un nouvel espace publicitaire sur votre blog','rentabads'); ?>.
		</p>
		<?php

	}

}



function rentabads_pages()
{
    add_menu_page(__('Rentab. Ads','rentabads'), __('Rentab. Ads','rentabads'), 10, 'rentabads_config', 'rentabads_config', DIRECTORY_PLUGIN . '/images/icon_menu.png', 3 );
    add_submenu_page('rentabads_config', __('Configuration de Rentabiliweb Ads','rentabads'), __('Configuration','rentabads'), 10, 'rentabads_config', 'rentabads_config');
    add_submenu_page('rentabads_config', __('Espaces sponsoris&eacute;s de votre blog','rentabads'), __('Espaces de ventes','rentabads'), 10, 'rentabads_espace_ventes', 'rentabads_espace_ventes');
    add_submenu_page('rentabads_config', __('Acheter un espace publicitaire','rentabads'), __('Acheter un espace','rentabads'), 0, 'rentabads_acheter', 'rentabads_acheter');
    add_submenu_page('rentabads_config', __('Campagnes achet&eacute;s sur les espaces de ventes','rentabads'), __('Campagnes','rentabads'), 0, 'rentabads_campagnes', 'rentabads_campagnes');
}
add_action('admin_menu', 'rentabads_pages');


function rentabads_load_plugin_textdomain()
{
	load_plugin_textdomain('rentabads', false, dirname(plugin_basename( __FILE__ )) . '/languages/');
}

rentabads_load_plugin_textdomain();

// add_action('init', 'rentabads_load_plugin_textdomain');
add_filter('plugin_row_meta', 'rentabiliweb_link', 10, 2);



include("rentabads_espace_ventes.php");
include("rentabads_config.php");
include("rentabads_acheter.php");
include("rentabads_campagnes.php");



/*

En cas de problème,
vous pouvez me contacter
sur mon blog à l'adresse
http://www.maxence-blog.fr/

*/



?>