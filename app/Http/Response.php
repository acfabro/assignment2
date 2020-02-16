<?php


namespace Acfabro\Assignment2\Http;


/**
 * Class Response
 *
 * Http response
 *
 * @package Acfabro\Assignment2\Http
 */
class Response
{
    /**
     * @var string HTTP response code
     */
    protected $code;
    /**
     * @var string Reponse message
     */
    protected $message;
    /**
     * @var array|object Json paylod
     */
    protected $data = [];
    /**
     * @var array Errors encountered
     */
    protected $errors = [];

    /**
     * @var array HTTP response headers
     */
    protected $headers = [];

    public function __construct($code, $message = null, $data = [], $errors = [])
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return array|object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param string $code
     * @return Response
     */
    public function setCode(string $code): Response
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param array $message
     * @return Response
     */
    public function setMessage(array $message): Response
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param array|object $data
     * @return Response
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param array $errors
     * @return Response
     */
    public function setErrors(array $errors): Response
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @param array $headers
     * @return Response
     */
    public function setHeaders(array $headers): Response
    {
        $this->headers = $headers;
        return $this;
    }

    public function setHeader($key, $value): Response
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function render()
    {
        // render headers
        header("HTTP/1.1 {$this->getCode()} {$this->getMessage()}", false);

        // content type
        $this->enableContentTypeJson();
        foreach ($this->headers as $key => $header) {
            header("{$key}: {$header}", false);
        }

        // assemble everything
        $output['responseCode'] = $this->getCode();
        if ($this->getMessage() !== null) $output['message'] = $this->getMessage();
        $output['data'] = $this->getData();

        // echo
        echo json_encode($output);
    }

    /**
     * Enable cors. Enable ALL cors for this exercise for now
     */
    public function enableCors()
    {
        $this->setHeader('Access-Control-Allow-Origin','*');
        $this->setHeader('Access-Control-Allow-Methods','GET, POST, PUT, PATCH, DELETE, HEAD');
        $this->setHeader('Access-Control-Allow-Headers','*');
        $this->setHeader('Access-Control-Max-Age', 86400);
    }

    /**
     * Enable cors. Enable ALL cors for this exercise for now
     */
    public function enableContentTypeJson()
    {
        $this->setHeader('Content-Type','application/json');
    }



}