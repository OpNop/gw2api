<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Gw2api
 * @subpackage Gw2api/admin/partials
 */

$permissions = array(
	'account'		=> ['name' => 'Account',		'enabled' => 'no'],
	'inventories'	=> ['name' => 'Inventories',	'enabled' => 'no'],
	'characters'	=> ['name' => 'Characters',		'enabled' => 'no'],
	'tradingpost'	=> ['name' => 'Tradingpost',	'enabled' => 'no'],
	'wallet'		=> ['name' => 'Wallet',			'enabled' => 'no'],
	'unlocks'		=> ['name' => 'Unlocks',		'enabled' => 'no'],
	'pvp'			=> ['name' => 'PvP',			'enabled' => 'no'],
	'builds'		=> ['name' => 'Builds',			'enabled' => 'no'],
	'progression'	=> ['name' => 'Progression',	'enabled' => 'no'],
	'guilds'		=> ['name' => 'Guilds',			'enabled' => 'no'],
);
$key = get_option( $this->plugin_name . '_key' );
if( empty( $key ) ){
	$data = "API Key Required";
} else {
	$data = "Key Permissions<br>";
	$key_data = $this->api->tokeninfo( $key )->get();
	// Todo: get this to 1 loop
	foreach ($key_data->permissions as $permmision) {
		$permissions[$permmision]['enabled'] = 'yes';
	}
	foreach ($permissions as $key => $permission) {
		$data .= '<span class="dashicons dashicons-' . $permission['enabled'] . '"></span>' . $permission['name'] . '<br>';
	}
}

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<form action="options.php" method="post">
		<?php
			settings_fields( $this->plugin_name );
			do_settings_sections( $this->plugin_name );
			submit_button();
		?>
	</form>
	<hr />
	<h1>Test API output</h1>
	<table class="form-table">
		<tr>
			<th scope="row">
				Public Test
			</th>
			<td>
				Game Build: <?php echo $this->api->build()->get(); ?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				Authenticated Test
			</th>
			<td>
				<?php echo $data; ?>
			</td>
		</tr>
	</table>
</div>