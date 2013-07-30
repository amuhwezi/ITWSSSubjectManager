<?php
  /*
	Plugin Name: Subject Manager
	Version: 0.1
	Plugin URI :
	Author: Abias&Arnold
	Author URI://www.itwss.co.ug
	Description: Manage Subjects by adding papers and combinations. This plugin works along side afew others to make up a school report management system.
	License: GPLv2
	*/

			
			include("includes/god.php");
			add_action('init','createtables');
			add_shortcode('form', 'subjectform');
			add_shortcode('show', 'fetchall');
			add_shortcode('comb', 'newcombination');
			add_shortcode('dispcomb', 'displaycombinations');
			
