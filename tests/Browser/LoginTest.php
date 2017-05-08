<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * Test the login page displays correctly
     *
     * @return void
     */
    public function testLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login');
        });
    }

    /**
     * Test submitting the login page with an incorrect email address and password
     *
     * @return void
     */
    public function testLoginSubmissionWrongEmailAndPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('txt-email', 'test@example.com')
                    ->type('txt-password', 'wrongpassword123')
                    ->press('Sign in')
                    ->assertSee('Invalid credentials entered.');
        });
    }

    /**
     * Test submitting the login page with a correct email address but an incorrect password
     *
     * @return void
     */
    public function testLoginSubmissionRightEmailAndWrongPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('txt-email', 'dev@dev.dev')
                    ->type('txt-password', 'wrongpassword123')
                    ->press('Sign in')
                    ->assertSee('Invalid credentials entered.');
        });
    }

    /**
     * Test submitting the login page with a correct email address and a correct password
     *
     * @return void
     */
    public function testLoginSubmissionRightEmailAndRightPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('txt-email', 'dev@dev.dev')
                    ->type('txt-password', 'secret')
                    ->press('Sign in')
                    ->assertPathIs('/devices');
        });
    }
}
