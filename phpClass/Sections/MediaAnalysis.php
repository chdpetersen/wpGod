<?php
namespace Sections;
use WP_Query;

class MediaAnalysis{

  private $legend = "This is the Media Content Analysis page for WpGod.";
  
  public function getMediaAnalysisHtml(){
    global $wpdb;
    ?>
    <div class="wrap">
        <?php 
        $sectionHeader = new \Components\WpGodSectionsHeader($this->legend);
        $sectionHeader->getSectionsHeaderHtml();
        ?>
       <h2><?php _e( 'Media Library Items', 'wpgod' ); ?></h2>
        <?php
        $args = array(
            'post_type'      => 'attachment',
            'post_status'    => 'inherit', // 'inherit' es el estado común para los adjuntos, 'any' también podría usarse.
            'posts_per_page' => 15,       // Mostrar los últimos 15. Cambia a -1 para todos, o implementa paginación.
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        $media_query = new WP_Query( $args );

        if ( $media_query->have_posts() ) :
            echo '<ul style="list-style: none; padding-left: 0;">';
            while ( $media_query->have_posts() ) :
                $media_query->the_post();
                $attachment_id = get_the_ID();
                $file_url = wp_get_attachment_url( $attachment_id );
                $mime_type = get_post_mime_type( $attachment_id );
                ?>
                <li style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #ddd;">
                    <div style="display: flex; align-items: flex-start;">
                        <?php if ( strpos( $mime_type, 'image/' ) === 0 ) : ?>
                            <a href="<?php echo esc_url( get_edit_post_link( $attachment_id ) ); ?>" style="margin-right: 15px; display: block; width: 80px; height: 80px; overflow: hidden; border: 1px solid #ddd;">
                                <?php echo wp_get_attachment_image( $attachment_id, 'thumbnail', false, array( 'style' => 'width: 100%; height: auto; display: block;' ) ); ?>
                            </a>
                        <?php else : ?>
                            <div style="margin-right: 15px; width: 80px; height: 80px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd; text-align: center; font-size: 12px; color: #555;">
                                <?php echo esc_html( strtoupper( substr( strrchr( $mime_type, '/' ), 1 ) ) ); // Muestra la extensión o tipo ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <strong><a href="<?php echo esc_url( get_edit_post_link( $attachment_id ) ); ?>"><?php echo esc_html( get_the_title() ); ?></a></strong><br>
                            <small><?php printf( esc_html__( 'Uploaded on: %s', 'wpgod' ), esc_html( get_the_date() ) ); ?></small><br>
                            <small><?php printf( esc_html__( 'Type: %s', 'wpgod' ), esc_html( $mime_type ) ); ?></small><br>
                            <small><a href="<?php echo esc_url( $file_url ); ?>" target="_blank" rel="noopener noreferrer"><?php _e( 'View file', 'wpgod' ); ?></a></small>
                        </div>
                    </div>
                    <details style="margin-top: 10px; background-color: #f9f9f9; border: 1px solid #eee; padding: 10px; border-radius: 4px;">
                        <summary style="cursor: pointer; font-weight: bold; color: #0073aa;"><?php _e( 'View Database Details', 'wpgod' ); ?></summary>
                        <div style="margin-top: 10px;">
                            <?php
                            // Obtener datos de la tabla wp_posts
                            $post_data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE ID = %d", $attachment_id ), ARRAY_A );
                            ?>
                            <h4 style="margin-top: 0; margin-bottom: 5px;"><?php printf( esc_html__( 'Data from %s table (ID: %d)', 'wpgod' ), '<code>' . esc_html( $wpdb->posts ) . '</code>', esc_html( $attachment_id ) ); ?></h4>
                            <?php if ( $post_data ) : ?>
                                <pre style="white-space: pre-wrap; word-wrap: break-word; background-color: #fff; padding: 8px; border: 1px solid #e0e0e0; border-radius: 3px; max-height: 300px; overflow-y: auto;"><?php echo esc_html( print_r( $post_data, true ) ); ?></pre>
                            <?php else : ?>
                                <p><?php _e( 'No data found in posts table for this item.', 'wpgod' ); ?></p>
                            <?php endif; ?>

                            <?php
                            // Obtener datos de la tabla wp_postmeta
                            $meta_data = $wpdb->get_results( $wpdb->prepare( "SELECT meta_key, meta_value FROM {$wpdb->postmeta} WHERE post_id = %d ORDER BY meta_key ASC", $attachment_id ), ARRAY_A );
                            ?>
                            <h4 style="margin-top: 15px; margin-bottom: 5px;"><?php printf( esc_html__( 'Data from %s table (post_id: %d)', 'wpgod' ), '<code>' . esc_html( $wpdb->postmeta ) . '</code>', esc_html( $attachment_id ) ); ?></h4>
                            <?php if ( $meta_data ) : ?>
                                <ul style="list-style-type: disc; padding-left: 20px; max-height: 400px; overflow-y: auto; background-color: #fff; padding: 8px; border: 1px solid #e0e0e0; border-radius: 3px;">
                                    <?php foreach ( $meta_data as $meta_item ) : ?>
                                        <li style="margin-bottom: 8px;">
                                            <strong><?php echo esc_html( $meta_item['meta_key'] ); ?>:</strong>
                                            <pre style="white-space: pre-wrap; word-wrap: break-word; margin-top: 3px; background-color: #fdfdfd; padding: 5px; border: 1px solid #e5e5e5; border-radius: 2px;"><?php
                                                $value = maybe_unserialize( $meta_item['meta_value'] );
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
            echo '<p>' . esc_html__( 'No media items found.', 'wpgod' ) . '</p>';
        endif;
        ?>
    </div>
    <?php
  }  

}  
