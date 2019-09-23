<?php 
$bid_rebate = 0;
if($count_total_bids){
	$bid_rebate = unitBidCost * $count_total_bids;
}

$AuctionPrice = $auction['Product']['buy_now'];
$delivery_cost =  $auction['Product']['delivery_cost'] ;
$root_price = ($AuctionPrice - $bid_rebate ) ;
$total_price = $root_price  + $delivery_cost;
	
	//echo $AuctionPrice; exit;			
			
?> 
<div class="box clearfix"><div class="f-top clearfix"><h2>Buy Now Auction</h2></div>

<div class="f-repeat clearfix">
<div class="content">
<div id="leftcol">
    <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
</div>
<div id="rightcol">
	<h1><?php __('');?></h1>
	<p><?php __('Buy for only');?>
	<strong>
	<?php if($auction['Product']['fixed'] > 0) : ?>
		<?php //echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['dollar']); ?>
		<?php echo $number->currency( ($root_price) , $appConfigurations['dollar']); ?>
	<?php else: ?>
		<?php //echo $number->currency($auction['Auction']['price'], $appConfigurations['dollar']); ?>
		<?php echo $number->currency( ($total_price)); ?> <?php __('for the auction titled', true);?> : <?php echo $html->link($auction['Product']['title'], array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id'])); ?><br>
		<?php endif; ?>
	</strong>
	<table width="80%"  border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#000000">
  <tr bgcolor="#999999">
    <td><strong>Article : </strong></td>
    <td><div align="center"><strong>Price</strong></div></td>
  </tr>
  <tr>
    <td><div align="left"><strong><?php echo $html->link($auction['Product']['title'], array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id'])); ?></strong></div></td>
    <td>
        <div align="center"><strong><?php echo $number->currency( ($AuctionPrice)); ?></strong></div></td>
  </tr>
   <tr>
    <td width="78%"><div align="right"><strong>Bids Spend (<?php echo $count_total_bids;?>) : </strong></div></td>
    <td width="22%">
        <div align="center"><?php echo $number->currency( $bid_rebate ); ?></div></td>
  </tr>
  <tr>
    <td width="78%"><div align="right"><strong>Sub Total : </strong></div></td>
    <td width="22%">
        <div align="center"><?php echo $number->currency( ($root_price)); ?></div></td>
  </tr>
 
  <tr>
    <td><div align="right"><strong>Delivery Fee : </strong></div></td>
    <td><div align="center"><?php echo $number->currency($auction['Product']['delivery_cost']); ?></div></td>
  </tr>
  
  <tr>
    <td height="19"><div align="right"><strong>Total : </strong></div></td>
    <td>
    <div align="center"><?php echo $number->currency( ($total_price)); ?></div></td>
  </tr>
</table>
	<?php if(!empty($auction['Product']['delivery_cost'])):?>
	<?php endif;?> 
	</p>
	<?php if(!empty($auction['Product']['delivery_information'])):?>
		<h3><?php __('Information Delivery');?></h3>
		<p>Delivery: <?php echo $auction['Product']['delivery_information']; ?></p>
	<?php endif;?>

	<p><?php __('Please confirm your address below before purchasing a product.');?></p>
<br>
	<?php if(!empty($address)) : ?>
		<?php foreach($address as $name => $address) :
				//if($name == 'Shipping') continue;
		?>
			<h2>Adresse Delivery</h2>
			<?php if(!empty($address)) : ?>
				<table class="results" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php __('Nom');?></th>
					<th><?php __('Adresse');?></th>
					<th><?php __('Ville / Province');?></th>
					<th><?php __('Code Postal');?></th>
					<th><?php __('Pays');?></th>
					<th><?php __('Tel.');?></th>
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
					<td><a href="<?php echo $appConfigurations['url'];?>/addresses/edit/<?php echo $name; ?>/buynow/<?php echo $auction['Auction']['id'];?>">Modifier</a></td>
				</tr>
				</table>
			<?php else: ?>
				<p><a href="<?php echo $appConfigurations['url'];?>/addresses/add/<?php echo $name; ?>">Add <?php echo $name; ?> Address</a></p>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if(!empty($addressRequired)) : ?>
		<h2><?php __('Adresse Manquante');?></h2>
		<p><?php __('Avant acheter cette article veuillez <a href="/addresses">cliquer ici pour modifier votre adresse</a>.');?></p>
	<?php else : ?>
	
		<?php if($total > 0) : ?>
			<h2><?php __('M&eacute;thode Paiement');?></h2>

			<?php if(Configure::read('PaypalProUk.username')) : ?>
			<p>
				<?php if(Configure::read('debug') == 0) : ?>
		        	<?php echo $form->create('Auction', array('url' => Configure::read('PaypalProUk.ssl_url').'/auctions/creditcard/'.$auction['Auction']['id'].'/'.$appConfigurations['currency'].'/'.$appConfigurations['serverName'].'/'.$session->read('Auth.User.id')));?>
		        <?php else: ?>
		        	<?php echo $form->create('Auction', array('url' => '/auctions/creditcard/'.$auction['Auction']['id'].'/'.$appConfigurations['currency'].'/'.$appConfigurations['serverName'].'/'.$session->read('Auth.User.id')));?>
		       	<?php endif; ?>

				<?php echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
				<?php echo $form->end(__('Pay Using Credit Card >>',true)); ?>
			</p>
			<?php endif; ?>

			<?php if($appConfigurations['demoMode'] == true):?>
				<p>
					<?php echo $form->create('Auction', array('url' => '/auctions/pay/'.$auction['Auction']['id']));?>
					<?php echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
					<?php echo $form->end(__('Pay for this Auction (demo mode) >>', true)); ?>
				</p>
			<?php endif;?>

			<?php if($appConfigurations['gateway'] == true):?>
				<?php if(!empty($paypalData)):?>
					<p>
					<?php echo $form->create('Auction', array('url' => '/payment_gateways/paypal/buynow/'.$auction['Auction']['id'].'/1'));?>
					<?php echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
					<?php echo $form->end(__('Payer avec Paypal >>', true)); ?>
					<p>
				<?php endif;?>

				<?php if(Configure::read('PaymentGateways.iDeal.layout')):?>
					<p>
					<?php echo $form->create('Auction', array('url' => '/payment_gateways/ideal/auction/'.$auction['Auction']['id']));?>
					<?php echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
					<?php echo $form->end(__('Pay using iDeal >>', true)); ?>
					<p>
				<?php endif;?>

				<?php if(Configure::read('PaymentGateways.GoogleCheckout.merchant_id')):?>
					<p>
						<?php echo $form->create('Auction', array('url' => '/payment_gateways/google_checkout/auction/'.$auction['Auction']['id']));?>
						<?php echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
						<?php echo $form->end(__('Pay using Google Checkout >>', true)); ?>
					</p>
				<?php endif;?>

				<?php if(Configure::read('PaymentGateways.AuthorizeNet.login')):?>
					<p>
						<?php echo $form->create('Auction', array('url' => '/payment_gateways/authorizenet/auction/'.$auction['Auction']['id']));?>
						<?php echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
						<?php echo $form->end(__('Pay using Authorize.net >>', true)); ?>
					</p>
				<?php endif;?>

				<?php if(Configure::read('PaymentGateways.DIBS.merchant')):?>
					<p>
						<?php echo $form->create('Auction', array('url' => '/payment_gateways/dibs/auction/'.$auction['Auction']['id']));?>
						<?php echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
						<?php echo $form->end(__('Pay using DIBS >>', true)); ?>
					</p>
				<?php endif;?>

				<?php if(Configure::read('PaymentGateways.custom.active')):?>
					<p>
						<?php $url = Configure::read('PaymentGateways.custom.won_url'); ?>
						<?php $url = str_replace('[user_id]', $session->read('Auth.User.id'), $url) ?>
						<?php $url = str_replace('[auction_id]', $auction['Auction']['id'], $url) ?>
						<?php $url = str_replace('[price]', $auction['Auction']['price'], $url) ?>
						<?php echo $html->link(__('Pay Using credit / debit card or PayPal', true), $url); ?>
					</p>
				<?php endif;?>
			<?php endif;?>
		<?php else : ?>
			<?php echo $form->create('Auction', array('url' => '/auctions/pay/'.$auction['Auction']['id']));?>
			<?php echo $form->hidden('id', array('value' => $auction['Auction']['id'])); ?>
			<?php echo $form->end(__('Confirm Your Details >>', true)); ?>
		<?php endif; ?>
	<?php endif; ?>
</div>
</div>
</div>
<div class="f-bottom clearfix"> &nbsp; </div>