<?php


namespace Hagrid\Exception;

/**
 * Class SecretsManagerException
 * @package Hagrid\Exception
 */
class SecretsManagerException extends \Exception
{
    /**
     * @return SecretsManagerException
     */
    public static function emptyAwsId(): SecretsManagerException
    {
        return new self("Aws id can't be empty.", 400);
    }

    /**
     * @return SecretsManagerException
     */
    public static function emptyAwsKey(): SecretsManagerException
    {
        return new self("Aws key can't be empty.", 400);
    }

    /**
     * @return SecretsManagerException
     */
    public static function emptyAwsRegion(): SecretsManagerException
    {
        return new self("Aws region can't be empty.", 400);
    }

    /**
     * @return SecretsManagerException
     */
    public static function emptySecretId(): SecretsManagerException
    {
        return new self("Secret id can't be empty.", 400);
    }
}
