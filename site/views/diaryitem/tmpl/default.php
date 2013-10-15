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
    echo '<h2 class="item-title">'.$active->page_heading.' '.$this->item->id.'</h2>';
} else {
    // echo '<h2 class="item-title">Diary entry '.$this->item->id.'</h2>';
    echo '<h2 class="item-title">Diary entry</h2>';
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
//FIX
$allowView = 1;
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
			<?php echo $this->item->notes; ?></div><br/>
			
			<div><?php echo '<strong>Youtube video/s</strong>'; ?><br/>
			<div align="left"><iframe width="280" height="210" src="//www.youtube.com/embed/<?php echo $this->item->youtube1; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
			<iframe width="280" height="210" src="//www.youtube.com/embed/<?php echo $this->item->youtube2; ?>?rel=0" frameborder="0" allowfullscreen></iframe></div><br/>
			
			<div><?php echo '<strong>Photo/s</strong>'; ?><br/>
			<div align="left"><iframe width="280" height="210" src="//www.youtube.com/embed/<?php echo $this->item->photo1; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
			<iframe width="280" height="210" src="//www.youtube.com/embed/<?php echo $this->item->photo2; ?>?rel=0" frameborder="0" allowfullscreen></iframe></div><br/>
			<p>
			<img src="images/diarysocial/<?php echo $this->item->photo1; ?>" alt="" style="float:left" width="40%">
			<img src="images/diarysocial/<?php echo $this->item->photo2; ?>" alt="" style="float:rigth" width="40%">
			<img src="images/diarysocial/<?php echo $this->item->photo1; ?>" alt="" style="float:left" width="40%">
			</p>
			
			
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

<input type="hidden" name="jform[youtube1]" value="<?php echo $this->item->youtube1; ?>" />
<input type="hidden" name="jform[youtube2]" value="<?php echo $this->item->youtube2; ?>" />
<input type="hidden" name="jform[photo1]" value="<?php echo $this->item->photo1; ?>" />
<input type="hidden" name="jform[photo2]" value="<?php echo $this->item->photo2; ?>" />
<input type="hidden" name="jform[photo3]" value="<?php echo $this->item->photo3; ?>" />

<input type="hidden" name="jform[dog]" value="<?php echo $this->item->dog; ?>" />
<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
<input type="hidden" name="option" value="com_diary" />
<input type="hidden" name="task" value="diaryitem.remove" />
<?php echo JHtml::_('form.token'); ?>
</form>

<?php endif; ?>
<br/>
<?php 

         $app_id = "340031409395063";
         // $canvas_page = "http://bloggundog.com/fb.php";
         $canvas_page = 'http://www.bloggundog.com';
         // DOES NOT WORK! $message = $this->item->title . ' on ' . $this->item->date;
         // Additional parameters
         $link = '&link=http://www.bloggundog.com';
         //$picture = '&picture="http://upload.wikimedia.org/wikipedia/commons/f/fe/American_Brittany_standing.jpg"';
         //$name    = '&name="Brittany picture"';
         //$caption = '&caption="Training on " . $this->item->date';
         //$description = "HPR line 1<center></center>line 2<center></center>line 3";
	 $description = $this->item->title . ' on ' . $this->item->date;
	 
         //$feed_url = "http://www.facebook.com/dialog/feed?app_id=". $app_id . "&link=" . $link . "&picture=" . $picture . "&name=" . $name . "&caption=" . $caption . "&description=" . $description . "&redirect_uri=" . $canvas_page . "&message=" . $message;

  	$feed_url = "http://www.facebook.com/dialog/feed?app_id=". $app_id . $link . $picture . $name .  $caption . "&description=" . $description . "&redirect_uri=" . $canvas_page . "&message=" . $message;

 echo '<br/>';
//echo 'Facebook message: ' . $feed_url;
 echo '<br/>';

//         if (empty($_REQUEST["post_id"])) {
//            echo("<script> top.location.href='" . $feed_url . "'</script>");
//         } else {
//            echo ("Feed Post Id: " . $_REQUEST["post_id"]);
//         }
// https://www.facebook.com/dialog/feed?app_id=340031409395063&link=http://www.wikipedia.com&
// picture=http://upload.wikimedia.org/wikipedia/commonsf/fe/American_Brittany_standing.jpg&name=new blog&
// caption=news and views&description=about gundogs&redirect_uri=http://bloggundog.com
?>
<!--a class="btn" href="<?php echo $feed_url; ?>" target="default">Post to Facebook</a-->							
							
<?php
else:
            $error = JText::_('COM_DIARY_ITEM_NOT_LOADED');
            JFactory::getApplication()->redirect(JURI::base(), $error, 'error' );
            return false;

endif;
?>

