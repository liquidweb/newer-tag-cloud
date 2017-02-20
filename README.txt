=== Newer Tag Cloud ===
Contributors: Liquid Web, liquidwebdan
Tags: tag, cloud, widget
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A small plugin providing a nice tag cloud feature. Inspired by New Tag Cloud.

== Description ==

Newer Tag Cloud, inspired by New Tag Cloud, is a WordPress plugin that generates a tag clouds.

Newer Tag Cloud uses the WordPress own tagging feature, so that you don't need any tagging plugin. You can use New Tag
Cloud directly as a shortcode in any post/page, as a widget, or in the theme as PHP code.

Configurebale options
* widget box title
* how many tags should be shown
* biggest font size
* smallest font size
* font size stepping
* font size type (px, em, rem, etc)
* filtering
* caching

== Installation ==
Installation is very easy:

1. Download the plugin zip to the `/wp-content/plugins/` directory
1. Extract the files in the plugins folder. The result being a new `/wp-content/plugins/newer-tag-cloud` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Check out the 'Widgets' tab in the 'Theme' menu and drag the 'New Tag Cloud' widget to your sidebar.

Using directly from a theme file:
Follow the steps 1 and 2 above. Step 3 is to place this code into your theme file:
`<?php newerTagCloud(); ?>`

Or you want place a tag cloud in a post, on a page or in a text widget?

Use a shortcode: `[newer-tag-cloud]` or [newer-tag-cloud int=1]

== Frequently Asked Questions ==

= So what does 'inspired by New Tag Cloud' mean exactly? =
Initially the plugin was created as a direct fork of New Tag Cloud, only used internally and not publically released. A
new version of the plugin was created based on the [WordPress Plugin Boilerplate](https://wppb.io/) with common features
being implemented in Newer Tag Cloud.

= How to use vanilla PHP to add a Tag Cloud? =
If you want to use Newer Tag Cloud in your theme you can still use `<?php newerTagCloud() ?>`. If you want to use a
specific widget you can provide the function an ID as parameter. For example, `<?php newerTagCloud(2) ?>` will result in
the configuration using the instance provided.

= Using shortcodes to add a Tag Cloud? =
Simply add `[newer-tag-cloud]` or `[newer-tag-cloud int=<ID>]` to your post or page and the tag cloud will be shown
there. If you use `[newer-tag-cloud]` the instances set as "Default instance for shortcode" is used. With int=<ID> set
you can specify an instance to use. For example, this is useful if you need two, or more, different tag clouds
generated via shortcode.

= Can I use multiple unique clouds? =
Yes. All "layout specific options" are stored in each instance. The instance has an ID which you can use to call it.
This feature allows you the place different tag clouds on your blog as needed.

= So who worked on this? =
Credit to the original plugin goes to [funnydingo](https://profiles.wordpress.org/funnydingo/).
This redone version was created by [liquidwebdan](https://profiles.wordpress.org/liquidwebdan/) (aka [MallardDuck on GitHub](https://github.com/mallardduck))

Finally, credit for the WordPress Plugin Boilerplate goes to:

* [DevinVinson](https://github.com/DevinVinson)
* [Tom McFarlin](https://github.com/tommcfarlin/)
* [Josh Eaton](https://github.com/jjeaton)
* [Ulrich Pogson](https://github.com/grappler)
* ...and many more!

== Changelog ==

= 1.0.0 =
* Initial version inspired by New Tag Cloud
