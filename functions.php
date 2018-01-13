<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ) );

    wp_register_script( 'masonry-cdn', 'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js', null, null, true );
    wp_enqueue_script( 'masonry-cdn');

    wp_register_script( 'masonry-images-loaded', 'https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js', null, null, true );
    wp_enqueue_script( 'masonry-images-loaded');

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
      'labels' => array(
        'name' => __( 'Icon Gallery' ),
        'singular_name' => __( 'Product' ),

      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action( 'init', 'create_post_type' );


add_action('init', 'my_custom_init');
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
    'name' => _x( 'Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Categories' ),
    'all_items' => __( 'All Categories' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Category' ),
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'menu_name' => __( 'Categories' ),
  );

// Now register the taxonomy

  register_taxonomy('Categories',array('cat_product'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'Category' ),
  ));

}

add_theme_support( 'post-thumbnails', array( 'cat_product' ) );
add_image_size( 'home-large', 671, 671 );
add_image_size( 'home-medium', 446, 446 );

/** black page logo theme option **/

function upload_logo($wp_customize)
{
$wp_customize->add_section('white_logo',array(
'title' => __('Upload Logo For Black Template','betheme child'),
'priority' => 30
));
$wp_customize->add_setting('white_logo_upload',array(
'default' => '',
'transport' => 'refresh'
));
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'logo',
		array(
		'label'=>__("Upload a logo",'betheme child'),
		'section' =>  'white_logo',
		'settings' => 'white_logo_upload',
)
));
}
add_action('customize_register','upload_logo');
