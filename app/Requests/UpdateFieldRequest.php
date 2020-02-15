<?php


namespace Acfabro\Assignment2\Requests;


use Acfabro\Assignment2\Error\ClientSideException;

/**
 * Class CreateFieldRequest
 *
 * Request object for Create field use case
 *
 * @package Acfabro\Assignment2\Requests
 */
class UpdateFieldRequest extends CreateFieldRequest
{
    public function __construct($method = 'GET', $uri = '/', $get = [], $post = [], $body = '')
    {
        parent::__construct($method, $uri, $get, $post, $body);
    }

    /**
     * return the subscriber id indicated in the body params
     * @return mixed
     */
    public function getSubscriberId()
    {
        return $this->getParam('subscriber_id');
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
        if ($this->hasParam('title') && strlen($this->getParam('title')) == 0) {
            throw new ClientSideException('Please enter a valid title');
        }

        // check if type is valid
        if ($this->hasParam('type') && strlen($this->getParam('type')) == 0) {
            throw new ClientSideException('Please enter a valid type');
        }

        // check if value is valid
        if ($this->hasParam('value') && strlen($this->getParam('value')) == 0) {
            throw new ClientSideException('Please enter the value');
        }

        return true;
    }

}