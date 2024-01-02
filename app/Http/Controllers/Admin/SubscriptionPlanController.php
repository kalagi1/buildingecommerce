<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::all();
        return view('admin.subscription-plans.index', compact('subscriptionPlans'));
    }

    public function create()
    {
        return view('admin.subscription-plans.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric', // Örneğin fiyatı numeric olarak tanımlayabilirsiniz.
            'project_limit' => 'required|integer',
            'user_limit' => 'required|integer',
            'housing_limit' => 'required|integer',
            'plan_type' => 'required|string|in:Bireysel,Emlakçı,Banka,İnşaat',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.subscriptionPlans.create')
                ->withErrors($validator)
                ->withInput();
        }

        SubscriptionPlan::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'project_limit' => $request->input('project_limit'),
            'user_limit' => $request->input('user_limit'),
            'housing_limit' => $request->input('housing_limit'),
            'plan_type' => $request->input('plan_type'),
        ]);

        return redirect()->route('admin.subscriptionPlans.index')
            ->with('success', 'Abonelik planı başarıyla oluşturuldu.');
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscription-plans.edit', compact('subscriptionPlan'));
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'project_limit' => 'required|integer',
            'user_limit' => 'required|integer',
            'housing_limit' => 'required|integer',
            'plan_type' => 'required|string|in:Bireysel,Emlakçı,Banka,İnşaat',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.subscriptionPlans.edit', $subscriptionPlan->id)
                ->withErrors($validator)
                ->withInput();
        }

        $subscriptionPlan->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'project_limit' => $request->input('project_limit'),
            'user_limit' => $request->input('user_limit'),
            'housing_limit' => $request->input('housing_limit'),
            'plan_type' => $request->input('plan_type'),
        ]);

        return redirect()->route('admin.subscriptionPlans.index')
            ->with('success', 'Abonelik planı başarıyla güncellendi.');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return redirect()->route('admin.subscriptionPlans.index')
            ->with('success', 'Abonelik planı başarıyla silindi.');
    }
}
