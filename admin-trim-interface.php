<?php
/**
 * @package Admin_Trim_Interface
 * @author Scott Reilly
 * @version 2.1
 */
/*
Plugin Name: Admin Trim Interface
Version: 2.1
Plugin URI: http://coffee2code.com/wp-plugins/admin-trim-interface/
Author: Scott Reilly
Author URI: http://coffee2code.com
Text Domain: admin-trim-interface
Description: Customize the WordPress admin pages by selectively removing interface elements.

Compatible with WordPress 3.0+, 3.1+, 3.2+.

=>> Read the accompanying readme.txt file for instructions and documentation.
=>> Also, visit the plugin's homepage for additional information and updates.
=>> Or visit: http://wordpress.org/extend/plugins/admin-trim-interface/

TODO:
	* Remove pre-WP3.0 specific code (to include Hide visit sitelink and hide turbo options)

*/

/*
Copyright (c) 2009-2011 by Scott Reilly (aka coffee2code)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

if ( is_admin() && ! class_exists( 'c2c_AdminTrimInterface' ) ) :

require_once( 'c2c-plugin.php' );

class c2c_AdminTrimInterface extends C2C_Plugin_024 {

	public static $instance;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->c2c_AdminTrimInterface();
	}

	public function c2c_AdminTrimInterface() {
		// Be a singleton
		if ( ! is_null( self::$instance ) )
			return;

		$this->C2C_Plugin_024( '2.1', 'admin-trim-interface', 'c2c', __FILE__, array( 'settings_page' => 'themes' ) );
		register_activation_hook( __FILE__, array( __CLASS__, 'activation' ) );
		self::$instance = $this;
	}

	/**
	 * Handles activation tasks, such as registering the uninstall hook.
	 *
	 * @since 2.1
	 *
	 * @return void
	 */
	public function activation() {
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
	}

	/**
	 * Handles uninstallation tasks, such as deleting plugin options.
	 *
	 * This can be overridden.
	 *
	 * @since 2.0
	 *
	 * @return void
	 */
	public function uninstall() {
		delete_option( 'c2c_admin_trim_interface' );
	}

	/**
	 * Initializes the plugin's configuration and localizable text variables.
	 *
	 * @return void
	 */
	public function load_config() {
		$this->name      = __( 'Admin Trim Interface', $this->textdomain );
		$this->menu_name = __( 'Admin Trim Interface', $this->textdomain );

		$this->config = array(
			'hide_wp_logo' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide WordPress logo in header?', $this->textdomain ) ),
			'hide_visit_site_link' => array( 'input' => 'checkbox', 'default' => false, 'wplt' => '3.0', 'numbered' => true,
					'label' => __( 'Hide "Visit site" link?', $this->textdomain ) ),
			'hide_search_engines_blocked' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'wpgte' => '3.0', 'wplt' => '3.2',
					'label' => __( 'Hide "Search Engines Blocked" link?', $this->textdomain ) ),
			'hide_favorite_actions' => array( 'input' => 'checkbox', 'default' => false, 'wplt' => '3.2', 'numbered' => true,
					'label' => __( 'Hide favorite actions shortcuts?', $this->textdomain ) ),
			'hide_howdy' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide "Howdy"?', $this->textdomain ) ),
			'hide_username' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide username profile link?', $this->textdomain ) ),
			'hide_turbo_link' => array( 'input' => 'checkbox', 'default' => false, 'wplt' => '3.0', 'numbered' => true,
					'label' => __( 'Hide "Turbo" link?', $this->textdomain ) ),
			'hide_dashboard' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide Dashboard menu link?', $this->textdomain ) ),
			'hide_page_heading_icon' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide page heading icon?', $this->textdomain ) ),
			'hide_help' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide contextual "Help" link?', $this->textdomain ) ),
			'hide_footer_left' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide footer links?', $this->textdomain ) ),
			'hide_footer_version' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide WordPress version in footer?', $this->textdomain ) )
		);
	}

	/**
	 * Override the plugin framework's register_filters() to actually actions against filters.
	 *
	 * @return void
	 */
	public function register_filters() {
		add_action( '_network_admin_menu',                     array( &$this, 'hide_dashboard' ) );
		add_action( '_user_admin_menu',                        array( &$this, 'hide_dashboard' ) );
		add_action( '_admin_menu',                             array( &$this, 'hide_dashboard' ) );
		add_action( 'admin_init',                              array( &$this, 'admin_init' ) );
		add_action( 'admin_head',                              array( &$this, 'add_admin_css' ) );
		add_action( 'admin_print_footer_scripts',              array( &$this, 'add_admin_js' ) );
		add_filter( 'admin_user_info_links',                   array( &$this, 'admin_user_info_links' ) );
		add_filter( 'explain_nonce_'.$this->nonce_field,       array( &$this, 'explain_nonce' ) );
		add_action( $this->get_hook( 'before_settings_form' ), array( &$this, 'show_legend_image' ) );
	}

	/**
	 * Remove call to core_update_footer filter
	 *
	 * @since 2.1
	 */
	public function admin_init() {
		$options = $this->get_options();
		if ( $options['hide_footer_left'] )
			add_filter( 'admin_footer_text', '__return_false' );
		if ( $options['hide_footer_version'] )
			remove_filter( 'update_footer', 'core_update_footer' );
		if ( $options['hide_howdy'] )
			add_filter( 'gettext', array( &$this, 'remove_howdy' ), 10, 3 );
	}

	/**
	 * Removes "Howdy, "
	 *
	 * @since 2.1
	 *
	 * @param $translation The translation of the original string
	 * @param $text string The original string
	 * @param $domain string The language domain
	 * @return string The translated string
	 */
	function remove_howdy( $translation, $text, $domain ) {
		if ( $text == 'Howdy, %1$s' )
			return '%1$s';
		return $translation;
	}

	/**
	 * Hides the dashboard menu link
	 *
	 * @since 2.1
	 */
	function hide_dashboard() {
		global $menu, $submenu;
		$options = $this->get_options();
		if ( $options['hide_dashboard'] ) {
			if ( function_exists( 'remove_menu_page' ) ) { // WP 3.1+
				remove_menu_page( 'index.php' );
				remove_menu_page( 'separator1' );
			} else {
				unset( $menu[2] );
				unset( $submenu[ 'index.php' ][0] );
				unset( $menu[4] );
			}
		}
	}

	/**
	 * Remove links top right of admin header
	 *
	 * @since 2.1
	 *
	 * @param array $links The links in admin header
	 * @param array The potentially modified links
	 */
	public function admin_user_info_links( $links ) {
		$options = $this->get_options();
		if ( $options['hide_username'] && $options['hide_howdy'] )
			unset( $links[5] );
		return $links;
	}

	/**
	 * Output message if nonce has expired.
	 *
	 * @param string $msg The message WordPress would have shown
	 * @return string The error message
	 */
	public function explain_nonce( $msg ) {
		return __( 'Unable to perform action: Your WordPress session has expired.  Please login and try again.' );
	}

	/**
	 * Outputs admin CSS
	 *
	 * @return void (Text is echoed.)
	 */
	public function add_admin_css() {
		$options = $this->get_options();

		$css = array();

		if ( $options['hide_wp_logo'] )
			$css[] = '#header-logo';
		if ( $this->is_option_valid( 'hide_visit_site_link' ) && $options['hide_visit_site_link'] )
			$css[] = '#wphead h1 a span, #wphead #site-visit-button'; // In WP2.8+ this just needs to be: #wphead #site-visit-button
		if ( $this->is_option_valid( 'hide_search_engines_blocked' ) && $options['hide_search_engines_blocked'] )
			$css[] = '#privacy-on-link'; // For WP3.0+ the site link was replaced by the search enginges blocked link
		if ( $options['hide_favorite_actions'] )
			$css[] = '#favorite-actions';
		if ( $options['hide_help'] )
			$css[] = '#contextual-help-link-wrap'; // This is just for < WP2.8, since 2.8 modifies this via JS
		if ( $options['hide_page_heading_icon'] )
			$css[] = '#icon-index, .icon32';
		if ( $options['hide_username'] )
			$css[] = '#user_info p > a[href=\'profile.php\']';

		// Hack
		$extra_css = '#wphead #site-title { display:inline; }';

		if ( ! empty( $css ) ) {
			$css = implode( ', ', $css );
			echo <<<CSS
		<style type="text/css">
		{$css} { display:none; }
		{$extra_css}
		</style>

CSS;
		}
	}

	/**
	 * Outputs admin JavaScript
	 *
	 * @return void (Text is echoed.)
	 */
	public function add_admin_js() {
		$options = $this->get_options();

		$do_turbo = $this->is_option_valid( 'hide_turbo_link' );  // pre WP 3.0

		$js = array();

		if ( $options['hide_dashboard'] )
			$js[] = "\$('.wp-menu-separator:first').remove();";

		if ( $do_turbo && $options['hide_turbo_link'] )
			$js[] = "\$('.turbo-nag').remove();";

		if ( $options['hide_help'] )
			$js[] = "\$('#contextual-help-link-wrap').remove();";

		if ( $do_turbo && $options['hide_howdy'] && $options['hide_username'] )
			$js[] = "\$('.turbo-nag').html(\$('.turbo-nag a'))";

		if ( $do_turbo ) { // Pre WP 3.0
			if ( ( !$options['hide_username'] && ( $options['hide_turbo_link'] && $options['hide_howdy'] ) ) ||
				 ( $options['hide_howdy'] && ( !$options['hide_turbo_link'] || !$options['hide_username'] ) ) )
				$js[] = "\$('#user_info p a:last').before(' | ');";
		} else {
			if ( !$options['hide_username'] && $options['hide_howdy'] )
				$js[] = "\$('#user_info p a:last').before(' | ');";
		}
		
		if ( ! empty( $js ) ) {
			$js = implode( "\n", $js );
			echo <<<JS
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			{$js}
		});
		</script>

JS;
		}
	}

	/**
	 * Outputs the text above the setting form
	 *
	 * @return void (Text will be echoed.)
	 */
	public function options_page_description() {
		$options = $this->get_options();
		parent::options_page_description( __( 'Admin Trim Interface Settings', $this->textdomain ) );
		echo '<p>' . __( 'Use the image at the right to correlate the settings below with the admin interface element they hide.', $this->textdomain ) . '</p>';
		echo '<p>' . __( 'Note: These settings are global and will affect all users who are able to visit the admin pages.', $this->textdomain ) . '</p>';
	}

	/**
	 * Outputs the image that demonstrates the sections of the site that admin that correspond to the various settings.
	 */
	public function show_legend_image() {
		global $wp_version;
		$image = version_compare( $wp_version, '3.2' ) < 0 ? 'screenshot-2.png' : 'screenshot-1.png';
		$link = plugins_url( basename( $_GET['page'], '.php' ) . '/' . $image );
		echo "<a href='$link' title='settings to admin interface mapping; click to view full size' style='position:absolute;left:450px;'>";
		echo "<img src='$link' width='450' alt='settings to admin interface mapping' />";
		echo '<br /><center><em>' . __( 'Click to view full size.', $this->textdomain ) . '</em></center></a>';
	}
} // end c2c_AdminTrimInterface


// NOTICE: The 'c2c_admin_trim_interface' global is deprecated and will be removed in the plugin's version 2.2.
// Instead, use: c2c_AdminTrimInterface::$instance
$GLOBALS['c2c_admin_trim_interface'] = new c2c_AdminTrimInterface();

endif; // end if !class_exists()

?>