<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<div id="page-full-width" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">

		
			<header class="row align-top align-left pattern3">

			<div class="column small-12 medium-12 large-8">
			<div id="seal-motion" class="callout large">
			<h1 class="typo-large gpg-slide"><em><?php the_title(); ?></em></h1>
			<div class="big">
			<h2><em><?php the_field('tagline'); ?></em></h2>
			<?php the_content(); ?>
			</div>
			</div>
			</div>

			<div class="column small-12 medium-12 large-4">
			<div class="row">
			<div class="column small-12 medium-6 large-12">
			<div class="callout">
			<?php
			if ( has_post_thumbnail() ) :
				the_post_thumbnail();
			endif;
			?>
			</div>
			</div>
			<div class="column small-12 medium-6 large-12">
			<hr />
			<div class="callout monospace">
			<?php the_field('infos'); ?>
			</div>
			<hr />
			</div>
			</div>
			</div>
			</header>


		<?php do_action( 'foundationpress_post_before_entry_content' ); ?>
		<div class="entry-content">
		<?php
	    $defaults = array(
	            'post_type'      => 'attachment',
	            'post_parent'    => $post->ID,
	            'post_mime_type' => 'image',
	            'post_status'    => 'publish',
	            'numberposts'    => 1,
	            'tax_query' => array(
	                array(
	                    'taxonomy'  => 'classification',
	                    'field'     => 'slug',
	                    'terms'     => 'covers'
	                    )
	                    ),
	        );
	    $cover_info = get_posts($defaults);

	        if ($cover_info) {

	            foreach ($cover_info as $sealcover) {

	            		$cover_full = wp_get_attachment_image_src($sealcover->ID, 'full');
	            		$cover_large = wp_get_attachment_image_src($sealcover->ID, 'large');
	            		$cover_medium = wp_get_attachment_image_src($sealcover->ID, 'medium');
	            		$cover_bigsquare = wp_get_attachment_image_src($sealcover->ID, 'bigsquare');

	            }

	        }
	        ?>

<div class="CoverImage bg-fixed full-height" style="background-image:url(<?php echo $cover_full[0]; ?>);" data-interchange="[<?php echo $cover_bigsquare[0]; ?>, small], [<?php echo $cover_medium[0]; ?>, medium], [<?php echo $cover_large[0]; ?>, large], [<?php echo $cover_full[0]; ?>, xlarge]">

</div>
		<?php item_toolset(); ?>
		</div>
		<footer>
<hr />
			<?php wp_link_pages( array('before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'foundationpress' ), 'after' => '</p></nav>' ) ); ?>
			<div class="big clearfix" style="padding:2rem 1rem;">

<span class="float-left"><?php previous_post_link(); ?></span>  <span class="float-right"><?php next_post_link(); ?></span>

</div>
<hr />
		</footer>



	</article>
<?php endwhile;?>

<?php do_action( 'foundationpress_after_content' ); ?>

</div>
<?php get_footer();
