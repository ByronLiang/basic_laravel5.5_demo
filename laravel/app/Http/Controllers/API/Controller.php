<?php

namespace App\Http\Controllers\API;

/**
 * @OAS\Info(version="1.0.0",title="XXXX OpenApi",
 *      description="in the URL for parameter ?api_token=XXX.<br/>in the header for 'Authorization: Bearer XXX'. Which is used in JWT, Oauth, etc.",
 * )
 * @OAS\Server(url="/api")
 * @OAS\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 * )
 * @OAS\SecurityScheme(
 *   securityScheme="appType",
 *   description="应用类型：android,ios",
 *   type="apiKey",
 *   name="app_type",
 *   in="header",
 * )
 */
abstract class Controller extends \App\Http\Controllers\Controller
{
    /**
     * @var null|\App\Models\User
     */
    private $my;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            if (auth()->check()) {
                $this->my = auth()->user();
            }

            return $next($request);
        });
    }
}
