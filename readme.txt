=== Admin Trim Interface ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: admin, interface, minimal, customize, coffee2code
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 3.8
Tested up to: 4.1
Stable tag: 3.0

Customize the WordPress admin pages by selectively removing interface elements.


== Description ==

This plugin uses a combination of WordPress hooks, CSS (when possible), and Javascript (last resort) to removed specified admin interface elements.  These elements may be considered by some to be superfluous interface elements that are undesired for one reason or another, so this plugin aids in their visual removal.

Each admin interface element is individually selected for removal.  The elements that can be removed are:

* The header WordPress logo (bear in mind this functions as a menu) in the admin bar
* The home icon next to your site's name in the admin bar
* The "Howdy," greeting before your username in the admin bar
* Your username link to your profile in the admin bar
* Your avatar in the admin bar
* The Dashboard menu link in the sidebar
* The contextual "Help" link
* The footer links
* The WordPress version in the footer

(There is an associated screenshot which points out these different sections.)

Note: These settings are global and will affect all users who are able to visit the admin pages.

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/admin-trim-interface/) | [Plugin Directory Page](https://wordpress.org/plugins/admin-trim-interface/) | [Author Homepage](http://coffee2code.com)


== Installation ==

1. Unzip `admin-trim-interface.zip` inside the `/wp-content/plugins/` directory for your site (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. Click the plugin's 'Settings' link next to its 'Deactivate' link (still on the Plugins page), or click on the Appearance -> Admin Trim Interface link, to go to the plugin's admin settings page.  Customize the settings to selectively remove admin interface elements.


== Frequently Asked Questions ==

= Does this plugin allow for each admin user to customize the admin interface to their individual liking? =

No. The settings for the plugin apply to all users within the admin pages and not to each user individually.

= Why is the admin dashboard still accessible? =

This plugin does not prevent access to the admin dashboard; it merely provides the ability to hide the admin sidebar menu button that leads to the admin dashboard.


== Screenshots ==

1. A image identifying the different elements of the admin interface that can be selectively disabled by the plugin.
2. An image of the user section of the admin bar when "Howdy" and the username is hidden, leaving only the avatar.
3. An image of the user section of the admin bar when "Howdy" and the avatar is hidden, leaving only the username.
4. A screenshot of the plugin's admin settings page.
5. A screenshot of a fully trimmed admin interface.


== Changelog ==

= 3.0 (2015-03-08) =
* Add ability to trim home icon in admin bar
* Apply admin bar trimmings to the front-end
* Drop compatibility with version of WP older than 3.8
    * Remove now-unused settings: hide_visit_site_link, hide_search_engines_blocked, hide_favorite_actions, hide_turbo_link, hide_page_heading_icon
    * Remove now-unused functions: `add_admin_js()`, `admin_user_info_links()`, `remove_howdy()`
    * Discontinue output of now-unused CSS and JS
* Remove `is_admin()` restriction so admin toolbar is trimmed on front-end too
* Update plugin framework to 039
* Explicitly declare `activation()` and `uninstall()` static
* Better singleton implementation:
    * Add `get_instance()` static method for returning/creating singleton instance
    * Make static variable 'instance' private
    * Make constructor protected
    * Additional related changes in plugin framework (protected constructor, erroring `__clone()` and `__wakeup()`)
* Add checks to prevent execution of code if file is directly accessed
* Rename `add_admin_css()` to `add_css()`
* For `options_page_description()`, match method signature of parent class to prevent PHP warnings
* Re-license as GPLv2 or later (from X11)
* Reformat plugin header
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Use explicit path for `require_once()`
* Discontinue use of PHP4-style constructor
* Discontinue use of explicit pass-by-reference for objects
* Remove ending PHP close tag
* Minor documentation improvements throughout
* Minor code reformatting (spacing, bracing)
* Change documentation links to wp.org to be https
* Note compatibility through WP 4.1+
* Update copyright date (2015)
* Regenerate .pot
* Change donate link
* Add assets directory to plugin repository checkout
* Update screenshots
* Move screenshots into repo's assets directory
* Add banner
* Add icon

= 2.2 =
* NOTE: v2.3 will remove support for versions of WP earlier than 3.3
* Add 'hide_avatar' setting
* Add hide_help_tabs(), clear_contextual_help(), admin_bar_menu()
* Only add filter on gettext when WP < 3.3
* Reposition legend image via CSS
* Adjust selection logic for legend image (based on new WP version and images being renamed)
* Add new screenshot-1.png for WP 3.3 and rename remaining images with one number higher
* Bugfix: check if 'hide_favorite_actions' validly applies to this WP version before using it
* Mark pre-WP3.3 code in anticipation of removal in next feature release
* Update plugin framework to 031
* Remove support for global $c2c_admin_trim_interface variable
* Change parent constructor invocation
* Explicitly declare methods public
* Note compatibility through WP 3.3+
* Drop support for versions of WP older than 3.1
* Create 'lang' subdirectory and move .pot file into it
* Regenerate .pot
* Update screenshots for WP 3.3
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

= 2.1 =
* Dynamically number options rather than hardcoding numbers into label
* Change to hide "Howdy" via gettext() translation string modification rather than CSS
* Change method and improve thoroughness of disabling dashboard menu link
* Use filters to disable footer links and WP version
* Show different legend image on settings page depending on what version of WP is in use
* Fix to properly register activation and uninstall hooks
* Update plugin framework to 024
* Save a static version of itself in class variable $instance
* Deprecate use of global variable $c2c_admin_trim_interface to store instance
* Add __construct(), activation(), admin_init(), hide_dashboard(), admin_user_info_links()
* Note compatibility through WP 3.2+
* Drop support for versions of WP older than 3.0
* Update all screenshots
* Display reduced size legend image, make it clickable to view full-size, and add text saying as much
* Explicitly declare functions public
* Regenerate .pot
* Minor code formatting changes (spacing)
* Update copyright date (2011)
* Add plugin homepage and author links in description in readme.txt

= 2.0.3 =
* Fix bug related to declaring functions static

= 2.0.2 =
* Update plugin framework to version 021
* Explicitly declare all class functions public static
* Delete plugin options upon uninstallation
* Fix to prevent PHP notices for version-dependent options
* Note compatibility through WP 3.1+
* Update copyright date (2011)

= 2.0.1 =
* Update plugin framework to version 016

= 2.0 =
* Re-implementation by extending C2C_Plugin_014, which among other things adds support for:
    * Reset of options to default values
    * Better sanitization of input values
    * Offload of core/basic functionality to generic plugin framework
    * Additional hooks for various stages/places of plugin operation
    * Easier localization support
* Full localization support
* Add option to hide "Search Engines Block" link in WP 3.0+
* Don't show option to hide "Visit site" link if running in WP 3.0+
* Change positioning method for setting page graphic
* Rename class from 'AdminTrimInterface' to 'c2c_AdminTrimInterface'
* Move object instantiation to within the initial if(!class_exists()) check
* Store plugin instance in global variable, $c2c_admin_trim_interface, to allow for external manipulation
* Check for is_admin() before defining class rather than during constructor
* Add PHPDoc documentation
* Add package info to top of plugin file
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Minor code reformatting (spacing)
* Add Upgrade Notice section to readme.txt
* Note compatibility with WP 2.9+ and 3.0+
* Drop compatibility with version of WP older than 2.8
* Update copyright date
* Add .pot file

= 1.1 =
* Change CSS selector usage in two places to not rely on text which may get translated (fixes inability to hide username link when translated)
* Fixed so that "|" is properly inserted as separator for upper-right links only when necessary under various visible/hidden combinations
* Hide topmost menu separator when dashboard menu link is hidden
* Fixed hiding of contextual help link
* Added missing c2c_minilogo.png
* Facilitated translation of 'Save Changes'
* Minor code reformatting (spacing)

= 1.0 =
* Initial release


== Upgrade Notice ==

= 3.0 =
Recommended update: Updated trim capabilities to be WP 4.1 compatible; dropped pre-WP 3.8 support; updated plugin framework.

= 2.2 =
Recommended update: Updated trim capabilities to be WP 3.3 compatible; minor bugfix; dropped pre-WP 3.1 support; updated plugin framework.

= 2.1 =
Recommended update. Update trim capabilities to be WP 3.2 compatible; improved interface trimming techniques; dropped support for versions of WP older than 3.0; updated plugin framework; and more.

= 2.0.3-=
Recommended bugfix release: fixed bug introduced in previous release.

= 2.0.2 =
Minor release: updated underlying plugin framework; noted compatibility with WP 3.1+ and updated copyright date.

= 2.0.1 =
Minor bugfix update of underlying plugin framework.

= 2.0 =
Recommended update! This release fixes WP 3.0 compatibility. It also includes major re-implementation, bug fixes, localization support, and more.
