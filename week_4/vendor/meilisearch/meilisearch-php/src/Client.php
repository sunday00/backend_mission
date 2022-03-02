<?php

declare(strict_types=1);

namespace MeiliSearch;

use MeiliSearch\Delegates\HandlesIndex;
use MeiliSearch\Delegates\HandlesSystem;
use MeiliSearch\Endpoints\Delegates\HandlesDumps;
use MeiliSearch\Endpoints\Delegates\HandlesKeys;
use MeiliSearch\Endpoints\Delegates\HandlesTasks;
use MeiliSearch\Endpoints\Dumps;
use MeiliSearch\Endpoints\Health;
use MeiliSearch\Endpoints\Indexes;
use MeiliSearch\Endpoints\Keys;
use MeiliSearch\Endpoints\Stats;
use MeiliSearch\Endpoints\Tasks;
use MeiliSearch\Endpoints\Version;
use Psr\Http\Client\ClientInterface;

class Client
{
    use HandlesDumps;
    use HandlesIndex;
    use HandlesTasks;
    use HandlesKeys;
    use HandlesSystem;

    private $http;

    /**
     * @var Indexes
     */
    private $index;

    /**
     * @var Health
     */
    private $health;

    /**
     * @var Version
     */
    private $version;

    /**
     * @var Keys
     */
    private $keys;

    /**
     * @var Stats
     */
    private $stats;

    /**
     * @var Tasks
     */
    private $tasks;

    /**
     * @var Dumps
     */
    private $dumps;

    public function __construct(string $url, string $apiKey = null, ClientInterface $httpClient = null)
    {
        $this->http = new Http\Client($url, $apiKey, $httpClient);
        $this->index = new Indexes($this->http);
        $this->health = new Health($this->http);
        $this->version = new Version($this->http);
        $this->stats = new Stats($this->http);
        $this->tasks = new Tasks($this->http);
        $this->keys = new Keys($this->http);
        $this->dumps = new Dumps($this->http);
    }
}
