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

        $this->title = __('Sviato Academy by Sviatoslav Otchenash');

        $this->description = __(
            'Learn from the best at Sviato Academy, a world-class permanent'
            . ' make-up training institution. Join us and take your permanent make-up career to the next level.'
        );

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
     * Set the page title
     *
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->data['title'] = $title;
        $this->data['opengraph']['title'] = $title;
        $this->data['twitter']['title'] = $title;

        return $this;
    }

    /**
     * Set the page description
     *
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->data['meta']['description'] = $description;
        $this->data['opengraph']['description'] = $description;
        $this->data['twitter']['description'] = $description;

        return $this;
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
