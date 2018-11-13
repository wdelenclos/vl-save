<?php
        $cb_sidebar_id = $cb_buddypress_on = NULL;

        if ( function_exists('buddypress') && is_buddypress() == true ) {
            $cb_buddypress_on = true;
        }
        
         if ( is_category() ) {
             
            $cb_cat_id = get_query_var( 'cat' );
            $cb_cat = get_category($cb_cat_id);
            $cb_cat_name = sanitize_title( $cb_cat->category_nicename );
            $cb_sidebar_id =  $cb_cat_name . '-sidebar';

            if ( ( is_active_sidebar( $cb_sidebar_id ) == false ) && ( $cb_cat->parent != 0 ) ) {
                $cb_cat = get_category($cb_cat->parent);
                $cb_cat_name = sanitize_title( $cb_cat->category_nicename );
                $cb_sidebar_id =  $cb_cat_name . '-sidebar';

                 if ( ( is_active_sidebar( $cb_sidebar_id ) == false ) && ( $cb_cat->parent != 0 ) ) {
                    $cb_cat = get_category($cb_cat->parent);
                    $cb_cat_name = sanitize_title( $cb_cat->category_nicename );
                    $cb_sidebar_id =  $cb_cat_name . '-sidebar';
                }
            }

        } elseif ( is_page() ) {
            
            $cb_page_id = get_the_id();   
            $cb_sidebar_id = 'page-'. $cb_page_id .'-sidebar';

            if  ( class_exists('Woocommerce') && ( ( is_cart() == true ) || ( is_account_page() == true ) || ( is_order_received_page() == true ) || ( is_checkout() == true ) )  ) {
                $cb_sidebar_id =  'sidebar-woocommerce';
            }

            if  ( function_exists('bbpress') && ( is_bbpress() == true ) && ( $cb_buddypress_on == NULL ) ) {
           
                $cb_sidebar_id =  'sidebar-bbpress';

            } elseif  ( function_exists('buddypress') && ( is_buddypress() == true ) ) {
               
               $cb_sidebar_id = 'sidebar-buddypress';

            }
              
        } elseif ( class_exists('Woocommerce') &&  ( is_woocommerce() == true ) ) {

            $cb_sidebar_id =  'sidebar-woocommerce';
            
        } elseif  ( function_exists('bbpress') && ( is_bbpress() == true ) && ( $cb_buddypress_on == NULL ) ) {
           
           $cb_sidebar_id =  'sidebar-bbpress';

        } elseif  ( function_exists('buddypress') && ( is_buddypress() == true ) ) {
           
           $cb_sidebar_id = 'sidebar-buddypress';

        } elseif ( is_single() && ( is_attachment() == false ) ) {
        
            $cb_cat = get_the_category( $post->ID );

            if ( ! empty( $cb_cat ) ) {

                $cb_cat_name = sanitize_title( $cb_cat[0]->category_nicename );
                $cb_cat_check = $cb_cat[0];
                $cb_sidebar_id =  $cb_cat_name . '-sidebar';
                
                if ( ( is_active_sidebar( $cb_sidebar_id ) == false ) && ( $cb_cat_check->parent != 0 ) ) {
                    $cb_cat = get_category($cb_cat_check->parent);
                    $cb_cat_name = sanitize_title( $cb_cat->category_nicename );
                    $cb_sidebar_id =  $cb_cat_name . '-sidebar';
                }

            }

            $cb_sidebar_custom =  get_post_meta( $post->ID, 'cb_post_sidebar', true );

            if ( $cb_sidebar_custom == 'off' ) {
                $cb_sidebar_select =  get_post_meta( $post->ID, 'cb_post_custom_sidebar_type', true );
                if ( $cb_sidebar_select == 'cb_existing' ) {
                    $cb_sidebar_id_check = get_post_meta( $post->ID, 'cb_sidebar_select', true );
                    if ( $cb_sidebar_id_check != NULL ) {
                        $cb_sidebar_id = $cb_sidebar_id_check;
                    }
                } else {
                    $cb_sidebar_id = 'post-'. $post->ID .'-sidebar';
                }
            }

        }

        if ( ot_get_option('cb_sticky_sb', 'off') == 'on' ) {
            echo '<div class="cb-sticky-sidebar">';
        }
?>
<aside class="cb-sidebar clearfix" role="complementary">

<?php
		if ( is_active_sidebar( $cb_sidebar_id ) == true ) {
			     
	  		dynamic_sidebar( $cb_sidebar_id );
                
		} elseif ( is_active_sidebar( 'sidebar-global' ) ) {
			     
			dynamic_sidebar( 'sidebar-global' );
		} 
?>

</aside>

<?php if ( ot_get_option('cb_sticky_sb', 'off') == 'on' ) { echo '</div>'; } ?>