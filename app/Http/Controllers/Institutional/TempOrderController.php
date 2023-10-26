<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\TempOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class TempOrderController extends Controller
{
    public function dataChange(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        
        if($request->input('item_type') == 1){
            $housing_statusX = HousingStatus::where('is_project',1)->where('is_default',1)->first();
        }else{
            $housing_statusX = HousingStatus::where('is_housing',1)->where('is_default',1)->first();
        }
        if(!$tempOrder){
            $tempData = [
                "images" => [],
                "statuses" => [$housing_statusX->id]
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
                array_push($values,''.$housing_statusX->id.'');
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

    public function returnOrder($keyx,$order,$roomInfo){
        foreach($roomInfo as $key => $info){
            if($info->name == $keyx."[]" && $info->room_order == $order + 1){
                return $key;
            }
        }
    }

    public function projectHousingDataChange(Request $request){
        if($request->input('item_type') != 3){
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
        }else{
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            
            $tempData = json_decode($tempOrder->data);
            $data = $tempData;
            if($request->input('checkbox')){
                if(isset($data->roomInfoKeys)){
                    if(strpos($request->input('key'), "payment-plan")){
                        $data->roomInfoKeys[$this->returnOrder($request->input('key'),$request->input('order'),$data->roomInfoKeys)]->value = $request->input('value');
                    }else{
                        $checkboxArr = json_decode($data->roomInfoKeys[$this->returnOrder(str_replace(intval($request->input('order')) + 1, "", $request->input('key')),$request->input('order'),$data->roomInfoKeys)]->value);
                        if(in_array($request->input('value'),$checkboxArr)){
                            $index = array_search($request->input('value'), $checkboxArr);
                            unset($checkboxArr[$index]);
                            $data->roomInfoKeys[$this->returnOrder(str_replace(intval($request->input('order')) + 1, "", $request->input('key')),$request->input('order'),$data->roomInfoKeys)]->value = json_encode(array_values($checkboxArr));
                        }else{
                            array_push($checkboxArr,$request->input('value'));
                            $data->roomInfoKeys[$this->returnOrder(str_replace(intval($request->input('order')) + 1, "", $request->input('key')),$request->input('order'),$data->roomInfoKeys)]->value = json_encode($checkboxArr);
                        }
                    }
                    
                }
            }else{
                if(isset($data->roomInfoKeys)){
                    $data->roomInfoKeys[$this->returnOrder($request->input('key'),$request->input('order'),$data->roomInfoKeys)]->value = $request->input('value');
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
    }

    public function singleFile(Request $request){
        if($request->input('item_type') != 3){
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
        }else{
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            
            $tempData = json_decode($tempOrder->data);

            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = 'cover_temp_image_edit'.time().auth()->guard()->user()->id . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/project_images'), $imageName);
            }else{
                $imageName = "";
            }

            $data = $tempData;
            $data->image = 'storage/project_images/'.$imageName;

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
        if($request->input('item_type') != "3"){
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

            return $imageName;
        }else{
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            
            $tempData = json_decode($tempOrder->data);
            
            $newOrder = $tempData->images ? count($tempData->images) + 1 : 1;
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = 'temp_order_image'.time().auth()->guard()->user()->id.$newOrder . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/project_images'), $imageName);
            }else{
                $imageName = "";
            }
    
            $data = $tempData;
            array_push($data->images,["image" => 'storage/project_images/'.$imageName]);
            
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);

            return $imageName;
        }
        
    }

    public function deleteImageOrders(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);

        $data = $tempData;
        $newImages = [];
        foreach($data->images as $image){
            if($image->image != $request->input('image')){
                array_push($newImages,$image);
            }
        }

        $data->images = $newImages;
        TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
            "data" => json_encode($data),
        ]);
    }

    public function updateImageOrders(Request $request){
        
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);

        $data = $tempData;
        $data->images = [];

        foreach($request->input('images') as $image){
            array_push($data->images,["image" => $image]);
        }

        TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
            "data" => json_encode($data),
        ]);
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

    public function addProjectImage(Request $request){
        if($request->input('item_type') != 3){
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            $tempData = json_decode($tempOrder->data);

            if($request->hasFile('file')){
                $imageCount = 0;
                if(isset($tempData->roomInfoKeys) && isset($tempData->roomInfoKeys->image)){
                    $imageCount = count($tempData->roomInfoKeys->image);
                }
                $image = $request->file('file');
                $imageName = 'cover_temp_image'.auth()->guard()->user()->id. $imageCount . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/project_images'), $imageName);
            }else{
                $imageName = "";
            }

            $data = $tempData;
            if(isset($data->roomInfoKeys) ){
                if(isset($data->roomInfoKeys->image)){
                    array_push($data->roomInfoKeys->image,$imageName);
                }else{
                    $data->roomInfoKeys->image = [$imageName];
                }
            }else{
                $data->roomInfoKeys = json_decode("{}");
                $data->roomInfoKeys->image = [$imageName];
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
        }else{
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            $tempData = json_decode($tempOrder->data);

            if($request->hasFile('file')){
                $imageCount = 0;
                if(isset($tempData->roomInfoKeys) && isset($tempData->roomInfoKeys->image)){
                    $imageCount = count($tempData->roomInfoKeys->image);
                }
                $image = $request->file('file');
                $imageName = 'cover_temp_image'.time().auth()->guard()->user()->id. $imageCount . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('project_housing_images'), $imageName);
            }else{
                $imageName = "";
            }

            $data = $tempData;
            $data->roomInfoKeys[$this->returnOrder("image",$request->input('order'),$data->roomInfoKeys)]->value = $imageName;

            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);
        }
    }

    public function deleteTempUpdate(Request $request){
        TempOrder::where('user_id',auth()->user()->id)->where('item_type',3)->delete();

        return json_encode([
            "status" => true
        ]);
    }

    public function copyItemImage(Request $request){
        $tempOrder = TempOrder::where('user_id',auth()->user()->id)->where('item_type',$request->input('item_type'))->first();
        $data = json_decode($tempOrder->data);
        array_push($data->roomInfoKeys->image,$data->roomInfoKeys->image[$request->input('lastorder')]);
        TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
            "data" => json_encode($data),
        ]);
    }
}
