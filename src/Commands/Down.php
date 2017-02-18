<?php

namespace LoganHenson\Raft\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class Down
 * @package LoganHenson\Raft\Commands
 */
class Down extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'raft:down';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Down';

    /**
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $composeFile = realpath(__DIR__ . '/../docker-compose.yml');

        shell_exec("docker-compose --project-name raft --file $composeFile down");
    }
}
