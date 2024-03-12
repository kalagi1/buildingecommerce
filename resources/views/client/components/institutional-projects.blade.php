<div class="container">
    <div style="display: flex; justify-content: space-between;" class="mb-3">
        <div class="section-title">
            <h2>Tüm Projeler</h2>
        </div>
    </div>
    <div class="row">
        @if (count($projects))
            @foreach ($projects as $project)
                <div class="col-sm-12 col-md-4 col-lg-4 col-12 projectMobileMargin" style="height:200px">
                    <div class="project-single no-mb " style="height:100%" data-aos="zoom-in" data-aos-delay="150">
                        <div class="listing-item compact" style="height:100%">
                            <a href="{{ route('project.detail', ['slug' => $project->slug."-". strtolower($project->city->title)."-". strtolower($project->county->ilce_title), 'id' => $project->id+1000000]) }}"
                                class="listing-img-container">
                                <div class="listing-img-content">
                                    <span class="listing-compact-title">{{ $project->project_title }}</span>

                                </div>
                                <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                    alt="" style="height:100%;object-fit:cover">
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                Proje bulunamadı.
            </div>
        @endif
    </div>
</div>
