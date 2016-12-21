<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>

		</section>
		<div id="footer-container" class="pattern1">
			<footer id="footer" class="on-top">
				<?php do_action( 'foundationpress_before_footer' ); ?>

<div class="row align-left align-top">

<div class="small-12 medium-12 large-4 column">

	          <ul class="no-bullet big monospace">
              <li><a href="https://www.facebook.com/pages/Parisian-Gentleman-the-french-voice-of-sartorial-excellence/116830841661701" rel="me"><i class="fa fa-facebook-square"></i>&nbsp;Facebook</a></li>
              <li><a href="https://twitter.com/Parisian_Gent" rel="me"><i class="fa fa-twitter-square"></i>&nbsp;Twitter</a></li>
              <li><a href="https://www.youtube.com/channel/UC4JvjWZ80HF-X6rqJULo-EQ" rel="me"><i class="fa fa-youtube-square"></i>&nbsp;YouTube</a></li>
              <li><a href="http://parisiangentleman.tumblr.com/" rel="me"><i class="fa fa-tumblr-square"></i>&nbsp;Tumblr</a></li>
              <li><a href="https://instagram.com/parisian_gentleman/" rel="me"><i class="fa fa-instagram"></i>&nbsp;Instagram</a></li>
            </ul>
</div>

<div class="small-12 medium-12 large-6 column">
<hr />
<h3><?php echo __('Recently on', 'FoundationPress'); ?> Parisian Gentleman</h3>

<?php 
if(ICL_LANGUAGE_CODE=='fr'){$rss = fetch_feed('http://parisiangentleman.fr/feed');}
else $rss = fetch_feed('http://parisiangentleman.co.uk/feed');


if (!is_wp_error( $rss ) ) : 
	
    $maxitems = $rss->get_item_quantity(3); 
    $rss_items = $rss->get_items(0, $maxitems); 
endif;
?>
	
 <?php
function shorten($string, $length)
{
    $suffix = '&hellip;';

$short_desc = trim(str_replace(array("/r", "/n", "/t"), ' ', strip_tags($string)));
    $desc = trim(substr($short_desc, 0, $length));
    $lastchar = substr($desc, -1, 1);
    	if ($lastchar == '.' || $lastchar == '!' || $lastchar == '?') $suffix='';
					$desc .= $suffix;
 		return $desc;
}
?>

    <?php 
    	if ($maxitems == 0) echo '<p>Nope!</p>';
    	else 
    	foreach ( $rss_items as $item ) : ?>
  <hr />  
<span><?php echo $item->get_date('d/m/Y'); ?></span><br />

<h6 class="monospace"><a href='<?php echo esc_url( $item->get_permalink() ); ?>' title='<?php echo esc_html( $item->get_title() ); ?>'><?php echo esc_html( $item->get_title() ); ?></a></h6>

	<p class="monospace"><?php echo shorten($item-> get_description(),'300');?></p>
    <?php endforeach; ?>


</div>


</div>
				<?php dynamic_sidebar( 'footer-widgets' ); ?>
				<?php do_action( 'foundationpress_after_footer' ); ?>

			</footer>
		</div>

		<?php do_action( 'foundationpress_layout_end' ); ?>

<?php if ( get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>
		</div><!-- Close off-canvas wrapper inner -->
	</div><!-- Close off-canvas wrapper -->
</div><!-- Close off-canvas content wrapper -->
<?php endif; ?>


<?php wp_footer(); ?>
<?php do_action( 'foundationpress_before_closing_body' ); ?>
</body>
</html>
