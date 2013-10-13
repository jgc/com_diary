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
class JFormFieldNamepname extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Namepname';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
        {
		//$loginuser = 897;
		$user =& JFactory::getUser();
 		if ($user->id == 0) {
		} else {
			$loginusername = $user->name;
			$loginuserid = $user->id;
		}
		$wh = 'state = 1 and owner = '.$loginuser;
		$db =& JFactory::getDbo();
		$query = "SELECT id, pname FROM #__diarynames WHERE (state = '1' and owner = '".$loginuserid."') order by pname ASC";
		//$query = "SELECT id, pname FROM #__diarynames WHERE (state = '1') order by pname ASC";
		$db->setQuery($query);
		
		//$db = JFactory::getDBO();
		//$query = $db->getQuery(true);
		//$query->select('id, pname');
		//$query->from('#__diarynames');
		//$query->where('owner = 879');
		//$db->setQuery((string)$query);
		//$db->setQuery($query);
		
		$sample = $db->loadObjectList();
		$options = array();
		if ($sample)
		{
		$html[] = '<select>';
		foreach($sample as $item)
		{
			$html[] .= '<option value="'.$item->id.'">'.$item->pname.'</option>';
		}
		$html[] .= '</select>';
		}

        	return implode($html);

	}
	
}