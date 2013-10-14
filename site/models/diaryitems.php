<?php

/**
 * @version     1.0.0
 * @package     com_diary
 * @copyright   Copyright (C) 2013 FalcoAccipiter. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      FalcoAccipiter <admin@falcoaccipiter.com> - http://www.falcoaccipiter.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Diary records.
 */
class DiaryModelDiaryitems extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {

        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $this->setState('list.limit', $limit);

        $limitstart = JFactory::getApplication()->input->getInt('limitstart', 0);
        $this->setState('list.start', $limitstart);

        

        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        Select the required fields from the table.
        //$query->select(
        //        $this->getState(
        //                'list.select', 'a.*'
        //        )
        //);

	$query->select('a.*');
        $query->from('`#__diaryitems` AS a');
	// Join over the created by field 'created_by'
	$query->select('created_by.name AS created_by');

	$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
        $query->order('a.date DESC, a.title ASC');

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.title LIKE '.$search.'  OR  a.notes LIKE '.$search.'  OR  a.dog LIKE '.$search.' )');
            }
        }

        

		//Filtering date
		$filter_date_from = $this->state->get("filter.date.from");
		if ($filter_date_from) {
			$query->where("a.date >= '".$filter_date_from."'");
		}
		$filter_date_to = $this->state->get("filter.date.to");
		if ($filter_date_to) {
			$query->where("a.date <= '".$filter_date_to."'");
		}

        return $query;
    }

    public function getItems() {
        return parent::getItems();
    }

}
