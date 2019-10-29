<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\test_api_key\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;


class ExtendedSiteInformationForm extends SiteInformationForm {

   /**
   * {@inheritdoc}
   */
    public function buildForm(array $form, FormStateInterface $form_state) {
      $form =  parent::buildForm($form, $form_state);
      $form['site_information']['site_api_key'] = [
          '#type' => 'textfield',
          '#title' => t('Site API Key'),
          '#default_value' => \Drupal::config('siteapikey.configuration')->get('siteapikey'),
          '#description' => t("Custom field to set the API Key"),
      ];
      $form['actions'] = array(
        '#type' => 'submit',
        '#value' => t('Update configuration')
      );
      return $form;
  }

    public function submitForm(array &$form, FormStateInterface $form_state) {
      $api_key_conf = \Drupal::configFactory()->getEditable('siteapikey.configuration');
      $new_key = $form_state->getValue('site_api_key');
      if($new_key != 'No API Key yet') {
        $api_key_conf->set('siteapikey', $new_key);
        $api_key_conf->save();
        // API Key Form Submit.
        parent::submitForm($form, $form_state);
        drupal_set_message("And New API Key Set to '" . $new_key."'");
      } else {
        // Not Change Message;
      }
    }
}