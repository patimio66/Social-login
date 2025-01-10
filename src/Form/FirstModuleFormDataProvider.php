<?php

declare(strict_types=1);

namespace PrestaShop\Module\FirstModule\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

/**
 * Provider is responsible for providing form data, in this case, it is returned from the configuration component.
 *
 * Class FirstModuleFormDataProvider
 */
class FirstModuleFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var DataConfigurationInterface
     */
    private $firstModuleDataConfiguration;

    public function __construct(DataConfigurationInterface $firstModuleDataConfiguration)
    {
        $this->firstModuleDataConfiguration = $firstModuleDataConfiguration;
    }

    public function getData(): array
    {
        return $this->firstModuleDataConfiguration->getConfiguration();
    }

    public function setData(array $data): array
    {
        return $this->firstModuleDataConfiguration->updateConfiguration($data);
    }
}
