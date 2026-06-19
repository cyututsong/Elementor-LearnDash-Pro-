<?php
/**
 * Elementor Widget: LearnDash Mark Complete Button with Click Alert (CLEAN VERSION)
 * Gets passing percentage from _sfwd-quiz meta (sfwd-quiz_passingpercentage)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ElemLearnPro_Mark_Complete_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'elemlearnpro_mark_complete';
    }

    public function get_title() {
        return esc_html__( 'LearnDash Mark Complete', 'elearnpro' );
    }

    public function get_icon() {
        return 'eicon-check-circle';
    }

    public function get_categories() {
        return [ 'elemlearnpro' ];
    }

    public function get_keywords() {
        return [ 'learndash', 'mark complete', 'complete button', 'lesson', 'topic', 'course', 'quiz' ];
    }

    public function get_style_depends() {
        return [ 'elearnpro-widget-css' ];
    }

    public function get_script_depends() {
        return [ 'elearnpro-widget-js' ];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Button Content', 'elearnpro'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('button_text', [
            'label' => esc_html__('Button Text', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Mark Complete', 'elearnpro'),
        ]);

        $this->add_control('completed_text', [
            'label' => esc_html__('Completed Message', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('✓ Lesson Completed', 'elearnpro'),
        ]);

        $this->add_control('show_icon', [
            'label' => esc_html__('Show Checkmark Icon', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('step_id', [
            'label' => esc_html__('Specific Lesson/Topic ID', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
        ]);

        $this->end_controls_section();

        // Alert Settings
        $this->start_controls_section('alert_settings_section', [
            'label' => esc_html__('Floating Alert Settings', 'elearnpro'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('enable_quiz_alert', [
            'label' => esc_html__('Enable Quiz Alert', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('quiz_required_message', [
            'label' => esc_html__('Quiz Required Message', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => '⚠️ You must complete and pass the quiz before marking this lesson as complete.',
            'condition' => ['enable_quiz_alert' => 'yes'],
        ]);

        $this->add_control('quiz_failed_message', [
            'label' => esc_html__('Quiz Failed Message', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => '❌ You did not pass the quiz. Please review and retake before marking complete.',
            'condition' => ['enable_quiz_alert' => 'yes'],
        ]);

        $this->add_control('alert_duration', [
            'label' => esc_html__('Alert Duration (seconds)', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 4,
            'min' => 1,
            'max' => 15,
            'condition' => ['enable_quiz_alert' => 'yes'],
        ]);

        $this->add_control('alert_position', [
            'label' => esc_html__('Alert Position', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'top-center',
            'options' => [
                'top-left' => 'Top Left',
                'top-center' => 'Top Center',
                'top-right' => 'Top Right',
                'bottom-left' => 'Bottom Left',
                'bottom-center' => 'Bottom Center',
                'bottom-right' => 'Bottom Right',
            ],
            'condition' => ['enable_quiz_alert' => 'yes'],
        ]);

        $this->end_controls_section();

        // Button Style
        $this->start_controls_section('style_section', [
            'label' => esc_html__('Button Style', 'elearnpro'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('button_bg_color', [
            'label' => esc_html__('Background Color', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#4CAF50',
            'selectors' => ['{{WRAPPER}} .learndash_mark_complete_button' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('button_text_color', [
            'label' => esc_html__('Text Color', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .learndash_mark_complete_button' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), [
            'name' => 'button_typography',
            'selector' => '{{WRAPPER}} .learndash_mark_complete_button',
        ]);

        $this->add_control('button_padding', [
            'label' => esc_html__('Padding', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem'],
            'selectors' => ['{{WRAPPER}} .learndash_mark_complete_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->add_control('button_radius', [
            'label' => esc_html__('Border Radius', 'elearnpro'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => ['{{WRAPPER}} .learndash_mark_complete_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

        // Completed Message Style
        $this->start_controls_section('completed_style_section', [
            'label' => esc_html__('Completed Message Style', 'elearnpro'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('completed_bg_color', [
            'label' => 'Background Color',
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#d4edda',
            'selectors' => ['{{WRAPPER}} .elearnpro-completed-message' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('completed_text_color', [
            'label' => 'Text Color',
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#155724',
            'selectors' => ['{{WRAPPER}} .elearnpro-completed-message' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('completed_padding', [
            'label' => 'Padding',
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem'],
            'default' => ['top' => '12', 'right' => '20', 'bottom' => '12', 'left' => '20', 'unit' => 'px'],
            'selectors' => ['{{WRAPPER}} .elearnpro-completed-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->end_controls_section();
    }

    private function get_quiz_passing_percentage($quiz_id) {
        $sfwd_quiz = get_post_meta($quiz_id, '_sfwd-quiz', true);
        
        if (!empty($sfwd_quiz) && is_array($sfwd_quiz) && isset($sfwd_quiz['sfwd-quiz_passingpercentage'])) {
            return (float) $sfwd_quiz['sfwd-quiz_passingpercentage'];
        }
        
        $ld_settings = learndash_get_setting($quiz_id);
        if (!empty($ld_settings['passing_grade'])) {
            return (float) $ld_settings['passing_grade'];
        }
        
        return 80;
    }

    private function is_quiz_passed($user_id, $quiz_id, $course_id = 0) {
        $passing_percentage = $this->get_quiz_passing_percentage($quiz_id);
        
        $quiz_meta = get_user_meta($user_id, '_sfwd-quizzes', true);
        
        if (empty($quiz_meta) || !is_array($quiz_meta)) {
            return false;
        }
        
        $quiz_meta = array_reverse($quiz_meta);
        
        foreach ($quiz_meta as $attempt) {
            $qid = is_object($attempt) ? ($attempt->quiz ?? null) : ($attempt['quiz'] ?? null);
            
            if ($qid == $quiz_id) {
                $percentage = is_object($attempt) ? ($attempt->percentage ?? 0) : ($attempt['percentage'] ?? 0);
                
                if ($percentage == 0) {
                    $points = is_object($attempt) ? ($attempt->points ?? 0) : ($attempt['points'] ?? 0);
                    $total_points = is_object($attempt) ? ($attempt->total_points ?? 5) : ($attempt['total_points'] ?? 5);
                    if ($total_points > 0) {
                        $percentage = ($points / $total_points) * 100;
                    }
                }
                
                return (float)$percentage >= (float)$passing_percentage;
            }
        }
        
        return false;
    }

    private function check_quiz_requirements($step_id, $user_id) {
        $quiz_status = [
            'has_quizzes' => false,
            'quizzes_completed' => false,
            'quizzes_passed' => false,
            'required_quizzes' => [],
            'all_requirements_met' => false,
            'debug' => []
        ];
        
        if (!$user_id || !$step_id) return $quiz_status;
        
        $course_id = learndash_get_course_id($step_id);
        $post_type = get_post_type($step_id);
        
        $quizzes_to_check = [];
        if ($post_type === 'sfwd-lessons') {
            $quizzes_to_check = learndash_get_lesson_quiz_list($step_id, $user_id);
        } elseif ($post_type === 'sfwd-topics') {
            $quizzes_to_check = learndash_get_topic_quiz_list($step_id, $user_id);
        }
        
        if (!empty($quizzes_to_check)) {
            $quiz_status['has_quizzes'] = true;
            
            foreach ($quizzes_to_check as $quiz_data) {
                $quiz_id = $quiz_data['post']->ID;
                $quiz_status['required_quizzes'][] = $quiz_id;
                
                $quiz_passed = $this->is_quiz_passed($user_id, $quiz_id, $course_id);
                
                if (!$quiz_passed) {
                    $quiz_status['quizzes_passed'] = false;
                    $quiz_status['all_requirements_met'] = false;
                    return $quiz_status;
                }
            }
            
            $quiz_status['quizzes_completed'] = true;
            $quiz_status['quizzes_passed'] = true;
            $quiz_status['all_requirements_met'] = true;
        } else {
            $quiz_status['all_requirements_met'] = true;
        }
        
        return $quiz_status;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $step_id = !empty($settings['step_id']) ? intval($settings['step_id']) : get_queried_object_id();
        
        if (!$step_id) {
            echo '<div class="elearnpro-warning">No lesson or topic found.</div>';
            return;
        }
        
        $post_type = get_post_type($step_id);
        if (!in_array($post_type, ['sfwd-lessons', 'sfwd-topics'])) {
            echo '<div class="elearnpro-warning">This widget only works on LearnDash lessons or topics.</div>';
            return;
        }
        
        if (!is_user_logged_in()) {
            echo '<div class="elearnpro-warning">Please log in to mark this content as complete.</div>';
            return;
        }
        
        $user_id = get_current_user_id();
        
        if (function_exists('learndash_is_item_complete') && learndash_is_item_complete($step_id, $user_id)) {
            $completed_text = !empty($settings['completed_text']) ? $settings['completed_text'] : '✓ Lesson Completed';
            echo '<div class="elearnpro-completed-message">';
            if ($settings['show_icon'] === 'yes') echo '<span class="completed-icon">✓ </span>';
            echo '<span class="completed-text">' . esc_html($completed_text) . '</span>';
            echo '</div>';
            return;
        }
        
        if (function_exists('learndash_is_previous_complete') && !learndash_is_previous_complete($step_id)) {
            echo '<div class="elearnpro-warning">Please complete the previous steps before marking this as complete.</div>';
            return;
        }
        
        $current_user = wp_get_current_user();
        $course_id = learndash_get_course_id($step_id);
        
        $quiz_status = $this->check_quiz_requirements($step_id, $user_id);
        
        $quiz_status['step_id'] = $step_id;
        $quiz_status['post_type'] = $post_type;
        $quiz_status['user_info'] = [
            'id' => $user_id,
            'email' => $current_user->user_email,
            'display_name' => $current_user->display_name,
            'username' => $current_user->user_login,
            'roles' => $current_user->roles
        ];
        $quiz_status['course_id'] = $course_id;
        
        $button_text = !empty($settings['button_text']) ? $settings['button_text'] : 'Mark Complete';
        $nonce = wp_create_nonce('learndash_mark_complete_' . $step_id);
        
        ?>
        <div class="elearnpro-mark-complete-wrapper">
            <button type="button" class="learndash_mark_complete_button elearnpro-validate-button" 
                    data-step-id="<?php echo esc_attr($step_id); ?>"
                    data-nonce="<?php echo esc_attr($nonce); ?>"
                    data-quiz-status="<?php echo esc_attr(json_encode($quiz_status)); ?>"
                    data-post-type="<?php echo esc_attr($post_type); ?>"
                    data-button-text="<?php echo esc_attr($button_text); ?>"
                    data-enable-alert="<?php echo esc_attr($settings['enable_quiz_alert']); ?>"
                    data-quiz-required-msg="<?php echo esc_attr($settings['quiz_required_message']); ?>"
                    data-quiz-failed-msg="<?php echo esc_attr($settings['quiz_failed_message']); ?>"
                    data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
                <?php echo esc_html($button_text); ?>
            </button>
        </div>
        <?php if ($settings['enable_quiz_alert'] === 'yes') : ?>
        <div id="elearnpro-floating-alert-container" 
             data-position="<?php echo esc_attr($settings['alert_position']); ?>"
             data-duration="<?php echo intval($settings['alert_duration']) * 1000; ?>">
        </div>
        <?php endif; ?>
        <?php
    }

    protected function content_template() {
        ?>
        <# var button_text = settings.button_text || 'Mark Complete'; #>
        <div class="elearnpro-mark-complete-wrapper">
            <div class="learndash_mark_complete_button" style="display:inline-block;padding:12px 20px;cursor:pointer;background-color:#4CAF50;color:#fff;border:none;border-radius:4px;">
                {{ button_text }}
            </div>
        </div>
        <?php
    }
}

// AJAX handler with server-side validation
add_action('wp_ajax_elearnpro_mark_complete', 'elearnpro_ajax_mark_complete');
function elearnpro_ajax_mark_complete() {
    if (!isset($_POST['nonce']) || !isset($_POST['step_id'])) {
        wp_send_json_error(['message' => 'Missing required parameters']);
    }
    
    $step_id = intval($_POST['step_id']);
    $nonce = sanitize_text_field($_POST['nonce']);
    $user_id = get_current_user_id();
    
    if (!wp_verify_nonce($nonce, 'learndash_mark_complete_' . $step_id)) {
        wp_send_json_error(['message' => 'Security check failed']);
    }
    
    if (!$user_id) {
        wp_send_json_error(['message' => 'You must be logged in']);
    }
    
    $course_id = learndash_get_course_id($step_id);
    
    if (learndash_is_item_complete($step_id, $user_id)) {
        wp_send_json_success(['message' => 'Already completed']);
    }
    
    $validation = validate_quiz_requirements($step_id, $user_id, $course_id);
    
    if (!$validation['can_complete']) {
        wp_send_json_error([
            'message' => $validation['message'],
            'quiz_status' => $validation
        ]);
    }
    
    $success = learndash_process_mark_complete($user_id, $step_id, false, $course_id);
    
    if ($success) {
        wp_send_json_success(['message' => 'Marked complete']);
    } else {
        wp_send_json_error(['message' => 'Could not mark complete.']);
    }
}

function validate_quiz_requirements($step_id, $user_id, $course_id) {
    $result = [
        'can_complete' => true,
        'message' => '',
        'has_quizzes' => false,
        'quizzes_passed' => false,
        'required_quizzes' => [],
        'quiz_details' => []
    ];
    
    $post_type = get_post_type($step_id);
    $quizzes_to_check = [];
    
    if ($post_type === 'sfwd-lessons') {
        $quizzes_to_check = learndash_get_lesson_quiz_list($step_id, $user_id);
    } elseif ($post_type === 'sfwd-topics') {
        $quizzes_to_check = learndash_get_topic_quiz_list($step_id, $user_id);
    }
    
    if (empty($quizzes_to_check)) {
        return $result;
    }
    
    $result['has_quizzes'] = true;
    $all_passed = true;
    
    foreach ($quizzes_to_check as $quiz_data) {
        $quiz_id = $quiz_data['post']->ID;
        $result['required_quizzes'][] = $quiz_id;
        
        $quiz_detail = [
            'quiz_id' => $quiz_id,
            'quiz_title' => $quiz_data['post']->post_title,
            'passed' => false
        ];
        
        $sfwd_quiz = get_post_meta($quiz_id, '_sfwd-quiz', true);
        $passing_pct = 80;
        if (is_array($sfwd_quiz) && isset($sfwd_quiz['sfwd-quiz_passingpercentage'])) {
            $passing_pct = (float) $sfwd_quiz['sfwd-quiz_passingpercentage'];
        }
        
        $quiz_meta = get_user_meta($user_id, '_sfwd-quizzes', true);
        $is_passed = false;
        
        if (!empty($quiz_meta) && is_array($quiz_meta)) {
            $quiz_meta = array_reverse($quiz_meta);
            foreach ($quiz_meta as $attempt) {
                $qid = is_object($attempt) ? ($attempt->quiz ?? null) : ($attempt['quiz'] ?? null);
                if ($qid == $quiz_id) {
                    $percentage = is_object($attempt) ? ($attempt->percentage ?? 0) : ($attempt['percentage'] ?? 0);
                    $is_passed = (float)$percentage >= (float)$passing_pct;
                    break;
                }
            }
        }
        
        $quiz_detail['passed'] = $is_passed;
        
        if (!$is_passed) {
            $all_passed = false;
        }
        
        $result['quiz_details'][] = $quiz_detail;
    }
    
    $result['quizzes_passed'] = $all_passed;
    
    if (!$all_passed) {
        $result['can_complete'] = false;
        $result['message'] = 'You must pass all required quizzes before marking this lesson as complete. Please review and retake the quiz.';
    }
    
    return $result;
}