import React, { useState } from 'react'
import TypeList from './create_project_components/TypeList';
import ProjectForm from './create_project_components/ProjectForm';
import axios from 'axios';
import { baseUrl } from '../define/variables';
import EndSection from './create_project_components/EndSection';
import TopCreateProjectNavigator from './create_project_components/TopCreateProjectNavigator';


function CreateProject(props) {
    const [step,setStep] = useState(1);
    const [housingTypes,setHousingTypes] = useState([]);
    const [selectedTypes,setSelectedTypes] = useState([]);
    const [projectData,setProjectData] = useState({});
    const [selectedHousingType,setSelectedHousingType] = useState({});
    const [haveBlocks,setHaveBlocks] = useState(false);
    const [blocks,setBlocks] = useState([]);
    const [roomCount,setRoomCount] = useState(0);
    const setProjectDataFunc = (key,value) => {
        setProjectData({
            ...projectData,
            [key] : value
        });
    }
    const nextStep = (stepOrder) => {
        setStep(stepOrder);
    }

    const createProject = () => {
        const formData = new FormData();
        blocks.forEach((block, blockIndex) => {
            // Blok verilerini FormData'ya ekle
            Object.keys(block).forEach(key => {
                if(key != 'rooms'){
                    formData.append(`blocks[${blockIndex}][${key}]`, block[key]);
                }
            });
          
            // Blokun odalarını FormData'ya ekle
            block.rooms.forEach((room, roomIndex) => {
              Object.keys(room).forEach(key => {
                if(key == "payDecs"){
                    room.payDecs.forEach((payDec,payDecIndex) => {
                        formData.append(`blocks[${blockIndex}][rooms][${roomIndex}][payDecs][${payDecIndex}][price]`, payDec.price);
                        formData.append(`blocks[${blockIndex}][rooms][${roomIndex}][payDecs][${payDecIndex}][date]`, payDec.date);
                    })
                }else{
                    if(!key.includes('imagex')){
                        formData.append(`blocks[${blockIndex}][rooms][${roomIndex}][${key.replace('[]','')}]`, room[key]);
                    }
                }
              });
            });
        });

        Object.keys(projectData).forEach(key => {
            if(!key.includes('_imagex') && !key.includes('_imagesx')){
                if(Array.isArray(projectData[key])){
                    projectData[key].forEach((data,index) => {
                        formData.append(`projectData[${key}][${index}]`, data);
                    })
                }else{
                    formData.append(`projectData[${key}]`, projectData[key]);
                }
            }
            
        })

        formData.append('haveBlocks',haveBlocks);
        
        selectedTypes.forEach((data,index) => {
            formData.append(`selectedTypes[${index}]`,data)
        })

        axios.post(baseUrl+'create_project',formData,{
            headers: {
                'accept': 'application/json',
                'Accept-Language': 'en-US,en;q=0.8',
                'Content-Type': `multipart/form-data;`,
            }
        }).then((res) => {
            if(res.data.status){
                setStep(3);
            }
        })
    }

    return(
        <>
            <TopCreateProjectNavigator step={step} setStep={setStep}/>
            {
                step == 1 ? 
                    <TypeList setSelectedHousingType={setSelectedHousingType} selectedHousingType={selectedHousingType} housingTypes={housingTypes} setHousingTypes={setHousingTypes} selectedTypes={selectedTypes} setSelectedTypes={setSelectedTypes} nextStep={nextStep} />
                :  step == 2 ?
                    <ProjectForm createProject={createProject} selectedHousingType={selectedHousingType} blocks={blocks} setBlocks={setBlocks} roomCount={roomCount} setRoomCount={setRoomCount} haveBlocks={haveBlocks} setHaveBlocks={setHaveBlocks} setProjectData={setProjectData} projectData={projectData} setProjectDataFunc={setProjectDataFunc} />
                : 
                    <EndSection/>
            }
        
        </>
    )
}
export default CreateProject