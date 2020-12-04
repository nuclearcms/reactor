<?php

namespace Nuclear\Reactor\Http\Controllers;

use Umomega\Foundation\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Nuclear\Hierarchy\Support\ViewsCounter;
use Nuclear\Hierarchy\Content;
use CyrildeWit\EloquentViewable\View;

class DashboardController extends Controller
{

	/**
	 * Returns information for the dashboard
	 *
	 * @param ViewsCounter $counter
	 */
	public function index(ViewsCounter $counter)
	{
		$recentlyViewed = View::latest('viewed_at')->limit(10)->pluck('viewable_id')->toArray();
		$recentlyViewed = empty($recentlyViewed) ? [] : Content::with('contentType')->whereIn('id', $recentlyViewed)->orderByRaw('FIELD (id, ' . implode(', ', $recentlyViewed) . ') ASC')->get();

		return [
			'contents' => [
				'most_viewed' => Content::orderByUniqueViews()->with('contentType')->limit(10)->get(),
				'recently_viewed' => $recentlyViewed,
				'recently_updated' => Content::latest('updated_at')->with('contentType')->limit(10)->get(),
				'recently_created' => Content::latest('created_at')->with('contentType')->limit(10)->get()
			],
			'views' => $counter->countFor()
		];
	}

    /**
	 * Lists the recent activity by current logged user
	 *
	 * @return json
	 */
	public function chronicle()
	{
		return Activity::with('subject', 'causer')->limit(30)->skip(request('s', 0))->latest()->get();
	}

}
