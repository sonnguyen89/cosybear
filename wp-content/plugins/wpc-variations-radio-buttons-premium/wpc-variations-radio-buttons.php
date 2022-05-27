<?php
/**
 * Plugin Name: WPC Variations Radio Buttons for WooCommerce (Premium)
 * Plugin URI: https://wpclever.net/
 * Description: WPC Variations Radio Buttons will replaces dropdown selects by radio buttons for the buyer more easier in selecting the variations.
 * Version: 2.4.5
 * Author: WPClever
 * Author URI: https://wpclever.net
 * Text Domain: wpc-variations-radio-buttons
 * Domain Path: /languages/
 * Requires at least: 4.0
 * Tested up to: 5.7.2
 * WC requires at least: 3.0
 * WC tested up to: 5.4.1
 */

defined( 'ABSPATH' ) || exit;

! defined( 'WOOVR_KEY' ) && define( 'WOOVR_KEY', '1x4O4k8m6' );
! defined( 'WOOVR_VERSION' ) && define( 'WOOVR_VERSION', '2.4.5' );
! defined( 'WOOVR_URI' ) && define( 'WOOVR_URI', plugin_dir_url( __FILE__ ) );
! defined( 'WOOVR_PATH' ) && define( 'WOOVR_PATH', plugin_dir_path( __FILE__ ) );
! defined( 'WOOVR_SUPPORT' ) && define( 'WOOVR_SUPPORT', 'https://wpclever.net/support?utm_source=support&utm_medium=woovr&utm_campaign=wporg' );
! defined( 'WOOVR_REVIEWS' ) && define( 'WOOVR_REVIEWS', 'https://wordpress.org/support/plugin/wpc-variations-radio-buttons/reviews/?filter=5' );
! defined( 'WOOVR_CHANGELOG' ) && define( 'WOOVR_CHANGELOG', 'https://wordpress.org/plugins/wpc-variations-radio-buttons/#developers' );
! defined( 'WOOVR_DISCUSSION' ) && define( 'WOOVR_DISCUSSION', 'https://wordpress.org/support/plugin/wpc-variations-radio-buttons' );
! defined( 'WPC_URI' ) && define( 'WPC_URI', WOOVR_URI );

include 'includes/wpc-dashboard.php';
include 'includes/wpc-menu.php';
include 'includes/wpc-kit.php';
include 'includes/wpc-notice.php';
require 'includes/wpc-checker.php';

if ( ! function_exists( 'woovr_init' ) ) {
	add_action( 'plugins_loaded', 'woovr_init', 11 );

	function woovr_init() {
		// load text-domain
		load_plugin_textdomain( 'wpc-variations-radio-buttons', false, basename( __DIR__ ) . '/languages/' );

		if ( ! function_exists( 'WC' ) || ! version_compare( WC()->version, '3.0', '>=' ) ) {
			add_action( 'admin_notices', 'woovr_notice_wc' );

			return;
		}

		if ( ! class_exists( 'WPClever_Woovr' ) && class_exists( 'WC_Product' ) ) {
			class WPClever_Woovr {
				function __construct() {
					// settings page
					add_action( 'admin_menu', array( $this, 'woovr_admin_menu' ) );

					// settings link
					add_filter( 'plugin_action_links', array( $this, 'woovr_action_links' ), 10, 2 );
					add_filter( 'plugin_row_meta', array( $this, 'woovr_row_meta' ), 10, 2 );

					// enqueue backend scripts
					add_action( 'admin_enqueue_scripts', array( $this, 'woovr_admin_enqueue_scripts' ), 99 );

					// enqueue frontend scripts
					add_action( 'wp_enqueue_scripts', array( $this, 'woovr_enqueue_scripts' ), 99 );

					// product data tabs
					add_filter( 'woocommerce_product_data_tabs', array( $this, 'woovr_product_data_tabs' ), 10, 1 );
					add_action( 'woocommerce_product_data_panels', array( $this, 'woovr_product_data_panels' ) );
					add_action( 'woocommerce_process_product_meta', array( $this, 'woovr_process_product_meta' ) );

					// functions
					if ( get_option( '_woovr_active', 'yes' ) !== 'yes_wpc' ) {
						add_filter( 'woocommerce_post_class', array( $this, 'woovr_post_class' ), 99, 2 );
						add_action( 'woocommerce_before_variations_form', array(
							$this,
							'woovr_before_variations_form'
						) );
					}

					// custom variation name & image
					add_action( 'woocommerce_product_after_variable_attributes', array(
						$this,
						'woovr_variation_settings_fields'
					), 10, 3 );
					add_action( 'woocommerce_save_product_variation', array(
						$this,
						'woovr_save_variation_settings'
					), 10, 2 );
					add_filter( 'woocommerce_product_variation_get_name', array(
						$this,
						'woovr_product_variation_get_name'
					), 99, 2 );

					// check update
					PucFactory::buildUpdateChecker( 'https://api.wpclever.net/update/' . WOOVR_KEY . '.json', __FILE__, 'wpc-variations-radio-buttons-premium' );
				}

				function woovr_admin_menu() {
					add_submenu_page( 'wpclever', esc_html__( 'WPC Variations Radio Buttons', 'wpc-variations-radio-buttons' ), esc_html__( 'Variations Radio Buttons', 'wpc-variations-radio-buttons' ), 'manage_options', 'wpclever-woovr', array(
						$this,
						'woovr_settings_page'
					) );
				}

				function woovr_settings_page() {
					$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'settings';
					?>
                    <div class="wpclever_settings_page wrap">
                        <h1 class="wpclever_settings_page_title"><?php echo esc_html__( 'WPC Variations Radio Buttons', 'wpc-variations-radio-buttons' ) . ' ' . WOOVR_VERSION; ?></h1>
                        <div class="wpclever_settings_page_desc about-text">
                            <p>
								<?php printf( esc_html__( 'Thank you for using our plugin! If you are satisfied, please reward it a full five-star %s rating.', 'wpc-variations-radio-buttons' ), '<span style="color:#ffb900">&#9733;&#9733;&#9733;&#9733;&#9733;</span>' ); ?>
                                <br/>
                                <a href="<?php echo esc_url( WOOVR_REVIEWS ); ?>"
                                   target="_blank"><?php esc_html_e( 'Reviews', 'wpc-variations-radio-buttons' ); ?></a>
                                | <a
                                        href="<?php echo esc_url( WOOVR_CHANGELOG ); ?>"
                                        target="_blank"><?php esc_html_e( 'Changelog', 'wpc-variations-radio-buttons' ); ?></a>
                                | <a href="<?php echo esc_url( WOOVR_DISCUSSION ); ?>"
                                     target="_blank"><?php esc_html_e( 'Discussion', 'wpc-variations-radio-buttons' ); ?></a>
                            </p>
                        </div>
                        <div class="wpclever_settings_page_nav">
                            <h2 class="nav-tab-wrapper">
                                <a href="<?php echo admin_url( 'admin.php?page=wpclever-woovr&tab=settings' ); ?>"
                                   class="<?php echo $active_tab === 'settings' ? 'nav-tab nav-tab-active' : 'nav-tab'; ?>">
									<?php esc_html_e( 'Settings', 'wpc-variations-radio-buttons' ); ?>
                                </a>
                                <!--
                                <a href="<?php echo admin_url( 'admin.php?page=wpclever-woovr&tab=premium' ); ?>"
                                   class="<?php echo $active_tab === 'premium' ? 'nav-tab nav-tab-active' : 'nav-tab'; ?>" style="color: #c9356e">
									<?php esc_html_e( 'Premium Version', 'wpc-variations-radio-buttons' ); ?>
                                </a>
                                -->
                                <a href="<?php echo esc_url( WOOVR_SUPPORT ); ?>" class="nav-tab" target="_blank">
									<?php esc_html_e( 'Support', 'wpc-variations-radio-buttons' ); ?>
                                </a>
                                <a href="<?php echo esc_url( admin_url( 'admin.php?page=wpclever-kit' ) ); ?>"
                                   class="nav-tab">
									<?php esc_html_e( 'Essential Kit', 'wpc-variations-radio-buttons' ); ?>
                                </a>
                            </h2>
                        </div>
                        <div class="wpclever_settings_page_content">
							<?php if ( $active_tab === 'settings' ) {
								$active             = get_option( '_woovr_active', 'yes' );
								$hide_unpurchasable = get_option( '_woovr_hide_unpurchasable', 'no' );
								$selector           = get_option( '_woovr_selector', 'default' );
								$variation_name     = get_option( '_woovr_variation_name', 'default' );
								$show_clear         = get_option( '_woovr_show_clear', 'yes' );
								$show_image         = get_option( '_woovr_show_image', 'yes' );
								$show_price         = get_option( '_woovr_show_price', 'yes' );
								$show_availability  = get_option( '_woovr_show_availability', 'yes' );
								$show_description   = get_option( '_woovr_show_description', 'yes' );
								?>
                                <form method="post" action="options.php">
									<?php wp_nonce_field( 'update-options' ) ?>
                                    <table class="form-table">
                                        <tr>
                                            <th>
												<?php esc_html_e( 'Active', 'wpc-variations-radio-buttons' ); ?>
                                            </th>
                                            <td>
                                                <select name="_woovr_active">
                                                    <option value="no" <?php echo( $active === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="yes" <?php echo( $active === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="yes_wpc" <?php echo( $active === 'yes_wpc' ? 'selected' : '' ); ?>><?php esc_html_e( 'For WPC plugins only', 'wpc-variations-radio-buttons' ); ?></option>
                                                </select> <span
                                                        class="description"><?php esc_html_e( 'This is the default status, you can set status for individual product in the its settings.', 'wpc-variations-radio-buttons' ); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
												<?php esc_html_e( 'Hide unpurchasable variation', 'wpc-variations-radio-buttons' ); ?>
                                            </th>
                                            <td>
                                                <select name="_woovr_hide_unpurchasable">
                                                    <option value="no" <?php echo( $hide_unpurchasable === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="yes" <?php echo( $hide_unpurchasable === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Selector interface', 'wpc-variations-radio-buttons' ); ?></th>
                                            <td>
                                                <select name="_woovr_selector">
                                                    <option value="default" <?php echo( $selector === 'default' ? 'selected' : '' ); ?>><?php esc_html_e( 'Radio buttons (default)', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="ddslick" <?php echo( $selector === 'ddslick' ? 'selected' : '' ); ?>><?php esc_html_e( 'ddSlick', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="select2" <?php echo( $selector === 'select2' ? 'selected' : '' ); ?>><?php esc_html_e( 'Select2', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="select" <?php echo( $selector === 'select' ? 'selected' : '' ); ?>><?php esc_html_e( 'HTML select tag', 'wpc-variations-radio-buttons' ); ?></option>
                                                </select>
                                                <span class="description">
                                                    Read more about ddSlick, Select2 and HTML select tag <a
                                                            href="https://wpclever.net/downloads/wpc-variations-radio-buttons-for-woocommerce"
                                                            target="_blank">here</a>.
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php esc_html_e( 'Variation name', 'wpc-variations-radio-buttons' ); ?></th>
                                            <td>
                                                <select name="_woovr_variation_name">
                                                    <option value="default" <?php echo( $variation_name === 'default' ? 'selected' : '' ); ?>><?php esc_html_e( 'Default (e.g Product A - Green, M)', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="formatted" <?php echo( $variation_name === 'formatted' ? 'selected' : '' ); ?>><?php esc_html_e( 'Formatted without attribute label (e.g Green, M)', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="formatted_label" <?php echo( $variation_name === 'formatted_label' ? 'selected' : '' ); ?>><?php esc_html_e( 'Formatted with attribute label (e.g Color: Green, Size: M)', 'wpc-variations-radio-buttons' ); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
												<?php esc_html_e( 'Show "Choose an option"', 'wpc-variations-radio-buttons' ); ?>
                                            </th>
                                            <td>
                                                <select name="_woovr_show_clear">
                                                    <option value="no" <?php echo( $show_clear === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="yes" <?php echo( $show_clear === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
												<?php esc_html_e( 'Show image', 'wpc-variations-radio-buttons' ); ?>
                                            </th>
                                            <td>
                                                <select name="_woovr_show_image">
                                                    <option value="no" <?php echo( $show_image === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="yes" <?php echo( $show_image === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
												<?php esc_html_e( 'Show price', 'wpc-variations-radio-buttons' ); ?>
                                            </th>
                                            <td>
                                                <select name="_woovr_show_price">
                                                    <option value="no" <?php echo( $show_price === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="yes" <?php echo( $show_price === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
												<?php esc_html_e( 'Show availability', 'wpc-variations-radio-buttons' ); ?>
                                            </th>
                                            <td>
                                                <select name="_woovr_show_availability">
                                                    <option value="no" <?php echo( $show_availability === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="yes" <?php echo( $show_availability === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
												<?php esc_html_e( 'Show description', 'wpc-variations-radio-buttons' ); ?>
                                            </th>
                                            <td>
                                                <select name="_woovr_show_description">
                                                    <option value="no" <?php echo( $show_description === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?></option>
                                                    <option value="yes" <?php echo( $show_description === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="submit">
                                            <th colspan="2">
                                                <input type="submit" name="submit" class="button button-primary"
                                                       value="<?php esc_html_e( 'Update Options', 'wpc-variations-radio-buttons' ); ?>"/>
                                                <input type="hidden" name="action" value="update"/>
                                                <input type="hidden" name="page_options"
                                                       value="_woovr_active,_woovr_hide_unpurchasable,_woovr_selector,_woovr_variation_name,_woovr_show_clear,_woovr_show_image,_woovr_show_price,_woovr_show_description,_woovr_show_availability"/>
                                            </th>
                                        </tr>
                                    </table>
                                </form>
							<?php } elseif ( $active_tab === 'premium' ) { ?>
                                <div class="wpclever_settings_page_content_text">
                                    <p>
                                        Get the Premium Version just $29! <a
                                                href="https://wpclever.net/downloads/wpc-variations-radio-buttons-for-woocommerce?utm_source=pro&utm_medium=woovr&utm_campaign=wporg"
                                                target="_blank">https://wpclever.net/downloads/wpc-variations-radio-buttons-for-woocommerce</a>
                                    </p>
                                    <p><strong>Extra features for Premium Version:</strong></p>
                                    <ul style="margin-bottom: 0">
                                        <li>- Settings for individual product.</li>
                                        <li>- Get the lifetime update & premium support.</li>
                                    </ul>
                                </div>
							<?php } ?>
                        </div>
                    </div>
					<?php
				}

				function woovr_action_links( $links, $file ) {
					static $plugin;

					if ( ! isset( $plugin ) ) {
						$plugin = plugin_basename( __FILE__ );
					}

					if ( $plugin === $file ) {
						$settings = '<a href="' . admin_url( 'admin.php?page=wpclever-woovr&tab=settings' ) . '">' . esc_html__( 'Settings', 'wpc-variations-radio-buttons' ) . '</a>';
						//$links['premium']       = '<a href="' . admin_url( 'admin.php?page=wpclever-woovr&tab=premium' ) . '">' . esc_html__( 'Premium Version', 'wpc-variations-radio-buttons' ) . '</a>';
						array_unshift( $links, $settings );
					}

					return (array) $links;
				}

				function woovr_row_meta( $links, $file ) {
					static $plugin;

					if ( ! isset( $plugin ) ) {
						$plugin = plugin_basename( __FILE__ );
					}

					if ( $plugin === $file ) {
						$row_meta = array(
							'support' => '<a href="' . esc_url( WOOVR_SUPPORT ) . '" target="_blank">' . esc_html__( 'Support', 'wpc-variations-radio-buttons' ) . '</a>',
						);

						return array_merge( $links, $row_meta );
					}

					return (array) $links;
				}

				function woovr_admin_enqueue_scripts() {
					wp_enqueue_style( 'woovr-backend', WOOVR_URI . 'assets/css/backend.css' );
					wp_enqueue_script( 'woovr-backend', WOOVR_URI . 'assets/js/backend.js', array( 'jquery' ), WOOVR_VERSION, true );
				}

				function woovr_enqueue_scripts() {
					// ddslick
					wp_enqueue_script( 'ddslick', WOOVR_URI . 'assets/libs/ddslick/jquery.ddslick.min.js', array( 'jquery' ), WOOVR_VERSION, true );

					// select2
					wp_enqueue_style( 'select2' );
					wp_enqueue_script( 'select2', WC()->plugin_url() . '/assets/js/select2/select2.full.min.js', array( 'jquery' ), WOOVR_VERSION, true );

					// woovr
					wp_enqueue_style( 'woovr-frontend', WOOVR_URI . 'assets/css/frontend.css' );
					wp_enqueue_script( 'woovr-frontend', WOOVR_URI . 'assets/js/frontend.js', array( 'jquery' ), WOOVR_VERSION, true );
				}

				function woovr_product_data_tabs( $tabs ) {
					$tabs['woovr'] = array(
						'label'  => esc_html__( 'Radio Buttons', 'wpc-variations-radio-buttons' ),
						'target' => 'woovr_settings',
						'class'  => array( 'show_if_variable' )
					);

					return $tabs;
				}

				function woovr_product_data_panels() {
					global $post;
					$post_id           = $post->ID;
					$active            = get_post_meta( $post_id, '_woovr_active', true ) ?: 'default';
					$selector          = get_post_meta( $post_id, '_woovr_selector', true ) ?: 'default';
					$variation_name    = get_post_meta( $post_id, '_woovr_variation_name', true ) ?: 'default';
					$show_image        = get_post_meta( $post_id, '_woovr_show_image', true ) ?: 'yes';
					$show_price        = get_post_meta( $post_id, '_woovr_show_price', true ) ?: 'yes';
					$show_description  = get_post_meta( $post_id, '_woovr_show_description', true ) ?: 'yes';
					$show_availability = get_post_meta( $post_id, '_woovr_show_availability', true ) ?: 'yes';
					?>
                    <div id='woovr_settings' class='panel woocommerce_options_panel woovr_table'>
                        <div class="woovr_tr">
                            <div class="woovr_td"><?php esc_html_e( 'Active', 'wpc-variations-radio-buttons' ); ?></div>
                            <div class="woovr_td">
                                <input name="_woovr_active" type="radio"
                                       value="default" <?php echo( $active === 'default' ? 'checked' : '' ); ?>/> <?php esc_html_e( 'Default', 'wpc-variations-radio-buttons' ); ?>
                                (<a
                                        href="<?php echo admin_url( 'admin.php?page=wpclever-woovr&tab=settings' ); ?>"
                                        target="_blank"><?php esc_html_e( 'settings', 'wpc-variations-radio-buttons' ); ?></a>)
                                &nbsp;
                                <input name="_woovr_active" type="radio"
                                       value="no" <?php echo( $active === 'no' ? 'checked' : '' ); ?>/> <?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?>
                                &nbsp;
                                <input name="_woovr_active" type="radio"
                                       value="yes" <?php echo( $active === 'yes' ? 'checked' : '' ); ?>/> <?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?>
                            </div>
                        </div>
                        <div class="woovr_tr woovr_show_if_active">
                            <div class="woovr_td"><?php esc_html_e( 'Selector interface', 'wpc-variations-radio-buttons' ); ?></div>
                            <div class="woovr_td">
                                <select name="_woovr_selector">
                                    <option value="default" <?php echo( $selector === 'default' ? 'selected' : '' ); ?>><?php esc_html_e( 'Radio buttons (default)', 'wpc-variations-radio-buttons' ); ?></option>
                                    <option value="ddslick" <?php echo( $selector === 'ddslick' ? 'selected' : '' ); ?>><?php esc_html_e( 'ddSlick', 'wpc-variations-radio-buttons' ); ?></option>
                                    <option value="select2" <?php echo( $selector === 'select2' ? 'selected' : '' ); ?>><?php esc_html_e( 'Select2', 'wpc-variations-radio-buttons' ); ?></option>
                                    <option value="select" <?php echo( $selector === 'select' ? 'selected' : '' ); ?>><?php esc_html_e( 'HTML select tag', 'wpc-variations-radio-buttons' ); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="woovr_tr woovr_show_if_active">
                            <div class="woovr_td"><?php esc_html_e( 'Variation name', 'wpc-variations-radio-buttons' ); ?></div>
                            <div class="woovr_td">
                                <select name="_woovr_variation_name">
                                    <option value="default" <?php echo( $variation_name === 'default' ? 'selected' : '' ); ?>><?php esc_html_e( 'Default (e.g Product A - Green, M)', 'wpc-variations-radio-buttons' ); ?></option>
                                    <option value="formatted" <?php echo( $variation_name === 'formatted' ? 'selected' : '' ); ?>><?php esc_html_e( 'Formatted without attribute label (e.g Green, M)', 'wpc-variations-radio-buttons' ); ?></option>
                                    <option value="formatted_label" <?php echo( $variation_name === 'formatted_label' ? 'selected' : '' ); ?>><?php esc_html_e( 'Formatted with attribute label (e.g Color: Green, Size: M)', 'wpc-variations-radio-buttons' ); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="woovr_tr woovr_show_if_active">
                            <div class="woovr_td">
								<?php esc_html_e( 'Show image', 'wpc-variations-radio-buttons' ); ?>
                            </div>
                            <div class="woovr_td">
                                <select name="_woovr_show_image">
                                    <option value="no" <?php echo( $show_image === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?></option>
                                    <option value="yes" <?php echo( $show_image === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="woovr_tr woovr_show_if_active">
                            <div class="woovr_td">
								<?php esc_html_e( 'Show price', 'wpc-variations-radio-buttons' ); ?>
                            </div>
                            <div class="woovr_td">
                                <select name="_woovr_show_price">
                                    <option value="no" <?php echo( $show_price === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?></option>
                                    <option value="yes" <?php echo( $show_price === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="woovr_tr woovr_show_if_active">
                            <div class="woovr_td">
								<?php esc_html_e( 'Show availability', 'wpc-variations-radio-buttons' ); ?>
                            </div>
                            <div class="woovr_td">
                                <select name="_woovr_show_availability">
                                    <option value="no" <?php echo( $show_availability === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?></option>
                                    <option value="yes" <?php echo( $show_availability === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="woovr_tr woovr_show_if_active">
                            <div class="woovr_td">
								<?php esc_html_e( 'Show description', 'wpc-variations-radio-buttons' ); ?>
                            </div>
                            <div class="woovr_td">
                                <select name="_woovr_show_description">
                                    <option value="no" <?php echo( $show_description === 'no' ? 'selected' : '' ); ?>><?php esc_html_e( 'No', 'wpc-variations-radio-buttons' ); ?></option>
                                    <option value="yes" <?php echo( $show_description === 'yes' ? 'selected' : '' ); ?>><?php esc_html_e( 'Yes', 'wpc-variations-radio-buttons' ); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
					<?php
				}

				function woovr_process_product_meta( $post_id ) {
					if ( isset( $_POST['_woovr_active'] ) ) {
						update_post_meta( $post_id, '_woovr_active', $_POST['_woovr_active'] );
					} else {
						delete_post_meta( $post_id, '_woovr_active' );
					}

					if ( isset( $_POST['_woovr_selector'] ) ) {
						update_post_meta( $post_id, '_woovr_selector', $_POST['_woovr_selector'] );
					} else {
						delete_post_meta( $post_id, '_woovr_selector' );
					}

					if ( isset( $_POST['_woovr_variation_name'] ) ) {
						update_post_meta( $post_id, '_woovr_variation_name', $_POST['_woovr_variation_name'] );
					} else {
						delete_post_meta( $post_id, '_woovr_variation_name' );
					}

					if ( isset( $_POST['_woovr_show_image'] ) ) {
						update_post_meta( $post_id, '_woovr_show_image', $_POST['_woovr_show_image'] );
					} else {
						delete_post_meta( $post_id, '_woovr_show_image' );
					}

					if ( isset( $_POST['_woovr_show_price'] ) ) {
						update_post_meta( $post_id, '_woovr_show_price', $_POST['_woovr_show_price'] );
					} else {
						delete_post_meta( $post_id, '_woovr_show_price' );
					}

					if ( isset( $_POST['_woovr_show_description'] ) ) {
						update_post_meta( $post_id, '_woovr_show_description', $_POST['_woovr_show_description'] );
					} else {
						delete_post_meta( $post_id, '_woovr_show_description' );
					}

					if ( isset( $_POST['_woovr_show_availability'] ) ) {
						update_post_meta( $post_id, '_woovr_show_availability', $_POST['_woovr_show_availability'] );
					} else {
						delete_post_meta( $post_id, '_woovr_show_availability' );
					}
				}

				function woovr_before_variations_form() {
					global $product;

					if ( $product && ( $product_id = $product->get_id() ) ) {
						$active  = get_option( '_woovr_active', 'yes' );
						$_active = get_post_meta( $product_id, '_woovr_active', true ) ?: 'default';

						if ( $_active === 'yes' || ( $_active === 'default' && $active === 'yes' ) ) {
							$this->woovr_variations_form( $product );
						}
					}
				}

				function woovr_variation_settings_fields( $loop, $variation_data, $variation ) {
					echo '<div class="form-row form-row-full woovr-variation-settings">';
					echo '<label>' . esc_html__( 'WPC Variations Radio Buttons', 'wpc-variations-radio-buttons' ) . '</label>';
					echo '<div class="woovr-variation-wrap">';

					woocommerce_wp_text_input(
						array(
							'name'  => 'woovr_name[' . $variation->ID . ']',
							'label' => esc_html__( 'Custom name', 'wpc-variations-radio-buttons' ),
							'value' => get_post_meta( $variation->ID, 'woovr_name', true ),
						) );
					woocommerce_wp_text_input(
						array(
							'name'      => 'woovr_image[' . $variation->ID . ']',
							'label'     => esc_html__( 'Custom image', 'wpc-variations-radio-buttons' ),
							'type'      => 'url',
							'data_type' => 'url',
							'value'     => get_post_meta( $variation->ID, 'woovr_image', true ),
						) );

					echo '</div></div>';
				}

				function woovr_save_variation_settings( $post_id ) {
					if ( isset( $_POST['woovr_name'][ $post_id ] ) ) {
						update_post_meta( $post_id, 'woovr_name', esc_html( $_POST['woovr_name'][ $post_id ] ) );
					} else {
						delete_post_meta( $post_id, 'woovr_name' );
					}

					if ( isset( $_POST['woovr_image'][ $post_id ] ) ) {
						update_post_meta( $post_id, 'woovr_image', esc_url( $_POST['woovr_image'][ $post_id ] ) );
					} else {
						delete_post_meta( $post_id, 'woovr_image' );
					}
				}

				function woovr_product_variation_get_name( $name, $product ) {
					if ( $custom_name = get_post_meta( $product->get_id(), 'woovr_name', true ) ) {
						if ( ! empty( $custom_name ) ) {
							return $custom_name;
						}
					}

					return $name;
				}

				function woovr_post_class( $classes, $product ) {
					$product_id        = $product->get_id();
					$active            = get_option( '_woovr_active', 'yes' );
					$show_price        = get_option( '_woovr_show_price', 'yes' );
					$show_availability = get_option( '_woovr_show_availability', 'yes' );
					$show_description  = get_option( '_woovr_show_description', 'yes' );
					$_active           = get_post_meta( $product_id, '_woovr_active', true ) ?: 'default';

					if ( $_active === 'yes' ) {
						// overwrite settings
						$show_price        = get_post_meta( $product_id, '_woovr_show_price', true ) ?: $show_price;
						$show_availability = get_post_meta( $product_id, '_woovr_show_availability', true ) ?: $show_availability;
						$show_description  = get_post_meta( $product_id, '_woovr_show_description', true ) ?: $show_description;
					}

					if ( ( $_active === 'yes' ) || ( ( $_active === 'default' ) && ( $active === 'yes' ) ) ) {
						$classes[] = 'woovr-active';

						if ( $show_price === 'yes' ) {
							$classes[] = 'woovr-show-price';
						}

						if ( $show_availability === 'yes' ) {
							$classes[] = 'woovr-show-availability';
						}

						if ( $show_description === 'yes' ) {
							$classes[] = 'woovr-show-description';
						}
					}

					return $classes;
				}

				static function woovr_data_attributes( $attrs ) {
					$attrs_arr = array();

					foreach ( $attrs as $key => $attr ) {
						$attrs_arr[] = 'data-' . sanitize_title( $key ) . '="' . esc_attr( $attr ) . '"';
					}

					return implode( ' ', $attrs_arr );
				}

				static function woovr_is_purchasable( $product ) {
					return $product->is_purchasable() && $product->is_in_stock() && $product->has_enough_stock( 1 );
				}

				public static function woovr_variations_form( $product ) {
					$product_id = $product->get_id();
					$_active    = get_post_meta( $product_id, '_woovr_active', true ) ?: 'default';

					$selector           = get_option( '_woovr_selector', 'default' );
					$variation_name     = get_option( '_woovr_variation_name', 'default' );
					$show_clear         = get_option( '_woovr_show_clear', 'yes' );
					$show_image         = get_option( '_woovr_show_image', 'yes' );
					$show_price         = get_option( '_woovr_show_price', 'yes' );
					$show_availability  = get_option( '_woovr_show_availability', 'yes' );
					$show_description   = get_option( '_woovr_show_description', 'yes' );
					$hide_unpurchasable = get_option( '_woovr_hide_unpurchasable', 'no' );

					if ( $_active === 'yes' ) {
						// overwrite settings
						$selector          = get_post_meta( $product_id, '_woovr_selector', true ) ?: $selector;
						$variation_name    = get_post_meta( $product_id, '_woovr_variation_name', true ) ?: $variation_name;
						$show_image        = get_post_meta( $product_id, '_woovr_show_image', true ) ?: $show_image;
						$show_price        = get_post_meta( $product_id, '_woovr_show_price', true ) ?: $show_price;
						$show_availability = get_post_meta( $product_id, '_woovr_show_availability', true ) ?: $show_availability;
						$show_description  = get_post_meta( $product_id, '_woovr_show_description', true ) ?: $show_description;
					}

					$df_attrs_arr = array();
					$df_attrs     = $product->get_default_attributes();

					if ( ! empty( $df_attrs ) ) {
						foreach ( $df_attrs as $key => $val ) {
							$df_attrs_arr[ 'attribute_' . $key ] = $val;
						}
					}

					$children = $product->get_children();

					if ( is_array( $children ) && count( $children ) > 0 ) {
						echo '<div class="woovr-variations ' . esc_attr( 'woovr-variations-' . $selector ) . '" data-click="0" data-description="' . esc_attr( $show_description ) . '">';

						if ( $selector === 'default' ) {
							// show choose an option
							if ( $show_clear === 'yes' ) {
								$data_attrs = apply_filters( 'woovr_data_attributes_option_none', array(
									'id'            => 0,
									'sku'           => '',
									'purchasable'   => 'no',
									'attrs'         => '',
									'price'         => 0,
									'regular-price' => 0,
									'pricehtml'     => '',
									'availability'  => ''
								) );

								$df_checked = empty( $df_attrs ) ? 'checked' : '';

								echo '<div class="woovr-variation woovr-variation-radio ' . ( empty( $df_attrs ) ? 'woovr-variation-active' : '' ) . '" ' . self::woovr_data_attributes( $data_attrs ) . '>';
								echo apply_filters( 'woovr_variation_radio_selector', '<div class="woovr-variation-selector"><input type="radio" name="woovr_variation_' . $product_id . '" ' . $df_checked . '/></div>', $product_id, $df_checked );

								if ( $show_image === 'yes' ) {
									echo '<div class="woovr-variation-image">' . apply_filters( 'woovr_clear_image', wc_placeholder_img(), $product ) . '</div>';
								}

								echo '<div class="woovr-variation-info">';
								echo '<div class="woovr-variation-name">' . esc_html__( 'Choose an option', 'wpc-variations-radio-buttons' ) . '</div>';
								echo '<div class="woovr-variation-description">' . apply_filters( 'woovr_clear_description', '', $product ) . '</div>';
								echo '</div><!-- /woovr-variation-info -->';
								echo '</div><!-- /woovr-variation -->';
							}

							// radio buttons
							foreach ( $children as $child ) {
								$child_product = wc_get_product( $child );

								if ( ! $child_product || ! $child_product->variation_is_visible() ) {
									continue;
								}

								if ( ( $hide_unpurchasable === 'yes' ) && ! self::woovr_is_purchasable( $child_product ) ) {
									continue;
								}

								$child_attrs   = htmlspecialchars( json_encode( $child_product->get_variation_attributes() ), ENT_QUOTES, 'UTF-8' );
								$child_checked = $child_product->get_variation_attributes() == $df_attrs_arr ? 'checked' : '';
								$child_class   = 'woovr-variation woovr-variation-radio';

								if ( $child_checked === 'checked' ) {
									$child_class .= ' woovr-variation-active';
								}

								if ( $variation_name === 'formatted_label' ) {
									$child_name = wc_get_formatted_variation( $child_product, true, true, false );
								} elseif ( $variation_name === 'formatted' ) {
									$child_name = wc_get_formatted_variation( $child_product, true, false, false );
								} else {
									// default
									$child_name = $child_product->get_name();
								}

								if ( $variation_name !== 'default' && $custom_name = get_post_meta( $child, 'woovr_name', true ) ) {
									if ( ! empty( $custom_name ) ) {
										$child_name = $custom_name;
									}
								}

								if ( $child_product->get_image_id() ) {
									$child_image     = wp_get_attachment_image_src( $child_product->get_image_id(), 'thumbnail' );
									$child_image_src = get_post_meta( $child, 'woovr_image', true ) ?: $child_image[0];
									$child_image_src = esc_url( apply_filters( 'woovr_variation_image_src', $child_image_src, $child_product ) );
								} else {
									$child_image_src = esc_url( apply_filters( 'woovr_variation_image_src', wc_placeholder_img_src(), $child_product ) );
								}

								$data_attrs = apply_filters( 'woovr_data_attributes', array(
									'id'            => $child,
									'sku'           => $child_product->get_sku(),
									'purchasable'   => self::woovr_is_purchasable( $child_product ) ? 'yes' : 'no',
									'attrs'         => $child_attrs,
									'price'         => wc_get_price_to_display( $child_product ),
									'regular-price' => wc_get_price_to_display( $child_product, array( 'price' => $child_product->get_regular_price() ) ),
									'pricehtml'     => htmlentities( $child_product->get_price_html() ),
									'imagesrc'      => $child_image_src,
									'availability'  => htmlentities( wc_get_stock_html( $child_product ) )
								), $child_product );

								echo '<div class="' . esc_attr( $child_class ) . '" ' . self::woovr_data_attributes( $data_attrs ) . '>';
								echo apply_filters( 'woovr_variation_radio_selector', '<div class="woovr-variation-selector"><input type="radio" name="woovr_variation_' . $product_id . '" ' . $child_checked . '/></div>', $product_id, $child_checked );

								if ( $show_image === 'yes' ) {
									echo '<div class="woovr-variation-image"><img src="' . $child_image_src . '"/></div>';
								}

								echo '<div class="woovr-variation-info">';
								$child_info = '<div class="woovr-variation-name">' . apply_filters( 'woovr_variation_name', $child_name, $child_product ) . '</div>';

								if ( $show_price === 'yes' ) {
									$child_info .= '<div class="woovr-variation-price">' . apply_filters( 'woovr_variation_price', $child_product->get_price_html(), $child_product ) . '</div>';
								}

								if ( $show_availability === 'yes' ) {
									$child_info .= '<div class="woovr-variation-availability">' . apply_filters( 'woovr_variation_availability', wc_get_stock_html( $child_product ), $child_product ) . '</div>';
								}

								if ( $show_description === 'yes' ) {
									$child_info .= '<div class="woovr-variation-description">' . apply_filters( 'woovr_variation_description', $child_product->get_description(), $child_product ) . '</div>';
								}

								echo apply_filters( 'woovr_variation_info', $child_info, $child_product );
								echo '</div><!-- /woovr-variation-info -->';
								echo '</div><!-- /woovr-variation -->';
							}
						} else {
							// dropdown
							echo '<div class="woovr-variation woovr-variation-dropdown">';

							if ( ( $selector === 'select' ) && ( $show_image === 'yes' ) ) {
								echo '<div class="woovr-variation-image">' . apply_filters( 'woovr_clear_image', wc_placeholder_img(), $product ) . '</div>';
							}

							echo '<div class="woovr-variation-selector"><select class="woovr-variation-select" id="woovr-variation-select-' . esc_attr( $product_id ) . '">';

							// show choose an option
							if ( $show_clear === 'yes' ) {
								if ( ( $selector === 'select' ) ) {
									$imagesrc = esc_url( apply_filters( 'woovr_clear_image_src', wc_placeholder_img_src(), $product ) );
								} else {
									$imagesrc = esc_url( apply_filters( 'woovr_clear_image_src', '', $product ) );
								}

								$data_attrs = apply_filters( 'woovr_data_attributes_option_none', array(
									'id'            => 0,
									'sku'           => '',
									'purchasable'   => 'no',
									'attrs'         => '',
									'price'         => 0,
									'regular-price' => 0,
									'pricehtml'     => '',
									'imagesrc'      => $imagesrc,
									'description'   => htmlentities( apply_filters( 'woovr_clear_description', '', $product ) ),
									'availability'  => ''
								) );
								echo '<option value="0" ' . self::woovr_data_attributes( $data_attrs ) . '>' . esc_html__( 'Choose an option', 'wpc-variations-radio-buttons' ) . '</option>';
							}

							foreach ( $children as $child ) {
								$child_product = wc_get_product( $child );

								if ( ! $child_product || ! $child_product->variation_is_visible() ) {
									continue;
								}

								if ( ( $hide_unpurchasable === 'yes' ) && ! self::woovr_is_purchasable( $child_product ) ) {
									continue;
								}

								if ( $variation_name === 'formatted_label' ) {
									$child_name = wc_get_formatted_variation( $child_product, true, true, false );
								} elseif ( $variation_name === 'formatted' ) {
									$child_name = wc_get_formatted_variation( $child_product, true, false, false );
								} else {
									// default
									$child_name = $child_product->get_name();
								}

								if ( $variation_name !== 'default' && $custom_name = get_post_meta( $child, 'woovr_name', true ) ) {
									if ( ! empty( $custom_name ) ) {
										$child_name = $custom_name;
									}
								}

								if ( $child_product->get_image_id() ) {
									$child_image     = wp_get_attachment_image_src( $child_product->get_image_id(), 'thumbnail' );
									$child_image_src = get_post_meta( $child, 'woovr_image', true ) ?: $child_image[0];
									$child_image_src = esc_url( apply_filters( 'woovr_variation_image_src', $child_image_src, $child_product ) );
								} else {
									$child_image_src = esc_url( apply_filters( 'woovr_variation_image_src', wc_placeholder_img_src(), $child_product ) );
								}

								$child_attrs    = htmlspecialchars( json_encode( $child_product->get_variation_attributes() ), ENT_QUOTES, 'UTF-8' );
								$child_selected = $child_product->get_variation_attributes() == $df_attrs_arr ? 'selected' : '';
								$child_info     = '';

								if ( $show_price === 'yes' ) {
									$child_info .= '<span class="woovr-variation-price">' . apply_filters( 'woovr_variation_price', $child_product->get_price_html(), $child_product ) . '</span>';
								}

								if ( $show_availability === 'yes' ) {
									$child_info .= '<span class="woovr-variation-availability">' . apply_filters( 'woovr_variation_availability', wc_get_stock_html( $child_product ), $child_product ) . '</span>';
								}

								if ( $show_description === 'yes' ) {
									$child_info .= '<span class="woovr-variation-description">' . apply_filters( 'woovr_variation_description', $child_product->get_description(), $child_product ) . '</span>';
								}

								$data_attrs = apply_filters( 'woovr_data_attributes', array(
									'id'            => $child,
									'sku'           => $child_product->get_sku(),
									'purchasable'   => self::woovr_is_purchasable( $child_product ) ? 'yes' : 'no',
									'attrs'         => $child_attrs,
									'price'         => wc_get_price_to_display( $child_product ),
									'regular-price' => wc_get_price_to_display( $child_product, array( 'price' => $child_product->get_regular_price() ) ),
									'pricehtml'     => htmlentities( $child_product->get_price_html() ),
									'imagesrc'      => esc_url( apply_filters( 'woovr_variation_image_src', $child_image_src, $child_product ) ),
									'description'   => htmlentities( apply_filters( 'woovr_variation_info', $child_info, $child_product ) ),
									'availability'  => htmlentities( wc_get_stock_html( $child_product ) )
								), $child_product );

								echo '<option value="' . $child . '" ' . self::woovr_data_attributes( $data_attrs ) . ' ' . $child_selected . '>' . apply_filters( 'woovr_variation_name', $child_name, $child_product ) . '</option>';
							}

							echo '</select></div><!-- /woovr-variation-selector -->';

							if ( ( $selector === 'select' ) && ( $show_price === 'yes' ) ) {
								echo '<div class="woovr-variation-price"></div>';
							}

							echo '</div><!-- /woovr-variation -->';
						}

						echo '</div><!-- /woovr-variations -->';
					}
				}
			}

			new WPClever_Woovr();
		}
	}
} else {
	add_action( 'admin_notices', 'woovr_notice_premium' );
}

if ( ! function_exists( 'woovr_notice_wc' ) ) {
	function woovr_notice_wc() {
		?>
        <div class="error">
            <p><strong>WPC Variations Radio Buttons</strong> requires WooCommerce version 3.0 or greater.</p>
        </div>
		<?php
	}
}

if ( ! function_exists( 'woovr_notice_premium' ) ) {
	function woovr_notice_premium() {
		?>
        <div class="error">
            <p>Seems you're using both free and premium version of <strong>WPC Variations Radio Buttons</strong>. Please
                deactivate the free version when using the premium version.</p>
        </div>
		<?php
	}
}