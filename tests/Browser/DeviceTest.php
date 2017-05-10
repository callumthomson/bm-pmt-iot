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
     *
     * @return void
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

    /**
     * Test updating a device
     *
     * @return void
     */
    public function testUpdateDevice()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/devices')
                ->mouseover('#devices-list-group a:nth-child(5) i.mdi-pencil')
                ->click('#devices-list-group a:nth-child(5) i.mdi-pencil')
                ->assertPathIs('/device/5/edit')
                ->assertSee('Update Electricity Meter')
                ->type('txt-name', 'Electricity Meter U')
                ->press('Save')
                ->assertPathIs('/devices')
                ->assertSee('Electricity Meter U');
        });
    }

    /**
     * Test updating a device without a name
     *
     * @return void
     */
    public function testUpdateDeviceNoName()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/devices')
                ->mouseover('#devices-list-group a:nth-child(5) i.mdi-pencil')
                ->click('#devices-list-group a:nth-child(5) i.mdi-pencil')
                ->assertPathIs('/device/5/edit')
                ->assertSee('Update Electricity Meter U')
                ->type('txt-name', '')
                ->press('Save')
                ->assertPathIs('/device/5/edit')
                ->assertSee('You must provide a name');
        });
    }

    /**
     * Test deleting a device but cancelling before it gets deleted
     *
     * @return void
     */
    public function testCancelDeleteDevice()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/devices')
                ->mouseover('#devices-list-group a:nth-child(5) i.mdi-delete')
                ->click('#devices-list-group a:nth-child(5) i.mdi-delete')
                ->assertPathIs('/device/5/delete')
                ->assertSee('Delete Electricity Meter U')
                ->clickLink('Cancel')
                ->assertPathIs('/devices')
                ->assertSee('Electricity Meter U');
        });
    }

    /**
     * Test deleting a device
     *
     * @return void
     */
    public function testDeleteDevice()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/devices')
                ->mouseover('#devices-list-group a:nth-child(5) i.mdi-delete')
                ->click('#devices-list-group a:nth-child(5) i.mdi-delete')
                ->assertPathIs('/device/5/delete')
                ->assertSee('Delete Electricity Meter U')
                ->press('Delete')
                ->assertPathIs('/devices')
                ->assertDontSee('Electricity Meter U');
        });
    }

    /**
     * Test creating a device
     *
     * @return void
     */
    public function testCreateDevice()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/devices')
                ->click('.fab-main i.glyphicon-plus')
                ->assertPathIs('/device/create')
                ->type('txt-name', 'New Device')
                ->select('sel-type', '1')
                ->press('Save')
                ->assertPathIs('/devices')
                ->assertSee('New Device');
        });
    }

    /**
     * Test creating a device with no name
     *
     * @return void
     */
    public function testCreateDeviceNoName()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/devices')
                ->click('.fab-main i.glyphicon-plus')
                ->assertPathIs('/device/create')
                ->type('txt-name', '')
                ->select('sel-type', '1')
                ->press('Save')
                ->assertPathIs('/device/create')
                ->assertSee('You must provide a name');
        });
    }
}