<?php
/**
 * @version     1.0.0
 * @package     com_diary
 * @copyright   Copyright (C) 2013 FalcoAccipiter. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      FalcoAccipiter <admin@falcoaccipiter.com> - http://www.falcoaccipiter.com
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

//jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldYoutubedisplay extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Youtubedisplay';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
        {

		$html = array();
	       	$video = $this->value;
	       	//FIX add additional tests
       		if (strpos($video,'/') !== false) {
       			$vstringerror = 1;
		}
		$inputpl = 'e.g. kfEy-XpGj2U'; 
		$inputst = '<table><tr><td valign="top"><input name="' . $this->name . '" type="text" size="20" maxlength="20" value="' . $video . '" placeholder = "' . $inputpl .'" ></td></tr>';
		$videost = '<tr><td><iframe width="220" height="165" src="//www.youtube.com/embed/' . $video . '?rel=0" frameborder="0" allowfullscreen></iframe></td><td><a href="http://www.youtube.com" target="_blank">&nbsp;&nbsp;Open<br/>&nbsp;&nbsp;Youtube</a></td></tr></table>';
		 
       		if (empty($video)){
    			$html[] = $inputst . '</table>';
       		}
       		
       		if ((!empty($video)) && (!$vstringerror)) {
			$html[] = $inputst;
			$html[] .= $videost;
		}
		
		
        return implode($html);

	}	
}