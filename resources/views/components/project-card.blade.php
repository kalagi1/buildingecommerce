@php
    $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
    $status = App\Models\HousingStatus::find($statusID);
@endphp
<div class="col-sm-12 col-md-4 col-lg-4 col-12 projectMobileMargin" data-aos="zoom-in" data-aos-delay="150"
    style="height:200px">
    <div class="project-single no-mb aos-init aos-animate" style="height:100%" data-aos="zoom-in" data-aos-delay="150">
        <div class="listing-item compact" style="height:100%">
            <a href="{{ route('project.detail', [
                'slug' =>
                    $status->slug .
                    '-' .
                    $project->step2_slug .
                    '-' .
                    $project->housingtype->slug .
                    '-' .
                    $project->slug .
                    '-' .
                    strtolower($project->city->title) .
                    '-' .
                    strtolower($project->county->ilce_title) .
                    '-' .
                    ($project->neighbourhood ? strtolower($project->neighbourhood->mahalle_title) : ''),
                'id' => $project->id + 1000000,
            ]) }}"
                class="listing-img-container">
                <span class="project_brand_profile_image">
                    <img loading="lazy"
                        src="{{ URL::to('/') . '/storage/profile_images/' . $project->user->profile_image }}"
                        alt="">
                    <span class="country">{{ $project->city->title }}/{{ $project->county->ilce_title }}</span>
                </span>
                @if (Auth::check() && Auth::user()->corporate_type == 'Emlak Ofisi')
                    <span class="project_estate_club_rate">
                        <span class="club_rate">%{{ $project->club_rate }} KOMİSYON!</span>
                    </span>
                @endif

                <div class="listing-img-content"
                    style="padding-left:10px;text-transform:uppercase;background-color: rgba({{ mt_rand(0, 255) }}, {{ mt_rand(0, 255) }}, {{ mt_rand(0, 255) }}, 0.8);">
                    <span class="badge badge-phoenix text-left">{{ $project->project_title }}</span>
                </div>
                <img loading="lazy" src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                    alt="" style="height:100%;object-fit:cover">
            </a>
        </div>
    </div>
</div>
