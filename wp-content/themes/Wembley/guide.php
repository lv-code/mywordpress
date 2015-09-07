<?php
function theme_guide(){
add_theme_page( 'Theme guide','Theme documentation','edit_themes', 'theme-documentation', 'fabthemes_theme_guide');
}
add_action('admin_menu', 'theme_guide');

function fabthemes_theme_guide(){
		echo '
		
<div id="welcome-panel" class="about-wrap">

	<div class="wpbadge" style="float:left; margin-right:30px; "><img src="'. get_template_directory_uri() . '/screenshot.png" width="250" height="200" /></div>

	<div class="welcome-panel-content">
	
	<h1>Welcome to '.wp_get_theme().' WordPress theme!</h1>
	
	<p class="about-text"> '.wp_get_theme().' is a free premium portfolio WordPress theme. This theme is built on <b>Bootstrap 3</b> framework. This is a responsive theme with all features of the awesome Bootstrap framework included. That makes this theme very extensible.</p>
	
	
		

		<div class="changelog ">
		<h3>Required plugins </h3>
		<p>The theme often requires few plugins to work the way it is originally intented to. You will find a notification on the admin panel prompting you to install the required plugins. Please install and activate the plugins.  </p>
		<ol>
			<li><a href="http://wordpress.org/extend/plugins/options-framework/">Options framework</a></li>
		</ol>
		</div>
	
	
		<div class="changelog ">
		
		<h3>Theme options explained</h3>
		<p>The theme contains an options page using which you adjust various settings available on the theme. </p>
		
		
		<p><b>Custom logo:</b>
		You can upload a custom logo image for your site. </p>
		
	
		<p><b>Welcome section</b>
		There is a welcome section on the homepage that you can customize vi the theme option page. </p>
		

		<p><b>Style settings:</b>
		You can adjust the main color scheme, link color and link hover color via the color style setting. </p>

		<p><b>Banner setting:</b>
		Configure the banner ads on the sidebar </p>

		</div>
	
				
		<div class="changelog ">
		' . file_get_contents(dirname(__FILE__) . '/FT/license-html.php') . '
		</div>
	
				


	</div>
	</div>
		
		';
		

}
