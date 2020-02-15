<?php


namespace Acfabro\Assignment2\Models;


use Illuminate\Database\Eloquent\Model;
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields()
    {
        return $this->hasMany(Field::class, 'subscriber_id');
    }
}