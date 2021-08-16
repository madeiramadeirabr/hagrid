<?php

use \Hagrid\SecretsManager;
use \Hagrid\EnvManager;
use \Hagrid\Exception\SecretsManagerException;

if (!function_exists('retrive_secrets')) {

    /**
     * Retrive data from secrets manager, considering you are using aws role system on EC2.
     *
     * @param string $secretId
     * @param string|null $env
     * @return mixed
     * @throws \Hagrid\Exception\SecretsManagerException
     */
    function retrive_secrets(string $secretId, string $env = null): string
    {
        if (!is_null($env)) {
            if (!in_array($env, ['staging', 'sandbox', 'production'])) {
                throw SecretsManagerException::invalidEnvironment();
            }

            $secretId = sprintf('%s-%s', $secretId, $env);
        }

        $secretsManager = (new SecretsManager($secretId));

        $secretValue = $secretsManager->getSecretValue();

        return $secretValue;
    }
}

if (!function_exists('create_env_file')) {

    /**
     * Creates the env file if it don't exists in directory. The env data is read from secrets manager.
     *
     * @param string $baseDir
     * @param string $secretId
     * @param string|null $env
     * @return bool
     * @throws \Hagrid\Exception\SecretsManagerException
     */
    function create_env_file(string $baseDir, string $secretId, string $env = null): bool
    {
        $fileCreated = false;

        $envManager = (new EnvManager($baseDir));

        if (!$envManager->verifyEnvExists()) {
            $secretValue = retrive_secrets($secretId, $env);

            $fileCreated = $envManager->createEnvFile(json_decode($secretValue));
        }

        return $fileCreated;
    }
}

if (!function_exists('add_env_vars')) {

    /**
     * Add envronment variables, read from secrets manager, on server.
     *
     * @param string $secretId
     * @param string|null $env
     * @throws \Hagrid\Exception\SecretsManagerException
     */
    function add_env_vars(string $secretId, string $env = null): void
    {
        $envManager = (new EnvManager());

        $secretValue = retrive_secrets($secretId, $env);

        $envManager->addEnvVars(json_decode($secretValue));
    }
}
