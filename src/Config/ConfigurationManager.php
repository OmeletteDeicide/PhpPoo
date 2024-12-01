<?php

namespace src\Config;

class ConfigurationManager
{
    private static ?ConfigurationManager $instance = null;
    private array $config = [];

    private function __construct() {}

    public static function getInstance(): ConfigurationManager
    {
        if (self::$instance === null) {
            self::$instance = new ConfigurationManager();
        }
        return self::$instance;
    }

    public function load(array $config): void
    {
        $this->config = $config;
    }

    public function get(string $key)
    {
        if (!array_key_exists($key, $this->config)) {
            throw new \Exception("Clé de configuration inconnue : $key");
        }
        return $this->config[$key];
    }
}
