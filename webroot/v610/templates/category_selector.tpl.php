<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link href="<? echo (IN_ADMIN == 1) ? '' : 'themes/' . $setts['default_theme'] . '/'; ?>style.css" rel="stylesheet" type="text/css">
<SCRIPT LANGUAGE="JavaScript"><!--
	function copyForm(selCBox)
	{
		opener.document.<?=$form_name;?>.<?=$cat;?>.value = selCBox.value;
		opener.document.<?=$form_name;?>.box_submit.value = 1;		
		//opener.document.<?=$form_name;?>.onsubmit();
		opener.document.<?=$form_name;?>.submit();
		window.opener.focus;
		window.close();
		return false;
	}
//-->
</SCRIPT>
<script language="javascript">
	function OnDivScroll()
	{
		var cat = document.getElementById("cat");

		if (cat.options.length > 15)
		{
			cat.size=cat.options.length;
		}
		else
		{
			cat.size=15;
		}
	}

	function OnSelectFocus()
	{
		var cat = document.getElementById('cat');
		if( cat.options.length > 15)
		{
			cat.focus();
			cat.size=15;
		}
	}
</script>
</head>

<body>
<form name="popupForm" onSubmit="return copyForm()">
   <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border">
      <tr>
         <td colspan="2" class="c3"><b>
            <?=$page_title;?>
            </b></td>
      </tr>
      <tr class="c5">
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="150" height="1"></td>
         <td><img src="themes/<?=$setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
      </tr>
      <tr class="c1">
         <td width="150" align="right"><?=GMSG_CATEGORY;?></td>
         <td><?=$category_selector_box;?></td>
      </tr>
      <tr class="c4">
         <td align="center" colspan="2"><INPUT TYPE="button" VALUE="<?=GMSG_PROCEED;?>" onClick="copyForm(cat)"></td>
      </tr>
   </table>
</form>
</body>
</html>
