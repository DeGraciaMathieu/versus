<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Team;
use App\Models\User;
use App\Models\Game;
use App\Models\Ladder;
use App\Services\EloService;
use App\Services\LevelService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AjaxLadderControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_have_ladders()
    {
        $expectedLadders = Ladder::factory()->count(2)->create();

        $response = $this->get('/ajax/ladders');

        $response->assertSuccessful();

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['name' => $expectedLadders[0]->name]);
        $response->assertJsonFragment(['name' => $expectedLadders[1]->name]);
    }

    /** @test */
    public function can_have_ranking_by_ladder()
    {
        $ladder = Ladder::factory()->create();
        $member = User::factory()->create();

        $teams = $this->makeSomeMatchesForLadderAndMember($ladder, $member);

        $response = $this->actingAs($member)->get('/ajax/ladders/' . $ladder->id . '/ranking');

        $response->assertSuccessful();

        $response->assertJsonCount(2);

        $response->assertJsonFragment([
            'name' => $teams[0]->name,
            'rank' => 1,
            'current' => true,
        ]);

        $response->assertJsonFragment([
            'name' => $teams[1]->name,
            'rank' => 2,
            'current' => false,
        ]);
    }

    /** @test */
    public function admin_can_create_ladder()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/ajax/ladders', [
            'name' => $name = '100v100 King',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
        ]);

        $response->assertSuccessful();

        $response->assertJsonFragment([
            'name' => $name,
        ]);

        $this->assertDatabaseHas('ladders', [
            'name' => $name,
        ]);
    }

    /** @test */
    public function member_cant_create_ladder()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $response = $this->actingAs($member)->post('/ajax/ladders', [
            'name' => 'Not yet bro',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function guest_cant_create_ladder()
    {
        $response = $this->post('/ajax/ladders', [
            'name' => 'Not yet bro too',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
        ]);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_can_edit_ladder()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $ladder = Ladder::factory()->create([
            'name' => 'From the past with love',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
        ]);

        $response = $this->actingAs($admin)->put('/ajax/ladders/' . $ladder->id, [
            'name' => $name = 'New age !',
            'description' => "Everyday I'm Shuffling ...",
        ]);

        $response->assertSuccessful();

        $response->assertJsonFragment([
            'name' => $name,
        ]);

        $this->assertDatabaseHas('ladders', [
            'id' => $ladder->id,
            'name' => $name,
        ]);
    }

    /** @test */
    public function member_cant_edit_ladder()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $ladder = Ladder::factory()->create();

        $response = $this->actingAs($member)->put('/ajax/ladders/' . $ladder->id, [
            'name' => 'Not yet bro',
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function guest_cant_edit_ladder()
    {
        $ladder = Ladder::factory()->create();

        $response = $this->put('/ajax/ladders/' . $ladder->id, [
            'name' => 'Not yet bro too',
        ]);

        $response->assertRedirect('/login');
    }

    protected function makeSomeMatchesForLadderAndMember(Ladder $ladder, User $member): array
    {
        $noobTeam = Team::factory()->make([
            'elo' => 999,
        ]);

        $ladder->teams()->save($noobTeam);

        $proTeam = Team::factory()->make([
            'elo' => 2200,
        ]);

        $ladder->teams()->save($proTeam);
        $member->teams()->save($proTeam);

        $match = Game::create([
            'processed_at' => now(),
        ]);

        $match->teams()->save($noobTeam, ['score' => 0]);
        $match->teams()->save($proTeam, ['score' => 11]);

        $eloService = new EloService(new LevelService($this->app->get('config')));

        $eloService->resolveByGame($match);

        return [$proTeam, $noobTeam];
    }
}
