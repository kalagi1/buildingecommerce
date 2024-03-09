<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\DopingPricing;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\TempOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;

class TempOrderController extends Controller
{
    public function updateSituationOrders(Request $request){
        if($request->input('item_type') != 3){
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            $tempData = json_decode($tempOrder->data);
    
            $data = $tempData;
            $data->situations = [];
    
            foreach($request->input('situations') as $situation){
                array_push($data->situations,$situation);
            }
    
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);
        }else{
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            $tempData = json_decode($tempOrder->data);
    
            $data = $tempData;
            $data->situations = [];
    
            foreach($request->input('situations') as $image){
                array_push($data->situations,["situation" => $image]);
            }
    
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);
        }
    }

    public function deleteSituationOrders(Request $request){
        if($request->input('item_type') != "3"){
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            $tempData = json_decode($tempOrder->data);
            $data = $tempData;
            $newImages = [];
            foreach($data->situations as $situation){
                if($situation != $request->input('situation')){
                    array_push($newImages,$situation);
                }
            }

            $data->situations = $newImages;
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);
        }else{
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            $tempData = json_decode($tempOrder->data);
            $data = $tempData;
            $newImages = [];
            foreach($data->situations as $image){
                if($image->situation != $request->input('situation')){
                    array_push($newImages,$image);
                }
            }

            $data->situations = $newImages;
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);
        }
    }

    public function situationImageAdd(Request $request){
        
        $manager = new ImageManager(
            new Driver()
        );

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
            if(!isset($tempData->situations)){
                $tempData->situations = [];
            }
            $newOrder = $tempData->situations ? count($tempData->situations) + 1 : 1;
            $uploadedFiles = $request->file();
            $imageNames = [];
            foreach ($uploadedFiles as $fileKey => $file) {
                $imageName = 'temp_order_situation'.auth()->guard()->user()->id.(intval($newOrder) + intval(str_replace('file','',$fileKey))) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('situation_images'), $imageName);

                $data = $tempData;
                array_push($data->situations,$imageName);
                array_push($imageNames,$imageName);
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
            

            return $imageNames;
        }else{
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            
            $tempData = json_decode($tempOrder->data);
            
            if(!isset($tempData->situations)){
                $tempData->situations = [];
            }
            $newOrder = $tempData->situations ? count($tempData->situations) + 1 : 1;
            $uploadedFiles = $request->file();
            $imageNames = [];
            $tempOrder = 0;
            foreach ($uploadedFiles as $fileKey => $file) {
                $imageName = 'temp_order_situation'.time().auth()->guard()->user()->id.($newOrder + $tempOrder).time(). '.' . $file->getClientOriginalExtension();

                $file->move(public_path('situation_images'), $imageName);

                $image = $manager->read(public_path('situation_images/'.$imageName));
                $imageWidth = $image->width();
                $imageHeight = $image->height();

                if($imageWidth > 450){
                    $newWidth = 450;
                    $newHeight = $imageHeight * 450 / $imageWidth;
                }else{
                    $newWidth = $imageWidth;
                    $newHeight = $imageHeight;
                }
                $image->resize($newWidth, $newHeight);
                $encoded = $image->place(public_path('images/filigran.png'),'center',10,10,10);
                $encoded->save(public_path('situation_images/'.$imageName));

                $data = $tempData;
                array_push($data->situations,["situation" => $imageName]);
                array_push($imageNames,$imageName);
                $tempOrder++;
            }
            
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);

            return $imageNames;
        }
    }

    public function removePayDecItem(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();

        $tempData = json_decode($tempOrder->data);

        for($i = 0 ; $i < $tempData->{"pay-dec-count".$request->active_housing} ; $i++){
            if($i == $tempData->{"pay-dec-count".$request->active_housing} - 1 ){
                unset($tempData->{"pay_desc_date".$request->active_housing.$i});
                unset($tempData->{"pay_desc_price".$request->active_housing.$i});
            }else{
                if($i >= $request->input('item_index')){
                    if(isset($tempData->{"pay_desc_price".$request->active_housing.($i+1)}) && $tempData->{"pay_desc_price".$request->active_housing.($i+1)}){
                        $tempData->{"pay_desc_price".$request->active_housing.$i} =  $tempData->{"pay_desc_price".$request->active_housing.($i+1)};
                    }

                    if(isset($tempData->{"pay_desc_date".$request->active_housing.($i+1)}) && $tempData->{"pay_desc_date".$request->active_housing.($i+1)}){
                        $tempData->{"pay_desc_date".$request->active_housing.$i} =  $tempData->{"pay_desc_date".$request->active_housing.($i+1)};
                    }
                }
            }
        }

        $tempData->{"pay-dec-count".$request->active_housing} = $tempData->{"pay-dec-count".$request->active_housing} - 1;

        TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
            "data" => json_encode($tempData),
        ]);
        
        return json_encode([
            "status" => true
        ]);
    }

    public function locationControl(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();

        $tempData = json_decode($tempOrder->data);

        if(isset($tempData->location)){
            if(!$tempData->location){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

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

    public function getDopingPrice(Request $request){
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

        $datas = [];

        if(isset($tempData->featured) && $tempData->featured){
            $dopingPrice = DopingPricing::where('day',$tempData->featured_data_day)->where('item_type',1)->first();
            array_push($datas,$dopingPrice);
        }

        if(isset($tempData->top_row) && $tempData->top_row){
            $dopingPrice = DopingPricing::where('day',$tempData->top_row_data_day)->where('item_type',1)->first();
            array_push($datas,$dopingPrice);
        }

        return $datas;
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
                    if(isset($data->roomInfoKeys->{$request->input('key')})){
                        if(in_array($request->input('value'),$data->roomInfoKeys->{$request->input('key')})){
                            $newArray = array_filter($data->roomInfoKeys->{$request->input('key')}, function ($eleman) use($request) { return $eleman != $request->input('value'); });
                            $newArray = array_values($newArray);
                            $data->roomInfoKeys->{$request->input('key')} = $newArray;
                        }else{
                            if($request->input('only-one')){
                                $data->roomInfoKeys->{$request->input('key')} = [$request->input('value')];
                            }else{
                                $data->roomInfoKeys->{$request->input('key')}[count($data->roomInfoKeys->{$request->input('key')})] = $request->input('value');
                            }
                        }
                    }else{
                        $data->roomInfoKeys->{$request->input('key')} = [$request->input('value')];
                    }
                }else{
                    $data->roomInfoKeys = json_decode('{}');
                    isset($data->roomInfoKeys->{$request->input('key')}) ? (in_array($request->input('value'),$data->roomInfoKeys->{$request->input('key')}) ? array_filter($data->roomInfoKeys->{$request->input('key')}, function ($eleman,$request) { return $eleman != $request->input('value'); }) : $data->roomInfoKeys->{$request->input('key')}[count($data->roomInfoKeys->{$request->input('key')})] = $request->input('value')) : $data->roomInfoKeys->{$request->input('key')} = [$request->input('value')];
                }
                echo json_encode($data->roomInfoKeys->{$request->input('key')});
            }else{
                if(isset($data->roomInfoKeys)){
                    if($request->input('key') == "installments" || $request->input('key') == "advance" || $request->input('key') == "installments-price"){
                        if($request->input('value') != -999 && $request->input('value') != "null" && $request->input('value')){
                            isset($data->roomInfoKeys->{$request->input('key')}) ? array_push($data->roomInfoKeys->{$request->input('key')},$request->input('value')) : $data->roomInfoKeys->{$request->input('key')} = [$request->input('value')];
                        }
                    }else{
                        if(isset($data->roomInfoKeys->{$request->input('key')})){
                            $data->roomInfoKeys->{$request->input('key')}[$request->input('order')] = $request->input('value');
                            $newArray = array_values($data->roomInfoKeys->{$request->input('key')});
                            $data->roomInfoKeys->{$request->input('key')} = $newArray;
                        }else{
                            $data->roomInfoKeys->{$request->input('key')} = [$request->input('value')];
                        }
                    }
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
            }else{
                if(isset($data->roomInfoKeys)){
                    if($this->returnOrder($request->input('key'),$request->input('order'),$data->roomInfoKeys)){
                        $data->roomInfoKeys[$this->returnOrder($request->input('key'),$request->input('order'),$data->roomInfoKeys)]->value = $request->input('value');
                    }else{
                        array_push($data->roomInfoKeys,[
                            "key" => "Yeni Veri",
                            "name" => $request->input('key').'[]',
                            "value" => $request->input('value'),
                            "room_order" => $request->input('order') + 1,
                            "new_value" => 1
                        ]);
                    }
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
        
        $manager = new ImageManager(
            new Driver()
        );

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
                $imageName = 'cover_temp_image_edit'.time().auth()->guard()->user()->id.time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/project_images'), $imageName);

                $image = $manager->read(public_path('storage/project_images/'.$imageName));
                $imageWidth = $image->width();
                $imageHeight = $image->height();

                if($imageWidth > 450){
                    $newWidth = 450;
                    $newHeight = $imageHeight * 450 / $imageWidth;
                }else{
                    $newWidth = $imageWidth;
                    $newHeight = $imageHeight;
                }
                $image->resize($newWidth, $newHeight);
                $encoded = $image->place(public_path('images/filigran.png'),'center',10,10,10);
                $encoded->save(public_path('storage/project_images  /'.$imageName));
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
        $manager = new ImageManager(
            new Driver()
        );
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
            $uploadedFiles = $request->file();
            $imageNames = [];
            foreach ($uploadedFiles as $fileKey => $file) {
                $imageName = 'temp_order_image'.auth()->guard()->user()->id.(intval($newOrder) + intval(str_replace('file','',$fileKey))) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('project_images'), $imageName);
                
                $data = $tempData;
                array_push($data->images,$imageName);
                array_push($imageNames,$imageName);
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
            

            return $imageNames;
        }else{
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            
            $tempData = json_decode($tempOrder->data);
            
            $newOrder = $tempData->images ? count($tempData->images) + 1 : 1;
            $newOrder = $tempData->images ? count($tempData->images) + 1 : 1;
            $uploadedFiles = $request->file();
            $imageNames = [];
            $tempOrder = 0;
            foreach ($uploadedFiles as $fileKey => $file) {
                $imageName = 'temp_order_image'.time().auth()->guard()->user()->id.($newOrder + $tempOrder). '.' . $file->getClientOriginalExtension();

                $file->move(public_path('storage/project_images'), $imageName);

                $image = $manager->read(public_path('storage/project_images/'.$imageName));
                $imageWidth = $image->width();
                $imageHeight = $image->height();

                if($imageWidth > 450){
                    $newWidth = 450;
                    $newHeight = $imageHeight * 450 / $imageWidth;
                }else{
                    $newWidth = $imageWidth;
                    $newHeight = $imageHeight;
                }
                $image->resize($newWidth, $newHeight);
                $encoded = $image->place(public_path('images/filigran.png'),'center',10,10,10);
                $encoded->save(public_path('storage/project_images/'.$imageName));
                $data = $tempData;
                array_push($data->images,["image" => 'storage/project_images/'.$imageName]);
                array_push($imageNames,$imageName);
                $tempOrder++;
            }
            
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);

            return $imageNames;
        }
        
    }

    public function deleteImageOrders(Request $request){
        if($request->input('item_type') != "3"){
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            $tempData = json_decode($tempOrder->data);
            $data = $tempData;
            $newImages = [];
            foreach($data->images as $image){
                if($image != $request->input('image')){
                    array_push($newImages,$image);
                }
            }

            $data->images = $newImages;
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);
        }else{
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
    }

    public function updateImageOrders(Request $request){
        if($request->input('item_type') != 3){
            $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
            $tempData = json_decode($tempOrder->data);
    
            $data = $tempData;
            $data->images = [];
    
            foreach($request->input('images') as $image){
                array_push($data->images,$image);
            }
    
            TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
                "data" => json_encode($data),
            ]);
        }else{
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
        
    }

    public function changeStepOrder(Request $request){
        TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
            "step_order" => $request->input('order'),
        ]);

        return json_encode([
            "status" => true
        ]);
    }

    public function copyCheckbox(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);
        $data = $tempData;
        $items = json_decode($request->input('value'));
        foreach($items as $key => $item){
            $data->roomInfoKeys->{$key} = $item;
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
        return $data;
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
                $imageName = 'cover_temp_image'.auth()->guard()->user()->id. (intval($request->input('order'))) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/project_images'), $imageName);
            }else{
                $imageName = "";
            }

            $data = $tempData;
            if(isset($data->roomInfoKeys) ){
                if(isset($data->roomInfoKeys->image)){
                    $data->roomInfoKeys->image[$request->input('order')] = $imageName;
                    $tempData->roomInfoKeys->image = array_values($tempData->roomInfoKeys->image);
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

    public function deleteTempCreate(Request $request){
        TempOrder::where('user_id',auth()->user()->id)->where('item_type',$request->input('item_type'))->delete();

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

    public function choiseAdvertiseType(){
        return view('institutional.advertise.choise');
    }

    public function getDataByKey($order,$tempData,$key){
        if(isset($tempData->roomInfoKeys)){
            foreach($tempData->roomInfoKeys as $keyt => $roomInfo){
                if($keyt.'[]' == $key){
                    if(!is_object($roomInfo) && isset($roomInfo[$order])){
                        return $roomInfo[$order];
                    }else{
                        return null;
                    }
                }
            }
        }else{
            return null;
        }
    }

    public function getDataByKeyCheckbox($order,$tempData,$key){
        if(isset($tempData->roomInfoKeys)){
            foreach($tempData->roomInfoKeys as $keyt => $roomInfo){
                if($keyt.'[]' == $key){
                    if(!is_object($roomInfo) && isset($roomInfo)){
                        return $roomInfo;
                    }else{
                        return null;
                    }
                }
            }
        }else{
            return null;
        }
    }

    public function getHouseData(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);
        $housingTypeForm = HousingType::where('id',$tempData->housing_type_id)->first();
        $housingTypeFormData = json_decode($housingTypeForm->form_json);
        $data = [];
        foreach($housingTypeFormData as $formData){
            if($formData->type == "checkbox-group"){
                array_push($data,[str_replace('[]','',$formData->name) => $this->getDataByKeyCheckbox($request->input('order'),$tempData,(str_replace('[]','',$formData->name).($request->input('order') + 1).'[]')) , "type" => $formData->type]);
            }else{
                array_push($data,[str_replace('[]','',$formData->name) => $this->getDataByKey($request->input('order'),$tempData,$formData->name) , "type" => $formData->type]);
            }
        }
        $data2 = [];
        if(isset($tempData->{"pay-dec-count".($request->input('order') + 1)})){
            $data2["pay-dec-count".($request->input('order') + 1)] = $tempData->{"pay-dec-count".($request->input('order') + 1)};
        }
        if(isset($tempData->{"pay-dec-count".(intval($request->input('order')) + 1)})){
            for($i = 0 ; $i < $tempData->{"pay-dec-count".intval($request->input('order') + 1)}; $i++){
                if(isset($tempData->{"pay_desc_price".($request->input('order') + 1).$i})){
                    $data2["pay_desc_price".($request->input('order') + 1).$i] = $tempData->{"pay_desc_price".($request->input('order') + 1).$i};
                }

                if(isset($tempData->{"pay_desc_date".($request->input('order') + 1).$i})){
                    $data2["pay_desc_date".($request->input('order') + 1).$i] = $tempData->{"pay_desc_date".($request->input('order') + 1).$i};
                }
            }
        }
        return [
            "data" => $data,
            "data2" => $data2 
        ];
    }

    public function getHouseDataFunc($lastOrder,$itemType){
        $tempOrder = TempOrder::where('item_type',$itemType)->where('user_id',auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);
        $housingTypeForm = HousingType::where('id',$tempData->housing_type_id)->first();
        $housingTypeFormData = json_decode($housingTypeForm->form_json);
        $data = [];
        foreach($housingTypeFormData as $formData){
            if($formData->type == "checkbox-group"){
                array_push($data,[str_replace('[]','',$formData->name) => $this->getDataByKeyCheckbox($lastOrder,$tempData,(str_replace('[]','',$formData->name).($lastOrder + 1).'[]')) , "type" => $formData->type]);
            }else{
                array_push($data,[str_replace('[]','',$formData->name) => $this->getDataByKey($lastOrder,$tempData,$formData->name) , "type" => $formData->type]);
            }
        }

        return $data;
    }

    public function copyData(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);
        $dataCopyItem = $this->getHouseDataFunc($request->input('last_order'),$request->input('item_type'));
        foreach($dataCopyItem as $key => $data){
            foreach($data as $keyx => $datax){
                if($data['type'] != "checkbox-group"){
                    if($keyx != "type"){
                        if( $data[$keyx] != null){
                            if(isset($tempData->roomInfoKeys)){
                                $tempData->roomInfoKeys->{$keyx}[($request->input('new_order'))] = $data[$keyx];
                                $tempData->roomInfoKeys->{$keyx} = array_values($tempData->roomInfoKeys->{$keyx});
                            }
                        }else{
                            if(isset($tempData->roomInfoKeys)){
                                $tempData->roomInfoKeys->{$keyx}[($request->input('new_order'))] = null;
                                $tempData->roomInfoKeys->{$keyx} = array_values($tempData->roomInfoKeys->{$keyx});
                            }
                        }
                    }
                }else{
                    if($keyx != "type"){
                        if($data[$keyx] && $data[$keyx] != null){
                            if(isset($tempData->roomInfoKeys)){
                                $tempData->roomInfoKeys->{$keyx.($request->input('new_order') + 1)} = $data[$keyx];
                            }
                        }else{
                            if(isset($tempData->roomInfoKeys)){
                                $tempData->roomInfoKeys->{$keyx.($request->input('new_order') + 1)} = [];
                            }
                        }
                    }
                }
            }
        }

        if(isset($tempData->{"pay-dec-count".($request->input('last_order')+1)}) && $tempData->{"pay-dec-count".($request->input('last_order')+1)}){
            $tempData->{"pay-dec-count".($request->input('new_order')+1)} = $tempData->{"pay-dec-count".($request->input('last_order')+1)};
                
            for($i = 0; $i < $tempData->{"pay-dec-count".($request->input('last_order')+1)} ; $i++){
                if(isset($tempData->{"pay_desc_price".($request->input('last_order') + 1).$i}) && $tempData->{"pay_desc_price".($request->input('last_order') + 1).$i}){
                    $tempData->{"pay_desc_price".($request->input('new_order') + 1).$i} = $tempData->{"pay_desc_price".($request->input('last_order') + 1).$i};
                }

                if(isset($tempData->{"pay_desc_date".($request->input('last_order') + 1).$i}) && $tempData->{"pay_desc_date".($request->input('last_order') + 1).$i}){
                    $tempData->{"pay_desc_date".($request->input('new_order') + 1).$i} = $tempData->{"pay_desc_date".($request->input('last_order') + 1).$i};
                }
            }
        }

        $tempOrder->update([
            "data" => json_encode($tempData)
        ]);

        $dataCopyItem = $this->getHouseDataFunc($request->input('new_order'),$request->input('item_type'));

        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);
        $data2 = [];
        if(isset($tempData->{"pay-dec-count".($request->input('new_order') + 1)})){
            $data2["pay-dec-count".($request->input('new_order') + 1)] = $tempData->{"pay-dec-count".($request->input('new_order') + 1)};
        }
        if(isset($tempData->{"pay-dec-count".(intval($request->input('new_order')) + 1)})){
            for($i = 0 ; $i < $tempData->{"pay-dec-count".intval($request->input('new_order') + 1)}; $i++){
                if(isset($tempData->{"pay_desc_price".($request->input('new_order') + 1).$i})){
                    $data2["pay_desc_price".($request->input('new_order') + 1).$i] = $tempData->{"pay_desc_price".($request->input('new_order') + 1).$i};
                }

                if(isset($tempData->{"pay_desc_date".($request->input('new_order') + 1).$i})){
                    $data2["pay_desc_date".($request->input('new_order') + 1).$i] = $tempData->{"pay_desc_date".($request->input('new_order') + 1).$i};
                }
            }
        }
        return [
            "data" => $dataCopyItem,
            "data2" => $data2
        ];
    }

    public function housingConfirmFull(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        
        $data = json_decode($tempOrder->data);
        $housingType = HousingType::where('id',$data->housing_type_id)->first();
        $formJson = json_decode($housingType->form_json);
        $errors = [];
        if(!isset($data->has_blocks) || !$data->has_blocks){
            if(isset($data->house_count) && $data->house_count ){
                for($i = 0; $i < $data->house_count; $i++){
                    foreach($formJson as $json){
                        if(in_array(3,$data->statuses)){
                            if(isset($json->className)){
                                if(!str_contains($json->className, 'continue-disabled')){
                                    if($json->required && !str_contains($json->className, 'project-disabled')){
                                        if(isset($data->roomInfoKeys->{str_replace('[]','',$json->name)}) && isset($data->roomInfoKeys->{str_replace('[]','',$json->name)}[$i]) && $data->roomInfoKeys->{str_replace('[]','',$json->name)}[$i] != "Seçiniz"){
                
                                        }else{
                                            array_push($errors,"Lütfen sonraki aşamaya geçmeden önce".($i+1).'. '.$housingType->title.' '.$json->label.' değerini doldurmanız gerekiyor');
                                        };
                                    }
                                }
                            }
                        }else{
                            if($json->required && !str_contains($json->className, 'project-disabled')){
                                if(isset($data->roomInfoKeys->{str_replace('[]','',$json->name)}) && isset($data->roomInfoKeys->{str_replace('[]','',$json->name)}[$i]) && $data->roomInfoKeys->{str_replace('[]','',$json->name)}[$i] != "Seçiniz"){
        
                                }else{
                                    array_push($errors,"Lütfen sonraki aşamaya geçmeden önce".($i+1).'. '.$housingType->title.' '.$json->label.' değerini doldurmanız gerekiyor');
                                };
                            }
                        }
                        
                    }
                }
            }else{
                return json_encode([
                    "status" => false,
                    "message" => "Sonraki aşamaya geçmeden önce lütfen ".$housingType->title.' sayısını belirtiniz ve içeriklerini doldurunuz'
                ]);
            }
        }else{
            for($j = 0 ; $j < count($data->blocks); $j++){
                if(isset($data->{"house_count".$j}) && $data->{"house_count".$j} ){
                    for($i = 0; $i < $data->{"house_count".$j}; $i++){
                        
                        foreach($formJson as $json){
                            if($json->required && !str_contains($json->className, 'project-disabled')){
                                if(isset($data->roomInfoKeys->{str_replace('[]','',$json->name)}) && isset($data->roomInfoKeys->{str_replace('[]','',$json->name)}[$i]) && $data->roomInfoKeys->{str_replace('[]','',$json->name)}[$i] != "Seçiniz"){
        
                                }else{
                                    array_push($errors,"Lütfen sonraki aşamaya geçmeden önce".($i+1).'. '.$housingType->title.' '.$json->label.' değerini doldurmanız gerekiyor');
                                };
                            }
                        }
                    }
                }else{
                    return json_encode([
                        "status" => false,
                        "message" => "Sonraki aşamaya geçmeden önce lütfen ".$data->blocks[$j]." ".$housingType->title.' sayısını belirtiniz ve içeriklerini doldurunuz'
                    ]);
                }
            }
        }
        
        
        if(count($errors) > 0){
            return json_encode([
                "status" => false,
                "message" => implode('<br>,',$errors)
            ]);
        }else{
            return json_encode([
                "status" => true,
            ]);
        }
        return ;
    }

    public function addBlockHousing(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);
        $data = $tempData;
        if(isset($data->blocks)){
            array_push($data->blocks,$request->input('block'));
        }else{
            $data->blocks = [$request->input('block')];
        }

        TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
            "data" => json_encode($data),
        ]);
    }

    public function getBlockData(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);
        $blockHousingCounts = 0;
        $housingTypeForm = HousingType::where('id',$tempData->housing_type_id)->first();
        $housingTypeFormData = json_decode($housingTypeForm->form_json);
        $lastHousings = 0;
        $blockIndex = $request->input('block_index');
        $check = true;
        for($i = 0; $i < $blockIndex - 1; $i++){
            $lastHousings += $tempData->{"house_count".$i};
        }
        
        if($blockIndex != 0){
            $blockHousingCount = $tempData->{"house_count".$blockIndex - 1};
        }else{
            $blockHousingCount = 0;
        }
        for($i = $lastHousings; $i < ($lastHousings + $blockHousingCount); $i++){
            foreach($housingTypeFormData as $formData){
                if($formData->type == "checkbox-group"){
                    if(isset($tempData->roomInfoKeys->{str_replace('[]','',$formData->name).$i+1})){
                    }
                }else{
                    if($formData->required && !str_contains($formData->className, 'project-disabled')){
                        if(isset($tempData->roomInfoKeys->{str_replace('[]','',$formData->name)}[$i])){
                            
                        }else{
                            $check = false;
                        }
                    }
                    
                }
            }
        }
    
        if($check){
            for($i = 0; $i < intval($request->input('block_index')); $i++){
                $blockHousingCounts += $tempData->{"house_count".$i};
            }
            $dataCopyItem = $this->getHouseDataFunc($blockHousingCounts,$request->input('item_type'));
    
            return json_encode([
                "status" => true,
                "housing_count" => isset($tempData->{"house_count".$request->input('block_index')}) ? $tempData->{"house_count".$request->input('block_index')} : 0,
                "data" => $dataCopyItem
            ]);
        }else{
            return json_encode([
                "status" => false,
                "message" => "Önceki bloktaki konutların tüm alanlarının doldurulması gerekiyor"
            ]);
        }
        
    }

    public function removeBlock(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);
        $housingTypeForm = HousingType::where('id',$tempData->housing_type_id)->first();
        $housingTypeFormData = json_decode($housingTypeForm->form_json);
        $lastHousings = 0;
        for($i = 0; $i < $request->input('block_index'); $i++){
            $lastHousings += $tempData->{"house_count".$i};
        }
        $tempCount = $lastHousings;
        for($i = $lastHousings; $i < ($lastHousings + $tempData->{"house_count".$request->input('block_index')}); $i++){
            foreach($housingTypeFormData as $formData){
                if($formData->type == "checkbox-group"){
                    if(isset($tempData->roomInfoKeys->{str_replace('[]','',$formData->name).$i+1})){
                        unset($tempData->roomInfoKeys->{str_replace('[]','',$formData->name).($i+1)});
                    }
                }else{
                    if(isset($tempData->roomInfoKeys->{str_replace('[]','',$formData->name)}[$tempCount])){
                        unset($tempData->roomInfoKeys->{str_replace('[]','',$formData->name)}[$tempCount]);
                        $tempData->roomInfoKeys->{str_replace('[]','',$formData->name)} = array_values($tempData->roomInfoKeys->{str_replace('[]','',$formData->name)});
                    }
                }
            }
        }

        $lastHousings = 0;
        $lastHousingsEnd = 0;
        for($i = 0; $i < $request->input('block_index'); $i++){
            $lastHousings += $tempData->{"house_count".$i};
        }

        for($j = intval($request->input('block_index')) + 1; $j < count($tempData->blocks); $j++){
            $lastHousingsEnd += $tempData->{"house_count".$j};
        }

        for($i = 0; $i < $lastHousingsEnd; $i++){
            foreach($housingTypeFormData as $formData){
                if($formData->type == "checkbox-group"){
                    if(isset($tempData->roomInfoKeys->{str_replace('[]','',$formData->name).($i+$tempData->{"house_count".$request->input('block_index')}+$lastHousings+1)})){
                        $tempData->roomInfoKeys->{str_replace('[]','',$formData->name).($i + $lastHousings + 1)} = $tempData->roomInfoKeys->{str_replace('[]','',$formData->name).($i+$tempData->{"house_count".$request->input('block_index')}+$lastHousings + 1)};
                    }
                }
            }
        }

        
        for($i = ($lastHousings+$lastHousingsEnd+intval($tempData->{"house_count".$request->input('block_index')})); $i > ($lastHousings+$lastHousingsEnd); $i--){
            foreach($housingTypeFormData as $formData){
                if($formData->type == "checkbox-group"){
                    if(isset($tempData->roomInfoKeys->{str_replace('[]','',$formData->name).($i)})){
                        unset($tempData->roomInfoKeys->{str_replace('[]','',$formData->name).($i)});
                    }
                }
            }
        }


        if(count($tempData->blocks) == intval($request->input('block_index')) + 1){
            unset($tempData->{"house_count".intval($request->input('block_index'))});
        }else{
            for($j = intval($request->input('block_index')); $j <= count($tempData->blocks); $j++){
                if(isset($tempData->{"house_count".$j+1})){
                    $tempData->{"house_count".($j)} = $tempData->{"house_count".$j+1};
                    unset($tempData->{"house_count".$j+1});
                }
            }
        }

        
        $dataCopyItem = [];
        $housingCount = 0;
        
        
        unset($tempData->blocks[$request->input('block_index')]);
        $tempData->blocks = array_values($tempData->blocks);
        TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
            "data" => json_encode($tempData),
        ]);
        
        return json_encode([
            "status" => true,
            "data" => $dataCopyItem,
            "housing_count" => $housingCount
        ]);
    }
    
    public function changeAreaListData(Request $request){
        $tempOrder = TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);
        if($request->input('key') == "step1_slug"){
            $tempData->step1_slug = $request->input('value');
            $tempData->step2_slug = "";
            $tempData->step3_slug = "";
        }else if($request->input('key') == "step2_slug"){
            $tempData->step2_slug = $request->input('value');
            $tempData->step3_slug = "";
        }else{
            $tempData->step3_slug = $request->input('value');
        }

        TempOrder::where('item_type',$request->input('item_type'))->where('user_id',auth()->guard()->user()->id)->update([
            "data" => json_encode($tempData),
        ]);

        return json_encode([
            "status" => true
        ]);
    }
}
