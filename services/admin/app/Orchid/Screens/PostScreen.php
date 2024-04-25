<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Services\PostService;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class PostScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     * @throws GuzzleException
     */
    public function query(): iterable
    {
        return [
            'posts' => (new PostService())->getPosts()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Posts';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('posts', [
                $this->td('title', 'Title'),
                $this->td('description', 'Description'),
                $this->td('created_at', 'Created At', function ($createdAt) {
                    return Carbon::parse($createdAt)->format('d.m.Y');
                }),
                $this->td('updated_at', 'Updated At', function ($updatedAt) {
                    return Carbon::parse($updatedAt)->format('d.m.Y');
                })
            ])
        ];
    }

    private function td(string $name, string $title, ?callable $format = null): TD
    {
        return TD::make($name, $title)->render(function (array $data) use ($name, $format) {
            if ($format) {
                return $format($data[$name]);
            }

            return $data[$name];
        });
    }
}
