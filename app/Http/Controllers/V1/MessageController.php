<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function show(int $id) {
        return [
            'response' => Message::findOrFail($id)
        ];
    }


    public function searchByText(string $keyword) {
        return [
            'response' => Message::where('message', 'like', '%' . $keyword . '%')->get()
        ];
    }
}
