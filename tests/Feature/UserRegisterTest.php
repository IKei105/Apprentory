<?php

use App\Models\Term;
use App\Models\TempRegisterCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registers_successfully(): void
    {
        $term = Term::factory()->create();

        $discordId = '741466203478032394';
        $rawCode = 'tvrl83g59bhnepku';

        TempRegisterCode::create([
            'discord_id' => $discordId,
            'register_code' => Hash::make($rawCode),
            'expires_at' => now()->addDay(),
        ]);

        $response = $this->post('/register2', [
            'userid' => 'unit_test_user',
            'term' => $term->id,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'user-name' => 'ユニットテスト',
            'discord-ID' => $discordId,
            'register-code' => $rawCode,
            'profile_image' => null,
        ]);

        $response->assertRedirect('/materials');

        $this->assertDatabaseHas('users', [
            'userid' => 'unit_test_user',
        ]);

        $this->assertDatabaseHas('profiles', [
            'username' => 'ユニットテスト君',
        ]);
    }
}
