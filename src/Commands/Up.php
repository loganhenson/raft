<?php

namespace LoganHenson\Raft\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class Up
 * @package LoganHenson\Raft\Commands
 */
class Up extends Command
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
    protected $signature = 'raft:up {--secure}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Up';

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

        if ($this->option('secure')) {
            $this->secure();
        }

        shell_exec("docker-compose --project-name raft --file $composeFile down");
        shell_exec("docker-compose --project-name raft --file $composeFile up -d");
    }

    public function secure()
    {
        $url = 'raft.docker';
        $certsPath = getenv('HOME') . "/.dinghy/certs/";
        $keyPath = getenv('HOME') . "/.dinghy/certs/$url.key";
        $csrPath = sys_get_temp_dir() . "/$url.csr";
        $crtPath = getenv('HOME') . "/.dinghy/certs/$url.crt";

        // remove old cert if exists
        if (file_exists("$certsPath/cert.crt")) {
            shell_exec("sudo security delete-certificate -c \"$url\" -t");
        }

        // create new cert
        shell_exec("sudo -u $(whoami) openssl genrsa -out $keyPath 2048");
        shell_exec("sudo -u $(whoami) openssl req -new -subj \"/C=/ST=/O=/localityName=/commonName=$url/organizationalUnitName=/emailAddress=/\" -key $keyPath -out $csrPath -passin pass:");
        shell_exec("sudo -u $(whoami) openssl x509 -req -days 365 -in $csrPath -signkey $keyPath -out $crtPath");

        // trust cert locally
        shell_exec("sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain $crtPath");
    }
}
