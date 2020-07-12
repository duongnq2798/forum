<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;


class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    function guests_may_not_create_threads()
    {
        // We should expect an authenticated error exception
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        // And a guest posts a new thread to the endpoint
        $this->post('/threads')
            ->assertRedirect('/login');
    }


    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        // Given we have a signed in user
        $this->signIn();
        // When we hit the endpoint to create a new thread
        $thread = create('App\Thread');
        $this->post('/threads', $thread->toArray());
        // Then, when we visit the thread page.
        // We should see the new thread
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}