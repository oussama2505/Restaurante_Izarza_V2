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

VRELoader::import('library.order.wrapper');

/**
 * Restaurant reservation class wrapper.
 *
 * @since 1.8
 */
class VREOrderRestaurant extends VREOrderWrapper
{
	/**
	 * Class constructor.
	 *
	 * @param 	integer  $id       The reservation ID.
	 * @param 	mixed    $langtag  The language tag. If null, the default one will be used.
	 * @param 	array 	 $options  An array of options to be passed to the order instance.
	 */
	public function __construct($id, $langtag = null, array $options = array())
	{
		// construct object
		parent::__construct($id, $langtag, $options);

		/**
		 * When "preload" option is passed, we need to prevent the
		 * lazy loading of all the secondary information.
		 *
		 * @since 1.8.4
		 */
		if (!empty($options['preload']))
		{
			// retrieve all the information with lazy load
			$this->tables;
			$this->menus;
		}
	}

	/**
	 * @override
	 * Returns the restaurant reservation object.
	 *
	 * @param 	integer  $id       The reservation ID.
	 * @param 	mixed    $langtag  The language tag. If null, the default one will be used.
	 * @param 	array 	 $options  An array of options to be passed to the order instance.
	 *
	 * @return 	mixed    The array/object to load.
	 *
	 * @throws 	Exception
	 */
	protected function load($id, $langtag = null, array $options = array())
	{
		$dbo        = JFactory::getDbo();
		$config     = VREFactory::getConfig();
		$dispatcher = VREFactory::getEventDispatcher();

		// create query
		$q = $dbo->getQuery(true);

		// select all reservation columns
		$q->select('r.*');
		$q->from($dbo->qn('#__vikrestaurants_reservation', 'r'));

		// select table name
		$q->select($dbo->qn('t.name', 'table_name'));
		$q->leftjoin($dbo->qn('#__vikrestaurants_table', 't') . ' ON ' . $dbo->qn('r.id_table') . ' = ' . $dbo->qn('t.id'));

		// select room name
		$q->select($dbo->qn('rm.id', 'id_room'));
		$q->select($dbo->qn('rm.name', 'room_name'));
		$q->select($dbo->qn('rm.description', 'room_description'));
		$q->leftjoin($dbo->qn('#__vikrestaurants_room', 'rm') . ' ON ' . $dbo->qn('t.id_room') . ' = ' . $dbo->qn('rm.id'));

		// select payment name
		$q->select($dbo->qn('gp.name', 'payment_name'));
		$q->select($dbo->qn('gp.file', 'payment_file'));
		$q->select($dbo->qn('gp.note', 'payment_note'));
		$q->select($dbo->qn('gp.prenote', 'payment_prenote'));
		$q->select($dbo->qn('gp.icontype', 'payment_icontype'));
		$q->select($dbo->qn('gp.icon', 'payment_icon'));
		$q->leftjoin($dbo->qn('#__vikrestaurants_gpayments', 'gp') . ' ON ' . $dbo->qn('r.id_payment') . ' = ' . $dbo->qn('gp.id'));

		// select status code
		$q->select($dbo->qn('rc.code', 'status_code'));
		$q->select($dbo->qn('rc.icon', 'code_icon'));
		$q->leftjoin($dbo->qn('#__vikrestaurants_res_code', 'rc') . ' ON ' . $dbo->qn('r.rescode') . ' = ' . $dbo->qn('rc.id'));

		// select reservation items
		$q->select($dbo->qn('i.id', 'item_id'));
		$q->select($dbo->qn('i.id_product', 'item_id_product'));
		$q->select($dbo->qn('i.id_product_option', 'item_id_option'));
		$q->select($dbo->qn('i.name', 'item_name'));
		$q->select($dbo->qn('i.quantity', 'item_quantity'));
		$q->select($dbo->qn('i.price', 'item_price'));
		$q->select($dbo->qn('i.net', 'item_net'));
		$q->select($dbo->qn('i.tax', 'item_tax'));
		$q->select($dbo->qn('i.gross', 'item_gross'));
		$q->select($dbo->qn('i.discount', 'item_discount'));
		$q->select($dbo->qn('i.tax_breakdown', 'item_tax_breakdown'));
		$q->select($dbo->qn('i.notes', 'item_notes'));
		$q->select($dbo->qn('i.servingnumber', 'item_servingnumber'));

		$q->leftjoin($dbo->qn('#__vikrestaurants_res_prod_assoc', 'i') . ' ON ' . $dbo->qn('i.id_reservation') . ' = ' . $dbo->qn('r.id'));

		// filter records by ID
		$q->where($dbo->qn('r.id') . ' = ' . (int) $id);

		// filter by order key, if specified
		if (isset($options['sid']))
		{
			$q->where($dbo->qn('r.sid') . ' = ' . $dbo->q($options['sid']));
		}

		// filter by confirmation key, if specified
		if (isset($options['conf_key']))
		{
			$q->where($dbo->qn('r.conf_key') . ' = ' . $dbo->q($options['conf_key']));
		}

		/**
		 * Sort the bill items by serving number.
		 * 
		 * @since 1.9.1
		 */
		$q->order($dbo->qn('i.servingnumber') . ' ASC');
		$q->order($dbo->qn('i.id') . ' ASC');

		/**
		 * External plugins can attach to this hook in order to manipulate
		 * the query at runtime, in example to alter the default ordering.
		 *
		 * @param 	mixed    &$query   A query builder instance.
		 * @param 	integer  $id       The ID of the reservation.
		 * @param 	mixed    $langtag  The language tag. If null, the default one will be used.
		 * @param 	array 	 $options  An array of options to be passed to the order instance.
		 *
		 * @return 	void
		 *
		 * @since 	1.8.4
		 */
		$dispatcher->trigger('onLoadRestaurantReservationDetails', array(&$q, $id, $langtag, $options));

		$dbo->setQuery($q);
		$list = $dbo->loadObjectList();

		if (!$list)
		{
			// order not found raise error
			throw new Exception(sprintf('Reservation [%d] not found', $id), 404);
		}

		$order = $list[0];
		$order->items = array();

		$order->room = new stdClass;
		$order->room->id          = $order->id_room;
		$order->room->name        = $order->room_name;
		$order->room->description = $order->room_description;

		// fetch checkout
		$staytime = $order->stay_time ? $order->stay_time : $config->getInt('averagetimestay');
		$order->checkout = strtotime('+' . $staytime . ' minutes', $order->checkin_ts);

		// format check-in
		$order->checkin_iso8601 = JFactory::getDate(date('Y-m-d H:i:s', $order->checkin_ts), date_default_timezone_get())->toISO8601();
		$order->checkin_lc1 = JHtml::fetch('date', $order->checkin_ts, JText::translate('DATE_FORMAT_LC1') . ' ' . $config->get('timeformat'), date_default_timezone_get());
		$order->checkin_lc3 = JHtml::fetch('date', $order->checkin_ts, JText::translate('DATE_FORMAT_LC3') . ' ' . $config->get('timeformat'), date_default_timezone_get());

		// format check-out
		$order->checkout_iso8601 = JFactory::getDate(date('Y-m-d H:i:s', $order->checkout), date_default_timezone_get())->toISO8601();
		$order->checkout_lc1 = JHtml::fetch('date', $order->checkout, JText::translate('DATE_FORMAT_LC1') . ' ' . $config->get('timeformat'), date_default_timezone_get());
		$order->checkout_lc3 = JHtml::fetch('date', $order->checkout, JText::translate('DATE_FORMAT_LC3') . ' ' . $config->get('timeformat'), date_default_timezone_get());

		// fetch coupon
		if ($order->coupon_str)
		{
			list($code, $amount, $type) = explode(';;', $order->coupon_str);

			$order->coupon = new stdClass;
			$order->coupon->code   = $code;
			$order->coupon->amount = $amount;
			$order->coupon->type   = $type;
		}
		else
		{
			$order->coupon = null;
		}

		/**
		 * Retrieve custom fields for the restaurant section by using the related helper.
		 * @var E4J\VikRestaurants\CustomFields\FieldsCollection
		 *
		 * @since 1.9
		 */
		$customFields = E4J\VikRestaurants\CustomFields\FieldsCollection::getInstance()
			->filter(new E4J\VikRestaurants\CustomFields\Filters\RestaurantGroupFilter)
			->filter(new E4J\VikRestaurants\CustomFields\Filters\SeparatorFilter($exclude = true))
			->filter(new E4J\VikRestaurants\CustomFields\Filters\RequiredCheckboxFilter($exclude = true));

		// decode stored CF data
		$order->fields = $order->custom_f ? (array) json_decode($order->custom_f, true) : [];

		// Translate CF data object into the current language.
		// Do not override the $order->fields property directly, otherwise the `translate` method would
		// apply the correct i18n to an object already translated.
		$translatedFields = VRCustomFields::translateObject($order->fields, $customFields);

		$order->displayFields = [];

		foreach ($customFields as $field)
		{
			$k = $field->getName();

			if (!array_key_exists($k, $translatedFields))
			{
				// field not found inside the given object, go to next one
				continue;
			}

			$v = $translatedFields[$k];

			// take only if the value is not empty
			if ((is_scalar($v) && strlen((string) $v)) || !empty($v))
			{
				// get a more readable label/text of the saved value
				$order->displayFields[$field->langname] = $v;
			}
		}

		$vars = array_values($order->fields);
		$vars = array_filter($vars, function($elem)
		{
			if (is_array($elem))
			{
				return (bool) $elem;
			}

			return strlen($elem);
		});
		
		$order->hasFields = (bool) $vars;

		// fetch restaurant reservation menu items
		foreach ($list as $row)
		{
			if ($row->item_id)
			{
				$item = new stdClass;
				$item->id            = $row->item_id;
				$item->id_product    = $row->item_id_product;
				$item->id_option     = $row->item_id_option;
				$item->name          = $row->item_name;
				$item->quantity      = $row->item_quantity;
				$item->price         = $row->item_price;
				$item->net           = $row->item_net;
				$item->tax           = $row->item_tax;
				$item->gross         = $row->item_gross;
				$item->discount      = $row->item_discount;
				$item->tax_breakdown = json_decode($row->item_tax_breakdown ?? '');
				$item->notes         = $row->item_notes;
				$item->servingnumber = $row->item_servingnumber;

				if ($item->id_option)
				{
					// extract product name and option name
					$names = preg_split("/\s+\-\s+/", $item->name);

					// the last chunck is the option name
					$item->optionName = array_pop($names);

					// the remaining part is the product name
					$item->productName = implode(' - ', $names);
				}
				else
				{
					// no option available
					$item->productName = $item->name;
					$item->optionName  = '';
				}

				$order->items[$item->id] = $item;
			}
		}

		// fetch payment data
		if ($order->payment_file)
		{
			$order->payment = new stdClass;
			$order->payment->id       = $order->id_payment;
			$order->payment->name     = $order->payment_name;
			$order->payment->driver   = $order->payment_file;
			$order->payment->iconType = $order->payment_icontype;
			$order->payment->icon     = $order->payment_icon;

			if ($order->payment->iconType == 1)
			{
				// Font Icon
				$order->payment->fontIcon = $order->payment->icon;
			}
			else
			{
				// Image Icon
				$order->payment->iconURI = JUri::root() . $order->payment->icon;

				// fetch Font Icon based on payment driver

				switch ($order->payment->driver)
				{
					case 'bank_transfer.php':
						$order->payment->fontIcon = 'fas fa-money-bill';
						break;

					case 'paypal.php':
						$order->payment->fontIcon = 'fab fa-paypal';
						break;

					default:
						$order->payment->fontIcon = 'fas fa-credit-card';
				}
			}

			$order->payment->notes = new stdClass;
			$order->payment->notes->beforePurchase = $order->payment_prenote;
			$order->payment->notes->afterPurchase  = $order->payment_note;
		}
		else
		{
			$order->payment = null;
		}

		/**
		 * Fetch status role depending on the selected status.
		 * 
		 * @since 1.9
		 */
		$order->statusRole = JHtml::fetch('vrehtml.status.role', 'restaurant', $order->status);

		// fetch paid flag based on current order status
		$order->paid = JHtml::fetch('vrehtml.status.ispaid', 'restaurant', $order->status);

		if ($order->paid)
		{
			// set as fully paid
			$order->tot_paid = max($order->bill_value, $order->tot_paid);
		}
		else if ($order->statusRole === 'APPROVED')
		{
			// reservation approved, set the total paid equals to the deposit left (if higher)
			$order->tot_paid = max($order->tot_paid, $order->deposit);
		}

		// calculate total due
		$order->total_due = max(0, $order->bill_value - $order->tot_paid);

		/**
		 * External plugins can use this event to manipulate the object holding
		 * the details of the reservation. Useful to inject all the additional
		 * data fetched with the manipulation of the query.
		 *
		 * @param 	mixed  &$res  The reservation details object.
		 * @param 	array  $list  The query resulting array.
		 *
		 * @return 	void
		 *
		 * @since 	1.8.4
		 */
		$dispatcher->trigger('onSetupRestaurantReservationDetails', array(&$order, $list));

		return $order;
	}

	/**
	 * @override
	 * Translates the internal properties.
	 *
	 * @param 	mixed    $langtag  The language tag. If null, the default one will be used.
	 *
	 * @return 	void
	 */
	protected function translate($langtag = null)
	{
		$dispatcher = VREFactory::getEventDispatcher();

		if (!$langtag)
		{
			// use order lang tag in case it was not specified
			$langtag = $this->get('langtag', null);

			if (!$langtag)
			{
				// the order is not assigned to any lang tag, use the current one
				$langtag = JFactory::getLanguage()->getTag();
			}
		}

		// get translator
		$translator = VREFactory::getTranslator();

		$product_ids = array();
		$option_ids  = array();

		foreach ($this->items as $item)
		{
			$product_ids[] = $item->id_product;

			if ($item->id_option)
			{
				$option_ids[] = $item->id_option;
			}
		}

		// pre-load products translations
		$prodLang = $translator->load('menusproduct', array_unique($product_ids), $langtag);
		// pre-load products options translations
		$optLang = $translator->load('productoption', array_unique($option_ids), $langtag);

		// iterate items and apply translationss
		foreach ($this->items as &$item)
		{
			// translate product name for the given language
			$prod_tx = $prodLang->getTranslation($item->id_product, $langtag);

			if ($prod_tx)
			{
				// inject translation within order item
				$item->productName = $prod_tx->name;
			}

			if ($item->id_option)
			{
				// translate product option name for the given language
				$opt_tx = $optLang->getTranslation($item->id_option, $langtag);

				if ($opt_tx)
				{
					// inject translation within order item
					$item->optionName = $opt_tx->name;
				}
			}

			// complete traslation of full name
			$item->name = $item->productName . ($item->id_option ? ' - ' . $item->optionName : '');
		}

		// translate payment if specified
		if ($this->id_payment)
		{
			// get payment translation
			$pay_tx = $translator->translate('payment', $this->id_payment, $langtag);

			if ($pay_tx)
			{
				// inject translation within order details
				$this->payment->name                  = $pay_tx->name;
				$this->payment->notes->beforePurchase = $pay_tx->prenote;
				$this->payment->notes->afterPurchase  = $pay_tx->note;
			}
		}

		// translate selected menus, if any
		foreach ($this->menus as $i => $menu)
		{
			// get menu translation
			$menu_tx = $translator->translate('menu', $menu->id, $langtag);

			if ($menu_tx)
			{
				// inject translation within order details
				$menu->name        = $menu_tx->name;
				$menu->description = $menu_tx->description;

				// update object in list
				$this->menus[$i] = $menu;
			}
		}

		/**
		 * Retrieve custom fields for the restaurant section by using the related helper.
		 * @var E4J\VikRestaurants\CustomFields\FieldsCollection
		 *
		 * @since 1.9
		 */
		$customFields = E4J\VikRestaurants\CustomFields\FieldsCollection::getInstance()
			->filter(new E4J\VikRestaurants\CustomFields\Filters\RestaurantGroupFilter)
			->filter(new E4J\VikRestaurants\CustomFields\Filters\SeparatorFilter($exclude = true))
			->filter(new E4J\VikRestaurants\CustomFields\Filters\RequiredCheckboxFilter($exclude = true));
		
		// translate CF data object into the given language
		$this->fields = VRCustomFields::translateObject($this->fields, $customFields, $langtag);

		// reset display fields
		$this->displayFields = [];

		foreach ($customFields as $field)
		{
			$k = $field->getName();

			if (!array_key_exists($k, $this->fields))
			{
				// field not found inside the given object, go to next one
				continue;
			}

			$v = $this->fields[$k];

			// take only if the value is not empty
			if ((is_scalar($v) && strlen((string) $v)) || !empty($v))
			{
				// get a more readable label/text of the saved value
				$this->displayFields[$field->langname] = $v;
			}
		}

		// translate room
		VikRestaurants::translateRooms($this->room, $langtag);

		/**
		 * External plugins can use this event to apply the translations to
		 * additional details manually included within the reservation object.
		 *
		 * @param 	mixed   $res      The reservation details object.
		 * @param   string  $langtag  The requested language tag.
		 *
		 * @return 	void
		 *
		 * @since 	1.8.4
		 */
		$dispatcher->trigger('onTranslateRestaurantReservationDetails', array($this, $langtag));
	}

	/**
	 * Creates a standard object, containing all the supported properties,
	 * to be used when this class is passed to "json_encode()".
	 *
	 * @return  object
	 *
	 * @see     JsonSerializable
	 */
	#[ReturnTypeWillChange]
	public function jsonSerialize()
	{
		$lookup = array(
			'tables',
			'menus',
		);

		// lazy load additional details before encoding them
		foreach ($lookup as $name)
		{
			$this->__get($name);
		}

		// invoke parent
		return parent::jsonSerialize();
	}

	/**
	 * @override
	 * Returns the billing details of the user that made the order.
	 *
	 * @return 	object
	 */
	protected function getBilling()
	{
		$dbo = JFactory::getDbo();

		$q = $dbo->getQuery(true)
			->select('*')
			->from($dbo->qn('#__vikrestaurants_users'))
			->where($dbo->qn('id') . ' = ' . (int) $this->id_user)
			->orWhere(array(
				$dbo->qn('billing_mail') . ' <> ' . $dbo->q(''),
				$dbo->qn('billing_mail') . ' IS NOT NULL',
				$dbo->qn('billing_mail') . ' = ' . $dbo->q($this->purchaser_mail),
			), 'AND');

		$dbo->setQuery($q, 0, 1);
		return $dbo->loadObject() ?: false;
	}

	/**
	 * @override
	 * Returns the account details of the order author.
	 *
	 * @return 	object
	 */
	protected function getAuthor()
	{
		if ($this->created_by <= 0)
		{
			// no registered author, do not go ahead
			return false;
		}

		$dbo = JFactory::getDbo();

		$q = $dbo->getQuery(true)
			->select($dbo->qn('name'))
			->select($dbo->qn('username'))
			->select($dbo->qn('email'))
			->from($dbo->qn('#__users'))
			->where($dbo->qn('id') . ' = ' . (int) $this->created_by);

		$dbo->setQuery($q, 0, 1);
		return $dbo->loadObject() ?: false;
	}

	/**
	 * @override
	 * Returns the invoice details of the order.
	 *
	 * @return 	mixed   The invoice object is exists, false otherwise.
	 */
	protected function getInvoice()
	{
		$dbo = JFactory::getDbo();

		$q = $dbo->getQuery(true)
			->select($dbo->qn('id'))
			->select($dbo->qn('inv_number', 'number'))
			->select($dbo->qn('inv_date', 'date'))
			->select($dbo->qn('file'))
			->select($dbo->qn('createdon'))
			->from($dbo->qn('#__vikrestaurants_invoice'))
			->where($dbo->qn('id_order') . ' = ' . (int) $this->id)
			->where($dbo->qn('group') . ' = 0');

		$dbo->setQuery($q, 0, 1);

		// load invoice
		$invoice = $dbo->loadObject();

		if (!$invoice)
		{
			// invoice not found
			return false;
		}

		// build invoice file path
		$invoice->path = VREINVOICE . DIRECTORY_SEPARATOR . $invoice->file;

		// build invoice file URI
		$invoice->uri = VREINVOICE_URI . $invoice->file;

		return $invoice;
	}

	/**
	 * @override
	 * Returns the list of selected menus.
	 *
	 * @return 	array   A list of selected menus.
	 */
	protected function getMenus()
	{
		$dbo = JFactory::getDbo();

		$q = $dbo->getQuery(true)
			->select($dbo->qn('a.id', 'id_assoc'))
			->select($dbo->qn('a.id_menu', 'id'))
			->select($dbo->qn('m.name'))
			->select($dbo->qn('m.description'))
			->select($dbo->qn('a.quantity'))
			->from($dbo->qn('#__vikrestaurants_res_menus_assoc', 'a'))
			->leftjoin($dbo->qn('#__vikrestaurants_menus', 'm') . ' ON ' . $dbo->qn('a.id_menu') . ' = ' . $dbo->qn('m.id'))
			->where($dbo->qn('a.id_reservation') . ' = ' . (int) $this->id);

		$dbo->setQuery($q);
		return $dbo->loadObjectList();
	}

	/**
	 * @override
	 * Returns a list containing all the tables
	 * assigned to this reservation.
	 *
	 * @return 	array   A list of tables.
	 */
	protected function getTables()
	{
		$tables = array();

		$def = new stdClass;
		$def->id       = $this->id_table;
		$def->name     = $this->table_name;
		$def->id_order = $this->id;

		$tables[] = $def;

		$dbo = JFactory::getDbo();

		$q = $dbo->getQuery(true)
			->select($dbo->qn('t.id', 'id'))
			->select($dbo->qn('t.name', 'name'))
			->select($dbo->qn('r.id', 'id_order'))
			->from($dbo->qn('#__vikrestaurants_reservation', 'r'))
			->leftjoin($dbo->qn('#__vikrestaurants_table', 't') . ' ON ' . $dbo->qn('r.id_table') . ' = ' . $dbo->qn('t.id'))
			->where($dbo->qn('r.id_parent') . ' = ' . (int) $this->id);

		$dbo->setQuery($q);
		return array_merge($tables, $dbo->loadObjectList());
	}

	/**
	 * @override
	 * Returns the history of the status codes set for the order.
	 *
	 * @return 	array
	 */
	protected function getHistory()
	{
		$dbo = JFactory::getDbo();

		$q = $dbo->getQuery(true)
			->select($dbo->qn('os.id'))
			->select($dbo->qn('os.id_rescode', 'idCode'))
			->select($dbo->qn('os.notes'))
			->select($dbo->qn('os.createdon'))
			->select($dbo->qn('os.createdby'))
			->select($dbo->qn('u.name', 'userName'))
			->select($dbo->qn('rc.code'))
			->select($dbo->qn('rc.icon'))
			->select($dbo->qn('rc.notes', 'codeNotes'))
			->from($dbo->qn('#__vikrestaurants_order_status', 'os'))
			->leftjoin($dbo->qn('#__vikrestaurants_res_code', 'rc') . ' ON ' . $dbo->qn('rc.id') . ' = ' . $dbo->qn('os.id_rescode'))
			->leftjoin($dbo->qn('#__users', 'u') . ' ON ' . $dbo->qn('u.id') . ' = ' . $dbo->qn('os.createdby'))
			->where($dbo->qn('os.id_order') . ' = ' . (int) $this->id)
			->where($dbo->qn('os.group') . ' = ' . 1)
			->order($dbo->qn('os.createdon') . ' DESC');

		$dbo->setQuery($q);
		$history = $dbo->loadObjectList();

		foreach ($history as $code)
		{
			if ($code->icon)
			{
				// set up icon URL
				$code->iconURL = VREMEDIA_SMALL_URI . $code->icon;
			}
		}

		return $history;
	}
}
