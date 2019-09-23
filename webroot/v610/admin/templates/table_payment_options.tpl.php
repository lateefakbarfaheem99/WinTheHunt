<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<div class="mainhead"><img src="images/tables.gif" align="absmiddle">
   <?=AMSG_TABLES_MANAGEMENT;?>
</div>
<?=$msg_changes_saved;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
      <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
   </tr>
</table>
<?=$management_box;?>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <tr class="c3">
      <td><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
         <?=strtoupper($subpage_title);?>
         </b></td>
   </tr>
   <form action="table_payment_options.php" method="post">
      <tr>
         <td><b>
            <?=AMSG_CURRENT_PAYMENT_OPTIONS;?>
            </b> [ <a href="table_payment_options.php?do=add_option"><?=AMSG_ADD_PAYMENT_OPTION;?></a> ]</td>
      </tr>
      <tr>
         <td><table width="100%" border="0" cellpadding="3" cellspacing="1">
               <tr class="c4">
                  <td><b>
                     <?=AMSG_NAME;?>
                     </b></td>
                  <td width="120" align="center"><b>
                     <?=AMSG_LOGO;?>
                     </b></td>
                  <td width="120" align="center"><b>
                     <?=AMSG_OPTIONS;?>
                     </b></td>
               </tr>
               <?=$payment_options_content;?>
            </table></td>
      </tr>
   </form>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>
