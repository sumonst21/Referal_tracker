<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for notes
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Goal;
use Illuminate\Http\Request;
use Log;

class GoalRepository {

    /**
     * The goals repository instance.
     */
    protected $goals;

    /**
     * Inject dependecies
     */
    public function __construct(Goal $goals) {
        $this->goals = $goals;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @param array $data optional data payload
     * @return object note collection
     */
    public function search($id = '') {

        $goals = $this->goals->newQuery();

        // all client fields
        $goals->selectRaw('*');

        //joins
        $goals->leftJoin('users', 'users.id', '=', 'goals.goal_creatorid');

        //default where
        $goals->whereRaw("1 = 1");

        //filters: id
        if (request()->filled('filter_goal_id')) {
            $goals->where('goal_id', request('filter_goal_id'));
        }
        if (is_numeric($id)) {
            $goals->where('goal_id', $id);
        }

        //resource filtering
        if (request()->filled('goalresource_type') && request()->filled('goalresource_id')) {
            $goals->where('goalresource_type', request('goalresource_type'));
            $goals->where('goalresource_id', request('goalresource_id'));
        }

        //only public or users own private goals
        $goals->where(function ($query) {
            $query->where('goal_visibility', 'public');
            $query->orWhere('goal_creatorid', auth()->id());
        });

        //search: various client columns and relationships (where first, then wherehas)
        if (request()->filled('search_query') || request()->filled('query')) {
            $goals->where(function ($query) {
                $query->where('goal_title', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('goal_description', 'LIKE', '%' . request('search_query') . '%');
            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('goals', request('orderby'))) {
                $goals->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'category':
                $goals->orderBy('category_name', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $goals->orderBy('goal_id', 'desc');
        }

        //eager load
        $goals->with(['tags']);

        // Get the results and return them.
        return $goals->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Create a new record
     * @return mixed int|bool
     */
    public function create() {

        //save new user
        $goal = new $this->goals;

        //data
        $goal->goal_creatorid = auth()->id();
        $goal->goal_title = request('goal_title');
        $goal->goal_description = request('goal_description');
        $goal->goalresource_type = request('goalresource_type');
        $goal->goalresource_id = request('goalresource_id');

        //save and return id
        if ($goal->save()) {
            return $goal->goal_id;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[GoalRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a record
     * @param int $id goal id
     * @return bool
     */
    public function update($id) {

        //get the record
        if (!$goal = $this->goals->find($id)) {
            Log::error("record could not be found - database error", ['process' => '[MilestoneRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'goal_id' => $id ?? '']);
            return false;
        }

        //general
        $goal->goal_title = request('goal_title');
        $goal->goal_description = request('goal_description');

        //save
        if ($goal->save()) {
            return $goal->goal_id;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[GoalRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }
}