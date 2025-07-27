/**
 * Instant Login - JavaScript Functionality
 * 
 * Handles AJAX login form submission with:
 * - Form validation and submission prevention
 * - Loading spinner during AJAX requests
 * - Success/error message display
 * - Redirect handling and page refresh
 * 
 * @package Instant_Login
 */

jQuery(document).ready(function($) {
    // Attach submit handler to the login form
    $('#instant-login-form').on('submit', function(e) {
        // Prevent default form submission behavior
        e.preventDefault();
        
        // Cache DOM elements
        const $btn = $('#instant-login-btn');
        const $message = $('#instant-login-message');
        
        // UI State Management: Show loading spinner and disable button
        $btn.prop('disabled', true);
        $btn.find('.spinner').css('display', 'inline-block');
        $message.removeClass('success error').html('');
        
        // AJAX Request Configuration
        $.ajax({
            url: instant_login_vars.ajax_url, // WordPress AJAX endpoint
            type: 'POST',
            data: {
                action: 'instant_login',     // WordPress action hook
                email: $('input[name="email"]').val(), // Email input value
                password: $('input[name="password"]').val(), // Password input value
                security: instant_login_vars.nonce // WordPress nonce for security
            },
            
            // Success Response Handler
            success: function(response) {
                if (response.success) {
                    // Handle redirect option
                    if (response.data.redirect) {
                        window.location.href = response.data.redirect;
                    } 
                    // Handle success message
                    else {
                        $message.addClass('success').html(response.data);
                        // Refresh page after 1 second to show logged-in state
                        setTimeout(() => location.reload(), 1000);
                    }
                } 
                // Handle error response
                else {
                    $message.addClass('error').html(response.data);
                }
            },
            
            // AJAX Completion Handler (always executes)
            complete: function() {
                // Reset UI state
                $btn.prop('disabled', false);
                $btn.find('.spinner').hide();
            }
        });
    });
});