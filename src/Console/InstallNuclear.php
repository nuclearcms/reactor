<?php

namespace Nuclear\Reactor\Console;

use Illuminate\Console\Command;
use Nuclear\Reactor\Support\InstallHelper;

class InstallNuclear extends Command {

	/**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'reactor:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Nuclear';

    /**
     * Execute the console command.
     *
     * @param InstallHelper $helper
     * @return mixed
     */
    public function handle(InstallHelper $helper)
    {
    	$this->info('Welcome to Nuclear CMS! The installer will ask you some questions...');

    	$this->setupInitialSiteInformation($helper);

    	$this->info('Great! Now we need a database, so you need to create it before giving below information:');
    	$this->setupDatabaseInformationAndMigrate($helper);

    	$this->info('Finally, Nuclear will grant you super admin powers! Please enter your user information:');
    	$this->createSuperadmin($helper);

    	$helper->setEnvVariable('APP_STATUS', 'INSTALLED');
    	$this->info('Installation is complete! Have fun developing with Nuclear!');
    }

    /**
     * Setups initial site information
     *
     * @param InstallHelper $helper
     */
    protected function setupInitialSiteInformation(InstallHelper $helper)
    {
    	// App name
    	$helper->setEnvVariable(
    		'APP_NAME',
    		$this->anticipate('Please enter the app name:', ['Nuclear CMS']));

    	// App URL
    	$appURL = $this->anticipate('Please enter the app URL:', ['http://nuclear.test']);
		$helper->setEnvVariable('APP_URL', $appURL);

		// App timezone
    	$helper->setEnvVariable(
    		'APP_TIMEZONE',
    		$this->anticipate('Please enter the app timezone:', ['Europe/Istanbul']));

    	// Reactor locale
    	$helper->setEnvVariable(
    		'REACTOR_LOCALE',
    		$this->anticipate('Please enter the CMS locale:', ['en', 'tr']));

    	// App locale
    	$helper->setEnvVariable(
    		'APP_LOCALE',
    		$this->anticipate('Please enter the site locale:', ['en', 'tr']));

    	// App locales
    	$helper->setEnvVariable(
    		'APP_LOCALES',
    		$this->anticipate('Please enter all the translation locales for the site separated with commas:', ['en,tr', 'tr,en']));
    }

    /**
     * Setups database information and migrates
     *
     * @param InstallHelper $helper
     */
    protected function setupDatabaseInformationAndMigrate($helper)
    {
    	$helper->setEnvVariable(
    		'DB_CONNECTION',
    		$this->anticipate('Please enter the database connection:', ['mysql', 'sqlite', 'pgsql, sqlsrv']));

    	$helper->setEnvVariable(
    		'DB_HOST',
    		$this->anticipate('Please enter the database host:', ['127.0.0.1', 'localhost']));

    	$helper->setEnvVariable(
    		'DB_PORT',
    		$this->anticipate('Please enter the database PORT:', ['3306', '5432']));
        
        $helper->setEnvVariable(
    		'DB_DATABASE',
    		$this->anticipate('Please enter the database name:', ['nuclear', 'reactor', 'awesome']));
        
		$helper->setEnvVariable(
    		'DB_USERNAME',
    		$this->anticipate('Please enter the database user:', ['root']));

		$helper->setEnvVariable(
    		'DB_PASSWORD',
    		$this->ask('Please enter the database password:'));

        $helper->migrateAndSeedDatabase();
    }

    /**
     * Creates the superadmin
     *
     * @param InstallHelper $helper
     */
    protected function createSuperadmin(InstallHelper $helper)
    {
    	$params = [];

    	$params['email'] = $this->ask('Email address:');
    	$params['first_name'] = $this->ask('First name:');
    	$params['last_name'] = $this->ask('Last name:');
    	$params['password'] = $this->ask('Password (choose a strong one):');

    	$helper->createSuperadmin($params);
    }

}