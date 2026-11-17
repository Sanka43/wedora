<?php

namespace Tests\Feature;

use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Identity\Models\User;
use App\Domains\Marketplace\Models\VendorCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Begin Your Journey');
    }

    public function test_couple_can_register_and_is_redirected_to_onboarding(): void
    {
        $response = $this->post('/register', [
            'name' => 'Kasun Perera',
            'email' => 'kasun@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '+94771234567',
            'role' => 'couple',
            'partner_name' => 'Amaya',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('workspace.onboarding'));

        $this->assertDatabaseHas('users', [
            'email' => 'kasun@example.com',
            'name' => 'Kasun Perera',
            'role' => 'couple',
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'partner_name' => 'Amaya',
        ]);
    }

    public function test_vendor_can_register_with_business_details(): void
    {
        $category = VendorCategory::create([
            'name' => 'Photography',
            'slug' => 'photography',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->post('/register', [
            'name' => 'Sunil Shantha',
            'email' => 'sunil@weddingshots.lk',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '+94711122334',
            'role' => 'vendor',
            'business_name' => 'Ceylon Grand Moments',
            'category_id' => $category->id,
            'district' => 'Kandy',
        ]);

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'sunil@weddingshots.lk',
            'role' => 'vendor',
        ]);

        $this->assertDatabaseHas('vendors', [
            'business_name' => 'Ceylon Grand Moments',
            'district' => 'Kandy',
        ]);
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Welcome Back');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::create([
            'name' => 'Amaya Fernando',
            'email' => 'amaya@example.com',
            'password' => bcrypt('secret123'),
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $response = $this->post('/login', [
            'email' => 'amaya@example.com',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('workspace.onboarding'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::create([
            'name' => 'Amaya Fernando',
            'email' => 'amaya@example.com',
            'password' => bcrypt('secret123'),
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $response = $this->post('/login', [
            'email' => 'amaya@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_users_can_logout(): void
    {
        $user = User::create([
            'name' => 'Amaya Fernando',
            'email' => 'amaya@example.com',
            'password' => bcrypt('secret123'),
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_user_profile_can_be_updated(): void
    {
        $user = User::create([
            'name' => 'Amaya Fernando',
            'email' => 'amaya@example.com',
            'password' => bcrypt('secret123'),
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'Amaya Senanayake',
            'email' => 'amaya@example.com',
            'phone' => '+94779876543',
            'partner_name' => 'Kasun',
            'preferred_locale' => 'si',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Amaya Senanayake',
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'partner_name' => 'Kasun',
            'preferred_locale' => 'si',
        ]);
    }
}
