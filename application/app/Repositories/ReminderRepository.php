<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for notes
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Log;
use DB;
use Illuminate\Support\Facades\Mail;
class ReminderRepository {

    /**
     * The reminders repository instance.
     */
    protected $reminders;

    /**
     * Inject dependecies
     */
    public function __construct(Reminder $reminders) {
        $this->reminders = $reminders;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @param array $data optional data payload
     * @return object note collection
     */
    public function search($id = '') {

        $reminders = $this->reminders->newQuery();

        // all client fields
        $reminders->selectRaw('*');

        //joins
        $reminders->leftJoin('users', 'users.id', '=', 'reminders.reminder_creatorid');

        //default where
        $reminders->whereRaw("1 = 1");

        //filters: id
        if (request()->filled('filter_reminder_id')) {
            $reminders->where('reminder_id', request('filter_reminder_id'));
        }
        if (is_numeric($id)) {
            $reminders->where('reminder_id', $id);
        }

        //resource filtering
        if (request()->filled('reminderresource_type') && request()->filled('reminderresource_id')) {
            $reminders->where('reminderresource_type', request('reminderresource_type'));
            $reminders->where('reminderresource_id', request('reminderresource_id'));
        }

        //only public or users own private reminders
        $reminders->where(function ($query) {
            $query->where('reminder_visibility', 'public');
            $query->orWhere('reminder_creatorid', auth()->id());
        });

        //search: various client columns and relationships (where first, then wherehas)
        if (request()->filled('search_query') || request()->filled('query')) {
            $reminders->where(function ($query) {
                $query->where('reminder_title', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('reminder_description', 'LIKE', '%' . request('search_query') . '%');
            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('reminders', request('orderby'))) {
                $reminders->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'category':
                $reminders->orderBy('category_name', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $reminders->orderBy('reminder_id', 'desc');
        }

        //eager load
        $reminders->with(['tags']);

        // Get the results and return them.
        return $reminders->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Create a new record
     * @return mixed int|bool
     */
    public function create() {

        //save new user
        $reminder = new $this->reminders;

        //data
        $reminder->reminder_creatorid = auth()->id();
        $reminder->reminder_title = request('reminder_title');
        $reminder->reminder_description = request('reminder_description');
        $reminder->reminder_date = request('reminder_date');
        $reminder->reminderresource_type = request('reminderresource_type');
        $reminder->reminderresource_id = request('reminderresource_id');

        //save and return id
        if ($reminder->save()) {
        //email
        $client = DB::table('users')->where('clientid',$reminder->reminderresource_id)->first();

            $email_to = $client->email;
            $name_to  = $client->first_name;
            $email_data = array('username' => $name_to);
            print_r($email_to);
                Mail::send('pages.reminder', $email_data, function($message) 
                    use ($name_to, $email_to){
                    $message->to($email_to, $name_to)->subject
                    ('Reminder');
                    $message->from('51userdemo@gmail.com','mail');
              });
            // $to = "sukhwinderindiit@gmail.com";
            // $subject = "My subject";
            // $txt = "Hello world!";
            // $headers = "From: webmaster@example.com" . "\r\n" .
            // mail($to,$subject,$txt,$headers);

            return $reminder->reminder_id;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[ReminderRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a record
     * @param int $id reminder id
     * @return bool
     */
    public function update($id) {

        //get the record
        if (!$reminder = $this->reminders->find($id)) {
            Log::error("record could not be found - database error", ['process' => '[MilestoneRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'reminder_id' => $id ?? '']);
            return false;
        }

        //general
        $reminder->reminder_title = request('reminder_title');
        $reminder->reminder_description = request('reminder_description');
        $reminder->reminder_date = request('reminder_date');

        //save
        if ($reminder->save()) {
            return $reminder->reminder_id;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[ReminderRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }
}