<?php get_header();

$divi_powerful_archive_category_page_header_styling_settings = get_option( 'divi_powerful_archive_category_page_header_styling_settings', 'none' );
$divi_powerful_archive_category_page_blog_styling_settings = get_option( 'divi_powerful_archive_category_page_blog_styling_settings', 'grid-2-col-sidebar' );

?> 

<div id="main-content" class="free-archive-wrapper">
	
	<?php if  ( is_tag() || is_category() || is_author() || is_archive() || is_home() || is_search() ): ?>
		
		<?php
			if ($divi_powerful_archive_category_page_header_styling_settings != 'none') {	?>
				<div class="free-archive-header">
					<?php
					$dp_archive_category_page_header_style = do_shortcode('[et_pb_section global_module="' . $divi_powerful_archive_category_page_header_styling_settings . '"][/et_pb_section]');
					echo $dp_archive_category_page_header_style;	?>
				</div>
			<?php
			}
		?>
	<?php endif;
 
	$dp_cat_layout = 'none';
	if (isset($_GET['dp_cat_layout'])) {
	  $dp_cat_layout = $_GET['dp_cat_layout'];
	}
	
	if ( file_exists(get_stylesheet_directory() . '/dp-assets/archive-blog/'. $dp_cat_layout . '.php') ) {
		include(get_stylesheet_directory() . '/dp-assets/archive-blog/'. $dp_cat_layout . '.php');
	} else {
		
		if ( file_exists(get_stylesheet_directory() . '/dp-assets/archive-blog/'. $divi_powerful_archive_category_page_blog_styling_settings . '.php') && ($divi_powerful_archive_category_page_blog_styling_settings != 'none') ) {
			include(get_stylesheet_directory() . '/dp-assets/archive-blog/'. $divi_powerful_archive_category_page_blog_styling_settings . '.php');
		} else { ?>

			<div class="container">
				<div id="content-area" class="clearfix">
					<div id="left-area">
				<?php
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							$post_format = et_pb_post_format(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

						<?php
							$thumb = '';

							$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

							$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
							$classtext = 'et_pb_post_main_image';
							$titletext = get_the_title();
							$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
							$thumb = $thumbnail["thumb"];

							et_divi_post_format_content();

							if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
								if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
									printf(
										'<div class="et_main_video_container">
											%1$s
										</div>',
										$first_video
									);
								elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
									<a class="entry-featured-image-url" href="<?php the_permalink(); ?>">
										<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
									</a>
							<?php
								elseif ( 'gallery' === $post_format ) :
									et_pb_gallery_images();
								endif;
							} ?>

						<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
							<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php endif; ?>

							<?php
								et_divi_post_meta();

								if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
									truncate_post( 270 );
								} else {
									the_content();
								}
							?>
						<?php endif; ?>

							</article> <!-- .et_pb_post -->
					<?php
							endwhile;

							if ( function_exists( 'wp_pagenavi' ) )
								wp_pagenavi();
							else
								get_template_part( 'includes/navigation', 'index' );
						else :
							get_template_part( 'includes/no-results', 'index' );
						endif;
					?>
					</div> <!-- #left-area -->

					<?php get_sidebar(); ?>
				</div> <!-- #content-area -->
			</div> <!-- .container -->
		
		<?php
		}
	}		?>

</div> <!-- #main-content -->

<?php

get_footer();
