<?php

namespace MMSecretsManager;

/**
 * Class EnvManager
 * @package MMSecretsManager
 */
class EnvManager
{
    /**
     * @var string
     */
    private $baseDir;

    /**
     * EnvManager constructor.
     * @param string|null $baseDir
     */
    public function __construct(?string $baseDir = null)
    {
        if (!is_null($baseDir))
            $this->setBaseDir($baseDir);
    }

    /**
     * @return string
     */
    public function getBaseDir(): string
    {
        return $this->baseDir;
    }

    /**
     * @param string $baseDir
     * @return EnvManager
     */
    public function setBaseDir(string $baseDir): EnvManager
    {
        $this->baseDir = $baseDir;
        return $this;
    }

    /**
     * @return bool
     */
    public function verifyEnvExists(): bool
    {
        return file_exists($this->getBaseDir() . '/.env');
    }

    /**
     * @param \stdClass $envData
     * @return bool
     */
    public function createEnvFile(\stdClass $envData): bool
    {
        $env = '';
        foreach ($envData as $key => $value) {
            $env .= "{$key}={$value}\n";
        }

        $envFile = file_put_contents($this->getBaseDir() . '/.env', $env);

        return (bool) $envFile;
    }

    /**
     * @param \stdClass $envData
     */
    public function addEnvVars(\stdClass $envData): void
    {
        foreach ($envData as $key => $value) {
            putenv("{$key}={$value}");
        }
    }
}
