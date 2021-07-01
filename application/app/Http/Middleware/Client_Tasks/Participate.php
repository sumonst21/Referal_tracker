<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [participate] precheck processes for tasks
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\C_Tasks;
use App\Models\C_Task;
use App\Permissions\C_TaskPermissions;
use Closure;
use Log;

class Participate {

    /**
     * The permisson repository instance.
     */
    protected $c_taskpermissions;

    /**
     * Inject any dependencies here
     *
     */
    public function __construct(C_TaskPermissions $c_taskpermissions) {

        //task permissions repo
        $this->c_taskpermissions = $c_taskpermissions;

    }

    /**
     * Check user permissions to edit a task
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //task id
        $task_id = $request->route('task');

        //does the task exist
        if ($task_id == '' || !$task = \App\Models\C_Task::Where('task_id', $task_id)->first()) {
            Log::error("task could not be found", ['process' => '[permissions][tasks][participate]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'task id' => $task_id ?? '']);
            abort(404);
        }

        //permission everyone
        if ($this->taskpermissions->check('participate', $task_id)) {
            return $next($request);
        }

        //no items were passed with this request
        Log::error("permission denied", ['process' => '[permissions][tasks][participate]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'task id' => $task_id ?? '']);
        abort(403);
    }
}
