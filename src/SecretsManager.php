<?php

namespace MMSecretsManager;

use Aws\Credentials\Credentials;
use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;
use MMSecretsManager\Exception\SecretsManagerException;

/**
 * Class SecretsManager
 * @package MMSecretsManager
 */
class SecretsManager
{
    /**
     * @var string
     */
    private $awsId;

    /**
     * @var string
     */
    private $awsKey;

    /**
     * @var string
     */
    private $awsRegion;

    /**
     * @var SecretsManagerClient
     */
    private $client;

    /**
     * @var string
     */
    private $secretId;

    /**
     * SecretsManager constructor.
     * @param string $awsRegion
     * @param string|null $secretId
     * @param string|null $awsId
     * @param string|null $awsKey
     * @throws SecretsManagerException
     */
    public function __construct(?string $secretId = null, string $awsRegion = 'us-east-2', ?string $awsId = null, ?string $awsKey = null)
    {
        $this->setAwsRegion($awsRegion);

        if (!is_null($awsId))
            $this->setAwsId($awsId);

        if (!is_null($awsKey))
            $this->setAwsKey($awsKey);

        if (!is_null($secretId))
            $this->setSecretId($secretId);
    }

    /**
     * @return string|null
     */
    public function getAwsId(): ?string
    {
        return $this->awsId;
    }

    /**
     * @param string $awsId
     * @return SecretsManager
     * @throws SecretsManagerException
     */
    public function setAwsId(string $awsId): SecretsManager
    {
        try {
            if (is_null($awsId) || empty($awsId))
                throw SecretsManagerException::emptyAwsId();

            $this->awsId = $awsId;
        } catch (SecretsManagerException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAwsKey(): ?string
    {
        return $this->awsKey;
    }

    /**
     * @param string $awsKey
     * @return SecretsManager
     * @throws SecretsManagerException
     */
    public function setAwsKey(string $awsKey): SecretsManager
    {
        try {
            if (is_null($awsKey) || empty($awsKey))
                throw SecretsManagerException::emptyAwsKey();

            $this->awsKey = $awsKey;
        } catch (SecretsManagerException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAwsRegion(): ?string
    {
        return $this->awsRegion;
    }

    /**
     * @param string $awsRegion
     * @return SecretsManager
     * @throws SecretsManagerException
     */
    public function setAwsRegion(string $awsRegion): SecretsManager
    {
        try {
            if (is_null($awsRegion) || empty($awsRegion))
                throw SecretsManagerException::emptyAwsRegion();

            $this->awsRegion = $awsRegion;
        } catch (SecretsManagerException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }

        return $this;
    }

    /**
     * @return SecretsManagerClient
     */
    public function getClient(): SecretsManagerClient
    {
        return $this->client;
    }

    /**
     * @return SecretsManager
     * @throws SecretsManagerException|\Exception
     */
    private function setClient(): SecretsManager
    {
        try {
            $secretsManagerClientData = [
                'version' => 'latest',
                'region' => $this->getAwsRegion(),
            ];

            if (!empty($this->getAwsId()) && !empty($this->getAwsKey())) {
                $credentials = new Credentials($this->getAwsId(), $this->getAwsKey());

                $secretsManagerClientData['credentials'] = $credentials;
            }

            $this->client = new SecretsManagerClient($secretsManagerClientData);
        } catch (SecretsManagerException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSecretId(): ?string
    {
        return $this->secretId;
    }

    /**
     * @param string $secretName
     * @return SecretsManager
     */
    public function setSecretId(string $secretId): SecretsManager
    {
        $this->secretId = $secretId;
        return $this;
    }

    /**
     * @return string
     * @throws AwsException|SecretsManagerException|\Exception
     */
    public function getSecretValue(): string
    {
        try {
            $this->setClient();

            if (is_null($this->getSecretId()) || empty($this->getSecretId()))
                throw SecretsManagerException::emptySecretId();

            $result = $this->client->getSecretValue([
                'SecretId' => $this->getSecretId(),
            ]);

            if (isset($result['SecretString'])) {
                $secret = $result['SecretString'];
            } else {
                $secret = base64_decode($result['SecretBinary']);
            }
        } catch (AwsException $e) {
            throw $e;
        } catch (SecretsManagerException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }

        return $secret;
    }
}
