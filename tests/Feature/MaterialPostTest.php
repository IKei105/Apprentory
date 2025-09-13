<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Database\Seeders\TermsSeeder;
use Tests\TestCase;

class MaterialPostTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'material-title'    => 'テスト教材タイトル',
            'material-thoughts' => 'とても良い教材でした！',
            'material-rate'     => 5,
            'material-price'    => 1200,
            'material-url'      => 'https://example.com/article',
            'select1'           => 2,
            'material-category' => 1,
        ], $overrides);
    }

    public function test_authenticated_user_can_post_material(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Profile::factory()->create();
        Storage::fake('public');

        $payload = $this->validPayload([
            'material-image' => new UploadedFile(
                base_path('tests/fixtures/test-cover.png'),
                'test-cover.png',
                'image/jpeg',
                null,
                true
            ),
        ]);

        $response = $this->actingAs($user)->post(route('materials.store'), $payload);
        $response->assertRedirect();

        $this->assertDatabaseHas('materials', [
            'title'       => 'テスト教材タイトル',
            'price'       => 1200,
            'material_url'=> 'https://example.com/article',
            'category_id' => 1,
        ]);

        $this->assertDatabaseHas('material_posts', [
            'posted_user_id' => $user->id,
        ]);


        $material = Material::where('title', 'テスト教材タイトル')->first();
        $this->assertNotNull($material);
        if (!empty($material->image_path)) {
            Storage::disk('public')->assertExists($material->image_path);
        }
    }

    public function test_guest_cannot_post_material(): void
    {
        $payload = $this->validPayload();

        $response = $this->post(route('materials.store'), $payload);

        $response->assertRedirect(route('login'));
    }
}
