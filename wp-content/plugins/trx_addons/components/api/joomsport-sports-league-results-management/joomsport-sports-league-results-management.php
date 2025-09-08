<?php
/**
 * Plugin support: JoomSport
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_joomsport' ) ) {
	function trx_addons_exists_joomsport() {
        return  function_exists( 'joomsport_activation_redirect' );
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_joomsport_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_joomsport_importer_required_plugins', 10, 2 );
    function trx_addons_joomsport_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'joomsport-sports-league-results-management')!==false && !trx_addons_exists_joomsport() )
            $not_installed .= '<br>' . esc_html__('JoomSport', 'trx_addons');
        return $not_installed;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_joomsport_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_joomsport_importer_set_options' );
    function trx_addons_joomsport_importer_set_options($options=array()) {
        if ( trx_addons_exists_joomsport() && in_array('joomsport-sports-league-results-management', $options['required_plugins']) ) {
            $options['additional_options'][] = 'joomsport_%';
            $options['additional_options'][] = 'taxonomy_%';
        }
        if (is_array($options['files']) && count($options['files']) > 0) {
            foreach ($options['files'] as $k => $v) {
                $options['files'][$k]['file_with_joomsport-sports-league-results-management'] = str_replace('name.ext', 'joomsport-sports-league-results-management.txt', $v['file_with_']);
            }
        }
        return $options;
    }
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_joomsport_importer_show_params' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_joomsport_importer_show_params', 10, 1 );
    function trx_addons_joomsport_importer_show_params($importer) {
        if ( trx_addons_exists_joomsport() && in_array('joomsport-sports-league-results-management', $importer->options['required_plugins']) ) {
            $importer->show_importer_params(array(
                'slug' => 'joomsport-sports-league-results-management',
                'title' => esc_html__('Import JoomSport', 'trx_addons'),
                'part' => 0
            ));
        }
    }
}

// Import posts
if ( !function_exists( 'trx_addons_joomsport_importer_import' ) ) {
    add_action( 'trx_addons_action_importer_import',	'trx_addons_joomsport_importer_import', 10, 2 );
    function trx_addons_joomsport_importer_import($importer, $action) {
        if ( trx_addons_exists_joomsport() && in_array('joomsport-sports-league-results-management', $importer->options['required_plugins']) ) {
            if ( $action == 'import_joomsport-sports-league-results-management' ) {
                $importer->response['start_from_id'] = 0;
                $importer->import_dump('joomsport-sports-league-results-management', esc_html__('Joomsport meta', 'trx_addons'));
            }
        }
    }
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_joomsport_importer_check_row' ) ) {
    add_filter('trx_addons_filter_importer_import_row', 'trx_addons_joomsport_importer_check_row', 9, 4);
    function trx_addons_joomsport_importer_check_row($flag, $table, $row, $list) {
        if ($flag || strpos($list, 'joomsport-sports-league-results-management')===false) return $flag;
        if ( trx_addons_exists_joomsport() ) {
            if ($table == 'posts')
                $flag = in_array($row['post_type'], array('joomsport_season', 'joomsport_team', 'joomsport_player', 'joomsport_match', 'joomsport_person'));
        }
        return $flag;
    }
}



// Display import progress
if ( !function_exists( 'trx_addons_joomsport_importer_import_fields' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_joomsport_importer_import_fields', 10, 1 );
    function trx_addons_joomsport_importer_import_fields($importer) {
        if ( trx_addons_exists_joomsport() && in_array('joomsport-sports-league-results-management', $importer->options['required_plugins']) ) {
            $importer->show_importer_fields(array(
                    'slug'=>'joomsport-sports-league-results-management',
                    'title' => esc_html__('JoomSport data', 'trx_addons')
                )
            );
        }
    }
}

// Export posts
if ( !function_exists( 'trx_addons_joomsport_importer_export' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_export',	'trx_addons_joomsport_importer_export', 10, 1 );
    function trx_addons_joomsport_importer_export($importer) {
        if ( trx_addons_exists_joomsport() && in_array('joomsport-sports-league-results-management', $importer->options['required_plugins']) ) {
            trx_addons_fpc($importer->export_file_dir('joomsport-sports-league-results-management.txt'), serialize( array(
                    "joomsport_box_fields" => $importer->export_dump("joomsport_box_fields"),
                    "joomsport_box_match" => $importer->export_dump("joomsport_box_match"),
                    "joomsport_config" => $importer->export_dump("joomsport_config"),
                    "joomsport_events" => $importer->export_dump("joomsport_events"),
                    "joomsport_events_depending" => $importer->export_dump("joomsport_events_depending"),
                    "joomsport_extra_fields" => $importer->export_dump("joomsport_extra_fields"),
                    "joomsport_extra_select" => $importer->export_dump("joomsport_extra_select"),
                    "joomsport_groups" => $importer->export_dump("joomsport_groups"),
                    "joomsport_maps" => $importer->export_dump("joomsport_maps"),
                    "joomsport_matches" => $importer->export_dump("joomsport_matches"),
                    "joomsport_match_events" => $importer->export_dump("joomsport_match_events"),
                    "joomsport_match_statuses" => $importer->export_dump("joomsport_match_statuses"),
                    "joomsport_playerlist" => $importer->export_dump("joomsport_playerlist"),
                    "joomsport_seasons" => $importer->export_dump("joomsport_seasons"),
                    "joomsport_season_table" => $importer->export_dump("joomsport_season_table"),
                    "joomsport_squad" => $importer->export_dump("joomsport_squad"),
							"joomsport_match_events_addit" => $importer->export_dump("joomsport_match_events_addit"),
							"joomsport_sports" => $importer->export_dump("joomsport_sports"),
							"joomsport_sports_template" => $importer->export_dump("joomsport_sports_template"),
							"joomsport_teamplayers" => $importer->export_dump("joomsport_teamplayers"),
							"joomsport_teamstats" => $importer->export_dump("joomsport_teamstats"),							
                ) )
            );
        }
    }
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_joomsport_importer_export_fields' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_joomsport_importer_export_fields', 10, 1 );
    function trx_addons_joomsport_importer_export_fields($importer) {
        if ( trx_addons_exists_joomsport() && in_array('joomsport-sports-league-results-management', $importer->options['required_plugins']) ) {
            $importer->show_exporter_fields(array(
                    'slug'	=> 'joomsport-sports-league-results-management',
                    'title' => esc_html__('JoomSport data', 'trx_addons')
                )
            );
        }
    }
}


// Add plugin to import list
if ( !function_exists( 'trx_addons_ocdi_joomsport_import_field' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_ocdi_import_fields', 'trx_addons_ocdi_joomsport_import_field' );
    function trx_addons_ocdi_joomsport_import_field($output){
        $list = array();
        if (trx_addons_exists_joomsport() && in_array('joomsport-sports-league-results-management', trx_addons_ocdi_options('required_plugins'))) {
            $output .= '<label><input type="checkbox" name="joomsport-sports-league-results-management" value="joomsport-sports-league-results-management">'. esc_html__( 'JoomSport', 'trx_addons' ).'</label><br/>';
        }
        return $output;
    }
}

// Import plugin's data
if ( !function_exists( 'trx_addons_ocdi_joomsport_import' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_ocdi_import_plugins', 'trx_addons_ocdi_joomsport_import', 10, 1 );
    function trx_addons_ocdi_joomsport_import( $import_plugins){
        if (trx_addons_exists_joomsport() && in_array('joomsport-sports-league-results-management', $import_plugins)) {
            trx_addons_ocdi_import_dump('joomsport-sports-league-results-management');
            echo esc_html__('JoomSport import complete.', 'trx_addons') . "\r\n";
        }
    }
}
?>