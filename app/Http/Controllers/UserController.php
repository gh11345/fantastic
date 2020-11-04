<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leaderboard;

class UserController extends Controller
{
	protected $leaderBoard;
	const HTTP_NOT_FOUND 			= 404;
	const HTTP_BAD_REQUEST 			= 400;
	const HTTP_CREATED 				= 201;
	const HTTP_OK 					= 200;
	const POINTS_VALUE_PER_CHANGE 	= 1;
	const DEFAULT_POINTS 			= 0;
	const MODIFIER_PLUS 			= '+';
	const MODIFIER_MINUS 			= '-';


	public function __construct(Leaderboard $leaderBoard)
    {
    	$this->leaderBoard = $leaderBoard;
    }


	/**
	 * Get User list and order by points value from high to low
	 */ 
    public function getAllUsers()
    {
	    $userData = $this->leaderBoard::orderBy('points', 'DESC')->get();

	    return response()->json($userData, self::HTTP_OK);
  	}

  	/**
	 * Get specific user by his/her id
	 * @param int $id The user id
	 */ 
  	public function getUser($id)
  	{
  		if ($this->leaderBoard::where('id', $id)->exists() ) {
  			$user 		= $this->leaderBoard::where('id', $id)->get();
    		$points 	= $user[0]->points;
    		$name 		= $user[0]->name;
    		$age 		= $user[0]->age;
    		$address 	= $user[0]->address;

    		$userData = [
    			'name'		=> $name,
    			'age'		=> $age,
    			'address'	=> $address,
    			'points'	=> $points,
    		];

    		return response()->json($userData, self::HTTP_OK);

  		} else {
  			return response()->json([
				"message" => "user not found"
			], self::HTTP_NOT_FOUND);
  		}
  	}

  	/**
	 * Create user
	 * @param Request $request The http request
	 */
  	public function createUser(Request $request) 
  	{

		$this->leaderBoard->name = $request->name ?? '';
		$this->leaderBoard->age = $request->age ?? '';
		$this->leaderBoard->address = $request->address ?? '';
		$this->leaderBoard->points = self::DEFAULT_POINTS;

		if (!empty($request->name) && !empty($request->age) && !empty($request->address)) {
			$this->leaderBoard->save();
		} else {
			return response()->json([
				"message" => "invalid user data"
			], self::HTTP_BAD_REQUEST);
		}

		return response()->json([
				"message" => "user created"
			], self::HTTP_CREATED);

    }

    /**
	 * Update points, for + or - action
	 * @param int $id The user id
	 * @param string $modifier (+ or -)
	 */
    public function updatePoints($id, $modifier)
    {
    	if ($this->leaderBoard::where('id', $id)->exists() ) {
    		$user = $this->leaderBoard::where('id', $id)->get();
    		$points = $user[0]->points;

    		if ($modifier == self::MODIFIER_PLUS) {
    			$points += self::POINTS_VALUE_PER_CHANGE;

    		} else if ($modifier == self::MODIFIER_MINUS) {
    			$points -= self::POINTS_VALUE_PER_CHANGE;

    		} else {
    			return response()->json([
					"message" => "invalid modifier provided"
				], self::HTTP_BAD_REQUEST);
    		}

    		$user = $this->leaderBoard::find($id);
    		$user->points = $points;
    		$user->save();

    		return response()->json([
				"message" => "points updated"
			], self::HTTP_CREATED);

    	} else {
    		return response()->json([
				"message" => "user not found"
			], self::HTTP_NOT_FOUND);
    	}

    }

    /**
	 * Delete user
	 * @param int $id The user id
	 */
    public function deleteUser($id)
    {
    	if ($this->leaderBoard::where('id', $id)->exists() ) {
    		$this->leaderBoard::where('id', $id)->delete();

    		return response()->json([
				"message" => "user deleted"
			], self::HTTP_OK);

    	} else {
    		return response()->json([
				"message" => "user not found"
			], self::HTTP_NOT_FOUND);
    	}
    }


}
