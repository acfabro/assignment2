<?php


namespace Acfabro\Assignment2\Requests;


use Acfabro\Assignment2\Error\ClientSideException;
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
class UpdateSubscriberRequest extends CreateSubscriberRequest
{
    public function __construct($method = 'GET', $uri = '/', $get = [], $post = [], $body = '')
    {
        parent::__construct($method, $uri, $get, $post, $body);
    }

    /**
     * returns the ID from the uri path
     * @return mixed
     */
    public function getId()
    {
        $parts = explode('/', $this->getUri());
        return $parts[3];
    }

    /**
     * Validate the request. May be called before injecting into a controller
     * @note would normally use a validation package
     * @throws ClientSideException
     */
    public function validate()
    {
        // check if name is present
        if ($this->hasParam('name') && !$this->getParam('name')) {
            throw new ClientSideException('invalid name');
        }

        // check is email is valid
        // a simple solution is to use a combination of regex and checkdnsrr()
        if ($this->hasParam('email')) {
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
            }
        }
        return true;
    }
}