@extends('client.layouts.master')
@section('content')

<div class="container">
    <div class="wrapper mt-5 mb-5">
        <nav id="sidebar">
            <ul class="list-unstyled components" style="font-size: 13px">
              @foreach($contract_pages as $page)
                <li>
                    <a href="#" data-target="{{ $page->title }}">{{ $page->title }}</a>
                </li>
              @endforeach
            </ul>
        </nav>
      
        <div id="content" style=" font-size: 12px;color:#060607;"></div>
    
    </div>
</div>
@endsection

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
$(document).ready(function() {
    // Sayfa yüklendiğinde ilk linkin içeriğini göster
    var firstLink = $('#sidebar ul.components li:first-child a');
    var target = firstLink.data('target');
    getContent(target);

    // Tıklanan linklere tıklanma olayı ekle
    // $('#sidebar ul.components li a').click(function(event) {
    //     event.preventDefault();
    //     $(this).append('<i class="fas fa-chevron-right"></i>');
    //     var target = $(this).data('target');
    //     getContent(target);
    // });

    // İçeriği getirme fonksiyonu
    function getContent(target) {
        $.ajax({
            url: '/get-content/' + target, // URL'yi doğrudan belirt
            type: 'GET',
            data: {target: target},
            success: function(response) {
                $('#content').html(response.content);
            },
            error: function(xhr, status, error) {
                console.error('İstek başarısız: ' + status);
            }
        });
    }
});


  </script>

  <style>
    /*
    DEMO STYLE
*/

@import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";
body {
  font-family: "Poppins", sans-serif;
  background: #fafafa;
}

p {
  font-family: "Poppins", sans-serif;
  font-size: 1.1em;
  font-weight: 300;
  line-height: 1.7em;
  color: #999;
}

a,
a:hover,
a:focus {
  color: inherit;
  text-decoration: none;
  transition: all 0.3s;
}

.navbar {
  padding: 15px 10px;
  background: #fff;
  border: none;
  border-radius: 0;
  margin-bottom: 40px;
  box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
}

.navbar-btn {
  box-shadow: none;
  outline: none !important;
  border: none;
}

.line {
  width: 100%;
  height: 1px;
  border-bottom: 1px dashed #ddd;
  margin: 40px 0;
}

/* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */

.wrapper {
  display: flex;
  width: 100%;
  align-items: stretch;
}

#sidebar {
  min-width: 250px;
  max-width: 250px;
  background: #060607;
  color: #fff;
  transition: all 0.3s;
}

#sidebar.active {
  margin-left: -250px;
}

#sidebar .sidebar-header {
  padding: 20px;
  background: #060607;
}

#sidebar ul.components {
  padding: 20px 0;
}

#sidebar ul p {
  color: #fff;
  padding: 10px;
}

#sidebar ul li a {
  padding: 10px;
  font-size: 12px;
  display: block;
  color: white;
  margin: 5px;

}

#sidebar ul li a:hover {
  color: #060607;
  background: #fff;
}

#sidebar ul li.active > a,
a[aria-expanded="true"] {
  color: #fff;
  background: #6d7fcc;
}

a[data-toggle="collapse"] {
  position: relative;
}

.dropdown-toggle::after {
  display: block;
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
}

ul ul a {
  font-size: 0.9em !important;
  padding-left: 30px !important;
  background: #6d7fcc;
}

ul.CTAs {
  padding: 20px;
}

ul.CTAs a {
  text-align: center;
  font-size: 0.9em !important;
  display: block;
  border-radius: 5px;
  margin-bottom: 5px;
}

a.download {
  background: #fff;
  color: #7386d5;
}

a.article,
a.article:hover {
  background: #6d7fcc !important;
  color: #fff !important;
}

/* ---------------------------------------------------
    CONTENT STYLE
----------------------------------------------------- */

#content {
  width: 100%;
  padding: 20px;
  min-height: 100vh;
  transition: all 0.3s;
}

/* ---------------------------------------------------
    MEDIAQUERIES
----------------------------------------------------- */

@media (max-width: 768px) {
  #sidebar {
    margin-left: -250px;
  }
  #sidebar.active {
    margin-left: 0;
  }
  #sidebarCollapse span {
    display: none;
  }
}

  </style>

 