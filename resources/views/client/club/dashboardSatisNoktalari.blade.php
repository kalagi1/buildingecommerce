@extends('client.layouts.master')

@section('content')
    <x-store-card :store="$store" />
    <section>
        <div class="container featured portfolio rec-pro disc bg-white">
            <div class="row">
                @foreach ($usersFromCollections as $index => $usersFromCollection)
                    <div class="col-md-6 col-xs-6 col-12">
                        <div class="news-item news-item-sm">
                            <a href="{{ route('institutional.dashboard', ['slug' => Str::slug($usersFromCollection->name), 'userID' => $usersFromCollection->id]) }}"
                                class="news-img-link">
                                <div class="news-item-img homes">
                                    <div class="homes-tag button alt featured">
                                        @if ($usersFromCollection->type == 1)
                                            Bireysel Hesap
                                        @elseif($usersFromCollection->type == 2)
                                            {{ $usersFromCollection->corporate_type }}
                                        @else
                                            Emlak Sepette Üyesi
                                        @endif
                                    </div>
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
                                            style="object-fit:contain;width:100%;height:100%">
                                    @endif
                                </div>
                            </a>
                            <div class="news-item-text">
                                <a
                                    href="{{ route('institutional.dashboard', ['slug' => Str::slug($usersFromCollection->name), 'userID' => $usersFromCollection->id]) }}">
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
                                    <a @if (isset($usersFromCollection->parent)) href="{{ route('club.dashboard', [
                                        'parentSlug' => Str::slug($usersFromCollection->parent->name),
                                        'slug' => Str::slug($usersFromCollection->name),
                                        'userID' => $usersFromCollection->id,
                                    ]) }}"
                                @else
                                href="{{ route('club.dashboard2', [
                                    'slug' => Str::slug($usersFromCollection->name),
                                    'userID' => $usersFromCollection->id,
                                ]) }}" @endif
                                        class="news-link">Koleksiyonları Gör</a>
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
    <style>
        .news-item-sm .news-img-link .news-item-img {
            position: absolute;
            max-width: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .news-item-sm .news-item-text {
            -ms-flex-preferred-size: 66.6%;
            flex-basis: 66.6%;
            padding: 25px 30px;
        }

        .news-item-sm .news-item-text {
            padding: 5px !important;
        }

        .portfolio .homes-tag.featured {
            width: auto !important;
        }

        .news-item {
            background: #fff;
            -webkit-box-shadow: 0px 0px 1px #e7e7e7 !important;
            box-shadow: 0px 0px 1px #f3f3f3 !important;
            border: 1px solid #e7e7e7;
            overflow: hidden;
        }


        .news-item-sm:last-child {
            border-radius: 0 0 8px 8px;
        }

        .news-item-sm .news-img-link {
            -ms-flex-preferred-size: 48.5%;
            flex-basis: 48.5%;
            position: relative;
        }

        .news-item-sm {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 2.5rem;
        }
    </style>
@endsection
