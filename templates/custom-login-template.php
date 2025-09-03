<?php
/**
 * Custom Login Template
 * 
 * This template displays the custom login form for the Instant Login plugin.
 * 
 * Features:
 * - Responsive login form with email and password fields
 * - AJAX-powered submission with loading spinner
 * - Dynamic message container for success/error feedback
 * 
 * The form is styled using classes from style.css and functionality
 * from script.js. It uses WordPress AJAX for seamless login without page reload.
 * 
 * @package Instant_Login
 */
?>
<body style="overflow: hidden;">
    <div class="container">
        <!-- Login Form Container -->
        <div class="form-container">
            <div class="form-header">
                <h1>Login</h1>
            </div>
            <form id="instant-login-form" method="post" class="form-box">
                <!-- Email Input Field -->
                <div class="input-group">
                    <input type="email" name="email" id="email" class="input-field" placeholder="" required>
                    <label for="email" class="floating-label">Email address</label>
                </div>
                
                <!-- Password Input Field -->
                <div class="input-group">
                    <input type="password" name="password" id="password" class="input-field" placeholder="" required>
                    <label for="password" class="floating-label">Password</label>
                    <div class="eye-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>                    
                    </div>
                </div>
                
                <!-- Submit Button with Spinner -->
                <button type="submit" class="form-btn form-btn--submit">
                    Login <span class="spinner"></span>
                </button>
                
                <!-- AJAX Response Message Container -->
                <div id="instant-login-message"></div>
            </form>
        </div>
    </div>
</body>
