<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [dynamic] precheck processes for tasks
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\C_Tasks;
use App\Models\C_Task;
use App\Permissions\C_TaskPermissions;
use Closure;
use Log;

class Dynamic {

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
        
        //enable task to be loaded dynamically
        if (is_numeric(request()->route('task')) && request()->segment(2) == 'v') {
            config([
                'visibility.dynamic_load_modal' => true,
                'settings.dynamic_trigger_dom' => '#dynamic-task-content',
            ]);
        }
        

    }


}
