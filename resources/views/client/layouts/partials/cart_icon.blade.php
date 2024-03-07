@php
    // $cartItemCount = request()->session()->get('cart');
    // dd(($cartItemCount['item']));
@endphp

<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
    <circle cx="9" cy="21" r="1"></circle>
    <circle cx="20" cy="21" r="1"></circle>
    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
</svg>

    @if(isset($cartItemCount['item']))
        <div class="number2">1</div> 
    @endif

    <span class="d-xl-block d-none d-lg-block rightNavText ml-1">{{ $text }}  </span>


<style>
        .number2 {
            height: 22px;
            width: 22px;
            background-color: #d63031;
            border-radius: 20px;
            color: white;
            text-align: center;
            position: absolute;
            top: -2px;
            left: 127px;
            display: flex;
            padding: 0;
            font-size: 10px;
            border-style: solid;
            align-items: center;
            justify-content: center;
            font: bold;
        }
</style>
