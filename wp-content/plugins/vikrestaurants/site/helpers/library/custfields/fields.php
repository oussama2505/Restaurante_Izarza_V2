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
 * VikRestaurants custom fields class handler.
 *
 * @since  	1.7
 * @deprecated 1.10 Rely on the customfields libraries.
 */
abstract class VRCustomFields
{
	/**
	 * The default country code in case it is not specified.
	 *
	 * @var string
	 * 
	 * @deprecated 1.10 Use E4J\VikRestaurants\CustomFields\Helpers\FieldsHelper::$defaultCountry instead.
	 */
	public static $defaultCountry = 'US';

	/**
	 * Flag used to check whether the delivery service is requested.
	 *
	 * @var   boolean
	 * @since 1.8
	 * @deprecated 1.10 Use E4J\VikRestaurants\CustomFields\FieldService instead.
	 */
	public static $deliveryService = false;

	/**
	 * Return the list of the custom fields for the specified section.
	 *
	 * @param 	integer  $group  The section of the program: 0 for Restaurant, 1 for Take-Away.
	 * 							 If not specified, all the fields will be returned.
	 * @param 	integer  $flag 	 A mask to filter the custom fields.
	 *
	 * @return 	array 	 The list of custom fields.
	 * 
	 * @deprecated 1.10 Use E4J\VikRestaurants\CustomFields\FieldsCollection instead.
	 */
	public static function getList($group = null, $flag = 0)
	{
		$collection = E4J\VikRestaurants\CustomFields\FieldsCollection::getInstance();

		if ($group === static::GROUP_RESTAURANT)
		{
			$group = new E4J\VikRestaurants\CustomFields\Filters\RestaurantGroupFilter;
		}
		else if ($group === static::GROUP_TAKEAWAY)
		{
			$group = new E4J\VikRestaurants\CustomFields\Filters\TakeAwayGroupFilter;
		}

		if ($group)
		{
			$collection = $collection->filter($group);
		}

		if ($flag & static::FILTER_EXCLUDE_SEPARATOR)
		{
			$collection = $collection->filter(new E4J\VikRestaurants\CustomFields\Filters\SeparatorFilter($exclude = true));
		}

		if ($flag & static::FILTER_EXCLUDE_REQUIRED_CHECKBOX)
		{
			$collection = $collection->filter(new E4J\VikRestaurants\CustomFields\Filters\RequiredCheckboxFilter($exclude = true));
		}

		return $collection;
	}

	/**
	 * Return the default country code assigned to the phone number custom field.
	 *
	 * @param 	string 	$langtag 	The langtag to retrieve the proper country 
	 * 								depending on the current language.
	 * @param 	mixed 	$default 	The default return value in case of unsupported
	 * 								
	 *
	 * @return 	string 	The default country code.
	 * 
	 * @deprecated 1.10 Use E4J\VikRestaurants\CustomFields\Helpers\FieldsHelper::getDefaultCountryCode() instead.
	 */
	public static function getDefaultCountryCode($langtag = null, $default = true)
	{
		return E4J\VikRestaurants\CustomFields\Helpers\FieldsHelper::getDefaultCountryCode($langtag, $default);
	}

	/**
	 * Translates the specified custom fields.
	 * The translation of the name will be placed in a different column 'langname'. 
	 * The original 'name' column won't be altered.
	 *
	 * @param 	array 	$fields  The records to translate.
	 *
	 * @return 	void
	 *
	 * @since 	1.8
	 * @deprecated 1.10 Without replacement
	 */
	public static function translate(&$fields, $tag = null)
	{
		// the fields are always translated by default
	}

	/**
	 * Translates the specified custom fields array data.
	 *
	 * @param 	array 	$data 	 The associative array with the CF data.
	 * @param 	array 	$fields  The custom fields (MUST BE already translated).
	 *
	 * @return 	array 	The translated CF data array.
	 *
	 * @uses 	findField()
	 *
	 * @since 	1.8
	 * @deprecated 1.10 Use E4J\VikRestaurants\CustomFields\FieldsLoader::translateObject() instead.
	 */
	public static function translateObject(array $data, $fields)
	{
		return E4J\VikRestaurants\CustomFields\Helpers\FieldsHelper::translateObject($data, $fields);
	}

	/**
	 * Searches a custom field using the specified query string.
	 *
	 * @param 	mixed 	 $key 	  The query params (the value to search for or an array
	 * 							  containing the column and the value).
	 * @param 	array 	 $fields  The custom fields list.
	 * @param 	integer  $fields  The maximum number of records to get (0 to ignore the limit).
	 *
	 * @return 	mixed 	 The custom fields that match the query.
	 *
	 * @since 	1.8
	 */
	public static function findField($key, $fields, $lim = 0)
	{
		$list = array();

		// if the key is a string, search by ID column
		if (is_string($key))
		{
			$key = array('id', $key);
		}

		foreach ($fields as $cf)
		{
			// check if the column value is equals to the key
			if (self::getColumnValue($cf, $key[0], null) == $key[1])
			{
				// push the custom field in the list
				$list[] = $cf;

				// stop iterating if we reached the limit
				if (count($list) == $lim)
				{
					break;
				}
			}
		}

		// return false if no matches
		if (!count($list))
		{
			return false;
		}
		// return the CF if the limit was set to 1
		else if ($lim == 1)
		{
			return reset($list);
		}

		// return the list of custom fields found (never empty)
		return $list;
	}

	/**
	 * Returns the custom fields values specified in the REQUEST.
	 *
	 * @param 	mixed 	 $fields 	The custom fields list to check for.
	 * 								If the list is not an array, the method will load
	 * 								all the custom fields that belong to the specified group.
	 * @param 	array 	 &$args 	The array data to fill-in in case of specific rules (name, e-mail, etc...).
	 * @param 	boolean  $strict 	True to raise an error when a mandatory field is missing.
	 *
	 * @return 	array 	The lookup array containing the values of the custom fields.
	 *
	 * @throws 	Exception 	When a mandatory field is empty or when a file hasn't been uploaded.
	 *
	 * @uses 	getList()
	 * @uses 	sanitizeFieldValue()
	 * @uses 	validateField()
	 * @uses 	dispatchRule()
	 * @uses 	helper methods to access fields properties
	 *
	 * @since 	1.8
	 */
	public static function loadFromRequest($fields = null, &$args = null, $strict = true)
	{
		$lookup = array();

		// if not an array, get the fields from the DB using the specified section
		if (!is_array($fields))
		{
			// always exclude separators
			$mask = self::FILTER_EXCLUDE_SEPARATOR;

			if (!$strict)
			{
				// exclude required checkbox too if we are in the back-end
				$mask |= self::FILTER_EXCLUDE_REQUIRED_CHECKBOX;
			}

			$fields = static::getList($fields, $mask);
		}

		// return an empty list in case there are no published fields
		if (!count($fields))
		{
			return $lookup;
		}

		if (is_null($args))
		{
			$args = array();
		}

		$app 	= JFactory::getApplication();
		$input 	= $app->input;

		foreach ($fields as $cf)
		{
			$id   = static::getID($cf);
			$name = static::getName($cf);

			$settings = (array) json_decode(static::getColumnValue($cf, 'choose', '{}'), true);

			// get value from request
			$lookup[$name] = $input->getString('vrcf' . $id, '');

			// if MULTIPLE select, stringify the selected options
			if (is_array($lookup[$name]))
			{
				$lookup[$name] = json_encode($lookup[$name]);
			}

			// sanitize the value obtained
			$lookup[$name] = static::sanitizeFieldValue($cf, $lookup[$name]);

			// validate the custom fields
			if (!static::validateField($cf, $lookup[$name]))
			{
				if ($strict)
				{
					// raise an error, the custom field is invalid
					throw new Exception(JText::translate('VRERRINSUFFCUSTF'));
				}
			}

			// dispatch the rule to fill $args array
			static::dispatchRule($cf, $lookup[$name], $args);

			// in case of required checkbox, such as the terms & conditions,
			// we should unset the registered value because it would be
			// always equals to YES/1
			if (static::isCheckbox($cf) && static::isRequired($cf))
			{
				unset($lookup[$name]);
			}
		}

		return $lookup;
	}

	/**
	 * Sanitize the field value.
	 *
	 * @param 	mixed 	$field 	The custom field.
	 * @param 	string 	$value 	The value to sanitize.
	 *
	 * @return 	mixed 	The sanitized value.
	 *
	 * @since 	1.8
	 */
	protected static function sanitizeFieldValue($field, $value)
	{
		// sanitize a input number
		if (static::isInputNumber($field))
		{
			// decode the settings
			$settings = json_decode(static::getColumnValue($field, 'choose', '{}'), true);

			// convert the string to float
			$value = floatval($value);
			
			// if min setting exists, make sure the value is not lower
			if (strlen($settings['min']))
			{
				$value = max(array($value, (float) $settings['min']));
			}

			// if max setting exists, make sure the value is not higher
			if (strlen($settings['max']))
			{
				$value = min(array($value, (float) $settings['max']));
			}

			// if decimals are not supported, round the value
			if (!$settings['decimals'])
			{
				$value = round($value);
			}
		}

		return $value;
	}

	/**
	 * Checks if the value of the field is accepted.
	 *
	 * @param 	mixed 	 $field   The custom field to evaluate.
	 * @param 	string 	 &$value  The value of the field.
	 *
	 * @return 	boolean  True if valid, otherwise false.
	 *
	 * @since 	1.8
	 */
	public static function validateField($field, &$value)
	{
		// check if delivery service is requested
		if (static::$deliveryService)
		{
			// check if the field is required only in case of pickup
			if (static::getColumnValue($field, 'required_delivery', 0) == 2)
			{
				// mark the field as optional in case of delivery
				static::setColumnValue($field, 'required', 0);

				if (JFactory::getApplication()->isClient('site'))
				{
					// clear value because it id not needed to collect
					// a delivery field in case of pickup service
					$value = '';
				}
			}
		}
		// fallback to pickup service
		else
		{
			// check if the field is required only in case of delivery
			if (static::getColumnValue($field, 'required_delivery', 0) == 1)
			{
				// mark the field as optional in case of pickup
				static::setColumnValue($field, 'required', 0);

				if (JFactory::getApplication()->isClient('site'))
				{
					// clear value because it id not needed to collect
					// a pickup field in case of delivery service
					$value = '';
				}
			}
		}

		return !static::isRequired($field) || strlen($value);
	}

	/**
	 * Dispatched the rule of the field.
	 *
	 * @param 	mixed 	$field 	The custom field to evaluate.
	 * @param 	string 	$value  The value of the field.
	 * @param 	array 	&$args 	The array data to fill-in in case of specific rules (name, e-mail, etc...).
	 *
	 * @return 	void
	 *
	 * @since 	1.8
	 */
	protected static function dispatchRule($field, $value, array &$args)
	{
		$input = JFactory::getApplication()->input;

		// get custom field ID
		$id = static::getID($field);

		// check if the field is a nominative
		if (static::isNominative($field))
		{
			if (!empty($args['purchaser_nominative']))
			{
				$args['purchaser_nominative'] .= ' ';
			}
			else
			{
				$args['purchaser_nominative'] = '';
			}

			$args['purchaser_nominative'] .= $value;
		}
		// check if the field is an e-mail
		else if (static::isEmail($field))
		{
			$args['purchaser_mail'] = $value;
		}
		// check if the field is a phone number
		else if (static::isPhoneNumber($field))
		{
			$args['purchaser_phone'] = $value;

			// get dial code
			$dial = $input->get('vrcf' . $id . '_dialcode', null, 'string');

			if ($dial)
			{
				$args['purchaser_prefix'] = $dial;
			}

			// get country code
			$country = $input->get('vrcf' . $id . '_country', null, 'string');

			if ($country)
			{
				$args['purchaser_country'] = $country;
			}
		}
		// check if the field is part of a complete address
		else if (static::isAddress($field) || static::isZip($field) || static::isCity($field) || static::isState($field))
		{
			if (!empty($args['purchaser_address']))
			{
				$args['purchaser_address'] .= ', ';
			}
			else
			{
				$args['purchaser_address'] = '';
			}

			$args['purchaser_address'] .= $value;
		}
		// check if the field holds some notes
		else if (static::isNotes($field) || static::isDeliveryNotes($field))
		{
			if (empty($args['notes']))
			{
				// init property
				$args['notes'] = '';
			}

			// wrap notes within a paragraph since they are
			// displayed within a WYSIWYG editor
			$args['notes'] .= '<p>' . $value . '</p>';

			// check if the field holds the delivery notes
			if (static::isDeliveryNotes($field))
			{
				// set also onto delivery notes
				$args['delivery_notes'] = $value;
			}
		}
	}

	/**
	 * Check if the custom field is a nominative.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if nominative, otherwise false.
	 *
	 * @uses 	getRule()
	 */
	public static function isNominative($cf)
	{
		return static::getRule($cf) == self::NOMINATIVE;
	}

	/**
	 * Check if the custom field is an e-mail.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if e-mail, otherwise false.
	 *
	 * @uses 	getRule()
	 */
	public static function isEmail($cf)
	{
		return static::getRule($cf) == self::EMAIL;
	}

	/**
	 * Check if the custom field is a phone number.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if phone number, otherwise false.
	 *
	 * @uses 	getRule()
	 */
	public static function isPhoneNumber($cf)
	{
		return static::getRule($cf) == self::PHONE_NUMBER;
	}

	/**
	 * Check if the custom field is an address.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if address, otherwise false.
	 *
	 * @uses 	getRule()
	 */
	public static function isAddress($cf)
	{
		return static::getRule($cf) == self::ADDRESS;
	}

	/**
	 * Check if the custom field is a delivery field.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if delivery field, otherwise false.
	 *
	 * @uses 	getRule()
	 */
	public static function isDelivery($cf)
	{
		return static::getRule($cf) == self::DELIVERY;
	}

	/**
	 * Check if the custom field is a pickup field.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if pickup field, otherwise false.
	 *
	 * @uses 	getRule()
	 */
	public static function isPickup($cf)
	{
		return static::getRule($cf) == self::PICKUP;
	}

	/**
	 * Check if the custom field is a ZIP field.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if ZIP field, otherwise false.
	 *
	 * @uses 	getRule()
	 */
	public static function isZip($cf)
	{
		return static::getRule($cf) == self::ZIP;
	}

	/**
	 * Check if the custom field is a City field.
	 *
	 * @param 	mixed    $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if City field, otherwise false.
	 *
	 * @uses 	getRule()
	 *
	 * @since 	1.8
	 */
	public static function isCity($cf)
	{
		return static::getRule($cf) == self::CITY;
	}

	/**
	 * Check if the custom field is a State/Province field.
	 *
	 * @param 	mixed    $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if State field, otherwise false.
	 *
	 * @uses 	getRule()
	 *
	 * @since 	1.8
	 */
	public static function isState($cf)
	{
		return static::getRule($cf) == self::STATE;
	}

	/**
	 * Check if the custom field is a Reservation Notes field.
	 *
	 * @param 	mixed    $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if Notes field, otherwise false.
	 *
	 * @uses 	getRule()
	 *
	 * @since 	1.8.3
	 */
	public static function isNotes($cf)
	{
		return static::getRule($cf) == self::NOTES;
	}

	/**
	 * Check if the custom field is a Delivery Notes field.
	 *
	 * @param 	mixed    $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if Delivery Notes field, otherwise false.
	 *
	 * @uses 	getRule()
	 *
	 * @since 	1.8.3
	 */
	public static function isDeliveryNotes($cf)
	{
		return static::getRule($cf) == self::DELIVERY_NOTES;
	}

	/**
	 * Get the ID property of the specified custom field object.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	integer  The ID of the custom field.
	 *
	 * @uses 	getColumnValue()
	 *
	 * @since 	1.8
	 */
	public static function getID($cf)
	{
		return static::getColumnValue($cf, 'id', 0);
	}

	/**
	 * Get the NAME property of the specified custom field object.
	 *
	 * @param 	mixed 	$cf  The array or the object of the custom field.
	 *
	 * @return 	string 	The name of the custom field.
	 *
	 * @uses 	getColumnValue()
	 *
	 * @since 	1.8
	 */
	public static function getName($cf)
	{
		return static::getColumnValue($cf, 'name', '');
	}

	/**
	 * Checks if the specified custom field is required.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if required, otherwise false.
	 *
	 * @uses 	getColumnValue()
	 *
	 * @since 	1.8
	 */
	public static function isRequired($cf)
	{
		return (bool) static::getColumnValue($cf, 'required', 0);
	}

	/**
	 * Get the TYPE property of the specified custom field object.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	integer  The type of the custom field.
	 *
	 * @uses 	getColumnValue()
	 *
	 * @since 	1.8
	 */
	public static function getType($cf)
	{
		return static::getColumnValue($cf, 'type', 'text');
	}

	/**
	 * Get the RULE property of the specified custom field object.
	 *
	 * @param 	mixed 	$cf  The array or the object of the custom field.
	 *
	 * @return 	string  The rule of the custom field, 
	 * 					'text' if it is not possible to estabilish it.
	 *
	 * @uses 	getColumnValue()
	 */
	public static function getRule($cf)
	{
		return static::getColumnValue($cf, 'rule', self::NONE);
	}

	/**
	 * Checks if the custom field is an input text.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if input text, otherwise false.
	 *
	 * @uses 	getType()
	 *
	 * @since 	1.8
	 */
	public static function isInputText($cf)
	{
		return static::getType($cf) == 'text';
	}

	/**
	 * Checks if the custom field is a textarea.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if textarea, otherwise false.
	 *
	 * @uses 	getType()
	 *
	 * @since 	1.8
	 */
	public static function isTextArea($cf)
	{
		return static::getType($cf) == 'textarea';
	}

	/**
	 * Checks if the custom field is an input number.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if input number, otherwise false.
	 *
	 * @uses 	getType()
	 *
	 * @since 	1.8
	 */
	public static function isInputNumber($cf)
	{
		return static::getType($cf) == 'number';
	}

	/**
	 * Checks if the custom field is a select.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if select, otherwise false.
	 *
	 * @uses 	getType()
	 *
	 * @since 	1.8
	 */
	public static function isSelect($cf)
	{
		return static::getType($cf) == 'select';
	}

	/**
	 * Checks if the custom field is a datepicker.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if datepicker, otherwise false.
	 *
	 * @uses 	getType()
	 *
	 * @since 	1.8
	 */
	public static function isCalendar($cf)
	{
		return static::getType($cf) == 'date';
	}

	/**
	 * Checks if the custom field is a checkbox.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if checkbox otherwise false.
	 *
	 * @uses 	getType()
	 *
	 * @since 	1.8
	 */
	public static function isCheckbox($cf)
	{
		return static::getType($cf) == 'checkbox';
	}

	/**
	 * Checks if the custom field is a separator.
	 *
	 * @param 	mixed 	 $cf  The array or the object of the custom field.
	 *
	 * @return 	boolean  True if separator, otherwise false.
	 *
	 * @uses 	getType()
	 *
	 * @since 	1.8
	 */
	public static function isSeparator($cf)
	{
		return static::getType($cf) == 'separator';
	}

	/**
	 * Method used to access the attributes and properties of the given
	 * custom field. Useful if we don't know if we are handling an array or an object.
	 *
	 * @param 	mixed 	$cf 	  The custom field array/object.
	 * @param 	string 	$column   The column to access.
	 * @param 	mixed 	$default  The default value in case the column does not exist.
	 *
	 * @return 	mixed 	The value at the specified column if exists, otherwise the default one.
	 *
	 * @since 	1.8
	 */
	protected static function getColumnValue($cf, $column, $default = null)
	{
		// check if the field is an array
		if (is_array($cf))
		{
			// if the column key exists, return the value
			if (array_key_exists($column, $cf))
			{
				return $cf[$column];
			}
		}
		// check if the field is an object
		else if (is_object($cf))
		{
			// if the property exists, return the value
			if (property_exists($cf, $column))
			{
				return $cf->{$column};
			}
		}

		// otherwise return the default one
		return $default;
	}

	/**
	 * Method used to set/update the attributes and properties of the given
	 * custom field. Useful if we don't know if we are handling an array or an object.
	 *
	 * @param 	mixed 	&$cf 	 The custom field array/object.
	 * @param 	string 	$column  The column to access.
	 * @param 	mixed 	$value   The value to set.
	 *
	 * @return 	mixed 	The previous value set, if any.
	 *
	 * @since 	1.8
	 */
	protected static function setColumnValue(&$cf, $column, $value)
	{
		// previous value set, if any
		$old = static::getColumnValue($cf, $column);

		// check if the field is an array
		if (is_array($cf))
		{
			// update array attribute
			$cf[$column] = $value;
		}
		// check if the field is an object
		else if (is_object($cf))
		{
			// update object property
			$cf->{$column} = $value;
		}

		// return previous value
		return $old;
	}

	/**
	 * Restaurant identifier group.
	 *
	 * @var integer
	 *
	 * @since 1.8
	 * @deprecated 1.10 Without replacement.
	 */
	const GROUP_RESTAURANT = 0;

	/**
	 * Take-Away identifier group.
	 *
	 * @var integer
	 *
	 * @since 1.8
	 * @deprecated 1.10 Without replacement.
	 */
	const GROUP_TAKEAWAY = 1;

	/**
	 * NONE identifier rule.
	 *
	 * @var integer
	 * @deprecated 1.10 Without replacement.
	 */
	const NONE = 0;

	/**
	 * NOMINATIVE identifier rule.
	 *
	 * @var integer
	 * @deprecated 1.10 Without replacement.
	 */
	const NOMINATIVE = 1;

	/**
	 * EMAIL identifier rule.
	 *
	 * @var integer
	 * @deprecated 1.10 Without replacement.
	 */
	const EMAIL = 2;

	/**
	 * PHONE NUMBER identifier rule.
	 *
	 * @var integer
	 * @deprecated 1.10 Without replacement.
	 */
	const PHONE_NUMBER = 3;

	/**
	 * ADDRESS identifier rule.
	 *
	 * @var integer
	 * @deprecated 1.10 Without replacement.
	 */
	const ADDRESS = 4;

	/**
	 * DELIVERY identifier rule.
	 *
	 * @var integer
	 * @deprecated 1.10 Without replacement.
	 */
	const DELIVERY = 5;

	/**
	 * ZIP identifier rule.
	 *
	 * @var integer
	 * @deprecated 1.10 Without replacement.
	 */
	const ZIP = 6;

	/**
	 * CITY identifier rule.
	 *
	 * @var integer
	 *
	 * @since 1.8
	 * @deprecated 1.10 Without replacement.
	 */
	const CITY = 7;

	/**
	 * STATE/PROVINCE identifier rule.
	 *
	 * @var integer
	 *
	 * @since 1.8
	 * @deprecated 1.10 Without replacement.
	 */
	const STATE = 8;

	/**
	 * PICKUP identifier rule.
	 *
	 * @var integer
	 *
	 * @since 1.8
	 * @deprecated 1.10 Without replacement.
	 */
	const PICKUP = 9;

	/**
	 * RESERVATION NOTES identifier rule.
	 *
	 * @var integer
	 *
	 * @since 1.8.3
	 * @deprecated 1.10 Without replacement.
	 */
	const NOTES = 10;

	/**
	 * DELIVERY NOTES identifier rule.
	 *
	 * @var integer
	 *
	 * @since 1.8.3
	 * @deprecated 1.10 Without replacement.
	 */
	const DELIVERY_NOTES = 11;

	/**
	 * Identifier used to use no filters when
	 * retrieving the custom fields.
	 *
	 * @var integer
	 *
	 * @since 1.8
	 * @deprecated 1.10 Without replacement.
	 */
	const FILTER_NONE = 0;

	/**
	 * Identifier used to use exclude the required
	 * checkboxes when retrieving the custom fields.
	 *
	 * @var integer
	 *
	 * @since 1.8
	 * @deprecated 1.10 Without replacement.
	 */
	const FILTER_EXCLUDE_REQUIRED_CHECKBOX = 1;

	/**
	 * Identifier used to use exclude the separators
	 * when retrieving the custom fields.
	 *
	 * @var integer
	 *
	 * @since 1.8
	 * @deprecated 1.10 Without replacement.
	 */
	const FILTER_EXCLUDE_SEPARATOR = 2;
}
