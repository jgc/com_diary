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
class JFormFieldPhotodisplay extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Photodisplay';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
        {

		$html = array();
       
		//Load name
		$nameid = $this->value;
		
		$user =& JFactory::getUser();
 		if ($user->id == 0) {
		} else {
			$loginusername = $user->name;
			$loginuserid = $user->id;
		}
		$wh = 'state = 1 and owner = '.$loginuser;
		$db =& JFactory::getDbo();
		//$query = "SELECT id, pname FROM #__diarynames WHERE (state = '1' and owner = '".$loginuserid."') order by pname ASC";
		$query = "SELECT id, pname FROM #__diarynames WHERE (owner = '".$loginuserid."') order by pname ASC";
		$db->setQuery($query);
		$sample = $db->loadObjectList();
		$options = array();
		if ($sample)
		{

		$html[] = '<select id="jform_nameid" name="jform[nameid]" class="inputbox" size="1">';
		foreach($sample as $item)
		{
			if ($item->id == $nameid){
				$html[] .= '<option value="'.$item->id.'" selected >'.$item->pname.'</option>';
			} else {
				$html[] .= '<option value="'.$item->id.'">'.$item->pname.'</option>';
			}
		}
		$html[] .= '</select>';
		}

        return implode($html);

	}	
}