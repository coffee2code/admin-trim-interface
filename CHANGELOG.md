# Changelog

## 3.5.1 _(2021-04-14)_
* Fix: Update plugin framework to 061 to fix a bug preventing settings from getting saved

## 3.5 _(2021-04-05)_

### Highlights:

This minor release updates the plugin framework and notes compatibility through WP 5.7+.

### Details:

* Change: Update plugin framework to 060
    * 060:
    * Rename class from `c2c_{PluginName}_Plugin_051` to `c2c_Plugin_060`
    * Move string translation handling into inheriting class making the plugin framework code plugin-agnostic
        * Add abstract function `get_c2c_string()` as a getter for translated strings
        * Replace all existing string usage with calls to `get_c2c_string()`
    * Handle WordPress's deprecation of the use of the term "whitelist"
        * Change: Rename `whitelist_options()` to `allowed_options()`
        * Change: Use `add_allowed_options()` instead of deprecated `add_option_whitelist()` for WP 5.5+
        * Change: Hook `allowed_options` filter instead of deprecated `whitelist_options` for WP 5.5+
    * New: Add initial unit tests (currently just covering `is_wp_version_cmp()` and `get_c2c_string()`)
    * Add `is_wp_version_cmp()` as a utility to compare current WP version against a given WP version
    * Refactor `contextual_help()` to be easier to read, and correct function docblocks
    * Don't translate urlencoded donation email body text
    * Add inline comments for translators to clarify purpose of placeholders
    * Change PHP package name (make it singular)
    * Tweak inline function description
    * Note compatibility through WP 5.7+
    * Update copyright date (2021)
    * 051:
    * Allow setting integer input value to include commas
    * Use `number_format_i18n()` to format integer value within input field
    * Update link to coffee2code.com to be HTTPS
    * Update `readme_url()` to refer to plugin's readme.txt on plugins.svn.wordpress.org
    * Remove defunct line of code
* Change: Move translation of all parent class strings into main plugin file
* Change: Note compatibility through WP 5.7+
* Change: Update copyright date (2021)
* Change: Tweak formatting for readme.txt changelog entry for v3.4

## 3.4 _(2020-06-27)_

### Highlights:

This recommended release adds the ability to hide the "My Sites" icon, prevents output of plugin-specific settings styles on other admin pages, omits the `type` attribute for `style` tag for themes that support 'html5', updates the plugin framework, adds a TODO.md file, updates a few URLs to be HTTPS, expands unit testing, updates compatibility to be WP 4.9 through 5.4+, and more.

### Details:

* New: Add ability to trim "My Sites" icon in admin bar
* New: Add HTML5 compliance by omitting `type` attribute when the theme supports 'html5'
* Change: Prevent output of plugin-page specific CSS elsewhere
* Change: Discontinue handling for contextual help text added via deprecated filter `contextual_help`
* Change: Update plugin framework to 050
    * Allow a hash entry to literally have '0' as a value without being entirely omitted when saved
    * Output donation markup using `printf()` rather than using string concatenation
    * Update copyright date (2020)
    * Note compatibility through WP 5.4+
    * Drop compatibility with version of WP older than 4.9
* New: Add TODO.md and move existing TODO list from top of main plugin file into it
* Change: Refactor handling of dynamic CSS rules and ensure they output properly indented
* Change: Adjust some CSS formatting (add second colon for `::before` and spaces around `>`)
* Change: Adjust output spacing for CSS
* Change: Note compatibility through WP 5.4+
* Change: Drop compatibility for version of WP older than 4.9
* Change: Add missing text domain from a few string translation calls
* Change: Remove unnecessary numbering of sole placeholder in string
* Change: Update links to coffee2code.com to be HTTPS
* Change: Update legend image
* Change: Update screenshot images
* Unit tests:
    * New: Add tests for `add_css()`, `admin_init()`, `explain_nonce()`, `show_admin_notices()`, `show_legend_image()`
    * New: Add test for setting name
    * New: Add helper `set_current_screen()` for setting the current screen, defaulting to plugin's setting page
    * Change: Store plugin instance in test object to simplify referencing it
    * Change: Update tests for default hooks, removing a duplicate and adding 2 that were missing
    * Change: Use HTTPS for link to WP SVN repository in bin script for configuring unit tests (and delete commented-out code)

## 3.3.1 _(2019-12-16)_
* Unit tests:
    * Change: Update unit test install script and bootstrap to use latest WP unit test repo
    * New: Add test that plugin initializes itself on `plugins_loaded`
* Change: Note compatibility through WP 5.3+
* Change: Update copyright date (2020)

## 3.3 _(2019-04-06)_
* Change: Initialize plugin on `plugins_loaded` action instead of on load
* Change: Update plugin framework to 049
    * 049:
    * Correct last arg in call to `add_settings_field()` to be an array
    * Wrap help text for settings in `label` instead of `p`
    * Only use `label` for help text for checkboxes, otherwise use `p`
    * Ensure a `textarea` displays as a block to prevent orphaning of subsequent help text
    * Note compatibility through WP 5.1+
    * Update copyright date (2019)
* New: Add CHANGELOG.md file and move all but most recent changelog entries into it
* Change: Note compatibility through WP 5.1+
* Change: Update copyright date (2019)
* Change: Update License URI to be HTTPS
* Change: Split paragraph in README.md's "Support" section into two

## 3.2 _(2018-06-15)_
* Fix: Show admin notices on plugin's setting page
* New: Add basic unit tests
* Change: Update plugin framework to 048
    * 048:
    * When resetting options, delete the option rather than setting it with default values
    * Prevent double "Settings reset" admin notice upon settings reset
    * 047:
    * Don't save default setting values to database on install
    * Change "Cheatin', huh?" error messages to "Something went wrong.", consistent with WP core
    * Note compatibility through WP 4.9+
    * Drop compatibility with version of WP older than 4.7
    * 046:
    * Fix `reset_options()` to reference instance variable `$options`
    * Note compatibility through WP 4.7+
    * Update copyright date (2017)
    * 045:
    * Ensure `reset_options()` resets values saved in the database
    * 044:
    * Add `reset_caches()` to clear caches and memoized data. Use it in `reset_options()` and `verify_config()`.
    * Add `verify_options()` with logic extracted from `verify_config()` for initializing default option attributes.
    * Add  `add_option()` to add a new option to the plugin's configuration.
    * Add filter 'sanitized_option_names' to allow modifying the list of whitelisted option names.
    * Change: Refactor `get_option_names()`.
    * 043:
    * Disregard invalid lines supplied as part of hash option value.
    * 042:
    * Update `disable_update_check()` to check for HTTP and HTTPS for plugin update check API URL.
    * Translate "Donate" in footer message.
    * Note compatibility through WP 4.5.
    * 041:
    * For a setting that is of datatype array, ensure its default value is an array.
    * Make `verify_config()` public.
    * Use `<p class="description">` for input field help text instead of custom styled span.
    * Remove output of markup for adding icon to setting page header.
    * Remove styling for .c2c-input-help.
    * Add braces around the few remaining single line conditionals.
* New: Add README.md
* New: Add LICENSE file
* Change: Give settings checkboxes more width so checkboxes don't always flow below their labels
* Change: Improve responsiveness of settings page
* Change: Store setting name in constant
* Change: Update session expiration error message to sync with one that WP core uses
* Change: Switch to outputting markup with `printf()`
* Change: (Hardening) Sanitize screenshot URL before output (for future-proofing)
* Change: Make legend image's title and alt text translatable
* Change: Minor code reformatting
* Change: Add GitHub link to readme
* Change: Note compatibility through WP 4.9+
* Change: Drop compatibility with versions of WP older than 4.7
* Change: Update copyright date (2018)
* Change: Update installation instruction to prefer built-in installer over .zip file
* Change: Fix changelog entry for v3.1 for proper rendering in Plugin Directory

## 3.1 _(2016-01-14)_

### Highlights:

* This release adds support for language packs and has many minor behind-the-scenes changes.

### Details:

* Change: Update plugin framework to 040:
    * Change class name to `c2c_AdminTrimInterface_Plugin_040` to be plugin-specific.
    * Set textdomain using a string instead of a variable.
    * Don't load textdomain from file.
    * Change admin page header from 'h2' to 'h1' tag.
    * Add `c2c_plugin_version()`.
    * Formatting improvements to inline docs.
* Change: Add support for language packs:
    * Set textdomain using a string instead of a variable.
    * Remove .pot file and /lang subdirectory.
* Change: Declare class as final.
* Add: Create empty index.php to prevent files from being listed if web server has enabled directory listings.
* Change: Note compatibility through WP 4.4+.
* Change: Update copyright date (2016).

## 3.0 _(2015-03-08)_
* Add ability to trim home icon in admin bar
* Apply admin bar trimmings to the front-end
* Drop compatibility with version of WP older than 3.8
    * Remove now-unused settings: `hide_visit_site_link`, `hide_search_engines_blocked`, `hide_favorite_actions`, `hide_turbo_link`, `hide_page_heading_icon`
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

## 2.2
* NOTE: v2.3 will remove support for versions of WP earlier than 3.3
* Add 'hide_avatar' setting
* Add `hide_help_tabs()`, `clear_contextual_help()`, `admin_bar_menu()`
* Only add filter on gettext when WP < 3.3
* Reposition legend image via CSS
* Adjust selection logic for legend image (based on new WP version and images being renamed)
* Add new screenshot-1.png for WP 3.3 and rename remaining images with one number higher
* Bugfix: check if `hide_favorite_actions` validly applies to this WP version before using it
* Mark pre-WP3.3 code in anticipation of removal in next feature release
* Update plugin framework to 031
* Remove support for global `$c2c_admin_trim_interface` variable
* Change parent constructor invocation
* Explicitly declare methods public
* Note compatibility through WP 3.3+
* Drop support for versions of WP older than 3.1
* Create 'lang' subdirectory and move .pot file into it
* Regenerate .pot
* Update screenshots for WP 3.3
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

## 2.1
* Dynamically number options rather than hardcoding numbers into label
* Change to hide "Howdy" via `gettext()` translation string modification rather than CSS
* Change method and improve thoroughness of disabling dashboard menu link
* Use filters to disable footer links and WP version
* Show different legend image on settings page depending on what version of WP is in use
* Fix to properly register activation and uninstall hooks
* Update plugin framework to 024
* Save a static version of itself in class variable $instance
* Deprecate use of global variable `$c2c_admin_trim_interface` to store instance
* Add `__construct()`, `activation()`, `admin_init()`, `hide_dashboard()`, `admin_user_info_links()`
* Note compatibility through WP 3.2+
* Drop support for versions of WP older than 3.0
* Update all screenshots
* Display reduced size legend image, make it clickable to view full-size, and add text saying as much
* Explicitly declare functions public
* Regenerate .pot
* Minor code formatting changes (spacing)
* Update copyright date (2011)
* Add plugin homepage and author links in description in readme.txt

## 2.0.3
* Fix bug related to declaring functions static

## 2.0.2
* Update plugin framework to version 021
* Explicitly declare all class functions public static
* Delete plugin options upon uninstallation
* Fix to prevent PHP notices for version-dependent options
* Note compatibility through WP 3.1+
* Update copyright date (2011)

## 2.0.1
* Update plugin framework to version 016

## 2.0
* Re-implementation by extending `C2C_Plugin_014`, which among other things adds support for:
    * Reset of options to default values
    * Better sanitization of input values
    * Offload of core/basic functionality to generic plugin framework
    * Additional hooks for various stages/places of plugin operation
    * Easier localization support
* Full localization support
* Add option to hide "Search Engines Block" link in WP 3.0+
* Don't show option to hide "Visit site" link if running in WP 3.0+
* Change positioning method for setting page graphic
* Rename class from `AdminTrimInterface` to `c2c_AdminTrimInterface`
* Move object instantiation to within the initial `if(!class_exists())` check
* Store plugin instance in global variable, `$c2c_admin_trim_interface`, to allow for external manipulation
* Check for `is_admin()` before defining class rather than during constructor
* Add PHPDoc documentation
* Add package info to top of plugin file
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Minor code reformatting (spacing)
* Add Upgrade Notice section to readme.txt
* Note compatibility with WP 2.9+ and 3.0+
* Drop compatibility with version of WP older than 2.8
* Update copyright date
* Add .pot file

## 1.1
* Change CSS selector usage in two places to not rely on text which may get translated (fixes inability to hide username link when translated)
* Fixed so that "|" is properly inserted as separator for upper-right links only when necessary under various visible/hidden combinations
* Hide topmost menu separator when dashboard menu link is hidden
* Fixed hiding of contextual help link
* Added missing c2c_minilogo.png
* Facilitated translation of 'Save Changes'
* Minor code reformatting (spacing)

## 1.0
* Initial release

