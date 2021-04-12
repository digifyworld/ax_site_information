<?php
/**
 * @file
 * Contains \Drupal\ax_site_information\Controller\AxSiteInformationController.
 */
namespace Drupal\ax_site_information\Controller;

use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class AxSiteInformationController {
    /**
     * @param $site_api_key
     * @param NodeInterface $node
     * @return JsonResponse
     */
    public function getJson($site_api_key, NodeInterface $node){
        // Retrieve site API Key configuration value.
        $config_factory = \Drupal::configFactory();
        $site_config = $config_factory->getEditable('system.site');
        $site_api_key_value = $site_config->get('siteapikey');

        // Check that the node is of type page and the site api key matches the key in the URL.
        if($node->getType() == 'page' && $site_api_key_value != 'No API Key yet' && $site_api_key_value == $site_api_key){
            // Return json representation of the node.
            return new JsonResponse($node->toArray(), 200, ['Content-Type'=> 'application/json']);
        }

        // Return access denied if api key or node type doesn't match.
        return new JsonResponse(array("Error" => "access denied"), 401, ['Content-Type'=> 'application/json']);
    }
}
