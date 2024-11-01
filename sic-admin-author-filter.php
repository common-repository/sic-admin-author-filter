<?php
/**
 * Plugin Name: SIC Admin Author Filter
 * Plugin URI: http://www.strategic-ic.co.uk
 * Description: This is a plugin for allowing user to set label for title field of each post type.If no label specified it will get the default one.
 * Version: 1.0
 * Author: Jipson Thomas
 * Author URI: http://www.jipsonthomas.com
 * License: A "Slug" license name e.g. GPL2
 *
 *
 * Copyright (c) 2014 Jipson Thomas <jipson@cstrategic-ic.co.uk>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit
 * persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 *   The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 **/

defined('ABSPATH') or die("Cannot access pages directly.");
class sic_admin_auther_filter_class {
	public function __construct() {
		add_action('restrict_manage_posts',array( $this, 'sic_author_filter' ));
        
    }
	
	function sic_author_filter() {
		$args = array('name' => 'author', 'show_option_all' => 'View all authors');
		if (isset($_GET['user'])) {
			$args['selected'] = $_GET['user'];
		}
		$all_users = get_users();
		$specific_users = array();
		$i = 0;
		foreach($all_users as $user){
		
			if($user->has_cap('publish_posts')){
				$specific_users[$i]['id'] = $user->data->ID;
				if($user->data->display_name != '' && $user->data->display_name != ' '){
					$specific_users[$i]['name'] = $user->data->display_name;
				}else{
					$specific_users[$i]['name'] = $user->data->user_name;
				}
				 $i++;
			}
		
		}
		if(isset($specific_users) && !empty($specific_users)){
			echo '<select name="author" id="author"><option value="0">View all authors</option>';
			foreach($specific_users as $usr){
				if (isset($_GET['author']) && $_GET['author'] == $usr['id']) {
					$sel = 'selected=selected';
				}else{
					$sel = '';
				}
				echo '<option value="'.$usr['id'].'" '.$sel.'>'.$usr['name'].'</option>';
			}
			
			echo '</select>';
		}
		
	}
   
}

/* initiate class */
$sic_admin_auther_filter_class_obj = new sic_admin_auther_filter_class;