<?php

namespace App\Jobs;

use App\Models\HousingFavorite;
use App\Models\ProjectFavorite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FavoriteRemoveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $type;
    private $data;

    public function __construct($type,$data)
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->type == "housing"){
            HousingFavorite::where('housing_id',$this->data['housingId'])->delete();
        }else{
            ProjectFavorite::where('housing_id',$this->data['roomOrder'])->where('project_id',$this->data['projectId'])->delete();
        }
    }
}
