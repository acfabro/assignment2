<?php


namespace Acfabro\Assignment2\Http;


class Request
{
    /**
     * @var string
     */
    protected $body;
    /**
     * @var array
     */
    protected $get;
    /**
     * @var array|string
     */
    protected $post;
    /**
     * @var string
     */
    protected $uri;
    /**
     * @var string
     */
    protected $method;

    /**
     * Request constructor.
     *
     * not complete, for demo only -> only uses get, post, body
     *
     * @param string|Request $method Request method; or put in a request object to "cast" it
     * @param string $uri
     * @param array $get
     * @param array $post
     * @param string $body
     */
    public function __construct($method = 'GET', $uri = '/', $get = [], $post = [], $body='')
    {
        // you can instantiate this class (and subclasses) using an existing request
        // can be used for polymorphing Request subclasses
        if ($method instanceof Request) {
            $this->get = $method->getGet();
            $this->post = $method->getPost();
            $this->uri = $method->getUri();
            $this->body = $method->getBody();
            $this->method = $method->getMethod();

        } else {
            $this->get = !empty($get)? $get: $_GET;
            $this->post = !empty($post)? $post: $_POST;
            $this->uri = $uri;
            $this->body = $body;
            $this->method = $method;
        }
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getGet(): array
    {
        return $this->get;
    }

    /**
     * @return array
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * get an item from the GET list
     * @param string $name GET variable name
     * @return mixed
     */
    public function get($name)
    {
        return $this->get[$name];
    }

    /**
     * get an item from the POST list
     * @param string $name POST variable name
     * @return mixed
     */
    public function post($name)
    {
        if (is_array($this->post)) {
            return $this->post[$name];

        } elseif (is_object($this->post)) {
            return $this->post->$name;

        } elseif (is_string($this->post)) {
            return $this->post;

        } else {
            return null;

        }
    }

    /**
     * get an item from the GET list
     * @param string $name GET variable name
     * @return mixed
     */
    public function input($name)
    {
        return @array_merge($this->post, $this->get)[$name];
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
     * Returns a param passed in the request body
     * @param $name
     * @return mixed
     */
    public function getParam($name)
    {
        $array = $this->toArray();
        return @$array[$name];
    }

    /**
     * Tells if a param exists
     * @param $name
     * @return bool
     */
    public function hasParam($name)
    {
        $array = $this->toArray();
        return isset($array[$name]);
    }

}
