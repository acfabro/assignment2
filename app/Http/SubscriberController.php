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

        try {
            // start a db transaction
            Connection::instance()->beginTransaction();

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
            return new Response(201, 'Subscriber created', $subscriber);

        } catch (\Exception $e) {
            // rollback transaction
            Connection::instance()->rollBack();
            return new Response(500, 'Unable to save new subscriber: ' . $e->getMessage());
        }
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

        try {
            // start a db transaction
            Connection::instance()->beginTransaction();

            // save subscriber
            $subscriber = Subscriber::find($id);
            $subscriber->fill($data);
            $subscriber->save();

            // commit transaction
            Connection::instance()->commit();
            return new Response(201, 'Subscriber updated', $subscriber);

        } catch (\Exception $e) {
            // rollback transaction
            Connection::instance()->rollBack();
            return new Response(500, 'Unable to save updates to subscriber: ' . $e->getMessage());
        }
    }

    /**
     * @param int $id delete a subscriber
     * @return Response
     * @throws \Exception
     */
    public function delete($id) {
        try {
            // start a db transaction
            Connection::instance()->beginTransaction();

            // delete subscribers and fields
            $subscriber = Subscriber::find($id);
            if (!$subscriber) return new Response(404, 'Subscriber not found');
            $subscriber->delete();

            // delete fields
            Field::where('subscriber_id', $id)->delete();

            // commit transaction
            Connection::instance()->commit();
            return new Response(200, 'Subscriber deleted');

        } catch (\Exception $e) {
            // rollback transaction
            Connection::instance()->rollBack();
            return new Response(500, 'Unable to delete subscriber: ' . $e->getMessage());
        }
    }

}