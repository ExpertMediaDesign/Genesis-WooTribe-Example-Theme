<?php
/**
 * Genesis Child Example with WooCommerce & Tribe Events.
 *
 * Built on top of the Genesis Framework theme.
 * Anonymized the function prefixes & named fields, so test well before using. 
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( genesis_get_theme_handle(), get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

// Registers the responsive menus.
if ( function_exists( 'genesis_register_responsive_menus' ) ) {
	genesis_register_responsive_menus( genesis_get_config( 'responsive-menus' ) );
}

add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles() {

	$appearance = genesis_get_config( 'appearance' );

	wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- see https://core.trac.wordpress.org/ticket/49742
		genesis_get_theme_handle() . '-fonts',
		$appearance['fonts-url'],
		[],
		null
	);

	wp_enqueue_style( 'dashicons' );

	if ( genesis_is_amp() ) {
		wp_enqueue_style(
			genesis_get_theme_handle() . '-amp',
			get_stylesheet_directory_uri() . '/lib/amp/amp.css',
			[ genesis_get_theme_handle() ],
			genesis_get_theme_version()
		);
	}

  // ionicons
  wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css' );

}

add_filter( 'body_class', 'genesis_sample_body_classes' );
/**
 * Add additional classes to the body element.
 *
 * @since 3.4.1
 *
 * @param array $classes Classes array.
 * @return array $classes Updated class array.
 */
function genesis_sample_body_classes( $classes ) {

	if ( ! genesis_is_amp() ) {
		// Add 'no-js' class to the body class values.
		$classes[] = 'no-js';
	}
	return $classes;
}

add_action( 'genesis_before', 'genesis_sample_js_nojs_script', 1 );
/**
 * Echo the script that changes 'no-js' class to 'js'.
 *
 * @since 3.4.1
 */
function genesis_sample_js_nojs_script() {

	if ( genesis_is_amp() ) {
		return;
	}

	?>
	<script>
	//<![CDATA[
	(function(){
		var c = document.body.classList;
		c.remove( 'no-js' );
		c.add( 'js' );
	})();
	//]]>
	</script>
	<?php
}

add_filter( 'wp_resource_hints', 'genesis_sample_resource_hints', 10, 2 );
/**
 * Add preconnect for Google Fonts.
 *
 * @since 3.4.1
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function genesis_sample_resource_hints( $urls, $relation_type ) {

	if ( wp_style_is( genesis_get_theme_handle() . '-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = [
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		];
	}

	return $urls;
}

add_action( 'after_setup_theme', 'genesis_sample_theme_support', 9 );
/**
 * Add desired theme supports.
 *
 * See config file at `config/theme-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_theme_support() {

	$theme_supports = genesis_get_config( 'theme-supports' );

	foreach ( $theme_supports as $feature => $args ) {
		add_theme_support( $feature, $args );
	}

}

add_action( 'after_setup_theme', 'genesis_sample_post_type_support', 9 );
/**
 * Add desired post type supports.
 *
 * See config file at `config/post-type-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_post_type_support() {

	$post_type_supports = genesis_get_config( 'post-type-supports' );

	foreach ( $post_type_supports as $post_type => $args ) {
		add_post_type_support( $post_type, $args );
	}

}

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );
add_image_size( 'genesis-singular-images', 702, 526, true );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

// Remove Page Titles
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );









/*
 *
 * Expert Media Customizations 
 *
 */



/*
 * Grab Event info from Modern Tribe for Contact Form 7 & Dynamic Text Extension
 *
 * Dynamic Text Exntension allows shortcode values, so we can grab anything from the current page.
 * This lets it save to cf7db and be processed with other info in the emails.
 */ 
add_shortcode ( 'emd_eventtime', 'emd_custom_select_event_data' );
function emd_custom_select_event_data( $tag ) {

	$event_id = get_the_ID();
	$event = get_post( $event_id );
	return tribe_get_start_date( $event, true, 'n/j/Y &#64; g:ia' );

}


/* 
 * Adjust the checkout fields based on WooCommerce's documentation: 
 * https://woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
 */
add_filter( 'woocommerce_checkout_fields' , 'emd_custom_checkout_fields' );
function emd_custom_checkout_fields( $fields ) {

  // unset($fields['billing']['billing_company']);
  // unset($fields['billing']['billing_address_1']);
  // unset($fields['billing']['billing_address_2']);
  // unset($fields['billing']['billing_city']);
  // unset($fields['billing']['billing_postcode']);
  // unset($fields['billing']['billing_country']);
  // unset($fields['billing']['billing_state']);

  $fields['order']['order_comments']['placeholder'] = '';

  return $fields;

}
// Back to cart button after order summary
add_action( 'woocommerce_review_order_before_payment', 'emd_return_to_cart_notice_button' );
function emd_return_to_cart_notice_button(){

  $button_text = __('Adjust Order Items', 'woocommerce');
  $cart_link = WC()->cart->get_cart_url();

  echo '<a href="' . $cart_link . '" class="button wc-forward">' . $button_text . '</a><br><br>';

}





/**
 * Filter menu items, appending our Cart icon if there's items in the cart
 *
 * @param string   $menu HTML string of list items.
 * @param stdClass $args Menu arguments.
 *
 * @return string Amended HTML string of list items.
 */
add_filter( 'wp_nav_menu_items', 'emd_genesis_theme_menu_extras', 10, 2 );
function emd_genesis_theme_menu_extras( $menu, $args ) {
 
  //* Change 'primary' to 'secondary' to add extras to the secondary navigation menu
  if ( 'primary' !== $args->theme_location )
    return $menu;

  // Check if WooCommerce is active
  if ( class_exists( 'WooCommerce' ) ) {
    // Add the Shop icon here
    $menu .= '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-78"><a href="/shop/" itemprop="url"><span class="dashicons dashicons-store"></span></a></li>';

    // Check if there's a cart & if it's not empty
    if(WC()->cart && !WC()->cart->is_empty()){
      // the cart has products, add to menu
      $menu .= '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-79"><a href="/cart/" itemprop="url"><span class="dashicons dashicons-cart"></span></a></li>';
    }
  }
 
  return $menu;
 
}

/**
 * Add a custom product data tab for WooCommerce
 */
add_filter( 'woocommerce_product_tabs', 'emd_woo_new_product_tab' );
function emd_woo_new_product_tab( $tabs ) {
  
  // Adds the new tab
  $tabs['emd_includes'] = array(
    'title'   => __( 'More Info', 'woocommerce' ),
    'priority'  => 50,
    'callback'  => 'emd_woo_new_product_tab_content'
  );

  return $tabs;

}
// New Tab content
function emd_woo_new_product_tab_content() {

  // Bullet point out the Product Includes Custom Field
  $includes = get_post_meta(get_the_ID(), '_expertmedia_includes_textarea', true);
  if ($includes != '') {
    $includes_lines = preg_split('/\n|\r\n?/', $includes);
    echo '<h2>This Product Includes:</h2>';
    echo '<ul>';
    foreach($includes_lines as $result) {
      echo '<li>' . $result . '</li>';
    }
    echo '</ul>';
  }

  // Bullet point out the Product Includes Custom Field
  $notincludes = get_post_meta(get_the_ID(), '_expertmedia_not_includes_textarea', true);
  if ($notincludes != '') {
    $notincludes_lines = preg_split('/\n|\r\n?/', $notincludes);

    // echo $notincludes;
    echo '<h2>This Product Does Not Include:</h2>';
    echo '<ul>';
    foreach($notincludes_lines as $result) {
      echo '<li>' . $result . '</li>';
    }
    echo '</ul>';
  }

}

// Displaying WooCommerce Product Custom Fields in Admin
// add_action( 'woocommerce_product_options_general_product_data', 'emd_woocommerce_product_custom_fields' ); 
add_action( 'woocommerce_product_options_inventory_product_data', 'emd_woocommerce_product_custom_fields' ); 
function emd_woocommerce_product_custom_fields () {
  global $woocommerce, $post;
  echo '<div class=" product_custom_field ">';
  // Custom Product Textarea Field
  woocommerce_wp_textarea_input(
      array(
          'id' => '_expertmedia_includes_textarea',
          'placeholder' => 'This will be a list of bullet points. Use Enter for a new bullet point.',
          'label' => __('Product Includes', 'woocommerce'),
          'desc_tip'    => 'true'
      )
  );
  // Custom Product Textarea Field
  woocommerce_wp_textarea_input(
      array(
          'id' => '_expertmedia_not_includes_textarea',
          'placeholder' => 'This will be a list of bullet points. Use Enter for a new bullet point.',
          'label' => __('Product Does Not Include', 'woocommerce'),
          'desc_tip'    => 'true'
      )
  );
  echo '</div>';
}

// Saving WooCommerce Product Custom Fields 
add_action( 'woocommerce_process_product_meta', 'emd_woocommerce_product_custom_fields_save' );
function emd_woocommerce_product_custom_fields_save($post_id) {
  // Custom Product Textarea Field
  $woocommerce_custom_procut_textarea = $_POST['_expertmedia_includes_textarea'];
  if (!empty($woocommerce_custom_procut_textarea)) {
    update_post_meta($post_id, '_expertmedia_includes_textarea', esc_html($woocommerce_custom_procut_textarea));
  }
  $woocommerce_not_includes_textarea = $_POST['_expertmedia_not_includes_textarea'];
  if (!empty($woocommerce_not_includes_textarea)) {
    update_post_meta($post_id, '_expertmedia_not_includes_textarea', esc_html($woocommerce_not_includes_textarea));
  }
}


/**
 * Disables the default product loop from WooCommerce
 */
add_action( 'pre_get_posts', 'emd_remove_products_from_shop_page' );
function emd_remove_products_from_shop_page( $q ) {
  if ( ! $q->is_main_query() ) return;
  if ( ! $q->is_post_type_archive() ) return;
  if ( ! is_admin() && is_shop() ) {
    $q->set( 'post__in', array(0) );
  }
  remove_action( 'pre_get_posts', 'emd_remove_products_from_shop_page' );
}

/**
 * Removes the default "No Products Found Match Your Selection". 
 */
remove_action( 'woocommerce_no_products_found', 'wc_no_products_found' );


// For cart page: replacing proceed to checkout button
add_action( 'woocommerce_proceed_to_checkout', 'change_proceed_to_checkout', 1 );
function change_proceed_to_checkout() {
  remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
  add_action( 'woocommerce_proceed_to_checkout', 'custom_button_proceed_to_custom_page', 20 );
}

// For mini Cart widget: Replace checkout button
add_action( 'woocommerce_widget_shopping_cart_buttons', 'change_widget_shopping_cart_button_view_cart', 1 );
function change_widget_shopping_cart_button_view_cart() {
  remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
  add_action( 'woocommerce_widget_shopping_cart_buttons', 'custom_button_to_custom_page', 20 );
}

// Cart page: Displays the replacement custom button linked to your custom page
function custom_button_proceed_to_custom_page() {
  $button_name = esc_html__( 'Proceed to Checkout', 'woocommerce' ); // <== button Name
  $button_link = get_permalink( 733 ); // <== Set here the page ID or use home_url() function
  ?>
  <a href="<?php echo $button_link;?>" class="checkout-button button alt wc-forward">
      <?php echo $button_name; ?>
  </a>
  <?php
}

// Mini cart:  Displays the replacement custom button linked to your custom page
function custom_button_to_custom_page() {
  $button_name = esc_html__( 'Proceed to Checkout', 'woocommerce' ); // <== button Name
  $button_link = get_permalink( 733 ); // <== Set here the page ID or use home_url() function
  ?>
  <a href="<?php echo $button_link;?>" class="checkout button wc-forward">
      <?php echo $button_name; ?>
  </a>
  <?php
}

add_action('woocommerce_add_to_cart_redirect', 'emd_change_url_from_cart_to_checkout');
function emd_change_url_from_cart_to_checkout( $url){
  if( is_shop() ){
		return wc_get_cart_url();
  }elseif( is_page( 'dont-forget-these' ) ){
    return wc_get_checkout_url();
  }
}