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
 * Widget class used to fetch a list of reservations.
 * The widgets supports the following lists:
 * - latest
 * - incoming
 * - current
 *
 * Displays a table of reservations.
 *
 * @since 1.8
 */
class VREStatisticsWidgetReservations extends VREStatisticsWidget
{
	/**
	 * @override
	 * Returns the form parameters required to the widget.
	 *
	 * @return 	array
	 */
	public function getForm()
	{
		return array(
			/**
			 * The maximum number of items to load.
			 *
			 * @var select
			 */
			'items' => array(
				'type'     => 'select',
				'label'    => JText::translate('VRMANAGETKRES22'),
				'default'  => 10,
				'options'  => array(
					5,
					10,
					15,
					20,
					30,
					50,
				),
			),

			/**
			 * Flag used to check whether the latest table
			 * should be displayed or not.
			 *
			 * @var select
			 */
			'latest' => array(
				'type'    => 'checkbox',
				'label'   => JText::translate('VRE_STATS_WIDGET_RESERVATIONS_LATEST_FIELD'),
				'help'    => JText::translate('VRE_STATS_WIDGET_RESERVATIONS_LATEST_FIELD_HELP'),
				'default' => true, 
			),

			/**
			 * Flag used to check whether the incoming table
			 * should be displayed or not.
			 *
			 * @var select
			 */
			'incoming' => array(
				'type'    => 'checkbox',
				'label'   => JText::translate('VRE_STATS_WIDGET_RESERVATIONS_INCOMING_FIELD'),
				'help'    => JText::translate('VRE_STATS_WIDGET_RESERVATIONS_INCOMING_FIELD_HELP'),
				'default' => true, 
			),

			/**
			 * Flag used to check whether the current table
			 * should be displayed or not.
			 *
			 * @var select
			 */
			'current' => array(
				'type'    => 'checkbox',
				'label'   => JText::translate('VRE_STATS_WIDGET_RESERVATIONS_CURRENT_FIELD'),
				'help'    => JText::translate('VRE_STATS_WIDGET_RESERVATIONS_CURRENT_FIELD_HELP'),
				'default' => true, 
			),
		);
	}

	/**
	 * @override
	 * Checks whether the specified group is supported
	 * by the widget. Children classes can override this
	 * method to drop the support for a specific group.
	 *
	 * This widget supports only the "restaurant" group.
	 *
	 * @param 	string 	 $group  The group to check.
	 *
	 * @return 	boolean  True if supported, false otherwise.
	 */
	public function isSupported($group)
	{
		return $group == 'restaurant' ? true : false;
	}

	/**
	 * @override
	 * Loads the dataset(s) that will be recovered asynchronously
	 * for being displayed within the widget.
	 *
	 * It is possible to return an array of records to be passed
	 * to a chart or directly the HTML to replace.
	 *
	 * @return 	mixed
	 */
	public function getData()
	{
		$dbo    = JFactory::getDbo();
		$config = VREFactory::getConfig();

		// get number of items to display
		$limit = $this->getOption('items', 10);

		// get average time of stay
		$avg = VREFactory::getConfig()->getUint('averagetimestay');
		$now = VikRestaurants::now();

		$data = array();

		// if we are in the front-end, make sure the
		// user is an operator (throws exception)
		if (JFactory::getApplication()->isClient('site'))
		{
			// import operator user helper
			VRELoader::import('library.operator.user');
			// Load operator details. In case the user is
			// not an operator, an exception will be thrown
			$operator = VREOperatorUser::getInstance();
		}
		else
		{
			$operator = null;
		}

		// check if we should fetch the latest reservations
		if ($this->getOption('latest'))
		{
			$q = $dbo->getQuery(true)
				->select($dbo->qn('r.id'))
				->from($dbo->qn('#__vikrestaurants_reservation', 'r'))
				->where($dbo->qn('r.closure') . ' = 0')
				->where($dbo->qn('r.id_parent') . ' <= 0')
				->order($dbo->qn('r.id') . ' DESC');

			// apply restrictions depending on the current operator
			$this->applyOperatorRestrictions($q, $operator);

			$dbo->setQuery($q, 0, $limit);
			$data['latest'] = $dbo->loadColumn();
		}

		// check if we should fetch the incoming reservations
		if ($this->getOption('incoming'))
		{
			$q = $dbo->getQuery(true)
				->select('r.*')
				->from($dbo->qn('#__vikrestaurants_reservation', 'r'))
				->where($dbo->qn('r.closure') . ' = 0')
				->where($dbo->qn('r.id_parent') . ' <= 0')
				->where($dbo->qn('r.checkin_ts') . ' > ' . $now)
				/**
				 * Exclude all the reservations that have been flagged as arrived, which should
				 * rather be displayed within the "Current" tab.
				 * 
				 * @since 1.9
				 */
				->where('(' . $dbo->qn('r.arrived') . ' <> 1 OR ' . $dbo->qn('r.arrived') . ' IS NULL)')
				->order($dbo->qn('r.checkin_ts') . ' ASC');

			// take all the reserved statuses
			$reserved = JHtml::fetch('vrehtml.status.find', 'code', ['restaurant' => 1, 'reserved' => 1]);

			if ($reserved)
			{
				// filter reservations by status
				$q->where($dbo->qn('r.status') . ' IN (' . implode(',', array_map([$dbo, 'q'], $reserved)) . ')');
			}

			// apply restrictions depending on the current operator
			$this->applyOperatorRestrictions($q, $operator);

			$dbo->setQuery($q, 0, $limit);
			$data['incoming'] = $dbo->loadColumn();
		}

		// check if we should fetch the current reservations
		if ($this->getOption('current'))
		{
			$q = $dbo->getQuery(true)
				->select('r.*')
				->from($dbo->qn('#__vikrestaurants_reservation', 'r'))
				/**
				 * Take all the reservations with check-in in the future but that have been flagged as arrived.
				 * 
				 * @since 1.9
				 */
				->where($dbo->qn('r.checkin_ts') . ' <= ' . $now)
				->orWhere([
					$dbo->qn('r.checkin_ts') . ' > ' . $now,
					$dbo->qn('r.arrived') . ' = 1',
				], 'AND')
				->andWhere([
					sprintf(
						'(%1$s + IF(%2$s > 0, %2$s, %3$d) * 60) > %4$s',
						$dbo->qn('r.checkin_ts'),
						$dbo->qn('r.stay_time'),
						$avg,
						$now
					),
					$dbo->qn('r.closure') . ' = 0',
					$dbo->qn('r.id_parent') . ' <= 0',
				], 'AND')
				->order($dbo->qn('r.checkin_ts') . ' ASC');

			// take all the approved statuses
			$approved = JHtml::fetch('vrehtml.status.find', 'code', ['restaurant' => 1, 'approved' => 1]);

			if ($approved)
			{
				// filter reservations by status
				$q->where($dbo->qn('r.status') . ' IN (' . implode(',', array_map([$dbo, 'q'], $approved)) . ')');
			}

			// apply restrictions depending on the current operator
			$this->applyOperatorRestrictions($q, $operator);

			$dbo->setQuery($q, 0, $limit);
			$data['current'] = $dbo->loadColumn();
		}

		// get current language tag
		$langtag = JFactory::getLanguage()->getTag();

		foreach ($data as $k => $ids)
		{
			$list = array();

			// iterate all IDs
			foreach ($ids as $id)
			{
				// Load reservation.
				// If the same reservation was already loaded,
				// the cached record will be used.
				$res = VREOrderFactory::getReservation($id, $langtag);

				// push reservation in list
				$list[] = $res;
			}

			// define args for layout file
			$args = array(
				'reservations' => $list,
				'widget'       => $this,
			);

			// replace reservations list with HTML layout
			$data[$k] = JLayoutHelper::render('statistics.widgets.reservations.' . $k, $args);
		}

		return $data;
	}

	/**
	 * Applies any restrictions to avoid accessing reservations that
	 * shouldn't be seen by the specified operator.
	 *
	 * @param 	mixed 	&$query    The query builder.
	 * @param 	mixed 	$operator  The operator instance.
	 *
	 * @return 	void
	 */
	protected function applyOperatorRestrictions(&$query, $operator)
	{
		if (!$operator)
		{
			// not an operator, go ahead
			return;
		}

		$dbo = JFactory::getDbo();

		if ($operator->get('rooms'))
		{
			// join reservation tables
			$query->leftjoin($dbo->qn('#__vikrestaurants_table', 't') . ' ON ' . $dbo->qn('r.id_table') . ' = ' . $dbo->qn('t.id'));
			// take only the supported rooms (already comma-separated)
			$query->where($dbo->qn('t.id_room') . ' IN (' . $operator->get('rooms') . ')');
		}

		// check if the operator can see all the reservations
		if (!$operator->canSeeAll())
		{
			// check if the operator can self-assign reservations
			if ($operator->canAssign())
			{
				// retrieve reservations assigned to this operator and reservations
				// free of assignments
				$query->where($dbo->qn('r.id_operator') . ' IN (0, ' . (int) $operator->get('id') . ')');
			}
			else
			{
				// retrieve only the reservations assigned to the operator
				$query->where($dbo->qn('r.id_operator') . ' = ' . (int) $operator->get('id'));
			}
		}
	}
}
