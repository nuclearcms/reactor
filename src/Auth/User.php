<?php

namespace Nuclear\Reactor\Auth;

use Umomega\Auth\User as BaseUser;
use Nuclear\Hierarchy\Content;

class User extends BaseUser
{

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['gravatar', 'full_name', 'initials', 'roles_list', 'permissions_list', 'contents_list'];

    /**
     * Content relation
     *
     * @return HasMany
     */
    public function contents()
    {
        return $this->belongsToMany(Content::class);
    }

    /**
     * Updates contents
     * 
     * @param array|null
     */
    public function updateContents(array $contents = null)
    {
        if(!is_null($contents)) {
            $ids = collect($contents)->pluck('id');

            $this->contents()->sync($ids);
        }
    }

    /**
     * Returns a list of contents
     * 
     * @return array
     */
    public function getContentsListAttribute()
    {
        return $this->contents()->get()->map(function($content) {
            return ['title' => [config('app.locale') => $content->getTranslation('title', config('app.locale'))], 'id' => $content->id];
        });
    }

    /**
     * Returns the accessible content ids for the user
     * 
     * @param Collection|null $roots
     * @return array
     */
    public function getAccessibleContents($roots = null)
    {
        if(is_null($roots)) {
            $roots = $this->contents()->orderBy('parent_id')->orderBy('position')->get();
        }

        if(count($roots) == 0 || $roots == null) return null;

        $ids = [];
    
        foreach($roots as $root)
        {
            $ids = array_merge($ids, $root->descendantsWithSelf()->pluck('id')->toArray());
        }

        return $ids;
    }

}