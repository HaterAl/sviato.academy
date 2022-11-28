@extends('_l.templates.base')

@php
    $pages = Spatie\YamlFrontMatter\YamlFrontMatter::parseFile(resource_path('_data/_qa/pages.md'))->matter();
@endphp

@section('main')
    <main class="c-sheet pt-16">
        <h1 class="b-h3 mb-8">Pages</h1>

        @if (!empty($pages))
            <ol class="list-decimal pl-16 text-lg">
                @foreach ($pages as $id => $data)
                    <li class="mb-2">
                        {{-- <a
                            href="{{
                                empty($data['slug']) ?
                                route('_l.'.$id) :
                                route('_l.'.$data['slug'])
                            }}"
                        >{{ $data['name'] }}</a> --}}

                        <a
                            href="{{
                                empty($data['slug']) ?
                                '_l/'.$id :
                                route('_l.'.$data['slug'])
                            }}"
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
