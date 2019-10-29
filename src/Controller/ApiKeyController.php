<?php

namespace Drupal\test_api_key\Controller;

use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class ApiKeyController {
  /**
   * 
   * @param type $site_api_key - Used for Match configuration saved value.
   * @param NodeInterface $node - Used to check Node id given is Page or Not.
   * @return JsonResponse
   */
  public function content($site_api_key, NodeInterface $node) {
    // Site API Key configuration value
    $conf_saved = \Drupal::config('siteapikey.configuration')->get('siteapikey');

    // Checking parse node is a page, Configuration Value is not default "No API Key yet" and matches the entered key
    if($node->getType() == 'page' && $conf_saved != 'No API Key yet' && $conf_saved == $site_api_key) {
      return new JsonResponse($node->toArray(), 200, ['Content-Type'=> 'application/json']);
    } else {
      // Respond with access denied
      return new JsonResponse(array("error" => "access denied"), 401, ['Content-Type'=> 'application/json']);
    }
  }
}