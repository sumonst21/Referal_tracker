<?php

namespace App\Permissions;

use App\Permissions\ProjectPermissions;
use App\Repositories\ReminderRepository;
use Illuminate\Support\Facades\Log;

class ReminderPermissions {

    /**
     * The reminder repository instance.
     */
    protected $reminderrepo;

    /**
     * The project permissions instance.
     */
    protected $projectpermissons;

    /**
     * Inject dependecies
     */
    public function __construct(
        ReminderRepository $reminderrepo,
        ProjectPermissions $projectpermissons
    ) {

        $this->reminderrepo = $reminderrepo;
        $this->projectpermissons = $projectpermissons;

    }

    /**
     * The array of checks that are available.
     * NOTE: when a new check is added, you must also add it to this array
     * @return array
     */
    public function permissionChecksArray() {
        $checks = [
            'edit-delete',
            'show',
        ];
        return $checks;
    }

    /**
     * This method checks a users permissions for a particular, specified File ONLY.
     *
     * [EXAMPLE USAGE]
     *          if (!$this->notepermissons->check($note_id, 'delete')) {
     *                 abort(413)
     *          }
     *
     * @param numeric $note object or id of the resource
     * @param string $action [required] intended action on the resource se list above
     * @return bool true if user has permission
     */
    public function check($action = '', $reminder = '') {

        //VALIDATIOn
        if (!in_array($action, $this->permissionChecksArray())) {
            Log::error("the requested check is invalid", ['process' => '[permissions][reminder]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'check' => $action ?? '']);
            return false;
        }

        //GET THE RESOURCE
        if (is_numeric($reminder)) {
            if (!$reminder = \App\Models\Reminder::Where('reminder_id', $reminder)->first()) {
                Log::error("the reminder coud not be found", ['process' => '[permissions][reminder]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            }
        }

        //[IMPORTANT]: any passed file object must from filerepo->search() method, not the file model
        if ($reminder instanceof \App\Models\Reminder || $reminder instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            //all is ok
        } else {
            Log::error("the reminder coud not be found", ['process' => '[permissions][reminder]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        /**
         * [DOWNLOAD FILES]
         */
        if ($action == 'view') {

            //creator
            if ($reminder->reminder_creatorid == auth()->id()) {
                return true;
            }

            //public notes
            if ($reminder->reminder_visibility == 'public') {
                //project note
                if ($reminder->reminderresource_type == 'project') {
                    //user who can view can also dowload
                    if ($this->projectpermissons->check('reminders-view', $reminder->reminderresource_id)) {
                        return true;
                    }
                }

                //client note
                if ($reminder->reminderresource_type == 'client') {
                    if (auth()->user()->role->role_clients >= 1) {
                        return true;
                    }
                }
            }
        }

        /**
         * [EDIT OR DELETE NOTE]
         */
        if ($action == 'edit-delete') {
            //creator
            if ($reminder->reminder_creatorid == auth()->id() || auth()->user()->role_id == 1) {
                return true;
            }

            //project reminder
            if ($reminder->reminderresource_type == 'project') {
                if ($this->projectpermissons->check('super-user', $reminder->reminderresource_id)) {
                    return true;
                }
            }
            //client reminder
            if ($reminder->reminderresource_type == 'client') {
                if (auth()->user()->role->role_clients >= 2) {
                    return true;
                }
            }
        }

        //failed
        Log::info("permissions denied on this reminder", ['process' => '[permissions][files]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        return false;
    }

}