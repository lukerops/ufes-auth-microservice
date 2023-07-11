<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test if the user can login successfully
     *
     * @return void
     */
    public function test_login_successfully()
    {
        $faker = Faker::create();

        $email = $faker->email;
        $password = $faker->password;

        $user = User::factory()->create([
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(200);

        $user->tokens()->delete();
        $user->delete();
    }

    /**
     * Test if the user can login with invalid credentials
     *
     * @return void
     */
    public function test_login_with_invalid_credentials()
    {
        $faker = Faker::create();

        $response = $this->postJson('/api/login', [
            'email' => $faker->email,
            'password' => $faker->password,
        ]);

        $response->assertJson(['message' => 'Invalid credentials']);
        $response->assertStatus(401);
    }

    /**
     * Test if can find my user while logged in
     *
     * @return void
     */
    public function test_find_my_user_while_logged_in()
    {
        $faker = Faker::create();

        $email = $faker->email;
        $password = $faker->password;

        $user = User::factory()->create([
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $response = $this->actingAs($user)->getJson('/api/me');

        $response->assertStatus(200);
        $response->assertJson(['email' => $email]);

        $user->tokens()->delete();
        $user->delete();
    }

    /**
     * Test if can find my user without being logged in
     *
     * @return void
     */
    public function test_find_my_user_without_being_logged_in()
    {
        $response = $this->getJson('/api/me');

        $response->assertStatus(401);
    }

    /**
     * Test if can refresh token without being logged in
     *
     * @return void
     */
    public function test_refresh_token_while_logged_in()
    {
        $faker = Faker::create();

        $email = $faker->email;
        $password = $faker->password;

        $user = User::factory()->create([
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $initial_token = $user->tokens()->first();

        $response = $this->actingAs($user)->getJson('/api/refresh-token');

        $final_token = $user->tokens()->first();

        $response->assertStatus(200);
        $this->assertNotEquals($initial_token->id, $final_token->id);

        $user->tokens()->delete();
        $user->delete();
    }

    /**
     * Test if can refresh token without being logged in
     *
     * @return void
     */
    public function test_refresh_token_without_being_logged_in()
    {
        $response = $this->getJson('/api/refresh-token');

        $response->assertStatus(401);
    }

    /**
     * Test if can logout without being logged in
     *
     * @return void
     */
    public function test_logout_while_logged_in()
    {
        $faker = Faker::create();

        $email = $faker->email;
        $password = $faker->password;

        $user = User::factory()->create([
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $tokens = $user->tokens();
        $this->assertGreaterThan(0, $tokens->count());

        $response = $this->actingAs($user)->deleteJson('/api/logout');
        $response->assertStatus(200);

        $tokens = $user->tokens();
        $this->assertEquals(0, $tokens->count());
        
        $user->tokens()->delete();
        $user->delete();
    }

    /**
     * Test if can logout without being logged in
     *
     * @return void
     */
    public function test_logout_without_being_logged_in()
    {
        $response = $this->deleteJson('/api/logout');

        $response->assertStatus(401);
    }
}
