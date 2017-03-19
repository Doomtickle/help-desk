<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomePageTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_must_input_their_beebole_key_before_seeing_tasks()
    {
        $user = factory(App\User::class)->create(['beebole_key' => '']);
        $this->actingAs($user)
             ->visit('/home')
             ->see('Paste your beebole API key here');
    }

    /** @test */
    public function it_must_assign_beebole_key_to_current_user_when_entered()
    {
        $user = factory(App\User::class)->create(['beebole_key' => '']);

        $this->actingAs($user)
             ->visit('/home')
             ->type('123', '#beebole_key')
             ->press('Submit')
             ->assertTrue($user->beebole_key == '123');
    }

    /** @test */
    public function users_should_see_tasks_if_they_have_a_beebole_key()
    {
        $user = factory(App\User::class)->create(['beebole_key' => '92384789247']);
        $ticket = factory(App\TroubleTicket::class)->create();

        $this->actingAs($user)
             ->visit('/home')
             ->see($ticket->description);
    }


}
