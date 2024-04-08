<?php
/*
Plugin Name: Custom Metabox Plugin
Description: A basic metabox plugin. Add an input field and checkbox field to the metabox. show the input field data in the front end only if the checkbox is checked.
Version: 1.0
Author: Akhil
*/

function metabox_styles() {
    wp_enqueue_style('custom-metabox-styles', plugins_url('styles.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'metabox_styles');

function metabox() {
    add_meta_box(
        'metabox',  // id
        'Metabox',  // title
        'metabox_callback', // callback function
        'page', // shows up on pages
        'side', // placement of meta box
        'high' // priority
    );
}   
add_action('add_meta_boxes', 'metabox');

function metabox_callback($post) {
    $value = get_post_meta($post->ID, 'metabox_input', true);
    $checked = get_post_meta($post->ID, 'metabox_checkbox', true);
    ?>
    <label for="metabox_input">Enter Input Data:</label>
    <input type="text" id="metabox_input" name="metabox_input" value="<?php echo esc_attr($value); ?>"><br>
    <label for="metabox_checkbox">Display:</label>
    <input type="checkbox" id="metabox_checkbox" name="metabox_checkbox" <?php checked($checked, 'on'); ?>>
    <?php
}

// Save data
function save_metabox_data($post_id) {
    // Checks if autosave is enabled or not 
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
        return;
    // Checks if data exists or not
    $input_data = isset($_POST['metabox_input']) ? sanitize_text_field($_POST['metabox_input']) : '';
    $checkbox_data = isset($_POST['metabox_checkbox']) ? 'on' : '';
    update_post_meta($post_id, 'metabox_input', $input_data);
    update_post_meta($post_id, 'metabox_checkbox', $checkbox_data);
}
add_action('save_post', 'save_metabox_data');

// Display data
function display_metabox_data($content) {
    global $post;
    $value = get_post_meta($post->ID, 'metabox_input', true);
    $checked = get_post_meta($post->ID, 'metabox_checkbox', true);
    if ($checked === 'on') {
        $content .= '<div class="heading">' . esc_html($value) . '</div>';
    }
    return $content;
}
add_filter('the_content', 'display_metabox_data');
