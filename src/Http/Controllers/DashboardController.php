<?php

namespace Nuclear\Reactor\Http\Controllers;

use Umomega\Foundation\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{

    /**
	 * Lists the recent activity by current logged user
	 *
	 * @param User $user
	 * @return json
	 */
	public function chronicle()
	{
		return Activity::with('subject', 'causer')->limit(30)->skip(request('s', 0))->latest()->get();
	}

}
