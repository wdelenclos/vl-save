<?php  /* 125 Ads - Valenti Widget */

if ( !class_exists ( 'cb_wp_125_ads_widget' ) ) {
 class cb_wp_125_ads_widget extends WP_Widget {

        function __construct() {
            $widget_ops = array('classname' => 'cb-small-squares-widget clearfix', 'description' =>  "Show up to ten 125px x 125px ads" );
            parent::__construct('ads-125', 'Valenti 125px x 125px Ads', $widget_ops);
            $this->alt_option_name = 'widget_125_ads';

            add_action( 'save_post', array($this, 'flush_widget_cache') );
            add_action( 'deleted_post', array($this, 'flush_widget_cache') );
            add_action( 'switch_theme', array($this, 'flush_widget_cache') );
        }

        function widget($args, $instance) {
            $cache = wp_cache_get('widget_125_ads', 'widget');

            if ( !is_array($cache) )
                $cache = array();

            if ( ! isset( $args['widget_id'] ) )
                $args['widget_id'] = $this->id;

            if ( isset( $cache[ $args['widget_id'] ] ) ) {
                echo $cache[ $args['widget_id'] ];
                return;
            }
            ob_start();
            extract($args);
            $title = empty($instance['title']) ? '' : $instance['title'];
            $ad_url_1 = empty($instance['ad_url_1']) ? '' : $instance['ad_url_1'];
            $ad_url_2 = empty($instance['ad_url_2']) ? '' : $instance['ad_url_2'];
            $ad_url_3 = empty($instance['ad_url_3']) ? '' : $instance['ad_url_3'];
            $ad_url_4 = empty($instance['ad_url_4']) ? '' : $instance['ad_url_4'];
            $ad_url_5 = empty($instance['ad_url_5']) ? '' : $instance['ad_url_5'];
            $ad_url_6 = empty($instance['ad_url_6']) ? '' : $instance['ad_url_6'];
            $ad_url_7 = empty($instance['ad_url_7']) ? '' : $instance['ad_url_7'];
            $ad_url_8 = empty($instance['ad_url_8']) ? '' : $instance['ad_url_8'];
            $ad_url_9 = empty($instance['ad_url_9']) ? '' : $instance['ad_url_9'];
            $ad_url_10 =  empty($instance['ad_url_10']) ? '' : $instance['ad_url_10'];

            echo $before_widget;

            if ( $title ) echo $before_title . esc_html( $title ) . $after_title;

            if ( is_home() || is_category() || is_tag() || is_singular() || is_archive() ) { ?>

                <ul class="clearfix cb-small-squares-widget"> 

                <?php if ( $ad_url_1 != NULL ) { ?> <li> <?php echo wpautop( $ad_url_1 ) ?></li> <?php } ?>
                <?php if ( $ad_url_2 != NULL ) { ?> <li> <?php echo wpautop( $ad_url_2 ) ?></li> <?php } ?>
                <?php if ( $ad_url_3 != NULL ) { ?> <li> <?php echo wpautop( $ad_url_3 ) ?></li> <?php } ?>
                <?php if ( $ad_url_4 != NULL ) { ?> <li> <?php echo wpautop( $ad_url_4 ) ?></li> <?php } ?>
                <?php if ( $ad_url_5 != NULL ) { ?> <li> <?php echo wpautop( $ad_url_5 ) ?></li> <?php } ?>
                <?php if ( $ad_url_6 != NULL ) { ?> <li> <?php echo wpautop( $ad_url_6 ) ?></li> <?php } ?>
                <?php if ( $ad_url_7 != NULL ) { ?> <li> <?php echo wpautop( $ad_url_7 ) ?></li> <?php } ?>
                <?php if ( $ad_url_8 != NULL ) { ?> <li> <?php echo wpautop( $ad_url_8 ) ?></li> <?php } ?>
                <?php if ( $ad_url_9 != NULL ) { ?> <li> <?php echo wpautop( $ad_url_9 ) ?></li> <?php } ?>
                <?php if ( $ad_url_10 != NULL ) { ?>  <li> <?php echo wpautop( $ad_url_10 ) ?></li> <?php } ?>
                
                </ul>
            <?php
            }

            echo $after_widget;

            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set('widget_125_ads', $cache, 'widget');
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['ad_url_1'] = ($new_instance['ad_url_1']);
            $instance['ad_url_2'] = ($new_instance['ad_url_2']);
            $instance['ad_url_3'] = ($new_instance['ad_url_3']);
            $instance['ad_url_4'] = ($new_instance['ad_url_4']);
            $instance['ad_url_5'] = ($new_instance['ad_url_5']);
            $instance['ad_url_6'] = ($new_instance['ad_url_6']);
            $instance['ad_url_7'] = ($new_instance['ad_url_7']);
            $instance['ad_url_8'] = ($new_instance['ad_url_8']);
            $instance['ad_url_9'] = ($new_instance['ad_url_9']);
            $instance['ad_url_10'] = ($new_instance['ad_url_10']);

            $this->flush_widget_cache();

            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset($alloptions['widget_125_ads']) )
                delete_option('widget_125_ads');

            return $instance;
        }

        function flush_widget_cache() {
            wp_cache_delete('widget_125_ads', 'widget');
        }

        function form( $instance ) {
            $title     = isset( $instance['title'] ) ? ( $instance['title'] ) : '';
            $ad_url_1    = isset( $instance['ad_url_1'] ) ? ( $instance['ad_url_1'] ) : '';
            $ad_url_2    = isset( $instance['ad_url_2'] ) ? ( $instance['ad_url_2'] ) : '';
            $ad_url_3    = isset( $instance['ad_url_3'] ) ? ( $instance['ad_url_3'] ) : '';
            $ad_url_4    = isset( $instance['ad_url_4'] ) ? ( $instance['ad_url_4'] ) : '';
            $ad_url_5    = isset( $instance['ad_url_5'] ) ? ( $instance['ad_url_5'] ) : '';
            $ad_url_6    = isset( $instance['ad_url_6'] ) ? ( $instance['ad_url_6'] ) : '';
            $ad_url_7    = isset( $instance['ad_url_7'] ) ? ( $instance['ad_url_7'] ) : '';
            $ad_url_8    = isset( $instance['ad_url_8'] ) ? ( $instance['ad_url_8'] ) : '';
            $ad_url_9    = isset( $instance['ad_url_9'] ) ? ( $instance['ad_url_9'] ) : '';
            $ad_url_10    = isset( $instance['ad_url_10'] ) ? ( $instance['ad_url_10'] ) : '';

    ?>
            <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>


            <p><label for="<?php echo esc_attr( $this->get_field_id( 'ad_url_1' ) ); ?>">Ad 1 Code</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_url_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_url_1' ) ); ?>" type="text" value="<?php echo esc_attr( $ad_url_1 ); ?>" size="3" /></p>

            <p><label for="<?php echo esc_attr( $this->get_field_id( 'ad_url_2' ) ); ?>">Ad 2 Code</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_url_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_url_2' ) ); ?>" type="text" value="<?php echo esc_attr( $ad_url_2 ); ?>" size="3" /></p>

            <p><label for="<?php echo esc_attr( $this->get_field_id( 'ad_url_3' ) ); ?>">Ad 3 Code</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_url_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_url_3' ) ); ?>" type="text" value="<?php echo esc_attr( $ad_url_3 ); ?>" size="3" /></p>

            <p><label for="<?php echo esc_attr( $this->get_field_id( 'ad_url_4' ) ); ?>">Ad 4 Code</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_url_4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_url_4' ) ); ?>" type="text" value="<?php echo esc_attr( $ad_url_4 ); ?>" size="3" /></p>

            <p><label for="<?php echo esc_attr( $this->get_field_id( 'ad_url_5' ) ); ?>">Ad 5 Code</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_url_5' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_url_5' ) ); ?>" type="text" value="<?php echo esc_attr( $ad_url_5 ); ?>" size="3" /></p>

            <p><label for="<?php echo esc_attr( $this->get_field_id( 'ad_url_6' ) ); ?>">Ad 6 Code</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_url_6' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_url_6' ) ); ?>" type="text" value="<?php echo esc_attr( $ad_url_6 ); ?>" size="3" /></p>

            <p><label for="<?php echo esc_attr( $this->get_field_id( 'ad_url_7' ) ); ?>">Ad 7 Code</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_url_7' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_url_7' ) ); ?>" type="text" value="<?php echo esc_attr( $ad_url_7 ); ?>" size="3" /></p>

            <p><label for="<?php echo esc_attr( $this->get_field_id( 'ad_url_8' ) ); ?>">Ad 8 Code</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_url_8' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_url_8' ) ); ?>" type="text" value="<?php echo esc_attr( $ad_url_8 ); ?>" size="3" /></p>

            <p><label for="<?php echo esc_attr( $this->get_field_id( 'ad_url_9' ) ); ?>">Ad 9 Code</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_url_9' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_url_9' ) ); ?>" type="text" value="<?php echo esc_attr( $ad_url_9 ); ?>" size="3" /></p>

            <p><label for="<?php echo esc_attr( $this->get_field_id( 'ad_url_10' ) ); ?>">Ad 10 Code</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_url_10' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_url_10' ) ); ?>" type="text" value="<?php echo esc_attr( $ad_url_10 ); ?>" size="3" /></p>

    <?php
        }
    }
}
if ( ! function_exists( 'cb_125_ads_loader' ) ) {

    function cb_125_ads_loader () {
        register_widget( 'cb_wp_125_ads_widget' );
    }

    add_action( 'widgets_init', 'cb_125_ads_loader' );
}
?>