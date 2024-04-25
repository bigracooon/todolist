<?php

namespace App\Orchid\Screens;

use App\Services\PostService;
use Orchid\Screen\Action;
use Orchid\Screen\Field;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class PostScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
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
                $this->td('title', 'Title', 'title'),
                $this->td('description', 'Description', 'description')
            ])
        ];
    }

    private function td(string $target, string $title, string $field): TD
    {
        return TD::make($target, $title)->render(function (array $data) use ($field) {
            return $data[$field];
        });
    }
}
