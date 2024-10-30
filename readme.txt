=== JJ NextGen JQuery Cycle ===
Contributors: JJ Coder
Donate link: http://www.redcross.org.nz/donate
Tags: image, picture, photo, widgets, gallery, images, nextgen-gallery, jquery, slideshow, cycle lite, javascript
Requires at least: 2.8
Tested up to: 3.1
Stable tag: 1.1.2

Allows you to pick a gallery from the 'NextGen Gallery' plugin to use with 'JQuery Cycle Lite'.

== Description ==

The 'JJ NextGen JQuery Cycle' allows you to create a 'Cycle Lite' (http://jquery.malsup.com/cycle/lite/) as a widget or as a shortcode.
This plugin uses the 'NextGen Gallery' plugin for its images.

Requirements:

- NextGen Gallery Plugin (http://wordpress.org/extend/plugins/nextgen-gallery/)

NextGen Gallery Integration:

- This plugin uses the original width and height of the image uploaded so make sure the images are the correct dimensions when uploaded.
- If a width and height are defined under the configuration all images will be resized to those dimensions (Highly recommended).
- Alt & Title Text Field: Provide a full url here and the image will link to this. Only works if alt field starts with either of these; /, http, or ftp.
- Description Field: Will be used as image alt text. If alt text is present but not a valid url alt text will be used instead for image alt text.

You can specify the following parameters:

NOTE: sc means shortcode:

- Title: Title. Leave blank for no title. (sc: title="My Cycle Lite")
- Gallery: Leave blank to use all galleries or choose a gallery to use. (sc: gallery="galleryid")
- Order: Order to display results in. You can choose; Random, Latest First, Oldest First, or NextGen Sortorder. Random will still work when a page is cached. (sc: order="random"|"asc"|"desc"|"sortorder")
- Shuffle: If order is random and this is true will shuffle images with javascript. Useful if your are caching your pages. (sc: shuffle="true"|"false")
- Max pictures: The maximum amount of pictures to use. (sc: max_pictures="6")
- HTML id: HTML id to use. Defaults to 'cycle_lite'. Needs to be different for multiple instances on same page. (sc: html_id="cycle_lite")
- Image width: Width of image. Defaults to 200. Recommended to set this. (sc: width="200")
- Image height: Height of image. Defaults to 200. Recommended to set this. Will prevent a floating problem if set. (sc: height="150")
- Center: Centers content in container. Requires width to be set. (sc: center="1")

Cycle Lite settings:

Please check the cycle lite home page form more information (http://jquery.malsup.com/cycle/lite/).

- timeout: Milliseconds between slide transitions (0 to disable auto advance).. (sc: timeout="4000")
- speed: Speed of the transition (any valid fx speed value). (sc: speed="1000")
- sync: True if in/out transitions should occur simultaneously. (sc: sync="1")
- fit: Force slides to fit container. (sc: fit="0")
- pause: True to enable "pause on hover". (sc: pause="1")
- delay: Additional delay (in ms) for first transition (hint: can be negative). (sc: delay="2)

Shortcode Examples:

- [jj-ngg-jquery-cycle html_id="about-cycle-lite" gallery="1" width="200" height="150"]
- [jj-ngg-jquery-cycle title="Hello" html_id="about-cycle-lite" gallery="1" timeout="3000" speed="1000"]
- [jj-ngg-jquery-cycle html_id="about-cycle" gallery="2" width="150" height="100" timeout="3000" speed="1000" fit="1"]

Try out my other plugins:

- JJ NextGen JQuery Slider (http://wordpress.org/extend/plugins/jj-nextgen-jquery-slider/)
- JJ NextGen JQuery Carousel (http://wordpress.org/extend/plugins/jj-nextgen-jquery-carousel/)
- JJ NextGen Unload (http://wordpress.org/extend/plugins/jj-nextgen-unload/)
- JJ NextGen Image List (http://wordpress.org/extend/plugins/jj-nextgen-image-list/)
- JJ SwfObject (http://wordpress.org/extend/plugins/jj-swfobject/)

== Installation ==

Please refer to the description for requirements and how to use this plugin.

1. Copy the entire directory from the downloaded zip file into the /wp-content/plugins/ folder.
2. Activate the "JJ NextGen JQuery Cycle" plugin in the Plugin Management page.
3. Refer to the description to use the plugin as a widget and or a shortcode.

== Frequently Asked Questions ==

Question:

- How can I use plugin inside normal PHP code?

Answer:

- echo do_shortcode('[jj-ngg-jquery-cycle html_id="about-cycle-lite" gallery="1" width="200" height="150"]');

Question:

- Doesn't work after upgrade? or Doesn't work with this theme?
  
Answer:

- Please check that you don't have two versions of jQuery loading, this is the problem most of the time. Sometimes a theme puts in <br> tags at the end of newlines aswell.

== Screenshots ==

1. Screenshot

== Changelog ==

- 1.1.2: FAQ.
- 1.1.1: Donate to Christchurch Quake.
- 1.1.0: Readme.
- 1.0.9: Overflow hidden on divs if height is entered.
- 1.0.8: Width set on cycle lite container now. No more stylesheet everything inline for lightness. New shuffle field. If order is random and this is true will shuffle images with javascript. Useful if you are caching your pages. This use to be always on in previous verions but some people want images to load in order so if not caching the page no need to be turned on.
- 1.0.7: Fix.
- 1.0.6: Optimisation.
- 1.0.5: NextGen images that are excluded now don't show up.
- 1.0.4: Images attribute border="0" added. before_title, after_title, before_widget, after_widget enabled for widgets. No styling on ul and li now in widget.
- 1.0.3: Widget header is now a h2 tag. Widget output fix.
- 1.0.2: Better support for NextGen galleries already created. Alt text is now checked to see if its a url. If its not a url alt text will be used for image alt instead of description if it exists.
- 1.0.1: Tidy up.
- 1.0.0: First version.

== Contributors ==
