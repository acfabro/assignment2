<?php


namespace Acfabro\Assignment2\Http;


use Acfabro\Assignment2\Models\Subscriber;
use Acfabro\Assignment2\Requests\CreateSubscriberRequest;
use Acfabro\Assignment2\Requests\UpdateSubscriberRequest;

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
        if ($found->count()) {
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
     * @throws \Exception
     */
    public function create(CreateSubscriberRequest $request)
    {
        // create a new object, fill with data and save
        $data = $request->toArray();
        $subscriber = new Subscriber($data);
        $subscriber->save();

        return new Response(201, 'Subscriber created', $subscriber);
    }

    /**
     * Update a subscriber
     * @param UpdateSubscriberRequest $request
     * @param $id
     * @return Response
     * @throws \Exception
     */
    public function update(UpdateSubscriberRequest $request, $id)
    {
        $data = $request->toArray();

        // find the object to update
        $subscriber = Subscriber::find($id);
        if (!$subscriber) return new Response(404, 'Subscriber not found');

        // fill with data and save
        $subscriber->fill($data);
        $subscriber->save();

        return new Response(200, 'Subscriber updated', $subscriber);
    }

    /**
     * @param int $id delete a subscriber
     * @return Response
     * @throws \Exception
     */
    public function delete($id) {
        // find the object to delete
        $subscriber = Subscriber::find($id);
        if (!$subscriber) return new Response(404, 'Subscriber not found');

        // delete
        $subscriber->delete();

        return new Response(200, 'Subscriber deleted');
    }

}