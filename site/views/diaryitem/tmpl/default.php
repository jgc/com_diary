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

<div class="items">

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
			<?php if (!empty($this->item->date)): ?>	
			<?php 
				$date = date_create_from_format('Y-m-j', $this->item->date);
				$datest = date_format($date, 'd M Y');
				$datesth = date_format($date, 'd F Y');
				$display = '<div><strong>' . $datesth . '</strong>&nbsp;&nbsp;';
				echo $display;
			?>
			<?php endif; ?>
			
			<?php if (!empty($this->item->title)): ?>	
			<?php echo '' . $this->item->title . '</strong></div>'; ?>
			<?php endif; ?>
			
			<?php if (empty($this->item->title)): ?>	
			<?php echo '</strong></div>'; ?>
			<?php endif; ?>
			
			<?php if (!empty($this->item->nameid)): ?>
			<?php
			echo $item->nameid . ' ';
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('pname');
			$query->from($db->quoteName('#__diarynames'));
			$query->where($db->quoteName('id')." = ".$db->quote($this->item->nameid));
			$db->setQuery($query);
			$nameidname = $db->loadResult();
			//echo $query . ' ' . $result . '<br/>';
			?>
			<?php echo '&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
			<?php echo '<div><strong>Dog/s:&nbsp;</strong>'; ?>
			<?php echo ''.$nameidname; ?></div><br/>
			<?php endif; ?>
			
			<?php if (!empty($this->item->notes)): ?>			
			<div><?php echo '<strong>' . JText::_('COM_DIARY_FORM_LBL_DIARYITEM_NOTES') . '</strong>'; ?><br/>
			<?php echo $this->item->notes; ?></div><br/>
			<?php endif; ?>

<?php //FIX code - make loop for video and images ?>			
			<?php if ((!empty($this->item->photo1)) or (!empty($this->item->photo2)) or (!empty($this->item->photo3))): ?>
			<div><?php echo '<strong>Photo/s</strong>'; ?></div><div>
			<?php if (!empty($this->item->photo1)): ?>
			<img src="<?php echo JRoute::_(JUri::base() . 'images/diaryitems' .DIRECTORY_SEPARATOR . $this->item->photo1, true);?>" alt="<?php echo $this->item->photo1; ?>" width = "48%" />
			<?php endif; ?>
			<?php if (!empty($this->item->photo2)): ?>
			<img src="<?php echo JRoute::_(JUri::base() . 'images/diaryitems' .DIRECTORY_SEPARATOR . $this->item->photo2, true);?>" alt="<?php echo $this->item->photo2; ?>" width = "48%" />
			<?php endif; ?>
			<?php if (!empty($this->item->photo3)): ?>
			<img src="<?php echo JRoute::_(JUri::base() . 'images/diaryitems' .DIRECTORY_SEPARATOR . $this->item->photo3, true);?>" alt="<?php echo $this->item->photo3; ?>" width = "48%" />
			<?php endif; ?>
			</div><br/><br/>
			<?php endif; ?>

			<?php if ((!empty($this->item->youtube1)) or (!empty($this->item->youtube2))): ?>
			<div><?php echo '<strong>Video/s</strong>'; ?></div><div>
			<?php if (!empty($this->item->youtube1)): ?>
			<iframe width="48%" src="//www.youtube.com/embed/<?php echo $this->item->youtube1; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
			<?php endif; ?>
			<?php if (!empty($this->item->youtube2)): ?>			
			<iframe width="48%" src="//www.youtube.com/embed/<?php echo $this->item->youtube2; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
			<?php endif; ?>
			</div><br/>
			<?php endif; ?>			

   
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

<input type="hidden" name="jform[nameid]" value="<?php echo $this->item->nameid; ?>" />
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
							
							
<?php
else:
            $error = JText::_('COM_DIARY_ITEM_NOT_LOADED');
            JFactory::getApplication()->redirect(JURI::base(), $error, 'error' );
            return false;

endif; ?>

</div>

<br/>
<div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'bloggundog'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>


</div>
    

