<?php
namespace App;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
	/**
     * Get the path to the routes cache file.
     *
     * @return string
     */
    public function getCachedRoutesPath()
    {
        return (APP != 'admin') ? $this->bootstrapPath() . '/cache/routes.php' : null;
    }
}
