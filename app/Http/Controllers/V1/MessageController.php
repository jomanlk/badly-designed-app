<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageCollection;
use App\Http\Resources\MessageResource;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * @OA\Get(
     *      path="/messages",
     *      tags={"Messages"},
     *      summary="Retrieve all messages",
     *      description="Paginated list of all messages",
     *      @OA\Response(
     *          response=200,
     *          description="Messages found",
     *       ),
     *     )
     */
    public function index()
    {
        return new MessageCollection(Message::with(['hearts'])->where('id', '>', 0)->paginate());
    }

    /**
     * @OA\Get(
     *      path="/messages/{id}",
     *      tags={"Messages"},
     *      summary="Get a message",
     *      description="Returns the message object that matches the ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="Message id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Message found",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *      )
     *     )
     */
    public function show(int $id)
    {
        $message = Message::with(['hearts'])->find($id);
        if (empty($message)) {
            return response(["error" => "message not found"], 404);
        }

        return new MessageResource($message);
    }


    /**
     * @OA\Get(
     *      path="/messages/search/{keyword}",
     *      tags={"Messages"},
     *      summary="Find messages by text",
     *      description="Returns all messages that contain the search query",
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
     *          description="List of all messages that matched the search query",
     *       )
     *     )
     * )
     */
    public function searchByText(string $keyword)
    {
        return new MessageCollection(Message::where('message', 'like', '%' . $keyword . '%')->paginate());
    }
}
