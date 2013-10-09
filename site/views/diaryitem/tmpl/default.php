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
// $pheading = $this->params->get('page_heading', '');  // '$active->page_heading' neither work reliably, see viewdiaryform
// FIX
$pheading = "";

if ($pheading != ""){
    echo '<h1>'.$active->page_heading.' '.$this->item->id.'</h1>';
} else {
    echo '<h1>Diary entry '.$this->item->id.'</h1>';
    echo '<h1>Diary entry</h1>';
}
?>

<?php
$user = JFactory::getUser();
$loginuser = $user->id;
$owner = $this->item->owner;
$published = $this->item->state;
$allowView = 0;
if ($published == 1){
$allowView = 1;
} else {
$allowView = 0;
}
//echo $allowView;
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

<?php if ($this->item && ($allowView)): ?>

    <div class="item_fields">

			<br/>
			<div><?php echo '<strong>' . JText::_('COM_DIARY_FORM_LBL_DIARYITEM_DATE') . '</strong>'; ?>
			<?php echo $this->item->date; ?>
			
			<?php if (!empty($this->nameid)): ?>
			<?php echo '&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
			<?php echo '<strong>' . JText::_('COM_DIARY_FORM_LBL_DIARYITEM_DOG') . '</strong>'; ?>
			<?php echo $this->item->nameid; ?></div>
			<?php endif; ?>

			</div><br/>

			<div><?php echo '<strong>' . JText::_('COM_DIARY_FORM_LBL_DIARYITEM_TITLE') . '</strong>'; ?>
			<?php echo $this->item->title; ?></div><br/>
			
			<div><?php echo '<strong>' . JText::_('COM_DIARY_FORM_LBL_DIARYITEM_NOTES') . '</strong>'; ?><br/>
			<?php echo $this->item->notes; ?></div>
			
   </div>
   
    <?php if($canEdit): ?>
		<a href="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_DIARY_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if($allowDeleteX): //FIX - remove all together
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
