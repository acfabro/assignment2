<?php

if (!function_exists('app')) {
    function app($item) {
        return \Acfabro\Assignment2\Helpers\App::container($item);
    }
}