<?php

declare(strict_types=1);

namespace PrestaShop\Module\OAuthSignIn\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

/**
 * Provides form data for OAuth configuration by delegating to the configuration instance
 */
class OAuthSignInFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var DataConfigurationInterface
     */
    private $oAuthSignInDataConfiguration;

    /**
     * @param DataConfigurationInterface $oAuthSignInDataConfiguration
     */
    public function __construct(DataConfigurationInterface $oAuthSignInDataConfiguration)
    {
        $this->oAuthSignInDataConfiguration = $oAuthSignInDataConfiguration;
    }

    /**
     * Retrieves the form data for OAuth configuration
     *
     * @return array Returns an array of configuration values
     */
    public function getData(): array
    {
        return $this->oAuthSignInDataConfiguration->getConfiguration();
    }

    /**
     * Updates the OAuth configuration with the provided form data
     *
     * @param array $data Array of new configuration values
     *
     * @return array Returns an empty array on success or an array of error messages
     */
    public function setData(array $data): array
    {
        return $this->oAuthSignInDataConfiguration->updateConfiguration($data);
    }
}
