<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script language="javascript">
function popUp(URL) {
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=2,location=0,statusbar=1,menubar=0,resizable=0,width=550,height=395,left = 80,top = 80');");
}
</script>

<div class="mainhead"><img src="images/user.gif" align="absmiddle">
   <?=$header_section;?>
</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
      <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <tr class="c3">
      <td colspan="2"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
         <?=strtoupper($subpage_title);?>
         </b></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
   <tr>
      <td align="center"><?=$msg_changes_saved;?></td>
   </tr>
   <tr>
      <td><table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
            <form action="list_users_reputations.php" method="post">
               <tr class="c3">
                  <td colspan="3"><b>
                     <?=AMSG_REPUTATION_SEARCH;?>
                     </b></td>
               </tr>
               <tr class="c1">
                  <td nowrap><?=GMSG_FROM;?> (<?=AMSG_USERNAME;?>):
                     <input name="src_from" type="text" id="src_from" value="<?=$src_from;?>" /></td>
                  <td nowrap><?=GMSG_TO;?> (<?=AMSG_USERNAME;?>):
                     <input name="src_to" type="text" id="src_to" value="<?=$src_to;?>" /></td>
                  <td width="100%"><?=AMSG_RATING;?>:
                     <select name="src_rating">
                        <option value="" selected="selected">--
                        <?=GMSG_ANY;?>
                        --</option>
                        <option value="5" <? echo ($src_rating==5) ? "selected" : ""; ?>  style="color:#009933; ">
                        <?=GMSG_FIVE_TICKS;?>
                        </option>
                        <option value="4" <? echo ($src_rating==4) ? "selected" : ""; ?>  style="color:#009933; ">
                        <?=GMSG_FOUR_TICKS;?>
                        </option>
                        <option value="3" <? echo ($src_rating==3) ? "selected" : ""; ?>  style="color:#666666; ">
                        <?=GMSG_THREE_TICKS;?>
                        </option>
                        <option value="2" <? echo ($src_rating==2) ? "selected" : ""; ?>  style="color:#FF0000; ">
                        <?=GMSG_TWO_TICKS;?>
                        </option>
                        <option value="1" <? echo ($src_rating==1) ? "selected" : ""; ?>  style="color:#FF0000; ">
                        <?=GMSG_ONE_TICK;?>
                        </option>
                     </select>
                     <input name="form_rep_search" type="submit" id="form_rep_search" value="<?=GMSG_SEARCH;?>" /></td>
               </tr>
            </form>
         </table></td>
   </tr>
   <tr>
      <td align="center"><?=$query_results_message;?></td>
   </tr>
   <tr>
      <td><table width="100%" border="0" cellpadding="3" cellspacing="3">
            <tr>
               <td colspan="5" class="c7"><b>
                  <?=AMSG_FILTER_REPUTATIONS;?>
                  :</b>
                  <?=$filter_reps_content;?></td>
            </tr>
            <tr class="c3">
               <td width="200"><b>
                  <?=AMSG_DETAILS;?>
                  </b></td>
               <td width="100"><b>
                  <?=AMSG_REP_RATE;?>
                  </b></td>
               <td><b>
                  <?=AMSG_REP_COMMENTS;?>
                  </b></td>
               <td width="110" align="center"><b>
                  <?=AMSG_OPTIONS;?>
                  </b></td>
            </tr>
            <form action="list_users_reputations.php" method="POST">
               <?=$rep_details_content;?>
               <tr class="c4">
                  <td colspan="5" align="center"><input name="form_save_settings" type="submit" id="form_save_settings" value="<?=AMSG_SAVE_CHANGES;?>" /></td>
               </tr>
               <tr>
                  <td colspan="5" align="center"><?=$pagination;?></td>
               </tr>
            </form>
         </table></td>
   </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
      <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
      <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
   </tr>
</table>
