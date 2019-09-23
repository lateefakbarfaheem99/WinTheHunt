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