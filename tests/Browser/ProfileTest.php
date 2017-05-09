<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;

class ProfileTest extends DuskTestCase
{
    /**
     * Test updating personal details but leaving the name field empty.
     *
     * @return void
     */
    public function testSaveNoName()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/profile')
                    ->assertSee('My Details')
                    ->type('txt-name', '')
                    ->press('Save')
                    ->assertSee('Your name is required.');
        });
    }

    /**
     * Test updating personal details but leaving the email field empty.
     *
     * @return void
     */
    public function testSaveNoEmail()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/profile')
                    ->assertSee('My Details')
                    ->type('txt-email', '')
                    ->press('Save')
                    ->assertSee('Your email address is required.');
        });
    }

    /**
     * Test updating personal details but using an invalid email address.
     *
     * @return void
     */
    public function testSaveInvalidEmail()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/profile')
                    ->assertSee('My Details')
                    ->type('txt-email', 'invalid@email')
                    ->press('Save')
                    ->assertSee('Your email address is invalid.');
        });
    }

    /**
     * Test updating personal details with a new name.
     *
     * @return void
     */
    public function testSaveNewName()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/profile')
                    ->assertSee('My Details')
                    ->type('txt-name', 'DeveloperEdited')
                    ->press('Save')
                    ->assertSee('Your details were saved.');
        });
    }

    /**
     * Test updating personal details with a new email address.
     *
     * @return void
     */
    public function testSaveNewEmail()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/profile')
                    ->assertSee('My Details')
                    ->type('txt-email', 'dev-edited@dev.dev')
                    ->press('Save')
                    ->assertSee('Your details were saved.');
        });
    }
}
