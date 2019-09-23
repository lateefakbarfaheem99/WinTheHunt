<style>
ul.horizontal-bid-list li .rrpprice {
	background:url("../img/productBoxGreyLine.jpg") no-repeat scroll center bottom transparent;
	color:#cecece;
	font:11px/100% Arial,Helvetica,sans-serif;
	letter-spacing:-1px;
	margin:0;
	padding:5px 0 12px;
}
</style>
<div id="StepsArea">
    <div class="Step1">
      <p class="Hdg">Register to get points!</p>
      <p class="Txt">Register for a free account and receive 5 FREE Points. Register Now! it's FREE!<br/><br/></p>
      <a href="<?php echo $appConfigurations['nml_url'];?>/users/register"><input class="BtnRegister" type="image" src="<?php echo $appConfigurations['nml_url'];?>/img/register_now.gif" /></a>
      <!-- /Step1 -->
    </div>
    <div class="Step2">
      <p class="Hdg">Bid on an Item</p>
      <p class="Txt">Bid to win great gear!  Get Points!</p>
      <p class="LinkArea">...<a href="<?php echo $appConfigurations['nml_url'];?>/packages">view packages</a>&gt;&gt;</p>
      <!-- /Step2 -->
    </div>
    <div class="Step3">
    	<?php echo $this->element('latest_winner'); ?>
      <!-- /Step3 -->
    </div>
    <!--  /StepsArea -->
</div>
          
<?php 
//echo "<pre>";print_r($auctions_end_soon);
if(!empty($auctions_end_soon)) : ?>
<div id="ending-soon" class="box" style="margin-top:0;">
	<div class="f-top clearfix">	
	<div class="top_h2_l"><h2>Hurry! Use your points to bid!</h2></div>
	<div class="top_h2_r Txt3">
    	<!-- Free guide start -->
<!-- 		<a href="#" id="trigger_topguide"> -->
<!--         	<img src="<?php echo $appConfigurations['nml_url'];?>/img/parts/help_icon.png" width="19" height="19" border="0" alt="" title=""> -->
<!--         </a> -->
<!-- 		<div class="tooltip_t"> -->
<!-- 			<p class="bold orange2" style="margin-bottom:3px;">View list of auctions</p> -->
<!-- 			Every time a bid is placed, the auction extends its time by a set amount. When it hits zero, you win!  -->
<!-- 			<img src="<?php echo $appConfigurations['nml_url'];?>/img/guide/topguide.jpg" width="320" height="290" alt="" title=""> -->
<!-- 		</div> -->
<!-- 		<script> -->
<!--         $(function() { -->
<!--         $("#trigger_topguide").tooltip(); -->
<!--         }); -->
<!--         </script> -->
		<!-- Free guide end -->
		<label>Bid until the countdown hits zero. <span class="TxtRed">The most recent bidder wins!</span></label>
	</div>
	<br class="clear_br">	
	</div>
	<div class="f-repeat clearfix">
		<div class="content">
			<ul class="horizontal-bid-list">
				<?php 
				//echo "<pre>";
				//print_r($auctions_end_soon);
				foreach($auctions_end_soon as $auction):?>
				<li class="auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">				
					<?php if(!empty($auction['Product']['fixed'])):?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="fixed"></span></a><?php endif; ?><?php if(!empty($auction['Auction']['free'])) : ?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="free"></span></a><?php endif; ?>
					<div class="content">
						<h3><?php echo $html->link($text->truncate($auction['Product']['title'],25), array('action' => 'view', $auction['Auction']['id']));?></h3>
						<div class="thumb clearfix">
							<a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="<?php if(!empty($auction['Auction']['penny'])):?> penny<?php endif;?><?php if(!empty($auction['Auction']['peak_only'])):?> peak_only<?php endif;?><?php if(!empty($auction['Auction']['nail_bitter'])):?> nail<?php endif;?><?php if(!empty($auction['Auction']['beginner'])):?> beginner<?php endif;?> <?php if(!empty($auction['Auction']['featured'])):?> featured<?php endif;?>"></span>
							<?php 
							if(!empty($auction['Product']['Image']) && !empty($auction['Product']['Image'][0]['image'])) {
								echo $html->image('product_images/thumbs/'.$auction['Product']['Image'][0]['image']);
							} else {
								echo $html->image('product_images/thumbs/no-image.gif');
							} 
							?>
							</a>
						</div>
						<div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown clearfix" title="<?php echo $auction['Auction']['end_time'];?>">--:--:--</div>
						
						<div class="rrpprice clearfix"><span class="bid-price1">Retail Price: <?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></span></div>
						
						<div class="price clearfix">
							<?php if(!empty($auction['Product']['fixed'])):?>
								<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?>
								<span class="bid-price-fixed" style="display:none;">
									<?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>
								</span>
							<?php else: ?>
								<span class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
							<?php endif; ?>
						</div>
						<div class="username bid-bidder clearfix">The highest bidder</div>
						<div class="bid-now clearfix">
							<?php if(!empty($auction['Auction']['isFuture']) && 0) : ?>
								<!-- <div><img src="<?php //echo $appConfigurations['nml_url'];?>/img/button/b-soon.gif" width="94" height="32" alt="" title=""></div> -->
							 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
								<div><img src="<?php echo $appConfigurations['nml_url'];?>/img/button/b-sold.gif" width="94" height="32" alt="" title=""></div>
							 <?php else:?>
								 <?php if($session->check('Auth.User')):?>
									<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
									 <div class="bid-button"><a class="bid-button-link button-small" title="<?php echo $auction['Auction']['id'];?>" href="<?php echo $appConfigurations['nml_url'];?>/bid.php?id=<?php echo $auction['Auction']['id'];?>">Bid</a></div>
								<?php else:?>
									<div class="bid-button"><a href="<?php echo $appConfigurations['nml_url'];?>/users/login" class="b-login"><?php __($j['menu_my_login']);?></a></div>
								<?php endif;?>
							<?php endif; ?>
						</div>
						<div class="bid-msg">
						<div class="bid-message"></div>
						</div>
                        <div class="auction-item-bottom"></div>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
			<br class="clear_br">
			<div class="see-more float-right">
				<?php echo $html->link(__('&nbsp;', true), array('action' => 'index'), null, null, false);?>
			</div>
			<br class="clear_br">
		</div>
	</div>
<!--	<div id="news-info" class="f-repeat clearfix">
		<div class="content" style="padding:10px 25px; margin-bottom:10px;">
			<div class="col1">
			<?php echo $this->element('latest_news'); ?>
			</div>
			<div class="col2">
			<?php echo $this->element('latest_winner'); ?>
			</div>
			<div class="col3">
			<h3 class="orange2 bold font-14" style="margin:0;"><label>Auction News</label></h3>
				<div id="twitter_div" style="width: 240px;height: 128px;overflow: auto;overflow-x: hidden;overflow-y: hidden; margin-bottom:13px;">
				<ul id="twitter_update_list" class="tw_list"></ul>
				</div>

<p class="more" style="border-top:1px dotted #DEDEDE;"><a href="http://twitter.com/1centonline" target="_blank">Twitter<img src="<?php echo $appConfigurations['nml_url'];?>/img/parts/external.png" width="10" height="10" border="0" align="middle" style="vertical-align: baseline; margin-left:3px;"></a></p>
			</div>
		</div>
	</div>-->
<?php if(!empty($auctions_live)) : ?>
	<div class="f-repeat clearfix">
		<div class="content" style="padding:0px 12px 0px 0px; width:921px; margin:0px auto;">
			<div class="bid-heading clearfix">
				<div class="content">
					<div class="col1">Product</div>
					<div class="col2">&nbsp;</div>
					<div class="col3">Price</div>
					<div class="col4">Bidder</div>
					<div class="col5">Countdown</div>
				</div>
			</div>
			<ul class="vertical-bid-list" id="vertical-bid-list">
				<?php
                $i = 0;
                foreach($auctions_live as $auction):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = 'live_bid_lightgray';
                    }
                ?>
				<li class="auction-item <?php echo $class;?>" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">
					<div class="content">
						<div class="col1 thumb">
							<a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="<?php if(!empty($auction['Auction']['penny'])):?> penny<?php endif;?><?php if(!empty($auction['Auction']['peak_only'])):?> peak_only<?php endif;?><?php if(!empty($auction['Auction']['beginner'])):?> beginner<?php endif;?> <?php if(!empty($auction['Auction']['nail_bitter'])):?> nail<?php endif;?><?php if(!empty($auction['Auction']['featured'])):?> featured<?php endif;?><?php if(empty($auction['Auction']['nail_bitter']) && empty($auction['Auction']['penny']) && empty($auction['Auction']['featured']) && empty($auction['Auction']['peak_only'])):?> glossy<?php endif;?>"></span>
							<?php
							if(!empty($auction['Product']['Image']) && !empty($auction['Product']['Image'][0]['image'])) {
								echo $html->image('product_images/thumbs/'.$auction['Product']['Image'][0]['image']);
							} else {
								echo $html->image('product_images/thumbs/no-image.gif');
							}
							?>
							</a>
						</div>
						<div class="col2">
							<h3 class="heading"><?php echo $html->link($auction['Product']['title'], array('action' => 'view', $auction['Auction']['id']));?></h3>
							<?php echo strip_tags($text->truncate($auction['Product']['brief'], 120, '...', false, true));?>
							
							<div><?php if(!empty($auction['Product']['free'])) : ?><a href="<?php echo $appConfigurations['nml_url'];?>/page/auction_type" class="side_2px"><img src="<?php echo $appConfigurations['nml_url'];?>/img/badge/free_label_vertical.png" width="101" height="16" border="0" alt="Free auctions" title="Free auctions"></a><?php endif; ?>
							<?php if(!empty($auction['Product']['fixed'])) : ?><a href="<?php echo $appConfigurations['nml_url'];?>/page/auction_type" class="side_2px"><img src="<?php echo $appConfigurations['nml_url'];?>/img/badge/fixed_label_vertical.png" width="101" height="16" border="0" alt="Fixed price auction" title="Fixed price auction"></a><?php endif; ?></div>
						</div>
						<div class="col3">
							<div class="price">
								<?php if(!empty($auction['Product']['fixed'])) : ?>
									<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']); ?>
									<span class="bid-price-fixed" style="display:none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
								<?php else: ?>
									<div class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></div>
								<?php endif; ?>
							</div>
							<?php if(!empty($auction['Product']['rrp'])): ?>
								<div class="rrp">Retail Price : <?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></div>
							<?php endif; ?>

						</div>
						<div class="col4 bid-bidder">The highest bidder</div>
						<div class="col5">
							 <div id="auctionLive_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>">--:--:--</div>
							<div class="bid-now">
								<?php if(!empty($auction['Auction']['isFuture'])) : ?>
									<div><img src="<?php echo $appConfigurations['nml_url'];?>/img/button/b-soon-w.gif" width="94" height="32" alt="Please wait until auction starts" title="Please wait until the auction starts"></div>
								 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
									<div><img src="<?php echo $appConfigurations['nml_url'];?>/img/button/b-sold-w.gif" width="94" height="32" alt="????????" title="????????"></div>
								 <?php else:?>
									 <?php if($session->check('Auth.User')):?>
										<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
										 <div class="bid-button"><a class="bid-button-link button-small-vertical" title="<?php echo $auction['Auction']['id'];?>" href="<?php echo $appConfigurations['nml_url'];?>/bid.php?id=<?php echo $auction['Auction']['id'];?>">Bid</a></div>
									<?php else:?>
										<div class="bid-button"><a href="<?php echo $appConfigurations['nml_url'];?>/users/login" class="b-login-vertical"><?php __($j['menu_my_login']);?></a></div>
									<?php endif;?>
								<?php endif; ?>
							<div class="bid-message"></div>
							</div>
						</div>
					</div>
				</li>
				<?php endforeach;?>
			</ul>
            <div class="bid-bottom"></div>
	        <br class="clear_br">
	        <div class="see-more float-right">
	        	<?php echo $html->link(__('&nbsp;', true), array('action' => 'index'), null, null, false);?>
	        </div>
	        <br class="clear_br">
		</div>
	</div>
<?php else:?>
	<div class="f-bottom clearfix"><p class="page_top"><a href="#" id="link_to_top">PAGE TOP</a></p></div>
<?php endif; ?>
</div>
<?php endif; ?>


<?php if(!empty($future_auctions)) : ?>
<div id="live-bids" class="box">
	<div class="f-top clearfix">
    	<h2>Upcoming auctions</h2>
        <p class="Txt3"><span class="TxtRed">Add us to your favorites:
        
<!-- Sharing Start -->
	<dd class="foot_dd sharewith" style="float:right; width:auto; padding:0px; margin:17px 0px 0px 9px">
    	<div class="align-center">
        	<a href="http://www.addthis.com/bookmark.php?v=250&amp;pub=xa-4a7c06cd524f654b" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()" style="float:left;"><img src="http://s7.addthis.com/static/btn/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0; float:left;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=xa-4a7c06cd524f654b"></script>

		</div>
    </dd>
<!-- Sharing End -->        
        
        </span></p>
    </div>
	<div class="f-repeat clearfix">
		<div class="content" style="padding:0px 12px 0px 0px; width:921px; margin:0px auto;">
			<div class="bid-heading clearfix">
				<div class="content">
					<div class="col1">Product</div>
					<div class="col2">&nbsp;</div>
					<div class="col3">Price</div>
					<div class="col4">Bidder</div>
					<div class="col5">Countdown</div>
				</div>
			</div>
			<ul class="vertical-bid-list">
				<?php
                $i = 0;
                foreach($future_auctions as $auction):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = 'live_bid_lightgray';
                    }
                ?>
				<li class="auction-item <?php echo $class;?>" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">
					<div class="content">
						<div class="col1 thumb">
							<a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="<?php if(!empty($auction['Auction']['penny'])):?> penny<?php endif;?><?php if(!empty($auction['Auction']['peak_only'])):?> peak_only<?php endif;?><?php if(!empty($auction['Auction']['beginner'])):?> beginner<?php endif;?> <?php if(!empty($auction['Auction']['nail_bitter'])):?> nail<?php endif;?><?php if(!empty($auction['Auction']['featured'])):?> featured<?php endif;?><?php if(empty($auction['Auction']['nail_bitter']) && empty($auction['Auction']['penny']) && empty($auction['Auction']['featured']) && empty($auction['Auction']['peak_only'])):?> glossy<?php endif;?>"></span>
							<?php
							if(!empty($auction['Product']['Image']) && !empty($auction['Product']['Image'][0]['image'])) {
								echo $html->image('product_images/thumbs/'.$auction['Product']['Image'][0]['image']);
							} else {
								echo $html->image('product_images/thumbs/no-image.gif');
							}
							?>
							</a>
						</div>
						<div class="col2">
							<h3 class="heading"><?php echo $html->link($auction['Product']['title'], array('action' => 'view', $auction['Auction']['id']));?></h3>
							<?php echo strip_tags($text->truncate($auction['Product']['brief'], 120, '...', false, true));?>
							
							<div><?php if(!empty($auction['Product']['free'])) : ?><a href="<?php echo $appConfigurations['nml_url'];?>/page/auction_type" class="side_2px"><img src="<?php echo $appConfigurations['nml_url'];?>/img/badge/free_label_vertical.png" width="101" height="16" border="0" alt="Free auctions" title="Free auctions"></a><?php endif; ?>
							<?php if(!empty($auction['Product']['fixed'])) : ?><a href="<?php echo $appConfigurations['nml_url'];?>/page/auction_type" class="side_2px"><img src="<?php echo $appConfigurations['nml_url'];?>/img/badge/fixed_label_vertical.png" width="101" height="16" border="0" alt="Fixed price auction" title="Fixed price auction"></a><?php endif; ?></div>
						</div>
						<div class="col3">
							<div class="price">
								<?php if(!empty($auction['Product']['fixed'])) : ?>
									<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']); ?>
									<span class="bid-price-fixed" style="display:none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
								<?php else: ?>
									<div class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></div>
								<?php endif; ?>
							</div>
							<?php if(!empty($auction['Product']['rrp'])): ?>
								<div class="rrp">Retail Price : <?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></div>
							<?php endif; ?>

						</div>
						<div class="col4 bid-bidder">The highest bidder</div>
						<div class="col5">
							 <div id="auctionLive_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>">--:--:--</div>
							<div class="bid-now">
								<?php if(!empty($auction['Auction']['isFuture'])) : ?>
									<div><img src="<?php echo $appConfigurations['nml_url'];?>/img/button/b-soon-w.gif" width="94" height="32" alt="Please wait until auction starts" title="Please wait until the auction starts"></div>
								 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
									<div><img src="<?php echo $appConfigurations['nml_url'];?>/img/button/b-sold-w.gif" width="94" height="32" alt="????????" title="????????"></div>
								 <?php else:?>
									 <?php if($session->check('Auth.User')):?>
										<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
										 <div class="bid-button"><a class="bid-button-link button-small-vertical" title="<?php echo $auction['Auction']['id'];?>" href="<?php echo $appConfigurations['nml_url'];?>/bid.php?id=<?php echo $auction['Auction']['id'];?>">Bid</a></div>
									<?php else:?>
										<div class="bid-button"><a href="<?php echo $appConfigurations['nml_url'];?>/users/login" class="b-login-vertical"><?php __($j['menu_my_login']);?></a></div>
									<?php endif;?>
								<?php endif; ?>
							<div class="bid-message"></div>
							</div>
						</div>
					</div>
				</li>
				<?php endforeach;?>
			</ul>
            <div class="bid-bottom"></div>
	        <br class="clear_br">
	        <div class="see-more float-right">
	        	<?php echo $html->link(__('&nbsp;', true), array('action' => 'index'), null, null, false);?>
	        </div>
	        <br class="clear_br">
		</div>
	</div>
	<div class="f-bottom clearfix"><p class="page_top"><a href="#" id="link_to_top">PAGE TOP</a></p></div>
</div>
<?php endif; ?>