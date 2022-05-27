<?php

$divi_powerful_archive_category_page_blog_read_more_text = get_option( 'divi_powerful_archive_category_page_blog_read_more_text', 'READ MORE' );

?>

	<div class="container free-grid-2-col-featured-overlay-sidebar">
		<div id="content-area" class="clearfix">
			<div id="left-area">
		<?php
			if ( have_posts() ) :
				$flag = 1;
				?>
				<div class="free-archive-blog">
					<div class="et_pb_row et_pb_gutters2">
						<?php
						
						while ( have_posts() ) : the_post();
						
							if($flag == 1) {
							
								$post_format = et_pb_post_format(); ?>
								
								<div class="et_pb_column et_pb_column_4_4 free-archive-blog-individual free-archive-blog-featured free-blog-list-2 free-blog-medium">
								
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
											
											$video_overlay = has_post_thumbnail() ? sprintf(
												'<div class="et_pb_video_overlay free-background-overlay" style="background-image: url(%1$s); background-size: cover;">
													<div class="et_pb_video_overlay_hover">
														<a href="#" class="et_pb_video_play"></a>
													</div>
												</div>',
												$thumb
											) : '';
											
											printf(
												'<div class="et_main_video_container">
													%1$s
												</div>',
												$video_overlay
											);
											
										elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
											<div class="et_pb_image_container">
												<a class="entry-featured-image-url free-background-overlay" href="<?php the_permalink(); ?>">
													<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
												</a>
											</div>
									<?php
										elseif ( 'gallery' === $post_format ) :
											et_pb_gallery_images();
										endif;
									} ?>
								
								<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
								
									<span class="free-post-meta-category-extra free-background-category-main-color free-text-category-secondary-color"><?php echo get_the_category_list(', '); ?></span>
									
									<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
										<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<?php endif; ?>

									<?php
										et_divi_post_meta();
									?>
										<div class="post-content">
											<p><?php truncate_post( 145 ); ?></p>
											<a href="<?php the_permalink(); ?>" class="more-link"><?php echo $divi_powerful_archive_category_page_blog_read_more_text; ?></a>
										</div>
								<?php endif; ?>

									</article> <!-- .et_pb_post -->
								
								</div>
								
							<?php
							
								$flag = 0;
							
							} else {
							
								$post_format = et_pb_post_format(); ?>
							
								<div class="et_pb_column et_pb_column_1_2 free-archive-blog-individual free-archive-blog-normal">
								
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
											
											$video_overlay = has_post_thumbnail() ? sprintf(
												'<div class="et_pb_video_overlay" style="background-image: url(%1$s); background-size: cover;">
													<div class="et_pb_video_overlay_hover">
														<a href="#" class="et_pb_video_play"></a>
													</div>
												</div>',
												$thumb
											) : '';
											
											printf(
												'<div class="et_main_video_container">
													%1$s
													%2$s
												</div>',
												$video_overlay,
												$first_video
											);
											
										elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
											<div class="et_pb_image_container">
												<a class="entry-featured-image-url free-background-overlay" href="<?php the_permalink(); ?>">
													<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, 400, 250 ); ?>
												</a>
											</div>
									<?php
										elseif ( 'gallery' === $post_format ) :
											et_pb_gallery_images();
										endif;
									} ?>

								<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
								
									<span class="free-post-meta-category-extra free-background-category-main-color free-text-category-secondary-color"><?php echo get_the_category_list(', '); ?></span>
									
									<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
										<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<?php endif; ?>

									<?php
										et_divi_post_meta();
									?>
										<div class="post-content">
											<p><?php truncate_post( 145 ); ?></p>
											<a href="<?php the_permalink(); ?>" class="more-link free-text-main-color free-text-dark-color"><?php echo $divi_powerful_archive_category_page_blog_read_more_text; ?></a>
										</div>
								<?php endif; ?>

									</article> <!-- .et_pb_post -->
								
								</div>
							
							<?php
							
							} ?>
							
					<?php
							endwhile;
							
							?>
					</div>
				</div>
				<?php
				
				divi_powerful_archive_blog_pagination();
					
			else :
				get_template_part( 'includes/no-results', 'index' );
			endif;
			?>
			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php 