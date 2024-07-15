import axios from 'axios';
import React, { useEffect, useState } from 'react'
import { baseUrl } from '../../define/variables';
function TypeList({setSlug,setSelectedHousingType,setSelectedTypes,selectedTypes,nextStep,housingTypes,setHousingTypes,selectedTypesTitles,setSelectedTypesTitles}) {
    const [housingStatuses,setHousingStatuses] = React.useState([]);
    const [loadingOrder,setLoadingOrder] = React.useState(null);
    const [loadingOrderStatusId,setLoadingOrderStatusId] = React.useState(null);

    React.useEffect(() => {
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
            statusId,
            null, // Clear the second selection
            null, // Clear the third selection
            null  // Clear the fourth selection
        ]);
        setSelectedTypesTitles([statusId]); // Update titles accordingly
    }
    
    const setHousingTypeParent = (housingTypeId, order) => {
        var tempHousingTypeParents = [];
    
        for (var i = 0; i <= order; i++) {
            if (i === order) {
                tempHousingTypeParents.push(housingTypeId);
            } else {
                tempHousingTypeParents.push(selectedTypes[i]);
            }
        }
    
        setLoadingOrder(order);
        setLoadingOrderStatusId(housingTypeId);
        setSelectedTypes(tempHousingTypeParents);
    
        // Clear selections for further cards when setting a parent type
        if (order < 2) {
            setSelectedTypes((prev) => {
                const updated = [...prev];
                for (let i = order + 1; i < updated.length; i++) {
                    updated[i] = null;
                }
                return updated;
            });
        }
    
        const fetchHousingTypes = order === 2 
            ? `housing_types_end?parent_id=${housingTypeId}` 
            : `housing_types?parent_id=${housingTypeId}`;
    
        axios.get(baseUrl + fetchHousingTypes).then((res) => {
            var tempHousingTypeParents = [];
            for (var i = 0; i <= order; i++) {
                if (i === order) {
                    tempHousingTypeParents.push(res.data.data);
                } else {
                    tempHousingTypeParents.push(housingTypes[i]);
                }
            }
    
            setLoadingOrder(null);
            setLoadingOrderStatusId(null);
            setHousingTypes(tempHousingTypeParents);
        });
    }
    
    const setHousingTypeTitles = (housingTypeTitle,order) => {
        var tempHousingTypeParents = [];

        for(var i = 0; i <= order; i++){
            if(i == order){
                tempHousingTypeParents.push(housingTypeTitle);
            }else{
                tempHousingTypeParents.push(selectedTypesTitles[i]);
            }
        }
        
        setSelectedTypesTitles(tempHousingTypeParents)
        
    }

    return(
        <div>
            <div className="row">
                <div className="area-listx">
                    <ul>
                        {
                            housingStatuses.sort((a, b) => a.name.localeCompare(b.name, 'tr')).map((housingStatus) => {
                                if(!housingStatus.is_default){
                                    return(
                                        <li onClick={() => {setHousingStatus(housingStatus.id);setHousingTypeTitles(housingStatus.name,0)}} className={selectedTypes[0] == housingStatus.id ? "selected" : ""}>{housingStatus.name}</li>
                                    )
                                }
                                
                            })
                        }
                    </ul>
                </div>
                {
                    selectedTypes[0] && housingTypeTitle ? 
                        <div className="area-list active">
                            <ul>
                                {
                                    housingTypes[0].map((housingType) => {
                                        return(
                                            <li onClick={() => {setHousingTypeParent(housingType.id,1);setHousingTypeTitles(housingType.title,1)}} className={selectedTypes[1] == housingType.id ? "selected" : ""}>
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
                                            <li onClick={() => {setHousingTypeParent(housingType.id,2);setSlug(housingType.slug);setHousingTypeTitles(housingType.title,2)}} className={selectedTypes[2] == housingType.id ? "selected" : ""}>
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
                                            <li onClick={() => {setSelectedHousingType(housingType);setHousingTypeParent(housingType.id,3);setHousingTypeTitles(housingType?.housing_type?.title,3)}} className={selectedTypes[3] == housingType.id ? "selected" : ""}>
                                                {housingType?.housing_type?.title}
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
                                    <button onClick={() => {nextStep}} class="btn btn-info">
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