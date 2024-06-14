<?php

namespace App\Jobs;

use App\Models\ShareLink;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CollectionRemoveJob implements ShouldQueue
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
            ShareLink::where('item_id',$this->data['housing_id'])->where("item_type",2)->delete();
        }else{
            ShareLink::where('item_id',$this->data['project_id'])->where('room_order',$this->data['room_order'])->where("item_type",1)->delete();
        }
    }
}
