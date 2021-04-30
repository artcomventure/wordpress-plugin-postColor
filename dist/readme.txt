=== Post Color ===

Contributors:
Donate link:
Tags:
Requires at least:
Tested up to:
Stable tag:
License: MIT
License URI: https://github.com/artcomventure/wordpress-plugin-postColor/blob/master/LICENSE

Set specific colors for each and every post/page.

== Description ==

== Installation ==

1. Upload files to the `/wp-content/plugins/` directory of your WordPress installation.
* Either [download the latest files](https://github.com/artcomventure/wordpress-plugin-postColor/archive/master.zip) and extract zip (optionally rename folder)
* ... or clone repository:
  ```
  $ cd /PATH/TO/WORDPRESS/wp-content/plugins/
  $ git clone https://github.com/artcomventure/wordpress-plugin-postColor.git
  ```
If you want a different folder name than `wordpress-plugin-postColor` extend clone command by ` 'FOLDERNAME'` (replace the word `'FOLDERNAME'` by your chosen one):
  ```
  $ git clone https://github.com/artcomventure/wordpress-plugin-postColor.git 'FOLDERNAME'
  ```
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. **Enjoy**

== Plugin Updates ==

Although the plugin is not _yet_ listed on https://wordpress.org/plugins/, you can use WordPress' update functionality to keep it in sync with the files from [GitHub](https://github.com/artcomventure/wordpress-plugin-postColor).

**Please use for this our [WordPress Repository Updater](https://github.com/artcomventure/wordpress-plugin-repoUpdater)** with the settings:

* Repository URL: https://github.com/artcomventure/wordpress-plugin-postColor/
* Subfolder (optionally, if you don't want/need the development files in your environment): dist

_We test our plugin through its paces, but we advise you to take all safety precautions before the update. Just in case of the unexpected._

== Questions, concerns, needs, suggestions? ==

Don't hesitate! [Issues](https://github.com/artcomventure/wordpress-plugin-postColor/issues) welcome.
== Changelog ==

= 1.1.0 - 2021-04-30 =
**Added**

* Set colors also for blocks.

= 1.0.12 - 2021-04-26 =
**Fixed**

* Set color to body.

= 1.0.11 - 2021-04-21 =
**Fixed**

* Set color for page for posts.

= 1.0.10 - 2021-04-20 =
**Fixed**

* Get settings the REST way.

= 1.0.9 - 2021-04-20 =
**Fixed**

* En-/disable color editor according to settings.

= 1.0.8 - 2021-03-19 =
**Fixed**

* Remove omitted `style` type attribute.

= 1.0.7 - 2021-03-16 =
**Removed**

* Custom Bogo fix (https://wordpress.org/support/topic/gutenberg-updating-failed-with-custom-post-meta/).

**Added**

* Make POT file via WP CLI.

= 1.0.6 - 2021-02-11 =
**Fixed**

* Post query (no limit).

= 1.0.5 - 2021-02-11 =
**Fixed**

* Post CSS.

= 1.0.4 - 2021-02-09 =
**Fixed**

* Error register `_post-color` post meta.

= 1.0.3 - 2021-02-01 =
**Fixed**

* Error with custom post types.

= 1.0.2 - 2021-01-13 =
**Fixed**

* Initial editor color styles (with closed panel).
* Apply panel visibility settings.

= 1.0.1 - 2021-01-12 =
**Fixed**

* Gutenberg panel icon.
* _Temporally_ fix of https://wordpress.org/support/topic/gutenberg-updating-failed-with-custom-post-meta/

= 1.0.0 - 2021-01-12 =

* Initial commit.