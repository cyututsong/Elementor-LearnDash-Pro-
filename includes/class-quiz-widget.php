<?php
/**
 * ElemLearnPro - Quiz Widget Class with Direct Quiz Taking
 * 
 * @package ElemLearnPro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ElemLearnPro_Quiz_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'elemlearnpro_quiz_display';
    }

    public function get_title() {
        return esc_html__( 'LD Quiz Display & Take', 'elearnpro' );
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return [ 'elemlearnpro' ];
    }

    public function get_keywords() {
        return [ 'learndash', 'quiz', 'questions', 'lms', 'elemlearnpro', 'test', 'exam', 'take quiz' ];
    }

    protected function register_controls() {

        // ========== CONTENT TAB ==========
        
        // Quiz Selection
        $this->start_controls_section(
            'quiz_selection_section',
            [
                'label' => esc_html__( 'Quiz Selection', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'quiz_id_method',
            [
                'label' => esc_html__( 'Select Quiz Method', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'auto_detect' => esc_html__( 'Auto Detect from Lesson', 'elearnpro' ),
                    'specific_quiz' => esc_html__( 'Enter Specific Quiz ID', 'elearnpro' ),
                ],
                'default' => 'auto_detect',
                'description' => esc_html__( 'Auto Detect: Automatically shows the quiz associated with the current lesson.', 'elearnpro' ),
            ]
        );

        $this->add_control(
            'specific_quiz_id',
            [
                'label' => esc_html__( 'Quiz ID', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => esc_html__( 'Enter the ID of the quiz you want to display.', 'elearnpro' ),
                'condition' => [
                    'quiz_id_method' => 'specific_quiz',
                ],
            ]
        );

        $this->end_controls_section();

        // Quiz Display Settings
        $this->start_controls_section(
            'display_settings_section',
            [
                'label' => esc_html__( 'Quiz Display Settings', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_quiz_title',
            [
                'label' => esc_html__( 'Show Quiz Title', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_quiz_description',
            [
                'label' => esc_html__( 'Show Quiz Description', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_quiz_info',
            [
                'label' => esc_html__( 'Show Quiz Info (Questions, Points, etc.)', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'start_button_text',
            [
                'label' => esc_html__( 'Start Quiz Button Text', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Start Quiz', 'elearnpro' ),
            ]
        );

        $this->add_control(
            'auto_start',
            [
                'label' => esc_html__( 'Auto Start Quiz', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__( 'Automatically start the quiz without showing the intro.', 'elearnpro' ),
            ]
        );

        $this->end_controls_section();

        // Message Settings
        $this->start_controls_section(
            'message_settings_section',
            [
                'label' => esc_html__( 'Message Settings', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'no_quiz_message',
            [
                'label' => esc_html__( 'No Quiz Found Message', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'No quiz is associated with this lesson.', 'elearnpro' ),
            ]
        );

        $this->add_control(
            'quiz_completed_message',
            [
                'label' => esc_html__( 'Quiz Completed Message', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'You have already completed this quiz.', 'elearnpro' ),
            ]
        );

        $this->end_controls_section();

        // ========== STYLE TAB ==========
        
        // Quiz Container Style
        $this->start_controls_section(
            'style_quiz_container_section',
            [
                'label' => esc_html__( 'Quiz Container', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'quiz_container_background',
            [
                'label' => esc_html__( 'Background Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-quiz-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'quiz_container_border',
                'selector' => '{{WRAPPER}} .elearnpro-quiz-wrapper',
            ]
        );

        $this->add_control(
            'quiz_container_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-quiz-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'quiz_container_padding',
            [
                'label' => esc_html__( 'Padding', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-quiz-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Quiz Title Style
        $this->start_controls_section(
            'style_quiz_title_section',
            [
                'label' => esc_html__( 'Quiz Title', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_quiz_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'quiz_title_color',
            [
                'label' => esc_html__( 'Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-quiz-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'quiz_title_typography',
                'selector' => '{{WRAPPER}} .elearnpro-quiz-title',
            ]
        );

        $this->end_controls_section();

        // Quiz Description Style
        $this->start_controls_section(
            'style_quiz_description_section',
            [
                'label' => esc_html__( 'Quiz Description', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_quiz_description' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'quiz_description_color',
            [
                'label' => esc_html__( 'Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-quiz-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'quiz_description_typography',
                'selector' => '{{WRAPPER}} .elearnpro-quiz-description',
            ]
        );

        $this->end_controls_section();

        // Quiz Info Box Style
        $this->start_controls_section(
            'style_quiz_info_section',
            [
                'label' => esc_html__( 'Quiz Info Box', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_quiz_info' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'quiz_info_background',
            [
                'label' => esc_html__( 'Background Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-quiz-info-box' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'quiz_info_text_color',
            [
                'label' => esc_html__( 'Text Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-quiz-info-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'quiz_info_typography',
                'selector' => '{{WRAPPER}} .elearnpro-quiz-info-item',
            ]
        );

        $this->end_controls_section();

        // Start Button Style
        $this->start_controls_section(
            'style_start_button_section',
            [
                'label' => esc_html__( 'Start Quiz Button', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'start_button_background',
            [
                'label' => esc_html__( 'Background Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-start-quiz' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'start_button_background_hover',
            [
                'label' => esc_html__( 'Background Color (Hover)', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-start-quiz:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'start_button_text_color',
            [
                'label' => esc_html__( 'Text Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-start-quiz' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'start_button_text_color_hover',
            [
                'label' => esc_html__( 'Text Color (Hover)', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-start-quiz:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'start_button_typography',
                'selector' => '{{WRAPPER}} .elearnpro-start-quiz',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'start_button_border',
                'selector' => '{{WRAPPER}} .elearnpro-start-quiz',
            ]
        );

        $this->add_control(
            'start_button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-start-quiz' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'start_button_padding',
            [
                'label' => esc_html__( 'Padding', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-start-quiz' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'start_button_margin',
            [
                'label' => esc_html__( 'Margin', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-start-quiz' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $quiz_id = null;
        
        // Get quiz ID based on selected method
        if ( $settings['quiz_id_method'] === 'auto_detect' ) {
            $quiz_id = $this->get_lesson_quiz();
        } elseif ( $settings['quiz_id_method'] === 'specific_quiz' && ! empty( $settings['specific_quiz_id'] ) ) {
            $quiz_id = intval( $settings['specific_quiz_id'] );
        }
        
        // If no quiz found, show message
        if ( ! $quiz_id || ! $this->is_valid_quiz( $quiz_id ) ) {
            echo '<div class="elearnpro-quiz-wrapper">';
            echo '<p>' . esc_html( $settings['no_quiz_message'] ) . '</p>';
            echo '</div>';
            return;
        }
        
        // Check if user has already completed the quiz
        $user_id = get_current_user_id();
        if ( $user_id && $this->is_quiz_completed( $user_id, $quiz_id ) ) {
            echo '<div class="elearnpro-quiz-wrapper">';
            echo '<div class="elearnpro-quiz-completed">';
            echo '<p>' . esc_html( $settings['quiz_completed_message'] ) . '</p>';
            $this->display_quiz_results( $user_id, $quiz_id );
            echo '</div>';
            echo '</div>';
            return;
        }
        
        // Display the embedded quiz
        $this->display_embedded_quiz( $quiz_id, $settings );
    }

    /**
     * Get quiz associated with the current lesson using multiple methods
     */
    private function get_lesson_quiz() {
        $post_type = get_post_type();
        
        // Only run on lesson pages
        if ( $post_type !== 'sfwd-lessons' ) {
            return null;
        }
        
        $lesson_id = get_the_ID();
        $course_id = learndash_get_course_id( $lesson_id );
        $found_quiz_id = null;
        
        // METHOD 1: Check lesson_quiz meta
        $quiz_meta = get_post_meta( $lesson_id, 'lesson_quiz', true );
        if ( ! empty( $quiz_meta ) && is_numeric( $quiz_meta ) ) {
            $found_quiz_id = intval( $quiz_meta );
        }
        
        // METHOD 2: Check ld_course_lesson_quiz meta
        if ( ! $found_quiz_id ) {
            $quiz_meta = get_post_meta( $lesson_id, 'ld_course_lesson_quiz', true );
            if ( ! empty( $quiz_meta ) && is_numeric( $quiz_meta ) ) {
                $found_quiz_id = intval( $quiz_meta );
            }
        }
        
        // METHOD 3: Use learndash_get_lesson_quiz function
        if ( ! $found_quiz_id && function_exists( 'learndash_get_lesson_quiz' ) ) {
            $quiz_id = learndash_get_lesson_quiz( $lesson_id );
            if ( $quiz_id && is_numeric( $quiz_id ) ) {
                $found_quiz_id = intval( $quiz_id );
            }
        }
        
        // METHOD 4: Check for quiz using course_step relationship
        if ( ! $found_quiz_id && function_exists( 'learndash_course_get_steps_by_type' ) && $course_id ) {
            $steps = learndash_course_get_steps_by_type( $course_id, 'sfwd-quiz' );
            if ( ! empty( $steps ) ) {
                foreach ( $steps as $step_id ) {
                    $step_lesson_id = get_post_meta( $step_id, 'lesson_id', true );
                    if ( $step_lesson_id == $lesson_id ) {
                        $found_quiz_id = $step_id;
                        break;
                    }
                }
            }
        }
        
        // METHOD 5: Get all quizzes in the course and find by lesson association
        if ( ! $found_quiz_id && $course_id && function_exists( 'learndash_get_quizzes_for_course' ) ) {
            $quizzes = learndash_get_quizzes_for_course( $course_id );
            
            if ( ! empty( $quizzes ) ) {
                foreach ( $quizzes as $quiz ) {
                    // Check all possible meta keys
                    $quiz_lesson_id = get_post_meta( $quiz->ID, 'lesson_id', true );
                    $quiz_lesson_id_alt = get_post_meta( $quiz->ID, 'ld_course_lesson_id', true );
                    
                    if ( $quiz_lesson_id == $lesson_id || $quiz_lesson_id_alt == $lesson_id ) {
                        $found_quiz_id = $quiz->ID;
                        break;
                    }
                }
                
                // If still not found and there's only one quiz, use it
                if ( ! $found_quiz_id && count( $quizzes ) === 1 ) {
                    $first_quiz = reset( $quizzes );
                    $found_quiz_id = $first_quiz->ID;
                }
            }
        }
        
        // METHOD 6: Check legacy settings
        if ( ! $found_quiz_id ) {
            $quiz_settings = get_post_meta( $lesson_id, '_sfwd-lessons', true );
            if ( is_array( $quiz_settings ) && isset( $quiz_settings['sfwd-lessons_lesson_quiz'] ) ) {
                $found_quiz_id = intval( $quiz_settings['sfwd-lessons_lesson_quiz'] );
            }
        }
        
        return $found_quiz_id;
    }

    /**
     * Check if quiz is valid
     */
    private function is_valid_quiz( $quiz_id ) {
        $quiz = get_post( $quiz_id );
        return $quiz && $quiz->post_type === 'sfwd-quiz' && $quiz->post_status === 'publish';
    }

    /**
     * Check if user has completed the quiz
     */
    private function is_quiz_completed( $user_id, $quiz_id ) {
        if ( function_exists( 'learndash_is_quiz_complete' ) ) {
            return learndash_is_quiz_complete( $user_id, $quiz_id );
        }
        return false;
    }

    /**
     * Display quiz results for completed quiz
     */
    private function display_quiz_results( $user_id, $quiz_id ) {
        if ( function_exists( 'learndash_quiz_result_shortcode' ) ) {
            echo do_shortcode( '[ld_quiz_result quiz_id="' . $quiz_id . '" user_id="' . $user_id . '"]' );
        } else {
            global $wpdb;
            $attempt = $wpdb->get_row( $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}learndash_pro_quiz_attempts 
                WHERE quiz_id = %d AND user_id = %d 
                ORDER BY attempt_id DESC LIMIT 1",
                $quiz_id, $user_id
            ) );
            
            if ( $attempt ) {
                $score = $attempt->points_scored;
                $total = $attempt->max_points;
                $percentage = $total > 0 ? round( ( $score / $total ) * 100, 2 ) : 0;
                ?>
                <div class="elearnpro-quiz-results">
                    <h4><?php esc_html_e( 'Your Results', 'elearnpro' ); ?></h4>
                    <p><?php echo esc_html( $score ); ?> / <?php echo esc_html( $total ); ?> (<?php echo esc_html( $percentage ); ?>%)</p>
                </div>
                <?php
            }
        }
    }

    /**
     * Display embedded quiz using LearnDash's shortcode
     */
    private function display_embedded_quiz( $quiz_id, $settings ) {
        $quiz = get_post( $quiz_id );
        
        // Get quiz info
        $question_count = learndash_get_quiz_questions( $quiz_id );
        $question_count = is_array( $question_count ) ? count( $question_count ) : 0;
        $passing_score = get_post_meta( $quiz_id, 'passingpercentage', true );
        
        ?>
        <div class="elearnpro-quiz-wrapper">
            
            <!-- Quiz Intro Section -->
            <div class="elearnpro-quiz-intro" id="elearnpro-quiz-intro-<?php echo esc_attr( $quiz_id ); ?>">
                <?php if ( $settings['show_quiz_title'] === 'yes' ) : ?>
                    <h3 class="elearnpro-quiz-title"><?php echo esc_html( $quiz->post_title ); ?></h3>
                <?php endif; ?>
                
                <?php if ( $settings['show_quiz_description'] === 'yes' && ! empty( $quiz->post_excerpt ) ) : ?>
                    <div class="elearnpro-quiz-description"><?php echo wp_kses_post( $quiz->post_excerpt ); ?></div>
                <?php endif; ?>
                
                <?php if ( $settings['show_quiz_info'] === 'yes' ) : ?>
                    <div class="elearnpro-quiz-info-box">
                        <div class="elearnpro-quiz-info-item">
                            <span class="elearnpro-quiz-info-icon">📋</span>
                            <span><?php echo esc_html( $question_count ); ?> <?php esc_html_e( 'Questions', 'elearnpro' ); ?></span>
                        </div>
                        <?php if ( ! empty( $passing_score ) ) : ?>
                            <div class="elearnpro-quiz-info-item">
                                <span class="elearnpro-quiz-info-icon">🎯</span>
                                <span><?php esc_html_e( 'Passing Score:', 'elearnpro' ); ?> <?php echo esc_html( $passing_score ); ?>%</span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $settings['auto_start'] !== 'yes' ) : ?>
                    <button class="elearnpro-start-quiz" data-quiz-id="<?php echo esc_attr( $quiz_id ); ?>">
                        <?php echo esc_html( $settings['start_button_text'] ); ?>
                    </button>
                <?php endif; ?>
            </div>
            
            <!-- Quiz Content Section (hidden until start) -->
            <div class="elearnpro-quiz-content" id="elearnpro-quiz-content-<?php echo esc_attr( $quiz_id ); ?>" style="display: none;">
                <?php 
                echo do_shortcode( '[ld_quiz quiz_id="' . $quiz_id . '"]' );
                ?>
            </div>
            
        </div>
        
        <?php if ( $settings['auto_start'] === 'yes' ) : ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var quizContent = document.getElementById('elearnpro-quiz-content-<?php echo esc_attr( $quiz_id ); ?>');
                    var quizIntro = document.getElementById('elearnpro-quiz-intro-<?php echo esc_attr( $quiz_id ); ?>');
                    if (quizContent && quizIntro) {
                        quizContent.style.display = 'block';
                        quizIntro.style.display = 'none';
                    }
                });
            </script>
        <?php endif; ?>
        
        <script>
            (function() {
                var startButton = document.querySelector('.elearnpro-start-quiz[data-quiz-id="<?php echo esc_attr( $quiz_id ); ?>"]');
                if (startButton) {
                    startButton.addEventListener('click', function() {
                        var quizId = this.getAttribute('data-quiz-id');
                        var quizContent = document.getElementById('elearnpro-quiz-content-' + quizId);
                        var quizIntro = document.getElementById('elearnpro-quiz-intro-' + quizId);
                        
                        if (quizContent && quizIntro) {
                            quizContent.style.display = 'block';
                            quizIntro.style.display = 'none';
                            quizContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    });
                }
            })();
        </script>
        
        <style>
            .elearnpro-quiz-wrapper {
                margin: 20px 0;
                padding: 20px;
                background: #fff;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
            }
            
            .elearnpro-quiz-title {
                margin-top: 0;
                margin-bottom: 15px;
                font-size: 24px;
            }
            
            .elearnpro-quiz-description {
                margin-bottom: 20px;
                color: #666;
            }
            
            .elearnpro-quiz-info-box {
                display: flex;
                gap: 20px;
                margin-bottom: 25px;
                padding: 15px;
                background: #f5f5f5;
                border-radius: 5px;
                flex-wrap: wrap;
            }
            
            .elearnpro-quiz-info-item {
                display: flex;
                align-items: center;
                gap: 8px;
            }
            
            .elearnpro-quiz-info-icon {
                font-size: 18px;
            }
            
            .elearnpro-start-quiz {
                display: inline-block;
                padding: 12px 30px;
                background: #0073aa;
                color: #fff;
                border: none;
                border-radius: 4px;
                font-size: 16px;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .elearnpro-start-quiz:hover {
                background: #005a87;
            }
            
            .elearnpro-quiz-completed {
                text-align: center;
                padding: 20px;
            }
            
            .elearnpro-quiz-results {
                margin-top: 15px;
                padding: 15px;
                background: #e8f0fe;
                border-radius: 5px;
            }
        </style>
        <?php
    }
}