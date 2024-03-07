import axios from 'axios';
import React, { useEffect, useState } from 'react'
import { baseUrl } from '../../define/variables';
function TypeList({setSelectedHousingType,selectedHousingType,setSelectedTypes,selectedTypes,nextStep,housingTypes,setHousingTypes}) {
    const [housingStatuses,setHousingStatuses] = useState([]);
    const [loadingOrder,setLoadingOrder] = useState(null);
    const [loadingOrderStatusId,setLoadingOrderStatusId] = useState(null);

    useEffect(() => {
        axios.get(baseUrl+'get_housing_statuses').then((res) => {
            setHousingStatuses(res.data.data);
        })

        axios.get(baseUrl+'housing_types').then((res) => {
            setHousingTypes([
                res.data.data
            ])
        })
    },[])

    const setHousingStatus = (statusId) => {
        setSelectedTypes([
            statusId
        ]);
    }

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
        if(order == 2){
            axios.get(baseUrl+'housing_types_end?parent_id='+housingTypeId).then((res) => {
                var tempHousingTypeParents = [];
                for(var i = 0; i <= order; i++){
                    if(i == order){
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
                for(var i = 0; i <= order; i++){
                    if(i == order){
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
                <div className="area-listx">
                    <ul>
                        {
                            housingStatuses.map((housingStatus) => {
                                return(
                                    <li onClick={() => {setHousingStatus(housingStatus.id)}} className={selectedTypes[0] == housingStatus.id ? "selected" : ""}>{housingStatus.name}</li>
                                )
                            })
                        }
                    </ul>
                </div>
                {
                    selectedTypes[0] ? 
                        <div className="area-list active">
                            <ul>
                                {
                                    housingTypes[0].map((housingType) => {
                                        return(
                                            <li onClick={() => {setHousingTypeParent(housingType.id,1)}} className={selectedTypes[1] == housingType.id ? "selected" : ""}>
                                                {housingType.title}
                                                {
                                                    loadingOrder && loadingOrder == 1 && loadingOrderStatusId && loadingOrderStatusId == housingType.id ?
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
                                    housingTypes[1]?.map((housingType) => {
                                        return(
                                            <li onClick={() => {setHousingTypeParent(housingType.id,2)}} className={selectedTypes[2] == housingType.id ? "selected" : ""}>
                                                {housingType.title}
                                                {
                                                    loadingOrder && loadingOrder == 2 && loadingOrderStatusId && housingType.id == loadingOrderStatusId ?
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
                    selectedTypes[2] && selectedTypes[2] != undefined ? 
                        <div className="area-list active">
                            <ul>
                                {
                                    housingTypes[2]?.map((housingType) => {
                                        return(
                                            <li onClick={() => {setSelectedHousingType(housingType);setHousingTypeParent(housingType.id,3)}} className={selectedTypes[3] == housingType.id ? "selected" : ""}>
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
                    selectedTypes[3] && selectedTypes[3] != undefined ? 
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
export default TypeList