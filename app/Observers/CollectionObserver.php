<?php

namespace App\Observers;

use App\Models\Collection;

class CollectionObserver {
    public function updating( Collection $collection ) {
        // Check if the status is being set to 0
        if ( count( $collection->links ) == 0 ) {
            $collection->delete();
        }
    }
}
