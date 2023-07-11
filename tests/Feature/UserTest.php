<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test if can create a user by api route
     *
     * @return void
     */
    public function test_create_user_by_api_route()
    {
        $faker = Faker::create();

        $response = $this->postJson('/api/register', [
            'name' => $faker->name,
            'email' => $faker->email,
            'registration' => getRandomRegistration(),
            'password' => bcrypt($faker->password),
        ]);

        $response->assertStatus(200);
        User::find($response->json()['id'])->delete();
    }

    /**
     * Test if can update a user by api route
     *
     * @return void
     */
    public function test_update_user_by_api_route()
    {
        $faker = Faker::create();

        $user = User::factory()->create([
            'name' => $faker->name,
            'email' => $faker->email,
            'registration' => getRandomRegistration(),
            'password' => bcrypt($faker->password),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'registration' => $user->registration,
        ]);

        $new_name = $faker->name;
        $new_email = $faker->email;
        $new_registration = getRandomRegistration();

        $response = $this->actingAs($user)->putJson('/api/users/' . $user->id, [
            'name' => $new_name,
            'email' => $new_email,
            'registration' => $new_registration,
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $new_name,
            'email' => $new_email,
            'registration' => $new_registration,
        ]);

        $response->assertStatus(200);
        
        $user->tokens()->delete();
        $user->delete();
    }

    /**
     * Test if can update a user without permission by api route
     *
     * @return void
     */
    public function test_update_user_without_permission_by_api_route()
    {
        $faker = Faker::create();

        $update_user = User::factory()->create([
            'name' => $faker->name,
            'email' => $faker->email,
            'registration' => getRandomRegistration(),
            'password' => bcrypt($faker->password),
        ]);

        $user = User::factory()->create([
            'name' => $faker->name,
            'email' => $faker->email,
            'admin' => false,
            'registration' => getRandomRegistration(),
            'password' => bcrypt($faker->password),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $update_user->name,
            'email' => $update_user->email,
            'registration' => $update_user->registration,
        ]);

        $new_name = $faker->name;
        $new_email = $faker->email;
        $new_registration = getRandomRegistration();

        $response = $this->actingAs($user)->putJson('/api/users/' . $update_user->id, [
            'name' => $new_name,
            'email' => $new_email,
            'registration' => $new_registration,
        ]);

        $response->assertStatus(401);
        $this->assertDatabaseHas('users', [
            'name' => $update_user->name,
            'email' => $update_user->email,
            'registration' => $update_user->registration,
        ]);

        $update_user->tokens()->delete();
        $update_user->delete();
        $user->tokens()->delete();
        $user->delete();
    }

    /**
     * Test if can delete a user by api route
     *
     * @return void
     */
    public function test_delete_user_by_api_route()
    {
        $faker = Faker::create();

        $user = User::factory()->create([
            'name' => $faker->name,
            'email' => $faker->email,
            'registration' => getRandomRegistration(),
            'password' => bcrypt($faker->password),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'registration' => $user->registration,
        ]);

        $response = $this->actingAs($user)->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);

        $user->tokens()->delete();
        $user->delete();
    }

    /**
     * Test if can delete a user without permission by api route
     *
     * @return void
     */
    public function test_delete_user_without_permission_by_api_route()
    {
        $faker = Faker::create();

        $delete_user = User::factory()->create([
            'name' => $faker->name,
            'email' => $faker->email,
            'registration' => getRandomRegistration(),
            'password' => bcrypt($faker->password),
        ]);

        $user = User::factory()->create([
            'name' => $faker->name,
            'email' => $faker->email,
            'admin' => false,
            'registration' => getRandomRegistration(),
            'password' => bcrypt($faker->password),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'registration' => $user->registration,
        ]);

        $response = $this->actingAs($user)->deleteJson('/api/users/' . $delete_user->id);

        $response->assertStatus(401);
        $this->assertDatabaseHas('users', [
            'id' => $delete_user->id,
        ]);

        $delete_user->tokens()->delete();
        $delete_user->delete();
        $user->tokens()->delete();
        $user->delete();
    }

    /**
     * Test if can create a user
     *
     * @return void
     */
    public function test_create_user()
    {
        $faker = Faker::create();

        $user = User::create([
            'name' => $faker->name,
            'email' => $faker->email,
            'registration' => getRandomRegistration(),
            'password' => bcrypt($faker->password),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'registration' => $user->registration,
        ]);

        $user->tokens()->delete();
        $user->delete();
    }

    /**
     * Test if can update a user
     *
     * @return void
     */
    public function test_update_user()
    {
        $faker = Faker::create();

        $user = User::factory()->create([
            'name' => $faker->name,
            'email' => $faker->email,
            'registration' => getRandomRegistration(),
            'password' => bcrypt($faker->password),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'registration' => $user->registration,
        ]);

        $user->name = $faker->name;
        $user->email = $faker->email;
        $user->registration = getRandomRegistration();
        $user->save();

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'registration' => $user->registration,
        ]);

        $user->tokens()->delete();
        $user->delete();
    }

    /**
     * Test if can delete a user
     *
     * @return void
     */
    public function test_delete_user()
    {
        $faker = Faker::create();

        $user = User::factory()->create([
            'name' => $faker->name,
            'email' => $faker->email,
            'registration' => getRandomRegistration(),
            'password' => bcrypt($faker->password),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'registration' => $user->registration,
        ]);

        $user->tokens()->delete();
        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
