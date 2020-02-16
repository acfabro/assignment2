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
 * Request object for Create Subscriber use case
 *
 * @package Acfabro\Assignment2\Requests
 */
class UpdateSubscriberRequest extends CreateSubscriberRequest
{
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

        // if email is present, check if valid
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

        // check if state is valid
        if (strlen($this->getParam('state')) == 0) {
            throw new ClientSideException('State is required');
        }

        // validate the embedded fields
        $this->validateFields($this->getParam('fields'));

        return true;
    }
}