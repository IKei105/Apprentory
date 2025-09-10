



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
            'user-name' => 'unittestusername',
            'discord-ID' => $discordId,
            'register-code' => $rawCode,
            'profile_image' => null,
        ]);

        $response->assertRedirect('/materials');

        $this->assertDatabaseHas('users', [
            'userid' => 'unit_test_user',
        ]);

        $this->assertDatabaseHas('profiles', [
            'username' => 'unittestusername',
        ]);
    }

    public function test_register_fails_when_register_code_is_wrong(): void
    {
        $term = Term::factory()->create();

        $discordId = '741466203478032394';
        $rawCode   = 'correct-code';
        TempRegisterCode::create([
            'discord_id'   => $discordId,
            'register_code'=> Hash::make($rawCode),
            'expires_at'   => now()->addDay(),
        ]);

        $response = $this->from('/register2') // 直前ページ（バリデーションNG時に戻る先）
            ->post('/register2', [
                'userid'               => 'unit_test_user',
                'term'                 => $term->id,
                'password'             => 'password123',
                'password_confirmation'=> 'password123',
                'user-name'            => 'ユニットテスト',
                'discord-ID'           => $discordId,
                'register-code'        => 'wrong-code', // ←わざと不一致
                'profile_image'        => null,
            ]);

        $response->assertStatus(302)->assertRedirect('/register2');
        $response->assertSessionHasErrors(['register-code']);
        $this->assertDatabaseMissing('users', ['userid' => 'unit_test_user']);
    }

}

