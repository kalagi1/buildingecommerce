@extends('client.layouts.master')

@section('content')
    <x-store-card :store="$store" />
    <section>
        <div class="container">
            <div class="row">
                @foreach ($usersFromCollections as $index => $usersFromCollection)
                    <div class="col-md-12 col-xs-12">
                        <div class="news-item news-item-sm">
                            <a href="agent-details.html" class="news-img-link">
                                <div class="news-item-img homes">
                                    @if ($usersFromCollection->profile_image == 'indir.png')
                                        @php
                                            $nameInitials = collect(preg_split('/\s+/', $usersFromCollection->name))
                                                ->map(function ($word) {
                                                    return mb_strtoupper(mb_substr($word, 0, 1));
                                                })
                                                ->take(1)
                                                ->implode('');
                                        @endphp

                                        <div class="profile-initial">{{ $nameInitials }}</div>
                                    @else
                                        <img loading="lazy"
                                            src="{{ asset('storage/profile_images/' . $usersFromCollection->profile_image) }}"
                                            alt="{{ $usersFromCollection->name }}" class="esp-img"
                                            style="object-fit:contain;">
                                    @endif
                                </div>
                            </a>
                            <div class="news-item-text">
                                <a href="agent-details.html">
                                    <h3>{{ $usersFromCollection->name }}</h3>
                                </a>
                                <div class="the-agents">
                                    <ul class="the-agents-details">
                                        @if ($usersFromCollection->phone)
                                            <li><a href="tel:{{ $usersFromCollection->phone }}">İş:
                                                    {{ $usersFromCollection->phone }}</a></li>
                                        @endif
                                        @if ($usersFromCollection->mobile_phone)
                                            <li><a href="tel:{{ $usersFromCollection->mobile_phone }}">Cep:
                                                    {{ $usersFromCollection->mobile_phone }}</a></li>
                                        @endif
                                        <li><a
                                                href="mailto:{{ $usersFromCollection->email }}">{{ $usersFromCollection->email }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="news-item-bottom">
                                    <a href="{{ route('institutional.dashboard', ['slug' => Str::slug($usersFromCollection->name), 'userID' => $usersFromCollection->id]) }}"
                                        class="news-link">Görüntüle</a>
                                    @if ($usersFromCollection->parent_id)
                                        <div class="admin">
                                            <p>{{ $usersFromCollection->parent->name }}</p>
                                            <img src="{{ asset('storage/profile_images/' . $usersFromCollection->parent->profile_image) }}"
                                                alt="">
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection

@section('styles')
@endsection
