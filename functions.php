<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ) );

	wp_register_script( 'masonry-cdn', 'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js', null, null, true );
	wp_enqueue_script( 'masonry-cdn' );

	wp_register_script( 'masonry-images-loaded', 'https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js', null, null, true );
	wp_enqueue_script( 'masonry-images-loaded' );

	if ( function_exists( '\IronBoundDesigns\MicheleOkaDoner\enqueue' ) ) {
		$show = false;

		if ( is_front_page() ) {
			$show = true;
		}

		if ( basename( get_page_template() ) === 'prductpage.php' || 'prductpage-masonry.php' ) {
			$show = true;
		}

		if ( $show ) {
			\IronBoundDesigns\MicheleOkaDoner\enqueue();
		}
	}

}

/** Load jQuery and jQuery-ui script just before closing Body tag */
// add_action('genesis_after_footer', 'crunchify_script_add_body');
// function crunchify_script_add_body() {

//       wp_register_script( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js', false, null);
//       wp_enqueue_script( 'jquery-ui');
// }


function create_post_type() {
	register_post_type( 'cat_product',
		array(
			'labels'       => array(
				'name'          => __( 'Icon Gallery' ),
				'singular_name' => __( 'Icon Gallery' ),

			),
			'public'       => true,
			'has_archive'  => false,
			'show_in_rest' => true,
			'rest_base'    => 'icon-gallery'
		)
	);
}

add_action( 'init', 'create_post_type' );


add_action( 'init', 'my_custom_init' );
function my_custom_init() {
	// 'cat_product' is my post type
	add_post_type_support( 'cat_product', 'thumbnail' );
}


add_action( 'init', 'create_products_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts

function create_products_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Categories' ),
		'all_items'         => __( 'All Categories' ),
		'parent_item'       => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Category:' ),
		'edit_item'         => __( 'Edit Category' ),
		'update_item'       => __( 'Update Category' ),
		'add_new_item'      => __( 'Add New Category' ),
		'new_item_name'     => __( 'New Category Name' ),
		'menu_name'         => __( 'Categories' ),
	);

// Now register the taxonomy

	register_taxonomy( 'Categories', array( 'cat_product' ), array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'Category' ),
	) );

}

add_theme_support( 'post-thumbnails', array( 'cat_product' ) );
add_image_size( 'home-large', 671, 671 );
add_image_size( 'home-medium', 446, 446 );
add_image_size( 'hard-crop-thumbnail', 150, 150, true );

/**
 * Add taxonomy filtering to custom post types
 *
 * Original example for one post type, https://generatewp.com/filtering-posts-by-taxonomies-in-the-dashboard/
 *
 */
function michelle_oka_doner_filter_cpt_by_taxonomies( $post_type, $which ) {
    // Affected post types
    $post_types = array(
        'cat_product'
    );
    // Apply this only on a specific post type
    if ( !in_array( $post_type, $post_types ) ) {
        return;
    }
    // Loop cpts
    foreach ( $post_types as $type ) {
        // Exceute only on matching type
        if ( $post_type == $type ) {
            // Get associated taxonomies names
            $taxonomies = get_object_taxonomies( $type, 'object' );
            // Loop taxonomies
            foreach ( $taxonomies as $taxonomy  ) {
                // Retrieve taxonomy terms
                $terms = get_terms( $taxonomy->name );
                // Display filter HTML
                echo "<select name='{$taxonomy->name}' id='{$taxonomy->name}' class='postform'>";
                echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy->label ) . '</option>';
                foreach ( $terms as $term ) {
                    printf(
                        '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                        $term->slug,
                        ( ( isset( $_GET[$taxonomy->name] ) && ( $_GET[$taxonomy->name] == $term->slug ) ) ? ' selected="selected"' : '' ),
                        $term->name,
                        $term->count
                    );
                }
                echo '</select>';
            }
        }
    }
}
add_action( 'restrict_manage_posts', 'michelle_oka_doner_filter_cpt_by_taxonomies' , 10, 2);

/** black page logo theme option **/

function upload_logo( $wp_customize ) {
	$wp_customize->add_section( 'white_logo', array(
		'title'    => __( 'Upload Logo For Black Template', 'betheme child' ),
		'priority' => 30
	) );
	$wp_customize->add_setting( 'white_logo_upload', array(
		'default'   => '',
		'transport' => 'refresh'
	) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo',
			array(
				'label'    => __( "Upload a logo", 'betheme child' ),
				'section'  => 'white_logo',
				'settings' => 'white_logo_upload',
			)
		) );
}

add_action( 'customize_register', 'upload_logo' );

function michelle_oka_doner_portfolio_query_all() {
	$args = [
		'post_type' => 'cat_product',
		'posts_per_page' => -1,
		'tax_query' => [
			[
				'taxonomy' => 'Categories',
				'terms'    => array('supporting', 'history', 'talkwalk'),
				'field'    => 'slug',
				'operator' => 'NOT IN',
			]
		]

	];

	return new WP_Query( $args );
}

function michelle_oka_doner_portfolio_query_categorized( $slug ) {
	$args     = [
		'post_type'      => 'cat_product',
		'posts_per_page' => - 1,
		'tax_query'      => [
			[
				'taxonomy' => 'Categories',
				'field'    => 'slug',
				'terms'    => $slug,
			],
			[
				'taxonomy' => 'Categories',
				'terms'    => array('supporting'),
				'field'    => 'slug',
				'operator' => 'NOT IN',
			]
		],
	];

	return new WP_Query( $args );
}
/* use the custom url where it applies  - custom field currently only applies to books & walks/talks arj */
function michelle_oka_doner_custom_url($url, $post) {

	if ( 'cat_product' == get_post_type( $post ) ) {
		$newurl = CFS()->get( 'link_url', $post->ID );
		if (isset($newurl) && '' != $newurl ) 
			$url = $newurl;
		 }
	return $url;
}
add_filter( 'post_type_link', 'michelle_oka_doner_custom_url', 10, 2 );

/**
 * Display all image sizes in dashboard other than the default, thumbnail, medium and large
 *
 */
//add_action( 'admin_init', 'theme_additional_images' );

//function theme_additional_images() {
//	global $_wp_additional_image_sizes;
//	$get_intermediate_image_sizes = get_intermediate_image_sizes();
//
//	echo '<pre>' . print_r($_wp_additional_image_sizes) . '</pre>';
//}

/**
 * Remove unused image sizes from parent theme
 *
 */
add_action('init', 'mod_remove_unused_image_sizes');

function mod_remove_unused_image_sizes() {
	remove_image_size('50x50');
	remove_image_size('clients-slider');
	remove_image_size('slider-content');
	remove_image_size('testimonials');
	remove_image_size('blog-navi');
	remove_image_size('portfolio-mf');
	remove_image_size('portfolio-mf-w');
	remove_image_size('portfolio-mf-t');
	remove_image_size('portfolio-list');
	remove_image_size('blog-portfolio');
}

