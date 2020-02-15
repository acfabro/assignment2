<?php

namespace Acfabro\Assignment2Tests\Requests;

use Acfabro\Assignment2\Error\ClientSideException;
use Acfabro\Assignment2\Models\Subscriber;
use Acfabro\Assignment2\Requests\CreateFieldRequest;
use Acfabro\Assignment2\Requests\CreateSubscriberRequest;
use Acfabro\Assignment2Tests\AppTestCase;

class CreateFieldRequestTest extends AppTestCase
{
    public function testCanCheckValidName()
    {
        try {
            $request = new CreateFieldRequest(
                "POST", "/api/field", [], [],
                json_encode(
                    [
                        'title' => '',
                        'type' => 'string',
                        'value' => 'xxx'
                    ]
                )
            );
            $request->validate();

            // if we reach here, then we did not catch the error
            $this->fail();

        } catch (ClientSideException $e) {
            $this->assertSame($e->getMessage(), 'Please enter a valid title');
        }
    }

    public function testCanCheckValidType()
    {
        try {
            $request = new CreateFieldRequest(
                "POST", "/api/field", [], [],
                json_encode(
                    [
                        'title' => 'New title',
                        'type' => '',
                        'value' => 'xxx'
                    ]
                )
            );
            $request->validate();

            // if we reach here, then we did not catch the error
            $this->fail();

        } catch (ClientSideException $e) {
            $this->assertSame($e->getMessage(), 'Please enter a valid type');
        }
    }

}
