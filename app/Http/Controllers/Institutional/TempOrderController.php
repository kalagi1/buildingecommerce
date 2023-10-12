<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\HousingType;
use App\Models\TempOrder;
use Illuminate\Http\Request;
use Throwable;

class TempOrderController extends Controller
{
    public function dataChange(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        if(!$tempOrder){
            $tempData = [
                "images" => []
            ];

            $tempData = json_encode($tempData);
            $tempData = json_decode($tempData);
        }else{
            $tempData = json_decode($tempOrder->data);
        }

        $data = $tempData;
        if($request->input('array_data')){
            if(isset($data->{$request->input('key')})){
                $values = explode(',',$request->input('value'));
                $data->{$request->input('key')} = $values;
            }else{
                $data->{$request->input('key')} = [$request->input('value')];
            }
        }else{
            $data->{$request->input('key')} = $request->input('value');
        }

        if(!$tempOrder){
            TempOrder::create([
                "user_id" => auth()->guard()->user()->id,
                "data" => json_encode($data),
                "item_type" => $request->input('item_type')
            ]);
        }else{
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);
        }
    }

    public function projectHousingDataChange(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        if(!$tempOrder){
            $tempData = [
                "images" => []
            ];

            $tempData = json_encode($tempData);
            $tempData = json_decode($tempData);
        }else{
            $tempData = json_decode($tempOrder->data);
        }

        
        $data = $tempData;
        if($request->input('checkbox')){
            if(isset($data->roomInfoKeys)){
                isset($data->roomInfoKeys->{$request->input('key')}) ? $data->roomInfoKeys->{$request->input('key')}[count($data->roomInfoKeys->{$request->input('key')})] = $request->input('value') : $data->roomInfoKeys->{$request->input('key')} = [$request->input('value')];
            }else{
                $data->roomInfoKeys = json_decode('{}');
                isset($data->roomInfoKeys->{$request->input('key')}) ? $data->roomInfoKeys->{$request->input('key')}[count($data->roomInfoKeys->{$request->input('key')})] = $request->input('value') : $data->roomInfoKeys->{$request->input('key')} = [$request->input('value')];
            }
        }else{
            if(isset($data->roomInfoKeys)){
                isset($data->roomInfoKeys->{$request->input('key')}) ? $data->roomInfoKeys->{$request->input('key')}[$request->input('order')] = $request->input('value') : $data->roomInfoKeys->{$request->input('key')} = [$request->input('value')];
            }else{
                $data->roomInfoKeys = json_decode('{}');
                isset($data->roomInfoKeys->{$request->input('key')}) ? $data->roomInfoKeys->{$request->input('key')}[$request->input('order')] = $request->input('value') : $data->roomInfoKeys->{$request->input('key')} = [$request->input('value')];
            }
        }
        if(!$tempOrder){
            TempOrder::create([
                "user_id" => auth()->guard()->user()->id,
                "data" => json_encode($data),
                "item_type" => $request->input('item_type')
            ]);
        }else{
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);
        }
    }

    public function singleFile(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        if(!$tempOrder){
            $tempData = [
                "cover_image" => ""
            ];

            $tempData = json_encode($tempData);
            $tempData = json_decode($tempData);
        }else{
            $tempData = json_decode($tempOrder->data);
        }

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = 'cover_temp_image'.auth()->guard()->user()->id . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('project_images'), $imageName);
        }else{
            $imageName = "";
        }

        $data = $tempData;
        $data->cover_image = $imageName;

        if(!$tempOrder){
            TempOrder::create([
                "user_id" => auth()->guard()->user()->id,
                "data" => json_encode($data),
                "item_type" => $request->input('item_type')
            ]);
        }else{
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);
        }
    }

    public function documentFile(Request $request){
        try{
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            if(!$tempOrder){
                $tempData = [
                    "document" => ""
                ];

                $tempData = json_encode($tempData);
                $tempData = json_decode($tempData);
            }else{
                $tempData = json_decode($tempOrder->data);
            }

            if($request->hasFile('document')){
                $image = $request->file('document');
                $imageName = 'document_temp'.auth()->guard()->user()->id . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('housing_documents'), $imageName);
            }else{
                $imageName = "";
            }

            $data = $tempData;
            $data->document = $imageName;

            if(!$tempOrder){
                TempOrder::create([
                    "user_id" => auth()->guard()->user()->id,
                    "data" => json_encode($data),
                    "item_type" => $request->input('item_type')
                ]);
            }else{
                TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                    "data" => json_encode($data),
                ]);
            }

            return json_encode([
                "status" => true,
                "document_name" => $imageName
            ]);
        }catch(Throwable $e){
            return json_encode([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function addTempImage(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        if(!$tempOrder){
            $tempData = [
                "images" => []
            ];

            $tempData = json_encode($tempData);
            $tempData = json_decode($tempData);
        }else{
            $tempData = json_decode($tempOrder->data);
        }
        
        $newOrder = $tempData->images ? count($tempData->images) + 1 : 1;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = 'temp_order_image'.auth()->guard()->user()->id.$newOrder . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('project_images'), $imageName);
        }else{
            $imageName = "";
        }

        $data = $tempData;
        array_push($data->images,$imageName);
        if(!$tempOrder){
            TempOrder::create([
                "user_id" => auth()->guard()->user()->id,
                "data" => json_encode($data),
                "item_type" => $request->input('item_type')
            ]);
        }else{
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);
        }
        
    }

    public function changeStepOrder(Request $request){
        TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
            "step_order" => $request->input('order'),
        ]);

        return json_encode([
            "status" => true
        ]);
    }

    public function getHousingTypeId($slug){
        $housingType = HousingType::where('slug',$slug)->first();

        return $housingType->id;
    }
}
