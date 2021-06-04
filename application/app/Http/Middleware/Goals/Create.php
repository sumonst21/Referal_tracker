<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [create] precheck processes for notes
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Goals;
use App\Permissions\ProjectPermissions;
use Closure;
use Log;

class Create {

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

        //[project] - does user have 'project level' viewing permissions
        if (request('goalresource_type') == 'project') {
            if ($this->projectpermissons->check('goals-create', request('goalresource_id'))) {
                return $next($request);
            }
        }

        //permission: show only the users own notes
        if (request('goalresource_type') == 'user') {
            if (request('goalresource_id') == auth()->id()) {
                return $next($request);
            }
        }

        //permission: only team members with client editng permissions
        if (request('goalresource_type') == 'client') {
            if (auth()->user()->is_team) {
                if (auth()->user()->role->role_clients >= 2) {
                    return $next($request);
                }
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][files][create]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
