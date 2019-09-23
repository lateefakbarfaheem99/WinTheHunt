<div id="auction-details" class="box">
	<div class="f-top clearfix"><h2>Auction Details</h2></div>
	<div class="f-repeat clearfix">
		<div class="content">
			<h1><?php echo $auction['Product']['title']; ?></h1>
			<div class="col1">
				<div class="content">
					<div class="auction-image">
						<?php if(!empty($auction['Auction']['image'])):?>
							<?php echo $html->image($auction['Auction']['image'], array('class'=>'productImageMax', 'alt' => $auction['Product']['title'], 'title' => $auction['Product']['title']));?>
						<?php else:?>
							<?php echo $html->image('product_images/max/no-image.gif', array('alt' => $auction['Product']['title'], 'title' => $auction['Product']['title']));?>
						<?php endif; ?>
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
				</div>
			</div>

			<div class="col2">
				<div class="content auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">
					<div class="sub-col1">
						<?php if(!empty($auction['Auction']['isClosed'])):?>
							<div class="congrats">
                            <?php if(!empty($auction['Winner']['id'])):?>
                                <?php echo sprintf(__('Congratulations to %s', true), $auction['Winner']['username']);?><br />
                            <?php else:?>
                                <?php __('There was no winner');?><br />
                            <?php endif;?>
							</div>
                        <?php endif;?>

						<dl class="clearfix">
							<dt>Price</dt>
							<dd class="price">
								<?php if(!empty($auctionItem['Product']['fixed'])):?>
								<?php echo $number->currency($auctionItem['Product']['fixed_price'], $appConfigurations['currency']); ?>
								<span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auctionItem['Auction']['price'], $appConfigurations['currency']); ?></span>
							<?php else: ?>
								<span class="bid-price"><?php echo $number->currency($auctionItem['Auction']['price'], $appConfigurations['currency']); ?></span>
							<?php endif; ?>
								<br /><span class="vat">incl. VAT, excl. delivery</span>
							</dd>
							<dt>Highest Bidder</dt>
							<dd class="username"><span class="bid-bidder">Highest Bidder</span></dd>
						</dl>
						<div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>">--:--:--</div>
						<div class="bid-now">
							<?php if(!empty($auction['Auction']['isFuture'])) : ?>
								<div><?php echo $html->image('b-soon.gif');?></div>
							 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
								<div><?php echo $html->image('b-sold.gif');?></div>
							 <?php else:?>
								 <?php if($session->check('Auth.User')):?>
									<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
									<div class="bid-button"><?php echo $html->link($html->image('b-bid.gif'), '/bid.php?id='.$auction['Auction']['id'], array('class' => 'bid-button-link', 'title' => $auction['Auction']['id']), null, false);?></div>
								<?php else:?>
									<div class="bid-button"><?php echo $html->link($html->image('b-login.gif'), array('controller' => 'users', 'action' => 'login'), null, null, false);?></div>
								<?php endif;?>
							<?php endif; ?>
						</div>
						<div class="bid-message" style="display: none"></div>
						<?php if(empty($auction['Auction']['isClosed'])):?>
							<div class="note">It costs 50p to place a bid online. Each bid raises the auction price by $0.01 This auction will end on  07 Apr 2009 at 12:10am</div>
						<?php endif; ?>
					</div>

					<div class="count-saving">
						<strong>Savings:</strong> <br />
						<?php if(!empty($auction['Product']['rrp'])) : ?>
							<label>Worth up to</label> : $189.99
							<br />
						<?php endif; ?>
						<label>Price</label> :
							<?php if(!empty($auction['Product']['fixed'])):?>
								<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?>
							<?php else: ?>
								<?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>
							<?php endif; ?>
						<div class="total-savings">
							<label>Total Savings</label> : <span class="bid-savings-price"><?php echo $number->currency($auction['Auction']['savings']['price'], $appConfigurations['currency']);?></span>
						</div>
					</div>

				</div>
			</div>

			<div class="col3">
				<div class="bid-history bid-histories" id="bidHistoryTable<?php echo $auction['Auction']['id'];?>">
					<div class="content">
						<h3>Bid History</h3>
						<table width="100%" cellpadding="0" cellspacing="0" border="0" >
                            <thead>
                                <tr>
                                    <th><?php __('Time');?></th>
                                    <th><?php __('Bidder');?></th>
                                    <th><?php __('Type');?></th>
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
                            </tbody>
                        </table>
                        <?php if(empty($bidHistories)):?>
                            <p><?php __('No bids have been placed yet.');?></p>
                        <?php endif;?>
					</div>
				</div>

				<div class="banner">
					<?php echo $html->link($html->image('banner-register.gif', array('alt' => 'Register Now', 'title' => 'Register Now')), '/users/register', null, null, false); ?>
				</div>
			</div>

		</div>
	</div>
	<div class="f-bottom clearfix">&nbsp;</div>
</div>

<div id="payment-info" class="box">
	<div class="f-top clearfix"><h2>Payment Information</h2></div>
	<div class="f-repeat clearfix">
		<div class="content">
			<div class="col1">
				<strong>Payment Methods:</strong>
				<p>Credit Card &amp; Paypal</p>
			</div>
			<div class="col2">
				<strong>Delivery cost:</strong>
				 <?php if(!empty($auction['Product']['delivery_cost'])) : ?>
					<p>&raquo; <?php echo $number->currency($auction['Product']['delivery_cost'], $appConfigurations['currency']);?></p>
				 <?php endif;?>
			</div>
			<div class="col3">
				<strong>Delivery Information:</strong>
				<?php if(!empty($auction['Product']['delivery_information'])) : ?>
					<p>&raquo; <?php echo $auction['Product']['delivery_information'];?></p>
				<?php endif;?>
			</div>
			<div class="col4">
				<strong>Any questions left?</strong>
				<p><a href="/contact">&raquo; Contact us</a></p>
			</div>
		</div>
	</div>
	<div class="f-bottom clearfix">&nbsp;</div>
</div>

<div id="product-desc" class="box">
	<div class="f-top clearfix"><h2>Product Description</h2></div>
	<div class="f-repeat clearfix">
		<div class="content">
			<p>Description:</p>
			<?php echo $auction['Product']['description'];?>
		</div>
	</div>
	<div class="f-bottom clearfix">&nbsp;</div>
</div>