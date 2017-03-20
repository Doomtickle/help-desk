<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ArchiveTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(App\User::class)->create();
    }

    /** @test */
    public function a_user_should_be_able_to_view_the_archive_page()
    {
        $this->actingAs($this->user)
             ->visit('/archive')
             ->see('Archive');
    }
}
