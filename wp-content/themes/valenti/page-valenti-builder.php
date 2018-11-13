<?php /* Template Name: Valenti Drag & Drop Builder */

get_header();
$cb_page_id = get_the_ID();
$cb_section_a = get_post_meta( $cb_page_id, 'cb_section_a', true );
$cb_section_b = get_post_meta( $cb_page_id, 'cb_section_b', true );
$cb_section_c = get_post_meta( $cb_page_id, 'cb_section_c', true );
$cb_section_d = get_post_meta( $cb_page_id, 'cb_section_d', true );
$cb_pb_append = get_post_meta( $cb_page_id, 'cb_pb_append', true );

while ( have_posts() ) {

    the_post();
    $cb_classes = implode( ' ', get_post_class( 'clearfix', $cb_page_id ) );

    if ( get_the_content() != NULL) {
        echo '<div id="cb-content" class="wrap cb-pb clearfix"><div id="main" class="cb-fw-bs clearfix" role="main"><article id="post-' . $cb_page_id . '" class="' . $cb_classes . ' cb-entry-content">';
        the_content(); 
        echo '</article></div></div>';
    }
}

$cb_paged = get_query_var('page');

if ( $cb_paged == NULL ) {

    for ( $cb_section_count = 1; $cb_section_count < 5; $cb_section_count++ ) {

        if ( $cb_section_count == 1 ) { $cb_x = 'a'; $cb_flag_a = true; }
        if ( $cb_section_count == 2 ) { $cb_x = 'b'; }
        if ( $cb_section_count == 3 ) { $cb_x = 'c'; }
        if ( $cb_section_count == 4 ) { $cb_x = 'd'; }

        if ( ${'cb_section_' . $cb_x} != NULL ) {

            if ( $cb_x == 'b' ) {
              if ( $cb_section_a == NULL ) { $cb_section_spacing = ' cb-section-top'; } else { $cb_section_spacing = NULL; }
              $j = 0;
              $cb_section = NULL;
              echo '<section id="cb-section-b" class="cb-hp-section cb-site-padding wrap clearfix' . $cb_section_spacing . '"><div class="cb-main">';
            } elseif ( $cb_x == 'c' ) {
              $cb_section = 'c';
              $j = 0;
              echo '<section id="cb-section-c" class="cb-hp-section wrap clearfix">';
            } elseif ( $cb_x == 'd' ) {
              $j = 0;
              $cb_section = NULL;
              echo '<section id="cb-section-d" class="cb-hp-section cb-site-padding wrap clearfix"><div class="cb-main">';
            }

            foreach ( ${'cb_section_' . $cb_x} as $cb_module ) {

                if ( $cb_x == 'a' ) {
                    $cb_section = 'a';
                    $g = $j = $x = 0;
                    if ( $cb_flag_a == true ) {

                      if ( ( $x == 0 ) && ( 0 === strpos($cb_module['cb_a_module_style'], 'grid') ) ) {
                        echo '<section id="cb-section-a" class="cb-hp-section wrap cb-first-true clearfix">';
                      } elseif ( $x == 0 ) {
                        echo '<section id="cb-section-a" class="cb-hp-section wrap clearfix">';
                      }
                      $cb_flag_a = false;
                    }
                }

                $cb_offset = $cb_order = $cb_orderby = $cb_filter = $cb_cat_id = $cb_tag_id = $cb_post_ids = $cb_tax_id = $cb_taxonomy = $cb_tax_qry = NULL;

                if ( isset($cb_module['cb_order']) ) {

                    if ( $cb_module['cb_order'] == 'cb_latest' ) {
                        $cb_order = 'DESC';
                        $cb_orderby = 'date';
                    } elseif ( $cb_module['cb_order'] == 'cb_random' ) {
                        $cb_order = 'DESC';
                        $cb_orderby = 'rand';
                    } elseif ( $cb_module['cb_order'] == 'cb_oldest' ) {
                        $cb_order = 'ASC';
                        $cb_orderby = 'date';
                    }

                }

                if ( isset($cb_module['cb_filter']) ) {

                    $cb_filter = $cb_module['cb_filter'];

                    if ( ( $cb_filter == 'cb_filter_category' ) && isset( $cb_module['cb_' . $cb_x . '_latest_posts'] ) ) {
                        $cb_cat_id_selection = $cb_module['cb_' . $cb_x . '_latest_posts'];
                        $cb_cat_id = implode(',', $cb_cat_id_selection);

                    } elseif ( ( $cb_filter == 'cb_filter_postid' ) && isset( $cb_module['ids_posts_cb'] ) ) {

                        $cb_post_names = array_filter( explode( '<cb>', $cb_module['ids_posts_cb'] ) );
                        $cb_post_ids = array();

                        foreach ( $cb_post_names as $cb_post_single ) {
                            $cb_post_single_term = get_page_by_title( $cb_post_single, OBJECT, 'post' );
                            $cb_post_ids[] = $cb_post_single_term->ID;
                        }

                    } elseif ( ( $cb_filter == 'cb_filter_tags' )  && isset( $cb_module['tags_cb'] ) ) {

                        $cb_tag_names = array_filter( explode( ',', $cb_module['tags_cb'] ) );
                        $cb_tag_id = array();

                        foreach ( $cb_tag_names as $cb_tag ) {
                            $cb_tag_term = get_term_by( 'name', $cb_tag, 'post_tag' );
                            $cb_tag_id[] = $cb_tag_term->term_id;
                        }

                    } elseif ( ( $cb_filter == 'cb_filter_ctax' )  && isset( $cb_module['cb_tax_list'] ) ) {
                        $cb_taxonomy = $cb_module['cb_tax_list'];
                        if ( isset($cb_module['ctax_cb']) ) {
                            $cb_tax_id =  $cb_module['ctax_cb'];
                        } else {
                            $cb_tax_terms = get_terms($cb_taxonomy);
                            $cb_tax_id = $cb_tax_terms[0]->term_id;
                        }
                        $cb_tax_qry = array(array('taxonomy' => $cb_taxonomy, 'field' => 'term_id', 'terms' => $cb_tax_id ) );

                    }

                } else {

                    if ( isset($cb_module['cb_' . $cb_x . '_latest_posts']) ) {
                        $cb_cat_id_selection = $cb_module['cb_' . $cb_x . '_latest_posts'];
                        $cb_cat_id = implode(',', $cb_cat_id_selection);
                        $cb_cat_name = get_category($cb_cat_id)->name;
                        $cb_cat_url = get_category_link($cb_cat_id);
                    } else {
                        $cb_cat_id_selection = get_terms( 'category', array('fields' => 'ids') );
                        $cb_cat_id = implode(',', $cb_cat_id_selection);
                        $cb_cat_name = get_category($cb_cat_id)->name;
                        $cb_cat_url = get_category_link($cb_cat_id);
                    }
                }

                if ( isset($cb_module['cb_offset']) ) {
                    $cb_offset = $cb_module['cb_offset'];
                }

                $cb_amount = $cb_module['cb_slider_' . $cb_x];
                $cb_title = $cb_module['title'];
                $cb_flipped = NULL;
                $cb_style = $cb_module['cb_style_' . $cb_x];
                if ( $cb_style == 'cb_light_' . $cb_x ) {
                    $cb_module_style = 'cb-light';
                } else {
                    $cb_module_style = 'cb-dark';
                }
                $cb_ad_code = $cb_module['cb_ad_code_' . $cb_x];
                $cb_custom = $cb_module['cb_custom_' . $cb_x];
                $cb_subtitle = $cb_module['cb_subtitle_' . $cb_x];

                if ( $cb_subtitle != NULL ) {
                $cb_subtitle = '<p>' . $cb_subtitle . '</p>';
                }

                $cb_module_type = substr_replace( $cb_module['cb_' . $cb_x . '_module_style'] ,"",-1 );

                if ( $cb_module_type == 'grid-4-f' ) {
                    $cb_flipped = 'cb-flipped ';
                    $cb_module_type = 'grid-4';
                }
                if ( $cb_module_type == 'grid-5-f' ) {
                    $cb_flipped = 'cb-flipped ';
                    $cb_module_type = 'grid-5';
                }

                if ( ( function_exists( 'get_tax_meta' ) ) && ( $cb_cat_id != NULL ) ) {
                    $cb_category_color = get_tax_meta( $cb_cat_id, 'cb_color_field_id' );
                } else {
                    $cb_category_color = NULL;
                }

                include( locate_template('library/modules/cb-' . $cb_module_type . '.php') );

                if ( $cb_x == 'a' ) {
                    $j++;
                    $g++;
                    $x++;
                } elseif ( $cb_x == 'c' ) {
                    $j++;
                }

            }

            if ( ( $cb_x == 'a' ) && ( $cb_pb_append == 'style-a' ) ) {
                cb_pb_output( $cb_page_id );
            } elseif  ( ( $cb_x == 'b' ) && ( $cb_pb_append == 'style-b' ) ) {
                cb_pb_output( $cb_page_id );
            } elseif  ( ( $cb_x == 'c' ) && ( $cb_pb_append == 'style-c' ) ) {
                cb_pb_output( $cb_page_id );
            } elseif  ( ( $cb_x == 'd' ) && ( $cb_pb_append == 'style-d' ) ) {
                cb_pb_output( $cb_page_id );
            }
                                    
            if ( ( $cb_x == 'b' ) || ( $cb_x == 'd' ) ) {
                echo '</div>';
                if ( ot_get_option('cb_sticky_sb', 'off') == 'on' ) {
                    echo '<div class="cb-sticky-sidebar">';
                }

                if ( is_active_sidebar( 'sidebar-hp-' . $cb_x . '-' . $cb_page_id ) ) {
                    echo '<aside id="cb-sidebar-' . $cb_x . '" class="cb-sidebar cb-sidebar-hp clearfix' . $cb_section_spacing . '" role="complementary">';
                    dynamic_sidebar( 'sidebar-hp-' . $cb_x . '-' . $cb_page_id );
                    echo '</aside>';
                }

                if ( ot_get_option('cb_sticky_sb', 'off') == 'on' ) {
                    echo '</div>';
                }
            }

            echo '</section>';

        } 

    } 
} else {
    $cb_pb_append = get_post_meta( $cb_page_id, 'cb_pb_append', true );
    $cb_x = substr( $cb_pb_append, -1);
    if ( ( $cb_pb_append == 'style-a' ) || ( $cb_pb_append == 'style-c' ) ) {
        echo '<section id="cb-section-a" class="cb-hp-section cb-hp-paginated wrap clearfix">';
        if ( is_paged() ) {
            echo '<div id="cb-content" class="wrap cb-pb clearfix">';
        }
    } else {
        echo '<section id="cb-section-b" class="cb-hp-section cb-hp-paginated cb-site-padding wrap clearfix">';
        if ( is_paged() ) {
            echo '<div class="wrap cb-pb clearfix">';
        }
    }
    echo '<div class="cb-main clearfix cb-module-block cb-light-off cb-blog-style-roll" role="main">';
    cb_pb_output( $cb_page_id, false );
    echo '</div>';
    
    if ( ( $cb_pb_append == 'style-b' ) || ( $cb_pb_append == 'style-d' ) ) {

        if ( ot_get_option('cb_sticky_sb', 'off') == 'on' ) {
            echo '<div class="cb-sticky-sidebar">';
        }

        if ( is_active_sidebar( 'sidebar-hp-' . $cb_x . '-' . $cb_page_id ) ) {
            echo '<aside id="cb-sidebar-' . $cb_x . '" class="cb-sidebar cb-sidebar-hp clearfix" role="complementary">';
            dynamic_sidebar( 'sidebar-hp-' . $cb_x . '-' . $cb_page_id );
            echo '</aside>';
        }

        if ( ot_get_option('cb_sticky_sb', 'off') == 'on' ) {
            echo '</div>';
        }
    }
    if ( is_paged() ) {
        echo '</div>';
    }
    echo '</section>';
}

?>

<?php get_footer(); ?>