<?php
/** 
 * @package     VikRestaurants
 * @subpackage  core
 * @author      E4J s.r.l.
 * @copyright   Copyright (C) 2023 E4J s.r.l. All Rights Reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @link        https://vikwp.com
 */

namespace E4J\VikRestaurants\DI;

// No direct access
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Helper class used to easily load resources from a folder
 * according to specific patterns.
 * 
 * @since 1.9
 */
class ContainerDecorator
{
	/** @var Container */
	private $container;

	/**
	 * Class constructor.
	 * 
	 * @param  Container  $container  An optional container to bind. If not provided
	 *                                a new one will be created.
	 */
	public function __construct(Container $container = null)
	{
		if ($container)
		{
			// use the provided container
			$this->container = $container;
		}
		else
		{
			// create a new container
			$this->container = new Container;
		}
	}

	/**
	 * Returns the container.
	 * 
	 * @return  Container
	 */
	public function getContainer()
	{
		return $this->container;
	}

	/**
	 * Registers all the resources placed within the provided folder.
	 * It is possible to pass specific options to change the way the resources are
	 * loaded and registered.
	 * 
	 * - template   string    The template of the resource ID.
	 * - namespace  string    The namespace of the class.
	 * - suffix     string    The classname suffix.
	 * - prefix     string    The classname prefix.
	 * - autoload   bool      False to directly require the PHP file (default: true).
	 * - callback   callable  An optional callback to invoke to manipulate the classname at runtime (default: null).
	 * - protected  bool      True to protect the loaded resource (default: false).
	 * - shared     bool      True to share the loaded resource (default: false).
	 * 
	 * @param   string  $dir      The path to the folder containing the resources to load.
	 * @param   array   $options  An array of configuration options.
	 * 
	 * @return  self    This object to support chaining.
	 */
	public function register(string $dir, array $options = [])
	{
		if (!\JFolder::exists($dir))
		{
			throw new \RuntimeException('Folder [' . $dir . '] not found', 404);
		}

		// wrap in a registry for a better ease of use
		$options = new \JObject($options);

		// scan all the PHP files within the provided folder
		foreach (\JFolder::files($dir, '\.php$') as $file)
		{
			// remove extension from file name
			$resourceId = $classname = preg_replace("/\.php$/i", '', $file);

			if ($suffix = $options->get('suffix'))
			{
				// replace suffix from class name
				$resourceId = preg_replace("/{$suffix}$/i", '', $resourceId);
			}

			if ($prefix = $options->get('prefix'))
			{
				// replace prefix from class name
				$resourceId = preg_replace("/^{$prefix}/i", '', $resourceId);
			}

			if ($template = $options->get('template'))
			{
				// construct resource ID according to the provided template
				$resourceId = str_replace('{id}', $resourceId, $template);
			}

			// register resource
			$resource = $this->container->set(strtolower($resourceId), function() use ($dir, $classname, $options)
			{
				if ($options->get('autoload', true) == false)
				{
					// manually require the file
					require_once \JPath::clean($dir . '/' . $classname . '.php');
				}

				if (is_callable($options->get('callback')))
				{
					// manipulate the classname
					$classname = $options->get('callback')($classname);
				}

				if ($namespace = $options->get('namespace'))
				{
					// prepend the provided namespace to the class
					$classname = rtrim($namespace, '\\') . '\\' . $classname;
				}

				if (!class_exists($classname))
				{
					// the class does not exist
					throw new \RuntimeException('Resource [' . $classname . '] not found', 404);
				}

				// observe the metadata of the provided class
				$reflection = new \ReflectionClass($classname);

				// make sure the class has a constructor
				if ($reflection->getConstructor())
				{
					// construct with all the provided arguments
					$obj = $reflection->newInstanceArgs(func_get_args());
				}
				else
				{
					// the class doesn't provide a constructor, bypass it
					$obj = $reflection->newInstanceWithoutConstructor();
				}

				return $obj;
			});

			if (!empty($options->get('protected', false)))
			{
				// protect the resource
				$resource->protect(true);
			}

			if (!empty($options->get('shared', false)))
			{
				// share the resource
				$resource->share(true);
			}
		}

		return $this;
	}
}
