<style>
.submit { margin-left:210px !important; }
</style>
<div class="box clearfix">
	<div class="f-top clearfix"><h2><?php __('Forgotten Your Password?');?></h2></div>
	<div class="f-repeat clearfix">
		<div class="content">
			<p><?php __('If you have forgotten your username and password simply enter in your email address below.');?></p>

			<p><?php __('Your login details will be emailed to you and your password will be reset.');?></p>
			
			<fieldset>
				<?php 
					echo $form->create('User', array('action' => 'reset'));
					echo $form->input('email', array('label' => __('Email', true),'style' =>'width:250px'));
					//echo $form->end('Send Details');
				?>
				<div class="submit"><input type="submit" value="Send Details"></div></form>				
			</fieldset>
			
			<h3><?php __('Don\'t have an account?');?></h3>
			<p><?php echo sprintf(__('If so you may want to %s now.', true), $html->link(__('sign up', true), array('action'=>'register')));?></p>
			
			<h3><?php __('Already a Member?');?></h3>
			<p><?php echo sprintf(__('If so you may want to %s now.', true), $html->link(__('login', true), array('action'=>'login')));?></p>
		</div>
	</div>
	<div class="f-bottom clearfix"> &nbsp; </div>
</div>