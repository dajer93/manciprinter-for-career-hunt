<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php elegant_description(); ?>
	<?php elegant_keywords(); ?>
	<?php elegant_canonical(); ?>

	<?php do_action( 'et_head_meta' ); ?>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php $template_directory_uri = get_template_directory_uri(); ?>
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( $template_directory_uri . '/js/html5.js"' ); ?>" type="text/javascript"></script>
	<![endif]-->

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="jam-menu-overlay"></div>
<?php
	$product_tour_enabled = et_builder_is_product_tour_enabled();
	$page_container_style = $product_tour_enabled ? ' style="padding-top: 0px;"' : ''; ?>
	<div id="page-container"<?php echo $page_container_style; ?>>
<?php
	if ( $product_tour_enabled || is_page_template( 'page-template-blank.php' ) ) {
		return;
	}

	$et_secondary_nav_items = et_divi_get_top_nav_items();

	$et_phone_number = $et_secondary_nav_items->phone_number;

	$et_email = $et_secondary_nav_items->email;

	$et_contact_info_defined = $et_secondary_nav_items->contact_info_defined;

	$show_header_social_icons = $et_secondary_nav_items->show_header_social_icons;

	$et_secondary_nav = $et_secondary_nav_items->secondary_nav;

	$et_top_info_defined = $et_secondary_nav_items->top_info_defined;

	$et_slide_header = 'slide' === et_get_option( 'header_style', 'left' ) || 'fullscreen' === et_get_option( 'header_style', 'left' ) ? true : false;
?>

	<?php if ( $et_top_info_defined && ! $et_slide_header || is_customize_preview() ) : ?>
		<div id="top-header"<?php echo $et_top_info_defined ? '' : 'style="display: none;"'; ?>>
			<div class="container clearfix">

			<?php if ( $et_contact_info_defined ) : ?>

				<div id="et-info">
				<?php if ( '' !== ( $et_phone_number = et_get_option( 'phone_number' ) ) ) : ?>
					<span id="et-info-phone"><?php echo et_sanitize_html_input_text( $et_phone_number ); ?></span>
				<?php endif; ?>

				<?php if ( '' !== ( $et_email = et_get_option( 'header_email' ) ) ) : ?>
					<a href="<?php echo esc_attr( 'mailto:' . $et_email ); ?>"><span id="et-info-email"><?php echo esc_html( $et_email ); ?></span></a>
				<?php endif; ?>

				<?php
				if ( true === $show_header_social_icons ) {
					get_template_part( 'includes/social_icons', 'header' );
				} ?>
				</div> <!-- #et-info -->

			<?php endif; // true === $et_contact_info_defined ?>

				<div id="et-secondary-menu">
				<?php
					if ( ! $et_contact_info_defined && true === $show_header_social_icons ) {
						get_template_part( 'includes/social_icons', 'header' );
					} else if ( $et_contact_info_defined && true === $show_header_social_icons ) {
						ob_start();

						get_template_part( 'includes/social_icons', 'header' );

						$duplicate_social_icons = ob_get_contents();

						ob_end_clean();

						printf(
							'<div class="et_duplicate_social_icons">
								%1$s
							</div>',
							$duplicate_social_icons
						);
					}

					if ( '' !== $et_secondary_nav ) {
						echo $et_secondary_nav;
					}

					et_show_cart_total();
				?>
				</div> <!-- #et-secondary-menu -->

			</div> <!-- .container -->
		</div> <!-- #top-header -->
	<?php endif; // true ==== $et_top_info_defined ?>

		<header id="main-header" data-height-onload="<?php echo esc_attr( et_get_option( 'menu_height', '66' ) ); ?>">
			<div class="container clearfix et_menu_container">
			<?php
				$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo
					? $user_logo
					: $template_directory_uri . '/images/logo.png';
			?>
				<div class="logo_container">
					<span class="logo_helper"></span>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
					</a>
				</div>
				<div class="jam-header-button-container">
					<a class="jam-social" target="_blank" href="https://www.instagram.com/vas_manci/"><span class="jam-instagram"></span></a>
					<a class="jam-social" target="_blank" href="https://www.facebook.com/vasmancibar/"><span class="jam-facebook"></span></a>
					<a class="jam-social last" target="_blank" href="https://www.tripadvisor.co.hu/Restaurant_Review-g274887-d12645138-Reviews-Vas_Manci-Budapest_Central_Hungary.html?m=19905"><span class="jam-tripadvisor"></span></a>
					<a class="jam-menu" href="<?php pll_e('/etlap'); ?>"><?php pll_e('Étlap'); ?></a>
					<a class="jam-reservation" href="#reservation"><?php pll_e('Asztalfoglalás'); ?></a>
				</div>
				<div id="et-top-navigation" data-height="<?php echo esc_attr( et_get_option( 'menu_height', '66' ) ); ?>" data-fixed-height="<?php echo esc_attr( et_get_option( 'minimized_menu_height', '40' ) ); ?>">
					<span class="jam-toggle-menu"></span>
				</div> <!-- #et-top-navigation -->
			</div> <!-- .container -->
		</header> <!-- #main-header -->
		<div class="jam-sidemenu">
			<div class="jam-sidemenu-top">
				<img src="/wp-content/uploads/2018/05/manci_logo_2_white.png" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="sidemenu-logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
				<a class="jam-sidemenu-social" target="_blank" href="https://www.instagram.com/vas_manci/"><span class="jam-sidemenu-instagram"></span></a>
				<a class="jam-sidemenu-social" target="_blank" href="https://www.facebook.com/vasmancibar/"><span class="jam-sidemenu-facebook"></span></a>
				<a class="jam-sidemenu-social last" target="_blank" href="https://www.tripadvisor.co.hu/Restaurant_Review-g274887-d12645138-Reviews-Vas_Manci-Budapest_Central_Hungary.html?m=19905"><span class="jam-sidemenu-tripadvisor"></span></a>
				<span class="jam-toggle-menu close"></span>
			</div>
			<div class="lang-switcher">
				<?php pll_the_languages(array(
						'dropdown' 		=> 0,
						'show_names'	=> 1,
						'show_flags'	=> 0,
						'hide_if_empty'	=> 0,
						'hide_current'	=> 1
					)); ?>
			</div>
			<div class="jam-sidemenu-mid">
				<?php 
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => 'top-menu', 'echo' => false ) );
				echo $primaryNav;
				?>
			</div>
			<div class="jam-sidemenu-bottom">
				<h3><?php pll_e('Kapcsolat'); ?></h3>
				<div><span><?php pll_e('Tel.:'); ?> </span><span class="span-right">+36 20 800 8953</span></div>
				<div><span><?php pll_e('Cím:'); ?> </span><span class="span-right">1088 Budapest Vas utca 3.</span></div>
				<h3 class="last"><?php pll_e('Nyitvatartás'); ?></h3>
				<div><span><?php pll_e('H-Szo:'); ?> </span><span class="span-right">12:00 - 22:00</span></div>
				<div><span><?php pll_e('V:'); ?> </span><span class="span-right"><?php pll_e('Zárva'); ?></span></div>
			</div>
		</div>

		<div id="et-main-area">
