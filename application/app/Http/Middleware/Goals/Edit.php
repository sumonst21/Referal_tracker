<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [edit] precheck processes for notes
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Goals;
use App\Permissions\GoalPermissions;
use Closure;
use Log;

class Edit {

    /**
     * The note permisson repository instance.
     */
    protected $goalpermissons;

    /**
     * Inject any dependencies here
     *
     */
    public function __construct(GoalPermissions $goalpermissons) {

        $this->goalpermissons = $goalpermissons;
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
        if (!$goal = \App\Models\Goal::Where('goal_id', request()->route('goal'))->first()) {
            Log::error("goal could not be found", ['process' => '[permissions][goals][edit]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'goal' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'goal id' => $goal_id ?? '']);
            abort(409, __('lang.goal_not_found'));
        }

        //all
        if ($this->goalpermissons->check('edit-delete', $goal)) {
            return $next($request);
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][goals][create]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'goal' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
