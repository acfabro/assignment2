<?php


namespace Acfabro\Assignment2\Models;


use Acfabro\Assignment2\Database\Connection;
use Acfabro\Assignment2\Error\ServerSideException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Subscriber
 *
 * Model for a subscriber
 *
 * @package Acfabro\Assignment2\Models
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $status
 * @property Collection $fields
 */
class Subscriber extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_UNSUBSCRIBED = 'unsubscribed';
    public const STATUS_JUNK = 'junk';
    public const STATUS_BOUNCED = 'bounced';
    public const STATUS_UNCONFIRMED = 'unconfirmed';

    protected $table = "subscribers";

    protected $fillable = ['name', 'email', 'state'];

    /**
     * The subscriber's fields
     * @return HasMany
     */
    public function fields()
    {
        return $this->hasMany(Field::class, 'subscriber_id', 'id');
    }

    public function getFieldById($id)
    {
        return $this->fields->filter(function($item) use ($id) {
            return @$item->id === $id;
        })->first();
    }

    /**
     * Override fill so we can take care of the fields
     * @param array $attributes
     * @return Model|void
     */
    public function fill(array $attributes)
    {
        // fill this model with the data
        $result = parent::fill($attributes);

        // fill the dependent fields models with data
        if (isset($attributes['fields']) && is_array($attributes['fields'])) {
            foreach ($attributes['fields'] as $row) {
                $newRow = (array)$row; //new Field((array)$row);

                // if field already exists, fill it
                if (isset($newRow['id']) && $this->getFieldById($newRow['id'])) {
                    $currentField = $this->getFieldById($newRow['id']);
                    $currentField->fill($newRow);
                }

                // else create a new field
                else {
                    $newField = new Field($newRow);
                    $this->fields->push($newField);
                }
            }
        }

        return $result;
    }

    /**
     * Save this object and all unsaved fields associated with it
     * @param array $options
     * @return bool|void
     * @throws \Exception
     */
    public function save(array $options = [])
    {
        try {
            Connection::instance()->beginTransaction();
            parent::save($options);// save all unsaved fields
            $this->fields->map(
                function ($item) {
                    if (empty($item->id) || $item->isDirty()) {
                        $item->subscriber_id = $this->id; // associate new field with this subscriber
                        $item->save();
                    }
                }
            );
            Connection::instance()->commit();

            return true;
        } catch (\Exception $e) {
            Connection::instance()->rollBack();

            throw new ServerSideException('Unable to save entity Subscriber: ' . $e->getMessage());
        }
    }

    /**
     * Delete this object and all fields associated
     * @return bool|null
     * @throws ServerSideException
     */
    public function delete()
    {
        try {
            // begin transaction
            Connection::instance()->beginTransaction();

            // delete all fields
            foreach ($this->fields as $field) {
                $field->delete();
            }

            // delete this
            parent::delete();

            Connection::instance()->commit();
            return true;

        } catch (\Exception $e) {
            Connection::instance()->rollBack();

            throw new ServerSideException('Unable to delete entity Subscriber: ' . $e->getMessage());
        }
    }

}