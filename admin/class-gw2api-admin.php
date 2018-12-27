<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       nope
 * @since      1.0.0
 *
 * @package    Gw2api
 * @subpackage Gw2api/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gw2api
 * @subpackage Gw2api/admin
 * @author     Tiny Taimi <nope>
 */
class Gw2api_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since	1.0.0
	 * @access	private
	 * @var		string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since	1.0.0
	 * @access	private
	 * @var		string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The GW2Api 
	 * 
	 * @since 1.0.0
	 * @access	private
	 * @var		GW2Api	$api	The GW2API instance of the plugin
	 */
	private $api;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since	1.0.0
	 * @param	string    $plugin_name       The name of this plugin.
	 * @param	string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $api ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->api = $api;

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since	1.0.0
	 */
	public function add_plugin_admin_menu() {
		add_options_page( 'GW2 API Settings', 'GW2 API', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since	1.0.0
	 */
	public function add_action_links( $links ) {
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
		);
		return array_merge( $settings_link, $links );
	}

	/**
	 * Init the settings for the plugin
	 * 
	 * @since	1.0.0
	 */
	public function register_setting() {

		// Add a General section
		add_settings_section(
			$this->plugin_name . '_general',
			__( 'General', $this->plugin_name ),
			array( $this, $this->plugin_name . '_general_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->plugin_name . '_key',
			__( 'GW2 API Key', $this->plugin_name ),
			array( $this, $this->plugin_name . '_key_cb' ),
			$this->plugin_name,
			$this->plugin_name . '_general',
			array( 'label_for' => $this->plugin_name . '_key' )
		);

		register_setting( $this->plugin_name, $this->plugin_name . '_key', array( $this, $this->plugin_name . '_validate_key' ) );
	}

	/**
	 * Validate GW2 API key
	 * 
	 * @since	1.0.0
	 */
	public function gw2api_validate_key( $key ) {
		# key format XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXXXXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX
		$format = '/[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{20}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}/';
		
		if( empty( $key ) || preg_match( $format, $key ) ) {
			return sanitize_text_field( $key );
		} else {
			add_settings_error(
				$this->plugin_name . '_key',
				'validationError',
				'Invalid API key',
				'error'
			);
		}

	}

	/**
	 * Render the text for the general section
	 *
	 * @since	1.0.0
	 */
	public function gw2api_general_cb() {
		?>
		<p>API key should be guild leader's.<br>
		Create your key <a href="https://account.arena.net/applications/create" target="_blank">here</a></p>
		<?php
	}

	/**
	 * Render the API key input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function gw2api_key_cb() {
		$key = get_option( $this->plugin_name . '_key' );
		echo "<input type=\"text\" name=\"{$this->plugin_name}_key\" value=\"{$key}\" id=\"{$this->plugin_name}_key\" class=\"regular-text\" placeholder=\"XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXXXXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX\">";
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since	1.0.0
	 */
	public function display_plugin_setup_page() {
		include_once( 'partials/gw2api-admin-display.php' );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since	1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gw2api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gw2api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gw2api-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since	1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gw2api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gw2api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gw2api-admin.js', array( 'jquery' ), $this->version, false );

	}

}
