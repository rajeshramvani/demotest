<?php
/**
 * @file
 * Contains \Drupal\demo_test\Controller\DemoTestController.
 */
namespace Drupal\demo_test\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * DemoTestController.
 */
class DemoTestController extends ControllerBase {
	
	/**
	 * @param $siteapikey match with site information settings siteapikey field
	 * @param $nid nid check for only page content type
	 */
	
	public function content($siteapikey, $nid) {
		$site_api_key = \Drupal::config ( 'demo_test.settings' )->get ( 'demo_test.siteapikey' );
		if ($site_api_key == $siteapikey && ! empty ( $nid )) {
			$node = Node::load ( $nid );
			if ($node->getType () == "page") {
				$data = array ();
				$data ['title'] = $node->getTitle ();
				$data ['body'] = $node->body->value;
				
				return new JsonResponse ( $data, 200, ['Content-Type' => 'application/json'] );
				
			} else {
				$message = t ( "Access denied" );
				return new JsonResponse($message, 403, ['Content-Type'=> 'application/json']);
			}
		} else {
			$message=t("Access denied");
			return new JsonResponse($message, 403, ['Content-Type'=> 'application/json']);
		}
		exit;
	}
}