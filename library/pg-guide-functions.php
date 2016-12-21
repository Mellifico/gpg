<?php
/**
 * Define PG Guide bespoke functions
 *
 * The functions here mostly rely on taxonomies created and applied to post attachments (classification / covers, items, details, logotypes)
 * They are based on custom fields too (ACF plugin, currently) : none, one or more detail images for each attachment in classification "items"
 *
 * Crafted and added by me to :
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

	//Add a new very small size for medias
	add_action('init', 'microthumbs');
		function microthumbs() {
        add_image_size( 'microthumb', 64, 64, array( 'center', 'center' ) );   
		}
//Add a new big square size for medias ratio presentationnal purpose
    add_action('init', 'bigsquare');
        function bigsquare() {
        add_image_size( 'bigsquare', 470, 470, array( 'center', 'center' ) );   
        }

function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = __('Seals');
    $submenu['edit.php'][5][0] = __('All Seals');
    $submenu['edit.php'][10][0] = __('Add Seals');
    echo '';
}

function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = __('Seals');
        $labels->singular_name = __('Seal');
        $labels->menu_name = __('Seals');
        $labels->all_items = __('All Seals');
        $labels->add_new = __('Add Seal');
        $labels->add_new_item = __('Add Seal');
        $labels->edit_item = __('Edit Seals');
        $labels->new_item = __('Seal');
        $labels->view_item = __('View Seal');
        $labels->search_items = __('Search Seals');
        $labels->not_found = __('No Seals found');
        $labels->not_found_in_trash = __('No Seals found in Trash');
    }
    add_action( 'init', 'change_post_object_label' );
    add_action( 'admin_menu', 'change_post_menu_label' );

// Register Custom Post Type
function custom_post_type() {

    $labels = array(
        'name'                => _x( 'Lexicon', 'Post Type General Name', 'FoundationPress' ),
        'singular_name'       => _x( 'Lexicon', 'Post Type Singular Name', 'FoundationPress' ),
        'menu_name'           => __( 'Lexicon', 'FoundationPress' ),
        'parent_item_colon'   => __( 'Parent Lexicon:', 'FoundationPress' ),
        'all_items'           => __( 'All Lexicon Entries', 'FoundationPress' ),
        'view_item'           => __( 'View Lexicon Entry', 'FoundationPress' ),
        'add_new_item'        => __( 'Add New Lexicon Entry', 'FoundationPress' ),
        'add_new'             => __( 'Add New Entry', 'FoundationPress' ),
        'edit_item'           => __( 'Edit Lexique Entry', 'FoundationPress' ),
        'update_item'         => __( 'Update Lexicon Entry', 'FoundationPress' ),
        'search_items'        => __( 'Search Lexicon Entry', 'FoundationPress' ),
        'not_found'           => __( 'Not found', 'FoundationPress' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'FoundationPress' ),
    );
    $args = array(
        'label'               => __( 'lexicon', 'FoundationPress' ),
        'description'         => __( 'Lexicon Description', 'FoundationPress' ),
        'labels'              => $labels,
        'supports'            => array( ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'lexicon', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type', 0 );

// Show custom posts on home page
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

function add_my_post_types_to_query( $query ) {
  if ( is_search() || is_home() && $query->is_main_query() )
    $query->set( 'custom_post', array( 'post_type' ) );
  return $query;
}

// Register Custom Taxonomy
function attachments_custom_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Classifications', 'Taxonomy General Name', 'FoundationPress' ),
        'singular_name'              => _x( 'Classification', 'Taxonomy Singular Name', 'FoundationPress' ),
        'menu_name'                  => __( 'Classifications', 'FoundationPress' ),
        'all_items'                  => __( 'All Classifications', 'FoundationPress' ),
        'parent_item'                => __( 'Parent Classification', 'FoundationPress' ),
        'parent_item_colon'          => __( 'Parent Classification:', 'FoundationPress' ),
        'new_item_name'              => __( 'New Classification Name', 'FoundationPress' ),
        'add_new_item'               => __( 'Add New Classification', 'FoundationPress' ),
        'edit_item'                  => __( 'Edit Classification', 'FoundationPress' ),
        'update_item'                => __( 'Update Classification', 'FoundationPress' ),
        'separate_items_with_commas' => __( 'Separate classifications with commas', 'FoundationPress' ),
        'search_items'               => __( 'Search Classifications', 'FoundationPress' ),
        'add_or_remove_items'        => __( 'Add or remove classifications', 'FoundationPress' ),
        'choose_from_most_used'      => __( 'Choose from the most used classifications', 'FoundationPress' ),
        'not_found'                  => __( 'Classification not Found', 'FoundationPress' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'update_count_callback'      => '_update_generic_term_count',  );
    register_taxonomy( 'classification', array( 'attachment' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'attachments_custom_taxonomy', 0 );

// Register Custom Taxonomy
function attachments_custom_taxonomy_2() {

    $labels = array(
        'name'                       => _x( 'Subjects', 'Taxonomy General Name', 'FoundationPress' ),
        'singular_name'              => _x( 'Subject', 'Taxonomy Singular Name', 'FoundationPress' ),
        'menu_name'                  => __( 'Subjects', 'FoundationPress' ),
        'all_items'                  => __( 'All Subjects', 'FoundationPress' ),
        'parent_item'                => __( 'Parent Subject', 'FoundationPress' ),
        'parent_item_colon'          => __( 'Parent Subject:', 'FoundationPress' ),
        'new_item_name'              => __( 'New Subject Name', 'FoundationPress' ),
        'add_new_item'               => __( 'Add New Subject', 'FoundationPress' ),
        'edit_item'                  => __( 'Edit Subject', 'FoundationPress' ),
        'update_item'                => __( 'Update Subject', 'FoundationPress' ),
        'separate_items_with_commas' => __( 'Separate subjects with commas', 'FoundationPress' ),
        'search_items'               => __( 'Search Subjects', 'FoundationPress' ),
        'add_or_remove_items'        => __( 'Add or remove subjects', 'FoundationPress' ),
        'choose_from_most_used'      => __( 'Choose from the most used subjects', 'FoundationPress' ),
        'not_found'                  => __( 'Subject not Found', 'FoundationPress' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'update_count_callback'      => '_update_generic_term_count',  );
    register_taxonomy( 'subject', array( 'attachment' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'attachments_custom_taxonomy_2', 0 );

    // giga super important pour les templates de la custom taxonomie appliquée aux médias
    // cf. :  commentaires de http://wordpress.stackexchange.com/questions/29635/how-to-create-an-attachments-archive-with-working-pagination 
add_action('parse_query', 'hijack_query');

function hijack_query() {

    global $wp_query;

    // When inside a custom taxonomy archive include attachments 
    if (is_tax('classification') OR is_tax('subject')) {
        $wp_query->query_vars['post_type'] =  array( 'attachment' );
        $wp_query->query_vars['post_status'] =  array( null );
        // $wp_query->query_vars['tax_query'] =  array( array('taxonomy' => 'topic', 'field' => 'slug', 'terms' => array( 'verticale' ), 'operator' => 'NOT IN') );

        return $wp_query;
    }
}


function languages_list(){
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    if(!empty($languages)){
        foreach($languages as $l){
            echo '<li>';
            echo '<a href="'.$l['url'].'">';
            echo icl_disp_language($l['native_name']);
            echo '</a>';
            echo '</li>';
        }
    }
}
function baw_count_posts( $args )
 {
 // Si on passe juste un type de post en chaine, on force la construction du tableau
 $args = is_string( $args ) ? array( 'post_type'=>$args ) : $args;
 // valeurs par défaut
 $default = array( 'post_type'=>'post', 'perm'=>'', 'lang'=>'', 'post_status'=>'publish' );
 // croisement des valeurs par défaut avec celles passées en paramètre
 $args = wp_parse_args( $args, $default );
 // extraction des variables
 extract( $args, EXTR_SKIP );
 // on vérifie que WPML est activé avec leur globale, si "non", on fait appel à la fonction WordPress à la place
 global $sitepress;
 if( !$sitepress )
 return wp_count_posts( $post_type, $perm );
 // Si on a déjà en cache notre valeur on la renvoie
 $count = wp_cache_get( $post_type, 'counts' );
 if ( false !== $count )
 return (object)array( $post_status=>$count );
 // On récupère la classe globale WPDB (WordPress DataBase)
 global $wpdb;
 // Si on a pas fourni de langue dans les paramètres on prends la valeur de WPML sinon "fr"
 if( empty( $lang ) )
 $lang = defined('ICL_LANGUAGE_CODE')?ICL_LANGUAGE_CODE:'fr';
 // simple raccourci pour gagner de la place en nombre de caractères (place que je perds avec ce commentaire ;p)
 $p = $wpdb->prefix;
 // La requête magique
 $query = "SELECT COUNT( {$p}posts.ID )
 FROM {$p}posts
 LEFT JOIN {$p}icl_translations ON
 {$p}posts.ID = {$p}icl_translations.element_id
 WHERE {$p}posts.post_status='{$post_status}'
 AND {$p}posts.post_type='{$post_type}'
 AND {$p}icl_translations.language_code = '{$lang}'
 AND {$p}icl_translations.element_type = 'post_{$post_type}'";
 // on lance la requête
 $count = $wpdb->get_var( $query );
 // Mise en cache
 wp_cache_set( $post_type, $count, 'counts' );
 // Construction de l'object de retour
 $count = (object)array( $post_status=>$count );
 // Envoie de la valeur
 return $count;
 }

 // get the slug of post title
if(!function_exists('the_slug')) :
function the_slug() {
	$post_data = get_post($post->ID, ARRAY_A);
	$slug = $post_data['post_name'];
	return $slug;
}
endif;


if ( ! function_exists( 'item_toolset' ) ) :

	function item_toolset() {

		global $post;

		$args = array(
					'orderby'          => 'rand',
					'post_type'      => 'attachment',
					'post_parent'    => $post->ID,
					'post_mime_type' => 'image',
					'post_status'    => null,
					'numberposts'    => -1,
					'tax_query'	=> array(
				        array(
				            'taxonomy'  => 'classification',
				            'field'     => 'slug',
				            'terms'     => 'items',
				            'operator'  => 'IN')
				            ),
				);
				$attachments = get_posts($args);

				if ($attachments) {
					
    foreach ($attachments as $attachment) {

	$img = wp_get_attachment_thumb_url($attachment->ID);
	$title = get_the_title($attachment->post_parent);
	$attimg_micro = wp_get_attachment_image_src($attachment->ID,'microthumb');
	$attimg_th = wp_get_attachment_image_src($attachment->ID,'thumbnail');
	$attimg_medium = wp_get_attachment_image_src($attachment->ID,'medium');
    $attimg_large = wp_get_attachment_image_src($attachment->ID,'large');
    $attimg_bigsquare = wp_get_attachment_image_src($attachment->ID,'bigsquare');
    $attimg_full = wp_get_attachment_image_src($attachment->ID,'full');
	$atturl = wp_get_attachment_url($attachment->ID);
	$attlink = get_attachment_link($attachment->ID);
	$atttitle = apply_filters('the_title',$attachment->post_title);
	$attslug = sanitize_title($atttitle);
	$parent_id = $attachment->post_parent;
	$parent_title = get_the_title( $parent_id );
	$parent_permalink = get_permalink( $parent_id );
	$detail1_th = wp_get_attachment_image_src(get_field('item_detail_1', $attachment->ID), 'thumbnail');
	$detail2_th = wp_get_attachment_image_src(get_field('item_detail_2', $attachment->ID), 'thumbnail');
	$detail3_th = wp_get_attachment_image_src(get_field('item_detail_3', $attachment->ID), 'thumbnail');
	$detail1_large = wp_get_attachment_image_src(get_field('item_detail_1', $attachment->ID), 'large');
	$detail2_large = wp_get_attachment_image_src(get_field('item_detail_2', $attachment->ID), 'large');
	$detail3_large = wp_get_attachment_image_src(get_field('item_detail_3', $attachment->ID), 'large');
	$detail1_bigsquare = wp_get_attachment_image_src(get_field('item_detail_1', $attachment->ID), 'bigsquare');
	$detail2_bigsquare = wp_get_attachment_image_src(get_field('item_detail_2', $attachment->ID), 'bigsquare');
	$detail3_bigsquare = wp_get_attachment_image_src(get_field('item_detail_3', $attachment->ID), 'bigsquare');
	$detail1_full = wp_get_attachment_image_src(get_field('item_detail_1', $attachment->ID), 'full');
	$detail2_full = wp_get_attachment_image_src(get_field('item_detail_2', $attachment->ID), 'full');
	$detail3_full = wp_get_attachment_image_src(get_field('item_detail_3', $attachment->ID), 'full');
	

        	echo '<div class="row align-center align-middle items full-height CoverImage bg-fixed alphalayer-light text-center" style="position:relative;background-image:url('.$attimg_full[0].');" id="'.$attslug.'-item-'.$attachment->ID.'" data-magellan-target="'.$attslug.'-item-'.$attachment->ID.'" data-interchange="['.$attimg_bigsquare[0].', small], ['.$attimg_medium[0].', medium], ['.$attimg_large[0].', large], ['.$attimg_full[0].', xlarge]">';
			   		echo '<div class="column small-12 medium-12 large-12 on-top">';
			   		echo '<h1 class="text-center">'.$atttitle.'</h1><div class="big text-center" style="max-width:700px;margin:0 auto;">';
			        echo apply_filters('the_title', $attachment->post_content);
			        echo '</div></div>';
					echo '<a class="img-link on-top column small-12 medium-6 large-3" href="'.$attimg_full[0].'"><img class="polaroid" src="'.$attimg_th[0].'" alt="'.$atttitle.'"/></a>';
					if ($detail1_th) {echo '<a class="img-link on-top column small-12 medium-6 large-3" href="'.$detail1_full[0].'"><img class="polaroid" src="'.$detail1_th[0].'" alt="'.$atttitle.'" /></a>'; }
					if ($detail2_th) {echo '<a class="img-link on-top column small-12 medium-6 large-3" href="'.$detail2_full[0].'"><img class="polaroid" src="'.$detail2_th[0].'" alt="'.$atttitle.'" /></a>'; }	
					if ($detail3_th) {echo '<a class="img-link on-top column small-12 medium-6 large-3" href="'.$detail3_full[0].'"><img class="polaroid" src="'.$detail3_th[0].'" alt="'.$atttitle.'" /></a>'; }

        echo '</div>';
    }
 
}

    }
endif;

if ( ! function_exists( 'seal_cover_src_thumbnail' ) ) :

    function seal_cover_src_thumbnail() {

        global $post;

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

                        $src_info = wp_get_attachment_image_src($sealcover->ID, 'thumbnail');
                        $src = $src_info[0];
                        return $src;
                }

            }
            
    }

endif;
if ( ! function_exists( 'seal_cover_src_medium' ) ) :

	function seal_cover_src_medium() {

		global $post;

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

	            		$src_info = wp_get_attachment_image_src($sealcover->ID, 'medium');
	            		$src = $src_info[0];
	            		return $src;
	            }

	        }
	        
	}

endif;
if ( ! function_exists( 'seal_cover_src_bigsquare' ) ) :

    function seal_cover_src_bigsquare() {

        global $post;

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

                        $src_info = wp_get_attachment_image_src($sealcover->ID, 'bigsquare');
                        $src = $src_info[0];
                        return $src;
                }

            }
            
    }

endif;

// medias specific outputs functions

// A random picture url from "items" type
if ( ! function_exists( 'pg_medias_random_item_selected_src' ) ) :
function pg_medias_random_item_selected_src() {
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

    $bg_src = wp_get_attachment_image_src($bg->ID,'full');
    $item_url = $bg_src[0];
    $item_parent_title = get_the_title($bg->post_parent);
    $item_title = apply_filters('the_title',$bg->post_title);

    return $item_url;
            }
             
        }
    
    }
endif;