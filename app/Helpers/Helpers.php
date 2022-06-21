<?php

namespace App\Helpers;

class Helpers
{
    public static function test()
    {
        return true;
    }

    public static function response($response, $route = '/', $http = 200)
    {
        return $response['ajax'] ? response(['notification' => ['status' => $response['status'], 'message' => $response['message']]], $http) :
            redirect()->route($route)->with('notification', ['status' => 'error', 'message' => $response['message']], $route);
    }

    public static function success($response, $route = '/', $http = 200)
    {
        return redirect()->route($route)->with('notification', ['status' => 'success', 'message' => $response['message']], $route);
    }

    public static function failure($response, $route = '/', $http = 200)
    {
        return redirect()->route($route)->with('notification', ['status' => 'error', 'message' => $response['message']], $route);
    }
}
