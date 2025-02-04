<?php
/** 
 * @package     VikRestaurants
 * @subpackage  core
 * @author      E4J s.r.l.
 * @copyright   Copyright (C) 2023 E4J s.r.l. All Rights Reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @link        https://vikwp.com
 */

// No direct access
defined('ABSPATH') or die('No script kiddies please!');

/**
 * VikRestaurants restaurant reservation search view.
 * Within this view is displayed the search results
 * of the request made, usually through the "restaurants"
 * view or with the "search" module. 
 *
 * @since 1.0
 */
class VikRestaurantsViewsearch extends JViewVRE
{
	/**
	 * VikRestaurants view display method.
	 *
	 * @return 	void
	 */
	function display($tpl = null)
	{	
		$app = JFactory::getApplication();
		$dbo = JFactory::getDbo();
		
		// get search arguments
		$args = [];
		$args['date']    = $app->input->get('date', '', 'string');
		$args['hourmin'] = $app->input->get('hourmin', '', 'string');
		$args['people']  = $app->input->get('people', 0, 'uint');

		// get selected room
		$selected_room_id = $app->input->get('room', 0, 'uint');

		// it is not needed to check the integrity of the searched
		// arguments because thay have been already validated by
		// the controller before accessing this view

		/**
		 * Look for COVID19 prevention measures.
		 *
		 * @since 1.8
		 *
		 * @see COVID-19
		 */
		$people = VikRestaurants::getPeopleSafeDistance($args['people']);

		// instantiate availability search
		$search = new VREAvailabilitySearch($args['date'], $args['hourmin'], $people);

		// inject hours and minutes within $args
		$args['hour'] = $search->get('hour');
		$args['min']  = $search->get('min');

		// get all the tables available for the specified search arguments
		$avail = $search->getAvailableTables();

		// split standard tables from shared tables
		$standard = $shared = [];

		foreach ($avail as $table)
		{
			if (!$table->multi_res)
			{
				$standard[] = $table;
			}
			else
			{
				$shared[] = $table;
			}
		}

		// first attempt, try to search for a free STANDARD table
		$attempt = 1;
		
		if (count($standard) == 0)
		{
			// second attempt, try to search for a free SHARED table
			$attempt++;
			
			if (count($shared) == 0)
			{
				// third attempt, no available tables
				$attempt++;
			}
			
			// Elaborate time hints.
			// The method will return the first 2 available times before
			// the selected check-in time and the next 2. Such as:
			// 12:00 | 12:30 | CURRENT | 13:30 | 14:30
			// It is possible to pass a number to the function below
			// to increase/decrease the number of suggested times.
			$hints = $search->getSuggestedTimes();
		}
		else
		{
			$hints = null;
		}

		// create time object based on check-in time
		$timeslot = JHtml::fetch('vikrestaurants.min2time', $args['hour'] * 60 + $args['min'], $string = false);
		// include timestamp
		$timeslot->ts = VikRestaurants::createTimestamp($args['date'], $args['hour'], $args['min']);

		// in case of table selection, we need to count all
		// the guests assigned to each shared table
		if (VREFactory::getConfig()->getUint('reservationreq') == 0)
		{
			// obtain lookup with table ID (key) and
			// number of guests (value)
			$occurrences = $search->getTablesOccurrence();
		}
		else
		{
			$occurrences = [];
		}

		// get all rooms with related tables
		$rooms = $search->getRooms();

		// translate rooms in case multi-lingual is supported
		VikRestaurants::translateRooms($rooms);

		// iterate all rooms tables
		foreach ($rooms as $i => $rm)
		{
			// prepare tables attributes
			foreach ($rm->tables as $k => $table)
			{
				$table->available = 0;
				// check if the table is contained within the available list
				for ($j = 0; $j < count($avail) && $table->available == 0; $j++)
				{
					$table->available = $table->id == $avail[$j]->id ? 1 : 0;
				}

				// set table occurrence, if exists
				if (isset($occurrences[$table->id]))
				{
					$table->occurrency = $occurrences[$table->id];
				}
				else
				{
					$table->occurrency = 0;
				}

				// update table in list
				$rooms[$i]->tables[$k] = $table;
			}
		}

		// room already selected
		$step = 1;

		if ($rooms && $avail)
		{
			if (!$selected_room_id)
			{
				// pre-select first room available in case
				// the request doesn't contain the room ID
				$selected_room_id = $avail[0]->id_room;

				// room not selected
				$step = 0;
			}
		}

		$selected_room = null;
		
		// make sure the selected room exists
		foreach ($rooms as $rm)
		{
			if ($rm->id == $selected_room_id)
			{
				// room found, assign object
				$selected_room = $rm;
			}
		}

		if ($avail && !$selected_room)
		{
			// throw exception in case the room was not found
			throw new Exception('Room not found', 404);
		}
		
		$menus = [];

		// check if the customers are allowed to choose menu
		if (VikRestaurants::isMenusChoosable($args))
		{
			// Get menus available for the selected date and time.
			// Obtain only the menus that can effectively be chosen.
			$menus = VikRestaurants::getAllAvailableMenusOn($args, $choosable = true);
		}

		// translate menus in case multi-lingual is supported
		VikRestaurants::translateMenus($menus);

		$available_rooms = [];

		// fetch all the rooms that own at least a table available
		foreach ($avail as $table)
		{
			if (!in_array($table->id_room, $available_rooms))
			{
				$available_rooms[] = $table->id_room;
			}
		}

		/**
		 * An associative array containing the check-in details,
		 * such as: date, hourmin and people.
		 * 
		 * @var array
		 */
		$this->args = $args;

		/**
		 * A list of tables available for the selected check-in.
		 *
		 * @var array
		 */
		$this->avail = $avail;

		/**
		 * A list of suggested times close to the selected check-in.
		 * By default, the first 2 are before the selected time, the
		 * other ones are after the selected time.
		 *
		 * @var array|null
		 */
		$this->hints = $hints;

		/**
		 * The time object for the selected check-in time.
		 *
		 * @var object
		 */
		$this->checkinTime = $timeslot;

		/**
		 * The search attempt identifier.
		 * - 1: a standard table is available
		 * - 2: only shared tables are available
		 * - 3: no available tables
		 *
		 * @var integer
		 */
		$this->attempt = $attempt;

		/**
		 * The current step of the search process.
		 * - 0: click button to display available rooms;
		 * - 1: rooms already selected, scroll down to tables.
		 *
		 * @var integer
		 */
		$this->step = $step;

		/**
		 * The selected room object.
		 *
		 * @var object|null
		 */
		$this->selectedRoom = $selected_room;

		/**
		 * A list of published rooms.
		 * Each room contains its own tables.
		 *
		 * @var array
		 */
		$this->rooms = $rooms;

		/**
		 * A lookup containing the total count of guests (value)
		 * for each table (key).
		 *
		 * @var array
		 */
		$this->occurrences = $occurrences;

		/**
		 * A list of menus that can be chosen by the customers
		 * during the booking process, if any.
		 *
		 * @var array
		 */
		$this->menus = $menus;

		/**
		 * All the rooms that contain at least an available table.
		 * Moved from "default_room.php" template file.
		 * 
		 * @var int[]
		 * @since 1.9
		 */
		$this->availableRooms = $available_rooms;

		/**
		 * The current menu item ID.
		 * 
		 * @var int|null
		 * @since 1.9
		 */
		$this->itemid = $app->input->get('Itemid', null, 'uint');

		/**
		 * Evaluate whether this page needs an interaction with the user.
		 * Otherwise auto-redirect to the next page.
		 * 
		 * Ignore if we are coming back from the third step.
		 * 
		 * @since 1.9
		 */
		if ($app->input->getBool('back', false) === false)
		{
			$this->tryAutoRedirect();
		}

		// prepare page content
		VikRestaurants::prepareContent($this);
		
		// display the template
		parent::display($tpl);
	}

	/**
	 * Evaluates whether this page needs an interaction with the user.
	 * Otherwise auto-redirects to the next page.
	 * 
	 * @since 1.9
	 */
	protected function tryAutoRedirect()
	{
		if ($this->attempt == 3)
		{
			// no available tables, cannot go ahead
			return;
		}

		if ($this->menus)
		{
			// menu selection enabled, cannot skip this page
			return;
		}

		$reservationRequirements = VREFactory::getConfig()->getUint('reservationreq');

		if ($reservationRequirements === 0)
		{
			// table selection enabled, cannot skip this page
			return;
		}

		if ($reservationRequirements === 1 && count($this->availableRooms) > 1)
		{
			// multiple rooms found, cannot skip this page
			return;
		}

		// prepare landing page URL (do not specify the table ID to automatically pick a random one)
		$url = sprintf(
			'index.php?option=com_vikrestaurants&view=confirmres&date=%s&hourmin=%s&people=%d%s',
			$this->args['date'],
			$this->args['hourmin'],
			$this->args['people'],
			$this->itemid ? '&Itemid=' . $this->itemid : ''
		);
		
		// perform auto-redirect
		JFactory::getApplication()->redirect(JRoute::rewrite($url, false));
	}
}
