<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Services\PostService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class PostScreen extends Screen
{
    public function __construct(
        private readonly PostService $postService
    ) {
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     * @throws GuzzleException
     */
    public function query(): iterable
    {
        $posts = array_map(function (array $data) {
            return new Repository($data);
        }, $this->postService->getPosts());

        return [
            'posts' => $posts
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
        return [
            ModalToggle::make('Add Post')
                ->modal('postModal')
                ->method('create')
                ->icon('plus'),
        ];
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
                TD::make('title'),
                TD::make('description'),
                TD::make('created_at', 'Created at'),
                TD::make('updated_at', 'Updated at'),
            ]),
            Layout::modal('postModal', Layout::rows([
                Input::make('title')->placeholder('Enter title'),
                TextArea::make('description')->placeholder('Enter description'),
            ]))
                ->title('Create new post')
                ->applyButton('Add post')
        ];
    }

    public function create(Request $request): void
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();
        $this->postService->create($data);
    }
}
