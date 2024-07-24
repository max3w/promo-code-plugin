<?php
/*
Plugin Name: Promo Code Plugin
Description: Promo-code
Version: 1.0
*/

// Add admin
add_action('admin_menu', 'csp_add_admin_menu');
function csp_add_admin_menu() {
    add_menu_page(
        'Promo Code',
        'Promo Code',
        'manage_options',
        'promo-code',
        'csp_settings_page',
        '',
        99
    );
}

// View
function csp_settings_page() {
    ?>
    <div class="wrap">
        <h1>Promo Code Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('csp_settings_group');
            do_settings_sections('promo-code');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
add_action('admin_init', 'csp_register_settings');
function csp_register_settings() {
    register_setting('csp_settings_group', 'csp_text_field');

    add_settings_section(
        'csp_settings_section',
        'Promo Code Settings',
        'csp_settings_section_callback',
        'promo-code'
    );

    add_settings_field(
        'csp_text_field',
        'Promo Сode',
        'csp_text_field_callback',
        'promo-code',
        'csp_settings_section'
    );
}

function csp_settings_section_callback() {
    echo 'Enter promocode:';
}

function csp_text_field_callback() {
    $value = get_option('csp_text_field', '');
    echo '<input type="text" id="csp_text_field" name="csp_text_field" value="' . esc_attr($value) . '" />';
}

// AJAX
add_action('wp_ajax_get_promo_text', 'csp_get_promo_text');
add_action('wp_ajax_nopriv_get_promo_text', 'csp_get_promo_text');
function csp_get_promo_text() {
    $custom_text = get_option('csp_text_field', '');
    wp_send_json_success($custom_text);
}

// Register
add_action('wp_enqueue_scripts', 'csp_enqueue_scripts');
function csp_enqueue_scripts() {
    wp_enqueue_script('csp-script', plugins_url('csp-script.js', __FILE__), array('jquery'), null, true);
    wp_localize_script('csp-script', 'csp_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
