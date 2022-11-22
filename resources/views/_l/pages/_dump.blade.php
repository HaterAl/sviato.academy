@extends('_l.templates.base')

@php
    $pages = \Spatie\YamlFrontMatter\YamlFrontMatter::parseFile(resource_path('_data/_qa/pages.md'))->matter();
@endphp

@section('main')
    <main class="sheet">
        <h1>Pages</h1>

        @if (!empty($pages))
            <ol>
                @foreach ($pages as $id => $data)
                    <li>
                        <a
                            href="{{
                                empty($data['slug']) ?
                                route('_l.'.$id) :
                                route('_l.'.$data['slug'])
                            }}"
                            target="_blank"
                        >{{ $data['name'] }}</a>
                    </li>
                @endforeach
            </ol>
        @else
            <p>No pages yet ):</p>
        @endif
    </main>
@endsection

{{-- @section('beforeFooter') @parent @endsection --}}
{{-- @section('afterFooter') @parent @endsection --}}
