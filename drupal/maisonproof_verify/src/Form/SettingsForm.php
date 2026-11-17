<?php
namespace Drupal\maisonproof_verify\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
final class SettingsForm extends ConfigFormBase {
 protected function getEditableConfigNames(): array { return ['maisonproof_verify.settings']; }
 public function getFormId(): string { return 'maisonproof_verify_settings'; }
 public function buildForm(array $form, FormStateInterface $form_state): array {
  $c=$this->config('maisonproof_verify.settings');
  $form['api_url']=['#type'=>'url','#title'=>$this->t('HTTPS service URL'),'#default_value'=>$c->get('api_url'),'#required'=>TRUE];
  $form['store_id']=['#type'=>'textfield','#title'=>$this->t('Store ID'),'#default_value'=>$c->get('store_id'),'#required'=>TRUE];
  return parent::buildForm($form,$form_state);
 }
 public function validateForm(array &$form, FormStateInterface $form_state): void {
  if (!str_starts_with($form_state->getValue('api_url'),'https://')) $form_state->setErrorByName('api_url',$this->t('HTTPS is required.'));
  if (!preg_match('/^[A-Za-z0-9_-]{1,100}$/',$form_state->getValue('store_id'))) $form_state->setErrorByName('store_id',$this->t('Invalid store ID.'));
  parent::validateForm($form,$form_state);
 }
 public function submitForm(array &$form, FormStateInterface $form_state): void {
  $this->configFactory()->getEditable('maisonproof_verify.settings')->set('api_url',rtrim($form_state->getValue('api_url'),'/'))->set('store_id',$form_state->getValue('store_id'))->save();parent::submitForm($form,$form_state);
 }
}
