<?php $pages = $this->requestAction('/pages/getpages/bottom');?>
    <?php if(!empty($pages)):?>
        <?php foreach($pages as $page):?>
            <?php echo $html->link($page['Page']['name'], array('controller' => 'pages', 'action'=>'view', $page['Page']['slug'])); ?> 
        <?php endforeach;?>
        	<?php echo $html->link('Contact', array('controller' => 'contact', 'action'=>'index')); ?>
    <?php endif;?>
