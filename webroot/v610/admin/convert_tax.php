<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);

include_once ('../includes/global.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	$session->set('category_language', 0);

	include_once ('header.php');
	$link = 'convert_tax.php';

	$tax = new tax();
	$tax->setts = &$setts;
	$convert_tax = $tax->convert_tax();
	
	if ($convert_tax['result'])
	{
		$tax->hardcode_tax();
		
		$template_output .= '<table width="100%" border="0" cellspacing="3" cellpadding="3"> '.
			'<tr><td><b>Conversion in process...</b><br><br>
			There are <b>' . $convert_tax['invoices'] . '</b> unconverted site fees invoice rows and 
			<b>' . $convert_tax['winners'] . '</b> unconverted product invoice rows in the database still.<br><br>Please click '.
			'<a href=' . $link . '>here</a><br>if the page does not refresh automatically.'.
			'<script>window.setTimeout(\'changeurl();\',1500); function changeurl(){window.location=\'' . $link . '\'}</script>'.
			'</td></tr></table>';
	}
	else 
	{
		$template_output .= '<table width="100%" border="0" cellspacing="3" cellpadding="3"> '.
			'<tr><td>The tax fields conversion process has been finished successfully.</td></tr></table>';
	}
	

	include_once ('footer.php');

	echo $template_output;
}
?>
