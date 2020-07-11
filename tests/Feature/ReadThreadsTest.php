<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseMigrations;
    public function setUp(): void
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }
    /** @test */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads/')->assertSee($this->thread->title);
    }
    /** @test */
    public function a_user_can_read_single_thread()
    {
        $response = $this->get('/threads/' . $this->thread->id)->assertSee(
            $this->thread->title
        );
    }
    /** @test */
    function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        // Given we have a thread
        // And that thread includes replies
        $reply = factory('App\Reply')->create([
            'thread_id' => $this->thread->id,
        ]);
        // When we visit a thread page
        $this->get('/threads/' . $this->thread->id)->assertSee($reply->body);
        // Then we should see the replies
    }
}