<?php
declare(strict_types=1);

namespace PrestaShop\Module\OAuthSignIn\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;
use Context;

/**
 * Configuration is used to save data to configuration table and retrieve from it.
 */
final class OAuthSignInDataConfiguration implements DataConfigurationInterface
{
    public const OAUTH_GOOGLE_ENABLED = 'OAUTH_GOOGLE_ENABLED';
    public const OAUTH_GOOGLE_CLIENT_ID = 'OAUTH_GOOGLE_CLIENT_ID';
    public const OAUTH_GOOGLE_CLIENT_SECRET = 'OAUTH_GOOGLE_CLIENT_SECRET';

    public const OAUTH_FACEBOOK_ENABLED = 'OAUTH_FACEBOOK_ENABLED';
    public const OAUTH_FACEBOOK_APP_ID = 'OAUTH_FACEBOOK_APP_ID';
    // public const OAUTH_FACEBOOK_CLIENT_SECRET = 'OAUTH_FACEBOOK_CLIENT_SECRET';
    public const CONFIG_MAXLENGTH = 255;

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getConfiguration(): array
    {
        $return = [];
        
        //generating link viewed in module back office form field
        $context = Context::getContext();
        //funkcja getModuleLink wymusza protokół https, to spowoduje potencjalne błędy jeśli strona nie ma ssl
        $redirectUrl = $context->link->getModuleLink(
            'oauthsignin',
            'googlecallback',
            [],
            true
        );

        $return = [
            'enable_google' => $this->configuration->get(self::OAUTH_GOOGLE_ENABLED),
            'google_client_id' => $this->configuration->get(self::OAUTH_GOOGLE_CLIENT_ID),
            'google_client_secret' => $this->configuration->get(self::OAUTH_GOOGLE_CLIENT_SECRET),
            'redirect_url' => $redirectUrl,
            'enable_facebook' => $this->configuration->get(self::OAUTH_FACEBOOK_ENABLED),
            'fb_app_id' => $this->configuration->get(self::OAUTH_FACEBOOK_APP_ID)
        ];

        return $return;
    }

    public function updateConfiguration(array $configuration): array
    {
        $errors = []; 

        /* if (!$this->validateConfiguration($configuration)) {
            $errors[] = 'Google Client ID and Google Secret must not be empty.';
            return $errors;
        } */

        $enableGoogle = isset($configuration['enable_google']) && (bool)($configuration['enable_google']);
        $enableFacebook = isset($configuration['enable_facebook']) && (bool)($configuration['enable_facebook']);

        if ($enableGoogle){
            $googleClientId = trim($configuration['google_client_id'] ?? '');
            $googleClientSecret = trim($configuration['google_client_secret'] ?? '');

            if (empty($googleClientId)) {
                $errors[] = 'Google Client ID cannot be empty.';
            } elseif (strlen($googleClientId) > self::CONFIG_MAXLENGTH) {
                $errors[] = 'Google Client ID is too long.';
            }

            if (empty($googleClientSecret)) {
                $errors[] = 'Google Client Secret cannot be empty.';
            } elseif (strlen($googleClientSecret) > self::CONFIG_MAXLENGTH) {
                $errors[] = 'Google Client Secret is too long.';
            }
        
            if (empty($errors)) {
                $this->configuration->set(self::OAUTH_GOOGLE_CLIENT_ID, $googleClientId);
                $this->configuration->set(self::OAUTH_GOOGLE_CLIENT_SECRET, $googleClientSecret);
                $this->configuration->set(self::OAUTH_GOOGLE_ENABLED, true);
            } 
        } else {
            $this->configuration->set(self::OAUTH_GOOGLE_ENABLED, false);
        }
            
        if ($enableFacebook){
            $fbAppId = trim($configuration['fb_app_id'] ?? '');
            
            if (empty($fbAppId)) {
                $errors[] = 'Facebook App ID cannot be empty.';
            } elseif (strlen($fbAppId) > self::CONFIG_MAXLENGTH) {
                $errors[] = 'Facebook App ID is too long.';
            }
        

            if (empty($errors)) {
                $this->configuration->set(self::OAUTH_FACEBOOK_APP_ID, $fbAppId);
                $this->configuration->set(self::OAUTH_FACEBOOK_ENABLED, true);
            // $this->configuration->set(self::OAUTH_GOOGLE_CLIENT_SECRET, $fbClientSecret);
            }
        } else {
            $this->configuration->set(self::OAUTH_FACEBOOK_ENABLED, false);
        }

        return $errors;
    }

    /**
     * Ensure the parameters passed are valid.
     *
     * @return bool Returns true if no exception are thrown
     */
    public function validateConfiguration(array $configuration): bool
    {
        return isset($configuration['google_client_id']) && isset($configuration['google_client_secret']);
    }
}
