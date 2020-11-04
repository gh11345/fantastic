<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Http\Controllers\UserController;

class UserTest extends TestCase
{
    protected $user;

    public function setUp() :void{
        parent::setUp();
        $this->user = $this->app->make('App\Http\Controllers\UserController');
    }

    public function testUserAction()
    {
        $requestParams = [
            'name'      => 'allen',
            'age'       => '80',
            'address'   => '111 test street'
        ];

        // create user
        $request = new Request($requestParams, [], []);
        $result = $this->user->createUser($request);
        $result = response()->json($result)->getContent();
        $result = json_decode($result, true);
        $result = $result['original'];

        if (!empty($result)) {
            $actual = $result['message'];
            $this->assertTrue($actual == 'user created');
        }
        $userId = DB::getPdo()->lastInsertId();

        //get specific user
        $result = $this->user->getUser($userId);
        $result = response()->json($result)->getContent();
        $result = json_decode($result, true);
        $result = $result['original'];

        if (!empty($result)) {
            $actual = $result['name'];
            $this->assertTrue(strlen($actual) > 0);
        }

        // get all user
        $result = $this->user->getAllUsers();
        $result = response()->json($result)->getContent();
        $result = json_decode($result, true);
        $result = $result['original'];

        if (!empty($result)) {
            $actual = $result[0]['id'];
            $this->assertTrue($actual > 0);
        }

        //update points
        $result = $this->user->updatePoints($userId, '+');
        $result = response()->json($result)->getContent();
        $result = json_decode($result, true);
        $result = $result['original'];

        if (!empty($result)) {
            $actual = $result['message'];
            $this->assertTrue($actual == 'points updated');
        }

        // delete user
        $result = $this->user->deleteUser($userId);
        $result = response()->json($result)->getContent();
        $result = json_decode($result, true);
        $result = $result['original'];

        if (!empty($result)) {
            $actual = $result['message'];
            $this->assertTrue($actual == 'user deleted');
        }

        
       
    }

}
