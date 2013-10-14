<?php
/**
 * @version     1.0.0
 * @package     com_diary
 * @copyright   Copyright (C) 2013 FalcoAccipiter. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      FalcoAccipiter <admin@falcoaccipiter.com> - http://www.falcoaccipiter.com
 */
// no direct access
defined('_JEXEC') or die;
?>
<script type="text/javascript">
    function deleteItem(item_id){
        if(confirm("<?php echo JText::_('COM_DIARY_DELETE_MESSAGE'); ?>")){
            document.getElementById('form-diaryname-delete-' + item_id).submit();
        }
    }
</script>

<?php

$displayDelete = 0;
$displayPublish = 0;

$pheading = $this->params->get('page_heading', '');  // '$active->page_heading' also works
if ($pheading != ""){
    echo '<h2 class="item-title">'.$pheading.'</h2>';
} else {
    echo '<h2 class="item-title">Diary entries</h2>';
}
?>
<br/>

<div class="items">

<?php $show = false; ?>

<?php foreach ($this->items as $item) : ?>        

<?php
$user = JFactory::getUser();
$loginuser = $user->id;
$owner = $item->owner;
//echo $loginuser.'-'.$owner;
if ($loginuser == $owner){
    $allowEdit = 1;
    $allowState = 1;
    $allowDelete = 1;
} else {
    $allowEdit = 0;
    $allowState = 0;
    $allowDelete = 0;
}
					if($item->state == 1 || ($item->state == 0 && $allowEdit)):
						$show = true;
						?>
						    <div>
							<?php
							$display = $item->date . ' ';
							
							if (!empty($item->pname))
							{
							$display .= $item->pname;    
							}
							
							if (!empty($item->rname))
							{
							$display .= ' (registered as ' . $item->rname. ')';
							}
							
							?>
							
<?php if(!$allowEdit): ?>
<a href="<?php echo JRoute::_('index.php?option=com_diary&view=diaryname&id=' . (int)$item->id); ?>"><?php echo $display; ?></a>

<?php else: ?>
<a href="<?php echo JRoute::_('index.php?option=com_diary&view=diarynameform&id=' . (int)$item->id); ?>"><?php echo $display; ?></a>

<?php endif; ?>

<?php
if (!empty($item->notes))
{
	echo '<br/>&nbsp;&nbsp;' . $item->notes . '';
}
?>
<br/>							
<?php if($allowState && $displayPublish): ?>
<br/>
&nbsp;&nbsp;<a href="javascript:document.getElementById('form-diaryname-state-<?php echo $item->id; ?>').submit()">


<?php if($item->state == 1): echo JText::_("COM_DIARY_UNPUBLISH_ITEM"); 

else: echo JText::_("COM_DIARY_PUBLISH_ITEM"); 

endif; ?></a>
										
<form id="form-diaryname-state-<?php echo $item->id ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_diary&task=diaryname.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="jform[state]" value="<?php echo (int)!((int)$item->state); ?>" />
											<input type="hidden" name="jform[owner]" value="<?php echo $item->owner; ?>" />
											<input type="hidden" name="jform[pname]" value="<?php echo $item->pname; ?>" />
											<input type="hidden" name="jform[rname]" value="<?php echo $item->rname; ?>" />
											<input type="hidden" name="jform[rnumber]" value="<?php echo $item->rnumber; ?>" />
											<input type="hidden" name="jform[dob]" value="<?php echo $item->dob; ?>" />
											<input type="hidden" name="jform[notes]" value="<?php echo $item->notes; ?>" />
											<input type="hidden" name="jform[created_by]" value="<?php echo $item->created_by; ?>" />
											<input type="hidden" name="option" value="com_diary" />
											<input type="hidden" name="task" value="diaryname.save" />
											<?php echo JHtml::_('form.token'); ?>
</form>
<?php endif;?>

<?php if($allowDelete && $displayDelete):?>


<a href="javascript:deleteItem(<?php echo $item->id; ?>);">
<?php echo JText::_("COM_DIARY_DELETE_ITEM"); ?></a>

<form id="form-diaryname-delete-<?php echo $item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_diary&task=diaryname.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="jform[state]" value="<?php echo $item->state; ?>" />
											<input type="hidden" name="jform[owner]" value="<?php echo $item->owner; ?>" />
											<input type="hidden" name="jform[pname]" value="<?php echo $item->pname; ?>" />
											<input type="hidden" name="jform[rname]" value="<?php echo $item->rname; ?>" />
											<input type="hidden" name="jform[rnumber]" value="<?php echo $item->rnumber; ?>" />
											<input type="hidden" name="jform[dob]" value="<?php echo $item->dob; ?>" />
											<input type="hidden" name="jform[notes]" value="<?php echo $item->notes; ?>" />
											<input type="hidden" name="jform[created_by]" value="<?php echo $item->created_by; ?>" />
											<input type="hidden" name="option" value="com_diary" />
											<input type="hidden" name="task" value="diaryname.remove" />
											<?php echo JHtml::_('form.token'); ?>
</form>
<?php endif; ?>
<br/><br/>
</div>
<br/>

<?php endif; ?>

<?php endforeach; ?>
<br/>
<?php if (!$show):
            echo JText::_('COM_DIARY_NO_NAMES');
        endif;
        ?>

</div>
<br/><br/>

<?php if ($show): ?>
    <div class="pagination">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>

<?php endif; ?>
<br/>
<?php if(JFactory::getUser()->authorise('core.create','com_diary')): ?><a href="<?php echo JRoute::_('index.php?option=com_diary&task=diaryname.edit&id=0'); ?>"><?php echo JText::_("COM_DIARY_ADD_ITEM"); ?></a>

<?php endif; ?>