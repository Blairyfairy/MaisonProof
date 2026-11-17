<?php
namespace Drupal\maisonproof_verify\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
/** @Block(id="maisonproof_badge", admin_label=@Translation("MaisonProof authentication badge")) */
final class MaisonproofBadge extends BlockBase {
 public function defaultConfiguration(): array { return ['sku'=>''] + parent::defaultConfiguration(); }
 public function blockForm($form, FormStateInterface $form_state): array {
  $form['sku']=['#type'=>'textfield','#title'=>$this->t('Product SKU'),'#default_value'=>$this->configuration['sku'],'#required'=>TRUE];return $form;
 }
 public function blockSubmit($form, FormStateInterface $form_state): void {$this->configuration['sku']=$form_state->getValue('sku');}
 public function build(): array {
  $c=\Drupal::config('maisonproof_verify.settings');$sku=$this->configuration['sku'];$store=$c->get('store_id');$base=$c->get('api_url');
  if (!$sku || !$store || !$base) return [];
  $url=rtrim($base,'/').'/v1/public/'.rawurlencode($store).'/'.rawurlencode($sku);
  try {
   $res=\Drupal::httpClient()->get($url,['timeout'=>3,'http_errors'=>FALSE]);
   if ($res->getStatusCode()!==200) return [];
   $data=json_decode((string)$res->getBody(),TRUE);
   if (($data['status']??'')!=='authenticated') return [];
   return ['#type'=>'inline_template','#template'=>'<span class="maisonproof-proof"><span class="maisonproof-proof__mark">✓</span><strong class="maisonproof-proof__name">MAISONPROOF</strong> <span class="maisonproof-proof__status">Independently authenticated</span> <a href="{{ url }}">View record</a></span>','#context'=>['url'=>$url],'#attached'=>['library'=>['maisonproof_verify/badge']],'#cache'=>['max-age'=>60]];
  } catch (\Throwable $e) {return [];}
 }
}
