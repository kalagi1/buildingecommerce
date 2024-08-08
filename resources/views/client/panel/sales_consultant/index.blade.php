@extends('client.layouts.masterPanel')
@section('content')
    <div class="content">
        <div class="table-breadcrumb mb-5">
            <ul>
                <li>
                    Hesabım
                </li>
                <li>
                    CRM
                </li>
                <li>
                    Satış Temsilcilerim
                </li>
            </ul>
        </div>
        <div class="text-header-title">
            <p class="sales-consultants-heading">Satış Temsilcilerim ve İlgilendikleri Projeler</p>
        </div>
       
            <div class="project-table-content" style="border-radius: 4px;padding:5px">
                <ul class="list-unstyled d-flex housing-item">
                    <li style="width: 5%;font-weight: 800;">No.</li>
                    <li style="width: 10%;font-weight: 800;">Ad Soyad</li>
                    <li style="width: 25%;font-weight: 800;">E-posta</li>
                    <li style="width: 15%;font-weight: 800;">Unvan</li>
                    <li style="width: 15%;font-weight: 800;">İlgilendiği Projeler</li>
                    <li style="width: 15%;font-weight: 800;">Bugün çalışıyor mu ?</li>
                </ul>
            </div>
            <div class="project-table mb-5">
                @foreach ($sales_consultant as $index => $item)
                    <div class="project-table-content" style="border-radius: 4px;padding:10px 0px">
                        <ul class="list-unstyled d-flex housing-item">                        
                            <li style="width: 5%">{{ $index + 1 }}</li>
                            <li style="width: 10%">{{ $item->name }}</li>                   
                            <li style="width: 25%">{{ $item->email }}</li>                   
                            <li style="width: 15%">{{ $item->role->name }}</li>  
                            <li style="width: 15%">
                                <button type="button" class="btn btnProjectAssign" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $index }}">
                                    İlgilendiği Projeler
                                </button>
                            </li>                   
                                <div class="modal fade" id="exampleModal{{ $index }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header" >
                                                <h5 class="modal-title fs-2" id="exampleModalLabel{{ $index }}">{{$item->name}} adlı temsilcinize eklenebilecek projeler
                                                </h5>                                              
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background-color: transparent;" aria-label="Close"></button>                                             
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('institutional.assign.project.user') }}" method="POST">
                                                    @csrf
                                                    <div class="col-md-12 mb-3">
                                                    
                                                      <div id="projects{{ $index }}" style="max-height: 600px; overflow-y: auto;">
                                                        <div class="project-info mb-3">
                                                            <ul class="list-unstyled d-flex flex-wrap"  style="border-bottom:1px solid;">
                                                                <li style="width: 5%;font-weight: 800;">No.</li>
                                                                <li style="width: 20%;font-size:12px;font-weight:800 !important"><strong>Görsel</strong></li>
                                                                <li style="width: 20%;font-size:12px;font-weight:800 !important"><strong>Proje Adı</strong></li>
                                                                <li style="width: 5%;font-size:12px;font-weight:800 !important"><Strong>İlan Sayısı</Strong></li>
                                                                <li style="width: 15%;font-size:12px;font-weight:800 !important"><strong>Satılık / Kiralık</strong></li>
                                                                <li style="width: 10%;font-size:12px;font-weight:800 !important"><strong>Ekle / Çıkar</strong></li>
                                                            </ul>
                                                            <hr>
                                                        </div>
                                                        @foreach ($projects as $key => $project)
                                                        <input type="hidden" name="user_id" value="{{ $item->id }}">
                                            
                                                            <div class="project-info mb-3">
                                                                <ul class="list-unstyled d-flex flex-wrap">
                                                                    <li style="width: 5%;">{{ $key + 1 }}</li>
                                                                    <li style="width: 20%;">
                                                                        <img src="{{ url($project->image) }}" alt="">
                                                                    </li>
                                                                    <li style="width: 20%;">{{ $project->project_title }}</li>
                                                                    <li style="width: 5%;">{{ $project->room_count }}</li>
                                                                    <li style="width: 20%;">
                                                                        @if($project->step2_slug == 'satilik')
                                                                            Satılık
                                                                        @else
                                                                            Kiralık 
                                                                        @endif       
                                                                    </li>
                                                                    <li style="width: 10%;">
                                                                        <label class="switch " style="margin-bottom: 0px;">
                                                                            <input class="form-check-input mr-3 success" type="checkbox" name="projectIds[]" value="{{ $project->id }}"
                                                                                id="project{{ $index }}_{{ $project->id }}"
                                                                            {{ in_array($project->id, $item->projectAssigments->pluck('id')->toArray()) ? 'checked' : '' }}>
                
                                                                                <span class="slider round"></span>
                                                                        </label>
                                                                    </li>
                                                                </ul>
                                                                <hr>
                                                            </div>
                                                        @endforeach                                                         
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-between mt-2 mb-2">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                                        <button class="btn btn-primary" type="submit">Kaydet</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <li style="width: 15%; display: flex; align-items: center;flex-direction:row !important;">
                                    <label class="switch" style="margin-bottom: 0px;">
                                        <input type="checkbox" class="success today-working-checkbox" data-user-id="{{ $item->id }}" 
                                        {{ $item->today_working ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                    <i class="fas fa-info-circle info-icon" style="font-size: 16px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Satış temsilcim bugün çalışmıyorsa bugün gelecek veriler başka bir satış temsilcisine atanacak."></i>
                                </li>
                                              

                        </ul>                       
                    </div>
                @endforeach            
        </div>
 
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            $('[data-bs-toggle="tooltip"]').tooltip();

         // Formun başlangıç durumunu sakla
         function initializeForm(index) {
                let form = $(`#exampleModal${index} form`);
                form.data('initial', form.serialize());
            }

            // Formda değişiklik olup olmadığını kontrol et
            function hasChanges(index) {
                let form = $(`#exampleModal${index} form`);
                return form.serialize() !== form.data('initial');
            }

            // Modal formu hazırlama
            @foreach ($sales_consultant as $index => $item)
                initializeForm({{ $index }});
            @endforeach

            // Kaydet butonuna tıklama olayını dinle
            $('body').on('submit', 'form', function (e) {
                let form = $(this);
                let index = form.closest('.modal').attr('id').match(/\d+/)[0];
                if (!hasChanges(index)) {
                    e.preventDefault(); // Formun gönderilmesini engelle
                    Swal.fire({
                        icon: 'info',
                        title: 'Sanırım değişiklik yapmadınız...',
                        text: 'Herhangi bir değişiklik yapmadan kaydetmeye çalışıyorsunuz.',
                        confirmButtonText: 'Tamam'
                    });
                }
            });

            $('.today-working-checkbox').on('change', function() {
                var userId = $(this).data('user-id');
                var isChecked = $(this).is(':checked');
                var todayWorkingStatus = isChecked ? 1 : 0;

                $.ajax({
                    url: '{{ route('institutional.update.today.working') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        today_working: todayWorkingStatus
                    },
                    success: function(response) {
                        if (todayWorkingStatus === 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarı!',
                                text: 'Danışman çalışıyor olarak işaretlendi.',
                                confirmButtonText: 'Tamam'
                            });
                        } else {
                            Swal.fire({
                                icon: 'info',
                                title: 'Bilgi',
                                text: 'Danışman bugün çalışmıyor olarak işaretlendi.',
                                confirmButtonText: 'Tamam'
                            });
                        }
                        console.log('Today working status updated successfully');
                    },
                    error: function(xhr) {
                        console.error('Error updating today working status');
                    }
                });
            });
        });
    </script>

    
@endsection


    @section('styles')
        <style>
            .modal-header{
                background: #EC2F2E !important;
                padding: 15px 25px 15px 25px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .modal-title{
                font-size: 13px;
                color: #fff;
                margin: 0;
            }
            .info-icon {
                font-size: 16px;
                color: #2f5f9e;
                cursor: pointer;
            }

            .info-icon:hover {
                color: #0056b3;
            }

            .project-table-content ul li {
                padding: 12px 0px;
                flex: initial;
            }

            input.success:checked + .slider {
                background-color: #8bc34a;
            }
            .sales-consultants-heading {
                color: #333;
                font-weight: bold;
                position: relative;
                font-size: 15px;
            }

        
            .text-header {
                padding: 30px;
                margin-bottom: 25px;
                background-color: white;
                border-radius: 18px;
            }

            .text-header-title {
                margin-bottom: 15px;
            }

            .btnProjectAssign {
                width: 95%;
                border-color: #EC2F2E;
                background-color: #EC2F2E;
                color: white;
                border-radius: 6px !important;
            }

            .btnProjectAssign:hover {
                background-color: white !important;
                color: #EC2F2E;
                border-color: #EC2F2E;
            }
        </style>
    @endsection
