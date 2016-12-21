<?php

get_header(); ?>

<div role="main">

<div class="row collapse align-center align-middle">

<?php
$count_posts = baw_count_posts( 'post' );
$published_posts = $count_posts->publish;
?>
<?php $all_items = array(
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'publish',
    'numberposts' => -1,
        'tax_query' => array(
                array(
            'taxonomy'  => 'classification',
            'field'     => 'slug',
            'terms'     => array('details', 'items', 'covers', 'logotypes'),
            'operator'  => 'IN')
            ),
);  
$all_items_loop = get_posts($all_items);
$count_items = count($all_items_loop);
?>
<?php
$random_item = array(
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'publish',
    'numberposts' => 1,
    'orderby' => 'rand',
        'tax_query' => array(
                array(
            'taxonomy'  => 'classification',
            'field'     => 'slug',
            'terms'     => 'selected',
            'operator'  => 'IN')
            ),
);  
$item = get_posts($random_item);
 
if ($item) {
    foreach ($item as $bg) {

    $bg_bigsquare = wp_get_attachment_image_src($bg->ID,'bigsquare');
    $bg_medium = wp_get_attachment_image_src($bg->ID,'medium');
    $bg_large = wp_get_attachment_image_src($bg->ID,'large');
    $bg_full = wp_get_attachment_image_src($bg->ID,'full');

            }
             
        }
        ?>
<div class="column small-12 medium-12 large-12 full-height CoverImage bg-fixed alphalayer-light" style="padding-top:1rem;position:relative;background-image:url(<?php echo $bg_full[0]; ?>);" data-interchange="[<?php echo $bg_bigsquare[0]; ?>, small], [<?php echo $bg_medium[0]; ?>, medium], [<?php echo $bg_large[0]; ?>, large], [<?php echo $bg_full[0]; ?>, xlarge]">

<div id="brand-motion" class="on-top" style="padding:1rem;">
<?php if(ICL_LANGUAGE_CODE=='fr') { ?>
<img class="gpg-slide-1" src="<?php echo get_template_directory_uri() . '/assets/images/pg-logo-full-fr.png' ?>" alt="">
<?php } else { ?>
<img class="gpg-slide-1" src="<?php echo get_template_directory_uri() . '/assets/images/pg-logo-full-en.png' ?>" alt="">  
<?php } ?>
<h1 class="gpg-slide-2"><em><?php echo $published_posts; ?>&nbsp;<?php echo __('Seals of Quality', 'FoundationPress'); ?></em></h1>
<p class="big gpg-slide-3"><?php echo __('Selected by', 'FoundationPress'); ?> 
<?php if(ICL_LANGUAGE_CODE=='fr') { ?>
<a href="https://parisiangentleman.fr/" target="_blank" title="parisiangentleman.fr">
<?php } else { ?>
<a href="https://parisiangentleman.co.uk/" target="_blank" title="parisiangentleman.fr">
<?php } ?>
<span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="<?php echo __('Parisian Gentleman is an online magazine dedicated to classical men’s style', 'FoundationPress'); ?>"><em>Parisian Gentleman</em></span></a></p>
</div>

</div>

</div>


<div id="grid-isotope-seals" class="row align-center align-top">
<?php

    $recentPosts = new WP_Query();

    $args_sticky = array(

        'posts_per_page'      => 1,
        'numberposts'    => 1,
        'post__in'            => get_option( 'sticky_posts' ),
        'ignore_sticky_posts' => 1,

    );

    $recentPosts->query($args_sticky);

    while ($recentPosts->have_posts()) : $recentPosts->the_post();

?>
<article class="stamp small-12 medium-6 large-6">
<div class="callout text-center">
<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?> » <?php the_field('tagline'); ?>"><?php echo __('Featuring:', 'FoundationPress'); ?> <?php the_title(); ?></a></h4>
<p><em><?php the_field('tagline'); ?></em></p>
<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?> » <?php the_field('tagline'); ?>"><img class="thumbnail" src="<?php echo seal_cover_src_medium(); ?>" alt="<?php the_title(); ?>" data-interchange="[<?php echo seal_cover_src_thumbnail(); ?>, small], [<?php echo seal_cover_src_medium(); ?>, medium], [<?php echo seal_cover_src_medium(); ?>, large]"></a>
</div>
</article>
<?php endwhile; ?>

<?php wp_reset_postdata(); ?>


	<?php if ( have_posts() ) : ?>
		<?php $args_seals = array (
            'orderby' => 'rand',
            'post__not_in' => get_option('sticky_posts')
        );?>
		<?php query_posts($args_seals); ?>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

<article class="seal small-6 medium-3 large-3">
<div class="callout text-center">
<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?> » <?php the_field('tagline'); ?>"><?php the_title(); ?></a></h4>
<p><em><?php the_field('tagline'); ?></em></p>
<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?> » <?php the_field('tagline'); ?>"><img class="thumbnail" src="<?php echo seal_cover_src_medium(); ?>" alt="<?php the_title(); ?>" data-interchange="[<?php echo seal_cover_src_thumbnail(); ?>, small], [<?php echo seal_cover_src_thumbnail(); ?>, medium], [<?php echo seal_cover_src_medium(); ?>, large]"></a>
</div>
</article>
		<?php endwhile; ?>

		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; // End have_posts() check. ?>

	
</div>
</div>
<?php get_footer();
