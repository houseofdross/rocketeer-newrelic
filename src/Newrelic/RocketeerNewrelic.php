<?php
namespace Rocketeer\Plugins\Newrelic;

use Illuminate\Container\Container;
use Rocketeer\Abstracts\AbstractPlugin;
use Rocketeer\Services\TasksHandler;

class RocketeerNewrelic extends AbstractPlugin
{
    /**
     * Setup the plugin
     *
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        parent::__construct($app);
        $this->configurationFolder = __DIR__.'/../config';
    }

    /**
     * Bind additional classes to the Container
     *
     * @param Container $app
     *
     * @return void
     */
    public function register(Container $app)
    {
        $app->bind('newrelic', function ($app) {
            return new RocketeerNewrelicConfig($app['config']->get('rocketeer-newrelic::config'));
        });
        return $app;
    }

    /**
     * Register Tasks with Rocketeer
     *
     * @param \Rocketeer\Services\TasksHandler $queue
     *
     * @return void
     */
    public function onQueue(TasksHandler $queue)
    {
        $queue->after('deploy', function ($task) {
            $this->afterDeploy($task);
        });
    }

    /**
     * Talk to NewRelic and notify for each application
     *
     * @throws \Exception
     */
    private function afterDeploy($task)
    {
        $config = $this->app['newrelic']->getConfig();
        $environment = $task->getOption('on');

        // Only deploy when the environment tag is set and matches the --on flag given
        if ($environment != NULL && $environment == $config['environment']) {
            $apiKey = $config['apiKey'];
            $applicationIdCollection = $config['applicationIds'];
            $user = $config['user'];
            $description = $config['description'];
            $revision = $config['revision'];

            foreach ($applicationIdCollection as $applicationId) {
                $service = new RocketeerNewrelicDeploymentService($apiKey);
                $service->notify($applicationId, $user, $description, $revision);
                $task->command->info('Newrelic notified for app: '.$applicationId);
            }
        }
    }
}
