<?php
/*======================================================================*\
|| #################################################################### ||
|| # gbase.inc.php 6.00, for use with PhpProBid script 6.00+	       # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright © 2005 RENS Management, LLC. All Rights Reserved.      # ||
|| # This file is licensed under the End User Licensue Agreement at   # ||
|| #                 http://probid.rensmllc.com/eula.pdf              # ||
|| # -----------------  THIS IS NOT FREE SOFTWARE ------------------- # ||
|| #                                                                  # ||
|| #################################################################### ||
\*======================================================================*/

include_once ('gbase.cfg.php');

function findpath($search, $array_in) 
{
	foreach ($array_in as $key => $value) 
	{
		$startpos=strpos(strtolower($value), $search);
		if ($startpos !== FALSE) 
		{
			if ( strlen($value)>($startpos+4) ) continue; // not php root
			return $key;
    	}
   }
   return FALSE;
}

// lock file from other PhpProBid accesses
$lockfile = explode(".",Gbase_datafeed);
array_pop($lockfile);
$lockfile = $lockfile[0] . ".loc";
$handle = fopen($lockfile,'r+b');
$buffer = fgets($handle,10+1); // fgets reads lenght-1

if ($buffer>time()) // not time yet
{
   @fclose($handle);
   return;
}

$process_id=NULL;
fseek($handle,10);
$process_id=fgets($handle,32);

if (!isset($process_id)) 
{
   @fclose($handle);
   return;
} 
else 
{
	$process_id=md5(rand());
	fseek($handle,10);
	fputs($handle,$process_id,32);
	@fclose($handle);
}

// dispatch Gbase process
$parameters = Gbase_path . "gbase.php dbhost=$db_host dbuser=$db_username dbpass=$db_password dbname=$db_name process_id=$process_id";
if (PHP_SHLIB_SUFFIX == 'dll') // start on windows
{
	$pathArray = explode(PATH_SEPARATOR, $_SERVER['PATH']);
	$phppath=findpath("\php", $pathArray);
	
	if (isset($phppath)) 
	{
   	$phppath=$pathArray[$phppath]."\cli\php.exe";
   	//$phppath = 'd:\xampp\php\php.exe';
		pclose(popen("start /B $phppath $parameters", 'r'));
	}
} 
else // start on linux
{
	exec("php $parameters > /dev/null &");
}

?>