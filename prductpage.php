<?php
/**
 * Template Name: ProductPage Template
 *
 * @package Betheme
 * @author  Muffin Group
 */

get_header();
?>

    <!-- #Content -->
    <div id="Content">
        <div class="content_wrapper clearfix">
            <!-- .four-columns - sidebar -->
			<?php get_sidebar(); ?>

            <!-- .sections_group -->
            <div class="sections_group">

                <div class="entry-content" itemprop="mainContentOfPage">

					<?php
					while ( have_posts() ) {
						the_post();                            // Post Loop
						mfn_builder_print( get_the_ID() );    // Content Builder & WordPress Editor Content
						global $post;
						$post_slug = $post->post_name;
						// For display the data we need to echo it
					}
					?>

                    <div class="section section-page-footer">
                        <div class="section_wrapper clearfix">

                            <div class="column one page-pager">
								<?php
								// List of pages
								wp_link_pages( array(
									'before'         => '<div class="pager-single">',
									'after'          => '</div>',
									'link_before'    => '<span>',
									'link_after'     => '</span>',
									'next_or_number' => 'number'
								) );
								?>
                            </div>

                        </div>
                    </div>


					<?php $products = michelle_oka_doner_portfolio_query_categorized( $post_slug ); ?>
                    <div class="vc_row product-container">

						<?php

						while ( $products->have_posts() ) :
							global $post;
							$post_slug = $post->post_name;
							// For display the data we need to echo it

							$products->the_post();
							$values = CFS()->get( 'SelectGeneration' );
							$label  = '';
							foreach ( $values as $key => $label ) {
								$label = $label;
							}
							?>
                            <div class="image-box vc_col-sm-3 <?php echo $label; ?>"><a
                                        href="<?php echo get_permalink(); ?>" class="box-link"><img
                                            src="<?php echo get_the_post_thumbnail_url() ?>"></a>
                                <div class="below_title_gen"><?php echo get_the_title(); ?></div>
                            </div>
						<?php
						endwhile;
						wp_reset_postdata();
						?>
                    </div>

                </div>

				<?php if ( mfn_opts_get( 'page-comments' ) ): ?>
                    <div class="section section-page-comments">
                        <div class="section_wrapper clearfix">

                            <div class="column one comments">
								<?php comments_template( '', true ); ?>
                            </div>

                        </div>
                    </div>
				<?php endif; ?>

            </div>

            <!-- .four-columns - sidebar -->
			<?php get_sidebar(); ?>

        </div>
    </div>

<?php get_footer();

// Omit Closing PHP Tags