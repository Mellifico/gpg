<?php
/**
 * Template name: All Images
 */
?>

<?php get_header(); ?>

<?php  global $wp_rewrite;
             $current = $wp_query->query_vars['paged'] > 1 ?
             $wp_query->query_vars['paged'] : 1; ?>

<?php $args = array(
  //'lang' => ICL_LANGUAGE_CODE,
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'inherit',
    'numberposts' => 40,
    'offset' => 40 * ($current - 1),
    'suppress_filters' => false,
    'orderby' => 'date'
);  
$pagination = array(
  'base' => @add_query_arg( 'page', '%#%' ),
  'format' => '',
  'total' => wp_count_posts('attachment')->inherit / 40,
  'current' => $current,
  'show_all' => false,
  'end_size' => 2,
  'mid_size' => 4,
  'type' => 'list',
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
<div class="img-container" style="text-align:center;">

<h1 style="padding:1.6rem 0;"><?php the_title(); ?><sup><small>&nbsp;beta 1.1</small></sup></h1>
<h2>Les <?php echo $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'attachment'" ); ?> images illustrant <br />les articles de Parisian Gentleman.</h2>
<!-- <p>( <?php // echo $post_count ?>&nbsp;images sur cette page )</p> -->
<?php echo paginate_links($pagination); ?>

<?php 
if ($attachments) {
    foreach ($attachments as $attachment) {
	$img = wp_get_attachment_thumb_url($attachment->ID);
	$title = get_the_title($attachment->post_parent);
	$attimg_medium   = wp_get_attachment_image_src($attachment->ID,'medium');
       $attimg_large   = wp_get_attachment_image_src($attachment->ID,'large');
       $attimg_full   = wp_get_attachment_image_src($attachment->ID,'full');
	$atturl   = wp_get_attachment_url($attachment->ID);
	$attlink  = get_attachment_link($attachment->ID);
  $postparent_type = get_post_type($attachment->post_parent);
  $postparent_status = get_post_status($attachment->post_parent);
        $postparent_author_id = get_post_field( 'post_author', $attachment->post_parent);
        $postparent_author_name = get_the_author_meta( 'display_name', $postparent_author_id);
	$postlink = get_permalink($attachment->post_parent);
	$atttitle = apply_filters('the_title',$attachment->post_title);
       $postdate = get_the_date('j F Y',$attachment->post_parent);

if ($postparent_status=='publish' && $postparent_type!='advert') { 
        echo '<figure>';
        echo '<a class="image-link" title="'.$atttitle.'&nbsp;: image complète" href="'.$attimg_full[0].'"><img src="'.$img.'" alt="'.$atttitle.'"/></a>';
        echo '<figcaption style="min-height:150px;">';
        echo '<h6>'.$atttitle.'</h6>';
        echo '<a class="article-link" title="Lire cet article" href="'.$postlink.'">&#171;&nbsp;'.$title.'&nbsp;&#187;</a>';

        echo '<span style="font-size:.65em; color:#888;">Par&nbsp;<strong>'.$postparent_author_name.'</strong>, le&nbsp;'.$postdate.'</span>';
        echo '</figcaption>';
        echo '</figure>';
      }

    }   
} ?>

<?php echo paginate_links($pagination); ?>

</div>

<?php get_footer(); ?>