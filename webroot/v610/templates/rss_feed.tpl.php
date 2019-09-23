<?
#################################################################
## PHP Pro Bid v6.00															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?=$header_message;?>

<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="2">
   <tr class="contentfont">
      <td valign="top"><p>
            <?=$setts['sitename']; ?>
            auction information is available through Rich Site Summary (RSS) alerts or 
            feeds, which will allow you to see auction summaries without having to check
            <?=$setts['sitename']; ?>
            daily for updates.<br>
            <br>
            With RSS, you can see
            <?=$setts['sitename']; ?>
            auctions right on your desktop by installing a free RSS reader. 
            Most RSS readers will check for updates once every hour.<br>
            <br>
            Usually, a small alert pop-up will appear on your desktop for a few seconds if there is something new.<br>
            <br>
            To view the feed, click on the RSS link. You may see XML code displayed in your browser. <br>
            <br>
            That's ok, you just want the link address displayed in your address bar (the URL).
            Copy and paste the address into an RSS reader (see the list of compatible readers to the right). <br>
            <br>
            After you've installed your RSS reader, you can keep tabs for this site and other websites or blogs you 
            visit by adding their RSS feeds to your reader.<br>
            <br>
            <?=$setts['sitename']; ?>
            will feed you regular updates on the latest auctions and your favorite sellers.</p></td>
      <td valign="top"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="2" class="border">
            <tr class="contentfont">
               <td valign="top" class="c3"><b>Selected RSS Readers</b></td>
            </tr>
            <tr>
               <td class="c1" nowrap><p style="font-size: xx-small"><a href="http://www.rssreader.com/" target="blank">RSS Reader</a> &mdash; Windows; freeware<br>
            <a href="http://www.awasu.com/" target="blank">Awasu</a> &mdash; Windows; free for personal use<br>
            <a href="http://www.feedreader.com/" target="_blank">Feedreader</a> &mdash; Windows; freeware<br>
            <a href="http://www.sharpreader.com/" target="blank">SharpReader</a> &mdash; Windows; freeware<br>
            <a href="http://my.yahoo.com/" target="_blank">My Yahoo!</a> &mdash; Web-based; free<br>
            <a href="http://reader.rocketinfo.com/desktop/" target="_blank">Rocket RSS Reader</a> &mdash; Web-based; free<br>
            <a href="http://www.pluck.com/" target="_blank">Pluck Reader</a> &mdash; Web-based; free</p></td>
   </tr>
         </table></td>
   </tr>
   <tr class="contentfont">
      <td valign="top" colspan="2"><blockquote>
            <p><b>Just Listed</b><br>
               <a href="rss.php?feed=1"><img src="images/rss.gif" border="0" alt="" align="absmiddle"></a> <a href="http://add.my.yahoo.com/rss?url=<?=SITE_PATH;?>rss.php?feed=1"><img src="images/myyahoo.gif" border="0" alt="" align="absmiddle"></a> <a href="<?=SITE_PATH;?>rss.php?feed=1">
               <?=SITE_PATH;?>
               rss.php?feed=1</a></p>
            <p><b>Closing Soon</b><br>
               <a href="rss.php?feed=2"><img src="images/rss.gif" border="0" alt="" align="absmiddle"></a> <a href="http://add.my.yahoo.com/rss?url=<?=SITE_PATH;?>rss.php?feed=2"><img src="images/myyahoo.gif" border="0" alt="" align="absmiddle"></a> <a href="<?=SITE_PATH;?>rss.php?feed=2">
               <?=SITE_PATH;?>
               rss.php?feed=2</a></p>
            <p><b>Featured Items</b><br>
               <a href="rss.php?feed=3"><img src="images/rss.gif" border="0" alt="" align="absmiddle"></a> <a href="http://add.my.yahoo.com/rss?url=<?=SITE_PATH;?>rss.php?feed=3"><img src="images/myyahoo.gif" border="0" alt="" align="absmiddle"></a> <a href="<?=SITE_PATH;?>rss.php?feed=3">
               <?=SITE_PATH;?>
               rss.php?feed=3</a></p>
            <p><b>Big Ticket</b><br>
               <a href="rss.php?feed=4"><img src="images/rss.gif" border="0" alt="" align="absmiddle"></a> <a href="http://add.my.yahoo.com/rss?url=<?=SITE_PATH;?>rss.php?feed=4"><img src="images/myyahoo.gif" border="0" alt="" align="absmiddle"></a> <a href="<?=SITE_PATH;?>rss.php?feed=4">
               <?=SITE_PATH;?>
               rss.php?feed=4</a></p>
            <p><b>Very Expensive</b><br>
               <a href="rss.php?feed=5"><img src="images/rss.gif" border="0" alt="" align="absmiddle"></a> <a href="http://add.my.yahoo.com/rss?url=<?=SITE_PATH;?>rss.php?feed=5"><img src="images/myyahoo.gif" border="0" alt="" align="absmiddle"></a> <a href="<?=SITE_PATH;?>rss.php?feed=5">
               <?=SITE_PATH;?>
               rss.php?feed=5</a></p>
            <p><b>Item Under $10</b><br>
               <a href="rss.php?feed=6"><img src="images/rss.gif" border="0" alt="" align="absmiddle"></a> <a href="http://add.my.yahoo.com/rss?url=<?=SITE_PATH;?>rss.php?feed=6"><img src="images/myyahoo.gif" border="0" alt="" align="absmiddle"></a> <a href="<?=SITE_PATH;?>rss.php?feed=6">
               <?=SITE_PATH;?>
               rss.php?feed=6</a></p>
            <p><b>Warm Items</b><br>
               <a href="rss.php?feed=7"><img src="images/rss.gif" border="0" alt="" align="absmiddle"></a> <a href="http://add.my.yahoo.com/rss?url=<?=SITE_PATH;?>rss.php?feed=7"><img src="images/myyahoo.gif" border="0" alt="" align="absmiddle"></a> <a href="<?=SITE_PATH;?>rss.php?feed=7">
               <?=SITE_PATH;?>
               rss.php?feed=7</a></p>
            <p><b>Hot Items</b><br>
               <a href="rss.php?feed=8"><img src="images/rss.gif" border="0" alt="" align="absmiddle"></a> <a href="http://add.my.yahoo.com/rss?url=<?=SITE_PATH;?>rss.php?feed=8"><img src="images/myyahoo.gif" border="0" alt="" align="absmiddle"></a> <a href="<?=SITE_PATH;?>rss.php?feed=8">
               <?=SITE_PATH;?>
               rss.php?feed=8</a></p>
            <p><b>Buy It Now Items</b><br>
               <a href="rss.php?feed=9"><img src="images/rss.gif" border="0" alt="" align="absmiddle"></a> <a href="http://add.my.yahoo.com/rss?url=<?=SITE_PATH;?>rss.php?feed=9"><img src="images/myyahoo.gif" border="0" alt="" align="absmiddle"></a> <a href="<?=SITE_PATH;?>rss.php?feed=9">
               <?=SITE_PATH;?>
               rss.php?feed=9</a></p>
         </blockquote></td>
   </tr>
</table>
