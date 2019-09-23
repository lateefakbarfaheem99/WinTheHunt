<?php 
//echo "<pre>";print_r($statuses);echo "</pre>";exit('Exit call');
?>
<div id="ending-soon" class="box">
	<div class="f-top clearfix"><h2><?php __('Your Buy Now orders');?></h2></div>
	<div class="f-repeat clearfix">
		<div class="content">
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
				<?php if(!empty($auctions) ): ?>
					<?php echo $this->element('pagination'); ?>
			
					<table class="results" cellpadding="0" cellspacing="0">
						<tr>
							<th><?php echo $paginator->sort('Nom Produit', 'Nom Produit');?></th>
							<th><?php __('Prix');?></th>
							<th><?php __('Status');?></th>
							<th><?php echo $paginator->sort('Date Achat', 'Date Achat');?></th>
						</tr>
					<?php
					$i = 0;//echo '<pre>'; print_r($count_total_bids);
					foreach ($auctions as $auction):
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}
							//echo '<pre>'; print_r($auction);			
					?>
						<tr <?php echo $class; ?>>
							<td>&nbsp;<?php echo $auction['Buynow']['item_name'];?>  </td>
							<td>&nbsp;<?php echo $number->currency($auction['Buynow']['price']);?> </td>
							<td>&nbsp;<?php echo $statuses[$auction['Buynow']['payment_status']]; ?> </td>
							<td><?php echo $time->niceShort($auction['Buynow']['created']); ?></td>
						</tr>
					<?php endforeach; ?>
					</table>
			
					<?php echo $this->element('pagination'); ?>
			
				<?php else:?>
					<p><?php __('No Records Found');?></p>
				<?php endif;?>
			</div>
		</div>
	</div>
	<div class="f-bottom clearfix">&nbsp;</div>
</div>
