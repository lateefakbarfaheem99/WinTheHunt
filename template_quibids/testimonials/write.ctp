<?php //echo 'veriable : '.$auction_id ;exit;?>
<div class="box clearfix">
	<div class="f-top clearfix"><h2><?php __('Write Comment');?></h2></div>
	<div class="f-repeat clearfix">
		<div class="content">
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
				<?php echo $form->create('Testimonial',  array('type' => 'file','action' => '/write/'.$auction_id) );?>
				<fieldset>
					<legend><?php __('Write Testimonial:- ');?></legend>
				<br>
					<?php
						echo $form->input('content', array('label' => __('Your Comment:', true)));
						echo $form->input('image', array('type' => 'file')); 
						echo $form->hidden('id'); 
						echo $form->end(__('Submit', true));
					?>
					* Lorsque vous soumettez une photo veuillez vous assurer que le le fichier n'exc&egrave;de pas 2MB
					<br>
					** Les t&eacute;moignages sont v&eacute;rifi&eacute;s avant publication.
				</fieldset>
			</div>
		</div>
	</div>
	<div class="f-bottom clearfix"> &nbsp; </div>
</div>