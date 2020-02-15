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
 * Request object for Create Subscriber Request
 *
 * @package Acfabro\Assignment2\Requests
 */
class CreateSubscriberRequest extends Request
{
    public function __construct($method = 'GET', $uri = '/', $get = [], $post = [], $body = '')
    {
        parent::__construct($method, $uri, $get, $post, $body);
    }

    /**
     * Validate the request. May be called before injecting into a controller
     * @note would normally use a validation package
     * @throws ClientSideException
     */
    public function validate()
    {
        // check if name is present
        if ($this->hasParam('name') && strlen($this->getParam('name')) == 0) {
            throw new ClientSideException('Please enter a valid name');
        }

        // check is email is valid
        if ($this->hasParam('name')) {
            $emailValidator = new EmailValidator();
            if (!$emailValidator->isValid(
                $this->getParam('email'),
                new MultipleValidationWithAnd([
                    new RFCValidation(),
                    new DNSCheckValidation(),
                    new SpoofCheckValidation(),
                ])
            )) {
                throw new ClientSideException('email is invalid');
            };
        }

        // check if email is in db already
        $subscriber = Subscriber::where('email', $this->getParam('email'))->get();
        if ($subscriber->count()) {
            throw new ClientSideException('email is already registered');
        }

        return true;
    }
}