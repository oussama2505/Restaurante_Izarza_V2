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
 * VikRestaurants take-away order product topping table.
 *
 * @since 1.8
 */
class VRETableTkresprodtopping extends JTableVRE
{
	/**
	 * Class constructor.
	 *
	 * @param 	object 	$db  The database driver instance.
	 */
	public function __construct($db)
	{
		parent::__construct('#__vikrestaurants_takeaway_res_prod_topping_assoc', 'id', $db);

		// register required fields
		$this->_requiredFields[] = 'id_assoc';
		$this->_requiredFields[] = 'id_group';
		$this->_requiredFields[] = 'id_topping';
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
	 *
	 * @since 	1.8.2
	 */
	public function bind($src, $ignore = array())
	{
		$src = (array) $src;

		// check if the units have been specified
		if (isset($src['units']))
		{
			// then make sure we are not going to use a value lower than 1
			$src['units'] = max(1, (int) $src['units']);
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

		if (isset($this->id_group) || isset($this->id_topping))
		{
			$dbo = JFactory::getDbo();

			$q = $dbo->getQuery(true)
				->select(1)
				->from($dbo->qn('#__vikrestaurants_takeaway_group_topping_assoc'))
				->where($dbo->qn('id_group') . ' = ' . $this->id_group)
				->where($dbo->qn('id_topping') . ' = ' . $this->id_topping);
			
			$dbo->setQuery($q, 0, 1);
			$dbo->execute();

			// make sure the topping exists and belong to the selected group
			if ($dbo->getNumRows() == 0)
			{
				// register error message
				$this->setError(JText::translate('VRTKCARTROWNOTFOUND'));

				// invalid topping group
				return false;
			}
		}

		return true;
	}
}
