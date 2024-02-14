@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div id="sortable-container" class="row ">
            @foreach ($brands as $brand)
            <div class="col-md-2 col-6 mb-5 brand-item" data-order="{{ $brand->order }}" data-id="{{ $brand->id }}"> 
                <div class="border rounded-2 p-3 bg-white text-center bg-body-emphasis dark__bg-gray-1000 shadow-sm">
                        <a href="{{ route('institutional.dashboard', ['slug' => Str::slug($brand->name), 'userID' => $brand->id]) }}"
                            class="homes-img">
                            <div class="landscapes">
                                <div class="project-single">
                                    <div class="project-inner project-head">
                                        <div class="homes">
                                            <span class="kanban-title-badge">{{ $brand->order }}</span>
                                            @if ($brand->profile_image == 'indir.png')
                                                @php
                                                    $nameInitials = collect(preg_split('/\s+/', $brand->name))
                                                        ->map(function ($word) {
                                                            return mb_strtoupper(mb_substr($word, 0, 1));
                                                        })
                                                        ->take(1)
                                                        ->implode('');
                                                @endphp
    
                                                <div class="profile-initial">{{ $nameInitials }}</div>
                                            @else
                                                <img src="{{ asset('storage/profile_images/' . $brand->profile_image) }}"
                                                    alt="{{ $brand->name }}" class="rounded-circle profile-initial ">
                                            @endif
                                            <span class="text-center d-block w-100 mt-3"
                                                style="font-size:9px !important;border:none !important">{{ $brand->name }} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                
                </div>
            @endforeach

        </div>
    </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sortable = new Sortable(document.getElementById('sortable-container'), {
            animation: 150,
            onUpdate: function (evt) {
                const item = evt.item;
                const orders = Array.from(item.parentNode.getElementsByClassName('brand-item'))
                    .map(function (element) {
                        return {
                            id: element.dataset.id, // Add the actual identifier for your brand item
                            order: element.dataset.order,
                        };
                    });

                // Send an AJAX request using jQuery
                $.ajax({
                    type: 'POST',
                    url: '/qR9zLp2xS6y/secured/update-brand-order',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        orders: orders
                    },
                    success: function (response) {
                        location.reload();
                        console.log(response);
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            },
        });
    });
</script>
@endsection



@section('css')
<style>

    .kanban-title-badge{
        width: 20px;
        font-size: 10px;
    height: 20px;
    border-radius: 100%;
    background-color: grey;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    }
    .profile-initial {
    font-size: 20px;
    color: #e54242;
    background: white;
    border: 2px solid #e6e6e6;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 0 auto;
}
</style>
@endsection
