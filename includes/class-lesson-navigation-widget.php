<?php
/**
 * ElemLearnPro - Lesson Navigation Widget Class
 * 
 * @package ElemLearnPro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ElemLearnPro_Lesson_Navigation_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'elemlearnpro_lesson_navigation';
    }

    public function get_title() {
        return esc_html__( 'LD Lesson Navigator Pro', 'elearnpro' );
    }

    public function get_icon() {
        return 'eicon-post-navigation';
    }

    public function get_categories() {
        return [ 'elemlearnpro' ];
    }

    public function get_keywords() {
        return [ 'learndash', 'lesson', 'navigation', 'course', 'lms', 'elemlearnpro', 'courses', 'enrolled', 'hierarchy' ];
    }

    protected function register_controls() {

        // ========== CONTENT TAB ==========
        
        // Display Type Selection
        $this->start_controls_section(
            'display_type_section',
            [
                'label' => esc_html__( 'Display Type', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'display_mode',
            [
                'label' => esc_html__( 'What to Display', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'current_lesson' => esc_html__( 'Current Lesson Navigation', 'elearnpro' ),
                    'all_courses' => esc_html__( 'All Courses', 'elearnpro' ),
                    'all_lessons' => esc_html__( 'All Lessons', 'elearnpro' ),
                    'course_hierarchy' => esc_html__( 'Course Hierarchy (Course + Lessons)', 'elearnpro' ),
                ],
                'default' => 'current_lesson',
            ]
        );

        $this->add_control(
            'enrollment_filter',
            [
                'label' => esc_html__( 'Enrollment Filter', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'all' => esc_html__( 'Show All', 'elearnpro' ),
                    'enrolled_only' => esc_html__( 'Show Only Enrolled', 'elearnpro' ),
                ],
                'default' => 'all',
                'condition' => [
                    'display_mode' => [ 'all_courses', 'all_lessons', 'course_hierarchy' ],
                ],
                'description' => esc_html__( 'For "Course Hierarchy", this shows only courses the user is enrolled in.', 'elearnpro' ),
            ]
        );

        $this->add_control(
            'show_enrolled_badge',
            [
                'label' => esc_html__( 'Show "Enrolled" Badge', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elearnpro' ),
                'label_off' => esc_html__( 'Hide', 'elearnpro' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'display_mode' => [ 'all_courses', 'all_lessons', 'course_hierarchy' ],
                ],
            ]
        );

        $this->end_controls_section();

        // Course Hierarchy Settings - NEW
        $this->start_controls_section(
            'hierarchy_settings_section',
            [
                'label' => esc_html__( 'Course Hierarchy Settings', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'display_mode' => 'course_hierarchy',
                ],
            ]
        );

        $this->add_control(
            'hierarchy_title',
            [
                'label' => esc_html__( 'Hierarchy Title', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Course Curriculum', 'elearnpro' ),
            ]
        );

        $this->add_control(
            'expand_all_by_default',
            [
                'label' => esc_html__( 'Expand All Courses by Default', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'elearnpro' ),
                'label_off' => esc_html__( 'No', 'elearnpro' ),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__( 'If disabled, courses will be collapsed and users can click to expand.', 'elearnpro' ),
            ]
        );

        $this->add_control(
            'show_lesson_count',
            [
                'label' => esc_html__( 'Show Lesson Count', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_completion_percentage',
            [
                'label' => esc_html__( 'Show Completion Percentage', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__( 'Shows progress percentage for enrolled courses.', 'elearnpro' ),
            ]
        );

        $this->end_controls_section();

        // Navigation Settings Section (only for current lesson mode)
        $this->start_controls_section(
            'nav_settings_section',
            [
                'label' => esc_html__( 'Navigation Settings', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'display_mode' => 'current_lesson',
                ],
            ]
        );

        $this->add_control(
            'show_prev_next',
            [
                'label' => esc_html__( 'Show Previous/Next Buttons', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elearnpro' ),
                'label_off' => esc_html__( 'Hide', 'elearnpro' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'prev_label',
            [
                'label' => esc_html__( 'Previous Button Label', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => get_option( 'elearnpro_prev_label', '← Previous Lesson' ),
                'condition' => [
                    'show_prev_next' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'next_label',
            [
                'label' => esc_html__( 'Next Button Label', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => get_option( 'elearnpro_next_label', 'Next Lesson →' ),
                'condition' => [
                    'show_prev_next' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_sibling_list',
            [
                'label' => esc_html__( 'Show Sibling Lesson List', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elearnpro' ),
                'label_off' => esc_html__( 'Hide', 'elearnpro' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'sibling_title',
            [
                'label' => esc_html__( 'Lesson List Title', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Course Lessons', 'elearnpro' ),
                'condition' => [
                    'show_sibling_list' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_completion_status',
            [
                'label' => esc_html__( 'Show Completion Status (✓)', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elearnpro' ),
                'label_off' => esc_html__( 'Hide', 'elearnpro' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_sibling_list' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Courses/Lessons Display Settings
        $this->start_controls_section(
            'list_display_section',
            [
                'label' => esc_html__( 'List Display Settings', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'display_mode' => [ 'all_courses', 'all_lessons' ],
                ],
            ]
        );

        $this->add_control(
            'list_title',
            [
                'label' => esc_html__( 'List Title', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Available Courses', 'elearnpro' ),
                'condition' => [
                    'display_mode' => 'all_courses',
                ],
            ]
        );

        $this->add_control(
            'lesson_list_title',
            [
                'label' => esc_html__( 'List Title', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'All Lessons', 'elearnpro' ),
                'condition' => [
                    'display_mode' => 'all_lessons',
                ],
            ]
        );

        $this->add_control(
            'show_course_category',
            [
                'label' => esc_html__( 'Show Course Category', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'display_mode' => 'all_courses',
                ],
            ]
        );

        $this->add_control(
            'show_lesson_course',
            [
                'label' => esc_html__( 'Show Parent Course Name', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'display_mode' => 'all_lessons',
                ],
            ]
        );

        $this->end_controls_section();

        // Advanced Settings Section
        $this->start_controls_section(
            'advanced_settings_section',
            [
                'label' => esc_html__( 'Advanced Settings', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'open_links_in_same_tab',
            [
                'label' => esc_html__( 'Open Links In', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '_self' => esc_html__( 'Same Tab', 'elearnpro' ),
                    '_blank' => esc_html__( 'New Tab', 'elearnpro' ),
                ],
                'default' => '_self',
            ]
        );

        $this->add_control(
            'exclude_current_from_list',
            [
                'label' => esc_html__( 'Exclude Current Lesson from List', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'display_mode' => 'current_lesson',
                    'show_sibling_list' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE TAB ==========
        
        // Container Style
        $this->start_controls_section(
            'style_container_section',
            [
                'label' => esc_html__( 'Container', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'container_background',
            [
                'label' => esc_html__( 'Background Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-container' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'selector' => '{{WRAPPER}} .elearnpro-container',
            ]
        );

        $this->add_control(
            'container_padding',
            [
                'label' => esc_html__( 'Padding', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'container_margin',
            [
                'label' => esc_html__( 'Margin', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Section Title Style
        $this->start_controls_section(
            'style_section_title_section',
            [
                'label' => esc_html__( 'Section Title', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'section_title_color',
            [
                'label' => esc_html__( 'Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-section-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'section_title_typography',
                'selector' => '{{WRAPPER}} .elearnpro-section-title',
            ]
        );

        $this->add_control(
            'section_title_margin',
            [
                'label' => esc_html__( 'Margin', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

// Course Item Style (for hierarchy view)
$this->start_controls_section(
    'style_course_item_section',
    [
        'label' => esc_html__( 'Course Items (Hierarchy)', 'elearnpro' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'display_mode' => 'course_hierarchy',
        ],
    ]
);

// Course Header Styles
$this->add_control(
    'course_header_background',
    [
        'label' => esc_html__( 'Course Header Background', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-course-header' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'course_header_background_hover',
    [
        'label' => esc_html__( 'Course Header Background (Hover)', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-course-header:hover' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'course_header_color',
    [
        'label' => esc_html__( 'Course Title Color', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-course-header strong' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'course_title_typography',
        'label' => esc_html__( 'Course Title Typography', 'elearnpro' ),
        'selector' => '{{WRAPPER}} .elearnpro-course-header strong',
    ]
);

$this->add_control(
    'course_header_padding',
    [
        'label' => esc_html__( 'Course Header Padding', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-course-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Lesson Items Section
$this->add_control(
    'lesson_item_heading',
    [
        'label' => esc_html__( 'Lesson Items', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

// Lesson Typography - NEW
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'lesson_typography',
        'label' => esc_html__( 'Lesson Typography', 'elearnpro' ),
        'selector' => '{{WRAPPER}} .elearnpro-lesson-link',
    ]
);

$this->add_control(
    'lesson_background',
    [
        'label' => esc_html__( 'Lesson Background', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-lesson-item' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'lesson_background_hover',
    [
        'label' => esc_html__( 'Lesson Background (Hover)', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-lesson-item:hover' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'lesson_item_color',
    [
        'label' => esc_html__( 'Lesson Link Color', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-lesson-link' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'lesson_item_hover_color',
    [
        'label' => esc_html__( 'Lesson Link Hover Color', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-lesson-link:hover' => 'color: {{VALUE}};',
        ],
    ]
);

// Lesson Spacing
$this->add_control(
    'lesson_padding',
    [
        'label' => esc_html__( 'Lesson Padding', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .elearnpro-lesson-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'lesson_margin',
    [
        'label' => esc_html__( 'Lesson Margin', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .elearnpro-lesson-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Current Lesson (Active) Styles
$this->add_control(
    'current_lesson_heading',
    [
        'label' => esc_html__( 'Current Lesson (Active)', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

// Current Lesson Typography - NEW
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'current_lesson_typography',
        'label' => esc_html__( 'Current Lesson Typography', 'elearnpro' ),
        'selector' => '{{WRAPPER}} .elearnpro-current-lesson .elearnpro-lesson-link',
    ]
);

$this->add_control(
    'current_lesson_background',
    [
        'label' => esc_html__( 'Current Lesson Background', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-current-lesson' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'current_lesson_text_color',
    [
        'label' => esc_html__( 'Current Lesson Text Color', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-current-lesson .elearnpro-lesson-link' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'current_lesson_padding',
    [
        'label' => esc_html__( 'Current Lesson Padding', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .elearnpro-current-lesson' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'current_lesson_border',
        'label' => esc_html__( 'Current Lesson Border', 'elearnpro' ),
        'selector' => '{{WRAPPER}} .elearnpro-current-lesson',
    ]
);

$this->add_control(
    'current_lesson_border_radius',
    [
        'label' => esc_html__( 'Current Lesson Border Radius', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
            '{{WRAPPER}} .elearnpro-current-lesson' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Completed Lesson Styles
$this->add_control(
    'completed_lesson_heading',
    [
        'label' => esc_html__( 'Completed Lesson', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

// Completed Lesson Typography - NEW
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'completed_lesson_typography',
        'label' => esc_html__( 'Completed Lesson Typography', 'elearnpro' ),
        'selector' => '{{WRAPPER}} .elearnpro-lesson-completed .elearnpro-lesson-link',
    ]
);

$this->add_control(
    'completed_lesson_color',
    [
        'label' => esc_html__( 'Completed Lesson Text Color', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-lesson-completed .elearnpro-lesson-link' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'completed_lesson_background',
    [
        'label' => esc_html__( 'Completed Lesson Background', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-lesson-completed' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'checkmark_color',
    [
        'label' => esc_html__( 'Checkmark Color', 'elearnpro' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .elearnpro-checkmark' => 'color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();


        // Navigation Buttons Style
        $this->start_controls_section(
            'style_buttons_section',
            [
                'label' => esc_html__( 'Navigation Buttons', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_mode' => 'current_lesson',
                    'show_prev_next' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_display',
            [
                'label' => esc_html__( 'Layout', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'space-between' => esc_html__( 'Space Between', 'elearnpro' ),
                    'center' => esc_html__( 'Center', 'elearnpro' ),
                    'flex-start' => esc_html__( 'Left', 'elearnpro' ),
                    'flex-end' => esc_html__( 'Right', 'elearnpro' ),
                ],
                'default' => 'space-between',
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-buttons' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__( 'Background Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Text Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background',
            [
                'label' => esc_html__( 'Hover Background Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label' => esc_html__( 'Hover Text Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .elearnpro-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_padding',
            [
                'label' => esc_html__( 'Padding', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .elearnpro-button',
            ]
        );

        $this->end_controls_section();

        // Lesson List Style (for current lesson mode)
        $this->start_controls_section(
            'style_list_section',
            [
                'label' => esc_html__( 'Lesson List', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_mode' => 'current_lesson',
                    'show_sibling_list' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'list_heading_color',
            [
                'label' => esc_html__( 'Heading Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-list-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'list_heading_typography',
                'selector' => '{{WRAPPER}} .elearnpro-list-title',
            ]
        );

        $this->add_control(
            'list_heading_margin',
            [
                'label' => esc_html__( 'Heading Margin', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-list-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'list_item_color',
            [
                'label' => esc_html__( 'Lesson Link Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-list-item a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'list_item_hover_color',
            [
                'label' => esc_html__( 'Lesson Link Hover Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-list-item a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'current_lesson_color',
            [
                'label' => esc_html__( 'Current Lesson Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-list-item.current' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elearnpro-list-item.current a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'list_item_typography',
                'selector' => '{{WRAPPER}} .elearnpro-list-item, {{WRAPPER}} .elearnpro-list-item a',
            ]
        );

        $this->add_control(
            'list_item_padding',
            [
                'label' => esc_html__( 'List Item Padding', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'list_item_border_bottom',
            [
                'label' => esc_html__( 'Border Bottom', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-list-item' => 'border-bottom: {{TOP}}{{UNIT}} solid {{BOTTOM}};',
                ],
            ]
        );

        $this->add_control(
            'complete_check_color',
            [
                'label' => esc_html__( 'Completion Checkmark Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-check' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_completion_status' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Courses/Lessons List Item Style
        $this->start_controls_section(
            'style_courses_list_section',
            [
                'label' => esc_html__( 'List Items', 'elearnpro' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_mode' => [ 'all_courses', 'all_lessons' ],
                ],
            ]
        );

        $this->add_control(
            'courses_item_color',
            [
                'label' => esc_html__( 'Link Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-item-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'courses_item_hover_color',
            [
                'label' => esc_html__( 'Link Hover Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-item-link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'courses_item_typography',
                'selector' => '{{WRAPPER}} .elearnpro-item-link',
            ]
        );

        $this->add_control(
            'enrolled_badge_color',
            [
                'label' => esc_html__( 'Enrolled Badge Color', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-enrolled-badge' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_enrolled_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'courses_item_padding',
            [
                'label' => esc_html__( 'Item Padding', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'courses_item_border_bottom',
            [
                'label' => esc_html__( 'Border Bottom', 'elearnpro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .elearnpro-item' => 'border-bottom: {{TOP}}{{UNIT}} solid {{BOTTOM}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $display_mode = $settings['display_mode'];
        
        if ( $display_mode === 'current_lesson' ) {
            $this->render_current_lesson_navigation( $settings );
        } elseif ( $display_mode === 'all_courses' ) {
            $this->render_all_courses( $settings );
        } elseif ( $display_mode === 'all_lessons' ) {
            $this->render_all_lessons( $settings );
        } elseif ( $display_mode === 'course_hierarchy' ) {
            $this->render_course_hierarchy( $settings );
        }
    }

private function render_course_hierarchy( $settings ) {
    $user_id = get_current_user_id();
    $filter_type = $settings['enrollment_filter'];
    $show_badge = $settings['show_enrolled_badge'] === 'yes';
    $target = $settings['open_links_in_same_tab'] === '_blank' ? '_blank' : '_self';
    $current_lesson_id = get_the_ID();
    $current_course_id = learndash_get_course_id( $current_lesson_id );

    // Check if user needs to log in
    if ( $filter_type === 'enrolled_only' && ! $user_id ) {
        echo '<div class="elearnpro-container">';
        echo '<p>' . esc_html__( 'Please log in to see your enrolled courses.', 'elearnpro' ) . '</p>';
        echo '</div>';
        return;
    }

    // Get all courses
    $all_courses = get_posts( array(
        'post_type' => 'sfwd-courses',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
    ) );

    // Get enrolled courses for logged-in users
    $enrolled_courses = array();
    if ( $user_id && function_exists( 'learndash_user_get_enrolled_courses' ) ) {
        $enrolled_courses = learndash_user_get_enrolled_courses( $user_id );
    }

    // Filter courses based on setting
    $courses_to_show = $all_courses;
    if ( $filter_type === 'enrolled_only' ) {
        $courses_to_show = array();
        foreach ( $all_courses as $course ) {
            if ( in_array( $course->ID, $enrolled_courses ) ) {
                $courses_to_show[] = $course;
            }
        }
    }

    // Show message if no courses found
    if ( empty( $courses_to_show ) ) {
        echo '<div class="elearnpro-container">';
        if ( $filter_type === 'enrolled_only' && $user_id ) {
            echo '<p>' . esc_html__( 'You are not enrolled in any courses yet.', 'elearnpro' ) . '</p>';
        } else {
            echo '<p>' . esc_html__( 'No courses found.', 'elearnpro' ) . '</p>';
        }
        echo '</div>';
        return;
    }

    ?>
    <div class="elearnpro-container">
        <?php if ( ! empty( $settings['hierarchy_title'] ) ) : ?>
            <h3 class="elearnpro-section-title"><?php echo esc_html( $settings['hierarchy_title'] ); ?></h3>
        <?php endif; ?>
        
        <div class="elearnpro-hierarchy-list">
            <?php foreach ( $courses_to_show as $course ) : 
                $course_id = $course->ID;
                $is_enrolled = in_array( $course_id, $enrolled_courses );
                $lessons = learndash_get_lesson_list( $course_id );
                $lesson_count = count( $lessons );
                ?>
                
                <div class="elearnpro-course-wrapper" style="margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                    <!-- Course Header -->
                    <div class="elearnpro-course-header" style="cursor: pointer;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span class="elearnpro-toggle-icon" style="margin-right: 10px;">▼</span>
                                <strong><?php echo esc_html( $course->post_title ); ?></strong>
                                <?php if ( $show_badge && $is_enrolled ) : ?>
                                    <span class="elearnpro-enrolled-badge">✓ Enrolled</span>
                                <?php endif; ?>
                            </div>
                            <div class="elearnpro-lesson-count">
                                <?php echo $lesson_count; ?> lesson<?php echo $lesson_count != 1 ? 's' : ''; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lessons List -->
                    <div class="elearnpro-lessons-list">
                        <?php if ( empty( $lessons ) ) : ?>
                            <p class="elearnpro-no-lessons">No lessons in this course yet.</p>
                        <?php else : ?>
                            <ul class="elearnpro-lessons-ul">
                                <?php foreach ( $lessons as $lesson ) : 
                                    $is_current_lesson = ( $lesson->ID === $current_lesson_id );
                                    $is_complete = false;
                                    
                                    if ( $is_enrolled && function_exists( 'learndash_is_lesson_complete' ) ) {
                                        $is_complete = learndash_is_lesson_complete( $user_id, $lesson->ID );
                                    }
                                    
                                    // Build class names for styling
                                    $lesson_classes = 'elearnpro-lesson-item';
                                    if ( $is_current_lesson ) {
                                        $lesson_classes .= ' elearnpro-current-lesson';
                                    }
                                    if ( $is_complete ) {
                                        $lesson_classes .= ' elearnpro-lesson-completed';
                                    }
                                    ?>
                                    <li class="<?php echo esc_attr( $lesson_classes ); ?>">
                                        <a href="<?php echo esc_url( get_permalink( $lesson->ID ) ); ?>" 
                                           class="elearnpro-lesson-link" 
                                           target="<?php echo esc_attr( $target ); ?>">
                                            <?php if ( $is_complete && $is_enrolled ) : ?>
                                                <span class="elearnpro-checkmark">✓</span>
                                            <?php else : ?>
                                                <span class="elearnpro-lesson-icon">📖</span>
                                            <?php endif; ?>
                                            <?php echo esc_html( $lesson->post_title ); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <style>
    /* Course Header Styles */
    .elearnpro-course-header {
        padding: 12px 15px;
        background: #f5f5f5;
        transition: background-color 0.3s ease;
        border-bottom: 1px solid #ddd;
    }
    
    /* Enrolled Badge */
    .elearnpro-enrolled-badge {
        background: #4caf50;
        color: #fff;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 11px;
        margin-left: 8px;
        display: inline-block;
    }
    
    /* Lesson Count */
    .elearnpro-lesson-count {
        font-size: 12px;
        color: #666;
    }
    
    
    /* Lessons UL */
    .elearnpro-lessons-ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    /* Individual Lesson Item */
    .elearnpro-lesson-item {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
        transition: all 0.3s ease;
    }
    
    /* Remove border from last item */
    .elearnpro-lessons-ul .elearnpro-lesson-item:last-child {
        border-bottom: none;
    }
    
    /* Lesson Link */
    .elearnpro-lesson-link {
        text-decoration: none;
        display: block;
        transition: color 0.3s ease;
    }
    
    /* Lesson Icon */
    .elearnpro-lesson-icon,
    .elearnpro-checkmark {
        margin-right: 8px;
    }
    
    /* Current Lesson Badge */
    .elearnpro-current-badge {
        font-size: 11px;
        background: #0073aa;
        color: #fff;
        padding: 2px 6px;
        border-radius: 3px;
        margin-left: 8px;
        display: inline-block;
    }
    
    /* No Lessons Message */
    .elearnpro-no-lessons {
        padding: 10px 0;
        color: #666;
    }
    </style>

    <script>
    (function() {
        var headers = document.querySelectorAll('.elearnpro-course-header');
        headers.forEach(function(header) {
            header.addEventListener('click', function(e) {
                if (e.target.tagName === 'A') return;
                
                var wrapper = this.closest('.elearnpro-course-wrapper');
                var lessonsList = wrapper.querySelector('.elearnpro-lessons-list');
                var toggleIcon = this.querySelector('.elearnpro-toggle-icon');
                
                if (lessonsList.style.display === 'none') {
                    lessonsList.style.display = 'block';
                    if (toggleIcon) toggleIcon.innerHTML = '▼';
                } else {
                    lessonsList.style.display = 'none';
                    if (toggleIcon) toggleIcon.innerHTML = '▶';
                }
            });
        });
    })();
    </script>
    <?php
}

}