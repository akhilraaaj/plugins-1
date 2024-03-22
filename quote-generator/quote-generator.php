<?php
/*
Plugin Name: Quote Generator
Description: A basic shortcode plugin to display random quotes.
Version: 1.0
Author: Akhil
*/

function generate_quote() {
    $quotes = array(
        "The only way to do great work is to love what you do",
        "Innovation distinguishes between a leader and a follower",
        "Your time is limited, so don't waste it living someone else's life",
        "Don't let the noise of others' opinions drown out your own inner voice",
        "Design is not just what it looks like and feels like. Design is how it works",
        "Have the courage to follow your heart and intuition. They somehow already know what you truly want to become",
    );
    $random_quote = $quotes[array_rand($quotes)];
    return "<p class='random-quote'>'$random_quote'</p>";
}
add_shortcode('quote', 'generate_quote');

function enqueue_styles() {
    $plugin_url = plugin_dir_url(__FILE__);
    wp_enqueue_style('styles', $plugin_url . 'styles.css');
}
add_action('wp_enqueue_scripts', 'enqueue_styles');
