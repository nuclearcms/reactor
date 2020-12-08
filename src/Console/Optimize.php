<?php

namespace Nuclear\Reactor\Console;

use Illuminate\Console\Command;

class Optimize extends Command {

	/**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'reactor:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all necessary optimization commands';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('optimize:clear');
        $this->call('optimize');

        $this->call('cache:clear');

        $this->call('route:clear');
        $this->call('route:cache');

        $this->call('config:clear');
        $this->call('config:cache');

        $this->call('view:clear');
        $this->call('view:cache');
    }

}