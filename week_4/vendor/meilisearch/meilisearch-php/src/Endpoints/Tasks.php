<?php

declare(strict_types=1);

namespace MeiliSearch\Endpoints;

use MeiliSearch\Contracts\Endpoint;
use MeiliSearch\Exceptions\TimeOutException;

class Tasks extends Endpoint
{
    protected const PATH = '/tasks';

    public function get($taskUid): array
    {
        return $this->http->get(self::PATH.'/'.$taskUid);
    }

    public function all(): array
    {
        return $this->http->get(self::PATH.'/');
    }

    /**
     * @param string $taskUid
     * @param int    $timeoutInMs
     * @param int    $intervalInMs
     *
     * @throws TimeOutException
     */
    public function waitTask($taskUid, $timeoutInMs, $intervalInMs): array
    {
        $timeout_temp = 0;
        while ($timeoutInMs > $timeout_temp) {
            $res = $this->get($taskUid);
            if ('enqueued' != $res['status'] && 'processing' != $res['status']) {
                return $res;
            }
            $timeout_temp += $intervalInMs;
            usleep(1000 * $intervalInMs);
        }
        throw new TimeOutException();
    }

    /**
     * @param array $taskUids
     * @param int   $timeoutInMs
     * @param int   $intervalInMs
     */
    public function waitTasks($taskUids, $timeoutInMs, $intervalInMs): array
    {
        $tasks = [];
        foreach ($taskUids as $taskUid) {
            $tasks[] = $this->waitTask($taskUid, $timeoutInMs, $intervalInMs);
        }

        return $tasks;
    }
}
