<?php
/*
Plugin Name: Optimus Price
Description: Optimus Price automate pricing using Artificial Intelligence. It maximizes profit for your existing products.
Author: <a href="https://optimusprice.ai">Optimus Price</a>
Version: 1.0

License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

$optpr_slug = 'optimus-price';

// This declaration is in create_optimus_price_user and
// delete_optimus_price_user functions also because in the hooks, doesn't works.
// If changes, you need to chenge in all places.
$optpr_wc_user_name = 'optimusprice';
$optpr_wc_user_email = 'support@optimusprice.ai';

include 'helpers/optimus_price_icon.php';
include 'helpers/optimus_price_setup.php';
include 'helpers/optimus_price_style.php';

add_action('admin_menu', 'optpr_setup_menu');
add_action('admin_head', 'optpr_style');

function optpr_setup_menu(){
	global $optpr_slug, $optpr_icon;

	add_menu_page(
		'Optimus Price',
		'Optimus Price',
		'manage_options',
		$optpr_slug,
		'optpr_init',
		$optpr_icon
	);
}

function optpr_init(){
	// TITLE
	echo '<div id=col-container" class="wp-clearfix">';
	echo '<div class="wrap">';
	echo '<h1 class="op-title">Optimus Price Setup</h1>';
	echo '</div>';

	// LEFT COLUMN
	echo '<div id="col-left" style="width: 50%;">';
	// Status panel
	echo '<div class="wrap">';
	echo '<h2>Status</h2>';
	if ( optpr_is_setup_complete() ) {
		echo '<div class="op-panel op-panel-ok">';
		echo '<p>Completed</p>';
	}
	else {
		echo '<div class="op-panel op-panel-warning">';
		echo '<p>Incompleted</p>';
	}
	echo '</div>';
	echo '</div>';
	optpr_setup_table();
	echo '</div>';

	// RIGHT PANEL
	echo '<div id="col-right" style="width: 50%;">';
	// About Optimus Price
	echo '<div class="wrap">';
	echo '<h2>Welcome to Optimus Price!</h2>';
	echo '<p>Optimus Price is a tool that uses AI to automate pricing. '
		.'It maximizes profit for your existing products '
		.'(i.e. sale price minus costs).</p>';

	echo '<p>In order to use this tool you need to register in '
		.'<a href="https://app.optimusprice.ai" target="_blank">Optimus Price</a>.'
		.'</p>';
	echo '<p>Once you have activated your e-commerce in our system, '
		.'Optimus Price will be able to give you price recommendations for '
		.'your products. For more insights about Optimus Price, please visit '
		.'our <a href="https://support.optimusprice.ai" target="_blank">'
		.'help center</a>.';
	echo '</div>';
	echo '</div>';
	echo '</div>';
}
?>
