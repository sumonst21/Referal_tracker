<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [index] precheck processes for notes
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Reminders;

use App\Models\Reminder;
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
        if (!request()->filled('reminderresource_type')) {
            request()->merge([
                'reminderresource_type' => 'user',
                'reminderresource_id' => auth()->id(),
            ]);
        }

        //various frontend and visibility settings
        $this->fronteEnd();

        
        //permission: show only the users own notes
        if (request('reminderresource_type') == 'user') {
            if (request('reminderresource_id') == auth()->id()) {
                return $next($request);
            }
        }

        //Project Notes
        if (request('reminderresource_type') == 'project') {
            //team
            if (auth()->user()->is_team) {
                        Log::info("the project process has started", ['process' => '[permissions]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => 1]);
                if ($this->projectpermissons->check('reminders-view', request('reminderresource_id'))) {
                    return $next($request);
                }
            }
        }

        //Client Notes
        if (request('reminderresource_type') == 'client') {
            //team
            if (auth()->user()->is_team) {
                if (auth()->user()->role->role_clients >= 1) {
                    return $next($request);
                }
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][reminders][index]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
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
        if (request('reminderresource_type') != '' || is_numeric(request('reminderresource_id'))) {
            request()->merge([
                'resource_query' => 'ref=list&reminderresource_type=' . request('reminderresource_type') . '&reminderresource_id=' . request('reminderresource_id'),
            ]);
        } else {
            request()->merge([
                'resource_query' => 'ref=list',
            ]);
        }

        //add project reminder
        if (request('reminderresource_type') == 'project') {
            if (auth()->user()->role->role_projects >= 2) {
                config([
                    'visibility.list_page_actions_add_button' => true,
                ]);
            }
        }

        //add client reminder
        if (request('reminderresource_type') == 'client') {
            if (auth()->user()->role->role_clients >= 2) {
                config([
                    'visibility.list_page_actions_add_button' => true,
                ]);
            }
        }

        //add lead reminder
        if (request('reminderresource_type') == 'lead') {
            if (auth()->user()->role->role_leads >= 2) {
                config([
                    'visibility.list_page_actions_add_button' => true,
                ]);
            }
        }

        //add users own reminder
        if (request('reminderresource_type') == 'user') {
            config([
                'visibility.list_page_actions_add_button' => true,
            ]);
        }

    }
}
