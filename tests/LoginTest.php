<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic functional test example.
     *
     * @return void
     */
    /** @test **/
    public function it_should_see_the_login_page()
    {
        $this->visit('/')
             ->see('Sign in to start your session');
    }
}
