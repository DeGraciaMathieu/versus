<?php

use App\Models\Game;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLadderIdColumnOnGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->unsignedBigInteger('ladder_id')->nullable();
        });

        Game::with('teams.ladder')->each(function (Game $game) {
            $ladder = $game->teams->first()->ladder;

            $game->ladder()->associate($ladder);

            $game->save();
        });

        Schema::table('games', function (Blueprint $table) {
            $table->unsignedBigInteger('ladder_id')->nullable(false)->change();
            $table->foreign('ladder_id')->references('id')->on('ladders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ladder_id');
        });
    }
}
