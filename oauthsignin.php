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

class OAuthSignIn extends Module
{
    public function __construct()
    {
        $this->name = 'oauthsignin';
        $this->author = 'Adam Mańko';
        $this->version = '1.0';
        $this->need_instance = false;
        
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = 'Oauth Sign In Module';
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
        return parent::install();
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
}
