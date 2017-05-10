<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChangePasswordTest extends DuskTestCase
{
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('txt-email', 'dev@dev.dev')
                ->type('txt-password', 'secret')
                ->press('Sign in');
        });
    }

    /**
     * Test changing a password with a wrong original password
     *
     * @return void
     */
    public function testWrongOriginal()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/changepassword')
                    ->assertSee('Change Password')
                    ->type('txt-cpassword', 'wrongpassword')
                    ->type('txt-password1', 'newpass')
                    ->type('txt-password2', 'newpass')
                    ->press('Save')
                    ->assertSee('You provided the wrong current password.');
        });
    }

    /**
     * Test changing a password with the right original password but blank new passwords
     *
     * @return void
     */
    public function testNewBothBlank()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/changepassword')
                    ->assertSee('Change Password')
                    ->type('txt-cpassword', 'secret')
                    ->type('txt-password1', '')
                    ->type('txt-password2', '')
                    ->press('Save')
                    ->assertSee('You need to provide another password.');
        });
    }

    /**
     * Test changing a password with the right original password but a blank confirmation
     *
     * @return void
     */
    public function testBlankConfirmation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/changepassword')
                    ->assertSee('Change Password')
                    ->type('txt-cpassword', 'secret')
                    ->type('txt-password1', 'newpass')
                    ->type('txt-password2', '')
                    ->press('Save')
                    ->assertSee('Your password confirmation does not match the new password.');
        });
    }

    /**
     * Test changing a password with the right original password but a wrong confirmation
     *
     * @return void
     */
    public function testWrongConfirmation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/changepassword')
                    ->assertSee('Change Password')
                    ->type('txt-cpassword', 'secret')
                    ->type('txt-password1', 'newpass')
                    ->type('txt-password2', 'newpass_different')
                    ->press('Save')
                    ->assertSee('Your password confirmation does not match the new password.');
        });
    }

    /**
     * Test changing a password successfully
     *
     * @return void
     */
    public function testSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/changepassword')
                    ->assertSee('Change Password')
                    ->type('txt-cpassword', 'secret')
                    ->type('txt-password1', 'secret')
                    ->type('txt-password2', 'secret')
                    ->press('Save')
                    ->assertSee('Your password was changed.');
        });
    }
}
