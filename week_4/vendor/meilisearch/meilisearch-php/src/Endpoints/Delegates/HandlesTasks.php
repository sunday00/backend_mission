<?php

declare(strict_types=1);

namespace MeiliSearch\Endpoints\Delegates;

use MeiliSearch\Endpoints\Tasks;

/**
 * @property Tasks tasks
 */
trait HandlesTasks
{
    public function getTask($uid): array
    {
        return $this->tasks->get($uid);
    }

    public function getTasks(): array
    {
        return $this->tasks->all();
    }

    public function waitForTask($uid, $timeoutInMs = 5000, $intervalInMs = 50): array
    {
        return $this->tasks->waitTask($uid, $timeoutInMs, $intervalInMs);
    }

    public function waitForTasks($uids, $timeoutInMs = 5000, $intervalInMs = 50): array
    {
        return $this->tasks->waitTasks($uids, $timeoutInMs, $intervalInMs);
    }
}
