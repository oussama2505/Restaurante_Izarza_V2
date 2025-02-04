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
 * Widget class used to calculate either the total count of
 * new and returning customers within the specified month.
 *
 * Displays a DOUGHNUT chart.
 *
 * @since 1.8
 */
class VREStatisticsWidgetCustomers extends VREStatisticsWidget
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
			 * The month to fetch.
			 *
			 * The parameter is VOLATILE because, every time the session
			 * ends, we need to restore the field to an empty value, just
			 * to obtain the current date.
			 *
			 * @var select
			 */
			'month' => array(
				'type'     => 'select',
				'label'    => JText::translate('VRE_STATS_WIDGET_ROG_MONTH_FIELD'),
				'default'  => date('n'),
				'volatile' => true,
				'options'  => JHtml::fetch('vikrestaurants.months'),
			),

			/**
			 * The year to which the selected month belongs.
			 *
			 * The parameter is VOLATILE because, every time the session
			 * ends, we need to restore the field to an empty value, just
			 * to obtain the current date.
			 *
			 * @var select
			 */
			'year' => array(
				'type'     => 'select',
				'label'    => JText::translate('VRE_STATS_WIDGET_ROG_YEAR_FIELD'),
				'default'  => date('Y'),
				'volatile' => true,
				'options'  => JHtml::fetch('vikrestaurants.years', -10, 0),
			),

			/**
			 * The color to be used when displaying the RETURNING CUSTOMERS arc.
			 * By default, a yellow color will be used.
			 *
			 * @var color
			 */
			'retcolor' => array(
				'type'    => 'color',
				'label'   => JText::translate('VRE_STATS_WIDGET_CUSTOMERS_RETURNING'),
				'default' => 'ffd635',
			),

			/**
			 * The color to be used when displaying the NEW CUSTOMERS arc.
			 * By default, a blue color will be used.
			 *
			 * @var color
			 */
			'newcolor' => array(
				'type'    => 'color',
				'label'   => JText::translate('VRE_STATS_WIDGET_CUSTOMERS_NEW'),
				'default' => '1c81ea',
			),
		);
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
		$dbo = JFactory::getDbo();

		// get date from request
		$filters = array();
		$filters['month'] = $this->getOption('month');
		$filters['year']  = $this->getOption('year');

		// create timestamp delimiters
		$start_ts = mktime(0, 0, 0, $filters['month'], 1, $filters['year']);
		$end_ts   = mktime(0, 0, 0, $filters['month'] + 1, 1, $filters['year']) - 1;

		$dt = new JDate();

		// prepare return data
		$data = array(
			'month' => $dt->monthToString($filters['month'], true),
			'year'  => $filters['year'],
		);

		// build query
		$q = $dbo->getQuery(true);

		// fetches all the NEW customers
		$q->select('MIN(' . $dbo->qn('r.created_on') . ') AS ' . $dbo->qn('date'));
		$q->select($dbo->qn('r.id_user'));

		if ($this->isGroup('restaurant'))
		{
			// load restaurant reservations
			$q->from($dbo->qn('#__vikrestaurants_reservation', 'r'));

			// exclude closures
			$q->where($dbo->qn('r.closure') . ' = 0');
			// exclude children reservations
			$q->where($dbo->qn('r.id_parent') . ' <= 0');

			// take all the approved statuses
			$approved = JHtml::fetch('vrehtml.status.find', 'code', ['restaurant' => 1, 'approved' => 1]);
		}
		else
		{
			// load take-away orders
			$q->from($dbo->qn('#__vikrestaurants_takeaway_reservation', 'r'));

			// take all the approved statuses
			$approved = JHtml::fetch('vrehtml.status.find', 'code', ['takeaway' => 1, 'approved' => 1]);
		}

		if ($approved)
		{
			// filter reservations/orders by status
			$q->where($dbo->qn('r.status') . ' IN (' . implode(',', array_map([$dbo, 'q'], $approved)) . ')');
		}

		// ignore guests
		$q->where($dbo->qn('r.id_user') . ' > 0');
		
		// group by customer ID
		$q->group($dbo->qn('r.id_user'));

		// take records included within the specified month
		$q->having($dbo->qn('date') . ' BETWEEN ' . $start_ts . ' AND ' . $end_ts);

		// count the customers returned by the query
		$dbo->setQuery(
			$dbo->getQuery(true)
				->select('COUNT(1)')
				->from('(' . $q . ') AS ' . $dbo->qn('c'))
		);

		// register new customers
		$data['new'] = (int) $dbo->loadResult();

		// build query
		$q = $dbo->getQuery(true);

		// fetches all the customers
		$q->select($dbo->qn('r.id_user'));

		if ($this->isGroup('restaurant'))
		{
			// load restaurant reservations
			$q->from($dbo->qn('#__vikrestaurants_reservation', 'r'));

			// exclude closures
			$q->where($dbo->qn('r.closure') . ' = 0');
			// exclude children reservations
			$q->where($dbo->qn('r.id_parent') . ' <= 0');
		}
		else
		{
			// load take-away orders
			$q->from($dbo->qn('#__vikrestaurants_takeaway_reservation', 'r'));
		}

		if ($approved)
		{
			// filter reservations/orders by status
			$q->where($dbo->qn('r.status') . ' IN (' . implode(',', array_map([$dbo, 'q'], $approved)) . ')');
		}

		// ignore guests
		$q->where($dbo->qn('r.id_user') . ' > 0');
		// take records included within the specified month
		$q->where($dbo->qn('r.created_on') . ' BETWEEN ' . $start_ts . ' AND ' . $end_ts);
		
		// group by customer ID
		$q->group($dbo->qn('r.id_user'));

		// count the customers returned by the query
		$dbo->setQuery(
			$dbo->getQuery(true)
				->select('COUNT(1)')
				->from('(' . $q . ') AS ' . $dbo->qn('c'))
		);

		// subtract the NEW customers from the total count
		// to obtain the RETURNING customers
		$data['returning'] = (int) $dbo->loadResult() - $data['new'];

		return $data;
	}
}
