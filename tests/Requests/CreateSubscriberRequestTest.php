<?php

namespace Acfabro\Assignment2Tests\Requests;

use Acfabro\Assignment2\Error\ClientSideException;
use Acfabro\Assignment2\Models\Subscriber;
use Acfabro\Assignment2\Requests\CreateSubscriberRequest;
use Acfabro\Assignment2Tests\AppTestCase;

class CreateSubscriberRequestTest extends AppTestCase
{
    public function testCanValidateName()
    {
        try {
            $request = new CreateSubscriberRequest(
                "POST", "/api/subscriber", [], [],
                json_encode(
                    [
                        'email' => 'sample@gmail.com',
                        'state' => Subscriber::STATUS_ACTIVE,
                    ]
                )
            );
            $request->validate();

            // if we reach here, then we did not catch the error
            $this->fail();

        } catch (ClientSideException $e) {
            $this->assertSame($e->getMessage(), 'Please enter a valid name');
        }
    }

    public function testCanValidateEmailExists()
    {
        try {
            $request = new CreateSubscriberRequest(
                "POST", "/api/subscriber", [], [],
                json_encode(
                    [
                        'name' => 'Jake Peralta',
                        'state' => Subscriber::STATUS_ACTIVE,
                    ]
                )
            );
            $request->validate();

            // if we reach here, then we did not catch the error
            $this->fail();

        } catch (ClientSideException $e) {
            $this->assertSame($e->getMessage(), 'Please enter a valid email address');
        }
    }

    public function testCanValidateEmailValid()
    {
        try {
            $request = new CreateSubscriberRequest(
                "POST", "/api/subscriber", [], [],
                json_encode(
                    [
                        'name' => 'Jake Peralta',
                        'email' => 'jake@adadadaddsXCVCVZSCX.com',
                        'state' => Subscriber::STATUS_ACTIVE,
                    ]
                )
            );
            $request->validate();
        } catch (ClientSideException $e) {
            $this->assertSame($e->getMessage(), 'Please enter a valid email address');
        }
    }

}
