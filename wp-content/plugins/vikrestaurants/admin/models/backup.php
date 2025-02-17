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
 * VikRestaurants backup model.
 *
 * @since 1.9
 */
class VikRestaurantsModelBackup extends JModelVRE
{
	/**
	 * Basic item loading implementation.
	 *
	 * @param   mixed  $pk   An optional primary key value to load the row by, or an array of fields to match.
	 *                       If not set the instance property value is used.
	 *
	 * @return  mixed  The record object on success, null otherwise.
	 */
	public function getItem($pk, $new = false)
	{
		// check if we have a file path or a name
		if (!JFile::exists($pk))
		{
			// fetch folder in which the backup are stored
			$folder = VREFactory::getConfig()->get('backupfolder');

			if (!$folder)
			{
				// folder not specified, use the temporary folder
				$folder = JFactory::getApplication()->get('tmp_path');
			}

			// build file path
			$pk = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $pk;

			if (!JFile::exists($pk))
			{
				// backup not found
				return null;
			}
		}

		/** @var E4J\VikRestaurants\Platform\Uri\UriInterface */
		$uriHandler = VREFactory::getPlatform()->getUri();

		$backup = new stdClass;

		$backup->name      = basename($pk);
		$backup->path      = $pk;
		$backup->url       = $uriHandler->getUrlFromPath($pk);
		$backup->timestamp = filemtime($pk);
		$backup->date      = JFactory::getDate($backup->timestamp)->format('Y-m-d H:i:s');
		$backup->size      = filesize($pk);

		if (!$backup->url)
		{
			// use the administrator task for a direct download
			$url = $uriHandler->addCSRF('index.php?option=com_vikrestaurants&task=backup.download&cid[]=' . $backup->name);
			$backup->url = $uriHandler->admin($url, false);
		}

		$backup->type = new stdClass;

		if (preg_match("/backup_/i", $backup->name))
		{
			// try to fetch the backup type from the name
			$chunks = preg_split("/backup_/i", $backup->name);
			$chunks = preg_split("/_/", array_pop($chunks));
			// remove date from chunks
			array_pop($chunks);

			$backup->type->id = implode('_', $chunks);

			// try to fetch the matching export type
			$type = $this->getExportTypes($backup->type->id);

			if ($backup->type->id && $type)
			{
				$backup->type->name = $type->getName();
			}
			else
			{
				$backup->type->name = $backup->type->id;
			}	
		}
		else
		{
			// we are not dealing with a backup file
			$backup->type->id   = 'custom';
			$backup->type->name = 'custom';
		}

		return $backup;
	}

	/**
	 * Entirely rewrite save method because the backup files
	 * do not use database tables.
	 *
	 * @param 	mixed  $data  Either an array or an object of data to save.
	 *
	 * @return 	mixed  The ID of the record on success, false otherwise.
	 */
	public function save($data)
	{
		// wrap in a registry for a better ease of use
		$data = new JRegistry($data);

		$config = VREFactory::getConfig();

		if ($data->get('action', 'create') === 'create')
		{
			// get requested type
			$type = $data->get('type');

			if (!$type)
			{
				// type not specified, use the default one
				$type = $config->get('backuptype', 'full');
			}

			$options = [];

			// get requested folder
			$options['folder'] = $data->get('folder');

			if (!$options['folder'])
			{
				// folder not specified, use the default one
				$options['folder'] = $config->get('backupfolder', null);
			}

			if ($filename = $data->get('filename'))
			{
				// use the given filename
				$options['filename'] = $filename;
			}

			if ($prefix = $data->get('prefix'))
			{
				// use the given price
				$options['prefix'] = $prefix;
			}

			try
			{
				// create a new backup
				$archive = VREFactory::getBackupManager()->create($type, $options);
			}
			catch (Exception $e)
			{
				// register error and abort the saving process
				$this->setError($e);
				return false;
			}
		}
		else
		{
			$file = $data->get('file');

			// get requested folder
			$dest = $data->get('folder');

			if (!$dest)
			{
				// folder not specified, use the default one
				$dest = $config->get('backupfolder', null);
			}

			if (!$dest)
			{
				// use temporary folder if not specified
				$dest = JFactory::getApplication()->get('tmp_path');
			}

			// upload archive
			$resp = VikRestaurants::uploadFile($file, $dest, 'zip', $overwrite = false);

			if (!$resp->status)
			{
				// unable to upload the image, abort
				if ($resp->errno == 1)
				{
					$this->setError(JText::sprintf('VRCONFIGFILETYPEERRORWHO', $resp->mimeType));
				}
				else
				{
					$this->setError(JText::translate('VRCONFIGUPLOADERROR'));
				}

				return false;
			}

			// extract file type from path
			$filetype = pathinfo($resp->path, PATHINFO_EXTENSION);

			// build safe name
			$safeName = 'backup_uploaded_' . JFactory::getDate()->format('Y-m-d H-i-s') . '.' . $filetype;

			// rename the file so that the system will be able to load it
			if (!rename($resp->path, dirname($resp->path) . DIRECTORY_SEPARATOR . $safeName))
			{
				// it was not possible to rename the file
				JFile::delete($resp->path);
				$this->setError(sprintf('Cannot rename [%s] into [%s]', $resp->name, $safeName));
				return false;
			}

			// register archive name
			$archive = $safeName;
		}

		return $archive;
	}

	/**
	 * Restores an existing backup.
	 *
	 * @param 	string   $path  Either the name of the path of the archive.
	 *
	 * @return 	boolean  True on success, false otherwise.
	 */
	public function restore($path)
	{
		// make sure the archive exists
		$archive = $this->getItem($path);

		if (!$archive)
		{
			// the specified backup doesn't exist
			$this->setError(sprintf('Backup [%s] not found', $path));
			return false;
		}

		try
		{
			// restore the system with the backup data
			VREFactory::getBackupManager()->restore($archive->path);
		}
		catch (Exception $e)
		{
			// an error occurred
			$this->setError($e);
			return false;
		}

		return true;
	}

	/**
	 * Extend delete implementation to delete any related records
	 * stored within a separated table.
	 *
	 * @param   mixed    $ids  Either the record ID or a list of records.
	 *
	 * @return 	boolean  True on success, false otherwise.
	 */
	public function delete($ids)
	{
		$ids = (array) $ids;

		$result = false;

		foreach ($ids as $id)
		{
			// fetch backup details
			$item = $this->getItem($id);

			if ($item)
			{
				// delete the backup file
				$result = JFile::delete($item->path) || $result;
			}
		}

		return $result;
	}

	/**
	 * Moves the existing backup archives into the new specified folder.
	 * 
	 * @param 	string 	 $path  The new folder used to host the archives.
	 * 
	 * @return 	boolean  True on success, false otherwise.
	 */
	public function moveArchives($path)
	{
		// get currently set folder
		$current = VREFactory::getConfig()->get('backupfolder');

		if (!$current)
		{
			// folder not specified, use the default one
			$current = JFactory::getApplication()->get('tmp_path');
		}

		// load all backup archives
		$files = JFolder::files($current, 'backup_', $recurse = false, $fullpath = true);

		$path = rtrim($path, DIRECTORY_SEPARATOR);

		if (!JFolder::exists($path))
		{
			// attempt to create the folder if missing
			JFolder::create($path);
		}

		$status = true;

		foreach ($files as $file)
		{
			// create new path
			$newFile = $path . DIRECTORY_SEPARATOR . basename($file);
			// try to rename the archive
			if (!rename($file, $newFile))
			{
				$this->setError(sprintf('Unable to move [%s] into [%s]', $file, $newFile));
				$status = false;
			}
		}

		return $status;
	}

	/**
	 * Returns a list of supported export types.
	 * 
	 * @param 	string|null        $id  When provided, only the matching type will be returned.
	 * 
	 * @return 	array|object|null
	 */
	public function getExportTypes($id = null)
	{
		$backupManager = VREFactory::getBackupManager();

		if (!$id)
		{
			// return all the supported types
			return $backupManager->getExportTypes();
		}

		try
		{
			return $backupManager->getExportType($id);
		}
		catch (Exception $e)
		{
			// catch error silently
		}

		// type not found
		return null;
	}
}
