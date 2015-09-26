<?php
global $itMinisites;

/**
 * Class: ITMinisite
 *
 * Description: This is the custom post type that the framework uses for its Custom Minisites.
 *
 */
class ITMinisite {
	public $id = null; //full id, like "it_music_reviews" (system setting)											
	public $name = null; //something like "casino" or "music"																						
	public $enabled = true; //this minisite is enabled		
	public $excluded = false; //this minisite is excluded from the main loop														
	public $post_type_vars = null; //the variables (system setting)														
	public $taxonomies = array(); //array of custom taxonomies
	public $criteria = array(); //array of rating criteria
	public $details = array(); //array of custom meta fields
	public $awards = array(); //array of awards
	public $rating_metric = 'stars'; //stars, percentage, number, or letter
	public $color_ranges_disable = false; //change rating colors based on ranges (does not apply to stars)	
	public $editor_rating_disable = false; //disable editor ratings completely
	public $user_rating_disable = false; //disable user ratings completely
	public $editor_rating_hide = false; //hide editor ratings on post thumbnails
	public $user_rating_hide = false; //hide user ratings on post thumbnails	
	
	public $logobar_disable = false;
	public $logo_disable = false;
	public $ad_header_disable = false;
	public $logo_url = null; #minisite logo
	public $logo_url_hd = null;
	public $logo_width = null;
	public $logo_height = null;
	public $sticky_logo_url = null; #sticky minisite logo
	public $sticky_logo_url_hd = null;
	public $sticky_logo_width = null;
	public $sticky_logo_height = null;
	public $icon = null; #minisite icon to display on front-facing site
	public $iconwhite = null; #minisite icon to display on front-facing site for dark backgrounds
	public $iconhd = null; #minisite icon to display on front-facing site on hd displays
	public $iconhdwhite = null; #minisite icon to display on front-facing site for dark backgrounds on hd displays
	public $bg_color = null; 
	public $bg_color_override = false; 
	public $bg_image = null; 
	public $bg_position = null; 
	public $bg_repeat = null; 
	public $bg_attachment = null;
	public $color_accent = null;
	public $color_boxes_1 = null;
	public $color_boxes_2 = null;
	public $color_boxes_3 = null;
	public $color_boxes_4 = null;
	
	public $front_1 = null;
	public $front_2 = null;
	public $front_3 = null;
	public $front_4 = null;
	public $front_5 = null;
	public $front_6 = null;
	public $front_7 = null;
	public $front_8 = null;
	public $front_9 = null;
	public $front_10 = null;
	public $front_11 = null;
	public $targeted_sliders = true;
	public $featured_layout = 'medium';
	public $boxes_layout = 'a';
	
	public $loop_title_disable = false; #disable layout title
	public $filtering_disable = false; #disable filter buttons
	public $layout = 'a'; #layout of the post loop
	
	public $default_post_type = null;
	public $post_layout = null;
	public $post_featured_image_size = null;
	public $postnav_disable = false;
	public $sortbar_label_disable = false;
	public $sortbar_awards_disable = false;
	public $sortbar_views_disable = false;
	public $sortbar_likes_disable = false;
	public $sortbar_comments_disable = false;
	public $date_disable = false;
	public $details_position = 'top';
	public $proscons_position = 'top';
	public $ratings_position = 'top';
	public $bottomline_position = 'top';
	public $positives_label = null;
	public $negatives_label = null;
	public $bottomline_label = null;
	public $total_score_label = null;
	public $total_user_score_label = null;
	public $user_ratings_number_disable = false;
	public $rating_animations_disable = false;
	public $taxonomies_hide = false;
	public $badges_hide = false;
	public $details_hide = false;
	public $details_label = null;
	public $postinfo_disable = false;
	public $likes_disable = false;
	public $categories_disable = false;
	public $tags_disable = false;
	public $author_disable = false;
	public $recommended_disable = false;
	public $recommended_label = null;
	public $recommended_filters_num = 3;
	public $recommended_filters_disable = false;
	public $recommended_num = 6;
	public $recommended_method = 'tags';
	public $recommended_targeted = false;
	public $user_comment_rating_disable = false;
	public $user_comment_procon_disable = false;
	public $allow_blank_comments = true;
	
	public $topmenu_disable = false; #hide top menu for this minisite
	public $taxonomy_submenu = false; #hide submenu for this minisite
	public $unique_sidebar = false; #use a unique sidebar
	public $content_disable = false; #hide content on the front page
	public $ad_background = null; #URL for background ad						

	function __construct($options){
		foreach($options as $opt_id => $option){
			$this->$opt_id = $option;
			#echo 'opt_id=' . $opt_id . '<br />' . 'option=' . $option . '<br /><br />';
		}
		
		$var_safe_name = strtolower(str_replace(str_split("\\/ &'-"), "_", $this->name));
		$this->safe_name = $var_safe_name;
		
		#generate minisite id
		$prefix = 'it_';
		if(it_get_setting('legacy')) $prefix = 'os_'; #legacy prefix
		#find user specified slug
		$var_safe_id = strtolower(str_replace(str_split("\\/ &'-"), "_", $this->id));
		#set the url safe name (do this before we add the prefix below)
		$this->url_name = it_get_url_slug($this->name, $var_safe_id);
		#add prefix
		$var_safe_id = $prefix . $var_safe_id;
		#trim to 20 characters (wp imposed max)
		$var_safe_id = substr($var_safe_id, 0, 20);
		#set the id
		$this->id = $var_safe_id;	
		#get white icon first if available
		$minisite_icon = empty($this->iconwhite) ? $this->icon : $this->iconwhite;	

		if(!isset($this->post_type_vars)){
			$this->post_type_vars = array(
				'labels' => array(
					'name' => ucwords($this->name) . __( ' Articles' , IT_TEXTDOMAIN),
					'singular_name' => ucwords($this->name) . __( ' Article' , IT_TEXTDOMAIN),
					'add_new' => __('Add new article', IT_TEXTDOMAIN),
					'edit_item' => __('Edit article', IT_TEXTDOMAIN),
					'new_item' => __('New article', IT_TEXTDOMAIN),
					'view_item' => __('View article', IT_TEXTDOMAIN),
					'search_items' => __('Search articles', IT_TEXTDOMAIN),
					'not_found' => __('No articles found', IT_TEXTDOMAIN),
					'not_found_in_trash' => __('No articles found in Trash', IT_TEXTDOMAIN)
				),
				'public' => true,
				'menu_position' => 27,
				'menu_icon' => $minisite_icon,
				#'rewrite' => array('slug' => $this->url_name . '-detail'), #legacy
				'rewrite' => array('slug' => $this->url_name),
				'supports' => array('title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','publicize','wpcom-markdown'),
				'taxonomies' => array('category', 'post_tag'),
				'show_in_nav_menus' => true,
				'has_archive' => true
			);
		}

		$this->create_more_link();
	}

	public function create_more_link(){
		$moreLink = null;
		$args = array('post_type' => 'page',
			'posts_per_page' => 1,
			'meta_query' => array(
				array(
					'key' => '_select_minisite',
					'value' => $this->id,
					'compare' => 'LIKE'
				)
			)
		);
		$postcount=0;
		$moreLinkLoop = new WP_Query( $args );
		if ($moreLinkLoop->have_posts()) : while ($moreLinkLoop->have_posts()) : $moreLinkLoop->the_post(); $postcount++;
			$moreLink = get_permalink();
			endwhile;
		endif;
		
		$this->more_link = $moreLink;

	}

	public function create_minisite(){
		if($this->enabled){
			add_action( 'init', array($this, 'register_minisite') );
		}
	}

	public function register_minisite(){
		register_post_type( $this->id, $this->post_type_vars);
		if(is_array($this->taxonomies)) {	
			foreach($this->taxonomies as $taxonomy){			
				if(is_array($taxonomy)) {
					if(array_key_exists(0, $taxonomy)) {
						$taxonomy_name = $taxonomy[0]->name;
						$taxonomy_slug = $taxonomy[0]->slug;
						$taxonomy_url = $taxonomy[0]->url_name;
						$labels = array(
							'name' => _x( ucwords($taxonomy_name), 'taxonomy general name' ),
							'singular_name' => _x( ucwords($taxonomy_name), 'taxonomy singular name' ),
							'search_items' =>  __( 'Search ', IT_TEXTDOMAIN ).ucwords($taxonomy_name),
							'all_items' => __( 'All ', IT_TEXTDOMAIN ).ucwords($taxonomy_name),
							'parent_item' => __( 'Parent ', IT_TEXTDOMAIN ).ucwords($taxonomy_name),
							'parent_item_colon' => __( 'Parent ', IT_TEXTDOMAIN ).ucwords($taxonomy_name).':',
							'edit_item' => __( 'Edit ', IT_TEXTDOMAIN ).ucwords($taxonomy_name), 
							'update_item' => __( 'Update ', IT_TEXTDOMAIN ).ucwords($taxonomy_name),
							'add_new_item' => __( 'Add New ', IT_TEXTDOMAIN ).ucwords($taxonomy_name),
							'new_item_name' => __( 'New ', IT_TEXTDOMAIN ).ucwords($taxonomy_name).__(' Name', IT_TEXTDOMAIN),
							'menu_name' => ucwords($taxonomy_name),
						);
						register_taxonomy(
							$taxonomy_slug,
							array($this->id),
							array(
								'hierarchical' => true,
								'labels' => $labels,
								'query_var' => true,
								'rewrite' => array('slug' => $taxonomy_url),
								'capabilities' => array(
												'manage_terms' => 'edit_posts',
												'edit_terms' => 'edit_posts',
												'delete_terms' => 'edit_posts',
												'assign_terms' => 'edit_posts'
											)
							)
						);
						#echo "tax_slug=".$taxonomy_slug."<br />this->id=".$this->id."<br /><br />";
					}
				}
			}
			#die();
		}
	}

	public function get_taxonomy_by_id($taxId){
		foreach($this->taxonomies as $tax){
			if($tax[0]->id == $taxId){
				return $tax[0];
			}
		}
	}

	public function get_taxonomy_by_name($taxName){
		foreach($this->taxonomies as $tax){
			if($tax[0]->name == $taxName){
				return $tax[0];
			}
		}
	}

	public function get_primary_taxonomy(){
		foreach($this->taxonomies as $tax){
			if($tax[0]->isPrimary){
				return $tax[0];
			}
		}
	}	
}

/**
 * Class: itTaxonomy
 *
 * new itTaxonomy(string name [, boolean isPrimary, boolean includeInExcerpt, string id, string slug]);
 *
 * name = the user visible name, example: Type
 * isPrimary = [optional] whether the taxonomy is the "primary" taxonomy. defaults to false
 * includeInExcerpt = [optional] whether it should show up in the excerpt box, defaults to true
 * id = [optional] the unique id for this taxonomy, example: casino_type, defaults to 'casino_' . strtolower($name)
 * slug = [optional] the slug, example: casino-type, defaults to 'casino-' . strtolower($name)
 */
class itTaxonomy{
	public $isPrimary = false;
	public $minisite_slug = null;
	public $id = null;
	public $name = null;
	public $safe_name = null;			
	public $slug = null;
	public $url_name = null;

	function __construct($minisite_slug, $name, $id, $isPrimary = NULL, $slug = NULL, $url_name = NULL){	
				
		$var_safe_name = str_replace(str_split('\\/ '), '_', $name);
		$var_slug = $minisite_slug . '_' . strtolower(str_replace(str_split("\\/ &'-"), "_", $id));
		$var_url = str_replace('_','-',$var_slug);
		
		$this->name = $name;
		$this->safe_name = $var_safe_name;
		$this->id = $id;		
		
		if(!isset($slug)){
			$this->slug = $var_slug;
		}else{
			$this->slug = $slug;
		}
		
		if(!isset($url_name)){
			$this->url_name = $var_url;
			/*
			if you don't want the post type name appended to the beginning of the taxonomy name in the permalink
			and only want the name of the taxonomy, comment out the line above and use the line below instead.
			please note you cannot have taxonomies with the same name in multiple minisites if you do this.
			also note that if you change this you will need to refresh your permalinks (go to Settings >> Permalinks and click Save) 
			*/			
			#$this->url_name = strtolower(str_replace(str_split("\\/ &'_"), "-", $id));
		}else{
			$this->url_name = $url_name;
		}
	
		if(isset($isPrimary)){
			$this->isPrimary = $isPrimary;
		}
	}
}

/**
 * Class: itAward
 *
 * new itAward(string name);
 *
 * name = the user visible name, example: Editor's Choice
 */
class itAward{
	public $name = null;
	public $icon = null;
	public $iconhd = null;
	public $iconwhite = null;
	public $iconhdwhite = null;
	public $isBadge = false;

	function __construct($name, $icon, $iconhd, $iconwhite = NULL, $iconhdwhite = NULL, $isBadge = false){
		$this->name = $name;
		$this->icon = $icon;
		$this->iconhd = $iconhd;
		$this->iconwhite = $iconwhite;
		$this->iconhdwhite = $iconhdwhite;
		$this->isBadge = $isBadge;
	}
}

/**
 * Class: itDetail
 *
 * new itDetail(string name);
 *
 * name = the user visible name, example: Type
 */
class itDetail{
	public $name = null;
	public $safe_name = null;
	public $meta_name = null;

	function __construct($name, $safe_name = NULL, $meta_name = NULL){
		$this->name = $name;
		
		$safe_name = strtolower(str_replace(str_split("\\/ &'-"), "_", $name));
        $meta_name = '_'.$safe_name;
		
		$this->safe_name = $safe_name;
		$this->meta_name = $meta_name;
	}
}

/**
 * Class: itCriteria
 *
 * new itCriteria(string name, string weight);
 *
 * name = the name of the custom meta field used for the criteria, example: Usability
 * weight = the multiplier of the criteria, example: 2
 */
class itCriteria {
	public $name = null;
	public $weight = null;	
	public $safe_name = null;
	public $meta_name = null;

	function __construct($name, $weight, $safe_name = NULL, $meta_name = NULL){
		$this->name = $name;
		$this->weight = $weight;
		
		$safe_name = strtolower(str_replace(str_split("\\/ &'-"), "_", $name));
        $meta_name = '_'.$safe_name;
		
		$this->safe_name = $safe_name;
		$this->meta_name = $meta_name;
	}
}

//singleton, instantiation to immediately follow. You should NEVER say new itMinisites() anywhere else!
class itMinisites {
	public $minisites;

	function __construct(){
		//if you create a new PostType Object, add it to this array
		$possiblePostTypes = array();

		if(function_exists('add_post_types')){
			$possiblePostTypes = add_post_types($possiblePostTypes);
		}

		$this->minisites = array();
		foreach($possiblePostTypes as $minisite){
			//echo "<!-- post type: $minisite->name -->";
			$this->minisites[$minisite->id] = $minisite;/*replaced name*/
		}
	}

	/**
	 * Method: has_type
	 *
	 * A utility function to determine if there is a post type named "n",
	 * or, if has post type with id of "n"
	 *
	 * Example:
	 *	if($itMinisites->has_type("movie")){
	 *		echo "<h1>YEAH</h1>";
	 *	}else{
	 *		echo "<h1>nope</h1>";
	 *	}
	 *
	 * Can also be used like (to signify passed value is an id):
	 *	if($itMinisites->has_type("it_movie", true)){
	 *		echo "<h1>YEAH</h1>";
	 *	} else {
	 *		echo "<h1>nope</h1>";
	 *	}
	 */
	function has_type($type, $byId = NULL){
		if(!isset($byId)){
			$byId = false;
		}

		//echo "<!-- looking for $type by id? $byId -->";

		if($byId && !empty($this->minisites[$type])){
			//echo "<!-- has $type type -->";
			return true;
		}else if(!$byId){
			//echo "<!-- looking for $type by name. -->";
			foreach($this->minisites as $minisite){
				if($type == $minisite->name){
					//echo "<!-- has $type type -->";
					return true;
				}
			}
		}

		//echo "<!-- DOES NOT HAVE $type type -->";
		//echo "<!--";
		//print_r($this->minisites);
		//echo "-->";

		return false;
	}

	/**
	 * Method: get_type_by_name
	 *
	 * A utility function that returns the post type with a given name
	 *
	 * Example:
	 *	$minisite = itMinisites->get_type_by_name("products");
	 */
	function get_type_by_name($type){
		foreach($this->minisites as $minisite){
			if($minisite->name == $type){
				return $minisite;
			}
		}
	}

	/**
	 * Method: get_type_by_id
	 *
	 * A utility function that returns the post type with a given id
	 *
	 * Example:
	 *	$minisite = itMinisites->get_type_by_id(it_products");
	 */
	function get_type_by_id($type){
		$m = false;
		if(is_array($this->minisites) && !empty($type)) {
			if(array_key_exists($type, $this->minisites)) {
				$m = $this->minisites[$type];
			}
		}
		return $m;
	}	
}

#instantiate single instance of itMinisites to be used throughout site
$itMinisites = new itMinisites();

# create each minisite CPT
foreach($itMinisites->minisites as $minisite){
	if($minisite->enabled){
		$minisite->create_minisite();
	}
}

#function to add the post types
function add_post_types($possiblePostTypes){
	//get the minisites and loop through them to set each one up
	$minisite = it_get_setting('minisite');
	if ( isset($minisite['keys']) && $minisite['keys'] != '#' ) {
        $minisite_keys = explode(',',$minisite['keys']);
        foreach ($minisite_keys as $mkey) {
            if ( $mkey != '#') {
				//get main minisite info to build with
				$minisite_name = ( !empty( $minisite[$mkey]['name'] ) ) ? $minisite[$mkey]['name'] : '';
				$minisite_slug = it_get_slug($minisite[$mkey]['slug'], $minisite_name);					
				$minisite_enabled = ( !empty( $minisite[$mkey]['enabled'] ) ) ? $minisite[$mkey]['enabled'] : '0';
				$minisite_excluded = ( !empty( $minisite[$mkey]['excluded'] ) ) ? $minisite[$mkey]['excluded'] : '0';
	
				if($minisite_slug!='') {					
					$taxonomies = it_get_setting('taxonomies_'.$minisite_slug);
					$details = it_get_setting('details_'.$minisite_slug);
					$criteria = it_get_setting('criteria_'.$minisite_slug);	
					$awards = it_get_setting('awards_'.$minisite_slug);				
					array_push($possiblePostTypes, new ITMinisite(
						array(
							'id' => $minisite_slug,
							'name' => $minisite_name,
							'enabled' => $minisite_enabled,
							'excluded' => $minisite_excluded,
							'criteria' => $criteria,
							'details' => $details, 	
							'taxonomies' => $taxonomies,
							'awards' => $awards,
							'color_ranges_disable' => it_get_setting('color_ranges_disable_'.$minisite_slug),
							'rating_metric' => it_get_setting('rating_metric_'.$minisite_slug),
							'editor_rating_disable' => it_get_setting('editor_rating_disable_'.$minisite_slug),
							'user_rating_disable' => it_get_setting('user_rating_disable_'.$minisite_slug),
							'editor_rating_hide' => it_get_setting('editor_rating_hide_'.$minisite_slug),
							'user_rating_hide' => it_get_setting('user_rating_hide_'.$minisite_slug),							
							
							'logobar_disable' => it_get_setting('logobar_disable_'.$minisite_slug),	
							'logo_disable' => it_get_setting('logo_disable_'.$minisite_slug),	
							'ad_header_disable' => it_get_setting('ad_header_disable_'.$minisite_slug),
							'logo_url' => it_get_setting('logo_url_'.$minisite_slug),	
							'logo_url_hd' => it_get_setting('logo_url_hd_'.$minisite_slug),	
							'logo_width' => it_get_setting('logo_width_'.$minisite_slug),	
							'logo_height' => it_get_setting('logo_height_'.$minisite_slug),	
							'sticky_logo_url' => it_get_setting('sticky_logo_url_'.$minisite_slug),	
							'sticky_logo_url_hd' => it_get_setting('sticky_logo_url_hd_'.$minisite_slug),	
							'sticky_logo_width' => it_get_setting('sticky_logo_width_'.$minisite_slug),	
							'sticky_logo_height' => it_get_setting('sticky_logo_height_'.$minisite_slug),					
							'icon' => it_get_setting('icon_'.$minisite_slug),
							'iconwhite' => it_get_setting('iconwhite_'.$minisite_slug),
							'iconhd' => it_get_setting('iconhd_'.$minisite_slug),
							'iconhdwhite' => it_get_setting('iconhdwhite_'.$minisite_slug),
							'bg_color' => it_get_setting('bg_color_'.$minisite_slug),
							'bg_color_override' => it_get_setting('bg_color_override_'.$minisite_slug),
							'bg_image' => it_get_setting('bg_image_'.$minisite_slug),
							'bg_position' => it_get_setting('bg_position_'.$minisite_slug),
							'bg_repeat' => it_get_setting('bg_repeat_'.$minisite_slug),
							'bg_attachment' => it_get_setting('bg_attachment_'.$minisite_slug),
							'color_accent' => it_get_setting('color_accent_'.$minisite_slug),
							'color_boxes_1' => it_get_setting('color_boxes_1_'.$minisite_slug),							
							'color_boxes_2' => it_get_setting('color_boxes_2_'.$minisite_slug),	
							'color_boxes_3' => it_get_setting('color_boxes_3_'.$minisite_slug),	
							'color_boxes_4' => it_get_setting('color_boxes_4_'.$minisite_slug),	
								
							'front_1' => it_get_setting('front_1_'.$minisite_slug),
							'front_2' => it_get_setting('front_2_'.$minisite_slug),
							'front_3' => it_get_setting('front_3_'.$minisite_slug),
							'front_4' => it_get_setting('front_4_'.$minisite_slug),
							'front_5' => it_get_setting('front_5_'.$minisite_slug),
							'front_6' => it_get_setting('front_6_'.$minisite_slug),
							'front_7' => it_get_setting('front_7_'.$minisite_slug),
							'front_8' => it_get_setting('front_8_'.$minisite_slug),
							'front_9' => it_get_setting('front_9_'.$minisite_slug),
							'front_10' => it_get_setting('front_10_'.$minisite_slug),
							'front_11' => it_get_setting('front_11_'.$minisite_slug),
							'targeted_sliders' => it_get_setting('targeted_sliders_'.$minisite_slug),							
							'featured_layout' => it_get_setting('featured_layout_'.$minisite_slug),	
							'boxes_layout' => it_get_setting('boxes_layout_'.$minisite_slug),	
							
							'loop_title_disable' => it_get_setting('loop_title_disable_'.$minisite_slug),
							'filtering_disable' => it_get_setting('filtering_disable_'.$minisite_slug),
							'layout' => it_get_setting('layout_'.$minisite_slug),
							
							'default_post_type' => it_get_setting('default_post_type_'.$minisite_slug),
							'post_layout' => it_get_setting('post_layout_'.$minisite_slug),
							'post_featured_image_size' => it_get_setting('post_featured_image_size_'.$minisite_slug),
							'postnav_disable' => it_get_setting('postnav_disable_'.$minisite_slug),
							'sortbar_label_disable' => it_get_setting('sortbar_label_disable_'.$minisite_slug),
							'sortbar_awards_disable' => it_get_setting('sortbar_awards_disable_'.$minisite_slug),
							'sortbar_views_disable' => it_get_setting('sortbar_views_disable_'.$minisite_slug),
							'sortbar_likes_disable' => it_get_setting('sortbar_likes_disable_'.$minisite_slug),
							'sortbar_comments_disable' => it_get_setting('sortbar_comments_disable_'.$minisite_slug),
							'date_disable' => it_get_setting('date_disable_'.$minisite_slug),
							'details_position' => it_get_setting('details_position_'.$minisite_slug),
							'proscons_position' => it_get_setting('proscons_position_'.$minisite_slug),
							'ratings_position' => it_get_setting('ratings_position_'.$minisite_slug),
							'bottomline_position' => it_get_setting('bottomline_position_'.$minisite_slug),
							'positives_label' => it_get_setting('positives_label_'.$minisite_slug),
							'negatives_label' => it_get_setting('negatives_label_'.$minisite_slug),
							'bottomline_label' => it_get_setting('bottomline_label_'.$minisite_slug),
							'total_score_label' => it_get_setting('total_score_label_'.$minisite_slug),
							'total_user_score_label' => it_get_setting('total_user_score_label_'.$minisite_slug),
							'user_ratings_number_disable' => it_get_setting('user_ratings_number_disable_'.$minisite_slug),	
							'rating_animations_disable' => it_get_setting('rating_animations_disable_'.$minisite_slug),	
							'taxonomies_hide' => it_get_setting('taxonomies_hide_'.$minisite_slug),	
							'badges_hide' => it_get_setting('badges_hide_'.$minisite_slug),	
							'details_hide' => it_get_setting('details_hide_'.$minisite_slug),	
							'details_label' => it_get_setting('details_label_'.$minisite_slug),
							'postinfo_disable' => it_get_setting('postinfo_disable_'.$minisite_slug),	
							'likes_disable' => it_get_setting('likes_disable_'.$minisite_slug),	
							'categories_disable' => it_get_setting('categories_disable_'.$minisite_slug),	
							'tags_disable' => it_get_setting('tags_disable_'.$minisite_slug),	
							'author_disable' => it_get_setting('author_disable_'.$minisite_slug),	
							'recommended_disable' => it_get_setting('recommended_disable_'.$minisite_slug),
							'recommended_label' => it_get_setting('recommended_label_'.$minisite_slug),
							'recommended_filters_num' => it_get_setting('recommended_filters_num_'.$minisite_slug),
							'recommended_filters_disable' => it_get_setting('recommended_filters_disable_'.$minisite_slug),
							'recommended_num' => it_get_setting('recommended_num_'.$minisite_slug),
							'recommended_method' => it_get_setting('recommended_method_'.$minisite_slug),
							'recommended_targeted' => it_get_setting('recommended_targeted_'.$minisite_slug),
							'user_comment_rating_disable' => it_get_setting('user_comment_rating_disable_'.$minisite_slug),
							'user_comment_procon_disable' => it_get_setting('user_comment_procon_disable_'.$minisite_slug),
							'allow_blank_comments' => it_get_setting('allow_blank_comments_'.$minisite_slug),
							
							'topmenu_disable' => it_get_setting('topmenu_disable_'.$minisite_slug),
							'taxonomy_submenu' => it_get_setting('taxonomy_submenu_'.$minisite_slug),
							'unique_sidebar' => it_get_setting('unique_sidebar_'.$minisite_slug),
							'content_disable' => it_get_setting('content_disable_'.$minisite_slug),
							'ad_background' => it_get_setting('ad_background_'.$minisite_slug),
							'child_theme_post_type' => false
						)
					));
				}
			}
		}
	// echo "<pre>";
	// print_r($possiblePostTypes);
	// echo "</pre>";
	}
	return $possiblePostTypes;
}
?>