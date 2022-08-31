<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    /**
     * @OA\Get(
     *     path="/api/create",
     *     @OA\Response(response="200", description="create text.")
     * )
     */
    public function create()
    {
        return view('welcome');
    }
}
