<?php
namespace Sections;
use WP_Query;

class DBAnalysis{

  private $legend = "This is the DB Analysis page for WpGod.";
  
  public function getDBAnalysisHtml(){
    global $wpdb;
    ?>
    <div class="wrap">
        <?php 
        $sectionHeader = new \Components\WpGodSectionsHeader($this->legend);
        $sectionHeader->getSectionsHeaderHtml();
        ?>
        <h2><?php _e( "Database Tables", "wpgod" ); ?></h2>
        <?php
        $tables = $wpdb->get_results( "SHOW TABLES", ARRAY_N );

        if ( ! empty( $tables ) ) {
            echo '<p>' . sprintf( esc_html__( "Found %d tables in the database:", "wpgod" ), count( $tables ) ) . '</p>';
            echo '<ul style="list-style: none; padding-left: 0;">';
            foreach ( $tables as $table_row ) {
                $table_name = $table_row[0];

                // Get column information for the current table
                // Using backticks around table name for safety, though esc_sql should handle it.
                $columns_data = $wpdb->get_results( "SHOW COLUMNS FROM `" . esc_sql( $table_name ) . "`" );
                
                $num_columns = 0;
                $primary_keys_array = [];
                if ( $columns_data ) {
                    $num_columns = count( $columns_data );
                    foreach ( $columns_data as $column ) {
                        if ( $column->Key == 'PRI' ) {
                            $primary_keys_array[] = $column->Field;
                        }
                    }
                }
                $primary_key_display = !empty($primary_keys_array) ? implode(', ', $primary_keys_array) : __('N/A', 'wpgod');

                // Get row count for the current table
                $row_count = $wpdb->get_var( "SELECT COUNT(*) FROM `" . esc_sql( $table_name ) . "`" );
                if ( is_null( $row_count ) ) {
                    $row_count = __('Error fetching count', 'wpgod');
                }

                ?>
                <li style="margin-bottom: 10px;">
                    <details style="background-color: #f9f9f9; border: 1px solid #eee; padding: 10px; border-radius: 4px;">
                        <summary style="cursor: pointer; font-weight: bold; color: #0073aa;"><code><?php echo esc_html( $table_name ); ?></code></summary>
                        <div style="margin-top: 10px; background-color: #fff; padding: 15px; border: 1px solid #e0e0e0; border-radius: 3px; font-size: 0.9em;">
                            <p><strong><?php esc_html_e( 'Total Rows:', 'wpgod' ); ?></strong> <?php echo esc_html( number_format_i18n( (int) $row_count ) ); ?></p>
                            <p><strong><?php esc_html_e( 'Total Columns:', 'wpgod' ); ?></strong> <?php echo esc_html( number_format_i18n( $num_columns ) ); ?></p>
                            <p><strong><?php esc_html_e( 'Primary Key(s):', 'wpgod' ); ?></strong> <?php echo esc_html( $primary_key_display ); ?></p>
                            
                            <h4 style="margin-top: 20px; margin-bottom: 8px; font-size: 1.1em;"><?php esc_html_e( 'Columns:', 'wpgod' ); ?></h4>
                            <?php if ( ! empty( $columns_data ) ) : ?>
                                <ul style="list-style-type: none; padding-left: 0; max-height: 250px; overflow-y: auto; border: 1px solid #eee; padding: 10px; background-color: #fcfcfc; border-radius: 3px;">
                                    <?php foreach ( $columns_data as $column ) : ?>
                                        <li style="padding: 5px 0; border-bottom: 1px dashed #eee;">
                                            <strong><?php echo esc_html( $column->Field ); ?></strong> (<?php echo esc_html( $column->Type ); ?>)
                                            <?php if ( $column->Key == 'PRI' ) : ?><span style="font-weight: bold; color: #c00; margin-left: 5px;">[<?php esc_html_e( 'PK', 'wpgod' ); ?>]</span><?php endif; ?>
                                            <?php if ( $column->Null == 'NO' && $column->Default === null && !str_contains(strtolower($column->Extra), 'auto_increment') ) : ?><span style="color: #777; margin-left: 5px;">[<?php esc_html_e( 'NOT NULL', 'wpgod' ); ?>]</span><?php endif; ?>
                                            <?php if ( $column->Default !== null ) : ?><span style="color: #555; margin-left: 5px;">[<?php esc_html_e( 'Default:', 'wpgod' ); ?> <?php echo esc_html($column->Default); ?>]</span><?php endif; ?>
                                            <?php if ( !empty($column->Extra) ) : ?><span style="color: #333; margin-left: 5px;">[<?php echo esc_html(strtoupper($column->Extra)); ?>]</span><?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <p><?php esc_html_e( 'Could not retrieve column information for this table.', 'wpgod' ); ?></p>
                            <?php endif; ?>
                        </div>
                    </details>
                </li>
                <?php
            }
            echo '</ul>';
        } else {
            echo '<p>' . esc_html__( "No tables found in the database or an error occurred.", "wpgod" ) . '</p>';
        }
        ?>
    </div>
    <?php
  }  

}  

