<div align="center" class="search" style="width:100%;padding-left:10px;height:55px;"> 
	 <script language="javascript" src="<?php echo $appConfigurations['nml_url'];?>/js/jquery/jquery.autocomplete.js"></script> 
	<script type="text/javascript"> 
	//&lt;![CDATA[
	  jQuery(function() {
		var onAutocompleteSelect = function(value, data) {
		  jQuery('#selection').html('&lt;img src="\/global\/flags\/small\/' + data + '.png" alt="" \/&gt; ' + value);
		}
		var options = {
		  serviceUrl: '<?php echo $appConfigurations['nml_url'];?>/search.php',
		  width: 714,
		  delimiter: /(,|;)\s*/,
		  onSelect: onAutocompleteSelect,
		  deferRequestBy: 0, //miliseconds
		  params: { },
		  noCache: false //set to true, to disable caching
		};
		a1 = jQuery('#query').autocomplete(options);
	  });
	//]]&gt;
	</script> 
	<form action="<?php echo $appConfigurations['nml_url'];?>/auctions/search/" onsubmit="return checkvalidation();" id="searchFrm" method="POST"> 
		<fieldset>
			<input type="text" style="height: 30px; width: 714px; float: left; padding: 8px 0px 0px 50px; font-size: 18px;" value="Search for an item by keyword" onblur="click_search('out',this);" onclick="click_search('in',this);" id="query" name="data[Auction][search]" class="search_input" autocomplete="off">
			<input type="hidden" id="search_id" name="data[Auction][auction_id]">
			<input type="hidden" value="0" id="reload_java" class="reload_java">
			<div class="submit" style="margin:0px;padding:0px;"><input type="submit" value="Search" name="search" class="search_btn"></div>
	   <fieldset>
	</form>
</div>