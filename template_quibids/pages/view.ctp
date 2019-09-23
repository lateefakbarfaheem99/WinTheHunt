<?php
$ca = $this->params['action'];
$cc = $this->params['controller'];
$url = $this->params['url']['url'];
if($url == 'page/about' ){$aboutClass ='active';}
if($url == 'news' ){$latest_newsClass ='active';}
if($cc == 'auctions' && $ca == 'home'){$startClass ='active';}
if($url == 'page/help'){$helpClass ='active';}
if($cc == 'users' && $ca == 'index'){$contactClass ='active';}
if($url == 'page/suggestions' ){$suggestionClass ='active';}
if($url == 'page/privacy' ){$privacyClass ='active';}
if($url == 'page/terms' ){$termsClass ='active';}
if($cc == 'categories' ){$categoriesClass ='active';}
if($url == 'page/sitemap' ){$sitemapClass ='active';}
?>
<div class="box clearfix">
	<div class="f-top clearfix">
    	<h2><?php echo $page['Page']['title']; ?></h2>
	    <p class="Txt3"><span class="TxtRed">Win Awesome Products at Amazing Prices!</span></p>
    </div>
	<div class="f-repeat clearfix">
        <div id="QuickLinks">
              <p class="Hdg">QUICK LINKS</p>
              <div class="Btm">
                <div class="Content">
                  <ul>
                    <li class="active"><a class="<?php echo $aboutClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/page/about">About WinTheHunt?</a></li>
                    <li class="Seperator"></li>
                    <li><a class="<?php echo $latest_newsClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/news">Latest News</a></li>
                    <li class="Seperator"></li>
                    <li><a class="<?php echo $startClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/page/start">Getting Started</a></li>
                    <li class="Seperator"></li>
                    <li><a class="<?php echo $helpClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/page/help">Help</a></li>
                    <li class="Seperator"></li>
                    <li><a class="<?php echo $contactClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/contact">Contact Us</a></li>
                    <li class="Seperator"></li>
                    <li><a class="<?php echo $suggestionClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/suggestion">Suggestions</a></li>
                    <li class="Seperator"></li>
                    <li><a class="<?php echo $privacyClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/page/privacy">Privacy Policy</a></li>
                    <li class="Seperator"></li>
                    <li><a class="<?php echo $termsClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/page/terms">Terms &amp; Conditions</a></li>
                    <li class="Seperator"></li>
                    <li><a class="<?php echo $categoriesClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/categories">Categories</a></li>
                    <li class="Seperator"></li>
                    <li><a class="<?php echo $sitemapClass;?>" href="<?php echo $appConfigurations['nml_url'];?>/page/sitemap">Sitemap</a></li>
                    <li class="Seperator"></li>
                  </ul>
                  <p>Register now! to bid and win <br/>exciting items at awesome prices!</p>
                  <a href="<?php echo $appConfigurations['nml_url'];?>/users/register"><img class="Register" src="<?php echo $appConfigurations['nml_url'];?>/img/btn_register.jpg" width="171" height="43" alt="REGISTER NOW" title="REGISTER NOW" /></a>
                  <!-- /Content -->
                </div>
                <!-- /Btm -->
              </div>
              <!-- /QuickLinks -->
            </div>
		<div class="AbtUsTxt">
			<?php echo $page['Page']['content']; ?>
		</div>
	</div>
	<div class="f-bottom clearfix"><p class="page_top"><a href="#" id="link_to_top">PAGE TOP</a></p></div>
</div>
