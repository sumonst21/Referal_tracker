<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [edit] precheck processes for notes
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Reminders;
use App\Permissions\ReminderPermissions;
use Closure;
use Log;

class Edit {

    /**
     * The note permisson repository instance.
     */
    protected $reminderpermissons;

    /**
     * Inject any dependencies here
     *
     */
    public function __construct(ReminderPermissions $reminderpermissons) {

        $this->reminderpermissons = $reminderpermissons;
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

        //basic validation
        if (!$reminder = \App\Models\Reminder::Where('reminder_id', request()->route('reminder'))->first()) {
            Log::error("reminder could not be found", ['process' => '[permissions][reminders][edit]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'reminder' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'reminder id' => $reminder_id ?? '']);
            abort(409, __('lang.reminder_not_found'));
        }

        //all
        if ($this->reminderpermissons->check('edit-delete', $reminder)) {
            return $next($request);
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][reminders][create]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'reminder' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
