<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AcceptedBid;
use Carbon\Carbon;

class CheckBidExpiry extends Command
{
    protected $signature = 'bids:check-expiry';

    protected $description = 'Tekliflerin geçerlilik süresini kontrol eder ve durumu günceller';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $expiredBids = AcceptedBid::where('expires_at', '<', Carbon::now())->get();

        foreach ($expiredBids as $acceptedBid) {
            $bid = $acceptedBid->bid;
            $bid->status = 'expired';
            $bid->save();

            $acceptedBid->delete();
        }

        $this->info('Geçerlilik süresi dolan teklifler güncellendi.');
    }
}
