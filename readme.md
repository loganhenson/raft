# Local Development Dream -- Raft

This is a full Laravel local development experience (opinionated) which comes with:
- Php 7.1
- Node 7.5
- Yarn
- Queue
- Redis
- MariaDB

This can be compared to:
- Laravel Homestead (Straight VMs) vs Raft (Single proxy VM + Docker containers)
- Laravel Valet (Local Nginx proxy + local database etc.) vs Raft (All containers)

## Installation

First ensure you have the system dependencies.

- OS X Yosemite (10.10) or higher
- [Homebrew](https://github.com/Homebrew/homebrew)
- [Docker for Mac](https://docs.docker.com/docker-for-mac/install/)
- [Virtualbox](https://www.virtualbox.org/)
- [Virtualbox Extension Pack](https://www.virtualbox.org/wiki/Downloads)

Now install and start [Dinghy](https://github.com/codekitchen/dinghy)
```
brew tap codekitchen/dinghy
brew install dinghy
dinghy create --provider virtualbox
```

Next install the package through Composer.

```js
{
  "require": {
		"loganhenson/raft": "~1.0"
	}
}
```

And add the service provider to your application.

**config/app.php**
```
...
'providers' => [
    '...',
    LoganHenson\Raft\RaftServiceProvider::class
];
...
```


## Usage

> Up
```
php artisan raft:up
```

> Up with SSL
```
php artisan raft:up --secure
```

> Down
```
php artisan raft:down
```

> Sequel Pro
```
php artisan raft:sql
```

## Running commands in your containers
> Composer
```
docker exec raft_app_1 composer
```

> Yarn
```
docker exec raft_app_1 yarn
```

## Connecting to your containers
> App
```
docker exec -it raft_app_1 bash
```

> Redis
```
docker exec -it raft_redis_1 bash
```

> MariaDB
```
docker exec -it raft_database_1 bash
```

> Queue
```
docker exec -it raft_queue_1 bash
```

> View the site @ http://raft.docker or https://raft.docker

## FAQ

> Q: It isn't working!
- A: Make sure docker is running (check your toolbar), as well as the dinghy vm `dinghy restart`
 
> Q: Chrome always puts my site on https!
- A: Go to chrome://net-internals/#hsts and put `raft.docker` in the "Delete Domain" input and press delete

> Q: How do I add more/different containers??
- A: Fork (:

## License

[View the license](https://github.com/loganhenson/raft/blob/master/LICENSE) for this repo.
