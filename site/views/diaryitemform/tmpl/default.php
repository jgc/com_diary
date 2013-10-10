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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_diary', JPATH_ADMINISTRATOR);
?>

<!-- Styling for making front end forms look OK -->
<!-- This should probably be moved to the template CSS file -->
<style>
    .front-end-edit ul {
        padding: 0 !important;
    }
    .front-end-edit li {
        list-style: none;
        margin-bottom: 6px !important;
    }
    .front-end-edit label {
        margin-right: 10px;
        display: block;
        float: left;
        text-align: center;
        width: 200px !important;
    }
    .front-end-edit .radio label {
        float: none;
    }
    .front-end-edit .readonly {
        border: none !important;
        color: #666;
    }    
    .front-end-edit #editor-xtd-buttons {
        height: 50px;
        width: 600px;
        float: left;
    }
    .front-end-edit .toggle-editor {
        height: 50px;
        width: 120px;
        float: right;
    }

    #jform_rules-lbl{
        display:none;
    }

    #access-rules a:hover{
        background:#f5f5f5 url('../images/slider_minus.png') right  top no-repeat;
        color: #444;
    }

    fieldset.radio label{
        width: 50px !important;
    }
</style>
<script type="text/javascript">
    function getScript(url,success) {
        var script = document.createElement('script');
        script.src = url;
        var head = document.getElementsByTagName('head')[0],
        done = false;
        // Attach handlers for all browsers
        script.onload = script.onreadystatechange = function() {
            if (!done && (!this.readyState
                || this.readyState == 'loaded'
                || this.readyState == 'complete')) {
                done = true;
                success();
                script.onload = script.onreadystatechange = null;
                head.removeChild(script);
            }
        };
        head.appendChild(script);
    }
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',function() {
        js = jQuery.noConflict();
        js(document).ready(function(){
            js('#form-diaryitem').submit(function(event){
                 
            }); 
        
            
        });
    });
    
</script>

<?php
$user = JFactory::getUser();
$loginuser = $user->id;
$owner = $this->item->owner;
//echo $loginuser.'-'.$owner;
if (($loginuser == $owner) or ($user->authorise('core.create', 'com_diary')))  {
    $allowEdit = 1;
    $allowState = 1;
    $allowDelete = 1;
} else {
    $allowEdit = 0;
    $allowState = 0;
    $allowDelete = 0;
}	

//$pheading = $this->params->get('page_heading', ''); //does not work consistently, appears to pull in language string??
// $pheading = $active->page_heading; //does not work
// FIX
$pheading = "";

if ((empty($pheading)) and (empty($this->item->id))) {
$nheading = '<h2 class="item-title">Add diary entry</h2>';}

if ((empty($pheading)) and (!empty($this->item->id))) {
//$nheading = '<h1>Edit diary entry '.$this->item->id.'</h1>';}
$nheading = '<h2 class="item-title">Edit diary entry</h2>';}

if ((!empty($pheading)) and (empty($this->item->id))) {
$nheading = '<h2 class="item-title">Add '.$pheading.'</h2>';}

if ((!empty($pheading)) and (!empty($this->item->id))) {
//$nheading = '<h1>Edit '.$pheading.' '.$this->item->id.'</h1>';}
$nheading = '<h2 class="item-title">Edit '.$pheading.'</h2>';}

echo $nheading;
?>

<?php if($allowEdit): ?>

<div class="diaryitem-edit front-end-edit"> 
   
    <form id="form-diaryitem" action="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
        <ul>
            		<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
			<?php if(!$this->item->id){
			    echo '<div class="controls"><input type="hidden" name="jform[owner]" value="'. $loginuser .'"/>';
			} ?>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('date'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('date'); ?></div> 
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('notes'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('notes'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('nameid'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('nameid'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>
		</ul>

        <div>
            <button type="submit" class="validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
            <?php echo JText::_('or'); ?>
            <a href="<?php echo JRoute::_('index.php?option=com_diary&task=diaryitem.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>

            <input type="hidden" name="option" value="com_diary" />
            <input type="hidden" name="task" value="diaryitemform.save" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
    </form>
    <?php else: ?>
    <div class="diaryitem-edit front-end-edit">
    <?php
            $error = JText::_('COM_DIARY_ITEM_NOT_LOADED');
            JFactory::getApplication()->redirect(JURI::base(), $error, 'error' );
            return false;
            ?>
	</div>
    <?php endif; ?>