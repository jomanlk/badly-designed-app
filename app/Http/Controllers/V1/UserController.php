<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      tags={"Users"},
     *      summary="Get a user",
     *      description="Returns the user object that matches the ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User found",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *      )
     *     )
     */
    public function show(int $id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return response(["error" => "user not found"], 404);
        }

        return new UserResource($user);
    }


    /**
     * @OA\Get(
     *      path="/users/search/{keyword}",
     *      tags={"Users"},
     *      summary="Find users by name",
     *      description="Returns all users who have a name that mathes the search query",
     *      @OA\Parameter(
     *          name="keyword",
     *          description="Search keywords",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List of all users who matched the search query",
     *       )
     *     )
     * )
     */
    public function searchByName(string $keyword)
    {
        return new UserCollection(User::where('name', 'like', '%' . $keyword . '%')->paginate());
    }


	/**
	 * @OA\Get(
	 *      path="/users/most-posted",
	 *      tags={"Users"},
	 *      summary="Find top 5 message posters",
	 *      description="Returns the top 5 message posters within a given date range",
	 *      @OA\Parameter(
	 *          name="start_at",
	 *          description="Start date to filter by",
	 *          required=true,
	 *          in="query",
	 *          example="2022-03-20",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Parameter(
	 *          name="end_at",
	 *          description="End date to filter by",
	 *          required=true,
	 *          in="query",
	 *          example="2022-03-27",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Response(
	 *          response=200,
	 *          description="List of all users who matched the search query",
	 *       )
	 *     )
	 * )
	 */
    public function findUsersPostingTheMostMessages(Request $request)
    {
    	$startDate = new Carbon($request->get('start_at'));
    	$endDate = new Carbon($request->get('end_at'));

    	$rows = User::select(['users.*', DB::raw('COUNT(messages.id) AS message_count')])
		    ->leftJoin('messages', 'users.id', '=', 'messages.user_id')
	        ->whereBetween('messages.created_at', [$startDate, $endDate])
	        ->groupBy('users.email')
	        ->orderBy(DB::raw('COUNT(messages.id)'), 'DESC')
	        ->limit(5)
	        ->get();

    	return UserResource::collection($rows);
    }
}
