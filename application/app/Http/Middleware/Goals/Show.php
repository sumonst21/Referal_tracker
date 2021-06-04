<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [show] precheck processes for notes
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Goals;
use App\Permissions\ProjectPermissions;
use Closure;
use Log;

class Show {

    /**
     * The project permisson repository instance.
     */
    protected $projectpermissons;

    /**
     * Inject any dependencies here
     *
     */
    public function __construct(ProjectPermissions $projectpermissons) {

        $this->projectpermissons = $projectpermissons;
    }

    /**
     * This middleware does the following
     *   2. checks users permissions to [view] files
     *   3. modifies the request object as needed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //basic validation
        if (!$goal = \App\Models\Goal::Where('goal_id', request()->route('goal'))->first()) {
            Log::error("goal could not be found", ['process' => '[permissions][goals][edit]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'goal' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'goal id' => $goal_id ?? '']);
            abort(409, __('lang.goal_not_found'));
        }

        //[project] - does user have 'project level' viewing permissions
        if ($goal->goalresource_type == 'project') {
            if ($this->projectpermissons->check('goals-view', $goal->goalresource_id)) {
                return $next($request);
            }
        }

        //permission: show only the users own notes
        if ($goal->goalresource_type == 'user') {
            if ($goal->goaleresource_id == auth()->id()) {
                return $next($request);
            }
        }

        //permission: only team members with client editng permissions
        if ($goal->goalresource_type == 'client') {
            if (auth()->user()->is_team) {
                if (auth()->user()->role->role_clients >= 1) {
                    return $next($request);
                }
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][files][create]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
