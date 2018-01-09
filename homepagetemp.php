<?php
/**
 * Template Name: Homepage Template
 *
 * @package Betheme
 * @author Muffin Group
 */

get_header();
?>

<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">

			<div class="entry-content" itemprop="mainContentOfPage">

				<?php
					while ( have_posts() ){
						the_post();							// Post Loop
						mfn_builder_print( get_the_ID() );	// Content Builder & WordPress Editor Content
						/*global $post;
$post_slug=$post->post_name;*/
// For display the data we need to echo it
					}
				?>

				<div class="section section-page-footer">
					<div class="section_wrapper clearfix">

						<div class="column one page-pager">
							<?php
								// List of pages
								wp_link_pages(array(
									'before'			=> '<div class="pager-single">',
									'after'				=> '</div>',
									'link_before'		=> '<span>',
									'link_after'		=> '</span>',
									'next_or_number'	=> 'number'
								));
							?>
						</div>

					</div>
				</div><!-- end section-page-footer -->


				<?php
				$args = array(
					'post_type' => 'cat_product',
					'posts_per_page' => -1

				);
				$products = new WP_Query( $args );

				?>
				<div class="vc_row home_container product-container grid">
				<div class="grid-sizer"></div>
				    <?php

				    while( $products->have_posts() ) :
						global $post;
						$post_slug=$post->post_name;
						// For display the data we need to echo it

				        $products->the_post();
						$values = CFS()->get( 'SelectGeneration' );
						$label='';
						foreach( $values as $key => $label ) {
							$label =$label;
						}
				        ?>
				        <div class="home_img_box grid-item <?php echo $label; ?>">
				        	<a href="<?php echo get_permalink(); ?>" class="box-link">
				        		<img src="<?php echo get_the_post_thumbnail_url() ?>">
				        	</a>
				        	<div class="home_below_title_gen"><?php echo get_the_title(); ?></div>
				        </div>
				        <?php
				      endwhile;
				      wp_reset_postdata();
				    ?>
				</div><!-- end product-container -->

			</div><!-- end entry-content -->

			<?php if( mfn_opts_get('page-comments') ): ?>
				<div class="section section-page-comments">
					<div class="section_wrapper clearfix">

						<div class="column one comments">
							<?php comments_template( '', true ); ?>
						</div>

					</div>
				</div>
			<?php endif; ?>

		</div><!-- end sections_group -->

		<!-- .four-columns - sidebar -->
		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags
