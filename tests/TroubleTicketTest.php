<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class TroubleTicketTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $ticket;
    protected $company;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(App\User::class)->create(['beebole_key' => '123']);
        $this->company = factory(App\Company::class)->create();
        $this->ticket = factory(App\TroubleTicket::class)->create([
                'title'       => 'Title of ticket',
                'description' => 'Description for ticket',
                'company'     => $this->company->name,
                'category'    => 'Web',
                'priority'    => 2,
                'user_id'     => $this->user->id,
                'complete'    => false
            ]);
    }

    /** @test */
    public function unauthenticated_users_can_not_visit_create_tickets_page()
    {
        $this->visit('/ticket/create')
             ->see('Sign in to start your session');
    }

    /** @test */
    public function authenticated_users_can_visit_create_tickets_page()
    {
        $this->actingAs($this->user)
             ->visit('/ticket/create')
             ->see('New Task');
    }

    /** @test */
    public function authenticated_users_can_create_a_ticket()
    {

        $this->actingAs($this->user)
             ->visit('/ticket/create')
             ->submitForm('Submit', [
                'title'       => 'Title of ticket',
                'description' => 'Description for ticket',
                'company'     => $this->company->name,
                'category'    => 'Web',
                'priority'    => 2,
                ])
             ->visit('/home')
             ->see($this->company->name);
    }

    /** @test */
    public function all_fields_are_required_to_create_a_ticket()
    {
       $this->actingAs($this->user)
            ->visit('/ticket/create')
            ->submitForm('Submit', [
                'title'       => '',
                'description' => '',
                'company'     => '',
            ])
            ->see('The title field is required.')
            ->see('The description field is required.')
            ->see('The company field is required.');
    }

    /** @test */
    public function a_user_can_mark_a_ticket_complete()
    {
        $this->actingAs($this->user)
             ->visit('/')
             ->press('mark_complete')
             ->seeJson([
                'id' => $this->ticket->id
            ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_visit_the_edit_page_for_a_ticket()
    {
        $this->visit('/ticket/'.$this->ticket->id.'/edit')
             ->see('Sign in to start your session');
    }

    /** @test */
    public function a_user_can_visit_the_edit_page_for_a_ticket()
    {
        $this->actingAs($this->user)
             ->visit('/ticket/'.$this->ticket->id.'/edit')
             ->see('Edit Task #'. $this->ticket->id);
    }

    /** @test */
    public function a_user_can_edit_a_ticket()
    {
        $this->actingAs($this->user)
             ->visit('/ticket/'.$this->ticket->id.'/edit')
             ->submitForm('Submit', [
                'title'       => $this->ticket->title,
                'description' => 'Changed it!',
                'company'     => $this->ticket->company,
                'category'    => $this->ticket->category,
                'priority'    => $this->ticket->priority,
            ])
             ->visit('/home')
             ->see('Changed it!');
    }

}
