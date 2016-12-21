<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="google-site-verification" content="22weiMJUj1vrAxb5-aa0d74RMqANFRDm3-Y103bzxQM" />
		<script src="https://use.typekit.net/abd8tmq.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class('ligatures'); ?>>
	
	<?php do_action( 'foundationpress_after_body' ); ?>

	<?php if ( get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>
	<div class="off-canvas-wrapper">
		<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
		<?php get_template_part( 'template-parts/mobile-off-canvas' ); ?>
	<?php endif; ?>

	<?php do_action( 'foundationpress_layout_start' ); ?>
<div id="preloader" style="background: #fff url('https://guide.parisiangentleman.fr/wp-content/uploads/Forrest.gif') no-repeat 4rem 4rem;">
</div>
	<header id="masthead" class="site-header">
		<div class="title-bar" data-responsive-toggle="site-navigation">
			<button class="menu-icon" type="button" data-toggle="mobile-menu"></button>
			<div class="title-bar-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</div>
		</div>
	<div class="row" data-sticky-container>
		<nav id="site-navigation" class="main-navigation top-bar sticky" data-sticky data-options="marginTop:0;" style="width:100%;z-index:100;" role="navigation" >
			<div class="top-bar-left">
				<ul class="menu">
					<li class="home">

					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="Accueil du guide"><?php bloginfo( 'name' ); ?></a>

					</li>
				</ul>
			</div>
			<div class="top-bar-right">
			<ul class="menu align-right">
			<li style="padding-right:2px;"><select id="seals-select" style="margin:0;" name="seals-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value=""><?php echo esc_attr( __( 'Seals' ) ); ?></option> 
						  <?php wp_get_archives( 'type=alpha&format=option' ); ?>
						</select></li>
						<li><?php apply_filters( 'wpml_element_link', 540 ); ?></li>
						<li><?php languages_list(); ?></li>

				<?php foundationpress_top_bar_r(); ?>

				<?php if ( ! get_theme_mod( 'wpt_mobile_menu_layout' ) || get_theme_mod( 'wpt_mobile_menu_layout' ) == 'topbar' ) : ?>
					<?php get_template_part( 'template-parts/mobile-top-bar' ); ?>
				<?php endif; ?>
				</ul>
			</div>
		</nav>
		</div>
	</header>

	<section class="container">
		<?php do_action( 'foundationpress_after_header' );
