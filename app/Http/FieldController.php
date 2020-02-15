<?php


namespace Acfabro\Assignment2\Http;


use Acfabro\Assignment2\Models\Field;
use Acfabro\Assignment2\Requests\CreateFieldRequest;
use Acfabro\Assignment2\Requests\UpdateFieldRequest;

/**
 * Class FieldController
 *
 * Controller for Field API services
 *
 * @package Acfabro\Assignment2\Http
 */
class FieldController extends Controller
{

    /**
     * Create a new field, subscriber id should already be existing
     * @param CreateFieldRequest $request
     * @return Response
     */
    public function create(CreateFieldRequest $request)
    {
        // create the field and save
        $field = new Field($request->toArray());
        $field->subscriber_id = $request->getParam('subscriber_id');
        if ($field->save()) {
            return new Response(201, 'Field created', $field);
        } else {
            return new Response(500, 'Field could not be created', $field);
        }
    }

    /**
     * Update an existing field
     * @param UpdateFieldRequest $request
     * @param int $id ID of the field
     * @return Response
     */
    public function update(UpdateFieldRequest $request)
    {
        // create the field and save
        $field = Field::find($request->getId());
        $field->fill($request->toArray());
        if ($field->save()) {
            return new Response(200, 'Field updated', $field);
        } else {
            return new Response(500, 'Field could not be updated', $field);
        }
    }

    /**
     * Delete a field
     * @param int $id ID of the field
     * @return Response
     */
    public function delete($id)
    {
        $field = Field::find($id);
        if (!$field) return new Response(404, 'Field not found');
        if ($field->delete()) {
            return new Response(200, 'Field deleted');
        } else {
            return new Response(500, 'Field could not be deleted');
        }
    }

}