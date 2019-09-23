<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

include_once('includes/class_image.php');

$image = new image();

(string) $pic = null;

$pic = str_ireplace(' ','%20',$_GET['pic']);

$thumbnail_width = abs(intval($_GET['w']));

$is_square = ($_GET['sq']=='Y')? true : false;
$is_border = ($_GET['b']=='Y') ? true : false;

$pic_no_spaces = str_ireplace('%20','',$pic);

$pic_cached = str_ireplace($image->image_basedir,'',$pic_no_spaces);

$allowed_extension = $image->allowed_extension($pic);

/* check to see if file already exists in cache, and output it with no processing if it does */
$cached_filename = $image->set_cache_filename($pic_cached, $thumbnail_width, $is_square, $is_border);

if (is_file($cached_filename) && $allowed_extension) /* display cached filename */
{	
	$photo = file_get_contents($cached_filename);
	
	ob_start();
	header("Content-type: image/jpeg");
	print($photo);
	ob_end_flush();
}
else /* create new thumbnail, and add it into the cache directory as well */
{

	$allowed_widths = array(50, 55, 60, 70, 75, 80, 90, 100, 150, 250, 275, 300, 500, 750, $layout['hpfeat_width'], $layout['catfeat_width']);
	//$allowed_widths = sort($allowed_widths, SORT_NUMERIC);

	if (!in_array($thumbnail_width, $allowed_widths))
	{
		$difference = 0;
		$new_width = $thumbnail_width;
		foreach ($allowed_widths as $value)
		{
			$diff = abs($thumbnail_width - $value);

			if ($diff < $difference || $difference == 0)
			{
				$difference = $diff;
				$new_width = $value;
			}
		}

		$thumbnail_width = $new_width;
   }

	$info = null;
	
	$info = @getimagesize($pic);
	list($im_width, $im_height, $im_type, $im_attr) = $info;

	if (empty($info) || $im_type>3) $pic = 'images/broken.gif';
	
	if (isset($pic) && $thumbnail_width>0 && $allowed_extension)
	{
		$cache_output = $image->set_cache_filename($pic_cached, $thumbnail_width, $is_square, $is_border);
		$image->generate_thumb($pic, $thumbnail_width, $is_square, $is_border, $cache_output);
		//header('Location: ' . $cache_output);			
		
		$photo = file_get_contents($cached_filename);
		
		ob_start();
		header("Content-type: image/jpeg");
		print($photo);
		ob_end_flush();		
	}	
	else if (!isset($pic))
	{
		echo "<strong>ERROR:</strong> No image submitted";
	}
	else if ($thumbnail_width<=0)
	{
		echo "<strong>ERROR:</strong> Invalid resizing option";
	}
	else if (!$allowed_extension)
	{
		echo "<strong>ERROR:</strong> Prohibited file extension";
	}
}
?>