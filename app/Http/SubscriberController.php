<?php


namespace Acfabro\Assignment2\Http;


use Acfabro\Assignment2\Database\Connection;
use Acfabro\Assignment2\Models\Field;
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
     * @throws \Exception
     */
    public function create(CreateSubscriberRequest $request)
    {
        $data = $request->toArray();

        // start a db transaction
        Connection::instance()->beginTransaction();

        try {
            // save subscriber
            $subscriber = new Subscriber($data);
            $subscriber->save();

            // save fields if any
            if (isset($data['fields']) && is_array($data['fields'])) {
                foreach ($data['fields'] as $row) {
                    $newField = new Field((array)$row);
                    $newField->subscriber()->associate($subscriber);
                    $newField->save();
                }
            }

            // commit transaction
            Connection::instance()->commit();
            return new Response(201, 'Subscription created', $subscriber);

        } catch (\Exception $e) {
            // rollback transaction
            Connection::instance()->rollBack();
            return new Response(500, 'Unable to save new subscription: ' . $e->getMessage());
        }

    }

    /**
     * Update a subscription
     * @param UpdateSubscriberRequest $request
     * @param $id
     * @return Response
     */
    public function update(UpdateSubscriberRequest $request, $id)
    {
        $subscriber = Subscriber::find($id);
        $subscriber->fill($request->toArray());
        if ($subscriber->save()) {
            return new Response(200, 'Subscription updated');
        } else {
            return new Response(500, 'Unable to update subscription');
        }
    }

}