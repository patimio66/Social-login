<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class OAuthSignIn extends Module implements WidgetInterface
{
    public function __construct()
    {
        $this->name = 'oauthsignin';
        $this->author = 'Adam Mańko';
        $this->version = '1.0';
        $this->need_instance = false;
        
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = 'OAuth2 Sign In Module';
        $this->description = 'Module provides users sign in with Google or Apple';
        $this->confirmUninstall = '';
    
        $this->ps_versions_compliancy = [
            "min" => "8.0",
            "max" => _PS_VERSION_
        ];
    }

    /**
     * @return bool
     */
    public function install()
    {
        return parent::install()
            && $this->registerHook('displayCustomerLoginFormAfter')
            && $this->registerHook('header');
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        return parent::uninstall();
    }

    public function getContent()
    {
        $route = $this->get('router')->generate('o_auth_sign_in');
        Tools::redirectAdmin($route);
    }  
    
    public function renderWidget($hookName, array $configuration)
    {
        if (!$this->isCached('module:oauthsignin/views/templates/hook/displayAfterLoginForm.tpl', 
            $this->getCacheId())) {

            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }
        
        return $this->fetch('module:oauthsignin/views/templates/hook/displayAfterLoginForm.tpl', $this->getCacheId());

    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        $container = SymfonyContainer::getInstance();

        $googleLoginService = $container->get('prestashop.module.oauthsignin.google_login_service');

        $googleLoginUrl = $googleLoginService->getLoginUrl();
        
        return [
            'name' => 'Adam',
            'google_login_url' => $googleLoginUrl
        ];
    }

    public function hookDisplayCustomerLoginFormAfter($params)
    {
        return $this->renderWidget('displayCustomerLoginFormAfter', $params);
    }

    public function hookHeader($params)
    {
        // Rejestracja stylu z pliku w module
        $this->context->controller->registerStylesheet(
            'oauthsignin-style',                           // unikalny ID zasobu
            'modules/'.$this->name.'/views/css/oauth.css', // ścieżka do pliku w module
            [ 'media' => 'all', 'priority' => 150 ]
        );
    }
}
