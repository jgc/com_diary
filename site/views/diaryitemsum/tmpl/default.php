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
<?php if ($this->item) : ?>

    <div class="item_fields">

        <ul class="fields_list">

            		<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_ID'); ?>:
			<?php echo $this->item->id; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_ORDERING'); ?>:
			<?php echo $this->item->ordering; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_STATE'); ?>:
			<?php echo $this->item->state; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_CHECKED_OUT'); ?>:
			<?php echo $this->item->checked_out; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_CHECKED_OUT_TIME'); ?>:
			<?php echo $this->item->checked_out_time; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_CREATED_BY'); ?>:
			<?php echo $this->item->created_by; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_DNAME'); ?>:
			<?php echo $this->item->dname; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_DITEMDATE'); ?>:
			<?php echo $this->item->ditemdate; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_NOTES'); ?>:
			<?php echo $this->item->notes; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_CREATEDBY'); ?>:
			<?php echo $this->item->createdby; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_CREATED'); ?>:
			<?php echo $this->item->created; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_UPDATED'); ?>:
			<?php echo $this->item->updated; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_FILEUPLOAD'); ?>:

			<?php 
				$uploadPath = 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_diary' . DIRECTORY_SEPARATOR . 'dfiles' . DIRECTORY_SEPARATOR . $this->item->fileupload;
			?>
			<a href="<?php echo JRoute::_(JUri::base() . $uploadPath, false); ?>" target="_blank"><?php echo $this->item->fileupload; ?></a></li>			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_DINT'); ?>:
			<?php echo $this->item->dint; ?></li>
			<li><?php echo JText::_('COM_DIARY_FORM_LBL_DIARYITEM_CHECKBOX'); ?>:
			<?php echo $this->item->checkbox; ?></li>


        </ul>

    </div>
    <?php if($canEdit): ?>
		<a href="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_DIARY_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_diary.diaryitem.'.$this->item->id)):
								?>
									<a href="javascript:document.getElementById('form-diaryitem-delete-<?php echo $this->item->id ?>').submit()"><?php echo JText::_("COM_DIARY_DELETE_ITEM"); ?></a>
									<form id="form-diaryitem-delete-<?php echo $this->item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
										<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
										<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
										<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
										<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
										<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />
										<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
										<input type="hidden" name="jform[dname]" value="<?php echo $this->item->dname; ?>" />
										<input type="hidden" name="jform[ditemdate]" value="<?php echo $this->item->ditemdate; ?>" />
										<input type="hidden" name="jform[notes]" value="<?php echo $this->item->notes; ?>" />
										<input type="hidden" name="jform[createdby]" value="<?php echo $this->item->createdby; ?>" />
										<input type="hidden" name="jform[created]" value="<?php echo $this->item->created; ?>" />
										<input type="hidden" name="jform[updated]" value="<?php echo $this->item->updated; ?>" />
										<input type="hidden" name="jform[fileupload]" value="<?php echo $this->item->fileupload; ?>" />
										<input type="hidden" name="jform[dint]" value="<?php echo $this->item->dint; ?>" />
										<input type="hidden" name="jform[checkbox]" value="<?php echo $this->item->checkbox; ?>" />
										<input type="hidden" name="option" value="com_diary" />
										<input type="hidden" name="task" value="diaryitem.remove" />
										<?php echo JHtml::_('form.token'); ?>
									</form>
								<?php
								endif;
							?>
<?php
else:
    echo JText::_('COM_DIARY_ITEM_NOT_LOADED');
endif;
?>
