<?php

use \MMSecretsManager\SecretsManager;
use \MMSecretsManager\EnvManager;

if (!function_exists('retrive_secrets')) {

    /**
     * Retrive data from secrets manager, considering you are using aws role system on EC2.
     *
     * @param string $secretId
     * @param bool $verifyGlobals
     * @return mixed
     * @throws \MMSecretsManager\Exception\SecretsManagerException
     */
    function retrive_secrets(string $secretId): string
    {
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
     * @throws \MMSecretsManager\Exception\SecretsManagerException
     */
    function create_env_file(string $baseDir, string $secretId)
    {
        $envManager = (new EnvManager($baseDir));

        if (!$envManager->verifyEnvExists()) {
            $secretValue = retrive_secrets($secretId);

            $envManager->createEnvFile(json_decode($secretValue));
        }
    }
}

if (!function_exists('add_env_vars')) {

    /**
     * Add envronment variables, read from secrets manager, on server.
     *
     * @param string $secretId
     * @throws \MMSecretsManager\Exception\SecretsManagerException
     */
    function add_env_vars(string $secretId)
    {
        $envManager = (new EnvManager());

        $secretValue = retrive_secrets($secretId);

        $envManager->addEnvVars(json_decode($secretValue));
    }
}
