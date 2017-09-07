<?php

namespace Tests\Feature;

use App\User;
use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logged_in_user_can_create_article()
    {
        $headers = $this->createLoggedInUser();
        $payload = [
            'title' => 'Judul',
            'body' => 'Isi artikel',
        ];

        $this->json('POST', 'api/articles', $payload, $headers)
             ->assertStatus(201)
             ->assertJson([
                'id' => 1, 'title' => 'Judul', 'body' => 'Isi artikel',
             ]);

        $this->assertDatabaseHas('articles', [
            'id' => 1, 'title' => 'Judul', 'body' => 'Isi artikel',
        ]);
    }

    /** @test */
    public function logged_in_user_can_update_article()
    {
        $headers = $this->createLoggedInUser();
        $article = factory(Article::class)->create([
            'title' => 'Judul Artikel',
            'body' => 'Isi artikel pertama',
        ]);

        $payload = [
            'title' => 'Lorem',
            'body' => 'Ipsum',
        ];

        $this->json('PUT', "api/articles/$article->id", $payload, $headers)
             ->assertStatus(200)
             ->assertJson([
                'id' => 1, 'title' => 'Lorem', 'body' => 'Ipsum' 
             ]);

        $this->assertDatabaseMissing('articles', [
            'title'=>'Judul Artikel', 'body' => 'Isi artikel pertama',
        ]);
        $this->assertDatabaseHas('articles', [
            'id' => 1, 'title'=>'Lorem', 'body' => 'Ipsum',
        ]);
    }

    /** @test */
    public function logged_in_user_can_delete_article()
    {
        $headers = $this->createLoggedInUser();
        $article = factory(Article::class)->create([
            'title' => 'Judul',
            'body' => 'Isi artikel',
        ]);

        $this->assertDatabaseHas('articles', $article->toArray());

        $this->json('DELETE', "api/articles/$article->id", [], $headers)
             ->assertStatus(204);

        $this->assertDatabaseMissing('articles', $article->toArray());
    }

    /**
     * Membuat user yang memiliki api token
     * 
     * @param  array  $userData data user yang dibuat
     * @return array headers authorization
     */
    protected function createLoggedInUser($userData = [])
    {
        $user = factory(User::class)->create($userData);
        $token = $user->generateToken();
        return ['Authorization' => "Bearer $token"];
    }
}
