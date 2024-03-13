@foreach (range($start + 1, $end) as $roomNumber)
    @php
        $sold = isset($projectCartOrders[$roomNumber]) ? $projectCartOrders[$roomNumber] : null;

        $room_order = $roomNumber + 1;
        $allCounts = 0;
        $blockHousingCount = 0;
        $previousBlockHousingCount = 0;
        $key = 0;
        $blockStart = null;

        $roomKey = $roomNumber - 1;
        $roomNumbersUserSame =
            isset($projectCartOrders[$roomNumber + 1]) &&
            (Auth::check() ? $projectCartOrders[$roomNumber + 1]->user_id == Auth::user()->id : false);
        $blockName = null;
        $projectOffer = App\Models\Offer::where('type', 'project')
            ->where('project_id', $project->id)
            ->where(function ($query) use ($roomNumber) {
                $query
                    ->orWhereJsonContains('project_housings', [$roomNumber + 1])
                    ->orWhereJsonContains('project_housings', (string) ($roomNumber + 1)); // Handle as string as JSON might store values as strings
            })
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
        $projectDiscountAmount = $projectOffer ? $projectOffer->discount_amount : 0;
        $statusSlug = $status->slug;

        if (isset($blockStart) && $blockStart) {
        } else {
            $blockStart = null;
        }
    @endphp

    <x-project-item-mobile-card :towns="$towns" :cities="$cities" :blockName="null" :project="$project"
        :statusSlug="$statusSlug" :blockName="$blockName" :allCounts="$allCounts" :key="$key" :blockHousingCount="$blockHousingCount" :previousBlockHousingCount="$previousBlockHousingCount"
        :sumCartOrderQt="$sumCartOrderQt" :isUserSame="$roomNumbersUserSame" :bankAccounts="$bankAccounts" :i="$roomKey" :blockStart="$blockStart"
        :projectHousingsList="$projectHousingsList" :projectDiscountAmount="$projectDiscountAmount" :sold="$sold" :lastHousingCount="$lastHousingCount" />
@endforeach
