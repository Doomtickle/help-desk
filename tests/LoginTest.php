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
    public function a_user_should_see_the_login_page()
    {
        $this->visit('/')
             ->see('Sign in to start your session');
    }

    /** @test **/
    public function a_user_should_be_able_to_login()
    {

       $user = factory(App\User::class)->create(['password' => Hash::make('passw0RD')]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('passw0RD', 'password')
            ->press('Sign In')
            ->seePageIs('/home')
            ->see($user->name);
 
    }
    /** @test */
    public function all_login_fields_are_required()
    {
        $this->visit('/login')
            ->type('', 'email')
            ->type('', 'password')
            ->press('Sign In')
            ->see('The email field is required')
            ->see('The password field is required');

    }

    /** @test */
    public function register_page_should_work()
    {
        $this->visit('/register')
            ->see('Register a new membership');
    }

    /** @test */
    public function unauthenticated_users_should_be_redirected_to_login_page()
    {
        $this->visit('/home')
            ->seepageis('/login');
    }
    public function testLogout()
    {
        $user = factory(App\User::class)->create();

        $form = $this->actingAs($user)->visit('/home')->getForm('logout');

        $this->actingAs($user)
            ->visit('/home')
            ->makeRequestUsingForm($form)
            ->seePageIs('/login');
    }

    /**
     * Test 404 Error page.
     *
     * @return void
     */
    public function test404Page()
    {
        $this->get('asdasdjlapmnnk')
            ->seeStatusCode(404)
            ->see('404');
    }

    /**
     * Test user registration.
     *
     * @return void
     */
    public function testNewUserRegistration()
    {
        $this->visit('/register')
            ->type('Sergi Tur Badenas', 'name')
            ->type('sergiturbadenas@gmail.com', 'email')
            ->check('terms')
            ->type('passw0RD', 'password')
            ->type('passw0RD', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/home')
            ->seeInDatabase('users', ['email' => 'sergiturbadenas@gmail.com',
                                      'name'  => 'Sergi Tur Badenas', ]);
    }

    /**
     * Test required fields on registration page.
     *
     * @return void
     */
    public function testRequiredFieldsOnRegistrationPage()
    {
        $this->visit('/register')
            ->press('Register')
            ->see('The name field is required')
            ->see('The email field is required')
            ->see('The password field is required');
    }


}
