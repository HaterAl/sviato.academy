<?php

namespace App\Services;

use Illuminate\Http\Request;

class Seo
{
    /**
     * @var
     */
    protected $title;

    /**
     * @var
     */
    protected $description;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->title = __('Sviato Academy');

        $this->description = __('');

        $this->data = $this->defaults();
    }

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'title' => $this->title,
            'links' => [
                'canonical' => request()->url(),
                'alternates' => []
            ],
            'meta' => [
                'description' => $this->description,
                'keywords' => '',
                'robots' => 'max-snippet:-1, max-video-preview:-1, max-image-preview:large'
            ],
            'opengraph' => [
                'title' => $this->title,
                'description' => $this->description,
                'type' => 'website',
                'url' => request()->url(),
                'image' => [
                    'url' => asset('opengraph.jpg'),
                    'width' => 1200,
                    'height' => 630,
                ],
                'site_name' => config('app.name'),
            ],
            'twitter' => [
                'title' => $this->title,
                'description' => $this->description,
                'card' => 'summary_large_image',
                'image' => asset('opengraph.jpg'),
                'site' => config('app.name'),
            ]
        ];
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return view('main.seo.seo', ['data' => $this->data])
            ->render();
    }
}
