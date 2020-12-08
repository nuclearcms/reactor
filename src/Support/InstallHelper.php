<?php

namespace Nuclear\Reactor\Support;

use Umomega\Auth\Permission;
use Umomega\Auth\Role;
use Umomega\Auth\User;
use Nuclear\Hierarchy\Content;
use Nuclear\Hierarchy\ContentType;

class InstallHelper {

	/**
     * Sets an env variable
     *
     * @param string $key
     * @param string $value
     */
    public function setEnvVariable($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path))
        {
            file_put_contents($path, str_replace(
                $key . '=' . env($key),
                $key . '=' . $value,
                file_get_contents($path)
            ));
        }
    }

    /**
     * Migrates and seeds the database
     */
    public function migrateAndSeedDatabase()
    {
    	\Artisan::call('migrate');
    	
    	$this->generateRolesAndPermissions();

    	$this->generateHomeContent();
    }

    /**
     * Generates roles and permissions
     */
    protected function generateRolesAndPermissions()
    {
    	foreach(['access_reactor', 'maintain_reactor', 'read_chronicle', 'read_contents', 'read_contenttypes', 'read_media', 'read_tags', 'read_users', 'rw_environment', 'rw_logs', 'rw_permissions', 'superadmin', 'write_contents', 'write_contenttypes', 'write_media', 'write_tags', 'write_users'] as $permission)
    	{
    		Permission::create(['name' => $permission]);
    	}

    	foreach([
    		'Administrator' => ['access_reactor', 'maintain_reactor', 'read_chronicle', 'read_contents', 'read_contenttypes', 'read_media', 'read_tags', 'read_users', 'rw_environment', 'rw_logs', 'rw_permissions', 'write_contents', 'write_contenttypes', 'write_media', 'write_tags', 'write_users'],
    		'Editor' => ['access_reactor', 'read_chronicle', 'read_contents', 'read_media', 'read_tags', 'write_contents', 'write_media', 'write_tags']
    	] as $role => $permissions) {
    		$role = Role::create(['name' => $role]);

    		foreach($permissions as $permission) {
    			$role->givePermissionTo($permission);
    		}
    	}
    }

    /**
     * Generates home content
     */
    protected function generateHomeContent()
    {
    	$contentType = ContentType::create(['name' => 'Home', 'is_visible' => true, 'hides_children' => false, 'color' => '{"hex":"#00249C"}', 'is_taggable' => false, 'allowed_children_types' => []]);

    	$content = Content::create(['title' => 'Home', 'content_type_id' => $contentType->id, 'status' => 50]);
    }

    /**
     * Creates the superadmin
     *
     * @param array $params
     */
    public function createSuperadmin(array $params)
    {
    	$params['locale'] = env('REACTOR_LOCALE');

    	$user = new User($params);
    	$user->password = bcrypt($params['password']);
    	$user->updateApiToken(false);
    	$user->save();

    	$user->givePermissionTo('superadmin');
    }

}