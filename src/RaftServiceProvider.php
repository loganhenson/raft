<?php

namespace LoganHenson\Raft;

use Illuminate\Support\ServiceProvider;

/**
 * Class RaftServiceProvider
 * @package TylerWebDev\Raft
 */
class RaftServiceProvider extends ServiceProvider
{
    protected $commands = [
        'LoganHenson\Raft\Commands\Up',
        'LoganHenson\Raft\Commands\Down',
        'LoganHenson\Raft\Commands\Sql',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    public function boot()
    {
        //
    }
}
