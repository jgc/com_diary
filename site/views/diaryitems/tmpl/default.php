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

<?php 
$readmore = "<strong>Read more ...</strong>&nbsp;";
$readmoreEdit = "<strong>Edit / Read more ...</strong>&nbsp;";


// $pheading = $this->params->get('page_heading', '');  // '$active->page_heading' also works
$pheading = "Latest diary entries";
if ($pheading != ""){
    echo '<h2 class="item-title">'.$pheading.'</h2>';
} else {
    echo '<h2 class="item-title">Latest diary entries</h2>';
}
                      
?>

<div class="items">

<?php $show = false; ?>

<?php foreach ($this->items as $item) : ?>        

<?php
$viewState = 1;
$displayPublish = 0;
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

if(($item->state == 1 || ($item->state == 0 && $allowEdit)) or $viewState):
						$show = true;
						?>
						    <div>
							<?php
							$date = date_create_from_format('Y-m-j', $item->date);
							$datest = date_format($date, 'd M Y');
							$datesth = date_format($date, 'F d');
							$display = '<br/><strong>' . $datesth . '</strong>&nbsp;&nbsp;';
							
							if (!empty($item->title))
							{
							$display .= ' ' . ucfirst($item->title) . '';    
							}

							//$display .= '</strong>';

							if (!empty($item->nameid)) 
							{
							//echo $item->nameid . '<br/>';
							$db = JFactory::getDbo();
							$query = $db->getQuery(true);
							$query->select('pname');
							$query->from($db->quoteName('#__diarynames'));
							$query->where($db->quoteName('id')." = ".$db->quote($item->nameid));
							$db->setQuery($query);
							$nameidname = $db->loadResult();
							//echo $query . ' ' . $result . '<br/>';
							$display .= ' with ' . ucfirst($nameidname) . ''; 
							}
							
							if (!empty($item->owner))
							{
							$user = JFactory::getUser($item->owner);
							//$username = $user->get('username');
							$username = $user->get('name');
							$display .= ' [by ' . ucfirst($username) . ']';    
							}
														
							//$display .= '</strong>';
							//$display .= '</a>';
							
         $app_id = "340031409395063";
         // $canvas_page = "http://bloggundog.com/fb.php";
         $canvas_page = 'http://www.bloggundog.com';
         // $message = $this->item->title . ' on ' . $this->item->date; //DOES NOT WORK! 
         // Additional parameters
         $link = '&link=http://www.bloggundog.com/diary-entries/'.$item->id.'?view=diaryitem';
         $flink = 'http://www.bloggundog.com/diary-entries/'.$item->id.'?view=diaryitem';
         $tlink = 'http://www.bloggundog.com/diary-entries/'.$item->id.'?view=diaryitem';
         //$picture = '&picture="http://upload.wikimedia.org/wikipedia/commons/f/fe/American_Brittany_standing.jpg"';
         //$name    = '&name="Brittany picture"';
         //$caption = '&caption="Training on " . $this->item->date';
         //$description = "HPR line 1<center></center>line 2<center></center>line 3";
         
         if (!empty($item->title)){
	 	$description = $datest . ' ' . $item->title . '<center></center>&nbsp;<center></center>Link to details above';
	 	$fdescription = $datest . ' ' . $item->title . ' on Gundog Diary. ' ;
	 	//FIX handle long titles so only 140 characters in tweet
 	 	$tdescription = $datest . ' ' . $item->title . '&#46; Gundog Diary. ' ;         
         } else {
         	$description = $datest . ' ' . $item->title . '<center></center>&nbsp;<center></center>Link to details above';
	 	$fdescription = $datest . ' on Gundog Diary ' ;
	 	//FIX handle long titles so only 140 characters in tweet
 	 	$tdescription = $datest . ' on Gundog Diary ' ;
         }
	
         //$feed_url = "http://www.facebook.com/dialog/feed?app_id=". $app_id . "&link=" . $link . "&picture=" . $picture . "&name=" . $name . "&caption=" . $caption . "&description=" . $description . "&redirect_uri=" . $canvas_page . "&message=" . $message;

  	$feed_url = "http://www.facebook.com/dialog/feed?app_id=". $app_id . $link . $picture . $name .  $caption . "&description=" . $description . "&redirect_uri=" . $canvas_page . "&message=" . $message;

//echo '<br/>';
//echo 'Facebook message: ' . $feed_url;//echo '<br/>';

//         if (empty($_REQUEST["post_id"])) {
//            echo("<script> top.location.href='" . $feed_url . "'</script>");
//         } else {
//            echo ("Feed Post Id: " . $_REQUEST["post_id"]);
//         }
// https://www.facebook.com/dialog/feed?app_id=340031409395063&link=http://www.wikipedia.com&
// picture=http://upload.wikimedia.org/wikipedia/commonsf/fe/American_Brittany_standing.jpg&name=new blog&
// caption=news and views&description=about gundogs&redirect_uri=http://bloggundog.com
?>
							
<?php if(!$allowEdit): ?>
<?php echo $display; ?>

<?php else: ?>
<?php echo $display; ?>

<?php endif; ?>
							
<?php
if (!empty($item->notes))
{
echo '<br/>&nbsp;&nbsp;' . $item->notes . '';
}
?>
<br/>

&nbsp;&nbsp;
<?php if(!$allowEdit): ?>
<a href="<?php echo JRoute::_('index.php?option=com_diary&view=diaryitem&id=' . (int)$item->id); ?>"><?php echo $readmore; ?></a>

<?php else: ?>
<a href="<?php echo JRoute::_('index.php?option=com_diary&view=diaryitemform&id=' . (int)$item->id); ?>"><?php echo $readmoreEdit; ?></a>

<?php endif; ?>

<?php if(($allowState) & ($displayPublish == 1)): ?>
<br/>
&nbsp;&nbsp;

<?php if($item->state == 1): ?>
<?php echo JText::_("COM_DIARY_PUBLISH_ITEM"); ?>
&nbsp;<a class="icon-publish" href="javascript:document.getElementById('form-diaryitem-state-<?php echo $item->id; ?>').submit()">

<?php else: ?>
<?php echo JText::_("COM_DIARY_UNPUBLISH_ITEM"); ?>
&nbsp;<a class="icon-unpublish" href="javascript:document.getElementById('form-diaryitem-state-<?php echo $item->id; ?>').submit()">

<?php endif; ?>
</a>
										<form id="form-diaryitem-state-<?php echo $item->id ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="jform[state]" value="<?php echo (int)!((int)$item->state); ?>" />
											<input type="hidden" name="jform[owner]" value="<?php echo $item->owner; ?>" />
											<input type="hidden" name="jform[date]" value="<?php echo $item->date; ?>" />
											<input type="hidden" name="jform[title]" value="<?php echo $item->title; ?>" />
											<input type="hidden" name="jform[notes]" value="<?php echo $item->notes; ?>" />
											<input type="hidden" name="jform[nameid]" value="<?php echo $item->nameid; ?>" />
											<input type="hidden" name="option" value="com_diary" />
											<input type="hidden" name="task" value="diaryitem.save" />
											<?php echo JHtml::_('form.token'); ?>
</form>
<?php endif;




if($allowDelete):?>
<script type="text/javascript">
    function deleteItem(item_id){
        if(confirm("<?php echo JText::_('COM_DIARY_DELETE_MESSAGE'); ?>")){
            document.getElementById('form-diaryitem-delete-' + item_id).submit();
        }
    }
</script>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo JText::_("COM_DIARY_DELETE_ITEM"); ?>
&nbsp;<a class="icon-trash" href="javascript:deleteItem(<?php echo $item->id; ?>);"></a>
&nbsp;&nbsp;&nbsp;&nbsp;

<form id="form-diaryitem-delete-<?php echo $item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="jform[state]" value="<?php echo $item->state; ?>" />
											<input type="hidden" name="jform[owner]" value="<?php echo $item->owner; ?>" />
											<input type="hidden" name="jform[date]" value="<?php echo $item->date; ?>" />
											<input type="hidden" name="jform[title]" value="<?php echo $item->title; ?>" />
											<input type="hidden" name="jform[notes]" value="<?php echo $item->notes; ?>" />
											<input type="hidden" name="jform[nameid]" value="<?php echo $item->nameid; ?>" />
											<input type="hidden" name="jform[created_by]" value="<?php echo $item->created_by; ?>" />
											<input type="hidden" name="option" value="com_diary" />
											<input type="hidden" name="task" value="diaryitem.remove" />
											<?php echo JHtml::_('form.token'); ?>
</form>
<?php endif; ?>

&nbsp;&nbsp;

<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
<a href="https://twitter.com/intent/tweet?text=<?php echo $tdescription; ?>&url=<?php echo $tlink; ?>&related="><img src="<?php echo JURI::root();?>images/diarysocial/bird_blue_16.png" width="20px" alt="Tweet" /></a>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<a href="<?php echo $feed_url; ?>" target="default">
<img src="<?php echo JURI::root();?>images/diarysocial/facebook.png" width="20px" padding="5" alt="Publish to Facebook"></a>

</div>
<br/>

<?php endif; ?>

<?php endforeach; ?>
<br/>

<?php
        if (!$show):
            echo JText::_('COM_DIARY_NO_ITEMS');
        endif;
        ?>

</div>

<?php if ($show): ?>
    <div class="pagination">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
    
<?php endif; ?>
<br/>
<?php if(JFactory::getUser()->authorise('core.create','com_diary')): ?><a href="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.edit&id=0'); ?>"><?php echo JText::_("COM_DIARY_ADD_ITEM"); ?></a>
	
<?php endif; ?>