<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class DeviceTest extends DuskTestCase
{
    /**
     * Make sure all devices show up on the devices page
     *
     * @return void
     */
    public function testDevicesIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/devices')
                ->assertSee('Devices')
                ->assertSee('Kitchen Fridge')
                ->assertSee('Thermostat')
                ->assertSee('Gas Meter')
                ->assertSee('Water Meter')
                ->assertSee('Electricity Meter');
        });
    }

    /**
     * Test viewing a device
     */
    public function testViewDevice()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/devices')
                ->clickLink('Kitchen Fridge')
                ->assertPathIs('/device/1')
                ->assertSee('Kitchen Fridge')
                ->assertSee('Target Temperature')
                ->assertSee('Current Temperature')
                ->assertSee('Status')
                ->assertSee('Graphs');
        });
    }

    public function testEditDevice()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/devices')
                ->mouseover('#devices-list-group a:nth-child(5) i.mdi-pencil')
                ->click('#devices-list-group a:nth-child(5) i.mdi-pencil')
                ->assertPathIs('/device/5/edit')
                ->assertSee('Update Electricity Meter')
                ->type('txt-name', 'Water Meter Updated')
                ->press('Save')
                ->assertPathIs('/devices')
                ->assertSee('Water Meter Updated');
        });
    }
}