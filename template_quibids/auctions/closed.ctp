<div id="ending-soon" class="box">
	<div class="f-top clearfix"><h2><?php __('Closed Auctions'); ?></h2>
	<p>These auctions have ended. Look out for more great bargains!</p></div>
	<div class="f-repeat clearfix">
		<div class="content">
			
			<?php if(!empty($auctions)) : ?>
				<?php if(!empty($appConfigurations['endedLimit'])) : ?>
				<p><strong><?php __('Showing the last');?> <?php echo $appConfigurations['endedLimit']; ?> <?php __('auctions.');?></strong></p>	
				<?php else : ?>	
				<?php endif; ?>
					
				<?php //echo $this->element('auctions'); ?>
				
				
				
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
<ul class="horizontal-bid-list">
	<?php foreach($auctions as $auction):?>
	<li class="auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">
		<div class="content">
			<h3><?php echo $html->link($text->truncate($auction['Product']['title'],25), AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']));?></h3>
			<div class="thumb clearfix">
				<a href="<?php echo $appConfigurations['url'].AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>">
				
				<?php if(!empty($auction['Auction']['image'])):?>
					<?php echo $html->image($auction['Auction']['image']); ?>
				<?php else:?>
					<?php echo $html->image('product_images/thumbs/no-image.gif');?>
				<?php endif;?>
				</a>
			</div>
			<div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown clearfix" title="<?php echo $auction['Auction']['end_time'];?>">--:--:--</div>
			
			<div class="rrpprice clearfix"><span class="bid-price1">Retail Price: <?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></span></div>
			
			<div class="price clearfix">
				<?php if(!empty($auction['Product']['fixed'])):?>
					<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?>
					<span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
				<?php else: ?>
					<span class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
				<?php endif; ?>
			</div>
			<div class="username bid-bidder clearfix">Highest bidder</div>
			<div class="bid-now clearfix">
				<?php if(!empty($auction['Auction']['isFuture'])) : ?>
					<div><img src="<?php echo $this->webroot; ?>img/button/b-soon.gif" width="94" height="32" alt="Please wait until the auction begins" title="Please wait until the auction begins"></div>
				 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
					<div><img src="<?php echo $this->webroot; ?>img/button/b-sold.gif" width="94" height="32" alt="????????" title="????????"></div>
				 <?php else:?>
					 <?php if($session->check('Auth.User')):?>
						<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
						 <div class="bid-button"><a class="bid-button-link button-small" title="<?php echo $auction['Auction']['id'];?>" href="<?php echo $appConfigurations['url'];?>/bid.php?id=<?php echo $auction['Auction']['id'];?>">Bid</a></div>
					<?php else:?>
						<div class="bid-button"><a href="/users/login" class="b-login"><?php __(@$j['menu_my_login']);?></a></div>
					<?php endif;?>
				<?php endif; ?>
			</div>
			<div class="bid-msg">
				<div class="bid-message"></div>
			</div>
			<div class="auction-item-bottom"></div>
		</div>
	</li>
	<?php endforeach;?>
</ul>

				
				
				
				
				
					
					<?php //echo $this->element('pagination'); ?>

			<?php else: ?>
				<div class="align-center off_message"><p><?php __('There are no closed auctions at the moment.');?></p></div>
			<?php endif; ?>
		</div>
	<br class="clear_l">
	<div class="crumb_bar">
			<?php
			$html->addCrumb(__('Closed Auctions', true), '/auctions/closed');
			echo $this->element('crumb_auction');
			?>
	</div>
	</div>
	<div class="f-bottom-top clearfix"><p class="page_top"><a href="#" id="link_to_top">PAGE TOP</a></p></div>
</div>