<?php


namespace Acfabro\Assignment2\Models;


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
//        if (isset($attributes['fields']) && is_array($attributes['fields'])) {
//            foreach ($attributes['fields'] as $row) {
//                $newField = new Field((array)$row);
//                $this->fields()->create((array)$row);
//            }
//        }

        return $result;
    }

}