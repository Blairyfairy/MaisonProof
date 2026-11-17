<?php
/**
 * Plugin Name: MAISONPROOF Verify for WooCommerce
 * Description: Luxury inventory provenance and independently reviewed authentication status.
 * Version: 0.1.0
 * Requires PHP: 7.4
 * Requires Plugins: woocommerce
 * Text Domain: maisonproof-verify
 */
if (!defined('ABSPATH')) exit;
class Maisonproof_Verify {
 const OPTION = 'maisonproof_verify_settings';
 public function __construct() {
  add_action('admin_menu',[$this,'menu']);
  add_action('admin_init',[$this,'settings']);
  add_action('woocommerce_update_product',[$this,'sync'],20,1);
  add_action('woocommerce_single_product_summary',[$this,'badge'],35);
  add_shortcode('maisonproof_verify',[$this,'shortcode']);
  add_action('wp_enqueue_scripts',[$this,'styles']);
 }
 public function styles() { wp_enqueue_style('maisonproof-verify',plugins_url('assets/maisonproof.css',__FILE__),[], '0.2.0'); }
 public function menu() { add_submenu_page('woocommerce','MAISONPROOF Verify','MAISONPROOF Verify','manage_woocommerce','maisonproof-verify',[$this,'page']); }
 public function settings() {
  register_setting('maisonproof_verify',self::OPTION,['sanitize_callback'=>[$this,'sanitize']]);
 }
 public function sanitize($v) {
  $old=get_option(self::OPTION,[]);
  $url=isset($v['url'])?esc_url_raw(trim($v['url'])):'';
  if ($url && !preg_match('#^https://#i',$url) && !preg_match('#^http://localhost(?::[0-9]+)?/?$#i',rtrim($url,'/'))) { add_settings_error(self::OPTION,'https','Use HTTPS for the API URL.'); $url=$old['url']??''; }
  return ['url'=>rtrim($url,'/'),'store'=>sanitize_key($v['store']??''),'key'=>sanitize_text_field($v['key']??($old['key']??''))];
 }
 public function page() {
  if (!current_user_can('manage_woocommerce')) return;
  $o=get_option(self::OPTION,[]);
  echo '<div class="wrap"><h1>MAISONPROOF Verify</h1><p>Authentication requires independent review; supplier evidence alone is not proof.</p><form method="post" action="options.php">';
  settings_fields('maisonproof_verify');
  foreach (['url'=>'Service URL (HTTPS)','store'=>'Store ID','key'=>'Merchant API Key'] as $k=>$label) {
   echo '<p><label for="av_'.esc_attr($k).'">'.esc_html($label).'</label><br><input class="regular-text" id="av_'.esc_attr($k).'" type="'.($k==='key'?'password':'text').'" name="'.esc_attr(self::OPTION).'['.esc_attr($k).']" value="'.esc_attr($o[$k]??'').'" autocomplete="off"></p>';
  }
  submit_button();echo '</form></div>';
 }
 public function sync($id) {
  if (!function_exists('wc_get_product')) return;
  $p=wc_get_product($id);$o=get_option(self::OPTION,[]);
  if (!$p || empty($o['url']) || empty($o['key']) || empty($o['store']) || !$p->get_sku()) return;
  $brand=trim((string)$p->get_attribute('pa_brand'));
  $supplier=trim((string)get_post_meta($id,'_maisonproof_supplier_name',true));
  if (!$brand || !$supplier) return; // never invent supplier identity
  $result=wp_remote_post($o['url'].'/v1/products',['timeout'=>8,'headers'=>['X-API-Key'=>$o['key'],'Content-Type'=>'application/json'],'body'=>wp_json_encode(['store'=>$o['store'],'sku'=>$p->get_sku(),'brand'=>$brand,'supplier_name'=>$supplier])]);
  if (is_wp_error($result) || wp_remote_retrieve_response_code($result)>=400) error_log('MAISONPROOF: product sync failed for product '.intval($id));
 }
 public function status($id) {
  $o=get_option(self::OPTION,[]);$p=function_exists('wc_get_product')?wc_get_product($id):false;
  if (!$p || !$p->get_sku() || empty($o['url']) || empty($o['store'])) return null;
  $key='maisonproof_'.md5($o['store'].'|'.$p->get_sku());
  $cached=get_transient($key);if ($cached!==false) return $cached;
  $url=$o['url'].'/v1/public/'.rawurlencode($o['store']).'/'.rawurlencode($p->get_sku());
  $response=wp_remote_get($url,['timeout'=>5]);
  if (is_wp_error($response) || wp_remote_retrieve_response_code($response)!==200) return null;
  $data=json_decode(wp_remote_retrieve_body($response),true);
  if (!is_array($data) || empty($data['status'])) return null;
  set_transient($key,$data,60);return $data;
 }
 public function shortcode($atts=[]) {
  $atts=shortcode_atts(['id'=>get_the_ID()],$atts,'maisonproof_verify');$d=$this->status(absint($atts['id']));
  if (!$d || ($d['status']??'')!=='authenticated') return ''; // Never suggest authentication when it cannot be confirmed.
  $o=get_option(self::OPTION,[]);$p=wc_get_product(absint($atts['id']));
  if (!$p || empty($o['store']) || empty($o['url'])) return '';
  $url=rtrim($o['url'],'/').'/v1/public/'.rawurlencode($o['store']).'/'.rawurlencode($p->get_sku());
  return '<span class="maisonproof-proof" aria-label="Independent authentication record available"><span class="maisonproof-proof__mark" aria-hidden="true">✓</span><span class="maisonproof-proof__name">MAISONPROOF</span><span class="maisonproof-proof__status">Independently authenticated</span><a href="'.esc_url($url).'" target="_blank" rel="noopener noreferrer">View record</a></span>';
 }
 public function badge() { global $product; if ($product) echo $this->shortcode(['id'=>$product->get_id()]); }
}
add_action('plugins_loaded',function(){if (class_exists('WooCommerce')) new Maisonproof_Verify();});
