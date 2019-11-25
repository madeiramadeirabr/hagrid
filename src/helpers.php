<?php

use \MMSecretsManager\SecretsManager;
use \MMSecretsManager\EnvManager;

if (!function_exists('secrets_manager')) {
    /**
     * This function consider you are using aws role system on EC2.
     *
     * @param string $secretId
     * @param bool $verifyGlobals
     * @return mixed
     * @throws \MMSecretsManager\Exception\SecretsManagerException
     */
    function secrets_manager(string $secretId): string
    {
        $secretsManager = (new SecretsManager($secretId));

        $secretValue = $secretsManager->getSecretValue();

        return $secretValue;
    }
}

if (!function_exists('env_manager')) {
    /**
     * @param string $baseDir
     * @param string $secretId
     * @throws \MMSecretsManager\Exception\SecretsManagerException
     */
    function env_manager(string $baseDir, string $secretId)
    {
        $envManager = (new EnvManager($baseDir));

        if (!$envManager->verifyEnvExists()) {
            $secretValue = secrets_manager($secretId);

            $envManager->createEnv(json_decode($secretValue));
        }
    }
}
