<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [show] process for the goals
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Goals;
use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //content & title
        $html = view('pages/goals/components/modals/show-goal', compact('goal'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#plainModalBody',
            'action' => 'replace',
            'value' => $html);
        $jsondata['dom_html'][] = array(
            'selector' => '#plainModalTitle',
            'action' => 'replace',
            'value' => safestr($goal['goal_title']));

        //ajax response
        return response()->json($jsondata);

    }

}
