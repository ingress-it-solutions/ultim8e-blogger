<?php

namespace IngressITSolutions\Ultim8eBlogger\Tests;

use IngressITSolutions\Ultim8eBlogger\Models\Post;
use IngressITSolutions\Ultim8eBlogger\Tests\TestCase;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\Sheets\PathParsers\SlugWithDateParser;

class WebTest extends TestCase
{
    /** @test */
    public function it_can_show_index()
    {
        $response = $this->get(route('ultim8e-blogger.index'));
        $response
            ->assertStatus(200)
            ->assertSeeText(Post::all()->first()->title)
            ->assertViewHas(
                'posts',
                Post::paginate(
                    config('ultim8e-blogger.per_page'),
                    config('ultim8e-blogger.page_indicator')
                )
            );
    }

    /** @test */
    public function it_can_show_single_post()
    {
        $response = $this->get(
            route('ultim8e-blogger.show', Post::all()->first())
        );
        $response
            ->assertStatus(200)
            ->assertSeeText(Post::all()->first()->title)
            ->assertViewHas('post', Post::all()->first());
    }

    /** @test */
    public function it_has_pagination_links()
    {
        $this->app['config']->set('ultim8e-blogger.per_page', 1);
        $response = $this->get(route('ultim8e-blogger.index'));
        $response
            ->assertStatus(200)
            ->assertSeeText(Post::all()->first()->title)
            ->assertSee('?page=2');

        $response = $this->get(route('ultim8e-blogger.index', ['page' => 2]));
        $response
            ->assertStatus(200)
            ->assertSeeText(
                Post::all()
                    ->skip(1)
                    ->first()->title
            )
            ->assertSee('?page=1');
    }

    /** @test */
    public function it_shows_404()
    {
        $response = $this->get(route('ultim8e-blogger.show', 'no-post'));
        $response->assertStatus(404)->assertSeeText('Not Found');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filesystems.disks.ultim8e-blogger::posts', [
            'driver' => 'local',
            'root' => __DIR__ . '/fixtures',
        ]);
        $app['config']->set('sheets', [
            'collections' => [
                'posts' => [
                    'disk' => 'ultim8e-blogger::posts',
                    'sheet_class' => Post::class,
                    'path_parser' => SlugWithDateParser::class,
                    'content_parser' => MarkdownWithFrontMatterParser::class,
                    'extension' => 'md',
                ],
            ],
        ]);
    }
}
