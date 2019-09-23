<?php if(1) { ?> 
<LINK rel="stylesheet" type="text/css" href="<?php echo $appConfigurations['nml_url'];?>/css/slide/style_slide.css">
<LINK rel="stylesheet" type="text/css" href="<?php echo $appConfigurations['nml_url'];?>/css/slide/skin_slide.css">
<SCRIPT type="text/javascript" src="<?php echo $appConfigurations['nml_url'];?>/css/slide/jquery.jcarousel.min.js"></SCRIPT>
  <SCRIPT type="text/javascript">  
  function mycarousel_initCallback(carousel)
  {
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
      carousel.startAuto(0);
    });
 
    carousel.buttonPrev.bind('click', function() {
      carousel.startAuto(0);
    });
 
    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
      carousel.stopAuto();
    }, function() {
      carousel.startAuto();
    });
  };
   
  jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
      auto: 5, 
      wrap: 'last',
      initCallback: mycarousel_initCallback
    });
  });
  </SCRIPT> 
  <?php } ?>

<!-- sliding auctions start -->
<?php 

if($this->action == 'home') { 
	//$banner_auctions = $this->requestAction('/auctions/get_bannerAuction/50');
	if(!empty($banner_auctions) || 1) {	
//echo '<pre>';print_r($banner_auctions);
	?>
<DIV id="MainProdDisp">
	<div class="MainProdTop"></div>
	<div class="MainProdBtm">
	<DIV class="slider">
	  <DIV class=" jcarousel-skin-tango">
	  	<DIV class="jcarousel-container jcarousel-container-horizontal" style="position: relative; display: block; ">
	  		
	  		<DIV class="jcarousel-clip jcarousel-clip-horizontal" style="overflow-x: hidden; overflow-y: hidden; position: relative; ">
	  			<UL id="mycarousel" class="jcarousel-list jcarousel-list-horizontal" style="overflow-x: hidden; overflow-y: hidden; position: relative; top: 0px; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; width: 1800px; left: -900px; "> 
			<!-- start html loop -->
					<li ><img src="<?php echo $this->webroot; ?>img/Elk-Hunt-Banner.jpg" alt="" /> </li>
					<li><img src="<?php echo $this->webroot; ?>img/How-winthehunt-works-banner.jpg" alt="" /></li>
					<li><img src="<?php echo $this->webroot; ?>img/Hours-banner.jpg" alt="" /></li>
					<li><a href="/users/register"><img src="<?php echo $this->webroot; ?>img/Register-Banner.jpg" alt="" /></a></li> 
			  <!-- start html loop -->    
	        	</UL>
	      	</DIV>
		    <DIV class="jcarousel-prev jcarousel-prev-horizontal" style="display: block; " disabled="false"></DIV>
		    <DIV class="jcarousel-next jcarousel-next-horizontal" style="display: block; " disabled="false"></DIV>
	  	</DIV>
	  	</DIV> 
	  </DIV> 
	</DIV> 
</DIV> 
<?php } } ?>
<!-- sliding auctions end -->