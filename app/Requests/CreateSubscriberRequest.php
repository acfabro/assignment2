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
     * get the body in json decoded to array
     * @return array
     */
    public function toArray()
    {
        return (array)json_decode($this->body);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getParam($name)
    {
        $array = $this->toArray();
        return $array[$name];
    }

    /**
     * Validate the request. May be called before injecting into a controller
     * @note would normally use a validation package
     * @throws ClientSideException
     */
    public function validate()
    {
        // check if name is present
        if (!$this->getParam('name')) {
            throw new ClientSideException('name is required');
        }

        // check is email is valid
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

        // check if email is in db already
        $subscriber = Subscriber::where('email', $this->getParam('email'))->get();
        if ($subscriber->count()) {
            throw new ClientSideException('email is already registered');
        }

        return true;
    }
}