<?php

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

$show_navigation = get_post_meta( get_the_ID(), '_et_pb_project_nav', true );

$thumb = '';

$width = (int) apply_filters( 'et_pb_portfolio_single_image_width', 1080 );
$height = (int) apply_filters( 'et_pb_portfolio_single_image_height', 9999 );
$classtext = 'et_featured_image';
$titletext = get_the_title();
$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Projectimage' );
$thumb = $thumbnail["thumb"];

$page_layout = get_post_meta( get_the_ID(), '_et_pb_page_layout', true );

if ( '' !== $thumb ){
	$jam_fullwidth = "jam-food jam-food-left";
} else {
	$jam_fullwidth = "jam-food";
}

?>

<div id="main-content">
	<?php if (pll_current_language() == 'hu') { ?>
		<?php echo do_shortcode('[et_pb_section global_module="225"][/et_pb_section]'); ?>
	<?php } else { ?>
		<?php echo do_shortcode('[et_pb_section global_module="434"][/et_pb_section]'); ?>
	<?php } ?>
<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">

<?php endif; ?>
			
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="jam-food-page">
						<div class="jam-food-top-bg"></div>
						<div class="jam-flex">
							<div class="<?php echo $jam_fullwidth; ?>">

				<?php if ( ! $is_page_builder_used ) : ?>

					<div class="jam-food-title">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php /*<span class="et_project_categories"><?php echo get_the_term_list( get_the_ID(), 'project_category', '', ', ' ); ?></span> */?>
					</div>

				<?php endif; ?>

					<div class="jam-food-desc">
					
						<?php the_content(); ?>
						
					</div> <!-- .entry-content -->
					<div class="jam-food-price">
						<?php echo get_post_meta(get_the_ID(), 'price')[0] ?>
					</div>

				<?php if ( ! $is_page_builder_used ) : ?>

					<div class="jam-food-meta">
						<?php /* <strong class="et_project_meta_title"><?php echo esc_html__( 'Skills', 'Divi' ); ?></strong> */
						$jam_tags = wp_get_object_terms(get_the_ID(), 'project_tag');
						if (count($jam_tags) > 0){
						?>
						<span class="jam-food-meta-title">Info:</span>
						<?php } ?>
						<ul><?php
							for ($i=0; $i < count($jam_tags); $i++) { 
								echo '<li>'.$jam_tags[$i]->name.'</li>';
							}
						?></ul>

						<?php /* <strong class="et_project_meta_title"><?php echo esc_html__( 'Posted on', 'Divi' ); ?></strong>
						<p><?php echo get_the_date(); ?></p> */ ?>
					</div>

				<?php endif; ?>
							</div>
							<?php if ( '' !== $thumb ){ ?>
							<div class="jam-food-right">
								<?php

								if ( '' !== $thumb )
									print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
								?>
							</div>
							<?php } ?>
						</div>
						<div class="jam-food-bottom-upsale jam-menu-page">
							<?php do_action( 'jam_related_foods', get_the_ID() ); ?>
							<div class="jam-food-go-back">
								<a href="<?php pll_e('/etlap'); ?>"><?php pll_e('Teljes étlap'); ?></a>
							</div>
						</div>
						<div class="jam-food-bottom-bg"></div>
					</div>
				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php endif; ?>
<?php if (pll_current_language() == 'hu') { ?>
	<?php echo do_shortcode('[et_pb_section global_module="232"][/et_pb_section]'); ?>
<?php } else { ?>
	<?php echo do_shortcode('[et_pb_section global_module="429"][/et_pb_section]'); ?>
<?php } ?>
</div> <!-- #main-content -->

<?php

get_footer();
