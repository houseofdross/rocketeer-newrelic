<?php
namespace Rocketeer\Plugins\Newrelic;

class RocketeerNewrelicConfig
{
    /** @var array */
    private $config = array();

    public function __construct(array $config)
    {
        $this->config = $config;

        // Check we have all the config options we need
        foreach (array('apiKey', 'applicationIds') as $item) {
            if (!isset($this->config[$item]) || !$this->config[$item]) {
                throw new \Exception('Unable to find config item: '.$item);
            }
        }
    }

    public function getConfig()
    {
        return $this->config;
    }
}