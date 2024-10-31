<?php

/*
Plugin Name: My Pictures Widget
Version: 1.2.2
Plugin URI: http://www.pepijnkoning.nl/archief/wordpress-my-pictures-widget/
Description: This easy to use Widget shows your Twitpic or Mobypicture pictures and is very easy to configure. 
Author: Pepijn Koning
Author URI: http://www.pepijnkoning.nl/
*/

/*  Copyright 2010 Pepijn Koning

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* 	Version History
	v1.2.2
	- Bug fix: loading twitpic pictures is now going with the "file_get_contents" method
	
	v1.2.1
	- Bug fix: some twitpic usernames did'nt show the right pictures
	
	v1.2
	- Added Mobypicture support
	- Bug fix: changed the way Twitpic picture's are loaded
	- Plugin renamed to My Pictures Widget
	
	v1.1.0
	- Added custom image sizing
	- Added custom image margin
	- Added linked photos option
	- Added custom border size and color
	
	v1.0.1
	- Plugin My Twitpics released
*/	

define('MAGPIE_CACHE_ON', 0); //2.7 Cache Bug


/* WIDGET AANMAKEN */
/* en standaard waarden zetten */

$twitpic_options['widget_fields']['title'] = array('label'=>'Title:', 'type'=>'text', 'default'=>'My Pictures');
$twitpic_options['widget_fields']['service'] = array('label'=>'Twitpic/Mobypicture:', 'type'=>'text', 'default'=>'Twitpic');
$twitpic_options['widget_fields']['username'] = array('label'=>'Username:', 'type'=>'text', 'default'=>'');
$twitpic_options['widget_fields']['num'] = array('label'=>'Number of pics:', 'type'=>'text', 'default'=>'4');
$twitpic_options['widget_fields']['size'] = array('label'=>'Picture size:', 'type'=>'text', 'default'=>'70');
$twitpic_options['widget_fields']['margin'] = array('label'=>'Margin:', 'type'=>'text', 'default'=>'5');
$twitpic_options['widget_fields']['border'] = array('label'=>'Border:', 'type'=>'text', 'default'=>'1');
$twitpic_options['widget_fields']['bordercolor'] = array('label'=>'Border color:', 'type'=>'text', 'default'=>'#FFFFFF');
$twitpic_options['widget_fields']['linked'] = array('label'=>'Linked photos:', 'type'=>'checkbox', 'default'=>false);

$twitpic_options['prefix'] = 'twitpic';


/* GET TWITPICS FUNCTIONS */
/* functies voor het ophalen van de twitpic foto's */

/* function Twitpic_getThumb($url,$type = "mini") {
    preg_match("/(http:\/\/twitpic\.com\/)(.*$)/i",$url,$matches);
    return 'http://twitpic.com/show/' . $type . '/' . $matches[2];
}

function Twitpic_viewPhotos($user) {
    $url = 'http://twitpic.com/photos/' . $user . '/feed.rss';
    return Twitpic_objectify(Twitpic_fetch($url), LIBXML_NOCDATA);
}

function Twitpic_fetch($url,$post = false) {
    $ch = curl_init($url);
    if($post !== false) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, timeout);
    $output = curl_exec($ch);
    curl_close($ch); 
    return $output;
}

function Twitpic_objectify($data,$option = 0) {
    return (object) simplexml_load_string($data,'SimpleXMLElement',$option);
} */


/* TWITPIC LAATST TOEGEVOEGDE FOTO'S */
/* laat de nieuwste twitpic foto's zien */

function ShowTwitpics($username = '', $num = 4, $linked = true, $size = 70, $margin = 5, $border = 0, $bordercolor = '#FFFFFF') {
	$file = @file_get_contents("http://www.twitpic.com/photos/".$username."/feed.rss");

	for($i = 1; $i <= $num; ++$i) {
		$pic = explode('"><img src="', $file);
		$pic = explode('"></a>]]></description>', $pic[$i]);
		$pic = trim($pic[0]);

		$url = explode('<guid>', $file);
		$url = explode('</guid>', $url[$i]);
		$url = trim($url[0]);

		if($linked == "true") {
			echo '<a href="'.$url.'" target="_new" /><img src="'.$pic.'" width="'.$size.'" height="'.$size.'" style="margin: '.$margin.'px; border: '.$border.'px solid '.$bordercolor.';" class="mypictures" /></a>';
		} else {
			echo '<img src="'.$pic.'" width="'.$size.'" height="'.$size.'" style="margin: '.$margin.'px; border: '.$border.'px solid '.$bordercolor.';" class="mypictures" />';
		}
	}
}
/* function ShowTwitpics($username = '', $num = 4, $linked = true, $size = 70, $margin = 5, $border = 0, $bordercolor = '#FFFFFF') {
	$photos  = Twitpic_viewPhotos($username);
	
	if(count($photos->channel->item)>0) {
		$startnum = 1;
	    foreach($photos->channel->item as $item) {
	    	if($startnum <= $num) {
		        if($linked == "true") {
					echo '<a href="'.$item->link.'" target="_new" /><img src="'.Twitpic_getThumb($item->link,'thumb').'" width="'.$size.'" height="'.$size.'" style="margin: '.$margin.'px; border: '.$border.'px solid '.$bordercolor.';" class="mypictures" /></a>';
				} else {
					echo '<img src="'.Twitpic_getThumb($item->link,'thumb').'" width="'.$size.'" height="'.$size.'" style="margin: '.$margin.'px; border: '.$border.'px solid '.$bordercolor.';" class="mypictures" />';
				}
			}
			$startnum++;
	    }
	}
} */


/* MOBYPICTURE LAATST TOEGEVOEGDE FOTO'S */
/* laat de nieuwste mobypicture foto's zien */

function ShowMobypictures($username = '', $num = 4, $linked = true, $size = 70, $margin = 5, $border = 0, $bordercolor = '#FFFFFF') {
	$file = @file_get_contents("http://www.mobypicture.com/rss/".$username."/user.rss");

	for($i = 1; $i <= $num; ++$i) {
		$pic = explode('<media:thumbnail url="', $file);
		$pic = explode('"/>', $pic[$i]);
		$pic = trim($pic[0]);

		$url = explode('<description>&lt;a href=&quot;', $file);
		$url = explode('&quot;&gt;&lt;img src=', $url[$i]);
		$url = trim($url[0]);

		if($linked == "true") {
			echo '<a href="'.$url.'" target="_new" /><img src="'.$pic.'" width="'.$size.'" height="'.$size.'" style="margin: '.$margin.'px; border: '.$border.'px solid '.$bordercolor.';" class="mypictures" /></a>';
		} else {
			echo '<img src="'.$pic.'" width="'.$size.'" height="'.$size.'" style="margin: '.$margin.'px; border: '.$border.'px solid '.$bordercolor.';" class="mypictures" />';
		}
	}
}


/* SERVICE FUNCTION */

function MyPictures($username = '', $num = 4, $linked = true, $size = 70, $margin = 5, $border = 0, $bordercolor = '#FFFFFF', $service = 'Twitpic') {
	if($service == 'Mobypicture') {
		/* MOBYPICTURE */
		ShowMobypictures($username, $num, $linked, $size, $margin, $border, $bordercolor);
	} else {
		/* TWITPIC */
		ShowTwitpics($username, $num, $linked, $size, $margin, $border, $bordercolor);
	}
}


/* WIDGET STUFF */
/* zorg dat de widget goed werkt */

function widget_mypictures_init() {
	if (!function_exists('register_sidebar_widget'))
		return;
	
		$check_options = get_option('widget_mypictures');
  		if ($check_options['number']=='') {
    			$check_options['number'] = 1;
    			update_option('widget_mypictures', $check_options);
  		}

	function widget_mypictures($args, $number = 1) {
	
	global $twitpic_options;
		
		// $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
		extract($args);

		// Each widget can store its own options. We keep strings here.
		include_once(ABSPATH . WPINC . '/rss.php');
		$options = get_option('widget_mypictures');
		
		// fill options with default values if value is not set
		$item = $options[$number];
		foreach($twitpic_options['widget_fields'] as $key => $field) {
			if (! isset($item[$key])) {
				$item[$key] = $field['default'];
			}
		}
		
		// These lines generate our output.
		echo $before_widget . $before_title . $item['title'] . $after_title;
			echo '<ul style="align: center;">';
			MyPictures($item['username'], $item['num'], $item['linked'], $item['size'], $item['margin'], $item['border'], $item['bordercolor'], $item['service']);
			echo '</ul>';
		echo $after_widget;
	}

	// This is the function that outputs the form to let the users edit
	// the widget's title. It's an optional feature that users cry for.
	function widget_mypictures_control($number) {

		global $twitpic_options;

		// Get our options and see if we're handling a form submission.
		$options = get_option('widget_mypictures');
		
		if ( isset($_POST['twitpic-submit']) ) {
		
			foreach($twitpic_options['widget_fields'] as $key => $field) {
				$options[$number][$key] = $field['default'];
				$field_name = sprintf('%s_%s_%s', $twitpic_options['prefix'], $key, $number);

				if ($field['type'] == 'text') {
					$options[$number][$key] = strip_tags(stripslashes($_POST[$field_name]));
				} elseif ($field['type'] == 'checkbox') {
					$options[$number][$key] = isset($_POST[$field_name]);
				} elseif ($field['type'] == 'radio') {
					if (! empty($options[$number][$key])) {
						$field_checked = 'checked="checked"';
					}
					
					$cssRadioGroup .= '<div class="audioboo_field_radio_row"><input type="radio" name="audiobooradiogroup" value="' . $field_name .'" '. $field_checked . '>' . $field['label'] . "</div>";
					if ($key == 'customCSS') {
						$cssRadioGroup .= '<span style="font-size: 9px;">(selected themes folder)</span>';
						$rt_field_value = htmlspecialchars($options[$number][$key . "_name"], ENT_QUOTES);
						$rt_field_name = $field_name . "_name";
						$cssRadioGroup .= sprintf('<br><input class="audiobooradiogroupinputtext" id="%s" name="%s" type="text" value="%s"/>', $rt_field_name, $rt_field_name, $rt_field_value);
					}
					//$cssRadioGroup .= '<br>';
					continue;
				}
			}

			update_option('widget_mypictures', $options);
		}

		foreach($twitpic_options['widget_fields'] as $key => $field) {
			
			$field_name = sprintf('%s_%s_%s', $twitpic_options['prefix'], $key, $number);
			$field_checked = '';
			if ($field['type'] == 'text') {
				$field_value = htmlspecialchars($options[$number][$key], ENT_QUOTES);
			} elseif ($field['type'] == 'checkbox') {
				$field_value = 1;
				if (! empty($options[$number][$key])) {
					$field_checked = 'checked="checked"';
				}
			}
			
			printf('<p style="text-align:right;" class="twitpic_field"><label for="%s">%s <input id="%s" name="%s" type="%s" value="%s" class="%s" %s /></label></p>',
				$field_name, __($field['label']), $field_name, $field_name, $field['type'], $field_value, $field['type'], $field_checked);
		}
		echo '<input type="hidden" id="twitpic-submit" name="twitpic-submit" value="1" />';
	}
	

	function widget_mypictures_setup() {
		$options = $newoptions = get_option('widget_mypictures');
		
		if ( isset($_POST['twitpic-number-submit']) ) {
			$number = (int) $_POST['twitpic-number'];
			$newoptions['number'] = $number;
		}
		
		if ( $options != $newoptions ) {
			update_option('widget_mypictures', $newoptions);
			widget_mypictures_register();
		}
	}
	
	function widget_mypictures_register() {
		
		$options = get_option('widget_mypictures');
		$dims = array('width' => 300, 'height' => 300);
		$class = array('classname' => 'widget_mypictures');

		for ($i = 1; $i <= 9; $i++) {
			$name = sprintf(__('My Pictures'), $i);
			$id = "twitpic-$i"; // Never never never translate an id
			wp_register_sidebar_widget($id, $name, $i <= $options['number'] ? 'widget_mypictures' : /* unregister */ '', $class, $i);
			wp_register_widget_control($id, $name, $i <= $options['number'] ? 'widget_mypictures_control' : /* unregister */ '', $dims, $i);
		}
		
		add_action('sidebar_admin_setup', 'widget_mypictures_setup');
	}

	widget_mypictures_register();
}

/* WACHT MET HET UITVOEREN VAN DE CODE */
/* wanneer er een plugin is die voorang wil */

add_action('widgets_init', 'widget_mypictures_init');

?>