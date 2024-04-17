<!-- resources/views/components/store-card.blade.php -->

<div class="brand-head">
    <div class="container">
        <div class="card mb-3">
            <div class="card-img-top" style="background-color: {{ $store->banner_hex_code ?? '#000000' }}">
                <div class="brands-square w-100">
                    <img src="{{ url('storage/profile_images/' . $store->profile_image) }}" alt=""
                        class="brand-logo">
                    <div style="display: flex;margin-left:5px">
                        <p class="brand-name"><a
                                href="{{ route('institutional.profile', ['slug' => Str::slug($store->name), 'userID' => $store->id]) }}"
                                style="color:White">{{ $store->name }}</a>
                        </p>
                        <div class="mobile-hidden-flex">
                            @if ($store->corporate_account_status)
                                <span class="badgeYearIcon" style="display: inline-block; position: relative;">
                                    <img src="{{ asset('badge_fa1c1ff1863d3279ba0e8a1583c94547.png') }}" alt=""
                                        style="display: block; margin: 0 auto;">
                                    <span
                                        style="position: absolute;line-height:.9;color:black;font-size:9px !important; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                        <i class="fa fa-check"></i>
                                    </span>
                                </span>
                                @if ($store->year && $store->name == 'Maliyetine Ev')
                                    <span class="badgeYearIcon" style="display: inline-block; position: relative;">
                                        <img src="{{ asset('badge_fa1c1ff1863d3279ba0e8a1583c94547.png') }}"
                                            alt="" style="display: block; margin: 0 auto;">
                                        <span
                                            style="position: absolute;line-height:.9;color:black;font-size:9px !important; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            {{ $store->year }} Yıl
                                        </span>
                                    </span>
                                @endif
                            @endif

                        </div>


                        @if (Route::is('housing.show'))
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">{{ $housing->title }}</p>
                        @endif

                        @if (Route::is('club.dashboard'))
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">Koleksiyonlar</p>
                        @endif

                        @if (Route::is('project.housings.detail'))
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">{{ $project->project_title }} {{ $housingOrder }} NO'LU
                                {{ mb_strtoupper($project->step1_slug) }}</p>
                        @endif

                        @if (Route::is('institutional.profile'))
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">Mağaza Profili</p>
                        @endif

                        @if (Route::is('institutional.projects.detail'))
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">Proje İlanları</p>
                        @endif

                        @if (Route::is('institutional.housings'))
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">Emlak İlanları</p>
                        @endif

                        @if (Route::is('institutional.teams'))
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">Ekibimiz</p>
                        @endif

                        @if (Route::is('sharer.links.showClientLinks'))
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">{{ $collection->name }} ({{ count($mergedItems) }} İlan)</p>
                        @endif

                        @if (Route::is('project.detail'))
                            <p class="brand-name"><i class="fa fa-angle-right"></i> </p>
                            <p class="brand-name">{{ $project->project_title }}</p>
                        @endif
                    </div>
                </div>
                <div class="mobile-hidden-flex">

                    <button class="storeShareBtn"
                        onclick="shareStore('{{ route('institutional.profile', ['slug' => Str::slug($store->name), 'userID' => $store->id]) }}')">
                        Mağazayı Paylaş <i class="fa fa-share-alt" style="margin-left:5px"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <nav class="navbar" style="padding: 0 !important">
                    <div class="navbar-items">
                        <a class="navbar-item {{ Route::is('institutional.dashboard*') ? 'active' : '' }}"
                            href="{{ route('institutional.dashboard', ['slug' => Str::slug($store->name), 'userID' => $store->id]) }}">Anasayfa</a>
                        <a class="navbar-item {{ Route::is('institutional.profile*') ? 'active' : '' }}"
                            href="{{ route('institutional.profile', ['slug' => Str::slug($store->name), 'userID' => $store->id]) }}">Mağaza
                            Profili</a>
                        @if ($store->corporate_type != 'Emlakçı')
                            <a class="navbar-item {{ Route::is('institutional.projects.detail*') ? 'active' : '' }}"
                                href="{{ route('institutional.projects.detail', ['slug' => Str::slug($store->name), 'userID' => $store->id]) }}">Proje
                                İlanları</a>
                        @endif

                        <a class="navbar-item {{ Route::is('institutional.housings*') ? 'active' : '' }}"
                            href="{{ route('institutional.housings', ['slug' => Str::slug($store->name), 'userID' => $store->id]) }}">Emlak
                            İlanları</a>
                        <a class="navbar-item {{ Route::is('institutional.teams*') ? 'active' : '' }}"
                            href="{{ route('institutional.teams', ['slug' => Str::slug($store->name), 'userID' => $store->id]) }}">Ekibimiz</a>
                        <a class="navbar-item {{ Route::is('club.dashboard*') ? 'active' : '' }}"
                            href="{{ route('club.dashboard', ['slug' => Str::slug($store->name), 'userID' => $store->id]) }}">Koleksiyonlar</a>
                        <a class="navbar-item {{ Route::is('institutional.comments*') ? 'active' : '' }}"
                            href="{{ route('institutional.comments', ['slug' => Str::slug($store->name), 'userID' => $store->id]) }}">Değerlendirmeler</a>
                        <a class="navbar-item {{ Route::is('institutional.swap*') ? 'active' : '' }}"
                            href="{{ route('institutional.swap', ['slug' => Str::slug($store->name), 'userID' => $store->id]) }}">Takas
                            Başvuru Formu</a>
                    </div>

                    {{-- <div class="search-form">
                        <input class="search-input" type="text" placeholder="Mağazada Ara" id="search-project"
                            aria-label="Search" name="q">
                        <div class="header-search__suggestions">
                            <div class="header-search__suggestions__section">
                                <h5>Projeler</h5>
                                <div class="header-search__suggestions__section__items">
                                    @foreach ($store->projects as $item)
                                        <a href="{{ route('project.detail', ['slug' => $item->slug, 'id' => $item->id + 1000000]) }}"
                                            class="project-item"
                                            data-title="{{ $item->project_title }}"><span>{{ $item->project_title }}</span></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button class="search-button" type="submit"><i class="fas fa-search"></i></button>
                    </div> --}}
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
    function shareStore(url) {
        // WhatsApp üzerinde paylaşım yapmak için aşağıdaki URL'yi kullanabilirsiniz
        window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(url));
    }
</script>

<style>
    .mobile-hidden-flex {
        display: flex;
    }

    @media (max-width: 768px) {
        .mobile-hidden-flex {
            display: none !important;
        }

        .collection {
            width: 100% !important;
        }
    }
</style>
