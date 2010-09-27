=== Admin Trim Interface ===
Contributors: coffee2code
Donate link: http://coffee2code.com
Tags: admin, interface, minimal, customize, coffee2code
Requires at least: 2.8
Tested up to: 3.0.1
Stable tag: 2.0.1
Version: 2.0.1

Customize the WordPress admin pages by selectively removing interface elements.


== Description ==

This plugin uses a combination of CSS (when possible) and Javascript to removed specified admin interface elements.  These elements may be considered by some to be superfluous interface elements that are undesired for one reason or another, so this plugin aids in their visual removal.

Each admin interface element is individually selected for removal.  The elements that can be removed are:

* The header WordPress logo
* The "Visit site" link
* The "Search Engines Blocked" link
* The favorites shortcut dropdown
* The "Howdy," greeting before your username
* Your username link to your profile
* The "Turbo" link
* The Dashboard link
* The page header icon
* The contextual "Help" link
* The footer links
* The WordPress version in the footer

(There is an associated screenshot which points out these different sections.)

Note: These settings are global and will affect all users who are able to visit the admin pages.


== Installation ==

1. Unzip `admin-trim-interface.zip` inside the `/wp-content/plugins/` directory for your site (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. Click the plugin's 'Settings' link next to its 'Deactivate' link (still on the Plugins page), or click on the Theme -> Admin Trim Interface link, to go to the plugin's admin settings page.  Customize the settings to selectively remove admin interface elements.


== Frequently Asked Questions ==

= Does this plugin allow for each admin user to customize the admin interface to their individual liking? =

No. The settings for the plugin apply to all users within the admin pages and not to each user individually.


== Screenshots ==

1. A image indicating the different elements of the admin interface that can be selectively disabled by the plugin.
2. A screenshot of the plugin's admin settings page.
3. A screenshot of a fully trimmed admin interface.


== Changelog ==

= 2.0.1 =
* Update plugin framework to 016

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

= 2.0.1 =
Minor bugfix update of underlying plugin framework.

= 2.0 =
Recommended update! This release fixes WP 3.0 compatibility. It also includes major re-implementation, bug fixes, localization support, and more.