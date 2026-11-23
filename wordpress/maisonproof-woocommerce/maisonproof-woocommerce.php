<?php
/**
 * Plugin Name: MaisonProof Luxury Verification for WooCommerce
 * Description: Controlled luxury-item verification records, product image seals, public lookups, and merchant evidence submissions.
 * Version: 1.0.0
 * Requires PHP: 7.4
 * Requires Plugins: woocommerce
 * Text Domain: maisonproof-woocommerce
 * License: GPL-2.0-or-later
 */
if (!defined('ABSPATH')) exit;
final class MaisonProof_Woo {
 const VERSION='1.0.0';
 const META='_mp_verification_record';
 const NONCE='mp_record_save';
 public static function init(){
  add_action('init',[__CLASS__,'record_type']);
  add_action('add_meta_boxes',[__CLASS__,'meta_boxes']);
  add_action('save_post_mp_record',[__CLASS__,'save_record'],10,2);
  add_action('admin_post_mp_submit_evidence',[__CLASS__,'submit_evidence']);
  add_action('admin_menu',[__CLASS__,'admin_menu']);
  add_action('admin_init',[__CLASS__,'settings']);
  add_action('woocommerce_product_options_general_product_data',[__CLASS__,'product_field']);
  add_action('woocommerce_admin_process_product_object',[__CLASS__,'save_product_field']);
  add_action('woocommerce_product_thumbnails',[__CLASS__,'single_badge'],25);
  add_action('woocommerce_before_shop_loop_item_title',[__CLASS__,'loop_badge'],11);
  add_action('wp_enqueue_scripts',[__CLASS__,'styles']);
  add_shortcode('maisonproof_verify',[__CLASS__,'verify_shortcode']);
  add_shortcode('maisonproof_badge',[__CLASS__,'badge_shortcode']);
  add_shortcode('maisonproof_submit',[__CLASS__,'submit_shortcode']);
  add_action('rest_api_init',[__CLASS__,'rest_routes']);
  add_filter('manage_mp_record_posts_columns',[__CLASS__,'columns']);
  add_action('manage_mp_record_posts_custom_column',[__CLASS__,'column_data'],10,2);
  add_action('admin_notices',[__CLASS__,'woo_notice']);
 }
 public static function record_type(){register_post_type('mp_record',[
  'labels'=>['name'=>'MaisonProof Records','singular_name'=>'Verification Record','add_new_item'=>'Add Verification Record'],
  'public'=>false,'show_ui'=>true,'show_in_menu'=>true,'menu_icon'=>'dashicons-shield','supports'=>['title'],
  'capability_type'=>'post','map_meta_cap'=>true,'show_in_rest'=>false,
 ]);}
 public static function can_review(){return current_user_can('manage_options');}
 public static function meta_boxes(){add_meta_box('mp_details','Verification control and evidence',[__CLASS__,'record_box'],'mp_record','normal','high');}
 public static function record_box($post){
  wp_nonce_field(self::NONCE,'mp_nonce');
  $fields=['id'=>'Record ID (letters, numbers, dash, underscore)','status'=>'Status','product'=>'Linked WooCommerce product ID','brand'=>'Brand','model'=>'Model / item','serial'=>'Private serial / identifying reference','reviewer'=>'Reviewer name / ID','decision'=>'Decision notes (private)','date'=>'Decision date (YYYY-MM-DD)','expires'=>'Expiration date (optional)','evidence'=>'Evidence attachment IDs (comma-separated; private admin access)'];
  foreach($fields as $k=>$label){$value=get_post_meta($post->ID,'_mp_'.$k,true); echo '<p><label for="mp_'.esc_attr($k).'"><strong>'.esc_html($label).'</strong></label><br>';
   if($k==='status') {echo '<select id="mp_status" name="mp_status">'; foreach(['pending','in_review','verified','rejected','revoked','expired'] as $status)echo '<option value="'.esc_attr($status).'" '.selected($value,$status,false).'>'.esc_html(ucwords(str_replace('_',' ',$status))).'</option>';echo '</select>';}
   elseif($k==='decision')echo '<textarea style="width:100%" rows="3" id="mp_decision" name="mp_decision">'.esc_textarea($value).'</textarea>';
   else echo '<input style="width:100%" type="text" id="mp_'.esc_attr($k).'" name="mp_'.esc_attr($k).'" value="'.esc_attr($value).'">'; echo '</p>';
  }
  echo '<p><strong>Security:</strong> Only administrators may approve or revoke. The public record never exposes serial numbers, evidence or decision notes. Do not mark verified without an actual independent review.</p>';
 }
 public static function save_record($post_id,$post){
  if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE)return;
  if(!isset($_POST['mp_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mp_nonce'])),self::NONCE)||!self::can_review())return;
  $old=get_post_meta($post_id,'_mp_status',true);
  foreach(['id','status','product','brand','model','serial','reviewer','decision','date','expires','evidence'] as $k){
   if(!isset($_POST['mp_'.$k]))continue;
   $raw=wp_unslash($_POST['mp_'.$k]); $val=$k==='decision'?sanitize_textarea_field($raw):sanitize_text_field($raw);
   if($k==='id' && !preg_match('/^[A-Za-z0-9_-]{4,80}$/',$val))continue;
   if($k==='status'&&!in_array($val,['pending','in_review','verified','rejected','revoked','expired'],true))continue;
   if($k==='product')$val=absint($val);
   if(in_array($k,['date','expires'],true)&&$val!==''&&!preg_match('/^\d{4}-\d{2}-\d{2}$/',$val))continue;
   update_post_meta($post_id,'_mp_'.$k,$val);
  }
  $new=get_post_meta($post_id,'_mp_status',true);
  if($new!==$old){update_post_meta($post_id,'_mp_status_updated',gmdate('c')); update_post_meta($post_id,'_mp_status_changed_by',get_current_user_id());}
  // A record must have a unique ID and an explicitly assigned linked product.
 }
 public static function find($id){
  if(!preg_match('/^[A-Za-z0-9_-]{4,80}$/',$id))return null;
  $q=new WP_Query(['post_type'=>'mp_record','post_status'=>'publish','posts_per_page'=>2,'no_found_rows'=>true,'meta_query'=>[['key'=>'_mp_id','value'=>$id,'compare'=>'=']]]);
  return count($q->posts)===1?$q->posts[0]:null;
 }
 public static function product_record($product_id){
  $id=get_post_meta($product_id,self::META,true); if(!$id)return null;
  $post=self::find($id);if(!$post)return null;
  if((int)get_post_meta($post->ID,'_mp_product',true)!==(int)$product_id)return null;
  return $post;
 }
 public static function verified($post){
  if(!$post||get_post_meta($post->ID,'_mp_status',true)!=='verified')return false;
  $expiry=get_post_meta($post->ID,'_mp_expires',true);
  return !$expiry || (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/',$expiry)&&$expiry>=gmdate('Y-m-d');
 }
 public static function public_data($post){
  $status=get_post_meta($post->ID,'_mp_status',true)?:'pending';
  if($status==='verified'&&!self::verified($post))$status='expired';
  return ['id'=>get_post_meta($post->ID,'_mp_id',true),'status'=>$status,'badge_active'=>self::verified($post),
   'brand'=>get_post_meta($post->ID,'_mp_brand',true),'model'=>get_post_meta($post->ID,'_mp_model',true),
   'decision_date'=>get_post_meta($post->ID,'_mp_date',true),'expires'=>get_post_meta($post->ID,'_mp_expires',true),
   'lookup_url'=>self::lookup_url(get_post_meta($post->ID,'_mp_id',true))];
 }
 public static function lookup_url($id){return add_query_arg('mp_id',rawurlencode($id),home_url('/maisonproof-verification/'));}
 public static function product_field(){if(!function_exists('woocommerce_wp_text_input'))return;woocommerce_wp_text_input(['id'=>self::META,'label'=>'MaisonProof record ID','description'=>'Must match a published MaisonProof record linked to this product. Merchants cannot approve records.','desc_tip'=>true]);}
 public static function save_product_field($product){if(!current_user_can('edit_post',$product->get_id()))return;$id=isset($_POST[self::META])?sanitize_text_field(wp_unslash($_POST[self::META])):'';if($id===''||preg_match('/^[A-Za-z0-9_-]{4,80}$/',$id))$product->update_meta_data(self::META,$id);}
 public static function badge($product_id){
  $post=self::product_record($product_id);if(!self::verified($post))return '';
  $id=get_post_meta($post->ID,'_mp_id',true);
  return '<a class="mp-seal" href="'.esc_url(self::lookup_url($id)).'" aria-label="View MaisonProof verification record '.esc_attr($id).'" title="View independent verification record"><span class="mp-seal-m" aria-hidden="true">M</span><span class="mp-seal-text">MAISONPROOF<br><small>VERIFIED</small></span></a>';
 }
 public static function single_badge(){global $product;if(!$product||!is_a($product,'WC_Product'))return;$badge=self::badge($product->get_id());if($badge)echo '<div class="mp-single-seal">'.$badge.'</div>';}
 public static function loop_badge(){global $product;if(!$product||!is_a($product,'WC_Product'))return;$badge=self::badge($product->get_id());if($badge)echo '<div class="mp-loop-seal">'.$badge.'</div>';}
 public static function badge_shortcode($atts){$atts=shortcode_atts(['product_id'=>0],$atts);$id=absint($atts['product_id']);if(!$id&&function_exists('is_product')&&is_product())$id=get_the_ID();return $id?self::badge($id):'';}
 public static function styles(){if(!class_exists('WooCommerce'))return;wp_enqueue_style('maisonproof-woo',plugins_url('assets/maisonproof.css',__FILE__),[],self::VERSION);}
 public static function verify_shortcode($atts){
  $atts=shortcode_atts(['id'=>''],$atts);$id=$atts['id']?: (isset($_GET['mp_id'])?sanitize_text_field(wp_unslash($_GET['mp_id'])):'');
  $out='<section class="mp-lookup"><h2>MaisonProof Verification Lookup</h2><form method="get"><label for="mp_lookup_id">Verification record ID</label><div class="mp-lookup-form"><input id="mp_lookup_id" name="mp_id" maxlength="80" required value="'.esc_attr($id).'"><button type="submit">Look up record</button></div></form>';
  if($id){$post=self::find($id);if(!$post)$out.='<p role="status">No published verification record found for this ID.</p>';
   else{$data=self::public_data($post);$out.='<div class="mp-record"><h3>Record '.esc_html($data['id']).'</h3><p><strong>Status:</strong> '.esc_html(strtoupper(str_replace('_',' ',$data['status']))).'</p><p><strong>Brand:</strong> '.esc_html($data['brand']).'</p><p><strong>Item:</strong> '.esc_html($data['model']).'</p><p><strong>Decision date:</strong> '.esc_html($data['decision_date']?:'Not issued').'</p>';
    if($data['expires'])$out.='<p><strong>Expiration:</strong> '.esc_html($data['expires']).'</p>';
    if(!$data['badge_active'])$out.='<p>This item does not have an active MaisonProof verification badge.</p>';
    $out.='</div>';
   }
  }
  return $out.'</section>';
 }
 public static function rest_routes(){register_rest_route('maisonproof/v1','/records/(?P<id>[A-Za-z0-9_-]{4,80})',['methods'=>'GET','callback'=>function($request){$post=self::find($request['id']);return $post?rest_ensure_response(self::public_data($post)):new WP_Error('mp_not_found','Record not found',['status'=>404]);},'permission_callback'=>'__return_true']);}
 public static function submit_shortcode(){
  if(!is_user_logged_in())return '<p>Please sign in to submit supporting evidence.</p>';
  $products=function_exists('wc_get_products')?wc_get_products(['limit'=>100,'status'=>'publish','return'=>'objects']):[];
  $out='<form class="mp-submit" action="'.esc_url(admin_url('admin-post.php')).'" method="post" enctype="multipart/form-data"><h3>Submit evidence for review</h3><p>Submission does not grant verification. Files are reviewed separately by MaisonProof.</p>';
  $out.='<input type="hidden" name="action" value="mp_submit_evidence">'.wp_nonce_field('mp_submit_evidence','mp_submit_nonce',true,false);
  $out.='<label>WooCommerce product <select name="mp_product_id" required><option value="">Select your product</option>';
  foreach($products as $product){if(!current_user_can('edit_post',$product->get_id()))continue;$out.='<option value="'.esc_attr($product->get_id()).'">'.esc_html($product->get_name()).'</option>';}
  $out.='</select></label><label>Item notes <textarea name="mp_notes" maxlength="3000" required></textarea></label><label>Supporting image or PDF (max 5 MB) <input type="file" name="mp_file" accept="image/jpeg,image/png,image/webp,application/pdf" required></label><button type="submit">Submit for review</button></form>';
  if(isset($_GET['mp_submitted']))$out.='<p role="status">Submission received for administrative review. No authenticity decision has been made.</p>';
  return $out;
 }
 public static function submit_evidence(){
  if(!is_user_logged_in()||!isset($_POST['mp_submit_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mp_submit_nonce'])),'mp_submit_evidence'))wp_die('Invalid submission',403);
  $id=isset($_POST['mp_product_id'])?absint($_POST['mp_product_id']):0;
  if(!$id||!current_user_can('edit_post',$id)||get_post_type($id)!=='product')wp_die('Not authorized for this product',403);
  if(empty($_FILES['mp_file']['tmp_name'])||!is_uploaded_file($_FILES['mp_file']['tmp_name'])||$_FILES['mp_file']['size']>5*1024*1024)wp_die('Invalid file',400);
  $types=['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','webp'=>'image/webp','pdf'=>'application/pdf'];
  $check=wp_check_filetype_and_ext($_FILES['mp_file']['tmp_name'],$_FILES['mp_file']['name'],$types);
  if(empty($check['ext'])||!in_array($check['type'],array_values($types),true))wp_die('Unsupported file type',400);
  require_once ABSPATH.'wp-admin/includes/file.php';require_once ABSPATH.'wp-admin/includes/media.php';require_once ABSPATH.'wp-admin/includes/image.php';
  $attachment=media_handle_upload('mp_file',0,[],['test_form'=>false,'mimes'=>$types]);
  if(is_wp_error($attachment))wp_die('Upload failed',400);
  // Evidence media URLs may be publicly accessible on standard WordPress uploads. Use private storage before handling sensitive evidence.
  $notes=isset($_POST['mp_notes'])?sanitize_textarea_field(wp_unslash($_POST['mp_notes'])):'';
  $submission=wp_insert_post(['post_type'=>'mp_submission','post_status'=>'private','post_title'=>'Evidence submission for product '.$id,'post_author'=>get_current_user_id()],true);
  if(!is_wp_error($submission)){update_post_meta($submission,'_mp_product',$id);update_post_meta($submission,'_mp_attachment',$attachment);update_post_meta($submission,'_mp_notes',$notes);}
  wp_safe_redirect(add_query_arg('mp_submitted','1',wp_get_referer()?:home_url('/')));exit;
 }
 public static function admin_menu(){add_submenu_page('edit.php?post_type=mp_record','MaisonProof Settings','Settings','manage_options','mp-settings',[__CLASS__,'settings_page']);}
 public static function settings(){register_setting('mp_options','mp_badge_position',['type'=>'string','sanitize_callback'=>function($value){return in_array($value,['top-right','top-left','bottom-right','bottom-left'],true)?$value:'top-right';},'default'=>'top-right']);}
 public static function settings_page(){echo '<div class="wrap"><h1>MaisonProof Settings</h1><p>Only authorized administrators can issue verification decisions. Create a published record, assign its unique ID and linked WooCommerce product ID, and set the status after a genuine review.</p><form action="options.php" method="post">';settings_fields('mp_options');echo '<p><label>Badge placement <select name="mp_badge_position">';foreach(['top-right','top-left','bottom-right','bottom-left'] as $v)echo '<option value="'.esc_attr($v).'" '.selected(get_option('mp_badge_position','top-right'),$v,false).'>'.esc_html(ucwords(str_replace('-',' ',$v))).'</option>';echo '</select></label></p>';submit_button();echo '</form><p>Public lookup shortcode: <code>[maisonproof_verify]</code>. Product badge: <code>[maisonproof_badge product_id="123"]</code>. Merchant form: <code>[maisonproof_submit]</code>.</p></div>';}
 public static function columns($cols){$cols['mp_status']='Verification status';$cols['mp_id']='Record ID';return $cols;}
 public static function column_data($col,$id){if($col==='mp_status')echo esc_html(get_post_meta($id,'_mp_status',true));if($col==='mp_id')echo esc_html(get_post_meta($id,'_mp_id',true));}
 public static function woo_notice(){if(!class_exists('WooCommerce'))echo '<div class="notice notice-warning"><p>MaisonProof requires WooCommerce for product badges and merchant submissions.</p></div>';}
}
add_action('plugins_loaded',function(){MaisonProof_Woo::init();});
add_action('init',function(){register_post_type('mp_submission',['label'=>'MaisonProof Submissions','public'=>false,'show_ui'=>true,'show_in_menu'=>'edit.php?post_type=mp_record','supports'=>['title'],'capabilities'=>['create_posts'=>'do_not_allow'],'map_meta_cap'=>true]);},11);
add_action('wp_head',function(){if(!class_exists('WooCommerce'))return;$pos=get_option('mp_badge_position','top-right');$vertical=strpos($pos,'bottom')===0?'bottom:12px;':'top:12px;';$horizontal=substr($pos,-4)==='left'?'left:12px;':'right:12px;';echo '<style>.mp-single-seal,.mp-loop-seal{'.esc_html($vertical.$horizontal).'}</style>';});
