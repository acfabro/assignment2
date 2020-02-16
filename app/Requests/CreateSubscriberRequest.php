<?php


namespace Acfabro\Assignment2\Requests;


use Acfabro\Assignment2\Error\ClientSideException;
use Acfabro\Assignment2\Http\Request;
use Acfabro\Assignment2\Models\Subscriber;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\SpoofCheckValidation;

/**
 * Class CreateSubscriberRequest
 *
 * Request object for Create Subscriber use case
 *
 * @package Acfabro\Assignment2\Requests
 */
class CreateSubscriberRequest extends Request
{
    /**
     * Validate the request. May be called before injecting into a controller
     * @note would normally use a validation package
     * @throws ClientSideException
     */
    public function validate()
    {
        // check if name is present
        if (strlen($this->getParam('name')) == 0) {
            throw new ClientSideException('Please enter a valid name');
        }

        // check is email is valid
        $emailValidator = new EmailValidator();
        if (!$emailValidator->isValid(
            $this->getParam('email'),
            new MultipleValidationWithAnd(
                [
                    new RFCValidation(),
                    new DNSCheckValidation(),
                    new SpoofCheckValidation(),
                ]
            )
        )) {
            throw new ClientSideException('Please enter a valid email address');
        }

        // check if email is in db already
        $subscriber = Subscriber::where('email', $this->getParam('email'))->get();
        if ($subscriber->count()) {
            throw new ClientSideException('email is already registered');
        }

        // check if state is valid
        if (strlen($this->getParam('state')) == 0) {
            throw new ClientSideException('State is required');
        }

        // validate the embedded fields
        $this->validateFields($this->getParam('fields'));

        return true;
    }

    /**
     * Validate the fields in the parameters
     * @param $fields
     * @throws ClientSideException
     */
    protected function validateFields($fields)
    {
        if ($fields) {
            foreach ($fields as $field) {
                $fieldRequest = new CreateFieldRequest($this->getMethod(), '', [], [], json_encode($field));
                $fieldRequest->validate();
            }
        }
    }
}