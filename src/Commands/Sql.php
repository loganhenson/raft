<?php

namespace LoganHenson\Raft\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class Sql
 * @package LoganHenson\Raft\Commands
 */
class Sql extends Command
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
    protected $signature = 'raft:sql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sequel Pro';

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
        $name = 'raft';
        $user = 'root';
        $pass = 'password';
        $port = '3300';
        $host = '127.0.0.1';
        $database = 'database';
        $tmp = '/tmp/docker.spf';

        $str = <<<SEQUELPRO

cat > $tmp <<EOF
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
    <key>ContentFilters</key>
    <dict/>
    <key>auto_connect</key>
    <true/>
    <key>data</key>
    <dict>
        <key>connection</key>
        <dict>
            <key>database</key>
            <string>$database</string>
            <key>host</key>
            <string>$host</string>
            <key>name</key>
            <string>$name</string>
            <key>password</key>
            <string>$pass</string>
            <key>port</key>
            <integer>$port</integer>
            <key>rdbms_type</key>
            <string>mysql</string>
            <key>sslCACertFileLocation</key>
            <string></string>
            <key>sslCACertFileLocationEnabled</key>
            <integer>0</integer>
            <key>sslCertificateFileLocation</key>
            <string></string>
            <key>sslCertificateFileLocationEnabled</key>
            <integer>0</integer>
            <key>sslKeyFileLocation</key>
            <string></string>
            <key>sslKeyFileLocationEnabled</key>
            <integer>0</integer>
            <key>type</key>
            <string>SPTCPIPConnection</string>
            <key>useSSL</key>
            <integer>0</integer>
            <key>user</key>
            <string>$user</string>
        </dict>
    </dict>
    <key>encrypted</key>
    <false/>
    <key>format</key>
    <string>connection</string>
    <key>queryFavorites</key>
    <array/>
    <key>queryHistory</key>
    <array/>
    <key>rdbms_type</key>
    <string>mysql</string>
    <key>rdbms_version</key>
    <string>5.5.44</string>
    <key>version</key>
    <integer>1</integer>
</dict>
</plist>
EOF

exec open $tmp
SEQUELPRO;

        shell_exec($str);
    }
}
