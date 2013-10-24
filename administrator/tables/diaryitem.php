<?php

/**
 * @version     1.0.0
 * @package     com_diary
 * @copyright   Copyright (C) 2013 FalcoAccipiter. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      FalcoAccipiter <admin@falcoaccipiter.com> - http://www.falcoaccipiter.com
 */
// No direct access
defined('_JEXEC') or die;

/**
 * diaryitem Table class
 */
class DiaryTablediaryitem extends JTable {

    /**
     * Constructor
     *
     * @param JDatabase A database connector object
     */
    public function __construct(&$db) {
        parent::__construct('#__diaryitems', 'id', $db);
    }

    /**
     * Overloaded bind function to pre-process the params.
     *
     * @param	array		Named array
     * @return	null|string	null is operation was satisfactory, otherwise returns an error
     * @see		JTable:bind
     * @since	1.5
     */
    public function bind($array, $ignore = '') {

        
		$input = JFactory::getApplication()->input;
		$task = $input->getString('task', '');
		if(($task == 'save' || $task == 'apply') && (!JFactory::getUser()->authorise('core.edit.state','com_diary.diaryitem.'.$array['id']) && $array['state'] == 1)){
			$array['state'] = 0;
		}
		$task = JRequest::getVar('task');
		if($task == 'apply' || $task == 'save'){
			$array['modified'] = date("Y-m-d H:i:s");
		}
			//Support for file field: photo1
				if(isset($_FILES['jform']['name']['photo1'])):
					jimport('joomla.filesystem.file');
					jimport('joomla.filesystem.file');
					$file = $_FILES['jform'];

					//Check if the server found any error.
					$fileError = $file['error']['photo1'];
					$message = '';
					if($fileError > 0 && $fileError != 4) {
						switch ($fileError) :
							case 1:
								$message = JText::_( 'File size exceeds allowed by the server');
								break;
							case 2:
								$message = JText::_( 'File size exceeds allowed by the html form');
								break;
							case 3:
								$message = JText::_( 'Partial upload error');
								break;
						endswitch;
						if($message != '') :
							JError::raiseWarning(500,$message);
							return false;
						endif;
					}
					else if($fileError == 4){
						if(isset($array['photo1_hidden'])):;
							$array['photo1'] = $array['photo1_hidden'];
						endif;
					}
					else{

						//Check for filesize
						$fileSize = $file['size']['photo1'];
						if($fileSize > 1048576):
							JError::raiseWarning(500, 'File bigger than 1MB' );
							return false;
						endif;

						//Check for filetype
						$okMIMETypes = 'image/jpeg,image/png,image/gif';
						$validMIMEArray = explode(",",$okMIMETypes);
						$fileMime = $file['type']['photo1'];
						if(!in_array($fileMime,$validMIMEArray)):
							JError::raiseWarning(500,'This filetype is not allowed');
							return false;
						endif;

						//Replace any special characters in the filename
						$filename = explode('.',$file['name']['photo1']);
						$filename[0] = preg_replace("/[^A-Za-z0-9]/i", "-", $filename[0]);

						//Add Timestamp MD5 to avoid overwriting
						$filename = md5(time()) . '-' . implode('.',$filename);
						// $uploadPath =JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_photo'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.$filename;
						
						$uploadPath = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.$filename;
						
						$fileTemp = $file['tmp_name']['photo1'];
						
						if(!JFile::exists($uploadPath)):

							if (!JFile::upload($fileTemp, $uploadPath)):

								JError::raiseWarning(500,'Error moving file');

								return false;

							endif;

						endif;


// $ofile = JPATH_ROOT . DIRECTORY_SEPARATOR .'raindrops2.jpg'; //works
// $nfile = JPATH_ROOT . DIRECTORY_SEPARATOR .'xxx.jpg'; //works

$ofile = $uploadPath;//works
//$nfile = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.$filename.'.jpg'; //works
//$nfile = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.'q75-'.$filename; //works
$nfile = $uploadPath;//works

$image=imagecreatefromjpeg($ofile);  // MUST match image type when 
//imagefilter($image, IMG_FILTER_GRAYSCALE);
imagefilter($image, IMG_FILTER_SMOOTH, 6);
imagejpeg($image,$nfile, 75);
imagedestroy($image);
//unlink($uploadPath);

$notice = 'ofile: ' . $ofile . '<br/>nfile: ' . $nfile;
$notice .= '<br/>filename: ' . $filename . '<br/>';

//debug message
//echo JError::raiseNotice(100,$notice);

$array['photo1'] = $filename;
}

endif;
//************************************************************************
			//Support for file field: photo2
				if(isset($_FILES['jform']['name']['photo2'])):
					jimport('joomla.filesystem.file');
					jimport('joomla.filesystem.file');
					$file = $_FILES['jform'];

					//Check if the server found any error.
					$fileError = $file['error']['photo2'];
					$message = '';
					if($fileError > 0 && $fileError != 4) {
						switch ($fileError) :
							case 1:
								$message = JText::_( 'File size exceeds allowed by the server');
								break;
							case 2:
								$message = JText::_( 'File size exceeds allowed by the html form');
								break;
							case 3:
								$message = JText::_( 'Partial upload error');
								break;
						endswitch;
						if($message != '') :
							JError::raiseWarning(500,$message);
							return false;
						endif;
					}
					else if($fileError == 4){
						if(isset($array['photo2_hidden'])):;
							$array['photo2'] = $array['photo2_hidden'];
						endif;
					}
					else{

						//Check for filesize
						$fileSize = $file['size']['photo2'];
						if($fileSize > 1048576):
							JError::raiseWarning(500, 'File bigger than 1MB' );
							return false;
						endif;

						//Check for filetype
						$okMIMETypes = 'image/jpeg,image/png,image/gif';
						$validMIMEArray = explode(",",$okMIMETypes);
						$fileMime = $file['type']['photo2'];
						if(!in_array($fileMime,$validMIMEArray)):
							JError::raiseWarning(500,'This filetype is not allowed');
							return false;
						endif;

						//Replace any special characters in the filename
						$filename = explode('.',$file['name']['photo2']);
						$filename[0] = preg_replace("/[^A-Za-z0-9]/i", "-", $filename[0]);

						//Add Timestamp MD5 to avoid overwriting
						$filename = md5(time()) . '-' . implode('.',$filename);
						// $uploadPath =JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_photo'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.$filename;
						
						$uploadPath = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.$filename;
						
						$fileTemp = $file['tmp_name']['photo2'];
						
						if(!JFile::exists($uploadPath)):

							if (!JFile::upload($fileTemp, $uploadPath)):

								JError::raiseWarning(500,'Error moving file');

								return false;

							endif;

						endif;


// $ofile = JPATH_ROOT . DIRECTORY_SEPARATOR .'raindrops2.jpg'; //works
// $nfile = JPATH_ROOT . DIRECTORY_SEPARATOR .'xxx.jpg'; //works

$ofile = $uploadPath;//works
//$nfile = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.$filename.'.jpg'; //works
//$nfile = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.'q75-'.$filename; //works
$nfile = $uploadPath;//works

$image=imagecreatefromjpeg($ofile);  // MUST match image type when 
//imagefilter($image, IMG_FILTER_GRAYSCALE);
imagefilter($image, IMG_FILTER_SMOOTH, 6);
imagejpeg($image,$nfile, 75);
imagedestroy($image);
//unlink($uploadPath);

$notice = 'ofile: ' . $ofile . '<br/>nfile: ' . $nfile;
$notice .= '<br/>filename: ' . $filename . '<br/>';

//debug message
//echo JError::raiseNotice(100,$notice);

$array['photo2'] = $filename;
}
endif;
//*****************************************************
			//Support for file field: photo3
				if(isset($_FILES['jform']['name']['photo3'])):
					jimport('joomla.filesystem.file');
					jimport('joomla.filesystem.file');
					$file = $_FILES['jform'];

					//Check if the server found any error.
					$fileError = $file['error']['photo3'];
					$message = '';
					if($fileError > 0 && $fileError != 4) {
						switch ($fileError) :
							case 1:
								$message = JText::_( 'File size exceeds allowed by the server');
								break;
							case 2:
								$message = JText::_( 'File size exceeds allowed by the html form');
								break;
							case 3:
								$message = JText::_( 'Partial upload error');
								break;
						endswitch;
						if($message != '') :
							JError::raiseWarning(500,$message);
							return false;
						endif;
					}
					else if($fileError == 4){
						if(isset($array['photo3_hidden'])):;
							$array['photo3'] = $array['photo3_hidden'];
						endif;
					}
					else{

						//Check for filesize
						$fileSize = $file['size']['photo3'];
						if($fileSize > 1048576):
							JError::raiseWarning(500, 'File bigger than 1MB' );
							return false;
						endif;

						//Check for filetype
						$okMIMETypes = 'image/jpeg,image/png,image/gif';
						$validMIMEArray = explode(",",$okMIMETypes);
						$fileMime = $file['type']['photo3'];
						if(!in_array($fileMime,$validMIMEArray)):
							JError::raiseWarning(500,'This filetype is not allowed');
							return false;
						endif;

						//Replace any special characters in the filename
						$filename = explode('.',$file['name']['photo3']);
						$filename[0] = preg_replace("/[^A-Za-z0-9]/i", "-", $filename[0]);

						//Add Timestamp MD5 to avoid overwriting
						$filename = md5(time()) . '-' . implode('.',$filename);
						// $uploadPath =JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_photo'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.$filename;
						
						$uploadPath = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.$filename;
						
						$fileTemp = $file['tmp_name']['photo3'];
						
						if(!JFile::exists($uploadPath)):

							if (!JFile::upload($fileTemp, $uploadPath)):

								JError::raiseWarning(500,'Error moving file');

								return false;

							endif;

						endif;


// $ofile = JPATH_ROOT . DIRECTORY_SEPARATOR .'raindrops2.jpg'; //works
// $nfile = JPATH_ROOT . DIRECTORY_SEPARATOR .'xxx.jpg'; //works

$ofile = $uploadPath;//works
//$nfile = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.$filename.'.jpg'; //works
//$nfile = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'diaryitems'.DIRECTORY_SEPARATOR.'q75-'.$filename; //works
$nfile = $uploadPath;//works

$image=imagecreatefromjpeg($ofile);  // MUST match image type when 
//imagefilter($image, IMG_FILTER_GRAYSCALE);
imagefilter($image, IMG_FILTER_SMOOTH, 6);
imagejpeg($image,$nfile, 75);
imagedestroy($image);
//unlink($uploadPath);

$notice = 'ofile: ' . $ofile . '<br/>nfile: ' . $nfile;
$notice .= '<br/>filename: ' . $filename . '<br/>';

//debug message
//echo JError::raiseNotice(100,$notice);
$array['photo3'] = $filename;
}
endif;

//**********************



		//Support for checkbox field: checkbox
		if (!isset($array['checkbox'])){
			$array['checkbox'] = 0;
		}

        if (isset($array['params']) && is_array($array['params'])) {
            $registry = new JRegistry();
            $registry->loadArray($array['params']);
            $array['params'] = (string) $registry;
        }

        if (isset($array['metadata']) && is_array($array['metadata'])) {
            $registry = new JRegistry();
            $registry->loadArray($array['metadata']);
            $array['metadata'] = (string) $registry;
        }
        if(!JFactory::getUser()->authorise('core.admin', 'com_diary.diaryitem.'.$array['id'])){
            $actions = JFactory::getACL()->getActions('com_diary','diaryitem');
            $default_actions = JFactory::getACL()->getAssetRules('com_diary.diaryitem.'.$array['id'])->getData();
            $array_jaccess = array();
            foreach($actions as $action){
                $array_jaccess[$action->name] = $default_actions[$action->name];
            }
            $array['rules'] = $this->JAccessRulestoArray($array_jaccess);
        }
        //Bind the rules for ACL where supported.
		if (isset($array['rules']) && is_array($array['rules'])) {
			$this->setRules($array['rules']);
		}

        return parent::bind($array, $ignore);
    }
    
    /**
     * This function convert an array of JAccessRule objects into an rules array.
     * @param type $jaccessrules an arrao of JAccessRule objects.
     */
    private function JAccessRulestoArray($jaccessrules){
        $rules = array();
        foreach($jaccessrules as $action => $jaccess){
            $actions = array();
            foreach($jaccess->getData() as $group => $allow){
                $actions[$group] = ((bool)$allow);
            }
            $rules[$action] = $actions;
        }
        return $rules;
    }

    /**
     * Overloaded check function
     */
    public function check() {

        //If there is an ordering column and this is a new row then get the next ordering value
        if (property_exists($this, 'ordering') && $this->id == 0) {
            $this->ordering = self::getNextOrder();
        }

        return parent::check();
    }

    /**
     * Method to set the publishing state for a row or list of rows in the database
     * table.  The method respects checked out rows by other users and will attempt
     * to checkin rows that it can after adjustments are made.
     *
     * @param    mixed    An optional array of primary key values to update.  If not
     *                    set the instance property value is used.
     * @param    integer The publishing state. eg. [0 = unpublished, 1 = published]
     * @param    integer The user id of the user performing the operation.
     * @return    boolean    True on success.
     * @since    1.0.4
     */
    public function publish($pks = null, $state = 1, $userId = 0) {
        // Initialise variables.
        $k = $this->_tbl_key;

        // Sanitize input.
        JArrayHelper::toInteger($pks);
        $userId = (int) $userId;
        $state = (int) $state;

        // If there are no primary keys set check to see if the instance key is set.
        if (empty($pks)) {
            if ($this->$k) {
                $pks = array($this->$k);
            }
            // Nothing to set publishing state on, return false.
            else {
                $this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
                return false;
            }
        }

        // Build the WHERE clause for the primary keys.
        $where = $k . '=' . implode(' OR ' . $k . '=', $pks);

        // Determine if there is checkin support for the table.
        if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time')) {
            $checkin = '';
        } else {
            $checkin = ' AND (checked_out = 0 OR checked_out = ' . (int) $userId . ')';
        }

        // Update the publishing state for rows with the given primary keys.
        $this->_db->setQuery(
                'UPDATE `' . $this->_tbl . '`' .
                ' SET `state` = ' . (int) $state .
                ' WHERE (' . $where . ')' .
                $checkin
        );
        $this->_db->query();

        // Check for a database error.
        if ($this->_db->getErrorNum()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // If checkin is supported and all rows were adjusted, check them in.
        if ($checkin && (count($pks) == $this->_db->getAffectedRows())) {
            // Checkin each row.
            foreach ($pks as $pk) {
                $this->checkin($pk);
            }
        }

        // If the JTable instance value is in the list of primary keys that were set, set the instance.
        if (in_array($this->$k, $pks)) {
            $this->state = $state;
        }

        $this->setError('');
        return true;
    }
    
    /**
      * Define a namespaced asset name for inclusion in the #__assets table
      * @return string The asset name 
      *
      * @see JTable::_getAssetName 
    */
    protected function _getAssetName() {
        $k = $this->_tbl_key;
        return 'com_diary.diaryitem.' . (int) $this->$k;
    }
 
    /**
      * Returns the parent asset's id. If you have a tree structure, retrieve the parent's id using the external key field
      *
      * @see JTable::_getAssetParentId 
    */
    protected function _getAssetParentId($table = null, $id = null){
        // We will retrieve the parent-asset from the Asset-table
        $assetParent = JTable::getInstance('Asset');
        // Default: if no asset-parent can be found we take the global asset
        $assetParentId = $assetParent->getRootId();
        // The item has the component as asset-parent
        $assetParent->loadByName('com_diary');
        // Return the found asset-parent-id
        if ($assetParent->id){
            $assetParentId=$assetParent->id;
        }
        return $assetParentId;
    }
    
}