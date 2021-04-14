<?php
/**
 * Plugin Name: Admin Trim Interface
 * Version:     3.5.1
 * Plugin URI:  https://coffee2code.com/wp-plugins/admin-trim-interface/
 * Author:      Scott Reilly
 * Author URI:  https://coffee2code.com/
 * Text Domain: admin-trim-interface
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: Customize the WordPress admin pages by selectively removing interface elements on a per-user basis.
 *
 * Compatible with WordPress 4.9 through 5.7+.
 *
 * =>> Read the accompanying readme.txt file for instructions and documentation.
 * =>> Also, visit the plugin's homepage for additional information and updates.
 * =>> Or visit: https://wordpress.org/plugins/admin-trim-interface/
 *
 * @package Admin_Trim_Interface
 * @author  Scott Reilly
 * @version 3.5.1
 */

/*
	Copyright (c) 2009-2021 by Scott Reilly (aka coffee2code)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'c2c_AdminTrimInterface' ) ) :

require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'c2c-plugin.php' );

final class c2c_AdminTrimInterface extends c2c_Plugin_061 {

	/**
	 * Name of plugin's setting.
	 *
	 * @since 3.2
	 * @var string
	 */
	const SETTING_NAME = 'c2c_admin_trim_interface';

	/**
	 * The one true instance.
	 *
	 * @var c2c_AdminTrimInterface
	 */
	private static $instance;

	/**
	 * Get singleton instance.
	 *
	 * @since 3.0
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 */
	protected function __construct() {
		parent::__construct( '3.5.1', 'admin-trim-interface', 'c2c', __FILE__, array( 'settings_page' => 'themes' ) );
		register_activation_hook( __FILE__, array( __CLASS__, 'activation' ) );
		self::$instance = $this;
	}

	/**
	 * Handles activation tasks, such as registering the uninstall hook.
	 *
	 * @since 2.1
	 */
	public static function activation() {
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
	}

	/**
	 * Handles uninstallation tasks, such as deleting plugin options.
	 *
	 * This can be overridden.
	 *
	 * @since 2.0
	 */
	public static function uninstall() {
		delete_option( self::SETTING_NAME );
	}

	/**
	 * Initializes the plugin's configuration and localizable text variables.
	 */
	public function load_config() {
		$this->name      = __( 'Admin Trim Interface', 'admin-trim-interface' );
		$this->menu_name = $this->name;

		$this->config = array(
			'legend_image' => array(
				'input'    => 'custom',
			),
			'hide_wp_logo' => array(
				'input'    => 'checkbox',
				'default'  => false,
				'numbered' => true,
				'label'    => __( 'Hide WordPress logo in admin bar?', 'admin-trim-interface' ),
			),
			'hide_site_icon' => array(
				'input'    => 'checkbox',
				'default'  => false,
				'numbered' => true,
				'label'    => __( 'Hide sites icon in admin bar?', 'admin-trim-interface' ),
			),
			'hide_home_icon' => array(
				'input'    => 'checkbox',
				'default'  => false,
				'numbered' => true,
				'label'    => __( 'Hide home icon in admin bar?', 'admin-trim-interface' ),
			),
			'hide_howdy' => array(
				'input'    => 'checkbox',
				'default'  => false,
				'numbered' => true,
				'label'    => __( 'Hide "Howdy"?', 'admin-trim-interface' ),
			),
			'hide_username' => array(
				'input'    => 'checkbox',
				'default'  => false,
				'numbered' => true,
				'label'    => __( 'Hide username in admin bar?', 'admin-trim-interface' ),
			),
			'hide_avatar' => array(
				'input'    => 'checkbox',
				'default'  => false,
				'wpgte'    => '3.2.99',
				'numbered' => true,
				'label'    => __( 'Hide user avatar in admin bar?', 'admin-trim-interface' ),
			),
			'hide_dashboard' => array(
				'input'    => 'checkbox',
				'default'  => false,
				'numbered' => true,
				'label'    => __( 'Hide Dashboard menu link?', 'admin-trim-interface' ),
			),
			'hide_help' => array(
				'input'    => 'checkbox',
				'default'  => false,
				'numbered' => true,
				'label'    => __( 'Hide contextual "Help" link?', 'admin-trim-interface' ),
			),
			'hide_footer_left' => array(
				'input'    => 'checkbox',
				'default'  => false,
				'numbered' => true,
				'label'    => __( 'Hide footer links?', 'admin-trim-interface' ),
			),
			'hide_footer_version' => array(
				'input'    => 'checkbox',
				'default'  => false,
				'numbered' => true,
				'label'    => __( 'Hide WordPress version in footer?', 'admin-trim-interface' ),
			),
		);
	}

	/**
	 * Returns translated strings used by c2c_Plugin parent class.
	 *
	 * @since 3.5
	 *
	 * @param string $string Optional. The string whose translation should be
	 *                       returned, or an empty string to return all strings.
	 *                       Default ''.
	 * @return string|string[] The translated string, or if a string was provided
	 *                         but a translation was not found then the original
	 *                         string, or an array of all strings if $string is ''.
	 */
	public function get_c2c_string( $string = '' ) {
		$strings = array(
			'A value is required for: "%s"'
				/* translators: %s: Label for setting. */
				=> __( 'A value is required for: "%s"', 'admin-trim-interface' ),
			'Click for more help on this plugin'
				=> __( 'Click for more help on this plugin', 'admin-trim-interface' ),
			' (especially check out the "Other Notes" tab, if present)'
				=> __( ' (especially check out the "Other Notes" tab, if present)', 'admin-trim-interface' ),
			'Coffee fuels my coding.'
				=> __( 'Coffee fuels my coding.', 'admin-trim-interface' ),
			'Did you find this plugin useful?'
				=> __( 'Did you find this plugin useful?', 'admin-trim-interface' ),
			'Donate'
				=> __( 'Donate', 'admin-trim-interface' ),
			'Expected integer value for: %s'
				=> __( 'Expected integer value for: %s', 'admin-trim-interface' ),
			'Invalid file specified for C2C_Plugin: %s'
				/* translators: %s: Path to the plugin file. */
				=> __( 'Invalid file specified for C2C_Plugin: %s', 'admin-trim-interface' ),
			'More information about %1$s %2$s'
				/* translators: 1: plugin name 2: plugin version */
				=> __( 'More information about %1$s %2$s', 'admin-trim-interface' ),
			'More Help'
				=> __( 'More Help', 'admin-trim-interface' ),
			'More Plugin Help'
				=> __( 'More Plugin Help', 'admin-trim-interface' ),
			'Please consider a donation'
				=> __( 'Please consider a donation', 'admin-trim-interface' ),
			'Reset Settings'
				=> __( 'Reset Settings', 'admin-trim-interface' ),
			'Save Changes'
				=> __( 'Save Changes', 'admin-trim-interface' ),
			'See the "Help" link to the top-right of the page for more help.'
				=> __( 'See the "Help" link to the top-right of the page for more help.', 'admin-trim-interface' ),
			'Settings'
				=> __( 'Settings', 'admin-trim-interface' ),
			'Settings reset.'
				=> __( 'Settings reset.', 'admin-trim-interface' ),
			'Something went wrong.'
				=> __( 'Something went wrong.', 'admin-trim-interface' ),
			'The plugin author homepage.'
				=> __( 'The plugin author homepage.', 'admin-trim-interface' ),
			"The plugin configuration option '%s' must be supplied."
				/* translators: %s: The setting configuration key name. */
				=>__( "The plugin configuration option '%s' must be supplied.", 'admin-trim-interface' ),
			'This plugin brought to you by %s.'
				/* translators: %s: Link to plugin author's homepage. */
				=> __( 'This plugin brought to you by %s.', 'admin-trim-interface' ),
		);

		if ( ! $string ) {
			return array_values( $strings );
		}

		return ! empty( $strings[ $string ] ) ? $strings[ $string ] : $string;
	}

	/**
	 * Override the plugin framework's register_filters() to actually actions against filters.
	 */
	public function register_filters() {
		add_action( '_network_admin_menu',                     array( $this, 'hide_dashboard' ) );
		add_action( '_user_admin_menu',                        array( $this, 'hide_dashboard' ) );
		add_action( '_admin_menu',                             array( $this, 'hide_dashboard' ) );
		add_action( 'admin_init',                              array( $this, 'admin_init' ) );
		add_action( 'admin_enqueue_scripts',                   array( $this, 'add_css' ) );
		add_action( 'wp_enqueue_scripts',                      array( $this, 'add_css' ) );
		add_filter( 'admin_bar_menu',                          array( $this, 'admin_bar_menu' ), 5 );
		add_action( 'admin_head',                              array( $this, 'hide_help_tabs' ) );
		add_action( 'admin_notices',                           array( $this, 'show_admin_notices' ) );
		add_filter( 'explain_nonce_'.$this->nonce_field,       array( $this, 'explain_nonce' ) );
		add_action( $this->get_hook( 'custom_display_option'), array( $this, 'show_legend_image' ) );
	}

	/**
	 * Remove call to core_update_footer filter.
	 *
	 * @since 2.1
	 */
	public function admin_init() {
		$options = $this->get_options();

		if ( $options['hide_footer_left'] ) {
			add_filter( 'admin_footer_text', '__return_false' );
		}

		if ( $options['hide_footer_version'] ) {
			remove_filter( 'update_footer', 'core_update_footer' );
		}
	}

	/**
	 * Shows settings admin notices.
	 *
	 * Settings notices are only shown for admin pages listed under Settings.
	 * This plugin has its settings page under Appearance.
	 *
	 * @since 3.2
	 */
	public function show_admin_notices() {
		// Bail if not on the plugin setting page.
		if ( $this->options_page !== get_current_screen()->id ) {
			return;
		}

		settings_errors();
	}

	/**
	 * Hides help tabs.
	 *
	 * @since 2.2
	 */
	public function hide_help_tabs() {
		$options = $this->get_options();

		if ( $options['hide_help'] ) {
			$screen = get_current_screen();
			$screen->remove_help_tabs();
		}
	}

	/**
	 * Hides the dashboard menu link.
	 *
	 * @since 2.1
	 */
	public function hide_dashboard() {
		global $menu, $submenu;
		$options = $this->get_options();

		if ( $options['hide_dashboard'] ) {
			remove_menu_page( 'index.php' );
			remove_menu_page( 'separator1' );
		}
	}

	/**
	 * Modify admin bar according to settings.
	 *
	 * Much of the node building is based on wp_admin_bar_my_account_item().
	 *
	 * @since 2.2
	 *
	 * @param obj $wp_admin_bar The admin bar.
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
		$options = $this->get_options();

		// Possibly hide the WP logo.
		if ( $options['hide_wp_logo'] ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 );
		}

		// Now determine if the user node needs removal/paring.

		$user_id = get_current_user_id();

		if ( ! $user_id ) {
			return;
		}

		$current_user = wp_get_current_user();
		$profile_url  = get_edit_profile_url( $user_id );

		// If any element in the my-account admin bar node is being hidden,
		// remove the whole thing and rebuild it
		if ( $options['hide_username'] || $options['hide_howdy'] || $options['hide_avatar'] ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_my_account_item', 7 );
		}

		// All done if everything in the my-account node is being hidden.
		if ( $options['hide_username'] && $options['hide_howdy'] && $options['hide_avatar'] ) {
			return;
		}

		/*
		 * The rest of this function is adapted from wp_admin_bar_my_account_item().
		 */

		$avatar = $options['hide_avatar'] ? '' : get_avatar( $user_id, 26 );
		if ( $options['hide_howdy'] ) {
			$howdy = $options['hide_username'] ? '' : $current_user->display_name;
		} else {
			$howdy = $options['hide_username'] ? __( 'Howdy', 'admin-trim-interface' ) : sprintf( __( 'Howdy, %s', 'admin-trim-interface' ), $current_user->display_name );
		}

		$class = $avatar ? 'with-avatar' : '';

		$wp_admin_bar->add_menu( array(
			'id'        => 'my-account',
			'parent'    => 'top-secondary',
			'title'     => $howdy . $avatar,
			'href'      => $profile_url,
			'meta'      => array(
				'class' => $class,
			),
		) );
	}

	/**
	 * Output message if nonce has expired.
	 *
	 * @param string  $msg The message WordPress would have shown.
	 * @return string The error message.
	 */
	public function explain_nonce( $msg ) {
		return __( 'Your session has expired. Please log in to continue where you left off.', 'admin-trim-interface' );
	}

	/**
	 * Outputs CSS.
	 *
	 * Runs for both front-end and admin areas of the site.
	 */
	public function add_css() {
		$options   = $this->get_options();
		$css       = array();
		$extra_css = array();

		// Don't bother outputting CSS related to admin bar if it isn't showing.
		if ( is_admin_bar_showing() ) {

			// Remove the sites icon from admin bar.
			if ( $options['hide_site_icon'] ) {
				$rule = is_admin() ? '.wp-admin #wpwrap' : 'body';
				$rule .= ' #wpadminbar #wp-admin-bar-my-sites > .ab-item::before { content: ""; }';
				$extra_css[] = $rule;
			}

			// Remove the home icon from admin bar.
			if ( $options['hide_home_icon'] ) {
				$rule = is_admin() ? '.wp-admin #wpwrap' : 'body';
				$rule .= ' #wpadminbar #wp-admin-bar-site-name > .ab-item::before { content: ""; }';
				$extra_css[] = $rule;
			}

			// Remove the user icon from admin bar.
			if ( $options['hide_avatar'] ) {
				$css[] = 'body #wp-admin-bar-user-info .avatar';
				$extra_css[] = 'body #wp-admin-bar-my-account > .ab-item::before { content: ""; }';
			}

		}

		// Style the legend image on the plugin's setting page.
		if ( is_admin() && ( $this->options_page === get_current_screen()->id ) ) {
			$extra_css[] = <<<CSS
.c2c-ati-image { position: absolute; left: 400px; }
	.appearance_page_admin-trim-interface-admin-trim-interface .form-table th { width: 300px; }
	.appearance_page_admin-trim-interface-admin-trim-interface .c2c-form .form-table tr:first-child { position: absolute; }
	@media screen and (max-width: 782px) {
		.appearance_page_admin-trim-interface-admin-trim-interface .c2c-form .form-table tr:first-child { position: initial; }
		.c2c-ati-image { position: initial; left: 0; }
	}
CSS;
		}

		if ( $css || $extra_css ) {
			$css = implode( ', ', $css );
			if ( $css ) {
				$css = "\t$css { display: none; }";
			}

			$extra_css = implode( "\n\t", $extra_css );
			if ( $extra_css ) {
				$extra_css = "\t" . rtrim( $extra_css );
			}

			$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type="text/css"';

			echo <<<HTML
<style{$type_attr}>
{$css}
{$extra_css}
</style>

HTML;
		}
	}

	/**
	 * Outputs the text above the setting form.
	 *
	 * @param string $localized_heading_text Optional. Localized page heading text.
	 */
	public function options_page_description( $localized_heading_text = '' ) {
		$options = $this->get_options();
		parent::options_page_description( __( 'Admin Trim Interface Settings', 'admin-trim-interface' ) );
		echo '<p>' . __( 'Use the image below to correlate the settings below with the admin interface element they hide.', 'admin-trim-interface' ) . '</p>';
		echo '<p>' . __( 'Note: These settings are global and will affect all users who are able to visit the admin pages.', 'admin-trim-interface' ) . '</p>';
	}

	/**
	 * Outputs the image that demonstrates the sections of the site that admin that correspond to the various settings.
	 */
	public function show_legend_image() {
		$link = plugins_url( 'screenshot-1.png', __FILE__ );
		printf(
			'<a href="%s" title="%s" class="%s"><img src="%s" width="404" alt="%s" />',
			esc_url( $link ),
			esc_attr__( 'Settings to admin interface mapping; click to view full size', 'admin-trim-interface' ),
			'c2c-ati-image',
			esc_url( $link ),
			esc_attr__( 'Settings to admin interface mapping', 'admin-trim-interface' )
		);
		echo '<br /><center><em>' . __( 'Click to view full size.', 'admin-trim-interface' ) . '</em></center></a>';
	}
} // end c2c_AdminTrimInterface

add_action( 'plugins_loaded', array( 'c2c_AdminTrimInterface', 'get_instance' ) );

endif; // end if !class_exists()
