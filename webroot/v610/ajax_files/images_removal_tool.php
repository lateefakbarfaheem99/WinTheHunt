<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2010 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);
define ('IN_ADMIN', 1);
define ('IN_AJAX', 1);

define ('MAX_FILES_DELETE', 50);
include_once('../includes/global.php');

if ($session->value('adminarea')=='Active')
{
	$output = null;
	
	$dir = substr($_SERVER['SCRIPT_FILENAME'],0,-34);
	
	$total_files_size = 0;		
	
	$deletion=TRUE;
	$exit_loop = FALSE;
	$time_start1 = getmicrotime();
			
	$rep = opendir($dir . '/uplimg/');
	$counter = 0;
		
	## - users ('shop_logo_path' field)
	## - auction_media ('media_url' field)
	## - categories ('image_path' field)
	## gather all in an array

	$files = array();
	while (($file = readdir($rep)) && (!$exit_loop))
	{
		if($file != '..' && $file !='.' && $file !='' && $file !='index.htm')
		{
			$files[] = $file;
			$total_files_size += filesize($dir . '/uplimg/' . $file);
		}
	}

	$db_media = array();
	//SELECT picpath AS imgremoval_url FROM " . DB_PREFIX . "auctions WHERE picpath!='' UNION
	$sql_select_media = $db->query("SELECT media_url AS imgremoval_url FROM " . DB_PREFIX . "auction_media WHERE media_url!=''
			UNION
			SELECT shop_logo_path AS imgremoval_url FROM " . DB_PREFIX . "users WHERE shop_logo_path!='' 
			UNION
			SELECT image_path AS imgremoval_url FROM " . DB_PREFIX . "categories WHERE image_path!='' 
			UNION 
			SELECT advert_img_path AS imgremoval_url FROM " . DB_PREFIX . "adverts WHERE advert_img_path!='' 
			UNION 
			SELECT logo_url AS imgremoval_url FROM " . DB_PREFIX . "payment_options WHERE logo_url!='' 
			UNION 
			SELECT site_logo_path AS imgremoval_url FROM " . DB_PREFIX . "gen_setts WHERE site_logo_path!='' ");

	while ($img_removal = $db->fetch_array($sql_select_media))
	{
		$db_media[] = str_ireplace('uplimg/', '', $img_removal['imgremoval_url']);
	}

	natcasesort($files);
	natcasesort($db_media);
	$obsolete_files = filter_unused($files, $db_media);

	$nb_obs = count($obsolete_files);

	$ending = ($nb_obs > MAX_FILES_DELETE) ? MAX_FILES_DELETE : $nb_obs;

	$exit_loop = ($nb_obs > MAX_FILES_DELETE) ? TRUE : FALSE;

	for ($i=0; $i<$ending; $i++)
	{
		$obsolete_file = trim($obsolete_files[$i]);
		if (!empty($obsolete_file))
		{
			$output .= '<div>'.
			'<strong>' . AMSG_PROCESSING . '</strong> ' . $obsolete_file;

			$file_size = filesize($dir . '/uplimg/' . $obsolete_file);
			$is_deleted = @unlink($dir . '/uplimg/' . $obsolete_file);

			if ($is_deleted)
			{
				$counter++;
				$deleted_files_size += $file_size;
			}

			$output .= ' -> <font color="' . (($is_deleted) ? 'green' : 'red') . '"><strong>' . (($is_deleted) ? AMSG_DELETED : AMSG_NOT_DELETED) . '</strong></font>'.
			'</div>';
		}
	}

	$total_files = (!empty($_POST['total_files'])) ? $_POST['total_files'] : count($files);
	$total_size = (!empty($_POST['total_size'])) ? $_POST['total_size'] : number_format($total_files_size/1024, 2, '.', ',');
	$db_media = (!empty($_POST['db_media'])) ? $_POST['db_media'] : count($db_media);
	$obsolete_files = (!empty($_POST['obsolete_files'])) ? $_POST['obsolete_files'] : count($obsolete_files);
	$deleted_files = intval($_POST['deleted_files']) + $counter;
	
	closedir($rep);
	clearstatcache();

	$time_end1 = getmicrotime();
	$time_passed = $time_end1- $time_start1;
}

if ($deletion)
{
	$result = array(
		$output, 
		$total_files, 
		$total_size, 
		$db_media, 
		intval($obsolete_files), 
		$nb_obs, 
		$deleted_files, 
		$time_passed,
	);
	
	echo $db->implode_array($result, '||');
}
?>