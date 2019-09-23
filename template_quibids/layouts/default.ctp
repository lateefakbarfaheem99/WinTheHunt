<?php

/**
 * Default layout template.
 */

// template variabels definition

$froozleClass = isset($froozleClass) ? ' ' . $froozleClass : '';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<title><?php echo $title_for_layout; ?>|<?php echo $appConfigurations['name']; ?></title>
<link rel="alternate" type="application/rss+xml" href="/auctions/index.rss" title="<?php __('Live Auctions');?>">
<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico" />
<?php
		if(!empty($meta_description)) :
			echo $html->meta('description', $meta_description);
		endif;
		if(!empty($meta_keywords)) :
			echo $html->meta('keywords', $meta_keywords);
		endif;
		echo $html->css('style');

		echo $javascript->link('jquery/jquery');
		echo $javascript->link('jquery/ui');
		echo $javascript->link('default');

		echo $scripts_for_layout;
	?>
<!--[if lt IE 7]>
		<?php echo $javascript->link('dropdown'); ?>
	<![endif]-->
<?php $water_on = array('register'); ?>
<?php if(in_array($this->action, $water_on)){ ?>
<?= $javascript->link('jquery/jquery.updnWatermark.js') ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $.updnWatermark.attachAll();
	});
	</script>
<?php } ?>
<?php $head_ban = array('home'); ?>
<?php if(in_array($this->action, $head_ban)){ ?>
<?= $javascript->link('jquery/jquery.tools.min.js') ?>
<script type="text/javascript">
	<!--
	// header_banner_space
	$(document).ready(function(){
		$("#menu").css({display:"block"}),
		$("#button").click(function(){
			$("#menu").slideToggle("normal");
		}).css({
			cursor:"pointer"
		});
	});
	-->
	</script>
<script type="text/javascript">
$(document).ready(function(){
	
	var first = 0;
	var speed = 700;
	var pause = 8000;
	
		function removeFirst(){
			first = $('ul#twitter_update_list li:first').html();
			$('ul#twitter_update_list li:first')
			.animate({opacity: 0}, speed)
			.fadeOut('slow', function() {$(this).remove();});
			addLast(first);
		}
		
		function addLast(first){
			last = '<li style="display:none">'+first+'</li>';
			$('ul#twitter_update_list').append(last)
			$('ul#twitter_update_list li:last')
			.animate({opacity: 1}, speed)
			.fadeIn('slow')
		}
	
	interval = setInterval(removeFirst, pause);
});

</script>
<?php } ?>
<script type="text/javascript">
<?php if($_SERVER['HTTP_HOST'] == 'localhost'){ ?>
var dir_name = 'issac_pro/';
<?php  }else{ ?>
var dir_name = '';
<?php  } ?>
</script>



<script type="text/javascript"> 
var startTime=new Date();
var repeat = 20;// dont change this values
var main_ajax_time = 1;// dont change this values
var start = 10;// dont change this values
function currentTime(){ 
  var a=Math.floor((new Date()-startTime)/100)/10;
  if(start != repeat ) { 
	  	start = start + 1;
	  	if(start == 10) { 
	  		 main_ajax_time = '0'; 
	  		 window.location = "http://www.winthehunt.com/idle.html"; 
	  	}
  } else {
  		start = 0;
  }
}
window.onload=function(){
  clearTimeout(loopTime);
  var loopTime=setInterval("currentTime()",60000);  // 6000 = 10mins
}
var IE = document.all?true:false
if (!IE) document.captureEvents(Event.MOUSEMOVE)
document.onmousemove = getMouseXY;
function getMouseXY(e) {
  start = 0;
}
// End -->
</script> 

<?php
$right_cond = $this->params['controller']."->".$this->action;
$right_ary = array('auctions->view');
?>
<?php if(in_array($right_cond, $right_ary)){ ?>
<?= $javascript->link('jquery/jquery.tools.min') ?>
<?= $javascript->link('retweet') ?>
<script type="text/javascript">
	$(document).ready(function(){
		
		var first = 0;
		var speed = 700;
		var pause = 8000;
		
			function removeFirst(){
				first = $('ul#twitter_update_list li:first').html();
				$('ul#twitter_update_list li:first')
				.animate({opacity: 0}, speed)
				.fadeOut('slow', function() {$(this).remove();});
				addLast(first);
			}
			
			function addLast(first){
				last = '<li style="display:none">'+first+'</li>';
				$('ul#twitter_update_list').append(last)
				$('ul#twitter_update_list li:last')
				.animate({opacity: 1}, speed)
				.fadeIn('slow')
			}
		
		interval = setInterval(removeFirst, pause);
	});
	</script>
<?php } ?>
<script type="text/javascript">
	<!--
	// page_top_scroll
	$(function () {
        $('#link_to_top').click(function () {
            $(this).blur();

            $('html,body').animate({ scrollTop: 0 }, 'normal');
            return false;
        });
	});
	-->
	</script>
	<style>
	.right_ads {
float:right;
right:-216px;
position: absolute;
text-align: left;
top: 195px;
}
.wrapper{

position:relative;

}

	
	</style>
</head>
<body style="background: url('/img/bg.jpg');">

<?php include_once("analyticstracking.php") ?> 
<div class="left_icon">  
  <span class="f-icon" ><a target="_blank" href="http://www.facebook.com/pages/Win-The-Hunt/153070788097964">
  <div  class="f-icon-con"></div></a></span>
  
  <span class="t-icon"><a target="_blank" href="http://twitter.com/#!/winthehunt">&nbsp;
  <div class="t-icon-con"></div> </a></a></span>
 
  <span class="c-icon"><a href="/invites">&nbsp; 
  <div class="c-icon-con"></div> </a></a></span>  
 
  </div>
<!--[if lte IE 6]>
<?= $javascript->link('ie6/warning'); ?><script>window.onload=function(){e("<?= $this->webroot ?>/js/ie6/")}</script>
<![endif]-->
<div class="wrapper">
<div class="right_ads">
<a href="http://wildfireapp.com/website/6/contests/165982" target="_blank" >
<img src="/img/banner.jpg" />
</a>
</div>

  <div id="header">
    <div class="logo"> <a href="<?php echo $appConfigurations['nml_url'];?>" title="" class="logo"><span>&nbsp;</span></a>
      <?php if ($_SERVER['SERVER_PORT'] != '443') { ?>
      <?php } ?>
    </div>
    <div class="header_right"> <?php echo $this->element('status');?> </div>
    <div id="sub-header" class="clearfix">
      <div  align="center">
        <div style="width:950px; text-align:left;"> <?php echo $this->element('menu_categories'); ?> </div>
      </div>
    </div>
  </div>
  <div id="MainNav">
    <ul>
      <li ><a class="<?php echo @$homeClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/">HOME</a></li>
      <!--class="Active"-->
      <li><a class="getBids<?php echo $froozleClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/packages">GET BIDS</a></li>
      <?php if(!$session->check('Auth.User')){ ?>
      <li><a class="<?php echo $registerClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/users/register">REGISTER</a></li>
      <?php }else{ ?>
      <li class="<?php echo $myaccountClass;?>"><a href="<?php echo $appConfigurations['nml_url'];?>/users">My ACCOUNT</a></li>
      <?php } ?>
      <li><a class="<?php echo $helpClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/auctions/closed">WINNERS</a></li>
      <li><a class="<?php echo $helpClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/page/help">HELP</a></li>
    </ul>
    <div class="Last">
      <select class="Sbox" onchange="goCatPage(this.value);">
        <option value="all_live">Live Auctions</option>
        <?php foreach($menuCategories as $menuCategory): ?>
        <option value="<?php echo $menuCategory['Category']['id']; ?>" <?php if($menuCategory['Category']['id'] == $selectedCatId ){ echo 'selected';}?>><?php echo $menuCategory['Category']['name']; ?>(<?php echo $menuCategory['Category']['count']; ?>)</option>
        <?php endforeach; ?>
      </select>
    </div>
    <!-- /MainNav -->
  </div>
  <div id="container">
    <div id="maincontent" class="clearfix">
      <div id="maincontent_middle_bg">
        <?php //echo $this->element('ajax_search'); // ajax search plugin element ?>
        <!-- Head Ban Area Start -->
        <?php echo $this->element('home_bnr'); ?>
        <!-- Head Ban Area End -->
        <?php
		        
		       if($session->check('Message.flash')){
                    $session->flash();
                } elseif(@$_COOKIE['reg_complete']) {
                    echo "<div id=\"flashMessage\" class=\"success\">Thank you for registering. An email has been sent with a link to complete your registration. Please check your email inbox and click the confirmation link inside. Please check your SPAM folders if the email does not arrive within five minutes.</div>";
                    setcookie ("reg_complete", "", time() - 3600);
                }
    
                if($session->check('Message.auth')){
                    $session->flash('auth');
                }
				
            ?>
        <?php 
		
		echo $content_for_layout; ?> </div>
    </div>
  </div>
  <?php echo $this->element('footer');?> <?php echo $cakeDebug; ?>
  <?php
$disp_cond = $this->params['controller']."->".$this->action;
if($disp_cond == 'pages->view'){
    if(isset($this->passedArgs[0]))
	$disp_cond .= '->'.$this->passedArgs[0];
}
$cont_ary = array('news->index','auctions->view','auctions->home',
    'pages->view->guide');
?>
  <?php if(in_array($disp_cond, $cont_ary)){ ?>
  <?php if($disp_cond=='news->index' || $disp_cond=='pages->view->guide'){ ?>
  <!-- Twitter JS start -->
  <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
  <script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo Configure::read('Twitter.1centonline'); ?>.json?callback=twitterCallback2&amp;count=5"></script>
  <!-- Twitter JS end -->
  <?php }else{ ?>
  <!-- Twitter JS start -->
  <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
  <script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo Configure::read('Twitter.1centonline'); ?>.json?callback=twitterCallback2&amp;count=10"></script>
  <!-- Twitter JS end -->
  <?php } ?>
  <?php } ?>
</div>
</body>
</html>