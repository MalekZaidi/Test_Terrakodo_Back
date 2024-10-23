<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Jardin;
use App\Models\User;

class JardinControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexJardin()
    {
        $jardin = Jardin::factory()->create();

        $response = $this->get(route('jardins.index'));

        $response->assertStatus(200)
                 ->assertViewHas('jardins');
    }

    public function testStoreJardinAdmin()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('jardins.store.admin'), [
            'nom' => 'Test Jardin',
            'adresse' => '123 rue de test',
        ]);

        $response->assertRedirect(route('jardins.index.admin'));
        $this->assertDatabaseHas('jardins', ['nom' => 'Test Jardin']);
    }
}
