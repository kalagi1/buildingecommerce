import axios from 'axios';
import React, { useEffect, useState } from 'react'
import { baseUrl } from '../../define/variables';
function TypeList2({setSlug,setSelectedHousingType,selectedHousingType,setSelectedTypes,selectedTypes,nextStep,housingTypes,setHousingTypes}) {
    const [loadingOrder,setLoadingOrder] = useState(null);
    const [loadingOrderStatusId,setLoadingOrderStatusId] = useState(null);

    useEffect(() => {
        axios.get(baseUrl+'housing_types').then((res) => {
            setHousingTypes([
                res.data.data
            ])
        })
    },[])

    const setHousingTypeParent = (housingTypeId,order) => {
        var tempHousingTypeParents = [];

        for(var i = 0; i <= order; i++){
            if(i == order){
                tempHousingTypeParents.push(housingTypeId);
            }else{
                tempHousingTypeParents.push(selectedTypes[i]);
            }
        }
        setLoadingOrder(order);
        setLoadingOrderStatusId(housingTypeId);
        setSelectedTypes(tempHousingTypeParents)
        if(order == 1){
            axios.get(baseUrl+'housing_types_end?parent_id='+housingTypeId).then((res) => {
                var tempHousingTypeParents = [];
                for(var i = 0; i <= order + 1; i++){
                    if(i == order + 1){
                        tempHousingTypeParents.push(res.data.data);
                    }else{
                        tempHousingTypeParents.push(housingTypes[i]);
                    }
                }
                setLoadingOrder(null);
                setLoadingOrderStatusId(null);
                setHousingTypes(tempHousingTypeParents);
            })
        }else{
            axios.get(baseUrl+'housing_types?parent_id='+housingTypeId).then((res) => {
                var tempHousingTypeParents = [];
                for(var i = 0; i <= order + 1; i++){
                    if(i == order + 1){
                        tempHousingTypeParents.push(res.data.data);
                    }else{
                        tempHousingTypeParents.push(housingTypes[i]);
                    }
                }
                setLoadingOrder(null);
                setLoadingOrderStatusId(null);
                setHousingTypes(tempHousingTypeParents);
            })
        }
        
    }


    return(
        <div>
            <div className="row">
                {
                    housingTypes[0] ? 
                        <div className="area-list active">
                            <ul>
                                {
                                    housingTypes[0].map((housingType) => {
                                        return(
                                            <li onClick={() => {setHousingTypeParent(housingType.id,0)}} className={selectedTypes[0] == housingType.id ? "selected" : ""}>
                                                {housingType.title}
                                                {
                                                    loadingOrder && loadingOrder == 0 && loadingOrderStatusId && loadingOrderStatusId == housingType.id ?
                                                        <div class="loading-icon"><i class="fa fa-spinner"></i></div>
                                                    : ''
                                                }
                                            </li>
                                        )
                                    })
                                }
                            </ul>
                        </div>
                    : ''
                }
                {
                    selectedTypes[0] && selectedTypes[0] != undefined ? 
                        <div className="area-list active">
                            <ul>
                                {
                                    housingTypes[1]?.map((housingType) => {
                                        return(
                                            <li onClick={() => {setHousingTypeParent(housingType.id,1);setSlug(housingType.slug)}} className={selectedTypes[1] == housingType.id ? "selected" : ""}>
                                                {housingType.title}
                                                {
                                                    loadingOrder && loadingOrder == 1 && loadingOrderStatusId && housingType.id == loadingOrderStatusId ?
                                                        <div class="loading-icon"><i class="fa fa-spinner"></i></div>
                                                    : ''
                                                }
                                            </li>
                                        )
                                    })
                                }
                            </ul>
                        </div>
                    : ''
                }
                {
                    selectedTypes[1] && selectedTypes[1] != undefined ? 
                        <div className="area-list active">
                            <ul>
                                {
                                    housingTypes[2]?.map((housingType) => {
                                        return(
                                            <li onClick={() => {setSelectedHousingType(housingType);setHousingTypeParent(housingType.id,2)}} className={selectedTypes[2] == housingType.id ? "selected" : ""}>
                                                {housingType.housing_type.title}
                                            </li>
                                        )
                                    })
                                }
                            </ul>
                        </div>
                    : ''
                }
                {
                    selectedTypes[2] && selectedTypes[2] != undefined ? 
                        <div class="area-list active">
                            <div class="finish-category-select">
                                <div class="finish-icon-area">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div class="finish-text">
                                    <p>Kategori Seçimi Tamanlanmıştır</p>
                                </div>
                                <div class="finish-button-first">
                                    <button onClick={() => {nextStep(2)}} class="btn btn-info">
                                        Devam
                                    </button>
                                </div>
                            </div>
                        </div>
                    : ''
                }
            </div>
        </div>
    )
}
export default TypeList2