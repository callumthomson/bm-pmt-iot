<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Device;
use DB;

class ApiTest extends TestCase
{
    /**
     * Test sending a message to the API
     *
     * @return void
     */
    public function testPostMessage()
    {
        $device = Device::find(1);
        $response = $this->json('POST', '/api/message', [
            'token' => $device->token,
            'body' => '{"temp_target": 5,"temp_current": 4}'
        ]);
        $response->assertStatus(200);
        //$response->assertDatabaseHas('messages', ['body'=>'{"temp_target": 5,"temp_current": 4}']);
        $count = DB::table('messages')
            ->where('body', '=', '{"temp_target": 5,"temp_current": 4}')
            ->count();
        $this->assertEquals(1, $count);
    }
}
