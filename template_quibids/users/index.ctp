<div class="box clearfix">
	<div class="f-top clearfix"><h2><?php echo sprintf(__('My %s', true), $appConfigurations['name']); ?></h2></div>
	<div class="f-repeat clearfix">
		<div class="content">
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
				<?php
				$bidBalance = $this->requestAction('/bids/balance/'.$user['User']['id']);
				
				$html->addCrumb(__('Dash Board', true), '/users');
				echo $this->element('crumb_user');
				?>
				
				<h3><?php __('Things to Do');?></h3>
				<ul class="to-do">
				<?php if(!empty($userAddress)) : ?>
					<?php foreach($userAddress as $name => $address) : ?>
						<?php if(empty($address)) : ?>
							<?php $count = 1; ?>
							<li><a href="<?php echo $appConfigurations['url'];?>/addresses/add/<?php echo $name; ?>">Add a <?php echo $name; ?> Address</a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<?php if($bidBalance == 0) : ?>
					<?php $count = 1; ?>
					<li><a href="<?php echo $appConfigurations['url'];?>/packages"><?php __('Purchase some products');?></a></li>
				<?php endif; ?>
				
				<?php if($unpaidAuctions > 0) : ?>
					<?php $count = 1; ?>
					<li><a href="<?php echo $appConfigurations['url'];?>/auctions/won"><?php __('Pay for an Auction');?></a></li>
					<li><a href="<?php echo $appConfigurations['url'];?>/auctions/won"><?php __('Write Comments On Won Auctions');?></a></li>
				<?php endif; ?>
				
				<?php if(empty($count)) : ?>
					<li><?php __('You have no things to do at the moment.');?></li>
				<?php endif; ?>
				</ul>
				
				<h3><?php __('My Dash Board');?></h3>
				
				<p><?php echo sprintf(__('You currently have %s bids.', true), '<strong>'.$bidBalance.'</strong>');?><a class="purchase-bid" href="/packages"><?php __('Click here to purchase product and get points');?></a></p>
				
				<p><?php echo sprintf(__('You currently have %s unpaid auction(s).', true), '<strong>'.$unpaidAuctions.'</strong>');?><a href="/auctions/won"><?php __('View your won auctions');?></a></p>
			</div>
		</div>
	</div>
	<div class="f-bottom clearfix"> &nbsp; </div>
</div>