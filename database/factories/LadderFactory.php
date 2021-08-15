<?php

namespace Database\Factories;

use App\Models\Ladder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class LadderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ladder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Ping-Pong', 'Ping-Pong', 'Street Fighter', 'Shifumi', 'Mario Kart', 'Windjammers']),
            'description' => $this->faker->text(42),
            'thumbnail' => config('image.ladder.filename'),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Ladder $ladder) {
            if (! Storage::exists($path = 'images/' . $ladder->thumbnail)) {
                $data = config('image.ladder.data');

                Storage::put($path, base64_decode($data));
            }
        });
    }
}
