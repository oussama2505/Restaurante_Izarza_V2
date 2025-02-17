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

$returnUrl   = isset($displayData['return'])   ? $displayData['return']   : null;
$remember    = isset($displayData['remember']) ? $displayData['remember'] : false;
$footerLinks = isset($displayData['footer'])   ? $displayData['footer']   : true;

// create login URL for Wordpress
$url = wp_login_url($returnUrl);
// append action=login
$url .= (strpos($url, '?') !== false ? '&' : '?') . 'action=login';

?>
<form action="<?php echo $url; ?>" method="post">
	<h3><?php echo JText::translate('VRLOGINTITLE'); ?></h3>
	
	<div class="vrloginfieldsdiv">
		
		<?php
		/**
		 * Display the login form through the native WordPress function.
		 * 
		 * @since 1.3
		 */
		wp_login_form([
			'echo'           => true,
			'redirect'       => $returnUrl ? VREFactory::getPlatform()->getUri()->route($returnUrl) : null,
			'form_id'        => 'loginform',
			'label_username' => __('Username or Email Address'),
			'label_password' => __('Password' ),
			'label_remember' => __('Remember Me' ),
			'label_log_in'   => __('Log In'),
			'id_username'    => 'user_login',
			'id_password'    => 'user_pass',
			'id_remember'    => 'rememberme',
			'id_submit'      => 'wp-submit',
			'remember'       => true,
			'value_username' => '',
			'value_remember' => $remember,
		]);
		?>

	</div>

	<?php if ($footerLinks): ?>
		<div class="vr-login-footer-links">
			<div>
				<a href="<?php echo wp_lostpassword_url(); ?>" target="_blank">
					<?php echo JText::translate('COM_USERS_LOGIN_RESET'); ?>
				</a>
			</div>
		</div>
	<?php endif; ?>

	<?php echo JHtml::fetch('form.token'); ?>
</form>
