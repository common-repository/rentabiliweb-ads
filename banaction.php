<?php

require_once('../../../wp-load.php');

if(!empty($_GET['b']))
{


	if($_GET['b'] == 'a')
	{

		$data = htmlentities(trim($_GET['d']));

		$source_rentabads_campagne = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE data='" . $data . "'"));

		$source_rentabads_espaces = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_SPACES . " WHERE data='" . $source_rentabads_campagne['espace_data'] . "'"));
		$ifexpire = (60*60*24*$source_rentabads_espaces['duration']);
		if(time() >= ($source_rentabads_campagne['time']+$ifexpire))
		{
			mysql_query("UPDATE " . RENTABADS_TABLE_CAMPAIGNS . " SET expire='yes' WHERE data='" . $data . "'");
		}

		mysql_query("UPDATE " . RENTABADS_TABLE_CAMPAIGNS . " SET nb_lecture='" . ($source_rentabads_campagne['nb_lecture']+1) . "' WHERE data='" . $data . "'");

		header("Location: " . $source_rentabads_campagne['image']);
		exit;

	}

	if($_GET['b'] == 'c')
	{

		$data = htmlentities(trim($_GET['d']));

		$source_rentabads_campagne = mysql_fetch_array(mysql_query("SELECT * FROM " . RENTABADS_TABLE_CAMPAIGNS . " WHERE data='" . $data . "'"));

		mysql_query("UPDATE " . RENTABADS_TABLE_CAMPAIGNS . " SET nb_clic='" . ($source_rentabads_campagne['nb_clic']+1) . "' WHERE data='" . $data . "'");

		header("Location: " . $source_rentabads_campagne['link']);
		exit;

	}
	
}

?>