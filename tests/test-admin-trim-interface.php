<?php

defined( 'ABSPATH' ) or die();

class Admin_Trim_Interface_Test extends WP_UnitTestCase {

	protected $obj;

	public static function setUpBeforeClass() {
		c2c_AdminTrimInterface::get_instance()->install();
	}

	public function setUp() {
		parent::setUp();

		$this->obj = c2c_AdminTrimInterface::get_instance();

		$this->obj->reset_options();
	}

	public function tearDown() {
		parent::tearDown();

		// Reset options
		$this->obj->reset_options();
	}


	//
	//
	// DATA PROVIDERS
	//
	//

	public static function get_default_hooks() {
		return array(
			array( 'action', 'admin_init',            'admin_init',            10 ),
			array( 'action', '_network_admin_menu',   'hide_dashboard',        10 ),
			array( 'action', '_user_admin_menu',      'hide_dashboard',        10 ),
			array( 'action', '_admin_menu',           'hide_dashboard',        10 ),
			array( 'action', 'admin_enqueue_scripts', 'add_css',               10 ),
			array( 'action', 'wp_enqueue_scripts',    'add_css',               10 ),
			array( 'filter', 'admin_bar_menu',        'admin_bar_menu',        5 ),
			array( 'action', 'admin_head',            'hide_help_tabs',        10 ),
			array( 'action', 'admin_notices',         'show_admin_notices',    10 ),
			array( 'filter', 'explain_nonce_'.c2c_AdminTrimInterface::get_instance()->nonce_field, 'explain_nonce', 10 ),
			// TODO: Use ::get_hook() when plugin base clase makes method public.
			array( 'action', 'admin_trim_interface__custom_display_option', 'show_legend_image', 10 ),
		);
	}

	public static function get_settings_and_defaults() {
		return array(
			array( 'hide_wp_logo' ),
			array( 'hide_home_icon' ),
			array( 'hide_howdy' ),
			array( 'hide_username' ),
			array( 'hide_avatar' ),
			array( 'hide_dashboard' ),
			array( 'hide_help' ),
			array( 'hide_footer_left' ),
			array( 'hide_footer_version' ),
		);
	}


	//
	//
	// HELPER FUNCTIONS
	//
	//


	protected function set_option( $settings = array() ) {
		$defaults = $this->obj->get_options();
		$settings = wp_parse_args( (array) $settings, $defaults );
		$this->obj->update_option( $settings, true );
	}


	//
	//
	// TESTS
	//
	//


	public function test_class_exists() {
		$this->assertTrue( class_exists( 'c2c_AdminTrimInterface' ) );
	}

	public function test_plugin_framework_class_name() {
		$this->assertTrue( class_exists( 'c2c_AdminTrimInterface_Plugin_050' ) );
	}

	public function test_plugin_framework_version() {
		$this->assertEquals( '050', $this->obj->c2c_plugin_version() );
	}

	public function test_get_version() {
		$this->assertEquals( '3.3.1', $this->obj->version() );
	}

	public function test_instance_object_is_returned() {
		$this->assertTrue( is_a( $this->obj, 'c2c_AdminTrimInterface' ) );
	}

	public function test_hooks_plugins_loaded() {
		$this->assertEquals( 10, has_action( 'plugins_loaded', array( 'c2c_AdminTrimInterface', 'get_instance' ) ) );
	}

	/**
	 * @dataProvider get_default_hooks
	 */
	public function test_default_hooks( $hook_type, $hook, $function, $priority = 10, $class_method = true ) {
		$callback = $class_method ? array( $this->obj, $function ) : $function;

		$prio = $hook_type === 'action' ?
			has_action( $hook, $callback ) :
			has_filter( $hook, $callback );

		$this->assertNotFalse( $prio );
		if ( $priority ) {
			$this->assertEquals( $priority, $prio );
		}
	}

	public function test_setting_name() {
		$this->assertEquals( 'c2c_admin_trim_interface', c2c_AdminTrimInterface::SETTING_NAME );
	}

	/**
	 * @dataProvider get_settings_and_defaults
	 */
	public function test_default_settings( $setting ) {
		$options = $this->obj->get_options();

		$this->assertFalse( $options[ $setting ] );
	}

	/*
	 * admin_init()
	 */

	public function test_admin_init_hooks_admin_footer_text() {
		$this->obj->update_option( array( 'hide_footer_left' => true ) );

		$this->assertFalse( has_filter( 'admin_footer_text', '__return_false' ) );

		$this->obj->admin_init();

		$this->assertEquals( 10, has_filter( 'admin_footer_text', '__return_false' ) );
	}

	public function test_admin_init_hooks_update_footer() {
		$this->obj->update_option( array( 'hide_footer_version' => true ) );

		$this->assertEquals( 10, has_filter( 'update_footer', 'core_update_footer' ) );

		$this->obj->admin_init();

		$this->assertFalse( has_filter( 'update_footer', 'core_update_footer' ) );
	}

	/*
	 * show_admin_notices()
	 */

	public function test_show_admin_notices_does_not_show_when_not_on_settings_page() {
		add_settings_error( 'foo', 'bar', 'Capital P dangit!', 'error' );
		$path = 'themes.php?page=admin-trim-interface%2Fadmin-trim-interface.php';
		set_current_screen( $path );

		$this->expectOutputRegex( '~^$~', $this->obj->show_admin_notices() );
	}

	public function test_show_admin_notices_shows_when_not_on_settings_page() {
		add_settings_error( 'foo', 'bar', 'Capital P dangit!', 'error' );

		set_current_screen( 'themes.php?page=admin-trim-interface%2Fadmin-trim-interface.php' );
		$this->obj->options_page = 'themesphppageadmin-trim-interface2fadmin-trim-interface';

		$expected = "<div id='setting-error-bar' class='notice notice-error settings-error is-dismissible'> \n<p><strong>Capital P dangit!</strong></p></div> \n<div id='setting-error-bar' class='notice notice-error settings-error is-dismissible'> \n<p><strong>Capital P dangit!</strong></p></div> \n";

		$this->expectOutputRegex( '~^' . preg_quote( $expected ) . '$~', $this->obj->show_admin_notices() );
	}

	/*
	 * Setting handling
	 */

	public function test_does_not_immediately_store_default_settings_in_db() {
		$option_name = c2c_AdminTrimInterface::SETTING_NAME;
		// Get the options just to see if they may get saved.
		$options     = $this->obj->get_options();

		$this->assertFalse( get_option( $option_name ) );
	}

	public function test_uninstall_deletes_option() {
		$option_name = c2c_AdminTrimInterface::SETTING_NAME;
		$options     = $this->obj->get_options();

		// Explicitly set an option to ensure options get saved to the database.
		$this->set_option( array( 'hide_wp_logo' => true ) );

		$this->assertNotEmpty( $options );
		$this->assertNotFalse( get_option( $option_name ) );

		c2c_AdminTrimInterface::uninstall();

		$this->assertFalse( get_option( $option_name ) );
	}

}
