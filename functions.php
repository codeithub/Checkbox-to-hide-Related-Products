/**
 * @snippet       Checkbox to hide Related Products
 * @author        Codeithub
 */
 

add_action( 'woocommerce_product_options_general_product_data', 'codeithub_add_related_checkbox_products' );        
  
function codeithub_add_related_checkbox_products() {           
woocommerce_wp_checkbox( array( 
   'id' => 'hide_related', 
   'class' => '', 
   'label' => 'Hide Related Products'
   ) 
);      
}
  

// 2. Save checkbox into custom field
  
add_action( 'save_post_product', 'codeithub_save_related_checkbox_products' );
  
function codeithub_save_related_checkbox_products( $product_id ) {
   global $pagenow, $typenow;
   if ( 'post.php' !== $pagenow || 'product' !== $typenow ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( isset( $_POST['hide_related'] ) ) {
      update_post_meta( $product_id, 'hide_related', $_POST['hide_related'] );
    } else delete_post_meta( $product_id, 'hide_related' );
}
  

// 3. Hide related products @ single product page
  
add_action( 'woocommerce_after_single_product_summary', 'codeithub_hide_related_checkbox_products', 1 );
  
function codeithub_hide_related_checkbox_products() {
    global $product;
    if ( ! empty ( get_post_meta( $product->get_id(), 'hide_related', true ) ) ) {
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    }
}
