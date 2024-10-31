<?php
/**
 * Has all the function for check the status of the setup and for create the
 * Setup table.
 */

include 'optimus_price_user.php';

function optpr_is_wp_version_correct() {
	global $wp_version;
	if ( version_compare( $wp_version, '4.4', '>=' ) ) {
		return True;
	}
  return False;
}

function optpr_is_wc_plugin_active() {
	if ( class_exists( 'WooCommerce' ) ) {
		return True;
  }
  return False;
}

function optpr_is_wc_version_correct() {
	if ( is_wc_plugin_active ) {
		global $woocommerce;
		if( version_compare( $woocommerce->version, '3.0', ">=" ) ) {
			return True;
		}
	}
  return False;
}

function optpr_is_permalink_correct() {
  if ( get_option('permalink_structure') ) {
    return True;
  }
  return False;
}

function optpr_is_wc_user_created() {
  global $optpr_wc_user_name, $optpr_wc_user_email;
  if ( username_exists( $optpr_wc_user_name ) && email_exists( $optpr_wc_user_email ) ) {
		return True;
	}
  return False;
}

function optpr_is_keys_created() {
  global $wpdb, $optpr_wc_user_name;
	$optpr_wp_user = get_userdatabylogin($optpr_wc_user_name);
	if ($optpr_wp_user) {
		$optpr_wc_user_id = $optpr_wp_user->ID;
		$optpr_wp_user_query_result = $wpdb->get_results(
			"SELECT * FROM wp_woocommerce_api_keys WHERE user_id = '$optpr_wc_user_id' AND permissions = 'read_write'"
		);
		if ( $optpr_wp_user_query_result ) {
			return True;
		}
	}
  return False;
}

function optpr_is_setup_complete() {
  if ( optpr_is_wp_version_correct() && optpr_is_wc_version_correct() && optpr_is_permalink_correct() && optpr_is_wc_user_created() && optpr_is_keys_created() ) {
    return True;
  }
  return False;
}

function optpr_setup_table() {
	if ( optpr_is_wp_version_correct() ) {
		$optpr_html_wp_version = '✅';
	}
	else {
		$optpr_html_wp_version = '❌';
	}

	if ( optpr_is_wc_plugin_active() && optpr_is_wc_version_correct() ) {
		$optpr_html_wc_version = '<td>✅</td>'
			.'<td></td>';
	}
	elseif ( optpr_is_wc_plugin_active() ) {
		$optpr_html_wc_version = '<td>❌</td>'
			.'<td>Update your WooCommerce to a version 3.0 or later</td>';
	}
	else {
		$optpr_html_wc_version = '<td>❌ '
			.'(Install and active WooCommerce plugin)</td>'
			.'<td>Install and active WooCommerce plugin</td>';
	}

	if ( optpr_is_permalink_correct() ) {
		$optpr_html_permalink = '<td>✅</td>'
			.'<td></td>';
	}
	else {
		$optpr_html_permalink = '<td>❌</td>'
			.'<td>Set permalink with any option except "Plain" in the Section '
			.'<b>Common Settings</b> in '
			.'<a href="options-permalink.php">Settings → Permalinks</a>'
			.'.</td>';
	}

	if ( optpr_is_wc_user_created() ) {
		$optpr_html_wc_user = '<td>✅</td>'
			.'<td></td>';
	}
	else {
		$optpr_html_wc_user = '<td>❌</td>'
		.'<td><p>With the following information: </p>'
		.'<p> - Username: "optimusprice"</br >'
		.' - Email: "support@optimusprice.ai"</br >'
		.' - First Name: "Optimus"</br >'
		.' - Last Name: "Price"</br >'
		.' - Website: "https://optimusprice.ai"</br >'
		.' - Send User Notification: "Disable"</br >'
		.' - Role: "Shop manager"</p>'
		.'<p>Create a new user in '
		.'<a href="user-new.php">'
		.'Users → Add New</a>.</p></td>';
	}

	if ( optpr_is_keys_created() ) {
		$optpr_html_wc_keys = '<td>✅</td>'
			.'<td></td>';
	}
	else {
		$optpr_html_wc_keys = '<td>❌</td>'
			.'<td><p><b>⚠ Important! At the end of this configuration, copy the '
			.'consumer key and secret key in a safe place for use after in the '
			.'integration with Optimus Price.</b></p>'
			.'<p>With the following information: </p>'
			.'<p> - Description: "Optimus Price"</br >'
			.' - User: "Optimus Price"</br >'
			.' - Permissions: "Read/Write"</p>'
			.'Create new keys in '
			.'<a href="?page=wc-settings&tab=advanced&section=keys&create-key=1">'
			.'WooCommerce → Settings → Advanced → REST API → Add key</a>.</p></td>';
	}

	?>
		<div class="wrap">
			<h2>Setup</h2>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th width="30%">Setup</th>
						<th width="10%">Status</th>
						<th width="60%">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>WordPress version 4.4 or later</td>
						<td>
							<?php
							echo $optpr_html_wp_version;
							?>
						</td>
						<td></td>
					</tr>
					<tr>
						<td>WooCommerce version 3.0 or later</td>
						<?php
						echo $optpr_html_wc_version;
						?>
					</tr>
					<tr>
						<td>Permalink</td>
						<?php
						echo $optpr_html_permalink;
						?>
					</tr>
  				<tr>
						<td>Create Optimus Price user in WordPress</td>
						<?php
						echo $optpr_html_wc_user;
						?>
					</tr>
  				<tr>
						<td>Optimus Price Keys</td>
						<?php
						echo $optpr_html_wc_keys;
						?>
					</tr>
  				<tr>
						<td>Optimus Price account</td>
						<td>❓</td>
						<td>You need to register in
							<a href="https://app.optimusprice.ai" target="_blank">Optimus Price</a>
						</td>
					</tr>
  				<tr>
						<td>Add Keys in Optimus Price </td>
						<td>❓</td>
						<td>You need to set WooCommerce and add the keys in your
							<a href="https://app.optimusprice.ai/integrations" target="_blank">
								Optimus Price account
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	<?php
}

?>
