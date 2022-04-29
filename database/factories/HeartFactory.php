<?php

namespace Database\Factories;

use App\Models\Heart;
use App\Models\Message;
use App\Models\User;
use Closure;
use Database\Seeders\HeartSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class HeartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $messageId = (string) Message::pluck('id')->random(1)->get(0);
        $userId = (string) DB::table('users')
                    ->select('users.id')
                    ->whereNotIn('users.id', function($query) use($messageId) {
                        return $query->select('user_id')->from('hearts')->where([
                            'user_id' => DB::raw('users.id'),
                            'message_id' => $messageId
                        ]);
                    })
                    ->orderBy(DB::raw('rand()'))
                    ->limit(1)
                    ->pluck('id')
                    ->get(0);
        return [
            'user_id' => $userId,
            'message_id' => $messageId,
        ];
    }

}
