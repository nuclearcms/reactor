<?php

namespace Nuclear\Reactor\Support;


use Illuminate\Cache\Repository;
use Illuminate\Http\Request;

class TokenManager {

    /** @var Request */
    protected $request;

    /** @var Repository */
    protected $cache;

    /**
     * Constructor
     *
     * @param Request $request
     * @param Repository $cache
     */
    public function __construct(Request $request, Repository $cache)
    {
        $this->request = $request;
        $this->cache = $cache;
    }

    /**
     * Getter for token
     *
     * @param string $key
     * @return string|null
     */
    public function getToken($key)
    {
        return $this->cache->get('reactor.tokens.' . $key, null);
    }

    /**
     * Setter for token
     *
     * @param string $key
     * @param string $value
     * @param int $duration
     */
    public function setToken($key, $value, $duration = 60)
    {
        $this->cache->put('reactor.tokens.' . $key, $value, $duration);
    }

    /**
     * Creates a new token and returns it
     *
     * @param string $key
     * @param int $duration
     * @return string
     */
    public function makeNewToken($key, $duration = 60)
    {
        $token = \Str::random(40);

        $this->setToken($key, $token, $duration);

        return $token;
    }

    /**
     * Gets the current or makes a new token
     * 
     * @param $string $key
     * @param int $duration
     * @return string
     */
    public function getOrMakeNewToken($key, $duration = 60)
    {
        if($token = $this->getToken($key)) return $token;

        return $this->makeNewToken($key, $duration);
    }

    /**
     * Checks if the request has the token
     *
     * @param string $key
     * @return bool
     */
    public function requestHasToken($key)
    {
        $token = $this->request->input($key, null);
        
        if($token && $token === $this->getToken($key))
        {
            return true;
        }

        return false;
    }

}