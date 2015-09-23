<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = 'ct_mb_';

global $meta_boxes;

$meta_boxes = array();

/*-----------------------------------------------------------------------------------*/
/* SIDEBAR POSITION
/*-----------------------------------------------------------------------------------*/
$meta_boxes[] = array(
	'id'		=> 'ct_sidebar_settings',
	'title'		=> __('Sidebar Position', 'color-theme-framework'),
	'pages'		=> array( 'post', 'page' ),
	'context'	=> 'normal', // Where the meta box appear: normal (default), advanced, side. Optional.
	'priority'	=> 'high',
	'fields'	=> array(
		array(
			'name'     => __('Sidebar Position', 'color-theme-framework'),
			'id'       => "{$prefix}sidebar_position",
			'type'     => 'select',
			'std'		=> __('Select Position', 'color-theme-framework'),
			'options'  => array(
				'right' => 'Right',
				'left' => 'Left'
			),
		),
	)
);


/*-----------------------------------------------------------------------------------*/
/* Page Description
/*-----------------------------------------------------------------------------------*/
$meta_boxes[] = array(
	'id'		=> 'ct_page_settings',
	'title'		=> __('Custom Page Description', 'color-theme-framework'),
	'pages'		=> array( 'page' ),
	'context'	=> 'normal', // Where the meta box appear: normal (default), advanced, side. Optional.
	'priority'	=> 'high',
	'fields'	=> array(
		array(
			'name' => __('Custom Page Description', 'color-theme-framework'),
			'desc' => __('Text for page description. Appears under page title.', 'color-theme-framework'),
			'id'   => "{$prefix}page_desc",
			'type' => 'textarea',
			'cols' => '20',
			'rows' => '3',
		),
	)
);

/*-----------------------------------------------------------------------------------*/
/* CUSTOM BACKGROUND SETTINGS
/*-----------------------------------------------------------------------------------*/
$meta_boxes[] = array(
	'id'		=> 'ct_custom_backgrounds',
	'title'		=> __('Custom Background Settings for the Single Post', 'color-theme-framework'),
	'pages'		=> array( 'post', 'page' ),
	'context'	=> 'normal', // Where the meta box appear: normal (default), advanced, side. Optional.
	'priority'	=> 'high',
	'fields'	=> array(
		array(
			'name'		=> __('Custom Background Image', 'color-theme-framework'),
			'id'		=> "{$prefix}background_image",
			//'type'		=> 'thickbox_image',
			'type'				=> 'image_advanced',
			'max_file_uploads'	=> 1,
			'desc'		=> __('Upload a custom background image for this page. Once uploaded, click "Insert to Post".', 'color-theme-framework'),
		),
		array(
			'name'     => __('Custom Background Repeat', 'color-theme-framework'),
			'id'       => "{$prefix}background_repeat",
			'type'     => 'select',
			'std'		=> __('Select an Item', 'color-theme-framework'),
			'options'  => array(
				'no-repeat' => 'No Repeat',
				'repeat' => 'Repeat',
				'repeat-x' => 'Repeat Horizontally',
				'repeat-y' => 'Repeat Vertically',
			),
		),
		array(
			'name'     => __('Custom Background Position', 'color-theme-framework'),
			'id'       => "{$prefix}background_position",
			'type'     => 'select',
			'std'		=> __('Select an Item', 'color-theme-framework'),
			'options'  => array(
				'left' => 'Left',
				'right' => 'Right',
				'center' => 'Centered',
				'full' => 'Full Screen',
			),
		),
		array(
			'name'     => __('Custom Background Attachment', 'color-theme-framework'),
			'id'       => "{$prefix}background_attachment",
			'type'     => 'select',
			'std'		=> __('Select an Item', 'color-theme-framework'),
			'options'  => array(
				'fixed' => 'Fixed',
				'scroll' => 'Scroll',
			),
		),
		array(
			'name' => __('Custom Background Color', 'color-theme-framework'),
			'id'   => "{$prefix}background_color",
			'type' => 'color',
			'desc' => __('Select a custom background color for the uploaded image.', 'color-theme-framework'),
			'std' => '',
		),

	)
);


// Metabox for Post Format: Gallery
$meta_boxes[] = array(
	'title'		=> __('Post Format: Gallery', 'color-theme-framework'),
	'pages' => array( 'post' ),
	'id'		=> 'ct_gallery_format',
	'fields'	=> array(
		array(
			'name'				=> __('Add Images for Gallery', 'color-theme-framework'),
			'id'				=> "{$prefix}gallery",
			'type'				=> 'image_advanced',
			'max_file_uploads'	=> 20,
		),
	)
);


// Metabox for Post Format: Video
$meta_boxes[] = array(
	'id' => 'ct_video_format',
	'title' => __('Post Format: Video', 'color-theme-framework'),
	'pages' => array( 'post' ),
	'context' => 'normal', // Where the meta box appear: normal (default), advanced, side. Optional.
	'priority' => 'high',
	'fields' => array(
		array(
			'name'     => __('Type of Video', 'color-theme-framework'),
			'id'       => "{$prefix}post_video_type",
			'type'     => 'select',
			'std'		=> __('Select an Item', 'color-theme-framework'),
			'options'  => array(
				'vimeo' => 'Vimeo',
				'youtube' => 'Youtube',
				'dailymotion' => 'Dailymotion'
			),
			'multiple' => false,
		),

		array(
			'name'  => __('Video ID', 'color-theme-framework'),
			'id'    => "{$prefix}post_video_file",
			'desc'  => __('Enter Video ID (example: WluQQiXKVc8)', 'color-theme-framework'),
			'type'  => 'text',
			'std'   => '',
			'clone' => false,
		),
        array(
			'name'     => __('Type of Video Thumbnail', 'color-theme-framework'),
			'desc'  => __('Choose the type of thumbnail: auto generated from video service or use featured image', 'color-theme-framework'),
			'id'       => "{$prefix}post_video_thumb",
			'type'     => 'select',
			'std'		=> __('Select an Item', 'color-theme-framework'),
			'options'  => array(
				'player' => 'Iframe player',
				'featured' => 'Featured image'
			),
			'multiple' => false,
        ),

	)
);


// Metabox for Post Format: Audio
$meta_boxes[] = array(
	'id' => 'ct_audio_format',
	'title' => __('Post Format: Audio', 'color-theme-framework'),
	'pages' => array( 'post' ),
	'context' => 'normal', // Where the meta box appear: normal (default), advanced, side. Optional.
	'priority' => 'high',
	'fields' => array(
		array(
			'name'		=> __('Type of Audio Thumbnail (for Blog, Widgets, etc.)', 'color-theme-framework'),
			//'desc'		=> __('Choose the type of thumbnail : iframe player or featured image', 'color-theme-framework' ),
			'id'		=> "{$prefix}post_audio_thumb",
			'type'		=> 'select',
			'std'		=> __('Select an Item', 'color-theme-framework'),
			'options'	=> array(
				'player'	=> 'Iframe Player',
				'featured' => 'Featured Image',
			),
			'multiple' => false,
		),
		array(
			'name'  => __('Soundcloud', 'color-theme-framework'),
			'id'    => "{$prefix}post_soundcloud",
			'desc'  => __('Paste code from Soundcloud Service', 'color-theme-framework'),
			'type'  => 'textarea',
			'std'   => '',
			'clone' => false,
		),
	)
);

// Metabox for Post Format: Audio
$meta_boxes[] = array(
	'id' => 'ct_copy_format',
	'title' => __("Article's copyright", 'color-theme-framework'),
	'pages' => array( 'post' ),
	'context' => 'normal', // Where the meta box appear: normal (default), advanced, side. Optional.
	'priority' => 'high',
	'fields' => array(
		array(
			'name'  => __('Copyrights', 'color-theme-framework'),
			'id'    => "{$prefix}post_copyright",
			'desc'  => __('Paste copyrights for the article', 'color-theme-framework'),
			'type'  => 'textarea',
			'std'   => '',
			'clone' => false,
		),
	)
);



/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function ct_register_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $meta_boxes;
	foreach ( $meta_boxes as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'ct_register_meta_boxes' );