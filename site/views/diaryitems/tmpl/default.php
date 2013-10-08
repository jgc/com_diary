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
            document.getElementById('form-diaryitem-delete-' + item_id).submit();
        }
    }
</script>

<?php 
$active = JFactory::getApplication()->getMenu()->getActive();
if (!$active->page_heading){
    echo '<h1>'.$active->page_heading.'</h1>';
} else {
    echo '<h1>Diary item</h1>';
}
?>


<h1><?php echo $active->page_heading . ' ' . $this->item->id; ?></h1>

<div class="items">
    <ul class="items_list">
<?php $show = false; ?>

<?php foreach ($this->items as $item) : ?>        

<?php
$user = JFactory::getUser();
$loginuser = $user->id;
$owner = $item->owner;
// echo $loginuser.'-'.$owner;
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
							<li>
							<?php if(!$allowEdit): ?>
								<a href="<?php echo JRoute::_('index.php?option=com_diary&view=diaryitem&id=' . (int)$item->id); ?>"><?php echo $item->date . ' ' .$item->title . ':'; ?></a>
							<?php else: ?>
								<a href="<?php echo JRoute::_('index.php?option=com_diary&view=diaryitemform&id=' . (int)$item->id); ?>"><?php echo $item->date . ' ' .$item->title . ':'; ?></a>
							<?php endif; ?>
							<?php if($allowState): ?>
										<a href="javascript:document.getElementById('form-diaryitem-state-<?php echo $item->id; ?>').submit()"><?php if($item->state == 1): echo JText::_("COM_DIARY_UNPUBLISH_ITEM"); else: echo JText::_("COM_DIARY_PUBLISH_ITEM"); endif; ?></a>
										<form id="form-diaryitem-state-<?php echo $item->id ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="jform[state]" value="<?php echo (int)!((int)$item->state); ?>" />
											<input type="hidden" name="jform[owner]" value="<?php echo $item->owner; ?>" />
											<input type="hidden" name="jform[date]" value="<?php echo $item->date; ?>" />
											<input type="hidden" name="jform[title]" value="<?php echo $item->title; ?>" />
											<input type="hidden" name="jform[notes]" value="<?php echo $item->notes; ?>" />
											<input type="hidden" name="jform[dog]" value="<?php echo $item->dog; ?>" />
											<input type="hidden" name="option" value="com_diary" />
											<input type="hidden" name="task" value="diaryitem.save" />
											<?php echo JHtml::_('form.token'); ?>
										</form>
									<?php
									endif;
									if($allowDelete):
									?>
										<a href="javascript:deleteItem(<?php echo $item->id; ?>);"><?php echo JText::_("COM_DIARY_DELETE_ITEM"); ?></a>
										<form id="form-diaryitem-delete-<?php echo $item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="jform[state]" value="<?php echo $item->state; ?>" />
											<input type="hidden" name="jform[owner]" value="<?php echo $item->owner; ?>" />
											<input type="hidden" name="jform[date]" value="<?php echo $item->date; ?>" />
											<input type="hidden" name="jform[title]" value="<?php echo $item->title; ?>" />
											<input type="hidden" name="jform[notes]" value="<?php echo $item->notes; ?>" />
											<input type="hidden" name="jform[dog]" value="<?php echo $item->dog; ?>" />
											<input type="hidden" name="jform[created_by]" value="<?php echo $item->created_by; ?>" />
											<input type="hidden" name="option" value="com_diary" />
											<input type="hidden" name="task" value="diaryitem.remove" />
											<?php echo JHtml::_('form.token'); ?>
										</form>
									<?php
									endif;
								?>
							</li>
						<?php endif; ?>

<?php endforeach; ?>
        <?php
        if (!$show):
            echo JText::_('COM_DIARY_NO_ITEMS');
        endif;
        ?>
    </ul>
</div>
<?php if ($show): ?>
    <div class="pagination">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>


									<?php if(JFactory::getUser()->authorise('core.create','com_diary')): ?><a href="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.edit&id=0'); ?>"><?php echo JText::_("COM_DIARY_ADD_ITEM"); ?></a>
	<?php endif; ?>