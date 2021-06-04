<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [index] precheck processes for notes
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Goals;

use App\Models\Goal;
use App\Permissions\ProjectPermissions;
use Closure;
use Log;

class Index {

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
     *   2. checks users permissions to [view] notes
     *   3. modifies the request object as needed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //permission: show only the users own notes
        if (!request()->filled('goalresource_type')) {
            request()->merge([
                'goalresource_type' => 'user',
                'goalresource_id' => auth()->id(),
            ]);
        }

        //various frontend and visibility settings
        $this->fronteEnd();

        
        //permission: show only the users own notes
        if (request('goalresource_type') == 'user') {
            if (request('goalresource_id') == auth()->id()) {
                return $next($request);
            }
        }

        //Project Notes
        if (request('goalresource_type') == 'project') {
            //team
            if (auth()->user()->is_team) {
                        Log::info("the project process has started", ['process' => '[permissions]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => 1]);
                if ($this->projectpermissons->check('goals-view', request('goalresource_id'))) {
                    return $next($request);
                }
            }
        }

        //Client Notes
        if (request('goalresource_type') == 'client') {
            //team
            if (auth()->user()->is_team) {
                if (auth()->user()->role->role_clients >= 1) {
                    return $next($request);
                }
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][goals][index]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }

    /*
     * various frontend and visibility settings
     */
    private function fronteEnd() {

        /**
         * shorten resource type and id (for easy appending in blade templates)
         * [usage]
         *   replace the usual url('note') with urlResource('note'), in blade templated
         * */
        if (request('goalresource_type') != '' || is_numeric(request('goalresource_id'))) {
            request()->merge([
                'resource_query' => 'ref=list&goalresource_type=' . request('goalresource_type') . '&goalresource_id=' . request('goalresource_id'),
            ]);
        } else {
            request()->merge([
                'resource_query' => 'ref=list',
            ]);
        }

        //add project notes
        if (request('goalresource_type') == 'project') {
            if (auth()->user()->role->role_projects >= 2) {
                config([
                    'visibility.list_page_actions_add_button' => true,
                ]);
            }
        }

        //add client notes
        if (request('goalresource_type') == 'client') {
            if (auth()->user()->role->role_clients >= 2) {
                config([
                    'visibility.list_page_actions_add_button' => true,
                ]);
            }
        }

        //add lead notes
        if (request('goalresource_type') == 'lead') {
            if (auth()->user()->role->role_leads >= 2) {
                config([
                    'visibility.list_page_actions_add_button' => true,
                ]);
            }
        }

        //add users own notes
        if (request('goalresource_type') == 'user') {
            config([
                'visibility.list_page_actions_add_button' => true,
            ]);
        }

    }
}
