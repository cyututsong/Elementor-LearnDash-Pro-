<?php
/**
 * Plugin Name: ElemLearnPro
 * Plugin URI: https://github.com/cyututsong
 * Description: Custom Elementor widget for LearnDash - includes lesson navigation, quiz display, and mark complete button
 * Version: 1.1.0
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
define( 'ELEARNPRO_VERSION', '1.1.0' );
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

// Register widgets
function elearnpro_register_widgets( $widgets_manager ) {
    
    // Check dependencies
    if ( ! elearnpro_check_dependencies() ) {
        return;
    }
    
    // Include widget class files
    require_once ELEARNPRO_PLUGIN_DIR . 'includes/class-lesson-navigation-widget.php';
    
    if ( file_exists( ELEARNPRO_PLUGIN_DIR . 'includes/class-quiz-widget.php' ) ) {
        require_once ELEARNPRO_PLUGIN_DIR . 'includes/class-quiz-widget.php';
    }
    
    if ( file_exists( ELEARNPRO_PLUGIN_DIR . 'includes/class-mark-complete-widget.php' ) ) {
        require_once ELEARNPRO_PLUGIN_DIR . 'includes/class-mark-complete-widget.php';
    }
    
    // Register the Lesson Navigation Widget
    if ( class_exists( 'ElemLearnPro_Lesson_Navigation_Widget' ) ) {
        $widgets_manager->register( new \ElemLearnPro_Lesson_Navigation_Widget() );
    }
    
    // Register the Quiz Widget
    if ( class_exists( 'ElemLearnPro_Quiz_Widget' ) ) {
        $widgets_manager->register( new \ElemLearnPro_Quiz_Widget() );
    }
    
    // Register the Mark Complete Widget (NEW)
    if ( class_exists( 'ElemLearnPro_Mark_Complete_Widget' ) ) {
        $widgets_manager->register( new \ElemLearnPro_Mark_Complete_Widget() );
    }
}
add_action( 'elementor/widgets/register', 'elearnpro_register_widgets' );

// Handle custom mark complete form submission (fallback)
add_action('init', 'elearnpro_handle_mark_complete');
function elearnpro_handle_mark_complete() {
    if (isset($_POST['elearnpro_step_id']) && isset($_POST['elearnpro_nonce'])) {
        $step_id = intval($_POST['elearnpro_step_id']);
        $nonce = sanitize_text_field($_POST['elearnpro_nonce']);
        
        if (wp_verify_nonce($nonce, 'learndash_mark_complete_' . $step_id)) {
            $user_id = get_current_user_id();
            
            if ($user_id && function_exists('learndash_process_mark_complete')) {
                $course_id = learndash_get_course_id($step_id);
                $success = learndash_process_mark_complete($user_id, $step_id, false, $course_id);
                
                if ($success) {
                    wp_redirect(get_permalink($step_id));
                    exit;
                }
            }
        }
    }
}

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
add_action( 'init', function() {
    // Only load widgets if Elementor and LearnDash are active
    if ( did_action( 'elementor/loaded' ) && class_exists( 'SFWD_LMS' ) ) {
        $widget_files = [
            'class-lesson-navigation-widget.php',
            'class-quiz-widget.php',
            'class-mark-complete-widget.php'
        ];
        
        foreach ($widget_files as $file) {
            $file_path = ELEARNPRO_PLUGIN_DIR . 'includes/' . $file;
            if (file_exists($file_path)) {
                require_once $file_path;
            }
        }
    }
});


/**
 * Enqueue widget assets
 */
function elearnpro_enqueue_widget_assets() {
    // Register and enqueue CSS
    wp_register_style(
        'elearnpro-widget-css',
        plugin_dir_url(__FILE__) . 'assets/css/elearnpro-widget.css',
        [],
        '1.0.0'
    );
    
    // Register and enqueue JavaScript
    wp_register_script(
        'elearnpro-widget-js',
        plugin_dir_url(__FILE__) . 'assets/js/elearnpro-widget.js',
        ['jquery'],
        '1.0.0',
        true
    );
    
    // Only enqueue if widget is active (optional optimization)
    if (is_singular(['sfwd-lessons', 'sfwd-topics'])) {
        wp_enqueue_style('elearnpro-widget-css');
        wp_enqueue_script('elearnpro-widget-js');
    }
}
add_action('wp_enqueue_scripts', 'elearnpro_enqueue_widget_assets');

/**
 * Enqueue assets for Elementor editor
 */
function elearnpro_enqueue_editor_assets() {
    wp_enqueue_style('elearnpro-widget-css');
    wp_enqueue_script('elearnpro-widget-js');
}
add_action('elementor/editor/after_enqueue_scripts', 'elearnpro_enqueue_editor_assets');