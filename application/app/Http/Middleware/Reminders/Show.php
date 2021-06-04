<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [show] precheck processes for notes
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Reminders;
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
        if (!$reminder = \App\Models\Reminder::Where('reminder_id', request()->route('reminder'))->first()) {
            Log::error("reminder could not be found", ['process' => '[permissions][reminders][edit]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'reminder' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'reminder id' => $reminder_id ?? '']);
            abort(409, __('lang.reminder_not_found'));
        }

        //[project] - does user have 'project level' viewing permissions
        if ($reminder->reminderresource_type == 'project') {
            if ($this->projectpermissons->check('reminders-view', $reminder->reminderresource_id)) {
                return $next($request);
            }
        }

        //permission: show only the users own notes
        if ($reminder->reminderresource_type == 'user') {
            if ($reminder->remindereresource_id == auth()->id()) {
                return $next($request);
            }
        }

        //permission: only team members with client editng permissions
        if ($reminder->reminderresource_type == 'client') {
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
