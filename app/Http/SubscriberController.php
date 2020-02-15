<?php


namespace Acfabro\Assignment2\Http;


use Acfabro\Assignment2\Models\Subscriber;
use Acfabro\Assignment2\Requests\CreateSubscriberRequest;

/**
 * Class SubscriberController
 *
 * Controller for subscriber API services
 *
 * @package Acfabro\Assignment2\Http
 */
class SubscriberController extends Controller
{
    /**
     * List all subscribers
     * @param int $limit
     * @param int $offset
     * @return Response
     */
    public function list($limit = 10, $offset = 0)
    {
        // TODO apply limit and offset
        $list = Subscriber::all();
        return new Response(200, null, $list);
    }

    /**
     * Read one subscriber by ID
     * @param $id Subscriber's ID number
     * @return Response
     */
    public function read($id)
    {
        // find the subscriber include the fields
        $found = Subscriber::with('fields')
            ->where('id', $id)
            ->get();

        // response
        if ($found) {
            return new Response(200, null, $found);
        } else {
            return new Response(404, 'Subscriber not found');
        }
    }

    /**
     * Create a new subscriber record, can include fields
     *
     * @param CreateSubscriberRequest $request
     * @return Response
     */
    public function create(CreateSubscriberRequest $request)
    {
        $subcriber = new Subscriber($request->toArray());
        $subcriber->save();

        return new Response(201, 'Suibscription created');
    }

}