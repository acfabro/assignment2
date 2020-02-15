<?php


namespace Acfabro\Assignment2\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Field
 *
 * Field model
 *
 * @package Acfabro\Assignment2\Models
 * @property int $id
 * @property string $title
 * @property string $type
 * @property string $value
 * @property Subscriber $subscriber
 */
class Field extends Model
{
    public const TYPE_STRING = 'string';
    public const TYPE_NUMBER = 'number';
    public const TYPE_DATE = 'date';
    public const TYPE_BOOLEAN = 'boolean';

    protected $table = "fields";

    protected $fillable = ['title', 'type', 'value'];

    /**
     * The field's aggregate subscriber model
     */
    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class, 'subscriber_id', 'id');
    }
}