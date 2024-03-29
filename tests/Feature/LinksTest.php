<?php

namespace Tests\Feature;

use Corals\Modules\Shortener\Models\Link;
use Corals\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LinksTest extends TestCase
{
    use DatabaseTransactions;

    protected $link;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $user = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'superuser');
        })->first();
        Auth::loginUsingId($user->id);
    }

    public function test_links_store()
    {
        $url = 'https://links';
        $response = $this->post(
            'shortener/links',
            [
                'url' => $url,
                'status' => 'active',
            ]
        );

        $this->link = Link::query()->where('url', $url)->first();

        $response->assertDontSee('The given data was invalid')
            ->assertRedirect('shortener/links');

        $this->assertDatabaseHas('shortener_links', [
            'url' => $this->link->url,
        ]);
    }

    public function test_links_show()
    {
        $this->test_links_store();

        if ($this->link) {
            $response = $this->get('shortener/links/' . $this->link->hashed_id);

            $response->assertViewIs('Shortener::links.show')->assertStatus(200);
        }
        $this->assertTrue(true);
    }

    public function test_links_edit()
    {
        $this->test_links_store();

        if ($this->link) {
            $response = $this->get('shortener/links/' . $this->link->hashed_id . '/edit');

            $response->assertViewIs('Shortener::links.create_edit')->assertStatus(200);
        }
        $this->assertTrue(true);
    }

    public function test_links_update()
    {
        $this->test_links_store();

        if ($this->link) {
            $response = $this->put('shortener/links/' . $this->link->hashed_id, [
                'url' => $this->link->url,
                'status' => $this->link->status,
            ]);

            $response->assertRedirect('shortener/links');
            $this->assertDatabaseHas('shortener_links', [
                'url' => $this->link->url,
            ]);
        }

        $this->assertTrue(true);
    }

    public function test_links_delete()
    {
        $this->test_links_store();

        if ($this->link) {
            $response = $this->delete('shortener/links/' . $this->link->hashed_id);

            $response->assertStatus(200)->assertSeeText('Link has been deleted successfully.');

            $this->isSoftDeletableModel(Link::class);
            $this->assertDatabaseMissing('shortener_links', [
                'url' => $this->link->url,
            ]);
        }
        $this->assertTrue(true);
    }
}
