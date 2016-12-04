<?php

namespace Kanboard\Plugin\OAuth2\Controller;

use Kanboard\Controller\OAuthController as BaseOAuthController;

/**
 * OAuth Controller
 *
 * @package  Kanboard\Controller
 * @author   Frederic Guillot
 */
class OAuthController extends BaseOAuthController
{
    /**
     * Handle authentication
     *
     * @access public
     */
    public function handler()
    {
        $this->step1('OAuth2');
    }
}
