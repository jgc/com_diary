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

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_diary', JPATH_ADMINISTRATOR);
$canEdit = JFactory::getUser()->authorise('core.edit', 'com_diary.' . $this->item->id);
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_diary' . $this->item->id)) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<?php
$user = JFactory::getUser();
$loginuser = $user->id;
$owner = $this->item->owner;
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
?>

<?php if ($this->item && $allowEdit): ?>

    <div class="item_fields">

        <ul class="fields_list">

            			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_ID'); ?>:
			<?php echo $this->item->id; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_STATE'); ?>:
			<?php echo $this->item->state; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_OWNER'); ?>:
			<?php echo $this->item->owner; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_DATE'); ?>:
			<?php echo $this->item->date; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_TITLE'); ?>:
			<?php echo $this->item->title; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_NOTES'); ?>:
			<?php echo $this->item->notes; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_DOG'); ?>:
			<?php echo $this->item->dog; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_CREATED_BY'); ?>:
			<?php echo $this->item->created_by; ?></li>


        </ul>

    </div>
    <?php if($canEdit): ?>
		<a href="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_DIARY_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if($allowDelete):
								?>
									<a href="javascript:document.getElementById('form-diaryitem-delete-<?php echo $this->item->id ?>').submit()"><?php echo JText::_("COM_DIARY_DELETE_ITEM"); ?></a>
									<form id="form-diaryitem-delete-<?php echo $this->item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
										<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
										<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
										<input type="hidden" name="jform[owner]" value="<?php echo $this->item->owner; ?>" />
										<input type="hidden" name="jform[date]" value="<?php echo $this->item->date; ?>" />
										<input type="hidden" name="jform[title]" value="<?php echo $this->item->title; ?>" />
										<input type="hidden" name="jform[notes]" value="<?php echo $this->item->notes; ?>" />
										<input type="hidden" name="jform[dog]" value="<?php echo $this->item->dog; ?>" />
										<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
										<input type="hidden" name="option" value="com_diary" />
										<input type="hidden" name="task" value="diaryitem.remove" />
										<?php echo JHtml::_('form.token'); ?>
									</form>
								<?php
								endif;
							?>
<?php
else:
            $error = JText::_('COM_DIARY_ITEM_NOT_LOADED');
            JFactory::getApplication()->redirect(JURI::base(), $error, 'error' );
            return false;

endif;
?>
