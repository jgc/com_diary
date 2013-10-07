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

jimport('joomla.application.component.view');

/**
 * View class for a list of Diary.
 */
class DiaryViewDiaryitems extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		DiaryHelper::addSubmenu('diaryitems');
        
		$this->addToolbar();
        
        $this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/diary.php';

		$state	= $this->get('State');
		$canDo	= DiaryHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_DIARY_TITLE_DIARYITEMS'), 'diaryitems.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/diaryitem';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('diaryitem.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('diaryitem.edit','JTOOLBAR_EDIT');
		    }

        }

		if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('diaryitems.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('diaryitems.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'diaryitems.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('diaryitems.archive','JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('diaryitems.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'diaryitems.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::trash('diaryitems.trash','JTOOLBAR_TRASH');
			    JToolBarHelper::divider();
		    }
        }

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_diary');
		}
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_diary&view=diaryitems');
        
        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

			//Filter for the field ditemdate
			$this->extra_sidebar .= '<small><label for="filter_from_ditemdate">From Ditemdate</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.ditemdate.from'), 'filter_from_ditemdate', 'filter_from_ditemdate', '%Y-%m-%d', 'style="width:142px;" onchange="this.form.submit();"');
			$this->extra_sidebar .= '<small><label for="filter_to_ditemdate">To Ditemdate</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.ditemdate.to'), 'filter_to_ditemdate', 'filter_to_ditemdate', '%Y-%m-%d', 'style="width:142px;" onchange="this.form.submit();"');
			$this->extra_sidebar .= '<hr class="hr-condensed">';

			//Filter for the field created
			$this->extra_sidebar .= '<small><label for="filter_from_created">From Created</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.created.from'), 'filter_from_created', 'filter_from_created', '%Y-%m-%d', 'style="width:142px;" onchange="this.form.submit();"');
			$this->extra_sidebar .= '<small><label for="filter_to_created">To Created</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.created.to'), 'filter_to_created', 'filter_to_created', '%Y-%m-%d', 'style="width:142px;" onchange="this.form.submit();"');
			$this->extra_sidebar .= '<hr class="hr-condensed">';

        
	}
    
	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.checked_out' => JText::_('COM_DIARY_DIARYITEMS_CHECKED_OUT'),
		'a.checked_out_time' => JText::_('COM_DIARY_DIARYITEMS_CHECKED_OUT_TIME'),
		'a.created_by' => JText::_('COM_DIARY_DIARYITEMS_CREATED_BY'),
		'a.dname' => JText::_('COM_DIARY_DIARYITEMS_DNAME'),
		'a.ditemdate' => JText::_('COM_DIARY_DIARYITEMS_DITEMDATE'),
		'a.notes' => JText::_('COM_DIARY_DIARYITEMS_NOTES'),
		'a.createdby' => JText::_('COM_DIARY_DIARYITEMS_CREATEDBY'),
		'a.created' => JText::_('COM_DIARY_DIARYITEMS_CREATED'),
		'a.updated' => JText::_('COM_DIARY_DIARYITEMS_UPDATED'),
		'a.fileupload' => JText::_('COM_DIARY_DIARYITEMS_FILEUPLOAD'),
		'a.dint' => JText::_('COM_DIARY_DIARYITEMS_DINT'),
		'a.checkbox' => JText::_('COM_DIARY_DIARYITEMS_CHECKBOX'),
		);
	}

    
}
