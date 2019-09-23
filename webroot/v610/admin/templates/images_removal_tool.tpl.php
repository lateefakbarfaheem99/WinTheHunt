<?
#################################################################
## PHP Pro Bid v6.04															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<script type="text/javascript">
	$(document).ready(function() {
		function calcEndTime()
		{
			$.post(
			"../ajax_files/images_removal_tool.php",
			{
				total_files: $('#total_files').html(),
				total_size: $('#total_size').html(),
				db_media: $('#db_media').html(),
				obsolete_files: $('#obsolete_files').html(), 
				deleted_files: $('#deleted_files').html()
			},
			function(response)
			{
				result = response.split('||');
				
				var remaining_files = result[5];
				
				if (result[0] != '0')
				{
					$('#img_progress').show();
					$('#img_removal_content').append(result[0]);
				}
				
				$('#total_files').html(result[1]);
				$('#total_size').html(result[2]);
				$('#db_media').html(result[3]);
				$('#obsolete_files').html(result[4]);
				$('#deleted_files').html(result[6]);
				
				if (remaining_files > 0)
				{
					setTimeout(function() {calcEndTime()}, 1000);
				}							
				else
				{
					$('#removal_complete').show();
				}
			});
		}
		$('#img_removal_tool').click(function() {
			$('#img_button').hide();
			$('#img_results').show();
			calcEndTime();
		});
	});
</script>

<div class="mainhead"><img src="images/auction.gif" align="absmiddle">
   <?=$header_section;?>
</div>
<?=$msg_changes_saved;?>
<?=$management_box;?>
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
   <form action="images_removal_tool.php" method="post">
      <tr class="c1">
         <td><?=AMSG_IMG_REMOVAL_TOOL_DESC;?></td>
      </tr>
      <tr class="c5">
         <td></td>
      </tr>
      <tr class="c1" id="img_progress" style="display: none;">
         <td>
         	<div id="img_removal_content"></div>
         </td>
      </tr>
      <tr class="c2" id="img_results" style="display: none;">
         <td>
         	<div><strong>Total Files</strong>: <span id="total_files"></span></div>
         	<div><strong>Total Size</strong>: <span id="total_size"></span> KB.</div>
         	<div><strong>Total Media in Database</strong>: <span id="db_media"></span></div>
         	<div><strong>Total Obsolete Files</strong>: <span id="obsolete_files"></span></div>
         	<div><strong>Obsolete Files Erased</strong>: <span id="deleted_files">0</span></div>
<!--         	<div><span id="time_passed">0</span></div>-->
         </td>
      </tr>
		<tr class="c1" id="removal_complete" style="color: red; display: none;">
         <td>
         	<strong><?=AMSG_OPERATION_COMPLETE; ?></strong>
         </td>
      </tr>       
      <tr id="img_button">
         <td align="center"><input type="button" name="form_proceed" id="img_removal_tool" value="<?=GMSG_PROCEED;?>"></td>
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
