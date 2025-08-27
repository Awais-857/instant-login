/**
 * Instant Login - JavaScript Functionality
 * 
 * Handles AJAX login form submission with:
 * - Form validation and submission prevention
 * - Loading spinner during AJAX requests
 * - Success/error message display
 * - Redirect handling and page refresh
 * - Password visibility toggle
 * 
 * @package Instant_Login
 */

jQuery(document).ready(function($) {
    // Password visibility toggle
    $('.eye-icon').on('click', function() {
        const passwordInput = $('#password');
        const eyeIcon = $(this);
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            eyeIcon.html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off"><path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/></svg>');
        } else {
            passwordInput.attr('type', 'password');
            eyeIcon.html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>');
        }
    });

    // Attach submit handler to the login form
    $('#instant-login-form').on('submit', function(e) {
        // Prevent default form submission behavior
        e.preventDefault();
        
        // Cache DOM elements
        const $btn = $('.form-btn--submit');
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
