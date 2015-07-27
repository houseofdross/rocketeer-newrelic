<?php
namespace Rocketeer\Plugins\Newrelic;

use Rocketeer\Abstracts\AbstractPlugin;
use Rocketeer\Services\TasksHandler;

class Newrelic extends AbstractPlugin
{
    /**
     * Register Tasks with Rocketeer
     *
     * @param \Rocketeer\Services\TasksHandler $queue
     *
     * @return void
     */
    public function onQueue(TasksHandler $queue)
    {
        $afterDeploy = function() {
            $this->afterDeploy();
        };

        $queue->addTaskListeners('deploy', 'after', $afterDeploy, 0, true);
    }

    private function afterDeploy()
    {
        $apiKey = null; // fixme, where do these come from?
        $applicationId = null;
        $user = null;
        $description = null;
        $revision = null;

        $service = new NewrelicDeploymentService($apiKey);
        $service->notify($applicationId, $user, $description, $revision);

        echo "afterDeploy was just called!\n";
    }
}
