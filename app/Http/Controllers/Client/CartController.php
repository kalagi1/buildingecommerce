<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectHousing;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProjectToCart(Request $request){
        $project = Project::with('city','county','roomInfo')->where('id',$request->input('project_id'))->first();
        $housing = ProjectHousing::where('project_id',$project->id)->get()->keyBy('name');
        if($project){
            \Cart::session(1)->add(array(
                'id' => $project->id.'.'.$request->input('order'),
                'name' => $project->project_title,
                'price' => $housing['price[]']['value'],
                'order' => $request->input('order'),
                'quantity' => 1,
                'attributes' => array(),
                'associatedModel' => $project
            ));
        }

        $items = \Cart::getContent();

        return $items;
    }

    public function index(){
        
        $items = \Cart::session(1)->getContent();
        return view('client.cart.index',compact('items'));
    }
}
