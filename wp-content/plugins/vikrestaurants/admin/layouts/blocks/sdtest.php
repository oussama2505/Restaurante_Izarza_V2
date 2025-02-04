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
 * Layout variables
 * -----------------
 * @param 	array    list    An array of supported special days.
 * @param 	boolean  closed  True in case of closure, false otherwise.
 * @param 	array    args    An associative array containing the searched arguments.
 * @param 	array 	 shifts  A list of supported shifts.
 */
extract($displayData);

$vik = VREApplication::getInstance();

?>

<style>
	.git-table {
		margin-bottom: 20px;
	}
	/* increase line-height to support margins between badges */
	.git-table td { 
		line-height: 22px;
	}
</style>

<div class="sd-test-results-wrapper">

	<?php
	if (!$list)
	{
		if ($closed)
		{
			// restaurant is closed
			echo $vik->alert(JText::translate('VRRESERVATIONREQUESTMSG3'), 'error');
		}
		else
		{
			// default working shifts
			echo $vik->alert(JText::translate('VRTESTSPECIALDAYSWARN'), 'warning');
			
			// display global working shifts by using a sub layout
			echo $this->sublayout('shifts', $displayData);
		}
	}
	else
	{
		// iterate special days
		foreach ($list as $sd)
		{
			?>
			<div class="sd-test-result-table">
				<h4><?php echo $sd->name; ?></h4>

				<?php
				if ($closed && !$sd->ignoreClosingDays)
				{
					// restaurant is closed
					echo $vik->alert(JText::translate('VRRESERVATIONREQUESTMSG3'), 'error');
				}
				else
				{
					// inject special days object within display data
					$displayData['data'] = $sd;

					// display table by using a sub layout
					echo $this->sublayout($args['group'], $displayData);
				}
				?>
			</div>
			<?php
		}
	}
	?>

</div>
