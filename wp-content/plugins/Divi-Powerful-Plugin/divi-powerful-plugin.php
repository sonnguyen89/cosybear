<?php

/*
 * Plugin Name: Divi Powerful Plugin
 * Plugin URI:  https://divipowerful.divi.help/
 * Description: All updates on Divi Powerful is included in this assitant plugin.
 * Author:      Divi Powerful
 * Version:     1.1.1
 * Author URI:  https://divi.help/
 */

if ( ! defined( 'ABSPATH' ) ) exit; 
define('DIVI_POWERFUL_PLUGIN_VERSION', '1.1.1.7');

add_action('plugins_loaded', 'divi_powerful_plugin_init');

function divi_powerful_plugin_init() {
	add_action( 'wp_enqueue_scripts', 'divi_powerful_plugin_main_css', 35 ); 
	add_action('wp_footer', 'divi_powerful_plugin_echo_js', 15 );
	add_filter('body_class', 'divi_powerful_plugin_add_body_class');
	add_action('wp_head', 'divi_powerful_plugin_css_edit');
	add_action('customize_register', 'divi_powerful_plugin_customizer_settings', 999);
	add_action( 'customize_controls_enqueue_scripts', 'divi_powerful_plugin_customize_controls_js_css' );
	add_shortcode('dp_cart_icon', 'divi_powerful_plugin_cart_icon');
	add_shortcode('dp_cart_icon_minimal', 'divi_powerful_plugin_cart_icon_minimal');
}

// -------------- Load main CSS and JS Start ----------------
function divi_powerful_plugin_main_css() { 
	wp_enqueue_style('divi-powerful-plugin-main-css', plugin_dir_url( __FILE__ ) . 'css/main.css', array(), DIVI_POWERFUL_PLUGIN_VERSION);
} 
// -------------- Load main CSS and JS End ----------------

// -------------- Echo JS Start ----------------
function divi_powerful_plugin_echo_js() {	
	// Add vertical navigation body tag in Visual Builder
	if ( isset( $_GET['et_fb'] ) && '1' === $_GET['et_fb'] && is_user_logged_in() ) {
		echo '<script>!function(n){n(window).on("load",function(){n(".free-vertical-navigation").length&&n("body").addClass("free-vertical-navigation-body-tag")})}(jQuery);</script>';
		echo '<script>!function(e){e("body").on("DOMSubtreeModified",".free-vertical-navigation-js",function(){e(".free-vertical-navigation").length?e("body").addClass("free-vertical-navigation-body-tag"):e("body").removeClass("free-vertical-navigation-body-tag")})}(jQuery);</script>';
	} else {
		echo '<script src="' . plugin_dir_url( __FILE__ ) . 'js/jquery.du-sticky.min.js?ver=' . DIVI_POWERFUL_PLUGIN_VERSION . '"></script>';
		echo '<script src="' . plugin_dir_url( __FILE__ ) . 'js/jquery.du-vertical-navigation.min.js?ver=' . DIVI_POWERFUL_PLUGIN_VERSION . '"></script>';
	}
}
// -------------- Echo JS End ----------------

// -------------- Customizer Settings Start ----------------
function divi_powerful_plugin_customizer_settings($wp_customize) {
    
	// Add new sections
    $wp_customize->add_section('divi_powerful_plugin_vertical_navigation', array(
        'priority' => 20,
        'title' => 'Vertical Navigation',
        'panel'  => 'divi_powerful_customizer_options',
    )); 

	// Add new settings
	
	$wp_customize->add_setting( 'divi_powerful_plugin_vertical_navigation_description', array(
		'default'		=> 'none',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
	) );

	$wp_customize->add_control( 'divi_powerful_plugin_vertical_navigation_description', array(
		'settings' => 'divi_powerful_plugin_vertical_navigation_description',
		'label'		=> 'Settings for custom header style 11 & 12 (Vertical Navigation Styles)',
		'section'	=> 'divi_powerful_plugin_vertical_navigation',
		'type'      => 'text',
	) );
	
	if (class_exists('ET_Divi_Range_Option')) {
		$wp_customize->add_setting( 'divi_powerful_plugin_vertical_navigation_width', array(
			'default'       => '250',
			'type'          => 'option',
			'capability'    => 'edit_theme_options',
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'divi_powerful_plugin_vertical_navigation_width', array(
			'label'	      => 'Width of Vertical Navigation',
			'section'     => 'divi_powerful_plugin_vertical_navigation',
			'settings'	  => 'divi_powerful_plugin_vertical_navigation_width',
			'type'        => 'range',
			'input_attrs' => array(
				'min'  => 100,
				'max'  => 1000,
				'step' => 1
			),
		) ) );
		
		$wp_customize->add_setting( 'divi_powerful_plugin_vertical_navigation_breakpoint', array(
			'default'       => '1140',
			'type'          => 'option',
			'capability'    => 'edit_theme_options',
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'divi_powerful_plugin_vertical_navigation_breakpoint', array(
			'label'	      => 'Custom Breakpoint',
			'description' => 'Set when to hide the vertical navigation & show hamburger menu.',
			'section'     => 'divi_powerful_plugin_vertical_navigation',
			'settings'	  => 'divi_powerful_plugin_vertical_navigation_breakpoint',
			'type'        => 'range',
			'input_attrs' => array(
				'min'  => 981,
				'max'  => 3000,
				'step' => 1
			),
		) ) );
	}
	
	$wp_customize->add_setting( 'divi_powerful_plugin_vertical_navigation_no_breakpoint', array(
		'default'        => false,
		'type'           => 'option',
		'capability'     => 'edit_theme_options' 
	));

	$wp_customize->add_control( 'divi_powerful_plugin_vertical_navigation_no_breakpoint', array(
		'settings' => 'divi_powerful_plugin_vertical_navigation_no_breakpoint',
		'label'    => 'Always hide vertical navigation & show hamburger menu',
		'section'  => 'divi_powerful_plugin_vertical_navigation',
		'type'     => 'checkbox',
	));
	
    $wp_customize->add_setting( 'divi_powerful_plugin_vertical_navigation_overlay_trigger_style', array(
        'default'        => 'free-vertical-navigation-overlay-right',
        'type'           => 'option',
        'capability'     => 'edit_theme_options' 
    ));

    $wp_customize->add_control( 'divi_powerful_plugin_vertical_navigation_overlay_trigger_style', array(
        'settings' => 'divi_powerful_plugin_vertical_navigation_overlay_trigger_style',
        'label'    => 'Vertical navigation overlay trigger style',
        'section'  => 'divi_powerful_plugin_vertical_navigation',
		'type'     => 'select',
		'choices'  => array(
			'free-vertical-navigation-overlay-right' => 'Slide in from right',
			'free-vertical-navigation-overlay-left' => 'Slide in from left',
		),
    ));
	
	if (class_exists('ET_Divi_Customize_Color_Alpha_Control')) {
		$wp_customize->add_setting( 'divi_powerful_plugin_vertical_navigation_background_overlay_color', array(
			'default'		=> 'rgba(255, 255, 255, 0.85)',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
		) );
		
		$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'divi_powerful_plugin_vertical_navigation_background_overlay_color', array(
			'label'		=> 'Triggered Background Overlay Color',
			'section'	=> 'divi_powerful_plugin_vertical_navigation',
			'settings'	=> 'divi_powerful_plugin_vertical_navigation_background_overlay_color',
		) ) );
	}
	
	$wp_customize->add_setting( 'divi_powerful_plugin_vertical_navigation_hamburger_menu_color', array(
		'default'		=> '#505cfd',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'divi_powerful_plugin_vertical_navigation_hamburger_menu_color', array(
		'label'		=> 'Hamburger Menu Color',
		'section'	=> 'divi_powerful_plugin_vertical_navigation',
		'settings'	=> 'divi_powerful_plugin_vertical_navigation_hamburger_menu_color',
	) ) );
	
    $wp_customize->add_setting( 'divi_powerful_plugin_vertical_navigation_menu_hover_style', array(
        'default'        => 'none',
        'type'           => 'option',
        'capability'     => 'edit_theme_options' 
    ));

    $wp_customize->add_control( 'divi_powerful_plugin_vertical_navigation_menu_hover_style', array(
        'settings' => 'divi_powerful_plugin_vertical_navigation_menu_hover_style',
        'label'    => 'Choose your custom menu hover style',
        'section'  => 'divi_powerful_plugin_vertical_navigation',
		'type'     => 'select',
		'choices'  => array(
			'none' => 'None',
			'free-vertical-navigation-menu-hover-1' => 'Style 1',
			'free-vertical-navigation-menu-hover-2' => 'Style 2',
			'free-vertical-navigation-menu-hover-3' => 'Style 3',
		),
    ));
	
	$wp_customize->add_setting( 'divi_powerful_plugin_vertical_navigation_menu_hover_main_color', array(
		'default'		=> '#505cfd',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'divi_powerful_plugin_vertical_navigation_menu_hover_main_color', array(
		'label'		=> 'Menu Hover Main Color',
		'section'	=> 'divi_powerful_plugin_vertical_navigation',
		'settings'	=> 'divi_powerful_plugin_vertical_navigation_menu_hover_main_color',
	) ) );
	
	$wp_customize->add_setting( 'divi_powerful_plugin_vertical_navigation_menu_hover_text_color', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'divi_powerful_plugin_vertical_navigation_menu_hover_text_color', array(
		'label'		=> 'Menu Hover Text Color',
		'section'	=> 'divi_powerful_plugin_vertical_navigation',
		'settings'	=> 'divi_powerful_plugin_vertical_navigation_menu_hover_text_color',
	) ) );
	
	$wp_customize->add_setting( 'divi_powerful_plugin_vertical_navigation_menu_collapsible_arrow_only', array(
		'default'        => false,
		'type'           => 'option',
		'capability'     => 'edit_theme_options' 
	));

	$wp_customize->add_control( 'divi_powerful_plugin_vertical_navigation_menu_collapsible_arrow_only', array(
		'settings' => 'divi_powerful_plugin_vertical_navigation_menu_collapsible_arrow_only',
		'label'    => 'Only trigger collapsible menu upon clicking on arrow icon',
		'section'  => 'divi_powerful_plugin_vertical_navigation',
		'type'     => 'checkbox',
	));
	
}
// -------------- Customizer Settings End ----------------

// ----------------- Customizer JS Start -------------------
function divi_powerful_plugin_customize_controls_js_css() {
	wp_enqueue_style( 'divi-ultimate-header-customizer-controls-css', plugin_dir_url( __FILE__ ) . 'customizer/divi-ultimate-customizer-controls.css', array(), DIVI_POWERFUL_PLUGIN_VERSION );
}
// ----------------- Customizer JS End -------------------

// ------------- Add CSS Class to Body Tag Start -----------------
function divi_powerful_plugin_add_body_class( $classes = '' ) {
	$divi_powerful_plugin_vertical_navigation_overlay_trigger_style = get_option( 'divi_powerful_plugin_vertical_navigation_overlay_trigger_style', 'free-vertical-navigation-overlay-right' );
	$divi_powerful_plugin_vertical_navigation_menu_hover_style = get_option( 'divi_powerful_plugin_vertical_navigation_menu_hover_style', 'none' );
	$divi_powerful_plugin_vertical_navigation_menu_collapsible_arrow_only = get_option( 'divi_powerful_plugin_vertical_navigation_menu_collapsible_arrow_only' );
	
	if(function_exists('is_shop')) {
		if(is_shop()) {
			$get_the_ID = get_option( 'woocommerce_shop_page_id' );
		} else {
			$get_the_ID = get_queried_object_id();
		}	
	}
	else {
		$get_the_ID = get_queried_object_id();
	}
	
	if(get_post_meta($get_the_ID, "dp-meta-custom-header", true) && get_post_meta($get_the_ID, "dp-meta-custom-header", true) != 'default') {
		$divi_powerful_plugin_header_styling_settings = get_post_meta($get_the_ID, "dp-meta-custom-header", true);
	} else {
		$divi_powerful_plugin_header_styling_settings = get_option( 'divi_powerful_header_styling_settings', 'none' );
	}
	if ($divi_powerful_plugin_header_styling_settings != 'none') {
		
		$dp_vn = do_shortcode('[et_pb_section global_module="' . $divi_powerful_plugin_header_styling_settings . '"][/et_pb_section]');
		if ( isset( $_GET['et_fb'] ) && '1' === $_GET['et_fb'] && is_user_logged_in() ) {
		} else {
			if ($dp_header_position = strpos($dp_vn, ' free-vertical-navigation ')) {
				$classes[] = 'free-vertical-navigation-body-tag';
			}
		}
	}
	
	$classes[] = $divi_powerful_plugin_vertical_navigation_overlay_trigger_style;
	if ($divi_powerful_plugin_vertical_navigation_menu_hover_style != 'none') {
		$classes[] = $divi_powerful_plugin_vertical_navigation_menu_hover_style;
		$classes[] = 'free-vertical-navigation-custom-menu-hover';
	}
	
	if ($divi_powerful_plugin_vertical_navigation_menu_collapsible_arrow_only) {
		$classes[] = 'free-menu-collapsible-arrow-only';
	}
	
	return $classes;
}
// ------------- Add CSS Class to Body Tag End -----------------

// ------------------ CSS Edit Start ----------------------
function divi_powerful_plugin_css_edit() {
	$divi_powerful_plugin_vertical_navigation_width = get_option( 'divi_powerful_plugin_vertical_navigation_width', 250 );
	$divi_powerful_plugin_vertical_navigation_breakpoint = get_option( 'divi_powerful_plugin_vertical_navigation_breakpoint', 1140 );
	$divi_powerful_plugin_vertical_navigation_no_breakpoint = get_option( 'divi_powerful_plugin_vertical_navigation_no_breakpoint' );
	$divi_powerful_plugin_vertical_navigation_background_overlay_color = get_option( 'divi_powerful_plugin_vertical_navigation_background_overlay_color', 'rgba(255, 255, 255, 0.85)' );
	$divi_powerful_plugin_vertical_navigation_hamburger_menu_color = get_option( 'divi_powerful_plugin_vertical_navigation_hamburger_menu_color', '#505cfd' );
	$divi_powerful_plugin_vertical_navigation_menu_hover_main_color = get_option( 'divi_powerful_plugin_vertical_navigation_menu_hover_main_color', '#505cfd' );
	$divi_powerful_plugin_vertical_navigation_menu_hover_text_color = get_option( 'divi_powerful_plugin_vertical_navigation_menu_hover_text_color', '#ffffff' );
	
	?>
	
	<style type="text/css"> <?php
		
		// Vertical Navigation	?>
		body.free-vertical-navigation-body-tag .free-hamburger-icon .mobile_menu_bar:before { color: <?php echo $divi_powerful_plugin_vertical_navigation_hamburger_menu_color; ?>; }
		.free-vertical-navigation-background-overlay { background-color: <?php echo $divi_powerful_plugin_vertical_navigation_background_overlay_color; ?>; }
		.free-vertical-navigation, .free-vertical-navigation-wrapper { max-width: <?php echo $divi_powerful_plugin_vertical_navigation_width; ?>px!important; width: 100%!important; }
		.free-vertical-navigation .fullwidth-menu-nav>ul>li>ul.sub-menu { left: <?php echo $divi_powerful_plugin_vertical_navigation_width; ?>px; }
		.free-vertical-navigation .fullwidth-menu-nav>ul>li.et-reverse-direction-nav>ul.sub-menu { left: auto; right: <?php echo $divi_powerful_plugin_vertical_navigation_width; ?>px; }
		
		.free-vertical-navigation-menu-hover-1 .free-vertical-navigation nav>ul>li>a:before,
			.free-vertical-navigation-menu-hover-2 .free-vertical-navigation nav>ul>li>a:before,
				.free-vertical-navigation-menu-hover-3 .free-vertical-navigation nav>ul>li:hover>a,
					.free-vertical-navigation-menu-hover-4 .free-vertical-navigation nav>ul>li>a:before {
			background-color: <?php echo $divi_powerful_plugin_vertical_navigation_menu_hover_main_color; ?>!important;
		}
		body.free-vertical-navigation-custom-menu-hover .free-vertical-navigation nav>ul>li:hover>a {
			color: <?php echo $divi_powerful_plugin_vertical_navigation_menu_hover_text_color; ?>!important;
		}
		
		@media screen and (min-width: 981px) {
			html.et-fb-root-ancestor:not(.et-fb-preview--wireframe) .free-vertical-navigation {
				margin-left: -<?php echo $divi_powerful_plugin_vertical_navigation_width; ?>px!important;
			}
			html.et-fb-root-ancestor:not(.et-fb-preview--wireframe) body.free-vertical-navigation-body-tag.et-db.et-bfb>article #page-container-bfb .et-fb-post-content,
				html.et-fb-root-ancestor:not(.et-fb-preview--wireframe) body.free-vertical-navigation-body-tag .et-fb-post-content {
				margin-left: <?php echo $divi_powerful_plugin_vertical_navigation_width; ?>px!important;
			}
			html.et-fb-root-ancestor:not(.et-fb-preview--wireframe) body.free-vertical-navigation-body-tag.et-db.et-bfb>article #page-container-bfb .et-fb-post-content .free-vertical-navigation {
				position: relative!important;
				float: left !important;
			}
		}
		
		<?php
		
		if (!$divi_powerful_plugin_vertical_navigation_no_breakpoint) { ?>
		
			@media screen and (min-width: <?php echo $divi_powerful_plugin_vertical_navigation_breakpoint; ?>px) {
				html.et-fb-root-ancestor:not(.et-fb-preview--wireframe) .free-vertical-navigation-breakpoint-show {
					opacity: 0.5!important;
				}
				html:not(.et-fb-root-ancestor) .free-vertical-navigation {
					position: fixed!important;
					left: 0;
				}
				html:not(.et-fb-root-ancestor) .free-vertical-navigation-wrapper .free-vertical-navigation {
					position: relative!important;
				}
				html:not(.et-fb-root-ancestor):not(.et-fb-preview--wireframe) body.free-vertical-navigation-body-tag #et-main-area,
					body.free-vertical-navigation-body-tag .free-dp-plugin-header {
					margin-left: <?php echo $divi_powerful_plugin_vertical_navigation_width; ?>px!important;
				}
				html:not(.et-fb-root-ancestor) .free-vertical-navigation-breakpoint-show {
					display: none!important;
				}
				.free-vertical-navigation-background-overlay {
					display: none!important;
				}
				.free-vertical-navigation-wrapper:not(.free-menu-collapsible-wrapper) {
					box-shadow: none!important;
				}
			}
			@media screen and (max-width: <?php echo $divi_powerful_plugin_vertical_navigation_breakpoint - 1; ?>px) {
				html.et-fb-root-ancestor:not(.et-fb-preview--wireframe) .free-vertical-navigation-breakpoint-hide,
					html.et-fb-root-ancestor:not(.et-fb-preview--wireframe) .free-vertical-navigation {
					opacity: 0.5!important;
				}
				html:not(.et-fb-root-ancestor) .free-vertical-navigation {
					transform: translateX(-100%);
				}
				html:not(.et-fb-root-ancestor) .free-vertical-navigation-wrapper .free-vertical-navigation {
					transform: translateX(0%);
				}
				body:not(.free-vertical-navigation-overlay-show) .free-vertical-navigation-wrapper {
					box-shadow: none!important;
				}
			}
			
		<?php
		
		} else {	?>
		
			html.et-fb-root-ancestor:not(.et-fb-preview--wireframe) .free-vertical-navigation-breakpoint-hide,
				html.et-fb-root-ancestor:not(.et-fb-preview--wireframe) .free-vertical-navigation {
				opacity: 0.5!important;
			}
			html:not(.et-fb-root-ancestor) .free-vertical-navigation {
				transform: translateX(-100%);
			}
			html:not(.et-fb-root-ancestor) .free-vertical-navigation-wrapper .free-vertical-navigation {
				transform: translateX(0%);
			}
			body:not(.free-vertical-navigation-overlay-show) .free-vertical-navigation-wrapper {
				box-shadow: none!important;
			}
		
		<?php
		
		}
		
		if (!$divi_powerful_plugin_vertical_navigation_no_breakpoint) { ?>
		
			@media screen and (max-width: <?php echo $divi_powerful_plugin_vertical_navigation_breakpoint - 1; ?>px) {
		
		<?php
		
		}	?>
				html:not(.et-fb-root-ancestor) .free-vertical-navigation-breakpoint-hide {
					display: none!important;
				}
				body.free-vertical-navigation-overlay-left .free-vertical-navigation-wrapper {
					transform: translateX(-100%);
					transition: all 0.5s ease;
				}
				body.free-vertical-navigation-overlay-right .free-vertical-navigation-wrapper {
					transform: translateX(100%);
					left: auto;
					right: 0;
					transition: all 0.5s ease;
				}
		
		<?php
		
		if (!$divi_powerful_plugin_vertical_navigation_no_breakpoint) { ?>
		
			}
			
		<?php
		}	?>
		
	</style> <?php
}
// ------------------ CSS Edit End ----------------------

// -------------- Cart Icon Shortcode Start ----------------
function divi_powerful_plugin_cart_icon( $args = array() ) {
	if ( ! class_exists( 'woocommerce' ) || ! WC()->cart ) {
		return;
	}

	$defaults = array(
		'no_text' => false,
	);

	$args = wp_parse_args( $args, $defaults );

	$items_number = WC()->cart->get_cart_contents_count();
	
	$url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url();

	$dp_cart = sprintf (
		'<a href="%1$s" class="et-cart-info">
			<span>%2$s</span>
		</a>',
		esc_url( $url ),
		( ! $args['no_text']
			? esc_html( sprintf(
				_nx( '%1$s Item', '%1$s Items', $items_number, 'WooCommerce items number', 'Divi' ),
				number_format_i18n( $items_number )
			) )
			: ''
		)
	);
	return $dp_cart;
}
// -------------- Cart Icon Shortcode End ----------------

// -------------- Cart Icon Minimal Shortcode Start ----------------
function divi_powerful_plugin_cart_icon_minimal( $args = array() ) {
	if ( ! class_exists( 'woocommerce' ) || ! WC()->cart ) {
		return;
	}

	$defaults = array(
		'no_text' => false,
	);

	$args = wp_parse_args( $args, $defaults );

	$items_number = WC()->cart->get_cart_contents_count();
	
	$url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url();

	$dp_cart = sprintf (
		'<a href="%1$s" class="et-cart-info">
			<span><sup class="free-cart-total">%2$s</sup></span>
		</a>',
		esc_url( $url ),
		( ! $args['no_text']
			? esc_html( sprintf(
				_nx( '%1$s', '%1$s', $items_number, 'WooCommerce items number', 'Divi' ),
				number_format_i18n( $items_number )
			) )
			: ''
		)
	);
	return $dp_cart;
}
// -------------- Cart Icon Minimal Shortcode End ----------------

?>