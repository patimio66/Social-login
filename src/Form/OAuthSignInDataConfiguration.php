<?php
declare(strict_types=1);

namespace PrestaShop\Module\OAuthSignIn\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\InvalidParameterException;

/**
 * Configuration is used to save data to configuration table and retrieve from it.
 */
final class OAuthSignInDataConfiguration implements DataConfigurationInterface
{
    public const OAUTH_GOOGLE_CLIENT_ID = 'OAUTH_GOOGLE_CLIENT_ID';
    public const OAUTH_GOOGLE_CLIENT_SECRET = 'OAUTH_GOOGLE_CLIENT_SECRET';
    public const CONFIG_MAXLENGTH = 255;

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(ConfigurationInterface $configuration, RouterInterface $router)
    {
        $this->configuration = $configuration;
        $this->router = $router;
    }

    public function getConfiguration(): array
    {
        $return = [];

        $redirectUrl = 'Niezdefiniowany URL';

        try {
            $redirectUrl = $this->router->generate('google_callback', [], UrlGeneratorInterface::ABSOLUTE_URL);
            var_dump('redirect url = ' . $redirectUrl);
            die;
        } catch (RouteNotFoundException $e) {
            var_dump('Route not found: ' . $e->getMessage());
            die;
        }
        
        $return = [ 
            'google_client_id' => $this->configuration->get(self::OAUTH_GOOGLE_CLIENT_ID),
            'google_client_secret' => $this->configuration->get(self::OAUTH_GOOGLE_CLIENT_SECRET),
            'redirect_url' => $redirectUrl
        ];

        return $return;
    }

    public function updateConfiguration(array $configuration): array
    {
        $errors = [];

        if (!$this->validateConfiguration($configuration)) {
            $errors[] = 'Google Client ID and Google Secret must not be empty.';
            return $errors;
        }

        $clientId = trim($configuration['google_client_id']);
        $clientSecret = trim($configuration['google_client_secret']);

        if (empty($clientId)) {
            $errors[] = 'Google Client ID cannot be empty.';
        } elseif (strlen($clientId) > self::CONFIG_MAXLENGTH) {
            $errors[] = 'Google Client ID is too long.';
        }

        if (empty($clientSecret)) {
            $errors[] = 'Google Client Secret cannot be empty.';
        } elseif (strlen($clientSecret) > self::CONFIG_MAXLENGTH) {
            $errors[] = 'Google Client Secret is too long.';
        }

        if (empty($errors)) {
            $this->configuration->set(static::OAUTH_GOOGLE_CLIENT_ID, $clientId);
            $this->configuration->set(static::OAUTH_GOOGLE_CLIENT_SECRET, $clientSecret);
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
        return isset($configuration['google_client_id']) && isset($configuration['google_client_secret']);
    }
}
