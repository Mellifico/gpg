<?php
/**
 * Template name: All Items
 */
?>

<?php get_header(); ?>

<div id="page-full-width" role="main">

<?php  global $wp_rewrite;
             $current = $wp_query->query_vars['paged'] > 1 ?
             $wp_query->query_vars['paged'] : 1; ?>

<?php $args = array(
  //'lang' => ICL_LANGUAGE_CODE,
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'publish',
    'numberposts' => 40,
    'offset' => 40 * ($current - 1),
    'suppress_filters' => false,
    'orderby' => 'rand',
    'tax_query' => array(
              array(
            'taxonomy'  => 'classification',
            'field'     => 'slug',
            'terms'     => 'items',
            'operator'  => 'IN')
            ),

);  

$pagination = array(
  'base' => @add_query_arg( 'page', '%#%' ),
  'format' => '',
  'total' => wp_count_posts('attachment')->inherit / 40,
  'current' => $current,
  'show_all' => false,
  'end_size' => 0,
  'mid_size' => 0,
  'type' => 'plain',
  'before_page_number' => '&#123;',
  'after_page_number' => '&#125;',
  'prev_text'    => '« Précédentes',
  'next_text'    => 'Suivantes »'
  );
if( $wp_rewrite->using_permalinks() )
  $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');

if( !empty($wp_query->query_vars['s']) )
  $pagination['add_args'] = array('s'=>get_query_var('s'));

$attachments = get_posts($args);
$post_count = count ($attachments);
?>


<div class="text-center">
<h1 class="typo-large"><em><?php the_title(); ?></em></h1>
<div class="big"><?php the_content(); ?></div>
<hr />
<div class="big"><?php echo paginate_links($pagination); ?></div>
<hr />
</div>
<div id="grid-isotope-items" class="bg-light-gray">
<?php 
if ($attachments) {
    foreach ($attachments as $attachment) {

  $img = wp_get_attachment_thumb_url($attachment->ID);
  $title = get_the_title($attachment->post_parent);
  $attimg_micro = wp_get_attachment_image_src($attachment->ID,'microthumb');
  $attimg_th = wp_get_attachment_image_src($attachment->ID,'thumbnail');
  $attimg_medium = wp_get_attachment_image_src($attachment->ID,'medium');
    $attimg_large = wp_get_attachment_image_src($attachment->ID,'large');
    $attimg_full = wp_get_attachment_image_src($attachment->ID,'full');
  $atturl = wp_get_attachment_url($attachment->ID);
  $attlink = get_attachment_link($attachment->ID);
  $atttitle = apply_filters('the_title',$attachment->post_title);
    $attslug = sanitize_title($atttitle);
  $parent_id = $attachment->post_parent;
  $parent_title = get_the_title( $parent_id );
  $parent_permalink = get_permalink( $parent_id );
  $detail1_micro = wp_get_attachment_image_src(get_field('item_detail_1', $attachment->ID), 'microthumb');
  $detail2_micro = wp_get_attachment_image_src(get_field('item_detail_2', $attachment->ID), 'microthumb');
  $detail3_micro = wp_get_attachment_image_src(get_field('item_detail_3', $attachment->ID), 'microthumb');
  $detail1_th = wp_get_attachment_image_src(get_field('item_detail_1', $attachment->ID), 'thumbnail');
  $detail2_th = wp_get_attachment_image_src(get_field('item_detail_2', $attachment->ID), 'thumbnail');
  $detail3_th = wp_get_attachment_image_src(get_field('item_detail_3', $attachment->ID), 'thumbnail');
  $detail1_full = wp_get_attachment_image_src(get_field('item_detail_1', $attachment->ID), 'full');
  $detail2_full = wp_get_attachment_image_src(get_field('item_detail_2', $attachment->ID), 'full');
  $detail3_full = wp_get_attachment_image_src(get_field('item_detail_3', $attachment->ID), 'full');
  ?>

  <?php
        echo '<div class="item column small-12 medium-4 large-2">';
        echo '<figure id="item-'.$attachment->ID.'" class="smallbrd bg-light" style="padding:1rem;margin:1rem 0;">';
        echo '<figcaption class="text-center">';
        echo '<a class="block smallcaps text-center" href="'.$parent_permalink.'" title="Consulter la page dédiée à '.$parent_title.'">'.$parent_title.'</a>';   
        echo '<a class="big" href="'.$parent_permalink.'#'.$attslug.'-item-'.$attachment->ID.'" title="Voir cet item sur la page dédiée à '.$parent_title.'"><em>'.$atttitle.'</em></a>';
        
        echo '</figcaption>';
        
        echo '<a class="img-link block full-block" title="'.$atttitle.'" href="'.$attimg_full[0].'"><img style="width:100%;" src="'.$attimg_th[0].'" alt="'.$atttitle.'"/></a>';
        echo '<br /><div class="row align-center">';
  if ($detail1_micro) {echo '<a class="img-link column small-4" href="'.$detail1_full[0].'"><img src="'.$detail1_micro[0].'" alt="" /></a>'; }
  if ($detail2_micro) {echo '<a class="img-link column small-4" href="'.$detail2_full[0].'"><img src="'.$detail2_micro[0].'" alt="" /></a>'; }
  if ($detail3_micro) {echo '<a class="img-link column small-4" href="'.$detail3_full[0].'"><img src="'.$detail3_micro[0].'" alt="" /></a>'; }
        echo '</div>';
        echo '</figure>';
        echo '</div>';
        ?>
    <?php } ?>  
<?php } ?>
</div>
</div>
<hr />
<div class="big text-center pattern2"><?php echo paginate_links($pagination); ?></div>
<hr />
</div>

<?php get_footer(); ?>