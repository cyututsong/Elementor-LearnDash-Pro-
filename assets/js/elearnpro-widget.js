(function($) {
    'use strict';
    
    // Function to show floating alert
    function showFloatingAlert(message, type, container) {
        if (!container || !container.length) return;
        
        var position = container.data('position') || 'top-center';
        var duration = parseInt(container.data('duration')) || 4000;
        
        // Create alert element
        var alertDiv = $('<div class="elearnpro-floating-alert"></div>');
        alertDiv.html(message);
        
        // Add type class for styling
        if (type === 'error') {
            alertDiv.css('background-color', '#ff4444');
        } else if (type === 'warning') {
            alertDiv.css('background-color', '#ff9800');
        } else if (type === 'success') {
            alertDiv.css('background-color', '#4CAF50');
        }
        
        // Clear previous alerts
        container.empty();
        
        // Set position based on setting
        switch(position) {
            case 'top-left':
                container.css({ top: '20px', left: '20px', right: 'auto', bottom: 'auto', transform: 'none' });
                break;
            case 'top-right':
                container.css({ top: '20px', right: '20px', left: 'auto', bottom: 'auto', transform: 'none' });
                break;
            case 'bottom-left':
                container.css({ bottom: '20px', left: '20px', top: 'auto', right: 'auto', transform: 'none' });
                break;
            case 'bottom-right':
                container.css({ bottom: '20px', right: '20px', top: 'auto', left: 'auto', transform: 'none' });
                break;
            case 'bottom-center':
                container.css({ bottom: '20px', left: '50%', right: 'auto', top: 'auto', transform: 'translateX(-50%)' });
                break;
            case 'top-center':
            default:
                container.css({ top: '20px', left: '50%', right: 'auto', bottom: 'auto', transform: 'translateX(-50%)' });
                break;
        }
        
        container.append(alertDiv);
        
        // Animate in
        alertDiv.hide().fadeIn(300);
        
        // Auto-hide after duration
        if (duration > 0) {
            setTimeout(function() {
                alertDiv.fadeOut(300, function() {
                    $(this).remove();
                });
            }, duration);
        }
    }
    
    // Handle custom button clicks
    $(document).on('click', '.elearnpro-validate-button', function(e) {
        e.preventDefault();
        
        var button = $(this);
        
        // Get all data from button attributes
        var stepId = button.data('step-id');
        var nonce = button.data('nonce');
        var postType = button.data('post-type');
        var quizStatusStr = button.attr('data-quiz-status');
        var buttonText = button.data('button-text') || 'Mark Complete';
        var enableAlert = button.data('enable-alert') === 'yes';
        var quizRequiredMsg = button.data('quiz-required-msg') || 'You must complete and pass the quiz before you can mark this lesson as complete.';
        var quizFailedMsg = button.data('quiz-failed-msg') || 'You did not pass the quiz. Please review the material and retake the quiz before marking complete.';
        var ajaxUrl = button.data('ajax-url') || '/wp-admin/admin-ajax.php';
        
        // Get alert container
        var alertContainer = $('#elearnpro-floating-alert-container');
        
        // Parse quiz status
        var quizStatus = { has_quizzes: false, all_requirements_met: true };
        if (quizStatusStr) {
            try {
                quizStatus = JSON.parse(quizStatusStr);
            } catch(err) {
                console.log('Failed to parse quiz status:', err);
            }
        }
        
        // ============ CONSOLE LOGS - USER INFO ============
        console.log('========================================');
        console.log('👤 USER INFORMATION');
        console.log('========================================');
        
        if (quizStatus.user_info) {
            console.log('User ID:', quizStatus.user_info.id);
            console.log('User Email:', quizStatus.user_info.email);
            console.log('Display Name:', quizStatus.user_info.display_name);
            console.log('Username:', quizStatus.user_info.username);
            console.log('User Roles:', quizStatus.user_info.roles);
        } else {
            console.log('⚠️ User info not available');
        }
        
        console.log('Timestamp:', quizStatus.timestamp || 'Not available');
        console.log('========================================');
        console.log('🎯 Mark Complete Button Clicked');
        console.log('========================================');
        console.log('Step ID:', stepId);
        console.log('Post Type:', postType);
        console.log('Has Quizzes:', quizStatus.has_quizzes);
        console.log('Quizzes Completed:', quizStatus.quizzes_completed);
        console.log('Quizzes Passed:', quizStatus.quizzes_passed);
        console.log('All Requirements Met:', quizStatus.all_requirements_met);
        
        // Log required quizzes details
        if (quizStatus.required_quizzes && quizStatus.required_quizzes.length > 0) {
            console.log('Required Quiz IDs:', quizStatus.required_quizzes);
        }
        
        // Log debug information if available
        if (quizStatus.debug && quizStatus.debug.length > 0) {
            console.log('Debug Info:');
            quizStatus.debug.forEach(function(debugMsg) {
                console.log('  - ' + debugMsg);
            });
        }
        
        // Log user-friendly status
        if (quizStatus.has_quizzes) {
            if (quizStatus.quizzes_passed) {
                console.log('✅ RESULT: User HAS PASSED all required quizzes!');
            } else if (quizStatus.quizzes_completed) {
                console.log('⚠️ RESULT: User completed but DID NOT PASS all quizzes!');
            } else {
                console.log('❌ RESULT: User has NOT COMPLETED required quizzes!');
            }
        } else {
            console.log('ℹ️ RESULT: No quizzes required for this step.');
        }
        console.log('========================================');
        // ============ END CONSOLE LOGS ============
        
        // Check quiz requirements
        if (quizStatus.has_quizzes) {
            // Check if quizzes are not completed
            if (!quizStatus.quizzes_completed && enableAlert) {
                console.log('🚫 BLOCKED: Showing "Quiz Required" alert');
                showFloatingAlert(quizRequiredMsg, 'error', alertContainer);
                return false;
            }
            
            // Check if quizzes are not passed
            if (!quizStatus.quizzes_passed && enableAlert) {
                console.log('🚫 BLOCKED: Showing "Quiz Failed" alert');
                showFloatingAlert(quizFailedMsg, 'warning', alertContainer);
                return false;
            }
        }
        
        console.log('✅ PROCEEDING: Sending AJAX request to mark complete...');
        
        // If all requirements are met, submit via AJAX
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'elearnpro_mark_complete',
                step_id: stepId,
                nonce: nonce,
                post_type: postType
            },
            beforeSend: function() {
                button.prop('disabled', true).text('Processing...');
                console.log('⏳ AJAX Request sent...');
            },
            success: function(response) {
                console.log('📦 AJAX Response:', response);
                
                if (response.success) {
                    console.log('✅ SUCCESS: Lesson marked as complete!');
                    console.log('👤 User ID ' + (quizStatus.user_info ? quizStatus.user_info.id : 'unknown') + ' marked step ' + stepId + ' as complete');
                    if (enableAlert && alertContainer.length) {
                        showFloatingAlert('✓ Lesson marked as complete! Refreshing...', 'success', alertContainer);
                    }
                    setTimeout(function() {
                        console.log('🔄 Refreshing page...');
                        location.reload();
                    }, 1000);
                } else {
                    // Detailed error logging
                    console.log('❌ SERVER-SIDE VALIDATION FAILED');
                    console.log('Error Message:', response.data.message || 'Unknown error');
                    
                    if (response.data.quiz_status) {
                        console.log('Quiz Status from Server:');
                        console.log('  - Has Quizzes:', response.data.quiz_status.has_quizzes);
                        console.log('  - All Completed:', response.data.quiz_status.quizzes_completed);
                        console.log('  - All Passed:', response.data.quiz_status.quizzes_passed);
                        
                        if (response.data.quiz_status.quiz_details) {
                            console.log('Quiz Details:');
                            response.data.quiz_status.quiz_details.forEach(function(quiz, index) {
                                console.log('  Quiz #' + (index + 1) + ':');
                                console.log('    ID:', quiz.quiz_id);
                                console.log('    Title:', quiz.quiz_title);
                                console.log('    Completed:', quiz.completed ? '✅ Yes' : '❌ No');
                                console.log('    Passed:', quiz.passed ? '✅ Yes' : '❌ No');
                            });
                        }
                    }
                    
                    button.prop('disabled', false).text(buttonText);
                    if (enableAlert && alertContainer.length) {
                        var errorMsg = response.data.message || 'Error marking complete. Please check quiz requirements.';
                        showFloatingAlert(errorMsg, 'error', alertContainer);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('❌ AJAX ERROR:', textStatus, errorThrown);
                button.prop('disabled', false).text(buttonText);
                if (enableAlert && alertContainer.length) {
                    showFloatingAlert('An error occurred. Please try again.', 'error', alertContainer);
                }
            }
        });
    });
    
})(jQuery);