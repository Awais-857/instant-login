<?php
/**
 * Custom Login Template
 * 
 * This template displays the custom login form for the Instant Login plugin.
 * 
 * Features:
 * - Header section with customizable name/logo
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
<div class="instant-login-wrapper">
    <!-- Login Header Section -->
    <header class="instant-login-header">
        <h1>Awais Iqbal</h1>
    </header>
    
    <!-- Login Form Container -->
    <div class="instant-login-container">
        <form id="instant-login-form" method="post">
            <h2>Login</h2>
            
            <!-- Email Input Field -->
            <div class="instant-form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            
            <!-- Password Input Field -->
            <div class="instant-form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            
            <!-- Submit Button with Spinner -->
            <button type="submit" id="instant-login-btn">
                Login <span class="spinner"></span>
            </button>
            
            <!-- AJAX Response Message Container -->
            <div id="instant-login-message"></div>
        </form>
    </div>
</div>