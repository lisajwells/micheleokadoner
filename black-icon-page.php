<?php
/**
 Template Name: Black Icon Page
 Template Post Type: page, cat_product

 */

get_header('nonav');
?>

<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">
				<?php
					while ( have_posts() ){
						the_post();							// Post Loop
						mfn_builder_print( get_the_ID() );	// Content Builder & WordPress Editor Content
					}
				?>
		</div>


	</div>
</div>

<?php get_footer('empty');

// Omit Closing PHP Tags
