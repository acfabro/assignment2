<?php

namespace Acfabro\Assignment2Tests\Models;

use Acfabro\Assignment2\Models\Field;
use Acfabro\Assignment2\Models\Subscriber;
use Acfabro\Assignment2Tests\AppTestCase;

class SubscriberTest extends AppTestCase
{
    public function testCreate()
    {
        $newSubscriber = new Subscriber($this->data);
        $newSubscriber->save();

        $this->assertTrue($newSubscriber->id > 1);
    }

    public function testUpdate()
    {
        $newSubscriber = new Subscriber($this->data);
        $newSubscriber->save();

        // now edit and save
        $newSubscriber->email = "jakester@nine-nine.com";
        $newSubscriber->save();

        $this->assertTrue($newSubscriber->email === "jakester@nine-nine.com");
    }

    public function testDelete()
    {
        $newSubscriber = new Subscriber($this->data);
        $newSubscriber->save();

        // now delete and save
        $result = $newSubscriber->delete();

        $this->assertTrue($result);
    }

    public function testFind()
    {
        $found = Subscriber::find(1);
        $this->assertTrue($found->id === 1);
    }

    protected $data = [
        'name' => 'Jake Peralta',
        'email' => 'jake@nine-nine.com',
        'state' => Subscriber::STATUS_ACTIVE,
    ];

    protected $dataWithFields = [
        'name' => 'Jake Peralta',
        'email' => 'jake@nine-nine.com',
        'state' => Subscriber::STATUS_ACTIVE,
        'fields' => [
            [
                'title' => 'Name on Badge',
                'type' => Field::TYPE_STRING,
                'value' => 'Jake',
            ],
            [
                'title' => 'Date hired',
                'type' => Field::TYPE_DATE,
                'value' => '2020-02-14',
            ],
        ],
    ];

    protected $dataField = [
        'title' => 'Age',
        'type' => Field::TYPE_NUMBER,
        'value' => 30,
    ];

}
