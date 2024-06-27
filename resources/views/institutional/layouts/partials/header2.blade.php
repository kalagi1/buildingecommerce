<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow" />
    @if (isset($pageInfo))
        <meta name="keywords" content="{{ $pageInfo->meta_keywords }}">
        <meta name="description" content="{{ $pageInfo->meta_description }}">
        <meta name="author" content="{{ $pageInfo->meta_author }}">
        <title>{{ $pageInfo->meta_title }}</title>

        <meta property="og:site_name" content="Emlak Sepette">
        <meta property="og:url"content="https://test.emlaksepette.com/" />
        <meta property="og:type"content="website" />
        <meta property="og:title"content="{{ $pageInfo->meta_title }}" />
        <meta property="og:description"content="{{ $pageInfo->meta_description }}" />
        @php
            $imageUrl = $pageInfo->meta_image ?? 'https://test.emlaksepette.com/images/mini_logo.png';
        @endphp

        <meta property="og:image" content="{{ $imageUrl }}" />

        <meta property="og:image:width" content="300">
    @endif


    <!-- FAVICON -->
    <!-- Canonical URL için bölüm -->
    @if (isset($canonicalUrl))
        <link rel="canonical" href="{{ $canonicalUrl }}" />
    @endif
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('/') }}/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/themes/base/jquery-ui.min.css"
        integrity="sha512-8PjjnSP8Bw/WNPxF6wkklW6qlQJdWJc/3w/ZQPvZ/1bjVDkrrSqLe9mfPYrMxtnzsXFPc434+u4FHLnLjXTSsg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i%7CMontserrat:600,800" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/font/flaticon.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/fontawesome-5-all.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- ARCHIVES CSS -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/search-form.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/search.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/animate.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/aos.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/aos2.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/lightcase.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/menu.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/slick.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/styles.css?v=2">
    <link rel="stylesheet" id="color" href="{{ URL::to('/') }}/css/colors/dark-gray.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@600&display=swap" rel="stylesheet">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Canonical URL için bölüm -->
    @if (isset($canonicalUrl))
        <link rel="canonical" href="canonical-url" />
    @endif
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <meta name="msapplication-TileImage" content="{{ URL::to('/') }}/favicon.png">

    <script src="{{ URL::to('/') }}/adminassets/vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/config.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ URL::to('/') }}/adminassets/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="{{ URL::to('/') }}/adminassets/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet"
        id="style-rtl">
    <link href="{{ URL::to('/') }}/adminassets/assets/css/theme.min.css" type="text/css" rel="stylesheet"
        id="style-default">
    <link href="{{ URL::to('/') }}/adminassets/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet"
        id="user-style-rtl">
    <link href="{{ URL::to('/') }}/adminassets/assets/css/user.min.css" type="text/css" rel="stylesheet"
        id="user-style-default">
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/assets/css/leaflet-locationpicker.src.css" />
    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
    <link href="{{ URL::to('/') }}/adminassets/vendors/leaflet/leaflet.css" rel="stylesheet">
    <link href="{{ URL::to('/') }}/adminassets/vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet">
    <link href="{{ URL::to('/') }}/adminassets/vendors/leaflet.markercluster/MarkerCluster.Default.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    @yield('css')
    @yield('csss')
    <style>
        .ql-container {
          box-sizing: border-box;
          font-family: Helvetica, Arial, sans-serif;
          font-size: 13px;
          height: 100%;
          margin: 0px;
          position: relative;
        }
        .ql-container.ql-disabled .ql-tooltip {
          visibility: hidden;
        }
        .ql-container.ql-disabled .ql-editor ul[data-checked] > li::before {
          pointer-events: none;
        }
        .ql-clipboard {
          left: -100000px;
          height: 1px;
          overflow-y: hidden;
          position: absolute;
          top: 50%;
        }
        .ql-clipboard p {
          margin: 0;
          padding: 0;
        }
        .ql-editor {
          box-sizing: border-box;
          line-height: 1.42;
          height: 100%;
          outline: none;
          overflow-y: auto;
          padding: 12px 15px;
          tab-size: 4;
          -moz-tab-size: 4;
          text-align: left;
          white-space: pre-wrap;
          word-wrap: break-word;
        }
        .ql-editor > * {
          cursor: text;
        }
        .ql-editor p,
        .ql-editor ol,
        .ql-editor ul,
        .ql-editor pre,
        .ql-editor blockquote,
        .ql-editor h1,
        .ql-editor h2,
        .ql-editor h3,
        .ql-editor h4,
        .ql-editor h5,
        .ql-editor h6 {
          margin: 0;
          padding: 0;
          counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
        }
        .ql-editor ol,
        .ql-editor ul {
          padding-left: 1.5em;
        }
        .ql-editor ol > li,
        .ql-editor ul > li {
          list-style-type: none;
        }
        .ql-editor ul > li::before {
          content: '\2022';
        }
        .ql-editor ul[data-checked=true],
        .ql-editor ul[data-checked=false] {
          pointer-events: none;
        }
        .ql-editor ul[data-checked=true] > li *,
        .ql-editor ul[data-checked=false] > li * {
          pointer-events: all;
        }
        .ql-editor ul[data-checked=true] > li::before,
        .ql-editor ul[data-checked=false] > li::before {
          color: #777;
          cursor: pointer;
          pointer-events: all;
        }
        .ql-editor ul[data-checked=true] > li::before {
          content: '\2611';
        }
        .ql-editor ul[data-checked=false] > li::before {
          content: '\2610';
        }
        .ql-editor li::before {
          display: inline-block;
          white-space: nowrap;
          width: 1.2em;
        }
        .ql-editor li:not(.ql-direction-rtl)::before {
          margin-left: -1.5em;
          margin-right: 0.3em;
          text-align: right;
        }
        .ql-editor li.ql-direction-rtl::before {
          margin-left: 0.3em;
          margin-right: -1.5em;
        }
        .ql-editor ol li:not(.ql-direction-rtl),
        .ql-editor ul li:not(.ql-direction-rtl) {
          padding-left: 1.5em;
        }
        .ql-editor ol li.ql-direction-rtl,
        .ql-editor ul li.ql-direction-rtl {
          padding-right: 1.5em;
        }
        .ql-editor ol li {
          counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
          counter-increment: list-0;
        }
        .ql-editor ol li:before {
          content: counter(list-0, decimal) '. ';
        }
        .ql-editor ol li.ql-indent-1 {
          counter-increment: list-1;
        }
        .ql-editor ol li.ql-indent-1:before {
          content: counter(list-1, lower-alpha) '. ';
        }
        .ql-editor ol li.ql-indent-1 {
          counter-reset: list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
        }
        .ql-editor ol li.ql-indent-2 {
          counter-increment: list-2;
        }
        .ql-editor ol li.ql-indent-2:before {
          content: counter(list-2, lower-roman) '. ';
        }
        .ql-editor ol li.ql-indent-2 {
          counter-reset: list-3 list-4 list-5 list-6 list-7 list-8 list-9;
        }
        .ql-editor ol li.ql-indent-3 {
          counter-increment: list-3;
        }
        .ql-editor ol li.ql-indent-3:before {
          content: counter(list-3, decimal) '. ';
        }
        .ql-editor ol li.ql-indent-3 {
          counter-reset: list-4 list-5 list-6 list-7 list-8 list-9;
        }
        .ql-editor ol li.ql-indent-4 {
          counter-increment: list-4;
        }
        .ql-editor ol li.ql-indent-4:before {
          content: counter(list-4, lower-alpha) '. ';
        }
        .ql-editor ol li.ql-indent-4 {
          counter-reset: list-5 list-6 list-7 list-8 list-9;
        }
        .ql-editor ol li.ql-indent-5 {
          counter-increment: list-5;
        }
        .ql-editor ol li.ql-indent-5:before {
          content: counter(list-5, lower-roman) '. ';
        }
        .ql-editor ol li.ql-indent-5 {
          counter-reset: list-6 list-7 list-8 list-9;
        }
        .ql-editor ol li.ql-indent-6 {
          counter-increment: list-6;
        }
        .ql-editor ol li.ql-indent-6:before {
          content: counter(list-6, decimal) '. ';
        }
        .ql-editor ol li.ql-indent-6 {
          counter-reset: list-7 list-8 list-9;
        }
        .ql-editor ol li.ql-indent-7 {
          counter-increment: list-7;
        }
        .ql-editor ol li.ql-indent-7:before {
          content: counter(list-7, lower-alpha) '. ';
        }
        .ql-editor ol li.ql-indent-7 {
          counter-reset: list-8 list-9;
        }
        .ql-editor ol li.ql-indent-8 {
          counter-increment: list-8;
        }
        .ql-editor ol li.ql-indent-8:before {
          content: counter(list-8, lower-roman) '. ';
        }
        .ql-editor ol li.ql-indent-8 {
          counter-reset: list-9;
        }
        .ql-editor ol li.ql-indent-9 {
          counter-increment: list-9;
        }
        .ql-editor ol li.ql-indent-9:before {
          content: counter(list-9, decimal) '. ';
        }
        .ql-editor .ql-indent-1:not(.ql-direction-rtl) {
          padding-left: 3em;
        }
        .ql-editor li.ql-indent-1:not(.ql-direction-rtl) {
          padding-left: 4.5em;
        }
        .ql-editor .ql-indent-1.ql-direction-rtl.ql-align-right {
          padding-right: 3em;
        }
        .ql-editor li.ql-indent-1.ql-direction-rtl.ql-align-right {
          padding-right: 4.5em;
        }
        .ql-editor .ql-indent-2:not(.ql-direction-rtl) {
          padding-left: 6em;
        }
        .ql-editor li.ql-indent-2:not(.ql-direction-rtl) {
          padding-left: 7.5em;
        }
        .ql-editor .ql-indent-2.ql-direction-rtl.ql-align-right {
          padding-right: 6em;
        }
        .ql-editor li.ql-indent-2.ql-direction-rtl.ql-align-right {
          padding-right: 7.5em;
        }
        .ql-editor .ql-indent-3:not(.ql-direction-rtl) {
          padding-left: 9em;
        }
        .ql-editor li.ql-indent-3:not(.ql-direction-rtl) {
          padding-left: 10.5em;
        }
        .ql-editor .ql-indent-3.ql-direction-rtl.ql-align-right {
          padding-right: 9em;
        }
        .ql-editor li.ql-indent-3.ql-direction-rtl.ql-align-right {
          padding-right: 10.5em;
        }
        .ql-editor .ql-indent-4:not(.ql-direction-rtl) {
          padding-left: 12em;
        }
        .ql-editor li.ql-indent-4:not(.ql-direction-rtl) {
          padding-left: 13.5em;
        }
        .ql-editor .ql-indent-4.ql-direction-rtl.ql-align-right {
          padding-right: 12em;
        }
        .ql-editor li.ql-indent-4.ql-direction-rtl.ql-align-right {
          padding-right: 13.5em;
        }
        .ql-editor .ql-indent-5:not(.ql-direction-rtl) {
          padding-left: 15em;
        }
        .ql-editor li.ql-indent-5:not(.ql-direction-rtl) {
          padding-left: 16.5em;
        }
        .ql-editor .ql-indent-5.ql-direction-rtl.ql-align-right {
          padding-right: 15em;
        }
        .ql-editor li.ql-indent-5.ql-direction-rtl.ql-align-right {
          padding-right: 16.5em;
        }
        .ql-editor .ql-indent-6:not(.ql-direction-rtl) {
          padding-left: 18em;
        }
        .ql-editor li.ql-indent-6:not(.ql-direction-rtl) {
          padding-left: 19.5em;
        }
        .ql-editor .ql-indent-6.ql-direction-rtl.ql-align-right {
          padding-right: 18em;
        }
        .ql-editor li.ql-indent-6.ql-direction-rtl.ql-align-right {
          padding-right: 19.5em;
        }
        .ql-editor .ql-indent-7:not(.ql-direction-rtl) {
          padding-left: 21em;
        }
        .ql-editor li.ql-indent-7:not(.ql-direction-rtl) {
          padding-left: 22.5em;
        }
        .ql-editor .ql-indent-7.ql-direction-rtl.ql-align-right {
          padding-right: 21em;
        }
        .ql-editor li.ql-indent-7.ql-direction-rtl.ql-align-right {
          padding-right: 22.5em;
        }
        .ql-editor .ql-indent-8:not(.ql-direction-rtl) {
          padding-left: 24em;
        }
        .ql-editor li.ql-indent-8:not(.ql-direction-rtl) {
          padding-left: 25.5em;
        }
        .ql-editor .ql-indent-8.ql-direction-rtl.ql-align-right {
          padding-right: 24em;
        }
        .ql-editor li.ql-indent-8.ql-direction-rtl.ql-align-right {
          padding-right: 25.5em;
        }
        .ql-editor .ql-indent-9:not(.ql-direction-rtl) {
          padding-left: 27em;
        }
        .ql-editor li.ql-indent-9:not(.ql-direction-rtl) {
          padding-left: 28.5em;
        }
        .ql-editor .ql-indent-9.ql-direction-rtl.ql-align-right {
          padding-right: 27em;
        }
        .ql-editor li.ql-indent-9.ql-direction-rtl.ql-align-right {
          padding-right: 28.5em;
        }
        .ql-editor .ql-video {
          display: block;
          max-width: 100%;
        }
        .ql-editor .ql-video.ql-align-center {
          margin: 0 auto;
        }
        .ql-editor .ql-video.ql-align-right {
          margin: 0 0 0 auto;
        }
        .ql-editor .ql-bg-black {
          background-color: #000;
        }
        .ql-editor .ql-bg-red {
          background-color: #e60000;
        }
        .ql-editor .ql-bg-orange {
          background-color: #f90;
        }
        .ql-editor .ql-bg-yellow {
          background-color: #ff0;
        }
        .ql-editor .ql-bg-green {
          background-color: #008a00;
        }
        .ql-editor .ql-bg-blue {
          background-color: #06c;
        }
        .ql-editor .ql-bg-purple {
          background-color: #93f;
        }
        .ql-editor .ql-color-white {
          color: #fff;
        }
        .ql-editor .ql-color-red {
          color: #e60000;
        }
        .ql-editor .ql-color-orange {
          color: #f90;
        }
        .ql-editor .ql-color-yellow {
          color: #ff0;
        }
        .ql-editor .ql-color-green {
          color: #008a00;
        }
        .ql-editor .ql-color-blue {
          color: #06c;
        }
        .ql-editor .ql-color-purple {
          color: #93f;
        }
        .ql-editor .ql-font-serif {
          font-family: Georgia, Times New Roman, serif;
        }
        .ql-editor .ql-font-monospace {
          font-family: Monaco, Courier New, monospace;
        }
        .ql-editor .ql-size-small {
          font-size: 0.75em;
        }
        .ql-editor .ql-size-large {
          font-size: 1.5em;
        }
        .ql-editor .ql-size-huge {
          font-size: 2.5em;
        }
        .ql-editor .ql-direction-rtl {
          direction: rtl;
          text-align: inherit;
        }
        .ql-editor .ql-align-center {
          text-align: center;
        }
        .ql-editor .ql-align-justify {
          text-align: justify;
        }
        .ql-editor .ql-align-right {
          text-align: right;
        }
        .ql-editor.ql-blank::before {
          color: rgba(0,0,0,0.6);
          content: attr(data-placeholder);
          font-style: italic;
          left: 15px;
          pointer-events: none;
          position: absolute;
          right: 15px;
        }
        .ql-snow.ql-toolbar:after,
        .ql-snow .ql-toolbar:after {
          clear: both;
          content: '';
          display: table;
        }
        .ql-snow.ql-toolbar button,
        .ql-snow .ql-toolbar button {
          background: none;
          border: none;
          cursor: pointer;
          display: inline-block;
          float: left;
          height: 24px;
          padding: 3px 5px;
          width: 28px;
        }
        .ql-snow.ql-toolbar button svg,
        .ql-snow .ql-toolbar button svg {
          float: left;
          height: 100%;
        }
        .ql-snow.ql-toolbar button:active:hover,
        .ql-snow .ql-toolbar button:active:hover {
          outline: none;
        }
        .ql-snow.ql-toolbar input.ql-image[type=file],
        .ql-snow .ql-toolbar input.ql-image[type=file] {
          display: none;
        }
        .ql-snow.ql-toolbar button:hover,
        .ql-snow .ql-toolbar button:hover,
        .ql-snow.ql-toolbar button:focus,
        .ql-snow .ql-toolbar button:focus,
        .ql-snow.ql-toolbar button.ql-active,
        .ql-snow .ql-toolbar button.ql-active,
        .ql-snow.ql-toolbar .ql-picker-label:hover,
        .ql-snow .ql-toolbar .ql-picker-label:hover,
        .ql-snow.ql-toolbar .ql-picker-label.ql-active,
        .ql-snow .ql-toolbar .ql-picker-label.ql-active,
        .ql-snow.ql-toolbar .ql-picker-item:hover,
        .ql-snow .ql-toolbar .ql-picker-item:hover,
        .ql-snow.ql-toolbar .ql-picker-item.ql-selected,
        .ql-snow .ql-toolbar .ql-picker-item.ql-selected {
          color: #06c;
        }
        .ql-snow.ql-toolbar button:hover .ql-fill,
        .ql-snow .ql-toolbar button:hover .ql-fill,
        .ql-snow.ql-toolbar button:focus .ql-fill,
        .ql-snow .ql-toolbar button:focus .ql-fill,
        .ql-snow.ql-toolbar button.ql-active .ql-fill,
        .ql-snow .ql-toolbar button.ql-active .ql-fill,
        .ql-snow.ql-toolbar .ql-picker-label:hover .ql-fill,
        .ql-snow .ql-toolbar .ql-picker-label:hover .ql-fill,
        .ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-fill,
        .ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-fill,
        .ql-snow.ql-toolbar .ql-picker-item:hover .ql-fill,
        .ql-snow .ql-toolbar .ql-picker-item:hover .ql-fill,
        .ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-fill,
        .ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-fill,
        .ql-snow.ql-toolbar button:hover .ql-stroke.ql-fill,
        .ql-snow .ql-toolbar button:hover .ql-stroke.ql-fill,
        .ql-snow.ql-toolbar button:focus .ql-stroke.ql-fill,
        .ql-snow .ql-toolbar button:focus .ql-stroke.ql-fill,
        .ql-snow.ql-toolbar button.ql-active .ql-stroke.ql-fill,
        .ql-snow .ql-toolbar button.ql-active .ql-stroke.ql-fill,
        .ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke.ql-fill,
        .ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke.ql-fill,
        .ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke.ql-fill,
        .ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-stroke.ql-fill,
        .ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke.ql-fill,
        .ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke.ql-fill,
        .ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke.ql-fill,
        .ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-stroke.ql-fill {
          fill: #06c;
        }
        .ql-snow.ql-toolbar button:hover .ql-stroke,
        .ql-snow .ql-toolbar button:hover .ql-stroke,
        .ql-snow.ql-toolbar button:focus .ql-stroke,
        .ql-snow .ql-toolbar button:focus .ql-stroke,
        .ql-snow.ql-toolbar button.ql-active .ql-stroke,
        .ql-snow .ql-toolbar button.ql-active .ql-stroke,
        .ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke,
        .ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke,
        .ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke,
        .ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-stroke,
        .ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke,
        .ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke,
        .ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke,
        .ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-stroke,
        .ql-snow.ql-toolbar button:hover .ql-stroke-miter,
        .ql-snow .ql-toolbar button:hover .ql-stroke-miter,
        .ql-snow.ql-toolbar button:focus .ql-stroke-miter,
        .ql-snow .ql-toolbar button:focus .ql-stroke-miter,
        .ql-snow.ql-toolbar button.ql-active .ql-stroke-miter,
        .ql-snow .ql-toolbar button.ql-active .ql-stroke-miter,
        .ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke-miter,
        .ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke-miter,
        .ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke-miter,
        .ql-snow .ql-toolbar .ql-picker-label.ql-active .ql-stroke-miter,
        .ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke-miter,
        .ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke-miter,
        .ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke-miter,
        .ql-snow .ql-toolbar .ql-picker-item.ql-selected .ql-stroke-miter {
          stroke: #06c;
        }
        @media (pointer: coarse) {
          .ql-snow.ql-toolbar button:hover:not(.ql-active),
          .ql-snow .ql-toolbar button:hover:not(.ql-active) {
            color: #444;
          }
          .ql-snow.ql-toolbar button:hover:not(.ql-active) .ql-fill,
          .ql-snow .ql-toolbar button:hover:not(.ql-active) .ql-fill,
          .ql-snow.ql-toolbar button:hover:not(.ql-active) .ql-stroke.ql-fill,
          .ql-snow .ql-toolbar button:hover:not(.ql-active) .ql-stroke.ql-fill {
            fill: #444;
          }
          .ql-snow.ql-toolbar button:hover:not(.ql-active) .ql-stroke,
          .ql-snow .ql-toolbar button:hover:not(.ql-active) .ql-stroke,
          .ql-snow.ql-toolbar button:hover:not(.ql-active) .ql-stroke-miter,
          .ql-snow .ql-toolbar button:hover:not(.ql-active) .ql-stroke-miter {
            stroke: #444;
          }
        }
        .ql-snow {
          box-sizing: border-box;
        }
        .ql-snow * {
          box-sizing: border-box;
        }
        .ql-snow .ql-hidden {
          display: none;
        }
        .ql-snow .ql-out-bottom,
        .ql-snow .ql-out-top {
          visibility: hidden;
        }
        .ql-snow .ql-tooltip {
          position: absolute;
          transform: translateY(10px);
        }
        .ql-snow .ql-tooltip a {
          cursor: pointer;
          text-decoration: none;
        }
        .ql-snow .ql-tooltip.ql-flip {
          transform: translateY(-10px);
        }
        .ql-snow .ql-formats {
          display: inline-block;
          vertical-align: middle;
        }
        .ql-snow .ql-formats:after {
          clear: both;
          content: '';
          display: table;
        }
        .ql-snow .ql-stroke {
          fill: none;
          stroke: #444;
          stroke-linecap: round;
          stroke-linejoin: round;
          stroke-width: 2;
        }
        .ql-snow .ql-stroke-miter {
          fill: none;
          stroke: #444;
          stroke-miterlimit: 10;
          stroke-width: 2;
        }
        .ql-snow .ql-fill,
        .ql-snow .ql-stroke.ql-fill {
          fill: #444;
        }
        .ql-snow .ql-empty {
          fill: none;
        }
        .ql-snow .ql-even {
          fill-rule: evenodd;
        }
        .ql-snow .ql-thin,
        .ql-snow .ql-stroke.ql-thin {
          stroke-width: 1;
        }
        .ql-snow .ql-transparent {
          opacity: 0.4;
        }
        .ql-snow .ql-direction svg:last-child {
          display: none;
        }
        .ql-snow .ql-direction.ql-active svg:last-child {
          display: inline;
        }
        .ql-snow .ql-direction.ql-active svg:first-child {
          display: none;
        }
        .ql-snow .ql-editor h1 {
          font-size: 2em;
        }
        .ql-snow .ql-editor h2 {
          font-size: 1.5em;
        }
        .ql-snow .ql-editor h3 {
          font-size: 1.17em;
        }
        .ql-snow .ql-editor h4 {
          font-size: 1em;
        }
        .ql-snow .ql-editor h5 {
          font-size: 0.83em;
        }
        .ql-snow .ql-editor h6 {
          font-size: 0.67em;
        }
        .ql-snow .ql-editor a {
          text-decoration: underline;
        }
        .ql-snow .ql-editor blockquote {
          border-left: 4px solid #ccc;
          margin-bottom: 5px;
          margin-top: 5px;
          padding-left: 16px;
        }
        .ql-snow .ql-editor code,
        .ql-snow .ql-editor pre {
          background-color: #f0f0f0;
          border-radius: 3px;
        }
        .ql-snow .ql-editor pre {
          white-space: pre-wrap;
          margin-bottom: 5px;
          margin-top: 5px;
          padding: 5px 10px;
        }
        .ql-snow .ql-editor code {
          font-size: 85%;
          padding: 2px 4px;
        }
        .ql-snow .ql-editor pre.ql-syntax {
          background-color: #23241f;
          color: #f8f8f2;
          overflow: visible;
        }
        .ql-snow .ql-editor img {
          max-width: 100%;
        }
        .ql-snow .ql-picker {
          color: #444;
          display: inline-block;
          float: left;
          font-size: 14px;
          font-weight: 500;
          height: 24px;
          position: relative;
          vertical-align: middle;
        }
        .ql-snow .ql-picker-label {
          cursor: pointer;
          display: inline-block;
          height: 100%;
          padding-left: 8px;
          padding-right: 2px;
          position: relative;
          width: 100%;
        }
        .ql-snow .ql-picker-label::before {
          display: inline-block;
          line-height: 22px;
        }
        .ql-snow .ql-picker-options {
          background-color: #fff;
          display: none;
          min-width: 100%;
          padding: 4px 8px;
          position: absolute;
          white-space: nowrap;
        }
        .ql-snow .ql-picker-options .ql-picker-item {
          cursor: pointer;
          display: block;
          padding-bottom: 5px;
          padding-top: 5px;
        }
        .ql-snow .ql-picker.ql-expanded .ql-picker-label {
          color: #ccc;
          z-index: 2;
        }
        .ql-snow .ql-picker.ql-expanded .ql-picker-label .ql-fill {
          fill: #ccc;
        }
        .ql-snow .ql-picker.ql-expanded .ql-picker-label .ql-stroke {
          stroke: #ccc;
        }
        .ql-snow .ql-picker.ql-expanded .ql-picker-options {
          display: block;
          margin-top: -1px;
          top: 100%;
          z-index: 1;
        }
        .ql-snow .ql-color-picker,
        .ql-snow .ql-icon-picker {
          width: 28px;
        }
        .ql-snow .ql-color-picker .ql-picker-label,
        .ql-snow .ql-icon-picker .ql-picker-label {
          padding: 2px 4px;
        }
        .ql-snow .ql-color-picker .ql-picker-label svg,
        .ql-snow .ql-icon-picker .ql-picker-label svg {
          right: 4px;
        }
        .ql-snow .ql-icon-picker .ql-picker-options {
          padding: 4px 0px;
        }
        .ql-snow .ql-icon-picker .ql-picker-item {
          height: 24px;
          width: 24px;
          padding: 2px 4px;
        }
        .ql-snow .ql-color-picker .ql-picker-options {
          padding: 3px 5px;
          width: 152px;
        }
        .ql-snow .ql-color-picker .ql-picker-item {
          border: 1px solid transparent;
          float: left;
          height: 16px;
          margin: 2px;
          padding: 0px;
          width: 16px;
        }
        .ql-snow .ql-picker:not(.ql-color-picker):not(.ql-icon-picker) svg {
          position: absolute;
          margin-top: -9px;
          right: 0;
          top: 50%;
          width: 18px;
        }
        .ql-snow .ql-picker.ql-header .ql-picker-label[data-label]:not([data-label=''])::before,
        .ql-snow .ql-picker.ql-font .ql-picker-label[data-label]:not([data-label=''])::before,
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-label]:not([data-label=''])::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-label]:not([data-label=''])::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-label]:not([data-label=''])::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-label]:not([data-label=''])::before {
          content: attr(data-label);
        }
        .ql-snow .ql-picker.ql-header {
          width: 98px;
        }
        .ql-snow .ql-picker.ql-header .ql-picker-label::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item::before {
          content: 'Normal';
        }
        .ql-snow .ql-picker.ql-header .ql-picker-label[data-value="1"]::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="1"]::before {
          content: 'Heading 1';
        }
        .ql-snow .ql-picker.ql-header .ql-picker-label[data-value="2"]::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="2"]::before {
          content: 'Heading 2';
        }
        .ql-snow .ql-picker.ql-header .ql-picker-label[data-value="3"]::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="3"]::before {
          content: 'Heading 3';
        }
        .ql-snow .ql-picker.ql-header .ql-picker-label[data-value="4"]::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="4"]::before {
          content: 'Heading 4';
        }
        .ql-snow .ql-picker.ql-header .ql-picker-label[data-value="5"]::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="5"]::before {
          content: 'Heading 5';
        }
        .ql-snow .ql-picker.ql-header .ql-picker-label[data-value="6"]::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="6"]::before {
          content: 'Heading 6';
        }
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="1"]::before {
          font-size: 2em;
        }
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="2"]::before {
          font-size: 1.5em;
        }
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="3"]::before {
          font-size: 1.17em;
        }
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="4"]::before {
          font-size: 1em;
        }
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="5"]::before {
          font-size: 0.83em;
        }
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="6"]::before {
          font-size: 0.67em;
        }
        .ql-snow .ql-picker.ql-font {
          width: 108px;
        }
        .ql-snow .ql-picker.ql-font .ql-picker-label::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item::before {
          content: 'Sans Serif';
        }
        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value=serif]::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value=serif]::before {
          content: 'Serif';
        }
        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value=monospace]::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value=monospace]::before {
          content: 'Monospace';
        }
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value=serif]::before {
          font-family: Georgia, Times New Roman, serif;
        }
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value=monospace]::before {
          font-family: Monaco, Courier New, monospace;
        }
        .ql-snow .ql-picker.ql-size {
          width: 98px;
        }
        .ql-snow .ql-picker.ql-size .ql-picker-label::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item::before {
          content: 'Normal';
        }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value=small]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value=small]::before {
          content: 'Small';
        }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value=large]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value=large]::before {
          content: 'Large';
        }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value=huge]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value=huge]::before {
          content: 'Huge';
        }
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value=small]::before {
          font-size: 10px;
        }
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value=large]::before {
          font-size: 18px;
        }
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value=huge]::before {
          font-size: 32px;
        }
        .ql-snow .ql-color-picker.ql-background .ql-picker-item {
          background-color: #fff;
        }
        .ql-snow .ql-color-picker.ql-color .ql-picker-item {
          background-color: #000;
        }
        .ql-toolbar.ql-snow {
          border: 1px solid #ccc;
          box-sizing: border-box;
          font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
          padding: 8px;
        }
        .ql-toolbar.ql-snow .ql-formats {
          margin-right: 15px;
        }
        .ql-toolbar.ql-snow .ql-picker-label {
          border: 1px solid transparent;
        }
        .ql-toolbar.ql-snow .ql-picker-options {
          border: 1px solid transparent;
          box-shadow: rgba(0,0,0,0.2) 0 2px 8px;
        }
        .ql-toolbar.ql-snow .ql-picker.ql-expanded .ql-picker-label {
          border-color: #ccc;
        }
        .ql-toolbar.ql-snow .ql-picker.ql-expanded .ql-picker-options {
          border-color: #ccc;
        }
        .ql-toolbar.ql-snow .ql-color-picker .ql-picker-item.ql-selected,
        .ql-toolbar.ql-snow .ql-color-picker .ql-picker-item:hover {
          border-color: #000;
        }
        .ql-toolbar.ql-snow + .ql-container.ql-snow {
          border-top: 0px;
        }
        .ql-snow .ql-tooltip {
          background-color: #fff;
          border: 1px solid #ccc;
          box-shadow: 0px 0px 5px #ddd;
          color: #444;
          padding: 5px 12px;
          white-space: nowrap;
        }
        .ql-snow .ql-tooltip::before {
          content: "Visit URL:";
          line-height: 26px;
          margin-right: 8px;
        }
        .ql-snow .ql-tooltip input[type=text] {
          display: none;
          border: 1px solid #ccc;
          font-size: 13px;
          height: 26px;
          margin: 0px;
          padding: 3px 5px;
          width: 170px;
        }
        .ql-snow .ql-tooltip a.ql-preview {
          display: inline-block;
          max-width: 200px;
          overflow-x: hidden;
          text-overflow: ellipsis;
          vertical-align: top;
        }
        .ql-snow .ql-tooltip a.ql-action::after {
          border-right: 1px solid #ccc;
          content: 'Edit';
          margin-left: 16px;
          padding-right: 8px;
        }
        .ql-snow .ql-tooltip a.ql-remove::before {
          content: 'Remove';
          margin-left: 8px;
        }
        .ql-snow .ql-tooltip a {
          line-height: 26px;
        }
        .ql-snow .ql-tooltip.ql-editing a.ql-preview,
        .ql-snow .ql-tooltip.ql-editing a.ql-remove {
          display: none;
        }
        .ql-snow .ql-tooltip.ql-editing input[type=text] {
          display: inline-block;
        }
        .ql-snow .ql-tooltip.ql-editing a.ql-action::after {
          border-right: 0px;
          content: 'Save';
          padding-right: 0px;
        }
        .ql-snow .ql-tooltip[data-mode=link]::before {
          content: "Enter link:";
        }
        .ql-snow .ql-tooltip[data-mode=formula]::before {
          content: "Enter formula:";
        }
        .ql-snow .ql-tooltip[data-mode=video]::before {
          content: "Enter video:";
        }
        .ql-snow a {
          color: #06c;
        }
        .ql-container.ql-snow {
          border: 1px solid #ccc;
        }
            </style>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FVHQEVC6S0"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-FVHQEVC6S0');
    </script>
    <style>
        .notification-card.unread {
            background-color: #eff2f6;
        }

        #whatsappButton {
            height: 100% !important;
            background: green;
            margin-bottom: 10px;
        }

        .notification-card {
            cursor: pointer;
        }

        .box::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F5F5F5;
            border-radius: 5px
        }

        .box::-webkit-scrollbar {
            width: 7px;
            background-color: #F5F5F5;
            border-radius: 5px
        }

        .box::-webkit-scrollbar-thumb {
            background-color: #787373;
            border: 1px solid rgba(0, 0, 0, .03);
            border-radius: 5px
        }


        .icons {
            display: inline;
            float: right
        }

        .notification {
            padding-top: 10px;
            position: relative;
            display: inline-block;
        }

        .number {
            height: 22px;
            width: 22px;
            background-color: #d63031;
            border-radius: 20px;
            color: white;
            text-align: center;
            position: absolute;
            top: -1px;
            left: 27px;
            display: flex;
            padding: 0;
            font-size: 10px;
            border-style: solid;
            align-items: center;
            justify-content: center;
        }

        .number:empty {
            display: none;
        }

        .notBtn {
            transition: 0.5s;
            cursor: pointer
        }

        .fa-bell {
            font-size: 18px;
            padding-bottom: 10px;
            color: black;
            margin-left: 20px;
            margin-right: 20px;

        }

        .fs--1 {
            text-align: left;
            font-size: 11px !important;
            line-height: 11px;
            margin-bottom: 0 !important;
        }

        .box {
            width: 300px;
            z-index: 9999;
            height: 300px !important;
            height: 200px;
            border-radius: 10px;
            transition: 0.5s;
            position: absolute;
            overflow-y: scroll;
            overflow-x: hidden;
            padding: 0px;
            left: -74px;
            margin-top: 5px;
            background-color: #F4F4F4;
            -webkit-box-shadow: 10px 10px 23px 0px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 10px 10px 23px 0px rgba(0, 0, 0, 0.1);
            box-shadow: 10px 10px 23px 0px rgba(0, 0, 0, 0.1);
            cursor: context-menu;
        }

        .fas:hover {
            color: #d63031;
        }


        .gry {
            background-color: #F4F4F4;
        }

        .top {
            color: black;
            padding: 10px
        }


        .cont {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F4F4F4;
        }

        .cont:empty {
            display: none;
        }

        .stick {
            text-align: center;
            display: block;
            font-size: 50pt;
            padding-top: 70px;
            padding-left: 80px
        }

        .stick:hover {
            color: black;
        }

        .cent {
            text-align: center;
            display: block;
        }

        .sec {
            padding: 25px 10px;
            background-color: #F4F4F4;
            transition: 0.5s;
        }

        .profCont {
            padding-left: 15px;
        }

        .profile {
            -webkit-clip-path: circle(50% at 50% 50%);
            clip-path: circle(50% at 50% 50%);
            width: 75px;
            float: left;
        }

        .txt {
            vertical-align: top;
            font-size: 1.25rem;
            padding: 5px 10px 0px 115px;
        }

        .sub {
            font-size: 1rem;
            color: grey;
        }

        .new {
            border-style: none none solid none;
            border-color: #e54242;
        }

        .sec:hover {
            background-color: #BFBFBF;
        }

        .filter-date {
            display: flex;
            align-items: center;
            justify-content: start;
        }

        .collectionTitle {
            width: 100%;
            display: block;
            color: black;
            font-size: 13px !important;
        }

        .circleIcon {
            font-size: 5px !important;
            color: #ea2a28 !important;
            padding-right: 5px
        }

        .button-container {
            display: none;
        }

        @media (max-width: 768px) {
            .pro-wrapper {
                text-align: center
            }

            .button-container {
                z-index: 9999999;
                position: fixed;
                width: 100%;
                bottom: 0;
                display: flex;
                background-color: #F7F7F7;
                height: 60px;
                align-items: center;
                justify-content: space-around;
                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px,
                    rgba(245, 73, 144, 0.5) 5px 10px 15px;
            }

            .button-container .button {
                outline: 0 !important;
                border: 0 !important;
                padding: 0 !important;
                width: 100%;
                height: 100%;
                border-radius: 50%;
                background-color: transparent;
                display: flex;
                align-items: center;
                justify-content: center;
                color: black;
                transition: all ease-in-out 0.3s;
                cursor: pointer;
                flex-direction: column;

            }

            .button-container .button span {
                margin-top: 5px;
                font-size: 11px
            }

            .button-container .button:hover {
                transform: translateY(-3px);
            }

            .button-container .icon {
                font-size: 18px;
            }
        }
    </style>

</head>

<body class="m0a homepage-2 the-search hd-white inner-pages">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-55Q6HGHL" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- Wrapper -->
    <div id="wrapper">
        @if (request()->routeIs('index'))
            <div class="slick-lancersl">
                @foreach ($adBanners as $adBanner)
                    <div class="home-top-banner d-xl-block d-none d-lg-block"
                        style="background-color: {{ $adBanner->background_color }};padding:0 !important">
                        <img src="{{ asset("storage/{$adBanner->image}") }}" alt="Reklam Bannerı">
                    </div>
                @endforeach
            </div>
        @endif

        <!-- START SECTION HEADINGS -->
        <!-- Header Container
        ================================================== -->

        <header id="header-container">
            <div class="container">
                <div class="header-center">
                    <div class="d-flex justify-content-between align-items-center" style="padding-top:12px !important">
                        <div class="leftSide">
                            <div class="mmenu-trigger d-xl-none d-block d-lg-none ">
                                <button class="hamburger hamburger--collapse" type="button">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                            <div id="logo">
                                <a href="{{ route('index') }}"><img
                                        src="{{ URL::to('/') }}/images/emlaksepettelogo.png" alt=""></a>
                            </div>

                        </div>
                        <div class="center position-relative searchInput">
                            <form action="{{ route('search.index') }}" method="GET" id="search-form2">
                                @csrf
                                <div class="input-group search ml-3 d-xl-flex d-none d-lg-flex">
                                    <input type="text" name="searchTerm" class="ss-box" placeholder="Ara ..">
                                    <button type="submit" class="fa fa-search btn btn-primary" id="search-icon2"
                                        onclick="return validateForm2()"></button>
                                </div>
                            </form>

                            <script>
                                function validateForm2() {
                                    var searchTerm = document.getElementById("search-form2").elements["searchTerm"].value;
                                    if (searchTerm.trim() === "") {
                                        return false; // Form post edilmez
                                    }
                                    return true; // Form post edilir
                                }
                            </script>


                            <div class="header-search-box d-none flex-column position-absolute ml-3 bg-white border-bottom border-left border-right"
                                style="top: 100%; z-index: 100; width:160% ; gap: 12px;z-index:9999;max-height: 269px;
                                overflow-y: scroll;">
                            </div>
                        </div>
                        <div class="rightSide d-xl-block d-none d-lg-block ">
                            <div class="header-widget d-flex">

                                @auth
                                    @php
                                        $notifications = App\Models\DocumentNotification::with('user')
                                            ->orderBy('created_at', 'desc')
                                            ->where('readed', 0)
                                            ->where('owner_id', Auth::user()->id)
                                            ->get();
                                    @endphp


                                    @if (auth()->user()->type == 1)
                                        @include('client.layouts.partials.dropdown_user_icon', [
                                            'mainLink' => 'Hesabım',
                                            'links' => [
                                                [
                                                    'url' => route('institutional.index'),
                                                    'icon' => 'fa fa-user',
                                                    'text' => 'Hesabım',
                                                ],
                                                [
                                                    'url' => route('institutional.sharer.index'),
                                                    'icon' => 'fa fa-bookmark',
                                                    'text' =>
                                                        Auth::user()->corporate_type == 'Emlak Ofisi'
                                                            ? 'Portföylerim'
                                                            : 'Koleksiyonlarım',
                                                ],
                                                [
                                                    'url' => route('institutional.profile.cart-orders'),
                                                    'icon' => 'fa fa-shopping-cart',
                                                    'text' => 'Siparişlerim',
                                                ],
                                                [
                                                    'url' => route('favorites'),
                                                    'icon' => 'fa fa-heart',
                                                    'text' => 'Favorilerim',
                                                ],
                                                [
                                                    'url' => route('client.logout'),
                                                    'icon' => 'fa fa-sign-out',
                                                    'text' => 'Çıkış Yap',
                                                ],
                                            ],
                                        ])

                                        <a href="{{ route('cart') }}"
                                            style="    border-left: 1px solid #666;
                                        padding-left: 15px;
                                        border-right: 1px solid #666;
                                        padding-right: 15px;
                                    }">
                                            @include('client.layouts.partials.cart_icon', [
                                                'text' => 'Sepetim',
                                            ])
                                        </a>
                                    @elseif (auth()->user()->type != 1 &&
                                            auth()->user()->parent_id != 4 &&
                                            auth()->user()->type != 3 &&
                                            auth()->user()->type != 21)
                                        @include('client.layouts.partials.dropdown_user_icon', [
                                            'mainLink' => 'Hesabım',
                                            'links' => [
                                                [
                                                    'url' => route('institutional.dashboard', [
                                                        'slug' => Str::slug(auth()->user()->name),
                                                        'userID' => auth()->user()->id,
                                                    ]),
                                                    'icon' => 'fas fa-store',
                                                    'text' => 'Mağazam',
                                                ],
                                                [
                                                    'url' => route('institutional.index'),
                                                    'icon' => 'fa fa-user',
                                                    'text' => 'Panelim',
                                                ],
                                                [
                                                    'url' =>
                                                        Auth::user()->corporate_type == 'Emlak Ofisi'
                                                            ? route('institutional.housing.list')
                                                            : route('institutional.react.projects'),
                                                    'icon' => 'fa fa-home',
                                                    'text' => 'İlanlarım',
                                                ],
                                                [
                                                    'url' => route('institutional.sharer.index'),
                                                    'icon' => 'fa fa-bookmark',
                                                    'text' =>
                                                        Auth::user()->corporate_type == 'Emlak Ofisi'
                                                            ? 'Portföylerim'
                                                            : 'Koleksiyonlarım',
                                                ],
                                                [
                                                    'url' => url('hesabim/ilan-tipi-sec'),
                                                    'icon' => 'fa fa-plus',
                                                    'text' => 'İlan Ekle',
                                                ],
                                                [
                                                    'url' => route('institutional.profile.cart-orders'),
                                                    'icon' => 'fa fa-shopping-cart',
                                                    'text' => 'Siparişlerim',
                                                ],
                                                [
                                                    'url' => route('favorites'),
                                                    'icon' => 'fa fa-heart',
                                                    'text' => 'Favorilerim',
                                                ],
                                                [
                                                    'url' => route('client.logout'),
                                                    'icon' => 'fa fa-sign-out',
                                                    'text' => 'Çıkış Yap',
                                                ],
                                            ],
                                        ])
                                        <a href="{{ route('cart') }}"
                                            style="border-left: 1px solid #666;
                                         padding-left: 15px;
                                         border-right: 1px solid #666;
                                         padding-right: 15px;">
                                            @include('client.layouts.partials.cart_icon', [
                                                'text' => 'Sepetim',
                                            ])
                                        </a>
                                    @elseif (auth()->user()->type == 3 || auth()->user()->parent_id == 4)
                                        @include('client.layouts.partials.dropdown_user_icon', [
                                            'mainLink' => 'Yönetim',
                                            'links' => [
                                                [
                                                    'url' => route('admin.index'),
                                                    'icon' => 'fa fa-user',
                                                    'text' => 'Hesabım',
                                                ],
                                                [
                                                    'url' => route('client.logout'),
                                                    'icon' => 'fa fa-sign-out',
                                                    'text' => 'Çıkış Yap',
                                                ],
                                            ],
                                        ])
                                    @endif
                                @else
                                    <div class="userIconWrapper">
                                        <a href="{{ route('client.login') }}" class="userIcon">
                                            @include('client.layouts.partials.user_icon', [
                                                'text' => 'Giriş Yap',
                                            ])
                                        </a>
                                        <div class="new-login-dropdown">
                                            <div class="user-notloggedin-container container-padding">
                                                <div class="login-button"> <a href="{{ route('client.login') }}"
                                                        class="userIcon"
                                                        style="color: white;
                                                    text-align: center;
                                                    justify-content: center;
                                                    margin-right:0 !important">
                                                        Giriş Yap
                                                    </a></div>
                                                <div class="signup-button signup-button-container"><a
                                                        href="{{ url('giris-yap?uye-ol=/') }}" class="userIcon"
                                                        style="color: black;
                                                    text-align: center;
                                                    justify-content: center; margin-right:0 !important">
                                                        Üye Ol
                                                    </a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('cart') }}"
                                        style="border-left: 1px solid #666;
                                    padding-left: 15px;">
                                        @include('client.layouts.partials.cart_icon', [
                                            'text' => 'Sepetim',
                                        ])
                                    </a>
                                @endauth


                                @if (Auth::check())
                                    <div class="notification">
                                        <div class="notBtn">
                                            @php
                                                $unreadNotifications = $notifications->where('readed', 0);
                                                $unreadCount = $unreadNotifications->count();
                                            @endphp

                                            @if ($unreadCount)
                                                <div class="number">{{ $unreadCount }}</div>
                                            @endif


                                            <i class="fas fa-bell"></i>
                                            <div class="box">
                                                <div class="display">
                                                    <div class="card position-relative border-0">
                                                        <div class="card-header p-2">
                                                            <div class="d-flex justify-content-between">
                                                                <h5 class="text-black mb-0" style="font-size:12px">
                                                                    Bildirimler</h5>
                                                                <a href="{{ route('markAllAsRead') }}">
                                                                    Tümünü Oku
                                                                </a>
                                                            </div>

                                                        </div>
                                                        <div class="card-body p-0">
                                                            <div class="scrollbar-overlay" style="height: 27rem;">
                                                                <div class="border-300">
                                                                    @if (count($notifications) == 0)
                                                                        <span class="p-3 text-center">Bildirim
                                                                            Yok</span>
                                                                    @else
                                                                        @foreach ($notifications as $notification)
                                                                            <div class="px-2 px-sm-3 py-3 border-300 notification-card position-relative {{ $notification->readed == 0 ? 'unread' : 'read' }} border-bottom"
                                                                                data-id="{{ $notification->id }}"
                                                                                data-link="{{ $notification->link }}">
                                                                                <div
                                                                                    class="d-flex align-items-center justify-content-between position-relative">
                                                                                    <div class="d-flex">
                                                                                        <div class="avatar avatar-m status-online me-3"
                                                                                            style="width:45px !important">
                                                                                            <img class="rounded-circle avatar-placeholder"
                                                                                                style="max-width:40px !important"
                                                                                                src="https://prium.github.io/phoenix/v1.14.0/assets/img/team/40x40/avatar.webp"
                                                                                                alt="">
                                                                                        </div>
                                                                                        <div class="flex-1 me-sm-3">
                                                                                            <h4 class="fs-9 text-body-emphasis"
                                                                                                style="font-size: 11px;text-align:left;margin-bottom:0 !important">
                                                                                                {{ Auth::user()->name }}
                                                                                            </h4>
                                                                                            <p
                                                                                                class="fs--1 text-1000 mb-2 mb-sm-3 fw-normal">
                                                                                                {!! $notification->text !!}
                                                                                            </p>
                                                                                            @php
                                                                                                $notificationCreatedAt =
                                                                                                    $notification->created_at;
                                                                                                date_default_timezone_set(
                                                                                                    'Europe/Istanbul',
                                                                                                );
                                                                                                $notificationCreatedAtDate = date(
                                                                                                    'd.m.Y',
                                                                                                    strtotime(
                                                                                                        $notificationCreatedAt,
                                                                                                    ),
                                                                                                );
                                                                                                $notificationCreatedAtTime = date(
                                                                                                    'H:i',
                                                                                                    strtotime(
                                                                                                        $notificationCreatedAt,
                                                                                                    ),
                                                                                                );
                                                                                                $notificationCreatedAtTime12Hour = date(
                                                                                                    'h:i A',
                                                                                                    strtotime(
                                                                                                        $notificationCreatedAt,
                                                                                                    ),
                                                                                                );
                                                                                            @endphp
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $userType = Auth::user()->type;
                                    @endphp

                                    @php
                                        $link = '';
                                        $text = '';

                                        switch ($userType) {
                                            case 2:
                                                $link = url('hesabim/ilan-tipi-sec');
                                                $text = 'İlan Ekle';
                                                break;
                                            case 3:
                                                $link = url('qR9zLp2xS6y/secured/');
                                                $text = 'Yönetim';
                                                break;
                                            default:
                                                $link = url('sat-kirala-nedir/');
                                                $text = 'Sat Kirala';
                                        }
                                    @endphp
                                    <a href="{{ url('/emlak-kulup') }}">
                                        <button type="button" class=" newButtonStyle ml-2">
                                            <span class="buyUserRequest__text newButtonStyle__text"><img
                                                    src="{{ URL::to('/') }}/emlakkulüplogo.png" alt="">
                                                Emlak Kulüp</span>
                                        </button>
                                    </a>
                                    <a href="{{ $link }}">
                                        <button type="button" class="buyUserRequest ml-3">
                                            <span class="buyUserRequest__text">{{ $text }}</span>
                                            <span class="buyUserRequest__icon">
                                                <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                            </span>
                                        </button>
                                    </a>
                                @else
                                    @auth
                                        <a href="{{ url('/emlak-kulup') }}">
                                            <button type="button" class=" newButtonStyle ml-4">
                                                <span class="buyUserRequest__text newButtonStyle__text"><img
                                                        src="{{ URL::to('/') }}/emlakkulüplogo.png" alt="">
                                                    Emlak Kulüp</span>
                                            </button>
                                        </a>
                                        <a href="{{ route('real.estate.index2') }}">
                                            <button type="button" class="buyUserRequest ml-3">
                                                <span class="buyUserRequest__text"> Sat Kirala</span>
                                                <span class="buyUserRequest__icon">
                                                    <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                                </span>
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ url('/emlak-kulup') }}">
                                            <button type="button" class=" newButtonStyle ml-4">
                                                <span class="buyUserRequest__text newButtonStyle__text"><img
                                                        src="{{ URL::to('/') }}/emlakkulüplogo.png" alt="">
                                                    Emlak Kulüp</span>
                                            </button>
                                        </a>
                                        <a href="{{ url('/sat-kirala-nedir') }}">
                                            <button type="button" class="buyUserRequest ml-3">
                                                <span class="buyUserRequest__text"> Sat Kirala</span>
                                                <span class="buyUserRequest__icon">
                                                    <img src="{{ asset('sc.png') }}" alt="" srcset="">
                                                </span>
                                            </button>
                                        </a>
                                    @endauth
                                @endif



                            </div>
                        </div>

                    </div>
                </div>
                <div class="header-bottom d-xl-block d-none d-lg-block mb-0">
                    <nav id="navigation" class="style-1">
                        <ul id="responsive">
                            @php
                                $groupedMenuData = [];

                                foreach ($menuData as $menuItem) {
                                    $label = $menuItem['label'];

                                    // Gruplandırılmış menüyü oluştur
                                    if (!isset($groupedMenuData[$label])) {
                                        $groupedMenuData[$label] = [];
                                    }

                                    // Menü öğesini ilgili gruba ekle
                                    $groupedMenuData[$label][] = $menuItem;
                                }
                            @endphp

                            @foreach ($groupedMenuData as $label => $groupedMenu)
                                @php
                                    $hasVisibleMenus = false;
                                @endphp


                                @foreach ($groupedMenu as $menuItem)
                                    @if ($menuItem['visible'])
                                        @php
                                            $hasVisibleMenus = true;
                                            $applicationCount = null;
                                            $pendingHousingTypes = null;
                                            $pendingProjects = null;
                                            $orderCount = null;
                                            $neighborCount = null;
                                            $reservationsCount = null;
                                            $commentCount = null;

                                            if ($menuItem['key'] == 'EmlakClubApplications') {
                                                $applicationCount =
                                                    \App\Models\User::where('has_club', '2')->count() ?: null;
                                            } elseif ($menuItem['key'] == 'NeighborSeeApplications') {
                                                $neighborCount =
                                                    \App\Models\NeighborView::where('status', '0')->count() ?: null;
                                            } elseif ($menuItem['key'] == 'Housings') {
                                                $pendingHousingTypes =
                                                    \App\Models\Housing::with('city', 'county', 'neighborhood')
                                                        ->where('status', 2)
                                                        ->where('user_id', Auth::user()->id)
                                                        ->leftJoin(
                                                            'housing_types',
                                                            'housing_types.id',
                                                            '=',
                                                            'housings.housing_type_id',
                                                        )
                                                        ->select(
                                                            'housings.id',
                                                            'housings.title AS housing_title',
                                                            'housings.status AS status',
                                                            'housings.address',
                                                            'housings.created_at',
                                                            'housing_types.title as housing_type',
                                                            'housing_types.slug',
                                                            'housings.deleted_at',
                                                            'housings.city_id',
                                                            'housings.county_id',
                                                            'housings.neighborhood_id',
                                                            'housing_types.form_json',
                                                        )
                                                        ->orderByDesc('housings.updated_at')
                                                        ->count() ?:
                                                    null;
                                            } elseif ($menuItem['key'] == 'Projects') {
                                                $pendingProjects = \App\Models\Project::where('status', 2)
                                                    ->where('user_id', Auth::user()->id)
                                                    ->orderByDesc('updated_at')
                                                    ->get();
                                            } elseif ($menuItem['key'] == 'GetOrders') {
                                                $orderCount = \App\Models\CartOrder::with('user', 'share', 'price')
                                                    ->orderByDesc('created_at')
                                                    ->where('status', '0')
                                                    ->get();
                                            } elseif ($menuItem['key'] == 'GetReservations') {
                                                $reservationsCount = \App\Models\Reservation::with('user')
                                                    ->orderByDesc('created_at')
                                                    ->where('status', '0')
                                                    ->get();
                                            } elseif ($menuItem['key'] == 'GetHousingComments') {
                                                $commentCount = \App\Models\HousingComment::with('user')
                                                    ->orderByDesc('created_at')
                                                    ->where('status', '0')
                                                    ->get();
                                            }

                                        @endphp

                                        <li>
                                            <a
                                                href="@if (isset($menuItem['subMenu']) && count($menuItem['subMenu']) > 0) #nv-{{ $menuItem['key'] }} @else {{ route($menuItem['url']) }} @endif ">
                                                @if (!empty($menuItem['icon']))
                                                    <i class="{{ $menuItem['icon'] }}"></i>
                                                @endif
                                                @if ($menuItem['key'] == 'GetMyCollection')
                                                    @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                                        Portföylerim
                                                    @else
                                                        Koleksiyonlarım
                                                    @endif
                                                @else
                                                    {{ $menuItem['text'] }}
                                                @endif

                                                {{ $applicationCount != null ? "($applicationCount)" : null }}
                                                {{ $neighborCount != null ? "($neighborCount)" : null }}

                                                {{ $pendingHousingTypes != null ? "($pendingHousingTypes)" : null }}
                                                {{ $pendingProjects != null && $pendingProjects->count() != 0 ? '(' . $pendingProjects->count() . ')' : null }}
                                                {{ $orderCount != null ? '(' . $orderCount->count() . ')' : null }}
                                                {{ $reservationsCount != null ? '(' . $reservationsCount->count() . ')' : null }}
                                                {{ $commentCount != null ? '(' . $commentCount->count() . ')' : null }}
                                                @if (isset($menuItem['subMenu']) && count($menuItem['subMenu']) > 0)
                                                    <span class="caret"></span>
                                                @endif
                                            </a>
                                            {{-- @if (!empty($menuItem['children']))
                                        @include('client.layouts.partials.menu-item', [
                                            'items' => $menuItem['children'],
                                        ])
                                    @endif --}}
                                        </li>


                                        {{-- 
                                            @if (isset($menuItem['subMenu']) && count($menuItem['subMenu']) > 0)
                                                <div class="parent-wrapper label-1">
                                                    <ul class="nav collapse parent {{ request()->is($menuItem['activePath']) ? 'show' : '' }}"
                                                        data-bs-parent="#navbarVerticalCollapse"
                                                        id="nv-{{ $menuItem['key'] }}">
                                                        @foreach ($menuItem['subMenu'] as $subMenuItem)
                                                            @if ($subMenuItem['visible'])
                                                                <li class="nav-item">
                                                                    <a class="nav-link {{ request()->is($subMenuItem['activePath']) ? 'active' : '' }}"
                                                                        href="{{ route($subMenuItem['url']) }}"
                                                                        data-bs-toggle="" aria-expanded="false">
                                                                        <div class="d-flex align-items-center">
                                                                            <span
                                                                                class="nav-link-text">{{ $subMenuItem['text'] }}</span>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif --}}
                                    @endif
                                @endforeach
                            @endforeach
                            <li class="club-items mobile-show">
                                <a href="{{ url('/emlak-kulup') }}">
                                    <b style="font-weight:800 !important;display:flex">
                                        <img style="" class="lazy entered loading clubStyles"
                                            src="{{ url('emlakkulüplogo.png') }}" alt="Yeniler"
                                            data-ll-status="loading">
                                        EMLAK KULÜP</b>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>


        </header>
        <div class=" d-lg-none search-style">
            <form action="{{ route('search.index') }}" method="GET" id="search-form">
                @csrf
                <div class="input-group search ml-3 d-xl-flex d-lg-flex"
                    style="
                    width: 100%;
                margin: 0 auto;
                display: flex;
                justify-content: center;
                padding: 0;
                margin-left: 0 !important;">
                    <input type="text" name="searchTerm" class="ss-box" placeholder="Ara ..">
                    <button type="submit" class="fa fa-search btn btn-primary" id="search-icon"
                        onclick="return validateForm()"></button>
                </div>
            </form>


            <script>
                function validateForm() {
                    var searchTerm = document.getElementById("search-form").elements["searchTerm"].value;
                    if (searchTerm.trim() === "") {
                        return false; // Form post edilmez
                    }
                    return true; // Form post edilir
                }
            </script>

            <div class="header-search-box flex-column position-absolute ml-3 bg-white border-bottom border-left border-right"
                style="    top: 100%;
                z-index: 100;
                width: 100%;
                gap: 12px;
                max-height: 296px;
                overflow-y: scroll;
                margin-left: 0 !important;">
            </div>

        </div>
        <div class="clearfix"></div>

        <div id="preloader">
            <div id="status">
                <div class="status-mes"></div>
            </div>
        </div>
    
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                // Bildirimlere tıklama işlemi
                $('.notification-click').on('click', function(e) {
                    e.preventDefault();
                    var notificationId = $(this).data('id');
                    var notificationLink = $(this).data('link');

                    // AJAX isteği ile bildirimin "readed" değerini güncelleyin
                    $.ajax({
                        url: "{{ route('notification.read') }}", // Bildirim güncelleme rotası, bu rotayı belirlemeniz gerekiyor
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // CSRF koruması için gereken token
                            id: notificationId, // Güncellenecek bildirimin kimliği
                            link: notificationLink
                        },
                        success: function(response) {
                            window.location.href =
                                notificationLink; // Kullanıcıyı ilgili sayfaya yönlendirin


                        }
                    });
                });
            });


            document.addEventListener("DOMContentLoaded", function() {
                // Bildirim kartlarını bul
                var notificationCards = document.querySelectorAll(".notification-card");

                // Her kart için tıklama etkinleyici ekleyin
                notificationCards.forEach(function(card) {
                    card.addEventListener("click", function() {
                        var notificationId = card.getAttribute("data-id");
                        var notificationLink = $(this).data('link');

                        console.log(notificationId);

                        // AJAX ile bildirimi işaretle
                        fetch('/mark-notification-as-read/' + notificationId, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                }
                            })
                            .then(function(response) {

                                if (notificationLink) {
                                    window.location.href = notificationLink;
                                }
                                card.classList.remove("unread");
                                card.classList.add("read");

                            })
                            .catch(function(error) {
                                console.error('Bir hata oluştu:', error);
                            });
                    });
                });
            });
        </script>

