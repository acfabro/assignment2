<?php


namespace Acfabro\Assignment2\Requests;


use Acfabro\Assignment2\Error\ClientSideException;
use Acfabro\Assignment2\Http\Request;

/**
 * Class CreateFieldRequest
 *
 * Request object for Create field use case
 *
 * @package Acfabro\Assignment2\Requests
 */
class CreateFieldRequest extends Request
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
        if (strlen($this->getParam('title')) == 0) {
            throw new ClientSideException('Please enter a valid title');
        }

        // check if type is valid
        if (strlen($this->getParam('type')) == 0) {
            throw new ClientSideException('Please enter a valid type');
        }

        // check if value is valid
        if (strlen($this->getParam('value')) == 0) {
            throw new ClientSideException('Please enter the value');
        }

        return true;
    }
}