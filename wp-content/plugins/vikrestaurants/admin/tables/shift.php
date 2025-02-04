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
 * VikRestaurants working shift table.
 *
 * @since 1.8
 */
class VRETableShift extends JTableVRE
{
	/**
	 * Class constructor.
	 *
	 * @param 	object 	$db  The database driver instance.
	 */
	public function __construct($db)
	{
		parent::__construct('#__vikrestaurants_shifts', 'id', $db);

		// register required fields
		$this->_requiredFields[] = 'group';
		$this->_requiredFields[] = 'name';
		$this->_requiredFields[] = 'from';
		$this->_requiredFields[] = 'to';
	}

	/**
	 * Method to bind an associative array or object to the Table instance. This
	 * method only binds properties that are publicly accessible and optionally
	 * takes an array of properties to ignore when binding.
	 *
	 * @param   array|object  $src     An associative array or object to bind to the Table instance.
	 * @param   array|string  $ignore  An optional array or space separated list of properties to ignore while binding.
	 *
	 * @return  boolean  True on success.
	 */
	public function bind($src, $ignore = array())
	{
		$src = (array) $src;

		if (isset($src['minfrom']))
		{
			// make sure the value is between [0-59]
			$src['minfrom'] = $src['minfrom'] % 60;

			/**
			 * Do not restrict the steps according to
			 * the configuration of the minutes intervals.
			 *
			 * @since 1.8
			 */

			// fetch opening time in seconds
			$src['from'] = $src['from'] * 60 + $src['minfrom'];

			unset($src['minfrom']);
		}

		if (isset($src['minto']))
		{
			// make sure the value is between [0-59]
			$src['minto'] = $src['minto'] % 60;

			/**
			 * Do not restrict the steps according to
			 * the configuration of the minutes intervals.
			 *
			 * @since 1.8
			 */

			// fetch closing time in seconds
			$src['to'] = $src['to'] * 60 + $src['minto'];

			unset($src['minto']);
		}

		/**
		 * Normalize selected days of the week.
		 *
		 * @since 1.8.3
		 */
		if (isset($src['days']))
		{
			// back to array in case of stringified days
			if (is_string($src['days']))
			{
				$src['days'] = preg_split("/\s*,\s*/", $src['days']);
			}

			// compare full week array with selected days
			if (!array_diff(range(0, 6), $src['days']))
			{
				// in case of no differences, use an empty list
				$src['days'] = [];
			}

			// stringify days
			$src['days'] = implode(',', $src['days']);
		}

		// bind the details before save
		return parent::bind($src, $ignore);
	}

	/**
	 * Method to perform sanity checks on the Table instance properties to
	 * ensure they are safe to store in the database.
	 *
	 * @return  boolean  True if the instance is sane and able to be stored in the database.
	 */
	public function check()
	{
		// check integrity using parent
		if (!parent::check())
		{
			return false;
		}

		if (isset($this->from) || isset($this->to))
		{
			// check opening time integrity
			if ($this->from < 0 || $this->from >= 1440)
			{
				// register error message
				$this->setError(JText::sprintf('VRE_INVALID_REQ_FIELD', JText::translate('VRMANAGESHIFT2')));

				// the opening time is not between 0:00 and 23:59
				return false;
			}

			// check closing time integrity
			if ($this->to < 0 || $this->to >= 1440)
			{
				// register error message
				$this->setError(JText::sprintf('VRE_INVALID_REQ_FIELD', JText::translate('VRMANAGESHIFT3')));

				// the closing time is not between 0:00 and 23:59
				return false;
			}
			
			// check shift from/to hours
			if ($this->from > $this->to)
			{
				// register error message
				$this->setError(JText::sprintf('VRE_INVALID_REQ_FIELD', JText::translate('VRMANAGESHIFT2')));

				// the opening time is equals or higher than the closing time
				return false;
			}
		}

		return true;
	}

	/**
	 * Helper method used to store the user data within the session.
	 *
	 * @param 	mixed 	$data  The array data to store.
	 *
	 * @return 	self    This object to support chaining.
	 * 
	 * @since   1.9
	 */
	public function setUserStateData($data = null)
	{
		if ($data)
		{
			$data = (array) $data;

			if (isset($data['minfrom']))
			{
				$data['from'] = $data['from'] * 60 + $data['minfrom'];
			}

			if (isset($data['minto']))
			{
				$data['to'] = $data['to'] * 60 + $data['minto'];
			}
		}

		return parent::setUserStateData($data);
	}
}
