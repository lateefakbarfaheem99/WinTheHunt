<div id="leftcol">
    <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
</div>
<div id="rightcol">
	<?php
	$html->addCrumb(__('Won Auctions', true), '/auctions/won');
	$html->addCrumb(__('Pay for an Auction', true), '/auctions/pay/'.$auction['Auction']['id']);
	echo $this->element('crumb_user');
	?>

	<h1><?php __('Pay for an Auction');?></h1>

	<p><?php __('You are about to pay');?>
	<strong>
	<?php if($auction['Product']['fixed'] > 0) : ?>
		<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']); ?>
	<?php else: ?>
		<?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>
	<?php endif; ?>
	</strong>
	<?php if(!empty($auction['Product']['delivery_cost'])):?>
	<?php __('plus');?> <strong><?php echo $number->currency($auction['Product']['delivery_cost'], $appConfigurations['currency']); ?></strong>
	<?php __('for delivery');?><?php endif;?> <?php __('for the auction titled', true);?>: <?php echo $html->link($auction['Product']['title'], array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id'])); ?>
	</p>

	<?php if(!empty($auction['Product']['delivery_information'])):?>
		<h3><?php __('Delivery Information');?></h3>
		<p><?php echo $auction['Product']['delivery_information']; ?></p>
	<?php endif;?>

	<p><?php __('Please confirm your address details below and ensure the details are correct before purchasing this item');?>:</p>

	<?php if(!empty($address)) : ?>
		<?php foreach($address as $name => $address) : ?>
			<h2><?php echo $name; ?> Address</h2>
			<?php if(!empty($address)) : ?>
				<table class="results" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php __('Name');?></th>
					<th><?php __('Address');?></th>
					<th><?php __('Suburb / Town');?></th>
					<th><?php __('City / State / County');?></th>
					<th><?php __('Postcode');?></th>
					<th><?php __('Country');?></th>
					<th><?php __('Phone Number');?></th>
					<th class="actions"><?php __('Options');?></th>
				</tr>

				<tr>
					<td><?php echo $address['Address']['name']; ?></td>
					<td><?php echo $address['Address']['address_1']; ?><?php if(!empty($address['Address']['address_2'])) : ?>, <?php echo $address['Address']['address_2']; ?><?php endif; ?></td>
					<td><?php if(!empty($address['Address']['suburb'])) : ?><?php echo $address['Address']['suburb']; ?><?php else: ?>n/a<?php endif; ?></td>
					<td><?php echo $address['Address']['city']; ?></td>
					<td><?php echo $address['Address']['postcode']; ?></td>
					<td><?php echo $address['Country']['name']; ?></td>
					<td><?php if(!empty($address['Address']['phone'])) : ?><?php echo $address['Address']['phone']; ?><?php else: ?>n/a<?php endif; ?></td>
					<td><a href="/addresses/edit/<?php echo $name; ?>">Edit</a></td>
				</tr>
				</table>
			<?php else: ?>
				<p><a href="/addresses/add/<?php echo $name; ?>">Add a <?php echo $name; ?> Address</a></p>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if(!empty($addressRequired)) : ?>
		<h2><?php __('Missing Address information');?></h2>
		<p><?php __('Before purchasing the item please <a href="/addresses">click here to update your address information</a>.');?></p>
	<?php else : ?>
		<p><?php __('If you feel there is an error, or if you are unsure about anything please <a href="/contact">contact us before paying your auction</a>.');?></p>

		<?php if(!empty($appConfigurations['credits']['active'])) : ?>
		<h2><?php __('Credits');?></h2>
		<p><?php __('Total');?>: <?php echo $number->currency($orignal, $appConfigurations['currency']); ?></p>
		<p><?php __('Less Credits');?>: <?php echo $creditsRequired; ?> (from your credit balance of: <?php echo $credits; ?>)</p>
		<p class="bold"><?php __('Total Payabale');?>: <?php echo $number->currency($total, $appConfigurations['currency']); ?></p>
		<?php endif; ?>

		<?php if($total > 0) : ?>
			<h2><?php __('Payment Methods');?></h2>
			<p>
			<?php echo $form->create('Auction', array('url' => '/payment_gateways/paypal/auction/'.$auction['Auction']['id']));?>
			<?php echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
			<?php echo $form->end(__('Purchase Using Credit Card >>', true)); ?>
			<p>
			<!--<p>
			<?php //echo $form->create('Auction', array('url' => '/payment_gateways/google_checkout/auction/'.$auction['Auction']['id']));?>
			<?php //echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
			<?php //echo $form->end(__('Purchase Using Google Checkout >>', true)); ?>
			<p> --> 
				
		<?php endif; ?>
	<?php endif; ?>
</div>