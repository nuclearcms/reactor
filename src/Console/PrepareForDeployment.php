<?php

namespace Nuclear\Reactor\Console;

use Illuminate\Console\Command;

class PrepareForDeployment extends Command {

	/**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'reactor:prepare';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare website for production deployment';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$this->call('optimize:clear');

    	$this->call('cache:clear');

    	$this->call('route:clear');

    	$this->call('config:clear');

    	$this->call('view:clear');

    	exec('rm ' . storage_path('logs/*.log'));

    	exec('composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader');

    	exec('npm run prod');
    }

}