<?php
namespace Sections;
use WP_Query;

class ContentAnalysis{

  private $legend = "This is the Content Analysis page for WpGod.";
  
  public function getContentAnalysisHtml(){
    global $wpdb;
    ?>
    <div class="wrap">
        <?php 
        $sectionHeader = new \Components\WpGodSectionsHeader($this->legend);
        $sectionHeader->getSectionsHeaderHtml();
        ?>
         <h2><?php _e( 'Published Posts', 'wpgod' ); ?></h2>
        <?php
        $args = array(
            'post_type'      => 'post', // Queremos obtener 'posts' (entradas)
            'post_status'    => 'publish', // Solo posts publicados
            'posts_per_page' => 10, // Mostrar los últimos 10. Cambia a -1 para todos, o implementa paginación.
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        $posts_query = new WP_Query( $args );

        if ( $posts_query->have_posts() ) :
            echo '<ul style="list-style: none; padding-left: 0;">';
            while ( $posts_query->have_posts() ) :
                $posts_query->the_post();
                $post_id = get_the_ID();
                ?>
                <li style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #ddd;">
                    <div>
                        <strong><a href="<?php echo esc_url( get_edit_post_link( $post_id ) ); ?>"><?php echo esc_html( get_the_title() ); ?></a></strong>
                        <small>(<?php printf( esc_html__( 'Published on: %s', 'wpgod' ), esc_html( get_the_date() ) ); ?>)</small>
                    </div>
                    <details style="margin-top: 10px; background-color: #f9f9f9; border: 1px solid #eee; padding: 10px; border-radius: 4px;">
                        <summary style="cursor: pointer; font-weight: bold; color: #0073aa;"><?php _e( 'View Database Details', 'wpgod' ); ?></summary>
                        <div style="margin-top: 10px;">
                            <?php
                            // Obtener datos de la tabla wp_posts
                            $post_data_item = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE ID = %d", $post_id ), ARRAY_A );
                            ?>
                            <h4 style="margin-top: 0; margin-bottom: 5px;"><?php printf( esc_html__( 'Data from %s table (ID: %d)', 'wpgod' ), '<code>' . esc_html( $wpdb->posts ) . '</code>', esc_html( $post_id ) ); ?></h4>
                            <?php if ( $post_data_item ) : ?>
                                <pre style="white-space: pre-wrap; word-wrap: break-word; background-color: #fff; padding: 8px; border: 1px solid #e0e0e0; border-radius: 3px; max-height: 300px; overflow-y: auto;"><?php echo esc_html( print_r( $post_data_item, true ) ); ?></pre>
                            <?php else : ?>
                                <p><?php _e( 'No data found in posts table for this item.', 'wpgod' ); ?></p>
                            <?php endif; ?>

                            <?php
                            // Obtener datos de la tabla wp_postmeta
                            $meta_data_item = $wpdb->get_results( $wpdb->prepare( "SELECT meta_key, meta_value FROM {$wpdb->postmeta} WHERE post_id = %d ORDER BY meta_key ASC", $post_id ), ARRAY_A );
                            ?>
                            <h4 style="margin-top: 15px; margin-bottom: 5px;"><?php printf( esc_html__( 'Data from %s table (post_id: %d)', 'wpgod' ), '<code>' . esc_html( $wpdb->postmeta ) . '</code>', esc_html( $post_id ) ); ?></h4>
                            <?php if ( $meta_data_item ) : ?>
                                <ul style="list-style-type: disc; padding-left: 20px; max-height: 400px; overflow-y: auto; background-color: #fff; padding: 8px; border: 1px solid #e0e0e0; border-radius: 3px;">
                                    <?php foreach ( $meta_data_item as $meta_item_row ) : ?>
                                        <li style="margin-bottom: 8px;">
                                            <strong><?php echo esc_html( $meta_item_row['meta_key'] ); ?>:</strong>
                                            <pre style="white-space: pre-wrap; word-wrap: break-word; margin-top: 3px; background-color: #fdfdfd; padding: 5px; border: 1px solid #e5e5e5; border-radius: 2px;"><?php
                                                $value = maybe_unserialize( $meta_item_row['meta_value'] );
                                                echo esc_html( print_r( $value, true ) );
                                            ?></pre>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <p><?php _e( 'No metadata found for this item.', 'wpgod' ); ?></p>
                            <?php endif; ?>
                        </div>
                    </details>
                </li>
                <?php
            endwhile;
            echo '</ul>';
            wp_reset_postdata(); // Importante para restaurar el $post global original.
        else :
            echo '<p>' . esc_html__( 'No posts found.', 'wpgod' ) . '</p>';
        endif;
        ?>
       
    </div>
    <?php
  }  

}

