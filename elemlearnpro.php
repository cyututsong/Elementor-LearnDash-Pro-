<?php
/**
 * Plugin Name: ElemLearnPro
 * Plugin URI: https://github.com/cyututsong
 * Description: Custom Elementor widget for LearnDash lesson navigation - displays current lesson, previous/next navigation, and sibling lesson list
 * Version: 1.0.0
 * Author: Yendor015
 * Text Domain: elearnpro
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Elementor tested up to: 3.19.0
 * LearnDash tested up to: 4.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define( 'ELEARNPRO_VERSION', '1.0.0' );
define( 'ELEARNPRO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ELEARNPRO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Check if Elementor and LearnDash are active
function elearnpro_check_dependencies() {
    $dependencies_met = true;
    
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'elearnpro_missing_elementor_notice' );
        $dependencies_met = false;
    }
    
    if ( ! class_exists( 'SFWD_LMS' ) ) {
        add_action( 'admin_notices', 'elearnpro_missing_learndash_notice' );
        $dependencies_met = false;
    }
    
    return $dependencies_met;
}

function elearnpro_missing_elementor_notice() {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php esc_html_e( 'ElemLearnPro requires Elementor to be installed and activated.', 'elearnpro' ); ?></p>
    </div>
    <?php
}

function elearnpro_missing_learndash_notice() {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php esc_html_e( 'ElemLearnPro requires LearnDash LMS to be installed and activated.', 'elearnpro' ); ?></p>
    </div>
    <?php
}

// Register widgets - SINGLE REGISTRATION FUNCTION
function elearnpro_register_widgets( $widgets_manager ) {
    
    // Check dependencies
    if ( ! elearnpro_check_dependencies() ) {
        return;
    }
    
    // Register the Lesson Navigation Widget
    $widgets_manager->register( new \ElemLearnPro_Lesson_Navigation_Widget() );
    
    // Register the Quiz Widget (if the class exists)
    if ( class_exists( 'ElemLearnPro_Quiz_Widget' ) ) {
        $widgets_manager->register( new \ElemLearnPro_Quiz_Widget() );
    }
}
add_action( 'elementor/widgets/register', 'elearnpro_register_widgets' );

// Add custom widget category
function elearnpro_add_widget_category( $elements_manager ) {
    
    $category = [
        'title' => esc_html__( 'ElemLearnPro', 'elearnpro' ),
        'icon' => 'eicon-graduate',
    ];
    
    $elements_manager->add_category( 'elemlearnpro', $category );
    
}
add_action( 'elementor/elements/categories_registered', 'elearnpro_add_widget_category' );

// Load text domain for translations
function elearnpro_load_textdomain() {
    load_plugin_textdomain( 'elearnpro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'elearnpro_load_textdomain' );

// Add settings link on plugins page
function elearnpro_add_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=elearnpro-settings">' . esc_html__( 'Settings', 'elearnpro' ) . '</a>';
    array_push( $links, $settings_link );
    return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'elearnpro_add_settings_link' );

// Initialize admin settings page
function elearnpro_admin_menu() {
    add_submenu_page(
        'options-general.php',
        esc_html__( 'ElemLearnPro Settings', 'elearnpro' ),
        esc_html__( 'ElemLearnPro', 'elearnpro' ),
        'manage_options',
        'elearnpro-settings',
        'elearnpro_settings_page'
    );
}
add_action( 'admin_menu', 'elearnpro_admin_menu' );

function elearnpro_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'ElemLearnPro Settings', 'elearnpro' ); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'elearnpro_settings' ); ?>
            <?php do_settings_sections( 'elearnpro_settings' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php esc_html_e( 'Default Navigation Label', 'elearnpro' ); ?></th>
                    <td>
                        <input type="text" name="elearnpro_prev_label" value="<?php echo esc_attr( get_option( 'elearnpro_prev_label', 'Previous Lesson' ) ); ?>" />
                        <p class="description"><?php esc_html_e( 'Label for the previous lesson button', 'elearnpro' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e( 'Default Next Label', 'elearnpro' ); ?></th>
                    <td>
                        <input type="text" name="elearnpro_next_label" value="<?php echo esc_attr( get_option( 'elearnpro_next_label', 'Next Lesson' ) ); ?>" />
                        <p class="description"><?php esc_html_e( 'Label for the next lesson button', 'elearnpro' ); ?></p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Include widget files after all functions are defined
// This ensures the widget classes are available when needed
add_action( 'init', function() {
    // Only load widgets if Elementor and LearnDash are active
    if ( did_action( 'elementor/loaded' ) && class_exists( 'SFWD_LMS' ) ) {
        require_once ELEARNPRO_PLUGIN_DIR . 'includes/class-lesson-navigation-widget.php';
        
        if ( file_exists( ELEARNPRO_PLUGIN_DIR . 'includes/class-quiz-widget.php' ) ) {
            require_once ELEARNPRO_PLUGIN_DIR . 'includes/class-quiz-widget.php';
        }
    }
});