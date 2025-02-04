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
 * Helper class used to find the differences between 2 orders.
 *
 * The order details must be retrieved by using the global
 * factory class called "VREOrderFactory".
 *
 * @since 1.8
 */
class VREOrderComparator
{
	/**
	 * Returns an array containing the differences between the
	 * specified orders.
	 *
	 * @param 	object  $curr  The current order details.
	 * @param 	object  $prev  The previous order details.
	 *
	 * @return 	mixed   An array of differences.
	 */
	public static function diff($curr, $prev)
	{
		if (!$prev || !$curr)
		{
			// unable to proceed, not enough data
			return [];
		}

		$config   = VREFactory::getConfig();
		$currency = VREFactory::getCurrency();

		// start fetching any differences
		$diff = [];

		// checkin date (at midnight)
		if (isset($curr->checkin_ts) && isset($prev->checkin_ts) && strtotime('00:00:00', $curr->checkin_ts) != strtotime('00:00:00', $prev->checkin_ts))
		{
			// the checkin date has changed, register it
			$diff['checkin_date'] = [
				'label' => 'VRMANAGERESERVATION13',
				'prev'  => date($config->get('dateformat'), $prev->checkin_ts),
				'curr'  => date($config->get('dateformat'), $curr->checkin_ts),
			];
		}

		// checkin time
		if (isset($curr->checkin_ts) && isset($prev->checkin_ts) && date($config->get('timeformat'), $curr->checkin_ts) != date($config->get('timeformat'), $prev->checkin_ts))
		{
			// the checkin time has changed, register it
			$diff['checkin_time'] = [
				'label' => 'VRMANAGERESERVATION14',
				'prev'  => date($config->get('timeformat'), $prev->checkin_ts),
				'curr'  => date($config->get('timeformat'), $curr->checkin_ts),
			];
		}

		// number of people (RESTAURANT ONLY)
		if (isset($curr->people) && isset($prev->people) && $curr->people != $prev->people)
		{
			// the number of people has changed, register it
			$diff['people'] = [
				'label' => 'VRMANAGERESERVATION4',
				'prev'  => $prev->people,
				'curr'  => $curr->people,
			];
		}

		// table (RESTAURANT ONLY)
		if (isset($curr->id_table) && isset($prev->id_table))
		{
			// obtain all the tables assigned to the previous reservation
			$prevTables = array_map(function($table)
			{
				return $table->name;
			}, $prev->tables);

			// obtain all the tables assigned to the current reservation
			$currTables = array_map(function($table)
			{
				return $table->name;
			}, $curr->tables);

			// sort the tables
			sort($prevTables);
			sort($currTables);

			if ($prevTables !== $currTables)
			{
				// the selected table has changed, register it
				$diff['table'] = [
					'label' => 'VRMANAGERESERVATION5',
					'prev'  => $prev->room_name . ' - ' . implode(', ', $prevTables),
					'curr'  => $curr->room_name . ' - ' . implode(', ', $currTables),
				];
			}
		}

		// purchaser nominative
		if (isset($curr->purchaser_nominative) && isset($prev->purchaser_nominative) && strcasecmp($curr->purchaser_nominative, $prev->purchaser_nominative))
		{
			// the purchaser nominative has changed, register it
			$diff['customer'] = [
				'label' => 'VRMANAGERESERVATION18',
				'prev'  => $prev->purchaser_nominative,
				'curr'  => $curr->purchaser_nominative,
			];
		}

		// purchaser e-mail
		if (isset($curr->purchaser_mail) && isset($prev->purchaser_mail) && strcasecmp($curr->purchaser_mail, $prev->purchaser_mail))
		{
			// the purchaser e-mail has changed, register it
			$diff['mail'] = [
				'label' => 'VRMANAGERESERVATION6',
				'prev'  => $prev->purchaser_mail,
				'curr'  => $curr->purchaser_mail,
			];
		}

		// purchaser phone number
		if (isset($curr->purchaser_phone) && isset($prev->purchaser_phone) && strcasecmp($curr->purchaser_phone, $prev->purchaser_phone))
		{
			// the purchaser e-mail has changed, register it
			$diff['phone'] = [
				'label' => 'VRMANAGERESERVATION16',
				'prev'  => $prev->purchaser_phone,
				'curr'  => $curr->purchaser_phone,
			];
		}

		// deposit amount (RESTAURANT ONLY)
		if (isset($curr->deposit) && isset($prev->deposit) && $curr->deposit != $prev->deposit)
		{
			// the deposit has changed, register it
			$diff['deposit'] = [
				'label' => 'VRMANAGERESERVATION9',
				'prev'  => $currency->format($prev->deposit),
				'curr'  => $currency->format($curr->deposit),
			];
		}

		// total bill (RESTAURANT ONLY)
		if (isset($curr->bill_value) && isset($prev->bill_value) && $curr->bill_value != $prev->bill_value)
		{
			// the bill value has changed, register it
			$diff['bill_value'] = [
				'label' => 'VRMANAGERESERVATION10',
				'prev'  => $currency->format($prev->bill_value),
				'curr'  => $currency->format($curr->bill_value),
			];
		}

		// total paid
		if (isset($curr->tot_paid) && isset($prev->tot_paid) && $curr->tot_paid != $prev->tot_paid)
		{
			// the total paid amount has changed, register it
			$diff['tot_paid'] = [
				'label' => 'VRORDERTOTPAID',
				'prev'  => $currency->format($prev->tot_paid),
				'curr'  => $currency->format($curr->tot_paid),
			];
		}

		// discount amount
		if (isset($curr->discount_val) && isset($prev->discount_val) && $curr->discount_val != $prev->discount_val)
		{
			// the discount amount has changed, register it
			$diff['discount_val'] = [
				'label' => 'VRDISCOUNT',
				'prev'  => $currency->format($prev->discount_val * -1),
				'curr'  => $currency->format($curr->discount_val * -1),
			];
		}

		// tip amount
		if (isset($curr->tip_amount) && isset($prev->tip_amount) && $curr->tip_amount != $prev->tip_amount)
		{
			// the tip amount has changed, register it
			$diff['tip_amount'] = [
				'label' => 'VRTIP',
				'prev'  => $currency->format($prev->tip_amount),
				'curr'  => $currency->format($curr->tip_amount),
			];
		}

		// payment charge
		if ((isset($curr->payment_charge) && isset($prev->payment_charge) && $curr->payment_charge != $prev->payment_charge)
			|| (isset($curr->payment_tax) && isset($prev->payment_tax) && $curr->payment_tax != $prev->payment_tax))
		{
			// the payment charge has changed, register it
			$diff['payment_charge'] = [
				'label' => 'VRINVPAYCHARGE',
				'prev'  => $currency->format($prev->payment_charge + $prev->payment_tax),
				'curr'  => $currency->format($curr->payment_charge + $curr->payment_tax),
			];
		}

		// bill closed (RESTAURANT ONLY)
		if (isset($curr->bill_closed) && isset($prev->bill_closed) && $curr->bill_closed != $prev->bill_closed)
		{
			// the bill status has changed, register it
			$diff['bill_closed'] = [
				'label' => 'VRMANAGERESERVATION11',
				'prev'  => JText::translate($prev->bill_closed ? 'JYES' : 'JNO'),
				'curr'  => JText::translate($curr->bill_closed ? 'JYES' : 'JNO'),
			];
		}

		// coupon code
		if (isset($curr->coupon_str) && isset($prev->coupon_str) && $curr->coupon_str != $prev->coupon_str)
		{
			if ($curr->coupon_str)
			{
				$curr->coupon = explode(';;', $curr->coupon_str);
				$curr->coupon = $curr->coupon[0] . ' : ' . ($curr->coupon[2] == 1 ? $curr->coupon[1] . '%' : $currency->format($curr->coupon[1]));
			}
			else
			{
				$curr->coupon = '--';
			}

			if ($prev->coupon_str)
			{
				$prev->coupon = explode(';;', $prev->coupon_str);
				$prev->coupon = $prev->coupon[0] . ' : ' . ($prev->coupon[2] == 1 ? $prev->coupon[1] . '%' : $currency->format($prev->coupon[1]));
			}
			else
			{
				$prev->coupon = '--';
			}

			// the coupon code has changed, register it
			$diff['coupon'] = [
				'label' => 'VRMANAGERESERVATION8',
				'prev'  => $prev->coupon,
				'curr'  => $curr->coupon,
			];
		}

		// status
		if (isset($curr->status) && isset($prev->status) && $curr->status != $prev->status)
		{
			// the status has changed, register it
			$diff['status'] = [
				'label' => 'VRMANAGERESERVATION12',
				'prev'  => JHtml::fetch('vrehtml.status.display', $prev->status),
				'curr'  => JHtml::fetch('vrehtml.status.display', $curr->status),
			];
		}

		// payment
		if (isset($curr->id_payment) && isset($prev->id_payment) && $curr->id_payment != $prev->id_payment)
		{
			// the selected payment has changed, register it
			$diff['payment'] = [
				'label' => 'VRMANAGERESERVATION20',
				'prev'  => $prev->payment_name,
				'curr'  => $curr->payment_name,
			];
		}

		// reservation code
		if (isset($curr->rescode) && isset($prev->rescode) && $curr->rescode != $prev->rescode)
		{
			// the selected reservation code has changed, register it
			$diff['rescode'] = [
				'label' => 'VRMANAGERESCODE2',
			];

			if ($prev->rescode)
			{
				if ($prev->code_icon)
				{
					$diff['rescode']['prev'] = '<img src="' . VREMEDIA_SMALL_URI . $prev->code_icon . '" /> ' . $prev->status_code;
				}
				else
				{
					$diff['rescode']['prev'] = $prev->status_code;
				}
			}
			else
			{
				$diff['rescode']['prev'] = '--';
			}

			if ($curr->rescode)
			{
				if ($curr->code_icon)
				{
					$diff['rescode']['curr'] = '<img src="' . VREMEDIA_SMALL_URI . $curr->code_icon . '" /> ' . $curr->status_code;
				}
				else
				{
					$diff['rescode']['curr'] = $curr->status_code;
				}
			}
			else
			{
				$diff['rescode']['curr'] = '--';
			}
		}

		// notes
		if (isset($curr->notes) && isset($prev->notes))
		{
			$prev_notes = strip_tags($prev->notes);
			$curr_notes = strip_tags($curr->notes);

			// notes
			if (strcasecmp($curr_notes, $prev_notes))
			{
				// the reservation notes have changed, register it
				$diff['notes'] = [
					'label' => 'VRMANAGERESERVATIONTITLE3',
					'prev'  => $prev_notes,
					'curr'  => $curr_notes,
				];
			}
		}

		// operator
		if (isset($curr->id_operator) && isset($prev->id_operator) && $curr->id_operator != $prev->id_operator)
		{
			/** @var JModelLegacy */
			$operatorModel = JModelVRE::getInstance('operator');

			// get details of the previous and current operator
			$prevOperator = $operatorModel->getItem($prev->id_operator);
			$currOperator = $operatorModel->getItem($curr->id_operator);

			// the assigned operator has changed, register it
			$diff['operator'] = [
				'label' => 'VROPERATORFIELDSET1',
				'prev'  => $prevOperator ? trim($prevOperator->firstname . ' ' . $prevOperator->lastname) : '--',
				'curr'  => $currOperator ? trim($currOperator->firstname . ' ' . $currOperator->lastname) : '--',
			];
		}

		return $diff;
	}

	/**
	 * Returns an array containing the differences between the
	 * items of the specified orders.
	 *
	 * @param 	object  $curr  The current order details.
	 * @param 	object  $prev  The previous order details.
	 *
	 * @return 	mixed   An array of differences.
	 */
	public static function diffItems($curr, $prev)
	{
		if (!$prev || !$curr)
		{
			// unable to proceed, not enough data
			return [];
		}

		$data = [];

		// fetch added items
		foreach ($curr->items as $item)
		{
			// check if the previous order already contained the item
			if (!isset($prev->items[$item->id]))
			{
				// missing item, it has been added
				if (!isset($data['insert']))
				{
					$data['insert'] = [];
				}

				$data['insert'][] = $item;
			}
		}

		// fetch deleted items
		foreach ($prev->items as $item)
		{
			// check if the current order still contains the item
			if (!isset($curr->items[$item->id]))
			{
				// missing item, it has been deleted
				if (!isset($data['delete']))
				{
					$data['delete'] = [];
				}

				$data['delete'][] = $item;
			}
		}

		// fetch updated items
		foreach ($curr->items as $id => $curr_item)
		{
			if (isset($prev->items[$id]))
			{
				// get previous item
				$prev_item = $prev->items[$id];

				// search differences between the items
				$diff = static::_diffItems($curr_item, $prev_item);

				if ($diff)
				{
					// the items are different
					if (!isset($data['update']))
					{
						$data['update'] = [];
					}

					// push previous item and current item in "update" list
					$data['update'][] = [
						$prev_item,
						$curr_item,
					];
				}
			}
		}

		return $data;
	}

	/**
	 * Check if the specified items are different.
	 *
	 * @param 	object   $curr  The current item details.
	 * @param 	object   $prev  The previous item details.
	 *
	 * @return 	boolean  True if different, false otherwise.
	 */
	protected static function _diffItems($curr, $prev)
	{
		// iterate item properties
		foreach ($curr as $k => $v)
		{
			// skip properties that starts with "id_", make sure 
			// the previous item owns the property and check if
			// they doesn't share the same value
			if (!preg_match("/^id_?/", $k) && isset($prev->{$k}) && $v != $prev->{$k})
			{
				// the items are not equals
				return true;
			}
		}

		return false;
	}
}
