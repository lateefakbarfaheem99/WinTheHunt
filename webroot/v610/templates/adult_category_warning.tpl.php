<?
#################################################################
## PHP Pro Bid v6.01															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=headercat($categories_header_menu);?>

<br>
<table width="40%" border="0" cellpadding="5" cellspacing="0" class="errormessage" align="center">
   <tr>
      <td align="center" class="contentfont"><br /><h1 class="redfont" style="margin-bottom: 5px;"><?=MSG_WARNING;?></h1>
         <h3 style="margin-bottom: 5px; margin-top: 3px;"><?=MSG_ADULT_CAT_MSG_A;?></h3>
         <?=MSG_ADULT_CAT_MSG_B;?>
         <?=$minimum_age;?>
         <?=MSG_ADULT_CAT_MSG_C;?>
         <table>
            <tr>
               <td><form name="agree" action="<?=$_SERVER['PHP_SELF'];?>" method="GET">
               		<input type="hidden" name="auction_id" value="<?=$auction_id;?>">
               		<input type="hidden" name="parent_id" value="<?=$parent_id;?>">
							<input type="hidden" name="option" value="agree_adult">
                     <input type="submit" id="agree" value="<?=MSG_BTN_AGREE;?>">
                  </form></td>
               <td><form name="cancel" action="index.php">
                     <input type="submit" id="cancel" value="<?=MSG_CANCEL;?>">
                  </form></td>
            </tr>
         </table></td>
   </tr>
</table>
