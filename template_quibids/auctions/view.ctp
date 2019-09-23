<div id="auction-details" class="box">
	<div class="f-top clearfix">

<div class="detail_head">
<div class="detail_head_l">
<h2><?php echo $auction['Product']['title']; ?></h2>
<p class="Txt3">Bid until the countdown hits zero. <span class="TxtRed">The most recent bidder wins!</span></p>
</div>

<div class="detail_head_r">
<br class="clear_br"></div>
</div><!--detail_head end -->
	</div>
	<div class="f-repeat clearfix" style="padding-bottom:20px;">
		<div class="content">
			<div class="col1">
            	<div class="topheading"><p><?php echo $auction['Product']['title']; ?></p></div>
				<div class="content">
					<div class="auction-image">
						<?php if(!empty($auction['Auction']['image'])):?>
							<?php echo $html->image($auction['Auction']['image'], array('class'=>'productImageMax', 'alt' => $auction['Product']['title'], 'title' => $auction['Product']['title']));?>
						<?php else:?>
							<?php echo $html->image('product_images/max/no-image.gif', array('alt' => $auction['Product']['title'], 'title' => $auction['Product']['title']));?>
						<?php endif; ?><br/><br/><br/>
					</div>
					<div class="thumbs">
						<?php if(!empty($auction['Product']['Image']) && count($auction['Product']['Image']) > 1):?>
								<?php foreach($auction['Product']['Image'] as $image):?>
									<?php if(!empty($image['ImageDefault'])) : ?>
									<span><?php echo $html->link($html->image('default_images/'.$appConfigurations['serverName'].'/thumbs/'.$image['ImageDefault']['image']), '/img/'.$appConfigurations['currency'].'/default_images/max/'.$image['ImageDefault']['image'], array('class' => 'productImageThumb'), null, false);?></span>
								<?php else: ?>
									<span><?php echo $html->link($html->image('product_images/thumbs/'.$image['image']), '/img/product_images/max/'.$image['image'], array('class' => 'productImageThumb'), null, false);?></span>
								<?php endif; ?>
							<?php endforeach;?>
						<?php endif;?>
					</div>				
					<br class="clear_br">
					<div class="align-center" style="margin-bottom:0px;">
					<p style="margin:5px 0 13px; padding:0;"><label>Click to enlarge image</label></p>
				    <?php if(!$session->check('Auth.User')){ ?>
				    		<div style="margin:-3px 0 0 -11px;"><a href="<?php echo $appConfigurations['ref_url']; ?>/users/register" class="button_orage" style="font-size:14px;white-space:nowrap;">Hurry! Register for free bids.</a></div>
				    <?php } ?>

					<?php if($session->check('Auth.User') && empty($auction['Auction']['isClosed'])):?>
						<?php if(!empty($watchlist)):?>
							<div class="bid-addwatchlist" style="margin:-3px 0 0;"><?php echo $html->link(__('Remove from Watchlist', true), array('controller' => 'watchlists', 'action'=>'delete', $watchlist['Watchlist']['id']), null, sprintf(__('Are you sure you want to delete the auction from your watchlist??', true), $watchlist['Watchlist']['id'])); ?></div>
						<?php else:?>
							<div class="bid-addwatchlist" style="margin:-3px 0 0;"><?php echo $html->link(__('Add to Watchlist', true), array('controller' => 'watchlists', 'action' => 'add', $auction['Auction']['id']));?></div>
						<?php endif;?>
					<?php endif;?>
						<div class="bold bkmk align-center"><img src="<?php echo $this->webroot; ?>img/parts/twitter_logo_small.png" width="79" height="21" alt="Twitter" title="Twitter"><a class="retweet self" href=""></a> <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.<?php echo Configure::read('Twitter.username') ?>.com&amp;layout=button_count&amp;show_faces=true&amp;width=100&amp;action=like&amp;font=lucida+grande&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>
					</div>
				</div>
			</div>

			<div class="col2">
            	<div class="topheading">&nbsp;</div>
				<div class="content auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>" style="padding:0; width:100%;">
					<div class="sub-col1" style="margin-bottom:0px;">
						<div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>">--:--:--</div>
						</div>
                        <dd class="price">
                            <?php if(!empty($auction['Product']['fixed'])):?>
                            <?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']); ?><span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auctionItem['Auction']['price'], $appConfigurations['currency']); ?></span><?php else: ?><span class="bid-price"><?php echo $number->currency($auctionItem['Auction']['price'], $appConfigurations['currency']); ?></span><?php endif; ?><br /><!--<span class="vat">Including tax &amp; shipping</span>-->
                        </dd>                      
                         		<?php if(!empty($auction['Auction']['isFuture'])):?>
							<div class="congrats">Auction items will</div>
						<?php endif;?>

						<?php if(!empty($auction['Auction']['isClosed'])):?>
                            <?php if(!empty($auction['Winner']['id'])):?>
                                <!--<div class="congrats orange2">Congratulations!<br><?php echo $auction['Winner']['username'];?> </div>-->
                            <?php else:?>
                                <div class="congrats"><?php __('There was no winner');?></div>
                            <?php endif;?>
                        <?php endif;?>

                         		<?php if(!empty($auction['Auction']['peak_only'])):?>
							<!--<div class="congrats orange2">Peak only auctions</div>-->
						<?php endif;?>

						<?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed']) && empty($auction['Auction']['peak_only'])):?>
							<!--<div class="congrats orange2">
							<?php if(!empty($auction['Product']['fixed'])):?>Fixed<?php endif;?><?php if(!empty($auction['Auction']['penny'])):?>Penny<?php endif;?><?php if(!empty($auction['Product']['free'])):?>Free<?php endif;?> auction listing!
							</div>-->
						<?php endif;?>



						<dl class="current_price clearfix">
                        	<!-- 
							<dt><?php if(!empty($auction['Product']['fixed'])):?><span class="font-18">Flat rate pricing :</span><?php else: ?><?php echo empty($auction['Auction']['isClosed']) ? "Current price :" : "Price :"; ?><?php endif; ?></dt>

							<dt><?php echo empty($auction['Auction']['isClosed']) ? "Latest bidder :" : "Winners :"; ?></dt>
                            -->
							<dd class="username"><span class="bid-bidder">Highest Bidder</span></dd>
                            <div class="current_winner">Highest Bidder</div>
                            <div class="mrp"><span class="saved_red_text"><strong>Retail Price:</strong></span><span class="bid-savings-price1"><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></span></div>
						</dl>
					
						<?php if($buy_it_now):?>
								<dt class="saved_red_text">
								Buy it now :
								</dt>
								<dd class="price_bin">
								<?php echo $number->currency($auction['Product']['buy_now'], $appConfigurations['currency']); ?>
								<br /><span class="vat">Including tax &amp; shipping</span></dd>
						<?php endif; ?>
                    <div class="count-saving">
                    		<!--
							<dl class="saving">
						<?php if(!empty($auction['Product']['rrp'])) : ?>
							<dt class="saving">Normal price :</dt>
							<dd class="saving"><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></dd>
						<?php endif; ?>
						
						
						
							
						<dt class="saving" style="border:0px;"><?php if(!empty($auction['Product']['fixed'])):?>Flat-rate pricing :<?php else: ?><?php echo empty($auction['Auction']['isClosed']) ? "Current price :" : "Price :"; ?><?php endif; ?></dt>
							<?php if(!empty($auction['Product']['fixed'])):?>
								<dd class="saving" style="border:0px;"><?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?></dd>
							<?php else: ?>
								<dd class="saving" style="border:0px;"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></dd>
							<?php endif; ?>
							</dl><br class="clear_br">-->
						<div class="total-savings align-center"><?php if(empty($auction['Auction']['isFuture'])):?><span class="saved_red_text">SAVED:</span><br/><span class="bid-savings-price side_5px"><?php echo $number->currency($auction['Auction']['savings']['price'], $appConfigurations['currency']);?></span><?php endif; ?>
						</div>
					</div>

						<div style="padding-bottom:10px;">
						<?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed'])):?>
<!--						<span class="popup_time">
<a href="#">
<span class="tips"><pre>WIth each bid, the time remaining will increase by <strong class="orange2"><?php echo $timeIncrease; ?> seconds</strong>.</pre>
</span>
<img src="<?php echo $appConfigurations['nml_url'];?>/img/increment/time<?php echo $timeIncrease; ?>.png" class="timeincrement"></a>
</span>-->
						<?php endif; ?>
						
						<div class="bid-now">

							<?php if(!empty($auction['Auction']['isFuture']) && 0) : ?>
								<div><img src="<?php echo $appConfigurations['nml_url'];?>/img/button/b-soon-big.gif" width="199" height="59" alt="Please wait for the auction to begin" title="Please wait for the auction to begin"></div>
							 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
								<div><img src="<?php echo $appConfigurations['nml_url'];?>/img/button/b-sold-big.gif" alt="" title=""></div>
							 <?php else:?>
								 <?php if($session->check('Auth.User')):?>
									<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows-white.gif');?></div>
									<div class="bid-button"><a class="bid-button-link button-big" title="<?php echo $auction['Auction']['id'];?>" href="<?php echo $appConfiguration['nml_url'];?>/bid.php?id=<?php echo $auction['Auction']['id'];?>">Bid!</a></div>
								<?php else:?>
									<div class="bid-button"><a href="<?php echo $appConfiguration['nml_url'];?>/users/login" class="b-login-big"><?php __($j['menu_my_login']);?></a></div>
								<?php endif;?>
							<?php endif; ?>
						
						<?php if($buy_it_now):?>
							<div class="submit" style="padding-left:5px">
									<input type="submit" 
										onclick="window.location='/auctions/buy/<?php echo $auction['Auction']['id']; ?>'" 
										value="Buy it now!"
										style="width:194px; padding-top:2px; height:30px">
									</div>
						<?php endif; ?>
						</div>
<!--						
						<?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed'])):?>
						<div class="bid-msg">
							<div class="bid-message" style="display: none"></div>
						</div>
						<?php endif; ?>

						<?php if(!empty($auction['Product']['fixed']) && empty($auction['Auction']['isClosed'])):?>
							<div class="note"><?php if(!empty($auction['Product']['free'])):?>Free listing! Costs nothing. <br><?php endif; ?>To the highest bidder, flat rate pricing:<span class="side_2px bold blk"><?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?></span>You can bid.</div>
						<?php endif; ?>
						<?php if(empty($auction['Auction']['isClosed']) && empty($auction['Auction']['isFuture']) && empty($auction['Product']['fixed'])):?>
							<div class="note"><?php if(!empty($auction['Product']['free'])):?>Free listing! Costs nothing. <br><?php endif; ?>With each bid, the auction price increases by <span class="side_2px bold blk"><?php echo $bidIncrease; ?></span></div>
						<?php endif; ?>
-->
					</div>


				</div>
			</div>

			<div class="col3">

			
<!-- the tabs -->
<ul class="tabs">
	<li><a href="#t1">BIDDING HISTORY</a></li>
	
	<?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed']) && empty($auction['Auction']['nail_bitter']) && $session->check('Auth.User')):?>
	<li><a href="#t2">Bid Butlers</a></li>
	<?php endif;?>
</ul>

<!-- tab "panes" -->
<div class="panes">
	<div class="bid-history bid-histories" id="bidHistoryTable<?php echo $auction['Auction']['id'];?>">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<thead>
				<tr>
					<th width="95"><label><?php __('Time');?></label></th>
					<th width="69"><label><?php __('Bidder');?></label></th>
					<th><label><?php __('Type');?></label></th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($bidHistories)):?>
					<?php foreach($bidHistories as $bid):?>
					<tr>
						<td><?php echo $time->niceShort($bid['Bid']['created']);?></td>
						<td><?php echo $bid['User']['username'];?></td>
						<td><?php echo $bid['Bid']['description'];?></td>
					</tr>
					<?php endforeach;?>
				<?php endif;?>
				<?php if(empty($bidHistories)):?>
				<tr><td colspan="3" align="center" style="border-bottom:0px;"><p class="align-center bold" style="padding-top:30px; color:#AAA; font-size:12px;"><label><?php __('No bids have been placed yet.');?></label></p></td></tr>
				<?php endif;?>
			</tbody>
		</table>
	</div>
	<?php if(empty($auction['Auction']['isFuture']) && empty($auction['Auction']['isClosed']) && empty($auction['Auction']['nail_bitter']) && $session->check('Auth.User')):?>
		<div class="bid-history bid-histories">
			<p>Please enter a range</p>
				<?php echo $form->create('Bidbutler', array('url' => '/bidbutlers/add/'.$auction['Auction']['id']));?>
					<fieldset class="auto">
					<label for="BidbutlerMinimumPrice">Starting Bid Amount</label><input class="disabled" name="data[Bidbutler][minimum_price]" type="text" maxlength="6" value="" id="BidbutlerMinimumPrice" /><span class="unit"><?php echo $appConfigurations['currency'];?></span>
					<label for="BidbutlerMaximumPrice">Maximum bid</label><input class="disabled" name="data[Bidbutler][maximum_price]" type="text" maxlength="6" value="" id="BidbutlerMaximumPrice" /><span class="unit"><?php echo $appConfigurations['currency'];?></span>
					<label for="BidbutlerBids">Number of bids</label><input class="disabled" name="data[Bidbutler][bids]" type="text" maxlength="6" value="" id="BidbutlerBids" /><span class="unit"></span>
					</fieldset>
				<span class="submit"><input type="submit" value="Set Bid"/></span>
				<p class="bold"><a href="<?php echo $appConfiguration['nml_url'];?>/bidbutlers">Your Bid Butler settings</a></p>
		</div>
		<?php endif;?>
	</div>
	<script>
	$(function() {
		$("ul.tabs").tabs("div.panes > div", {history: true});
	});
	</script>
		  </div>
		</div>
	</div>

<!-- upcoming auctions -->

	<?php if(!empty($auctions_end_soon)) : ?>

	<div class="f-repeat clearfix" >

			<ul class="horizontal-bid-list">
				
				<li class="auction-item"></li><li class="auction-item"></li>
				
				<?php 
				//echo "<pre>";
				//print_r($auctions_end_soon);
				
				foreach($auctions_end_soon as $auction_detail):?>
				<li class="auction-item" title="<?php echo $auction_detail['Auction']['id'];?>" id="auction_<?php echo $auction_detail['Auction']['id'];?>">				
					<?php if(!empty($auction_detail['Product']['fixed'])):?><a href="<?php echo AppController::AuctionLinkFlat($auction_detail['Auction']['id'], $auction_detail['Product']['title']); ?>"><span class="fixed"></span></a><?php endif; ?><?php if(!empty($auction_detail['Auction']['free'])) : ?><a href="<?php echo AppController::AuctionLinkFlat($auction_detail['Auction']['id'], $auction_detail['Product']['title']); ?>"><span class="free"></span></a><?php endif; ?>
					<div class="content">
						<h3><?php echo $html->link($text->truncate($auction_detail['Product']['title'],25), array('action' => 'view', $auction_detail['Auction']['id']));?></h3>
						<div class="thumb clearfix">
							<a href="<?php echo AppController::AuctionLinkFlat($auction_detail['Auction']['id'], $auction_detail['Product']['title']); ?>"><span class="<?php if(!empty($auction_detail['Auction']['penny'])):?> penny<?php endif;?><?php if(!empty($auction_detail['Auction']['peak_only'])):?> peak_only<?php endif;?><?php if(!empty($auction_detail['Auction']['nail_bitter'])):?> nail<?php endif;?><?php if(!empty($auction_detail['Auction']['beginner'])):?> beginner<?php endif;?> <?php if(!empty($auction_detail['Auction']['featured'])):?> featured<?php endif;?>"></span>
							<?php 
							if(!empty($auction_detail['Product']['Image']) && !empty($auction_detail['Product']['Image'][0]['image'])) {
								echo $html->image('product_images/thumbs/'.$auction_detail['Product']['Image'][0]['image']);
							} else {
								echo $html->image('product_images/thumbs/no-image.gif');
							} 
							?>
							</a>
						</div>
						<div id="timer_<?php echo $auction_detail['Auction']['id'];?>" class="timer countdown clearfix" title="<?php echo $auction_detail['Auction']['end_time'];?>">--:--:--</div>
						
						<div class="rrpprice clearfix"><span class="bid-price1">Retail Price: <?php echo $number->currency($auction_detail['Product']['rrp'], $appConfigurations['currency']); ?></span></div>
						
						<div class="price clearfix">
							<?php if(!empty($auction_detail['Product']['fixed'])):?>
								<?php echo $number->currency($auction_detail['Product']['fixed_price'], $appConfigurations['currency']);?>
								<span class="bid-price-fixed" style="display:none;">
									<?php echo $number->currency($auction_detail['Auction']['price'], $appConfigurations['currency']); ?>
								</span>
							<?php else: ?>
								<span class="bid-price"><?php echo $number->currency($auction_detail['Auction']['price'], $appConfigurations['currency']); ?></span>
							<?php endif; ?>
						</div>
						<div class="username bid-bidder clearfix">The highest bidder</div>
						<div class="bid-now clearfix">
							<?php if(!empty($auction_detail['Auction']['isFuture']) && 0) : ?>
								<!-- <div><img src="<?php //echo $appConfigurations['nml_url'];?>/img/button/b-soon.gif" width="94" height="32" alt="" title=""></div> -->
							 <?php elseif(!empty($auction_detail['Auction']['isClosed'])) : ?>
								<div><img src="<?php echo $appConfigurations['nml_url'];?>/img/button/b-sold.gif" width="94" height="32" alt="" title=""></div>
							 <?php else:?>
								 <?php if($session->check('Auth.User')):?>
									<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
									 <div class="bid-button"><a class="bid-button-link button-small" title="<?php echo $auction_detail['Auction']['id'];?>" href="<?php echo $appConfigurations['nml_url'];?>/bid.php?id=<?php echo $auction_detail['Auction']['id'];?>">Bid</a></div>
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


	</div>
	
	<?php endif; ?>

<!-- end of upcoming auctions -->


	<div class="f-bottom clearfix">&nbsp;</div>
</div>



<div id="product-desc" class="box">
	<div class="f-top clearfix">
	  <h2 style="font-size:20px;"><?php echo $auction['Product']['title']; ?> - Product Information</h2>
      <p class="Txt3"><span class="TxtRed">Add us to your favorites:
<!-- Sharing Start -->
	<dd class="foot_dd sharewith" style="float:right; width:auto; padding:0px; margin:17px 0px 0px 9px">
    	<div class="align-center">
        	<a href="http://www.addthis.com/bookmark.php?v=250&amp;pub=xa-4a7c06cd524f654b" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()" style="float:left;"><img src="http://s7.addthis.com/static/btn/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0; float:left;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=xa-4a7c06cd524f654b"></script>

		</div>
    </dd>
<!-- Sharing End --> 
		</span>
      </p>
	</div>
	<div class="f-repeat clearfix">
		<div class="content">
			<?php echo $auction['Product']['description'];?>
		</div>
	</div>
	<div class="f-bottom clearfix">&nbsp;</div>
</div>
<div id="payment-info" class="box">
	<div class="f-top clearfix"><h2>Payment Information</h2></div>
	<div class="f-repeat clearfix" style="padding-left:11px; padding-bottom:15px; width:955px;">
        	<div class="PmtMthd">
              <p class="Hdg1"><span class="Sec1">PAYMENT METHODS</span><span class="Sec2">DELIVERY COST</span><span class="Sec3">DELIVERY TIME</span>ANY QUESTIONS?</p>
              <div class="Btm">
                <div class="Content">
                  <p class="PmtDet"><span class="Sec1">Visa, Mastercard</span>
                  <span class="Sec2">
                  <?php echo $auction['Product']['delivery_cost'] ?>
                  </span><span class="Sec3">
                  <?php echo $auction['Product']['delivery_information'] ?>
                  </span><a href="/contact" style="font-weight:normal;">Contact us</a></p>
                  <!-- /Content -->
                </div>
                <!-- /Btm -->
              </div>
              <!--/PmtMthd -->
            </div>
<!--    	<div class="content" style="padding:10px 25px; margin-bottom:10px;">
        	<div class="col1">
            <dl>
            <dt>Auction ID :</dt>
            <dd><?php echo $auction['Auction']['id'];?></dd>
            <dt>Auction type :</dt>
            <dd><?php if(!empty($auction['Product']['free'])):?>
                        <?php echo $html->link('Free auctions', '/page/auction_type', null, null, false); ?>							
                    <?php endif; ?>
                    <?php if(!empty($auction['Product']['fixed'])):?>
                        <?php echo $html->link('Fixed price auctions', '/page/auction_type', null, null, false); ?>							
                    <?php endif; ?>
                    <?php if(!empty($auction['Auction']['penny'])):?>
                        <?php echo $html->link('1p auctions', '/page/auction_type', null, null, false); ?>
                    <?php endif; ?>
                    <?php if(!empty($auction['Auction']['nail_bitter'])):?>
                        <?php echo $html->link('Nailbiter auctions', '/page/auction_type', null, null, false); ?>
                    <?php endif; ?>
                    <?php if(!empty($auction['Auction']['peak_only'])):?>
                        <?php echo $html->link('Peak only auctions', '/page/auction_type', null, null, false); ?>
                    <?php endif; ?>
                    <?php if(empty($auction['Product']['free']) && empty($auction['Product']['fixed']) && empty($auction['Auction']['penny']) && empty($auction['Auction']['nail_bitter']) && empty($auction['Auction']['peak_only'])):?>
                        <?php echo $html->link('Normal Auctions', '/page/auction_type', null, null, false); ?>
                    <?php endif; ?>
                    </dd>
            <dt>Payment :</dt>
            <dd>Credit/Debit Cards &amp; Paypal</dd>
            </dl>
        </div>

        <div class="col2">
            <dl>
                     <?php if(!empty($auction['Auction']['isFuture'])):?>
            <dt>Prices start :</dt>
            <dd><span class="side_5px">$</span><?php echo $auction['Product']['start_price'];?></dd>
            <dt>Scheduled start date :</dt>
            <dd><?php echo $time->nice($auction['Auction']['start_time']);?></dd>
            <dt>Closing date :</dt>
            <dd><?php echo $time->nice($auction['Auction']['end_time']);?></dd>
            
            <?php elseif(!empty($auction['Auction']['isClosed'])):?>
            <dt>Prices start at :</dt>
            <dd><span class="side_5px">£</span><?php echo $auction['Product']['start_price'];?></dd>
            <dt>Start time :</dt>
            <dd><?php echo $time->nice($auction['Auction']['start_time']);?></dd>
            <dt>End time :</dt>
            <dd><?php echo $time->nice($auction['Auction']['end_time']);?></dd>
            <?php else: ?>
            <dt>Prices start at :</dt>
            <dd><span class="side_5px">¥</span><?php echo $auction['Product']['start_price'];?></dd>
            <dt>Start time :</dt>
            <dd><?php echo $time->nice($auction['Auction']['start_time']);?></dd>
            <dt>End time :</dt>
            <dd><?php echo $time->nice($auction['Auction']['end_time']);?></dd>
            <?php endif;?>
            </dl>
        </div>
        <div class="col3">
            <dl>
            <dt>Shipping Fee :</dt>
             <?php if(!empty($auction['Product']['delivery_cost'])) : ?>
                <dd><?php echo $number->currency($auction['Product']['delivery_cost'], $appConfigurations['currency']);?></dd>
             <?php endif;?>
            </dl><br class="clear_br">
            <div class="info">
            <strong>Shipping information:</strong>
            <?php if(!empty($auction['Product']['delivery_information'])) : ?>
                <p><?php echo $auction['Product']['delivery_information'];?></p>
            <?php else: ?>
            <p class="align-center" style="padding:4px;">None provided</p>
            <?php endif;?>
            </div>
        </div>
    </div>-->
    </div>
	<div class="f-bottom clearfix"><p class="page_top"><a href="#" id="link_to_top">TOP OF PAGE</a></p></div>
    
</div>