<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Evenement;
use App\Models\Jardin;
use App\Models\User;

class EvenementControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowEvenement()
    {
        // Créer un utilisateur
        $user = User::factory()->create();
        
        // Créer un jardin et un événement
        $jardin = Jardin::factory()->create();
        $evenement = Evenement::factory()->create([
            'jardin_id' => $jardin->id,
            'user_id' => $user->id,
        ]);

        // Appeler l'action show et vérifier que l'affichage fonctionne
        $response = $this->actingAs($user)->get(route('evenements.show', $evenement->id));

        $response->assertStatus(200)
                 ->assertViewHas('evenement', $evenement);
    }

    public function testCreateEvenementAdmin()
    {
        $user = User::factory()->create();
        $jardin = Jardin::factory()->create();

        $response = $this->actingAs($user)->post(route('evenements.store.admin'), [
            'nom' => 'Test Evenement',
            'description' => 'Ceci est un test d\'événement',
            'date' => now()->addDay(),
            'jardin_id' => $jardin->id,
        ]);

        $response->assertRedirect(route('evenements.index.admin'));
        $this->assertDatabaseHas('evenements', ['nom' => 'Test Evenement']);
    }
}
