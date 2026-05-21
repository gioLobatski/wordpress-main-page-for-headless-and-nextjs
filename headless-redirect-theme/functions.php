<?php
/**
 * Headless Redirect Theme - Functions
 *
 * Registers the admin settings page and theme defaults.
 *
 * @package Headless_Redirect
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define default option values.
 */
function headless_redirect_defaults() {
    return array(
        'frontend_url'       => '',
        'logo_image'         => '',
        'page_title'         => '',
        'description'        => 'You are viewing the admin backend. Click below to visit the main website.',
        'button_text'        => 'Visit Website',
        'button_color'       => '#0073aa',
        'button_text_color'  => '#ffffff',
        'preserve_path'      => true,
        'auto_redirect'      => 0,
        'background_color'   => '#ffffff',
        'text_color'         => '#333333',
    );
}

/**
 * Get a single theme option with fallback to default.
 */
function headless_redirect_get_option( $key ) {
    $options  = get_option( 'headless_redirect_options', array() );
    $defaults = headless_redirect_defaults();

    return isset( $options[ $key ] ) ? $options[ $key ] : ( isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
}

/**
 * Register the settings page under Appearance menu.
 */
function headless_redirect_admin_menu() {
    add_theme_page(
        __( 'Headless Redirect Settings', 'headless-redirect' ),
        __( 'Headless Redirect', 'headless-redirect' ),
        'manage_options',
        'headless-redirect-settings',
        'headless_redirect_settings_page'
    );
}
add_action( 'admin_menu', 'headless_redirect_admin_menu' );

/**
 * Register settings.
 */
function headless_redirect_register_settings() {
    register_setting( 'headless_redirect_group', 'headless_redirect_options', 'headless_redirect_sanitize' );
}
add_action( 'admin_init', 'headless_redirect_register_settings' );

/**
 * Sanitize settings on save.
 */
function headless_redirect_sanitize( $input ) {
    $defaults  = headless_redirect_defaults();
    $sanitized = array();

    $sanitized['frontend_url']      = esc_url_raw( trim( $input['frontend_url'] ?? $defaults['frontend_url'] ) );
    $sanitized['logo_image']        = esc_url_raw( trim( $input['logo_image'] ?? '' ) );
    $sanitized['page_title']        = sanitize_text_field( $input['page_title'] ?? $defaults['page_title'] );
    $sanitized['description']       = sanitize_textarea_field( $input['description'] ?? $defaults['description'] );
    $sanitized['button_text']       = sanitize_text_field( $input['button_text'] ?? $defaults['button_text'] );
    $sanitized['button_color']      = sanitize_hex_color( $input['button_color'] ?? $defaults['button_color'] );
    $sanitized['button_text_color'] = sanitize_hex_color( $input['button_text_color'] ?? $defaults['button_text_color'] );
    $sanitized['preserve_path']     = ! empty( $input['preserve_path'] );
    $sanitized['auto_redirect']     = absint( $input['auto_redirect'] ?? 0 );
    $sanitized['background_color']  = sanitize_hex_color( $input['background_color'] ?? $defaults['background_color'] );
    $sanitized['text_color']        = sanitize_hex_color( $input['text_color'] ?? $defaults['text_color'] );

    return $sanitized;
}

/**
 * Enqueue the WP media uploader on the settings page.
 */
function headless_redirect_admin_scripts( $hook ) {
    if ( 'appearance_page_headless-redirect-settings' !== $hook ) {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'headless_redirect_admin_scripts' );

/**
 * Load the settings page template.
 */
function headless_redirect_settings_page() {
    require get_template_directory() . '/inc/settings-page.php';
}

/**
 * Ensure REST API and GraphQL are not blocked.
 * This theme does not interfere with API endpoints.
 */
function headless_redirect_allow_api( $template ) {
    // Don't override REST API or GraphQL requests.
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        return $template;
    }

    // Allow WP admin to load normally.
    if ( is_admin() ) {
        return $template;
    }

    return $template;
}
add_filter( 'template_include', 'headless_redirect_allow_api', 99 );
