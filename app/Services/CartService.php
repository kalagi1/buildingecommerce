<?php 

namespace App\Services;

use App\Models\CartItem;
use App\Models\CartOrder;
use App\Models\Click;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\NeighborView;
use App\Models\Collection;
use App\Models\Housing;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function addItemToCart($data)
    {
        $user = Auth::user();

        // Retrieve last click data
        $lastClick = Click::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(1))
            ->latest('created_at')
            ->first();

        $type = $data['type'];
        $id = $data['id'];
        $project = $data['project'];
        $neighborProjects = [];

        // Retrieve order count
        $orderCount = CartOrder::where('status', '!=', '2')
            ->whereJsonContains('cart->item->id', $project)
            ->whereJsonContains('cart->item->housing', $id)
            ->whereJsonContains('cart->type', $type)
            ->count();

        $cartItem = $this->getCartItem($type, $id, $project, $data, $lastClick);

        if (!$cartItem) {
            return response(['message' => 'fail'], 400);
        }

        // Delete existing cart items
        CartItem::where('user_id', $user->id)->delete();

        // Store new cart item in session
        session(['cart' => ['item' => $cartItem, 'type' => $type, 'hasCounter' => $cartItem['hasCounter']]]);

        // Save cart item to database
        CartItem::create([
            'cart' => json_encode(['item' => $cartItem, 'type' => $type, 'hasCounter' => $cartItem['hasCounter']]),
            'user_id' => $user->id
        ]);

        // Optionally send an SMS notification

        return response(['message' => 'success']);
    }

    private function getCartItem($type, $id, $project, $data, $lastClick)
    {
        if ($type == 'project') {
            return $this->getProjectCartItem($id, $project, $data, $lastClick);
        } else if ($type == 'housing') {
            return $this->getHousingCartItem($id, $data, $lastClick);
        }

        return null;
    }

    private function getProjectCartItem($id, $project, $data, $lastClick)
    {
        $discountAmount = Offer::where('type', 'project')
            ->where('project_id', $project)
            ->where('project_housings', 'LIKE', '%' . $id . '%')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first()
            ->discount_amount ?? 0;

        $project = Project::find($project);
        $projectHousing = ProjectHousing::where('project_id', $project->id)
            ->where('room_order', $id)
            ->get()
            ->keyBy('key');

        $hasCounter = $this->checkHasCounter($lastClick, $id);

        $price = $projectHousing['Peşin Fiyat']->value ?? $projectHousing['Fiyat']->value;

        $installmentDetails = $this->getInstallmentDetails($projectHousing, $data['id']);

        $image = $projectHousing['Kapak Resmi']->value;

        return [
            'id' => $project->id,
            'housing' => $id,
            'neighborProjects' => $this->getNeighborProjects($project->id, $data['user_id']),
            'city' => $project->city->title,
            'address' => $project->address,
            'title' => $project->project_title,
            'price' => $price,
            'isShare' => $data['isShare'],
            'numbershare' => $data['numbershare'],
            'qt' => $data['qt'],
            'amount' => $data['isShare'] ? ($price / $data['numbershare']) : $price,
            'defaultPrice' => $data['isShare'] ? ($price / $data['numbershare']) : $price,
            'image' => asset('project_housing_images/' . $image),
            'discount_amount' => $hasCounter ? $discountAmount : 0,
            'share_open' => $projectHousing['Paylaşıma Açık']->value ?? false,
            'share_percent' => 0.5,
            'discount_rate' => $projectHousing['İndirim Oranı %']->value ?? 0,
            'installmentPrice' => $data['isShare'] ? ($installmentDetails['price'] / $data['numbershare']) : $installmentDetails['price'],
            'payment-plan' => 'pesin',
            'pesinat' => $data['isShare'] ? ($installmentDetails['pesinat'] / $data['numbershare']) : $installmentDetails['pesinat'],
            'taksitSayisi' => $installmentDetails['taksitSayisi'],
            'aylik' => $installmentDetails['aylik'],
            'pay_decs' => $installmentDetails['payDecs'],
        ];
    }

    private function getHousingCartItem($id, $data, $lastClick)
    {
        $discountAmount = Offer::where('type', 'housing')
            ->where('housing_id', $id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first()
            ->discount_amount ?? 0;

        $housing = Housing::find($id);
        $housingData = json_decode($housing->housing_type_data);

        return [
            'id' => $housing->id,
            'city' => $housing->city['title'],
            'address' => $housing->address,
            'title' => $housing->title,
            'slug' => $housing->slug,
            'amount' => $housingData->price[0],
            'price' => $housingData->price[0],
            'defaultPrice' => $housingData->price[0],
            'image' => asset('housing_images/' . $housingData->images[0]),
            'discount_amount' => $this->checkHasCounter($lastClick, $id) ? $discountAmount : 0,
            'share_open' => $housingData->{'share-open'}[0] ?? null,
            'installmentPrice' => null,
            'share_percent' => 0.5,
            'discount_rate' => $housingData->{'discount_rate'}[0] ?? 0,
        ];
    }

    private function getInstallmentDetails($projectHousing, $id)
    {
        $installmentPrice = $projectHousing['Taksitli Toplam Fiyat']->value ?? $projectHousing['Taksitli Fiyat']->value ?? 0;
        $pesinat = $projectHousing['Peşinat']->value ?? 0;
        $taksitSayisi = $projectHousing['Taksit Sayısı']->value ?? 0;
        $newPrice = $installmentPrice;

        $countKey = "pay-dec-count{$id}";
        if (isset($projectHousing[$countKey])) {
            $count = $projectHousing[$countKey]->value;

            for ($k = 0; $k < $count; $k++) {
                $payDescPriceKey = "pay_desc_price{$id}{$k}";

                if (isset($projectHousing[$payDescPriceKey])) {
                    $newPrice -= $projectHousing[$payDescPriceKey]->value;
                }
            }
        }

        $number_of_share = $projectHousing['Kaç Hisse Var ?']->value ?? 0;

        $aylik = $taksitSayisi > 0 ? ($newPrice - $pesinat) / $taksitSayisi / ($number_of_share ?: 1) : 0;

        $payDecs = [];
        if (isset($projectHousing[$countKey])) {
            for ($k = 0; $k < $projectHousing[$countKey]->value; $k++) {
                $payDescPriceKey = "pay_desc_price{$id}{$k}";

                if (isset($projectHousing[$payDescPriceKey])) {
                    $payDecs[] = [
                        "pay_dec_price{$k}" => $projectHousing[$payDescPriceKey]->value,
                        "pay_dec_date{$k}" => $projectHousing["pay_desc_date{$id}{$k}"]->value,
                    ];
                }
            }
        }

        return compact('newPrice', 'pesinat', 'taksitSayisi', 'aylik', 'payDecs');
    }

    private function checkHasCounter($lastClick, $id)
    {
        if ($lastClick) {
            $collection = Collection::with('links')->where('id', $lastClick->collection_id)->first();
            if ($collection) {
                foreach ($collection->links as $link) {
                    if ($link->item_type == 2 && $link->item_id == $id && $link->user_id != Auth::user()->id) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function getNeighborProjects($projectId, $userId)
    {
        return NeighborView::with('user', 'owner', 'project')
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->where('status', 1)
            ->get();
    }
}
