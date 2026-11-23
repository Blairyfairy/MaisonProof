<?php
/**
 * Plugin Name: MaisonProof Product Verification Badge
 * Description: Displays a MaisonProof-issued authentication seal only after MaisonProof approves the item.
 * Version: 0.1.0
 * License: MIT
 */
if (!defined('ABSPATH')) exit;
add_action('woocommerce_before_single_product_summary', function () {
    global $product;
    if (!$product || !is_a($product, 'WC_Product')) return;
    $id = $product->get_meta('_maisonproof_id', true);
    if (!$id || !preg_match('/^[A-Za-z0-9_-]{1,80}$/', $id)) return;
    $base = apply_filters('maisonproof_verification_base_url', 'https://maisonproof.org');
    if (strpos($base, 'https://') !== 0) return;
    $response = wp_remote_get(trailingslashit($base) . 'v1/records/' . rawurlencode($id), ['timeout' => 3, 'redirection' => 0]);
    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) return;
    $data = json_decode(wp_remote_retrieve_body($response), true);
    if (!is_array($data) || ($data['id'] ?? '') !== $id || ($data['status'] ?? '') !== 'authenticated' || ($data['badge_active'] ?? false) !== true) return;
    $url = trailingslashit($base) . 'verify/' . rawurlencode($id);
    echo '<a class="maisonproof-badge" href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer" title="View MaisonProof verification record" aria-label="View MaisonProof verification record">✓ Vetted by MaisonProof</a>';
}, 25);
add_action('wp_head', function () {
    if (!function_exists('is_product') || !is_product()) return;
    echo '<style>.single-product .woocommerce-product-gallery{position:relative}.maisonproof-badge{display:inline-block;position:absolute;bottom:12px;right:12px;z-index:5;background:#152d4c;color:#fff!important;border:1px solid #d6ad66;border-radius:18px;padding:7px 11px;font:600 12px system-ui;text-decoration:none}.maisonproof-badge:focus-visible{outline:3px solid #2563eb}</style>';
});
