<?php

class ET_Builder_Module_Image_N10S extends ET_Builder_Module {

    public $slug       = 'et_pb_image_n10s';
	public $vb_support = 'on';

	function init() {
		$this->name = esc_html__( 'Image Intense', 'et_builder' );
		$this->main_css_element = '%%order_class%%' . ' .n10s-block';
		$this->fb_support = false;

		$this->whitelisted_fields = array(
			'src',
			'size',
			'alt',
			'title_text',
			'n10s_type',
			'title1_overlay',
			'title2_overlay',
			'header_font_size',
			'header_font_size_tablet',
			'header_font_size_phone',
			'caption_overlay',
			'caption_orientation',
			'text_font_size',
			'text_font_size_tablet',
			'text_font_size_phone',
			'show_in_lightbox',
			'image_as_url',
			'url',
			'url_new_window',
			'include_button',
			'button_url',
			'button_url_new_window',
			'button_text',
			'button_position',
			'animation',
			'sticky',
			'align',
			'max_width',
			'max_width_tablet',
			'max_width_phone',
			'always_center_on_mobile',
			'mix_blend_mode',
			'image_alpha',
			'image_alpha_hover',
			'use_overlay_gradient',
			'overlay_color1',
			'overlay_color2',
			'overlay_color_stop1',
			'overlay_color_stop2',
			'overlay_orientation',
			'overlay_color1_hover',
			'overlay_color2_hover',
			'overlay_color_stop1_hover',
			'overlay_color_stop2_hover',
			'overlay_orientation_hover',
			'disabled_on',
			'admin_label',
			'module_id',
			'module_class'
		);
		
		$this->fields_defaults = array(
			'size'						=> array( 'full' ),
			'n10s_type'					=> array( 'auckland' ),
			'show_in_lightbox'      	=> array( 'off' ),
			'url_new_window'        	=> array( 'off' ),
			'include_button'			=> array( 'off' ),
			'animation'             	=> array( 'left' ),
			'sticky'                	=> array( 'off' ),
			'align'                 	=> array( 'left' ),
			'always_center_on_mobile' 	=> array( 'on' ),
			'mix_blend_mode'			=> array( 'normal' ),
			'button_position'			=> array( 'middle-center' ),
			'button_url_new_window'		=> array( 'off' ),
			'header_font_size'			=> array( '26px' ),
			'image_alpha'				=> array( '1'),
			'image_alpha_hover'			=> array( '1'),
			'text_font_size'			=> array( '14px' ),
			'caption_orientation'		=> array( 'center' ),
			'use_overlay_gradient' 		=> array( 'off' ),
			'overlay_color_stop1'  		=> array( '0' ),
			'overlay_color_stop2'  		=> array( '100' ),
			'overlay_color_stop1_hover' => array( '0' ),
			'overlay_color_stop2_hover' => array( '100' )
		);

		$this->options_toggles = array(
			// Content tab
			'general'  => array(
				'toggles' => array(
					'main_content'	 => esc_html__( 'Image',  'et_builder' ),
					'text_general'	 => esc_html__( 'Text',   'et_builder' ),
					'link'			 => esc_html__( 'Link',   'et_builder' ),
					'button_general' => esc_html__( 'Button', 'et_builder' ),
				),
			),
			// Design tab
			'advanced' => array(
				'toggles' => array(
					'overlay'    => esc_html__( 'Overlay',   'et_builder' ),
					'alignment'  => esc_html__( 'Alignment', 'et_builder' ),
					'width'      => array(
						'title'    => esc_html__( 'Sizing',  'et_builder' ),
						'priority' => 65,
					),
				),
			),
			// Advanced tab
			'custom_css' => array(
				'toggles' => array(
					'animation' => array(
						'title'    => esc_html__( 'Animation', 'et_builder' ),
						'priority' => 90,
					),
					'attributes' => array(
						'title'    => esc_html__( 'Attributes', 'et_builder' ),
						'priority' => 95,
					),
				),
			),
		);

		// These will appear on the Design tab
		$this->advanced_options = array(
			'fonts' => array(
				'header'   => array(
					'label'			  => esc_html__( 'Title', 'et_builder' ),
					'hide_font_size'  => array( 'true' ),
					'line_height'     => array(
						'default' => '1em',
					),
					'css'			  => array(
						'main' 		  => "{$this->main_css_element} h2",
					),
				),
				'text' => array(
					'label'			  => esc_html__( 'Caption', 'et_builder' ),
					'hide_font_size'  => array( 'true' ),
					'line_height'     => array(
						'default' 	  => '1.2em'
					),
					'css'			  => array(
						'main' => "{$this->main_css_element} p",
					),
				),
			),
			'border'                => array(
				'css'			  => array(
					'main' => "{$this->main_css_element} .n10s-overlay",
				),
			),
			'custom_margin_padding' => array(
				'css' => array(
					// 'important' => 'all',
				),
			),
			'background' => array(
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'button' => array(
				'button' => array(
					'label' => esc_html__( 'Button', 'et_builder' ),
					'css' => array(
						'main' => $this->main_css_element . ' a.et_pb_promo_button.et_pb_button'
					),
				),
			)
			
		);
	}
	
	// There is an Image Intense "shortcode" available:
	//   {n10slink} for regular hyptertext anchor links.
	//   See if Title or Caption content has this and process accordingly.
	private function maybe_do_n10s_shortcode( $content ) {
		
		// Return empty content passed in if nothing there - save some time
		if ( '' == $content ) {
			return $content;
		}
		
		// Set some position indicators
		$n10s_anchor_link_pos  = false;
		
		// Define available shortcodes, then test to see if either one is present in content
		// We'll use these to see if n10s shortcodes are within the content.
		// Not testing for closing curly braces allows all attributes for the anchor tag
		//  as easily as possible.
		$n10s_anchor_shortcode     = '{n10slink';
		$n10s_anchor_shortcode_end = '{/n10slink';
		
		// See if we have a basic anchor link "shortcode"
		$n10s_anchor_link_pos = strpos( $content, $n10s_anchor_shortcode );
		
		if ( false !== $n10s_anchor_link_pos ) {
			// We found an n10s anchor shortcode. 
			//  Replace curly braces and codes with actual HTML anchor tag and appropriate class.
			$content = str_replace($n10s_anchor_shortcode, '<a class="n10s-anchor" ', $content);
			$content = str_replace($n10s_anchor_shortcode_end, '</a', $content);
			$content = str_replace('}', '>', $content);
			
			// That's all - send it back!
			return $content;
		}
		
		// Fall back in case of nothing else
		return $content;
	}

	// Get a list of available media sizes
	private function getImageSizes( $size='' ) {
		global $_wp_additional_image_sizes;
		$sizes = array();
		$get_intermediate_image_sizes = get_intermediate_image_sizes();
		
		// Create the full array with sizes and crop info
		foreach ($get_intermediate_image_sizes as $_size) {
			
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
				// The default WordPress media sizes
				$sizes[$_size]['name']   = $_size;
				$sizes[$_size]['width']  = get_option( $_size . '_size_w' );
				$sizes[$_size]['height'] = get_option( $_size . '_size_h' );
				$sizes[$_size]['crop']   = (bool) get_option( $_size . '_crop' );
				
				$sizes[$_size]['desc']   = $_size . 
											': ' . 
											$sizes[$_size]['width'] . 
											'x' . 
											$sizes[$_size]['height'] .
											' (' .
											( $sizes[$_size]['crop'] ? 'Cropped)' : 'No crop)' );
											
			} elseif ( isset( $_wp_additional_image_sizes[$_size] ) ) {
				// Media sizes added by themes, plugins, etc.
				$sizes[$_size] = array(
					'name'   => $_size,
					'width'  => $_wp_additional_image_sizes[$_size]['width'],
					'height' => $_wp_additional_image_sizes[$_size]['height'],
					'crop'   => $_wp_additional_image_sizes[$_size]['crop'],
					'desc'   => $_size .
								': ' .
								$_wp_additional_image_sizes[$_size]['width'] .
								'x' .
								$_wp_additional_image_sizes[$_size]['height'] .
								' (' .
								( $_wp_additional_image_sizes[$_size]['crop'] ? 'Cropped)' : 'No crop)')
				);
			}
		}

		if ( $size ) {
			if ( isset( $sizes[$size] ) ) {
				return $sizes[$size];
			} else {
				return FALSE;
			}
		}
		return $sizes;
	}
	
	private function get_image_url_by_size( $image_url, $size) {
		
		global $wpdb;
		$prefix = $wpdb->prefix;		// wp_ is not always the table prefix!
		$table  = $prefix . 'posts';

        // $attachment = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM {$table} WHERE guid = %s;", 
        //                                                  $image_url )
		//                                  );
		
		$attachment = attachment_url_to_postid($image_url);
		
		// If the media size was not found, let's try using the full attachment URL to find the right GUID
		if ( !isset( $attachment ) || $attachment == false ) {

            // Add the site URL to the image attachment info
            $site_url = site_url();

            // $attachment = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM {$table} WHERE guid = %s;", 
            //                                                  $site_url . $image_url )
			//                                  );
			
			$attachment = attachment_url_to_postid($image_url);
		}
		
		// If we didn't find media size the 2nd time, we will just return the original image.
		//  It's possible the site URL has changed, which means it will not be possible to
		//  get media sizes until the wp_posts table attachments have the guid field updated.
		if ( !isset( $attachment ) || $attachment == false ) {
			$image_url_by_size = $image_url;
		} else {
			
			// Attempt to get the image for the specified media size
			$image_thumb = wp_get_attachment_image_src( $attachment, $size );

			// Test for empty result. If the URL wasn't found, it might not have been uploaded through media,
			//  and we'll need to leave it as it was typed in.  Regenerate Thumbnails plugin might fix this problem.
			if ( !isset( $image_thumb ) || $image_thumb == false ) {
				$image_url_by_size = $image_url;
			} else {
				// Success in finding the right image!
				$image_url_by_size = $image_thumb[0];
			}
		}

		return $image_url_by_size;
}



	function get_fields() {
		
		// List of n10s media size options
		$n10s_size_options = $this->getImageSizes();
		$n10s_size_options_list = array();
		
		$n10s_size_options_list['full'] = 'full: Original media size';
		
		foreach ($n10s_size_options as $_sizes) {
			$n10s_size_options_list[$_sizes['name']] = $_sizes['desc'];
		}
		
		// List of background blend mode options
		$n10s_mix_blend_mode_options_list = array(
			'normal'		=> esc_html__( 'Normal', 'et_builder'),
			'multiply'		=> esc_html__( 'Multiply', 'et_builder'),
			'overlay'		=> esc_html__( 'Overlay', 'et_builder'),
			'screen'		=> esc_html__( 'Screen', 'et_builder'),
			'darken'		=> esc_html__( 'Darken', 'et_builder'),
			'lighten'		=> esc_html__( 'Lighten', 'et_builder'),
			'color-dodge'	=> esc_html__( 'Color dodge', 'et_builder'),
			'color-burn'	=> esc_html__( 'Color burn', 'et_builder'),
			'hard-light'	=> esc_html__( 'Hard light', 'et_builder'),
			'soft-light'	=> esc_html__( 'Soft light', 'et_builder'),
			'difference'	=> esc_html__( 'Difference', 'et_builder'),
			'exclusion'		=> esc_html__( 'Exclusion', 'et_builder'),
			'hue'			=> esc_html__( 'Hue', 'et_builder'),
			'saturation'	=> esc_html__( 'Saturation', 'et_builder'),
			'color'			=> esc_html__( 'Color', 'et_builder'),
			'luminosity'	=> esc_html__( 'Luminosity', 'et_builder')
		);
		
		// List of n10s hover style options
		$n10s_type_options_list = array(
			'auckland'	 => esc_html__( 'Auckland', 'et_builder' ),
			'berlin'	 => esc_html__( 'Berlin', 'et_builder' ),
			'cali'		 => esc_html__( 'Cali', 'et_builder' ),
			'copenhagen' => esc_html__( 'Copenhagen', 'et_builder' ),
			'dallas'	 => esc_html__( 'Dallas', 'et_builder' ),
			'douala'  	 => esc_html__( 'Douala', 'et_builder' ),
			'hanoi'	  	 => esc_html__( 'Hanoi', 'et_builder' ),
			'jerusalem'  => esc_html__( 'Jerusalem', 'et_builder' ),
			'kiev'  	 => esc_html__( 'Kiev', 'et_builder' ),
			'lisbon'	 => esc_html__( 'Lisbon', 'et_builder' ),
			'london'	 => esc_html__( 'London', 'et_builder' ),
			'madison'	 => esc_html__( 'Madison', 'et_builder' ),
			'mumbai'  	 => esc_html__( 'Mumbai', 'et_builder' ),
			'oslo'	  	 => esc_html__( 'Oslo', 'et_builder' ),
			'paris'  	 => esc_html__( 'Paris', 'et_builder' ),
			'portland'	 => esc_html__( 'Portland', 'et_builder' ),
			'rochester'	 => esc_html__( 'Rochester', 'et_builder' ),
			'seattle'	 => esc_html__( 'Seattle', 'et_builder' ),
			'seoul'	  	 => esc_html__( 'Seoul', 'et_builder' ),
			'sydney'	 => esc_html__( 'Sydney', 'et_builder' ),
			'taipei'	 => esc_html__( 'Taipei', 'et_builder' ),
			'toronto' 	 => esc_html__( 'Toronto', 'et_builder' )
		);

		// Create a list of available button CSS positions
		$n10s_button_positions_list = array(
			'top-left'		=> esc_html__( 'Top Left', 'et_builder'),
			'top-center'	=> esc_html__( 'Top Center', 'et_builder'),
			'top-right'		=> esc_html__( 'Top Right', 'et_builder'),
			'middle-left'	=> esc_html__( 'Center Left', 'et_builder'),
			'middle-center'	=> esc_html__( 'Center Center', 'et_builder'),
			'middle-right'	=> esc_html__( 'Center Right', 'et_builder'),
			'bottom-left'	=> esc_html__( 'Bottom Left', 'et_builder'),
			'bottom-center'	=> esc_html__( 'Bottom Center', 'et_builder'),
			'bottom-right'	=> esc_html__( 'Bottom Right', 'et_builder'),
		);
		
		// Create a list of overlay color orientations
		$n10s_overlay_orientations_list = array(
			'to right'		    => esc_html__( 'Horizontal →', 'et_builder'),
			'to bottom'		    => esc_html__( 'Vertical ↓', 'et_builder'),
			'to bottom right'   => esc_html__( 'Diagonal ↘', 'et_builder'),
			'to top right'      => esc_html__( 'Diagonal ↗', 'et_builder'),
			'ellipse at center' => esc_html__( 'Radial ○', 'et_builder')
		);
		
		// Create slug and names for processing
		$n10s_option_name  = sprintf( '%1$s-n10s', $this->slug );

		$default_n10s_type = ET_Global_Settings::get_value( $n10s_option_name );

		// If user modifies default hover option via Customizer, we'll need to change the order
		if ( 'auckland' !== $default_n10s_type && ! empty( $default_n10s_type ) && array_key_exists( 			$default_n10s_type, $n10s_type_options_list ) ) {

			// The options, sans user's preferred direction
			$n10s_options_wo_default = $n10s_type_options_list;
			unset( $n10s_options_wo_default[ $default_n10s_type ] );

			// All animation options
			$n10s_options = array_merge(
				array( $default_n10s_type => $n10s_type_options_list[$default_n10s_type] ),
				$n10s_options_wo_default

			);

		} else {

			// Simply copy the animation options
			$n10s_options = $n10s_type_options_list;
		}

		// List of animation options
		$animation_options_list = array(
			'left'    => esc_html__( 'Left To Right', 'et_builder' ),
			'right'   => esc_html__( 'Right To Left', 'et_builder' ),
			'top'     => esc_html__( 'Top To Bottom', 'et_builder' ),
			'bottom'  => esc_html__( 'Bottom To Top', 'et_builder' ),
			'fade_in' => esc_html__( 'Fade In', 'et_builder' ),
			'off'     => esc_html__( 'No Animation', 'et_builder' ),
		);

		$animation_option_name       = sprintf( '%1$s-animation', $this->slug );
		$default_animation_direction = ET_Global_Settings::get_value( $animation_option_name );

		// If user modifies default animation option via Customizer, we'll need to change the order
		if ( 'left' !== $default_animation_direction && ! empty( $default_animation_direction ) && array_key_exists( $default_animation_direction, $animation_options_list ) ) {
			// The options, sans user's preferred direction
			$animation_options_wo_default = $animation_options_list;
			unset( $animation_options_wo_default[ $default_animation_direction ] );

			// All animation options
			$animation_options = array_merge(
				array( $default_animation_direction => $animation_options_list[$default_animation_direction] ),
				$animation_options_wo_default
			);
		} else {
			// Simply copy the animation options
			$animation_options = $animation_options_list;
		}

		// Fields specific to this module
		$fields = array(
			'src' => array(
				'label'              => esc_html__( 'Image URL', 'et_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Find an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'affects'            => array(
					'alt',
					'title_text',
				),
				'description'        => esc_html__( 'Click FIND AN IMAGE to access your media library to select or upload your desired image. Or, type in the URL of the image you would like to display.', 'et_builder' ),
				'toggle_slug'        => 'main_content',
			),
			'size' => array(
				'label'			  => esc_html__( 'Media size', 'et_bulder' ),
				'type'			  => 'select',
				'option_category' => 'configuration',
				'options'		  => $n10s_size_options_list,
				'description'	  => 'Select the best media size for your usage in this module.  This will typically be based on number of columns and/or website content (boxed layout) width. For more info, please <a href="https://besuperfly.com/image-intense-documentation" target="_blank">see the documentation</a>. If you select a size but your image displays at the normal size, you may need to <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a>.',
				'toggle_slug'        => 'main_content',
			),
			'alt' => array(
				'label'           => esc_html__( 'Image Alt Text', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'This sets the text for the image\'s HTML \'alt\' attribute. A short description of your image can be placed here for SEO and accessibility purposes. Note that you must specify this if you want it to be part of your HTML, even if you have done so in the WP media library.', 'et_builder' ),
				'toggle_slug'	  => 'attributes',
				'tab_slug' 		  => 'custom_css',
			),
			'title_text' => array(
				'label'           => esc_html__( 'Image Title Text', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'This sets the text for the image\'s HTML \'title\' attribute. Note that you must specify this if you want it to be part of your HTML, even if you have done so in the WP media library.', 'et_builder' ),
				'toggle_slug'	  => 'attributes',
				'tab_slug' 		  => 'custom_css',
			),
			'n10s_type' => array(
				'label'			  => esc_html__( 'Intense Hover Style', 'et_bulder' ),
				'type'			  => 'select',
				'option_category' => 'configuration',
				'options'		  => $n10s_options,
				'description'	  => 'Select the Intense Hover Style effect type for this module. Hover Style effects are <a href="https://besuperfly.com/image-intense-divi-extra/" target="_blank">listed here</a>.',
				'toggle_slug'        => 'main_content',
			),
			'title1_overlay' => array(
				'label'           => esc_html__( 'Overlay Title Part 1', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => 'This is the first half of the overlay title (header) text. Normally this is best with just one or two words. For this, the Overlay Title Part 2 (below), and the Overlay Caption Text (below), you can use <code>&lt;b&gt;</code>, <code>&lt;br&gt;</code>, <code>&lt;em&gt;</code>, <code>&lt;i&gt;</code> or <code>&lt;strong&gt;</code> tags here. The <code>{n10slink}</code> pseudo-shortcode can be used as well to generate a normal hypertext link. See the <a href="https://besuperfly.com/how-to-style-image-intense-plugin/" target="_blank">documentation</a> for more info.',
				'toggle_slug'     => 'text_general',
			),
			'title2_overlay' => array(
				'label'           => esc_html__( 'Overlay Title Part 2', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'This is the second (bolded in most hover styles) half of the overlay title text. Normally this is best with just one or two words.', 'et_builder' ),
				'toggle_slug'     => 'text_general',
			),
			'caption_overlay' => array(
				'label'           => esc_html__( 'Overlay Caption Text', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'This is the typically smaller overlay caption text. The number of words you should use here depends on the Intense Hover Style selected above along with the size of the column this module is in. Most (but not all) Intense Hover Styles include a caption.', 'et_builder' ),
				'toggle_slug'     => 'text_general',
			),
			'caption_orientation' => array(
				'label'             => esc_html__( 'Caption Orientation', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'layout',
				'options'           => array(
										'left'    => esc_html__( 'Left', 'et_builder' ),
										'center'  => esc_html__( 'Center', 'et_builder' ),
										'right'   => esc_html__( 'Right', 'et_builder' ),
										'justify' => esc_html__( 'Justified', 'et_builder' ),
										),
				'description'       => esc_html__( 'This controls the how your Overlay Caption Text is aligned within the space assigned it by the Hover Style. For example, a Hover Style may only assign 50% of the width to caption text, so your caption will be aligned within that space.', 'et_builder' ),
				'toggle_slug'     => 'text_general',
			),
			'show_in_lightbox' => array(
				'label'           => esc_html__( 'Open Image in Lightbox', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( "No", 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'affects'		  => array(
					'#et_pb_image_as_url',
					'#et_pb_hover_icon_lightbox_color'
				),
				'description'     => esc_html__( 'Selecting "Yes" will cause the module image to be opened up in a lightbox when clicked/tapped.', 'et_builder' ),
				'toggle_slug'     => 'link',
			),
			'image_as_url' => array(
				'label'           => esc_html__( 'Use Image as URL', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( "No", 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'affects'           => array(
					'#et_pb_url',
					'#et_pb_url_new_window',
					'#et_pb_hover_icon_url_color'
				),
				'depends_show_if' => 'off',
				'description'     => esc_html__( 'Selecting "Yes" will give you the option to specify a URL that your module should open when it is clicked/tapped.  This works only if you select "No" to the "Open Image in Lightbox" option above.', 'et_builder' ),
				'toggle_slug'     => 'link',
			),
			'url' => array(
				'label'           => esc_html__( 'Link URL', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Your module will go to this destination URL when clicked/tapped.', 'et_builder' ),
				'toggle_slug'     => 'link',
			),
			'url_new_window' => array(
				'label'           => esc_html__( 'URL Opens', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In A New Tab', 'et_builder' ),
				),
				'description'     => esc_html__( 'Here you can choose whether or not your link (not Lightbox) opens in a new window.', 'et_builder' ),
				'toggle_slug'     => 'link',
			),
			'include_button' => array(
				'label'			  => esc_html__( 'Include a Button'),
				'type'			  => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( "No", 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'affects'		  => array(
					'#et_pb_button_url',
					'#et_pb_button_url_new_window',
					'#et_pb_button_text',
					'#et_pb_button_position'
				),
				'description'     => esc_html__( 'Select "Yes" to add a styled/CTA button to your Image Intense module. Use the "Design" tab to style the button beyond the Divi theme defaults.', 'et_builder' ),
				'toggle_slug'     => 'button_general',
			),
			'button_url' => array(
				'label'           => esc_html__( 'Button URL', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the destination URL for your Image Intense button.', 'et_builder' ),
				'toggle_slug'     => 'button_general',
			),
			'button_url_new_window' => array(
				'label'           => esc_html__( 'Button Url Opens', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'In The Same Tab', 'et_builder' ),
					'on'  => esc_html__( 'In A New Tab', 'et_builder' ),
				),
				'description'       => esc_html__( 'Defines whether your Image Intense button opens its link in the same tab or a new one.', 'et_builder' ),
				'toggle_slug'     => 'button_general',
			),
			'button_text' => array(
				'label'           => esc_html__( 'Button Text', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the text for your Image Intense button link.', 'et_builder' ),
				'toggle_slug'     => 'button_general',
			),
			'button_position' => array(
				'label'			  => esc_html__( 'Button Position', 'et_builder'),
				'type'			  => 'select',
				'option_category' => 'layout',
				'options'		  => $n10s_button_positions_list,
				'description'	  => "Specify the button position. Note that 'center' is horizontal and 'middle' is vertical.",
				'toggle_slug'     => 'button_general',
			),
			'animation' => array(
				'label'           => esc_html__( 'Module Animation Direction', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => $animation_options,
				'description'     => esc_html__( 'Set the direction of the animation when the image comes into view on your page.', 'et_builder' ),
				'toggle_slug'	  => 'animation',
				'tab_slug' 		  => 'custom_css',
			),
			'sticky' => array(
				'label'           => esc_html__( 'Remove Space Below The Image', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'layout',
				'options'         => array(
					'off'     => esc_html__( 'No', 'et_builder' ),
					'on'      => esc_html__( 'Yes', 'et_builder' ),
				),
				'description'     => esc_html__( 'Selecting Yes will remove the default padding/margin below the image.', 'et_builder' ),
				'toggle_slug'	  => 'alignment',
				'tab_slug' 		  => 'advanced',
			),
			'align' => array(
				'label'           => esc_html__( 'Image Alignment', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options' => array(
					'left'   => esc_html__( 'Left', 'et_builder' ),
					'center' => esc_html__( 'Center', 'et_builder' ),
					'right'  => esc_html__( 'Right', 'et_builder' ),
				),
				'description'     => esc_html__( 'Select the alignment that will be used for the image within this column.', 'et_builder' ),
				'toggle_slug'	  => 'alignment',
				'tab_slug' 		  => 'advanced',
			),
			'max_width' => array(
				'label'           => esc_html__( 'Image Max Width', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'alignment',
				'mobile_options'  => true,
				'validate_unit'   => true,
				'description'     => esc_html__( 'Input a value plus a unit of measurement. e.g. 100px or 25vh. Placing a value here will also allow you to set mobile options.', 'et_builder' ),
			),
			'max_width_last_edited' => array(
				'type'     => 'skip',
				'tab_slug' => 'advanced',
			),
			'max_width_tablet' => array(
				'type' => 'skip',
				'tab_slug' => 'advanced'
			),
			'max_width_phone' => array(
				'type' => 'skip',
				'tab_slug' => 'advanced'
			),
			'always_center_on_mobile' => array(
				'label'           => esc_html__( 'Always Center Image On Mobile', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'layout',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( "No", 'et_builder' ),
				),
				'toggle_slug'	  => 'alignment',
				'tab_slug' 		  => 'advanced',
			),
			'mix_blend_mode' => array(
				'label'			  => esc_html__( 'Mix Blend Mode', 'et_builder'),
				'type'			  => 'select',
				'option_category' => 'layout',
				'tab_slug'		  => 'advanced',
				'options'		  => $n10s_mix_blend_mode_options_list,
				'description'	  => "This will define how the module's contents should color blend with its background elements.  See <a href='https://css-tricks.com/almanac/properties/m/mix-blend-mode/' target='_blank'>CSS Tricks</a> for more information. <b>Note:</b> Should be used with caution. Some or all of this feature <a href='http://caniuse.com/#search=mix-blend-mode' target='_blank'>may not work</a> on certain browsers!",
				'toggle_slug' => 'overlay',
			),
			'image_alpha' => array(
				'label'           => esc_html__( 'Image Opacity', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'configuration',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '1.0',
					'step' => '0.05',
				),
				'default'		  => '1',
				'description'	  => esc_html__( 'Set the image opacity (transparency) in the normal state. Valid values are anything between 0 and 1.', 'et_builder'),
				//'tab_slug' 		  => 'advanced',
				'validate_unit'   => false,
				'toggle_slug'     => 'main_content',
			),
			'image_alpha_hover' => array(
				'label'           => esc_html__( 'Image Opacity On Hover', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'configuration',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '1.0',
					'step' => '0.05',
				),
				'default'		  => '1',
				'description'	  => esc_html__( 'Set the image opacity (transparency) when hovered over.', 'et_builder'),
				//'tab_slug' 		  => 'advanced',
				'validate_unit'   => false,
				'toggle_slug'     => 'main_content',
			),
			'use_overlay_gradient' => array(
				'label'           => esc_html__( 'Use Custom Overlay Gradient', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'layout',
				'options'         => array(
					'off'     => esc_html__( 'No', 'et_builder' ),
					'on'      => esc_html__( 'Yes', 'et_builder' ),
				),
				'affects'		  => array(
					'#et_pb_overlay_color1',
					'#et_pb_overlay_color2',
					'#et_pb_overlay_color_stop1',
					'#et_pb_overlay_color_stop2',
					'#et_pb_overlay_orientation',
					'#et_pb_overlay_color1_hover',
					'#et_pb_overlay_color2_hover',
					'#et_pb_overlay_color_stop1_hover',
					'#et_pb_overlay_color_stop2_hover',
					'#et_pb_overlay_orientation_hover',
				),
				'description'     => "<br />Some hover style effects come with their own overlay color/gradient settings for normal (at rest) and on hover. Selecting Yes will allow you to create a custom gradient overlay color by specifying beginning and ending color stops with a position for each. You can also set an orientation (direction) for the gradient. To get an idea of how this works, visit the <a href='http://www.colorzilla.com/gradient-editor/' target='_blank'>ColorZilla Gradient Generator</a>.",
				'toggle_slug'	  => 'overlay',
				'tab_slug' 		  => 'advanced',
			),
			'overlay_orientation' => array(
				'label'			  => esc_html__( 'Overlay Gradient Orientation', 'et_builder'),
				'type'			  => 'select',
				'option_category' => 'layout',
				'depends_show_if' => 'on',
				'toggle_slug'	  => 'overlay',
				'tab_slug' 		  => 'advanced',
				'options'		  => $n10s_overlay_orientations_list,
				'description'	  => "This will define how the module's overlay gradient will orient - the direction of the color change."
			),
			'overlay_color1' => array(
				'label'           => esc_html__( 'Overlay Beginning Stop Color', 'et_builder' ),
				'type'            => 'color-alpha',
				// 'option_category'	=> 'color_option',
				'custom_color'    => true,
				'depends_show_if' => 'on',
				'description'     => esc_html__( 'Set the beginning overlay stop color. Hint: to get the same color/gradient on both normal and hover states, use the same colors and stop positions for both states.', 'et_builder' ),
				'toggle_slug'	  => 'overlay',
				'tab_slug' 		  => 'advanced',
			),
			'overlay_color_stop1' => array(
				'label'           => esc_html__( 'Overlay Beginning Stop Position', 'et_builder' ),
				'type'            => 'range',
				'default'		  => '0',
				'option_category' => 'configuration',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'description'	  => esc_html__( 'Set the % position of where the starting overlay color will begin to change. Your overlay gradient will be filled with the Beginning Stop Color until this point in your module.', 'et_builder'),
				'toggle_slug'	  => 'overlay',
				'tab_slug' 		  => 'advanced',
				'validate_unit'   => false,
				'depends_show_if'   => 'on',
			),
			'overlay_color2' => array(
				'label'           => esc_html__( 'Overlay Ending Stop Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'custom_color'    => true,
				'depends_show_if' => 'on',
				'description'     => esc_html__( 'Set the ending overlay stop color.', 'et_builder' ),
				'toggle_slug'	  => 'overlay',
				'tab_slug' 		  => 'advanced',
			),
			'overlay_color_stop2' => array(
				'label'           => esc_html__( 'Overlay Ending Stop Position', 'et_builder' ),
				'type'            => 'range',
				'default'		  => '100',
				'option_category' => 'configuration',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'description'	  => esc_html__( 'Set the % position of where the ending overlay color will stop changing. From this point on, your module will be overlayed with the Ending Stop Color.', 'et_builder'),
				'toggle_slug'	  => 'overlay',
				'tab_slug' 		  => 'advanced',
				'validate_unit'   => false,
				'depends_show_if' => 'on',
			),
			'overlay_orientation_hover' => array(
				'label'			  => esc_html__( 'Overlay Gradient Orientation On Hover', 'et_builder'),
				'type'			  => 'select',
				'option_category' => 'layout',
				'depends_show_if' => 'on',
				'toggle_slug'	  => 'overlay',
				'tab_slug' 		  => 'advanced',
				'options'		  => $n10s_overlay_orientations_list,
				'description'	  => "This will define how the module's overlay gradient will orient on hover - the direction of the color change on hover."
			),
			'overlay_color1_hover' => array(
				'label'           => esc_html__( 'Overlay Beginning Stop Color On Hover', 'et_builder' ),
				'type'            => 'color-alpha',
				'option_category' => 'color_option',
				'custom_color'    => true,
				'depends_show_if' => 'on',
				'description'     => esc_html__( 'Set the beginning overlay stop color on hover. Hint: to get the same color/gradient on both normal and hover states, use the same colors and stop positions for both states.', 'et_builder' ),
				'toggle_slug'	  => 'overlay',
				'tab_slug' 		  => 'advanced',
			),
			'overlay_color_stop1_hover' => array(
				'label'           => esc_html__( 'Overlay Beginning Stop Position On Hover', 'et_builder' ),
				'type'            => 'range',
				'default'		  => '0',
				'option_category' => 'configuration',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'description'	  => esc_html__( 'Set the % position of where the starting overlay color will begin to change on hover. Your overlay gradient will be filled with the Beginning Stop Color until this point in your module.', 'et_builder'),
				'toggle_slug'	  => 'overlay',
				'tab_slug' 		  => 'advanced',
				'validate_unit'   => false,
				'depends_show_if' => 'on',
			),
			'overlay_color2_hover' => array(
				'label'           => esc_html__( 'Overlay Ending Stop Color On Hover', 'et_builder' ),
				'type'            => 'color-alpha',
				'custom_color'    => true,
				'depends_show_if' => 'on',
				'description'     => esc_html__( 'Set the ending overlay stop color on hover.', 'et_builder' ),
				'toggle_slug'	  => 'overlay',
				'tab_slug' 		  => 'advanced',
			),
			'overlay_color_stop2_hover' => array(
				'label'           => esc_html__( 'Overlay Ending Stop Position On Hover', 'et_builder' ),
				'type'            => 'range',
				'default'		  => '100',
				'option_category' => 'configuration',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'description'	  => esc_html__( 'Set the % position of where the ending overlay color will stop changing on hover. From this point on, your module will be overlayed with the Ending Stop Color.', 'et_builder'),
				'toggle_slug'	  => 'overlay',
				'tab_slug' 		  => 'advanced',
				'validate_unit'   => false,
				'depends_show_if' => 'on',
			),
			'disabled_on' => array(
				'label'           => esc_html__( 'Disable on', 'et_builder' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'et_builder' ),
					'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
					'desktop' => esc_html__( 'Desktop', 'et_builder' ),
				),
				'additional_att'  => 'disable_on',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'This will disable (hide) Image Intense on the devices selected above, based on the native Divi media queries.', 'et_builder' ),
				'toggle_slug'	  => 'visibility',
				'tab_slug' 		  => 'custom_css',
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will set the module label within the Builder for easier identification.', 'et_builder' ),
				'toggle_slug' => 'admin_label',
			),
			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'header_font_size' => array(
				'label'           => esc_html__( 'Title Font Size', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'header',
				'mobile_options'  => true,
				'default'		  => '26px',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'description'     => esc_html__( 'Specify the font size for the Title 1 and Title 2 texts.  Additional Title styling options appear below.', 'et_builder' ),
			),
			'header_font_size_tablet' => array(
				'type'		  => 'skip',
				'tab_slug'	  => 'advanced',
				'toggle_slug' => 'header',
			),
			'header_font_size_phone' => array(
				'type'		  => 'skip',
				'tab_slug'	  => 'advanced',
				'toggle_slug' => 'header',
			),
			'text_font_size' => array(
				'label'           => esc_html__( 'Caption Font Size', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'mobile_options'  => true,
				'default'		  => '14px',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'description'     => esc_html__( 'Specify the font size for the Caption text.   Additional Caption styling options appear below.', 'et_builder' ),
			),
			'text_font_size_tablet' => array(
				'type'		  => 'skip',
				'tab_slug'	  => 'advanced',
				'toggle_slug' => 'header',
			),
			'text_font_size_phone' => array(
				'type'		  => 'skip',
				'tab_slug'	  => 'advanced',
				'toggle_slug' => 'header',
			),
		);

		return $fields;
	}

	public function get_custom_css_fields_config() {
		// return array(
		// 	'alpha' => array(
		// 		'label'    => esc_html__( 'Alpha Hover', 'et_pb_image_n10s' ),
		// 		'selector'    => '%%order_class%% .n10s-block img',
		// 	),
		// 	'alpha_hover' => array(
		// 		'label'    => esc_html__( 'Alpha Hover', 'et_pb_image_n10s' ),
		// 		'selector'    => '%%order_class%% .n10s-block:hover img',
		// 	)
		// );
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id              		= $this->props['module_id'];
		$module_class            		= $this->props['module_class'];
		$src                     		= $this->props['src'];
		$size							= $this->props['size'];
		$alt                     		= $this->props['alt'];
		$title_text              		= $this->props['title_text'];
		$n10s_type				 		= $this->props['n10s_type'];
		$overlay_title1			 		= $this->props['title1_overlay'];
		$overlay_title2			 		= $this->props['title2_overlay'];
		$overlay_header_font_size		= $this->props['header_font_size'];
		$overlay_header_font_size_t		= $this->props['header_font_size_tablet'];
		$overlay_header_font_size_p		= $this->props['header_font_size_phone'];
		$overlay_caption		 		= $this->props['caption_overlay'];
		$overlay_caption_orientation 	= $this->props['caption_orientation'];
		$overlay_text_font_size			= $this->props['text_font_size'];
		$overlay_text_font_size_t		= $this->props['text_font_size_tablet'];
		$overlay_text_font_size_p		= $this->props['text_font_size_phone'];
		$show_in_lightbox        		= $this->props['show_in_lightbox'];
		$image_as_url 					= $this->props['image_as_url'];
		$url                     		= $this->props['url'];
		$url_new_window          		= $this->props['url_new_window'];
		$include_button					= $this->props['include_button'];
		$button_url						= $this->props['button_url'];
		$button_url_new_window			= $this->props['button_url_new_window'];
		$button_text					= $this->props['button_text'];
		$custom_icon          			= $this->props['button_icon'];
		$button_custom        			= $this->props['custom_button'];
		$animation              		= $this->props['animation'];
		$sticky                 		= $this->props['sticky'];
		$align                  		= $this->props['align'];
		$max_width              		= $this->props['max_width'];
		$max_width_tablet       		= $this->props['max_width_tablet'];
		$max_width_phone        		= $this->props['max_width_phone'];
		$always_center_on_mobile		= $this->props['always_center_on_mobile'];
		$mix_blend_mode					= $this->props['mix_blend_mode'];
		$button_position				= $this->props['button_position'];
		$image_alpha					= $this->props['image_alpha'];
		$image_alpha_hover				= $this->props['image_alpha_hover'];
		$use_overlay_gradient			= $this->props['use_overlay_gradient'];
		$overlay_color1					= $this->props['overlay_color1'];
		$overlay_color2					= $this->props['overlay_color2'];
		$overlay_color_stop1			= $this->props['overlay_color_stop1'];
		$overlay_color_stop2			= $this->props['overlay_color_stop2'];
		$overlay_orientation			= $this->props['overlay_orientation'];
		$overlay_color1_hover			= $this->props['overlay_color1_hover'];
		$overlay_color2_hover			= $this->props['overlay_color2_hover'];
		$overlay_color_stop1_hover		= $this->props['overlay_color_stop1_hover'];
		$overlay_color_stop2_hover		= $this->props['overlay_color_stop2_hover'];
		$overlay_orientation_hover		= $this->props['overlay_orientation_hover'];
		
		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		// Add the center on mobile class if needed
		if ( 'on' === $always_center_on_mobile ) {
			$module_class .= ' et_always_center_on_mobile';
		}

		// Add a class for this module based on n10s option type
		//  We'll use this class to add a class personality type and do some styling
		$n10s_class = 'n10s-' . $n10s_type;
		
		// Define some media query breakpoints 
		$media_query_desk  = '@media all and (min-width: 981px) { ';
		$media_query_tab   = '@media all and (max-width: 980px) { ';
		$media_query_phone = '@media all and (max-width: 767px) { ';
		$media_query_end   = ' }';
		
		/* ------------------ Define some styling based on module options ---------------- */
		// Style the mix blend mode
		if ( 'normal' !== $mix_blend_mode ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .n10s-block.',
				'declaration' => sprintf(
					'mix-blend-mode: %1$s;',
					esc_html( $mix_blend_mode )
				),
			) );
		}
			
		// Style the opacity for the regular state of the image itself
		if ( '1' !== $image_alpha || '' !== $image_alpha ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .n10s-block img',
				'declaration' => sprintf(
					'opacity: %1$s !important;',
					esc_html( $image_alpha )
				),
			) );
		}

		// Style the opacity for the hover/long press state of the image itself
		if ( '1' !== $image_alpha_hover || '' !== $image_alpha_hover ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .n10s-block:hover img',
				'declaration' => sprintf(
					'opacity: %1$s !important;',
					esc_html( $image_alpha_hover )
				),
			) );
		}
		
		// Do we want to use custom background color gradients?
		if ( 'on' === $use_overlay_gradient ) {
			
			// Set some variables for browser compatibility - normal (at rest) mode
			$type = 'linear-gradient';
			$w3c  = $overlay_orientation;
			$web  = '';
			
			switch ($overlay_orientation) {
				case 'to right':
					$web = 'left';
					break;
				case 'to bottom':
					$web = 'top';
					break;
				case 'to bottom right':
					$web = '-45deg';
					break;
				case 'to top right':
					$web = '45deg';
					break;
				case 'ellipse at center':
					$web  = 'center, ellipse cover';
					$type = 'radial-gradient';
			}

			// Create a background gradient for normal (at rest) CSS based on browser compatibility
			$bg_gradient_css = 
				/* FF3.6-15 */
				'background: -moz-' . $type . '(' . $web . ', ' . $overlay_color1 . ' ' . $overlay_color_stop1 . 
					'%, ' . $overlay_color2 . ' ' . $overlay_color_stop2 . '%) ;' .
				/* Chrome10-25,Safari5.1-6 */
				'background: -webkit-' . $type . '(' . $web . ', ' . $overlay_color1 . ' ' . $overlay_color_stop1 . 
					'%, ' . $overlay_color2 . ' ' . $overlay_color_stop2 . '%) ;' .
				/* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
				'background: ' . $type . '(' . $w3c . ', ' . $overlay_color1 . ' ' . $overlay_color_stop1 . 
					'%, ' . $overlay_color2 . ' ' . $overlay_color_stop2 . '%) ;';
			
			// Style the regular state (at rest) of the background gradient
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .n10s-block.' . $n10s_class . ' .n10s-overlay',
				'declaration' => sprintf(
					'%1$s',
					esc_html( $bg_gradient_css )
				),
			) );

			// Set some variables for browser compatibility - hover mode
			$type = 'linear-gradient';
			$w3c  = $overlay_orientation_hover;
			
			switch ($overlay_orientation_hover) {
				case 'to right':
					$web = 'left';
					break;
				case 'to bottom':
					$web = 'top';
					break;
				case 'to bottom right':
					$web = '-45deg';
					break;
					
				case 'to top right':
					$web = '45deg';
					break;
				case 'ellipse at center':
					$web  = 'center, ellipse cover';
					$type = 'radial-gradient';
			}

			// Create a background gradient for hover CSS based on browser compatibility
			$bg_gradient_css_hover = 
				/* FF3.6-15 */
				'background: -moz-' . $type . '(' . $web . ', ' . $overlay_color1_hover . ' ' . $overlay_color_stop1_hover . 
					'%, ' . $overlay_color2_hover . ' ' . $overlay_color_stop2_hover . '%) ;' .
				/* Chrome10-25,Safari5.1-6 */
				'background: -webkit-' . $type . '(' . $web . ', ' . $overlay_color1_hover . ' ' . $overlay_color_stop1_hover . 
					'%, ' . $overlay_color2_hover . ' ' . $overlay_color_stop2_hover . '%) ;' .
				/* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
				'background: ' . $type . '(' . $w3c . ', ' . $overlay_color1_hover . ' ' . $overlay_color_stop1_hover . 
					'%, ' . $overlay_color2_hover . ' ' . $overlay_color_stop2_hover . '%) ;';
			
			
			// Style the opacity for the hover/long press state of the background gradient
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .n10s-block.' . $n10s_class . ':hover .n10s-overlay',
				'declaration' => sprintf(
					'%1$s',
					esc_html( $bg_gradient_css_hover )
				),
			) );
		}
		// Include responsive title font sizes if specified
		if ( '' !== $overlay_header_font_size_t ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => $media_query_tab . '%%order_class%% .n10s-block h2',
				'declaration' => sprintf(
									'font-size: %1$s;' . $media_query_end,
									esc_html( $overlay_header_font_size_t )
							 	)
			) );
		}
		if ( '' !== $overlay_header_font_size_p ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => $media_query_phone . '%%order_class%% .n10s-block h2',
				'declaration' => sprintf(
									'font-size: %1$s;' . $media_query_end,
									esc_html( $overlay_header_font_size_p )
							 	)
			) );
		}

		// Set the caption orientation if not the 'center' default
		if ( 'center' !== $overlay_caption_orientation || '' !== $overlay_caption_orientation ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .n10s-block.' . $n10s_class . ' p',
				'declaration' => sprintf(
					'text-align: %1$s;',
					esc_html( $overlay_caption_orientation )
				),
			) );
		}

		// Include reponsive caption font sizes if specified
		if ( '' !== $overlay_text_font_size_t ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => $media_query_tab . '%%order_class%% .n10s-block p',
				'declaration' => sprintf(
									'font-size: %1$s;' . $media_query_end,
									esc_html( $overlay_text_font_size_t )
							 	)
			) );
		}
		if ( '' !== $overlay_text_font_size_p ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => $media_query_phone . '%%order_class%% .n10s-block p',
				'declaration' => sprintf(
									'font-size: %1$s;' . $media_query_end,
									esc_html( $overlay_text_font_size_p )
							 	)
			) );
		}

		// Include reponsive max-width if specified
		if ( '' !== $max_width ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .n10s-block',
				'declaration' => sprintf(
									'max-width: %1$s;',
									esc_html( $max_width )
								 )
			) );
		}
		if ( '' !== $max_width_tablet ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => $media_query_tab . '%%order_class%% .n10s-block',
				'declaration' => sprintf(
									'max-width: %1$s;' . $media_query_end,
									esc_html( $max_width_tablet )
								 )
			) );
		}
		if ( '' !== $max_width_phone ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => $media_query_phone . '%%order_class%% .n10s-block',
				'declaration' => sprintf(
									'max-width: %1$s;' . $media_query_end,
									esc_html( $max_width_phone )
								 )
			) );
		}

		// Module alignment options
		$justify_content   = '';
		$justify_media	   = '';
		$justify_media_end = '';
		
		// Determine our flex alignment
		switch ( $align ) {
			// We could have specified these values in the options list above,
			//  but we're doing it this way for backwards compatibility
				
			case 'left':
				$justify_content = 'flex-start';
				break;
				
			case 'center':
				$justify_content = 'center';
				break;
				
			case 'right':
				$justify_content = 'flex-end';
				break;
		}
		
		// If module is set to 'Always center on mobile',
		//  we only want to align at > 980px
		if ( 'on' === $always_center_on_mobile ) {
			$justify_media	   = '@media all and (min-width: 981px) { ';
			$justify_media_end = ' }';
		}
		ET_Builder_Element::set_style( $function_name, array(
			'selector'    => $media_query_desk . '%%order_class%%',
			'declaration' => sprintf(
				'display: flex; justify-content: %1$s;' . $media_query_end,
				esc_html( $justify_content )
				),	
		) );
		
		// To begin actual HTML generation, see if have an attachment (media) size specified
		$src_available = '';
		if ( 'full' !== $size ) {
			$src_available = $this->get_image_url_by_size( $src, $size);
			
			if ( '' !== $src_available ) {
				// Found a match on media size
				$src = $src_available;
			}
		}
			
		// Next, create the image HTML itself
		$output_img = sprintf(
			'<img src="%1$s" alt="%2$s"%3$s />',
			esc_url( $src ),
			esc_attr( $alt ),
			( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' )
		);

		// Test for anchor or button "n10s shortcodes" in either Title text or in Caption
		$overlay_title1  = $this->maybe_do_n10s_shortcode( $overlay_title1 );
		$overlay_title2  = $this->maybe_do_n10s_shortcode( $overlay_title2 );
		$overlay_caption = $this->maybe_do_n10s_shortcode( $overlay_caption );
		
		// Stubs and defaults - also prevent PHP warnings in console
		$button_position_css 			= '';
		$button_position_css_top 		= '50%';
		$button_position_css_left 		= '50%';
		$button_position_css_right 		= 'auto';
		$button_position_css_bottom 	= 'auto';
		$button_position_css_transform 	= 'translate( -50%, -50% )';
				
		// Did we ask for a button?
		$output_button = '';
		if ( 'on' === $include_button ) {
			
			// Button position options
			if ( 'middle-center' !== $button_position ) {
				
				// Let's set that CSS based on button position!
				switch ( $button_position ) {
					case 'top-left':
						$button_position_css = 
							'top: 0; ' .
							'left: 0; ' . 
							'-webkit-transform: inherit; ' .
							'transform: inherit; ';
						$button_position_css_top 		= '0';
						$button_position_css_left 		= '0';
						$button_position_css_transform 	= 'inherit';
						break;
					case 'top-center':
						$button_position_css = 
							'top: 0; ' .
							'left: 50%; ' . 
							'-webkit-transform: translateX( -50% ); ' .
							'transform: translateX( -50% ); ';
						$button_position_css_top 		= '0';
						$button_position_css_left 		= '50%';
						$button_position_css_transform 	= 'translateX( -50% )';
						break;
					case 'top-right':
						$button_position_css = 
							'top: 0; ' .
							'right: 0; ' . 
							'-webkit-transform: inherit; ' .
							'transform: inherit;';
						$button_position_css_top 		= '0';
						$button_position_css_left		= 'auto';
						$button_position_css_right 		= '0';
						$button_position_css_transform 	= 'inherit';
						break;
					case 'middle-left':
						$button_position_css = 
							'left: 0; ' . 
							'-webkit-transform: translateY( -50% ); ' .
							'transform: translateY( -50% ); ';
						$button_position_css_left 		= '0';
						$button_position_css_transform 	= 'translateY( -50% )';
						break;
					case 'middle-center':
						// Middle Center is the default - leave alone
						break;
					case 'middle-right':
						$button_position_css = 
							'right: 0; ' . 
							'-webkit-transform: translateY( -50% ); ' .
							'transform: translateY( -50% ); ';
							$button_position_css_left 		= 'auto';
							$button_position_css_right 		= '0';
							$button_position_css_transform 	= 'translateY( -50% )';
						break;
					case 'bottom-left':
						$button_position_css = 
							'bottom: 0; ' .
							'left: 0; ' . 
							'top: initial; ' . 
							'-webkit-transform: inherit; ' .
							'transform: inherit; ';
							$button_position_css_top 		= 'initial';
							$button_position_css_left 		= '0';
							$button_position_css_bottom 	= '0';
							$button_position_css_transform 	= 'inherit';
						break;
					case 'bottom-center':
						$button_position_css = 
							'bottom: 0; ' .
							'top: initial; ' . 
							'-webkit-transform: translateX( -50% ); ' .
							'transform: translateX( -50% ); ';
							$button_position_css_top 		= 'initial';
							$button_position_css_bottom 	= '0';
							$button_position_css_transform 	= 'translateX( -50% )';
						break;
					case 'bottom-right':
						$button_position_css = 
							'bottom: 0; ' .
							'top: initial; ' . 
							'left: initial; '.
							'-webkit-transform: inherit; ' .
							'transform: inherit;';
							$button_position_css_top 		= 'initial';
							$button_position_css_left 		= 'initial';
							$button_position_css_bottom 	= '0';
							$button_position_css_right	 	= '0';
							$button_position_css_transform 	= 'inherit';
						break;
				};
			};
			
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%' . ' .n10s-block .n10s-overlay > a.et_pb_promo_button.et_pb_button',
				'declaration' => sprintf(
					'top: %1$s;',
					esc_html( $button_position_css_top )
				),
			) );
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%' . ' .n10s-block .n10s-overlay > a.et_pb_promo_button.et_pb_button',
				'declaration' => sprintf(
					'left: %1$s;',
					esc_html( $button_position_css_left )
				),
			) );
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%' . ' .n10s-block .n10s-overlay > a.et_pb_promo_button.et_pb_button',
				'declaration' => sprintf(
					'bottom: %1$s;',
					esc_html( $button_position_css_bottom )
				),
			) );
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%' . ' .n10s-block .n10s-overlay > a.et_pb_promo_button.et_pb_button',
				'declaration' => sprintf(
					'right: %1$s;',
					esc_html( $button_position_css_right )
				),
			) );
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%' . ' .n10s-block .n10s-overlay > a.et_pb_promo_button.et_pb_button',
				'declaration' => sprintf(
					'-webkit-transform: %1$s;',
					esc_html( $button_position_css_transform )
				),
			) );
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%' . ' .n10s-block .n10s-overlay > a.et_pb_promo_button.et_pb_button',
				'declaration' => sprintf(
					'transform: %1$s;',
					esc_html( $button_position_css_transform )
				),
			) );
		
			// This code comes from Divi's class ET_Builder_Module_Button in mainmodules.php
			//  Basically, it says that if there is no button URL or button text then skip anyway,
			//  even if we asked for a button.
			$output_button = (
				'' !== $button_url && '' !== $button_text
					? sprintf( '<a class="et_pb_promo_button et_pb_button%5$s" href="%1$s"%3$s%4$s>%2$s</a>',
							  esc_url( $button_url ),
							  esc_html( $button_text ),
							  ( 'on' === $button_url_new_window ? ' target="_blank"' : '' ),
							  '' !== $custom_icon && 'on' === $button_custom ? sprintf(
								' data-icon="%1$s"',
								esc_attr( et_pb_process_font_icon( $custom_icon ) )
								) : '',
							  '' !== $custom_icon && 'on' === $button_custom ? ' et_pb_custom_button_icon' : ''
							)
					: ''
				);

		};

		// Almost done! Create the main block output.
		$output_blk = 
			'<div class="n10s-overlay">' .
				'<h2>' . $overlay_title1 . ' ' . 
					'<span>' . $overlay_title2 . '</span>' . 
				'</h2>' . 
				'<p class="description">' . 
					$overlay_caption .
				'</p>' .
				$output_button .
			'</div>';
				

		// If Lightbox is set to 'yes' then this entire image module will will open as a lightbox.
		if ( 'on' === $show_in_lightbox ) {
			$output = sprintf( '<div class="n10s-block %3$s"><a href="%1$s" class="et_pb_lightbox_image">%2$s%4$s</a></div>',
				esc_url( $src ),
				$output_img,
				$n10s_class,
				$output_blk
			);	
			
		// Else, if lightbox is set to 'off' then create a URL link if specified
		} elseif ( 'on' === $image_as_url ) {
			$output = sprintf( '<div class="n10s-block %4$s"><a href="%1$s" %3$s>%2$s%5$s</a></div>',
				esc_url( $url ),
				$output_img,
				( 'on' === $url_new_window ? ' target="_blank"' : '' ),
				$n10s_class,
				$output_blk
			);	
		// No lightbox or URL means no link at all
		} else {
				
			$output = sprintf( '<div class="n10s-block %2$s">%1$s%3$s</div>',
				$output_img,
				$n10s_class,
				$output_blk
			);	
		}
		
		// Set the module animation if specified, or default to the global setting
		$animation = '' === $animation ? ET_Global_Settings::get_value( 'et_pb_image-animation' ) : $animation;

		// Now, finally, we can create the total Image Intense output
		$output = sprintf(
			'<div%5$s class="et_pb_module et-waypoint et_pb_image%2$s%3$s%4$s">%1$s</div>',
			$output,
			esc_attr( " et_pb_animation_{$animation} " ),
			//( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
			$this->module_classname( $function_name ),
			( 'on' === $sticky ? esc_attr( ' et_pb_image_sticky ' ) : '' ),
			//( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' )
			$this->module_id()
		);
		
		// Add any custom module styling if specified
		// 10/2017 - no longer needed with recent Divi updates
		// $output .= '<style>' . ET_Builder_Element::get_style( false, true ) . '</style>';
		
		return $output;
	}

}
// new ET_Builder_Module_Image_N10S;
$et_builder_module_image_n10s = new ET_Builder_Module_Image_N10S();
//add_shortcode( 'et_pb_image_n10s', array($et_builder_module_image_n10s, '_shortcode_callback') );

// Admin CSS
// Added v 4.0
add_action('admin_enqueue_scripts', 'wm_superfly_image_intense_admin_css');

function wm_superfly_image_intense_admin_css() {
	wp_register_style( 'image_intense_admin_css', plugin_dir_url(__FILE__) . '/setup.css', false, '4.0' );
	wp_enqueue_style( 'image_intense_admin_css' );
}
