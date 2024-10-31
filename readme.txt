=== My Pictures Widget ===
Contributors: pepijnkoning
Donate link: http://www.pepijnkoning.nl/contact/
Tags: twitter, twitpic, widget, photos, pictures, mobypicture
Requires at least: 2.2
Tested up to: 3.0
Stable tag: 2.2

This easy to use Widget shows your Twitpic or Mobypicture pictures and is very easy to configure.

== Description ==

The My Pictures Widget allows you to show your recently added items to Twitpic.com and Mobypicture.com on your WordPress powered website. 
This simple widget automatically displays them in your sidebar. If your theme don't support widgets you could add some custom code.

= Currently supported services =

* Twitpic
* Mobypicture

= Features =

* Simple
* Customizable title
* Only twitter username required
* You could change the number of photos
* Link to pictures on/off
* Change picture size
* Change margin
* Border modification

== Installation ==

= Themes with widget support =
1. Upload `mypictures.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add the widget to the sidebar
4. Setup the widget
5. Enjoy!

= Themes without widget support =
1. Upload `mypictures.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Insert and edit the PHP code listed below in your `sidebar.php` at the desired location:

`< ?php MyPictures($username = 'pepijnkoning', $num = 4, $linked = true, $size = 70, $margin = 5, $border = 0, $bordercolor = '#FFFFFF', $service = 'Twitpic') ?>`

* `$username = pepijnkoning` >> replace with your own username;
* `$num = 4` >> replace with the number of thumbnails you wish to display;
* `$linked = true` >> replace with `false` when you don't want to link the pictures to the original ones;
* `$size = 70` >> replace with desired width of the thumbnail in number of pixels;
* `$margin = 2` >> the margin around the pictures in pixels;
* `$border = 0` >> the border size in pixels;
* `$bordercolor = '#FFFFFF'` >> the border color, if the border is not 0px;
* `$service = 'Twitpic'` >> the service you wanna use: 'Twitpic' or 'Mobypicture'

== Frequently Asked Questions ==

= How many photo's shows the plugin? =

On the widget administration page you could set up how many photo's you want to show (max. 20)

= Are the photo's linked? =

Yes, but when you don't want that visitors could click on it you could put it off on the widget administratoin page.

= What do I have to fill in by "Username" =

The username of your twitter account.

== Screenshots ==

1. Administration interface of the widget

== Version History ==

= Version 1.2 =
* Added Mobypicture support
* Bug fix: Changed the way Twitpic picture's are loaded
* Plugin renamed to My Pictures Widget
	
= Version 1.1.0 =
* Added custom image sizing
* Added custom image margin
* Added linked photos option
* Added custom border size and color
	
= Version 1.0.1 =
* Plugin My Twitpics released

== Licence ==

Good news, this plugin is free for everyone! Since it's released under the GPL, you can use it free of charge on your personal or commercial blog.