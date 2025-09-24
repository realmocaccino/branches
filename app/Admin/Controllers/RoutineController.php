<?php
namespace App\Admin\Controllers;

use App\Console\Actions\Misc\FlushCacheDirectory;

class RoutineController extends BaseController
{
	public function cleanCache(FlushCacheDirectory $action)
	{
		$action->run();

        return redirect()->back()->with('message', 'success|Cache limpo');
	}
}