<?php

declare(strict_types=1);

namespace Prestashop\Module\OAuthSignIn\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

/**
 * Provider is responsible for providing form data, in this case, it is returned from the configuration component.
 *
 * Class OAuthSignInFormDataProvider
 */
class OAuthSignInFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var DataConfigurationInterface
     */
    private $oAuthSignInDataConfiguration;

    public function __construct(DataConfigurationInterface $oAuthSignInDataConfiguration)
    {
        $this->oAuthSignInDataConfiguration = $oAuthSignInDataConfiguration;
    }

    public function getData(): array
    {
        return $this->oAuthSignInDataConfiguration->getConfiguration();
    }

    public function setData(array $data): array
    {
        return $this->oAuthSignInDataConfiguration->updateConfiguration($data);
    }
}
