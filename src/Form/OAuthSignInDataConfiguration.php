<?php
declare(strict_types=1);

namespace PrestaShop\Module\FirstModule\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;

/**
 * Configuration is used to save data to configuration table and retrieve from it.
 */
final class FirstModuleDataConfiguration implements DataConfigurationInterface
{
    public const FIRST_MODULE_FORM_SIMPLE_TEXT_TYPE = 'FIRST_MODULE_FORM_SIMPLE_TEXT_TYPE';
    public const CONFIG_MAXLENGTH = 32;
    public const FIRST_MODULE_CHOICE_FIELD = 'FIRST_MODULE_CHOICE_FIELD';

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

        $return = [ 
            'config_text' => $this->configuration->get(static::FIRST_MODULE_FORM_SIMPLE_TEXT_TYPE),
            'choice_field' => $this->configuration->get(static::FIRST_MODULE_CHOICE_FIELD),
        ];

        return $return;
    }

    public function updateConfiguration(array $configuration): array
    {
        $errors = [];

        if ($this->validateConfiguration($configuration)) {
            if (strlen($configuration['config_text']) <= static::CONFIG_MAXLENGTH) {
                $this->configuration->set(static::FIRST_MODULE_FORM_SIMPLE_TEXT_TYPE, $configuration['config_text']);
            } else {
                $errors[] = 'FIRST_MODULE_FORM_SIMPLE_TEXT_TYPE value is too long';
            }
        }

        if ($this->validateConfiguration($configuration)) {
            if (($configuration['choice_field']) == ('A' || 'B' || 'C')) {
                $this->configuration->set(static::FIRST_MODULE_CHOICE_FIELD, $configuration['choice_field']);
            } else {
                $errors[] = 'FIRST_MODULE_CHOICE_FIELD wrong choice choosen';
            }
        }

        /* Errors are returned here. */
        return $errors;
    }

    /**
     * Ensure the parameters passed are valid.
     *
     * @return bool Returns true if no exception are thrown
     */
    public function validateConfiguration(array $configuration): bool
    {
        return isset($configuration['config_text']) && isset($configuration['choice_field']);
    }
}
