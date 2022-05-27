<?php get_header(); 

$divi_powerful_custom_404_styling_settings = get_option( 'divi_powerful_custom_404_styling_settings', 'none' );

?>

<div id="main-content">
	<?php
	if ($divi_powerful_custom_404_styling_settings != 'none') { ?>
		<div class="free-custom-404-page">
			<?php
				$dp_404_style = do_shortcode('[et_pb_section global_module="' . $divi_powerful_custom_404_styling_settings . '"][/et_pb_section]');
				echo $dp_404_style;
			?>
		</div> <!-- .free-custom-404-page -->
	<?php
	} else { ?>
		<div class="container">
			<div id="content-area" class="clearfix">
					<div id="left-area">
						<article id="post-0" <?php post_class( 'et_pb_post not_found' ); ?>>
							<?php get_template_part( 'includes/no-results', '404' ); ?>
						</article> <!-- .et_pb_post -->
					</div> <!-- #left-area -->

					<?php get_sidebar(); ?>

			</div> <!-- #content-area -->
		</div> <!-- .container -->
	<?php
	} ?>
</div> <!-- #main-content -->

<?php

get_footer();
