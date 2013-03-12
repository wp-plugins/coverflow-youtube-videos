=== Plugin Name ===
Contributors: baba_mmx
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WQA7VVGLLW6UN
Tags: video, playlists, youyube, coverflow, contentflow, html5lightbox, lightbox
Requires at least: 3.0.1
Tested up to: 3.5
Stable tag: 1.0.5
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays a user's Youtube videos in a simil-Coverflow way.

== Description ==

Displays a user's Youtube videos in a simil-Coverflow way.

This plugin uses ContentFlow v1.0.2 and HTML5Lightbox Javascript
libraries to mimic the Coverflow's Apple visualization interface.

* [ContentFlow](http://www.jacksasylum.eu/ContentFlow/license.php "ContentFlow") is licensed as MIT *GPL-compatible*
* [HTML5Lightbox](http://html5box.com/html5lightbox/index.php "HTML5Lightbox") is licensed as GPLv2

= Usage =

* Displays the videos of the user configured in the admin page:
`[coverflow_youtube_videos]`

* Displays the videos of the user specified in the shortcode:
`[coverflow_youtube_videos user="USERNAME"]`

* Displays the videos of the playlist specified in the shortcode:
`[coverflow_youtube_videos list="PLAYLIST_ID"]`

= Shortcode Options =

* Hide the numbers underneath the slider: `numbers=no`

= Style =

You can change the color of the text displayed underneath the video thumbnails adding some CSS to your theme stylesheet file:
`
.ContentFlow .globalCaption .caption {
  color: black;
}
`

If you need to change also the slider color you have to overwrite the default values with something like that:
`
.ContentFlow .scrollbar {
  background: url(img/my_scrollbar.png) left center repeat-x !important;
}
.ContentFlow .scrollbar .slider {
  background: url(img/my_slider.png) center center no-repeat !important;
}
`

Where my_scrollbar.png and my_slider.png are your custom images (under the img folder of your theme).
These images needs to be like scrollbar_white.png and slider_white.png under wp-content/plugins/coverflow-youtube-videos/ContentFlow/img


== Installation ==

1. Unzip the archive of the plugin or download it from the [official Wordpress plugin repository](http://wordpress.org/extend/plugins/coverflow-youtube-videos/ "Coverflow Youtube Videos")
2. Upload the folder 'coverflow-youtube-videos' to the Wordpress plugin directory (../wp-content/plugins/)
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure it as you like

== Frequently Asked Questions ==

= Do I need to edit any files? =
No, once followed the installation instruction you have done. Just check for file permissions (chmod +x).

= How do I display the user's YouTube videos? =
Add this shortcode to either a post or page: **[coverflow_youtube_videos]**.

= How do I enable videos of a specific user? =
Go to 'Settings -> Coverflow YouTube Videos' and change the username of the Youtube user.
See *Usage* and *Shortcode Options* sections in the main plugin page for more info.

= I need some plugin modifications. How can I tell you what I want? =
Send me an email at **info@mauromascia.com** and we'll talk about it.

== Screenshots ==

1. User's YouTube videos shown in a simil-Coverflow way
2. Single video overlay
3. Configuration panel

== Changelog ==

= 1.0.5 =
* NEW: added ability to hide numbers from shortcode.
* Fixed code indentation
* Removed debugging code

= 1.0.4 =
* Fixed Coverflow Android support.

= 1.0.3 =
* Fixed: Video playlist id can be longer than 16 characters.

= 1.0.2 =
* NEW: added startItem option

= 1.0.1 =
* Fixed: issue with thumbnails on playlists

= 1.0 =
* First release

== Upgrade Notice ==

== Credits ==

Sebs Studio [Sebastien](http://www.sebs-studio.com/ "Sebs Studio") for the "My YouTube Videos" plugin used as initial code for this project.

