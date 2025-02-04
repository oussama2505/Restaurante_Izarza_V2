<?php
/** 
 * @package     VikRestaurants
 * @subpackage  core
 * @author      E4J s.r.l.
 * @copyright   Copyright (C) 2023 E4J s.r.l. All Rights Reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @link        https://vikwp.com
 */

namespace E4J\VikRestaurants\Update\Adapters;

// No direct access
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Update adapter for com_vikrestaurants 1.8.5 version.
 *
 * NOTE. do not call exit() or die() because the update won't be finalised correctly.
 * Return false instead to stop in anytime the flow without errors.
 *
 * @since 1.8.5
 * @since 1.9    Renamed from VikRestaurantsUpdateAdapter1_8_5
 */
abstract class UpdateAdapter1_8_5
{
	/**
	 * Method run during update process.
	 *
	 * @param   object  $parent  The parent that calls this method.
	 *
	 * @return  bool    True on success, otherwise false to stop the flow.
	 */
	public static function update($parent)
	{
		return true;
	}

	/**
	 * Method run during postflight process.
	 *
	 * @param   object  $parent  The parent that calls this method.
	 *
	 * @return  bool    True on success, otherwise false to stop the flow.
	 */
	public static function finalise($parent)
	{
		return true;
	}

	/**
	 * Method run before executing VikRestaurants for the first time
	 * after the update completion.
	 *
	 * @param   object  $parent  The parent that calls this method.
	 *
	 * @return 	bool    True on success, otherwise false to stop the flow.
	 */
	public static function afterupdate($parent)
	{
		// update BC version to the current one before executing the process,
		// so that in case of errors it won't be executed anymore
		\VREFactory::getConfig()->set('bcv', '1.8.5');

		self::upgradeFontAwesomeIcons();
		self::migrateTakeAwayOrigins();

		return true;
	}

	/**
	 * Adjusts the icons of the payments.
	 *
	 * @return  void
	 */
	protected static function upgradeFontAwesomeIcons()
	{
		// create lookup to assign the correct icon
		$lookup = [
			'paypal'          => 'fab fa-paypal',
			'credit-card'     => 'far fa-credit-card',
			'credit-card-alt' => 'fas fa-credit-card',
			'cc-visa'         => 'fab fa-cc-visa',
			'cc-mastercard'   => 'fab fa-cc-mastercard',
			'cc-amex'         => 'fab fa-cc-amex',
			'cc-discover'     => 'fab fa-cc-discover',
			'cc-jcb'          => 'fab fa-cc-jcb',
			'cc-diners-club'  => 'fab fa-cc-diners-club',
			'cc-stripe'       => 'fab fa-cc-stripe',
			'eur'             => 'fas fa-euro-sign',
			'usd'             => 'fas fa-dollar-sign',
			'gbp'             => 'fas fa-pound-sign',
			'money'           => 'fas fa-money-bill',
		];

		$db = \JFactory::getDbo();

		// fetch all the payments that own a FontAwesome icon
		$q = $db->getQuery(true)
			->select($db->qn(['id', 'icon']))
			->from($db->qn('#__vikrestaurants_gpayments'))
			->where($db->qn('icon') . ' <> ' . $db->q(''))
			->where($db->qn('icontype') . ' = 1');

		$db->setQuery($q);
		
		foreach ($db->loadObjectList() as $p)
		{
			// make sure the icon is supported
			if (!isset($lookup[$p->icon]))
			{
				continue;
			}

			// assign the new icon
			$p->icon = $lookup[$p->icon];
			// finalise the update
			$db->updateObject('#__vikrestaurants_gpayments', $p, 'id');
		}
	}

	/**
	 * Helper method used to move the existing take-away origins
	 * from the configuration into the apposite database table.
	 * 
	 * @return  void
	 */
	protected static function migrateTakeAwayOrigins()
	{
		$config = \VREFactory::getConfig();

		// load the list of existing addresses
		$addresses = $config->getArray('tkaddrorigins', []);

		if (!$addresses)
		{
			return;
		}

		$model = \JModelVRE::getInstance('origin');

		// init HTTP transport to fetch the latitude and longitude of the addresses
		$http = new \JHttp();

		$notices = [];

		$restname = $config->get('restname');

		if (!$restname)
		{
			// missing company name, use a default text to avoid saving
			// failures due to an empty name of the first record
			$restname = \JText::translate('VRMENUTITLEHEADER1');
		}

		foreach ($addresses as $i => $addr)
		{
			// build save data
			$data = [
				'id'        => 0,
				'name'      => $restname . ($i > 0 ? ' #' . ($i + 1) : ''),
				'address'   => $addr,
				'published' => 1,
			];

			// make sure the Google API Key is set
			$apiKey = $config->get('googleapikey');

			if ($apiKey)
			{
				// prepare validation URL
				$uri = new \JUri('https://maps.google.com/maps/api/geocode/json');

				// enter the address
				$uri->setVar('address', urlencode($addr));

				// register Google API Key
				$uri->setVar('key', $apiKey);

				// make geocoding request
				$response = $http->get($uri);

				if ($response->code == 200)
				{
					// extract JSON from body
					$body = json_decode($response->body);

					// make sure the request was successful
					if (isset($body->status) && $body->status === 'OK')
					{
						// inject latitude and longitude into the save data
						$data['latitude']  = $body->results[0]->geometry->location->lat;
			    		$data['longitude'] = $body->results[0]->geometry->location->lng;
					}
				}
			}

			if (!isset($data['latitude']))
			{
				// unable to fetch the coordinates, register notice
				$notices[] = $data['address'];
			}

			// save location as a new record
			$model->save($data);
		}

		if ($notices)
		{
			// create LI elements
			$ul = implode("\n", array_map(function($addr)
			{
				return '<li>' . $addr . '</li>';
			}, $notices));

			// display warning message
			\JFactory::getApplication()->enqueueMessage(sprintf(
				'<p>It was not possible to fetch the coordinates for the following addresses:</p><ul>%s</ul><p>Please click <a href="%s">HERE</a> to complete the configuration by specifying the latitude and longitude for your addresses.</p>',
				$ul,
				'index.php?option=com_vikrestaurants&view=origins'
			), 'warning');
		}
	}
}
