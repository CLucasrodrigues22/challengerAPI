<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[
    OA\Info(version: "1.0", description: "Challenger API", title: "Challenger API"),
    OA\Server(url: 'http://127.0.0.1', description: 'challenger-api server'),
]

abstract class Controller
{
    //
}
