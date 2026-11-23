<?php
/** Optional central submission; no merchant-side authenticity approvals. */
if (!defined('ABSPATH')) exit;
add_action('woocommerce_update_product', 'mp_central_publish', 30, 1);
function mp_central_publish($product_id) {
 if (!get_option('mp_central_enabled', false) || !current_user_can('edit_post', $product_id)) return;
 $product=wc_get_product($product_id);
 if (!$product || $product->get_status()!=='publish') return;
 $url=untrailingslashit((string)get_option('mp_central_url',''));
 $key=(string)get_option('mp_central_key','');$store=(string)get_option('mp_central_store','');
 if (!str_starts_with($url,'https://') || strlen($key)<32 || !$store) return;
 $version=$product->get_date_modified();$stamp=$version ? $version->getTimestamp() : time();
 $idem='wc-'.$product_id.'-'.$stamp;
 if (get_post_meta($product_id,'_mp_central_last_idem',true)===$idem) return;
 $body=wp_json_encode(['source'=>'woocommerce','sku'=>$product->get_sku() ?: (string)$product_id,'name'=>$product->get_name()]);
 $time=(string)time();$sig=hash_hmac('sha256',$time."\n".$store."\n".$body,$key);
 $response=wp_remote_post($url.'/v1/submissions',['timeout'=>12,'redirection'=>0,'headers'=>['content-type'=>'application/json','x-mp-store'=>$store,'x-mp-timestamp'=>$time,'x-mp-signature'=>$sig,'idempotency-key'=>$idem],'body'=>$body]);
 if (is_wp_error($response)) {error_log('MaisonProof central submission transport failed');return;}
 $code=wp_remote_retrieve_response_code($response);$result=json_decode(wp_remote_retrieve_body($response),true);
 if (in_array($code,[200,202],true) && is_array($result) && !empty($result['id'])) {
  update_post_meta($product_id,'_mp_central_record_id',sanitize_text_field($result['id']));
  update_post_meta($product_id,'_mp_central_last_idem',$idem);
  update_post_meta($product_id,'_mp_central_status','pending');
 } else error_log('MaisonProof central submission rejected: HTTP '.intval($code));
}
add_action('admin_init',function(){
 foreach(['mp_central_url','mp_central_store'] as $name) register_setting('mp_options',$name,['sanitize_callback'=>'sanitize_text_field']);
 register_setting('mp_options','mp_central_key',['sanitize_callback'=>'sanitize_text_field']);
 register_setting('mp_options','mp_central_enabled',['sanitize_callback'=>'absint']);
});
add_action('admin_menu',function(){add_options_page('MaisonProof Central API','MaisonProof Central API','manage_options','mp-central',function(){
 echo '<div class="wrap"><h1>MaisonProof Central API</h1><p>Optional: published products submit as pending. No verification is issued by this plugin.</p><form method="post" action="options.php">';settings_fields('mp_options');
 foreach(['mp_central_url'=>'HTTPS API base URL','mp_central_store'=>'Store identifier','mp_central_key'=>'Store signing secret'] as $name=>$label){echo '<p><label>'.esc_html($label).' <input class="regular-text" type="'.($name==='mp_central_key'?'password':'text').'" name="'.esc_attr($name).'" value="'.esc_attr(get_option($name,'')).'" autocomplete="off"></label></p>';}
 echo '<p><label><input type="checkbox" name="mp_central_enabled" value="1" '.checked(get_option('mp_central_enabled',0),1,false).'> Enable central submission</label></p>';submit_button();echo '</form></div>';
});});
