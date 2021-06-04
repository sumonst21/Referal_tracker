<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for goals
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Responses\Goals\CreateResponse;
use App\Http\Responses\Goals\DestroyResponse;
use App\Http\Responses\Goals\EditResponse;
use App\Http\Responses\Goals\IndexResponse;
use App\Http\Responses\Goals\ShowResponse;
use App\Http\Responses\Goals\StoreResponse;
use App\Http\Responses\Goals\UpdateResponse;
use App\Permissions\GoalPermissions;
use App\Repositories\CategoryRepository;
use App\Repositories\GoalRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use App\Rules\NoTags;
use Illuminate\Http\Request;
use Validator;

class Goals extends Controller {

    /**
     * The goal repository instance.
     */
    protected $goalrepo;

    /**
     * The tags repository instance.
     */
    protected $tagrepo;

    /**
     * The user repository instance.
     */
    protected $userrepo;

    /**
     * The goal permission instance.
     */
    protected $goalpermissions;

    public function __construct(
        GoalRepository $goalrepo,
        TagRepository $tagrepo,
        UserRepository $userrepo,
        GoalPermissions $goalpermissions) {

        //parent
        parent::__construct();

        //authenticated
        $this->middleware('auth');

        $this->middleware('goalsMiddlewareIndex')->only([
            'index',
            'store',
        ]);

        $this->middleware('goalsMiddlewareCreate')->only([
            'create',
            'store',
        ]);

        $this->middleware('goalsMiddlewareShow')->only([
            'show',
        ]);

        $this->middleware('goalsMiddlewareEdit')->only([
            'edit',
            'update',
        ]);

        $this->middleware('goalsMiddlewareDestroy')->only([
            'destroy',
        ]);

        $this->goalrepo = $goalrepo;

        $this->tagrepo = $tagrepo;

        $this->userrepo = $userrepo;

        $this->goalpermissions = $goalpermissions;

    }

    /**
     * Display a listing of goals
     * @param object CategoryRepository instance of the repository
     * @return blade view | ajax view
     */
    public function index(CategoryRepository $categoryrepo) {

        //default to user goals if type is not set
        if (request('goalresource_type')) {
            $page = $this->pageSettings('mygoals');
        } else {
            $page = $this->pageSettings('goals');
        }

        //get goals
        $goals = $this->goalrepo->search();

        //apply some permissions
        if ($goals) {
            foreach ($goals as $goal) {
                $this->applyPermissions($goal);
            }
        }

        //reponse payload
        $payload = [
            'page' => $page,
            'goals' => $goals,
        ];

        //show the view
        return new IndexResponse($payload);
    }

    /**
     * Show the form for creating a new  goal
     * @param object CategoryRepository instance of the repository
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryRepository $categoryrepo) {

        //get tags
        $tags = $this->tagrepo->getByType('goals');

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('create'),
            'tags' => $tags,
        ];

        //show the form
        return new CreateResponse($payload);
    }

    /**
     * Store a newly created goal in storage.
     * @return \Illuminate\Http\Response
     */
    public function store() {

        $messages = [];

        //validate
        $validator = Validator::make(request()->all(), [
            'goal_title' => [
                'required',
                new NoTags,
            ],
            'goal_description' => 'required',
            'tags' => [
                'bail',
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $key => $data) {
                        if (hasHTML($data)) {
                            return $fail(__('lang.tags_no_html'));
                        }
                    }
                },
            ],
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }

            abort(409, $messages);
        }

        //create the goal
        if (!$goal_id = $this->goalrepo->create()) {
            abort(409);
        }

        //add tags
        $this->tagrepo->add('goal', $goal_id);

        //get the goal object (friendly for rendering in blade template)
        $goals = $this->goalrepo->search($goal_id);

        //permissions
        $this->applyPermissions($goals->first());

        //counting rows
        $rows = $this->goalrepo->search();
        $count = $rows->total();

        //reponse payload
        $payload = [
            'goals' => $goals,
            'count' => $count,
        ];

        //process reponse
        return new StoreResponse($payload);

    }

    /**
     * display a goal via ajax modal
     * @param int $id goal id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        //get the goal
        $goal = $this->goalrepo->search($id);

        //goal not found
        if (!$goal = $goal->first()) {
            abort(409, __('lang.goal_not_found'));
        }

        //reponse payload
        $payload = [
            'goal' => $goal,
        ];

        //process reponse
        return new ShowResponse($payload);
    }

    /**
     * Show the form for editing the specified  goal
     * @param int $id goal id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        //get the goal
        $goal = $this->goalrepo->search($id);

        //get tags
        $tags = $this->tagrepo->getByResource('goal', $id);

        //goal not found
        if (!$goal = $goal->first()) {
            abort(409, __('lang.goal_not_found'));
        }

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('edit'),
            'goal' => $goal,
            'tags' => $tags,
        ];

        //response
        return new EditResponse($payload);
    }

    /**
     * Update the specified goal in storage.
     * @param int $id goal id
     * @return \Illuminate\Http\Response
     */
    public function update($id) {

        //custom error messages
        $messages = [];

        //validate
        $validator = Validator::make(request()->all(), [
            'goal_title' => [
                'required',
                new NoTags,
            ],
            'goal_description' => 'required',
            'tags' => [
                'bail',
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $key => $data) {
                        if (hasHTML($data)) {
                            return $fail(__('lang.tags_no_html'));
                        }
                    }
                },
            ],
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }

            abort(409, $messages);
        }
          
        //update
        if (!$this->goalrepo->update($id)) {
            abort(409);
        }

        //delete & update tags
        $this->tagrepo->delete('goal', $id);
        $this->tagrepo->add('goal', $id);

        //get goal
        $goals = $this->goalrepo->search($id);

        $this->applyPermissions($goals->first());

        //reponse payload
        $payload = [
            'goals' => $goals,
        ];

        //generate a response
        return new UpdateResponse($payload);
    }

    /**
     * Remove the specified goal from storage.
     * @param int $id goal id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $goal = \App\Models\Goal::Where('goal_id', $id)->first();

        //remove the item
        $goal->delete();

        //reponse payload
        $payload = [
            'goal_id' => $id,
        ];

        //generate a response
        return new DestroyResponse($payload);
    }

    /**
     * pass the file through the ProjectPermissions class and apply user permissions.
     * @param object goal instance of the goal model object
     * @return object
     */
    private function applyPermissions($goal = '') {

        //sanity - make sure this is a valid file object
        if ($goal instanceof \App\Models\Goal) {
            //delete permissions
            $goal->permission_edit_delete_goal = $this->goalpermissions->check('edit-delete', $goal);
        }
    }
    /**
     * basic page setting for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        //common settings
        $page = [
            'crumbs' => [
                __('lang.goals'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'goals',
            'no_results_message' => __('lang.no_results_found'),
            'mainmenu_goals' => 'active',
            'sidepanel_id' => 'sidepanel-filter-goals',
            'dynamic_search_url' => url('goals/search?action=search&goalresource_id=' . request('goalresource_id') . '&goalresource_type=' . request('goalresource_type')),
            'add_button_classes' => 'add-edit-goal-button',
            'load_more_button_route' => 'goals',
            'source' => 'list',
        ];

        //default modal settings (modify for sepecif sections)
        $page += [
            'add_modal_title' => __('lang.add_goal'),
            'add_modal_create_url' => url('goals/create?goalresource_id=' . request('goalresource_id') . '&goalresource_type=' . request('goalresource_type')),
            'add_modal_action_url' => url('goals?goalresource_id=' . request('goalresource_id') . '&goalresource_type=' . request('goalresource_type')),
            'add_modal_action_ajax_class' => '',
            'add_modal_action_ajax_loading_target' => 'commonModalBody',
            'add_modal_action_method' => 'POST',
        ];

        //goals list page
        if ($section == 'goals') {
            $page += [
                'meta_title' => __('lang.goals'),
                'heading' => __('lang.goals-'),
            ];
            if (request('source') == 'ext') {
                $page += [
                    'list_page_actions_size' => 'col-lg-12',
                ];
            }
            return $page;
        }

        //goals list my goals
        if ($section == 'mygoals') {
            $page += [
                'meta_title' => __('lang.ny_goals'),
                'heading' => __('lang.ny_goals'),
            ];
            if (request('source') == 'ext') {
                $page += [
                    'list_page_actions_size' => 'col-lg-12',
                ];
            }
            return $page;
        }

        //goal page
        if ($section == 'goal') {
            //adjust
            $page['page'] = 'goal';
            //add
            $page += [
                'crumbs' => [
                    __('lang.goals'),
                ],
                'meta_title' => __('lang.goals'),
                'goal_id' => request()->segment(2),
                'section' => 'overview',
            ];
            //ajax loading and tabs
            $page += $this->setActiveTab(request()->segment(3));
            return $page;
        }

        //create new resource
        if ($section == 'create') {
            $page += [
                'section' => 'create',
            ];
            return $page;
        }

        //edit new resource
        if ($section == 'edit') {
            $page += [
                'section' => 'edit',
            ];
            return $page;
        }

        //return
        return $page;
    }

}