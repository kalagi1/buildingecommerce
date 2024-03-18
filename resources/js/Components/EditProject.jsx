import React, { useEffect, useState } from 'react'
import TypeList from './create_project_components/TypeList';
import ProjectForm from './create_project_components/ProjectForm';
import axios from 'axios';
import { baseUrl, frontEndUrl } from '../define/variables';
import EndSection from './create_project_components/EndSection';
import TopCreateProjectNavigator from './create_project_components/TopCreateProjectNavigator';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { Block } from '@mui/icons-material';
import { Box, LinearProgress, Modal, Typography } from '@mui/material';
import ProjectFormEdit from './create_project_components/ProjectFormEdit';
import EndSection2 from './create_project_components/EndSection2';


function EditProject({projectId}) {
    const [step,setStep] = useState(1);
    const [loadingModal,setLoadingModal] = useState(false);
    const [projectData,setProjectData] = useState({});
    const [selectedHousingType,setSelectedHousingType] = useState({});
    const [haveBlocks,setHaveBlocks] = useState(false);
    const [blocks,setBlocks] = useState([]);
    const [roomCount,setRoomCount] = useState(0);
    const [allErrors,setAllErrors] = useState([]);
    const [selectedBlock,setSelectedBlock] = useState(null);
    const [selectedRoom,setSelectedRoom] = useState(0);
    const [lastImages,setLastImages] = useState([]);
    const [lastSituations,setLastSituations] = useState([]);
    const [anotherBlockErrors,setAnotherBlockErrors] = useState(0);
    const [center,setCenter] = useState({
        lat: 37.871540,
        lng: 32.498914
    });
    const setProjectDataFunc = (key,value) => {
        setProjectData({
            ...projectData,
            [key] : value
        });
    }
    const nextStep = (stepOrder) => {
        setStep(stepOrder);
    }

    console.log(projectData)
    useEffect(() => {
        axios.get(baseUrl+'project/'+projectId).then((res) => {
            var tempImages = [];
            var tempSituations = [];

            for(var i = 0; i < res.data.data.images.length; i++){
                tempImages.push(frontEndUrl+(res.data.data.images[i]?.image.replace('public','storage')));
            }

            for(var i = 0; i < res.data.data.situations.length; i++){
                tempSituations.push(frontEndUrl+(res.data.data.situations[i]?.situation.replace('public/','')));
            }

            var lat = res.data.data.location.split(',')[0];
            var lng = res.data.data.location.split(',')[1];
            setProjectData({
                project_title : res.data.data.project_title,
                description : res.data.data.description,
                create_company : res.data.data.create_company,
                total_project_area : res.data.data.total_project_area,
                start_date : res.data.data.start_date,
                end_date : res.data.data.end_date,
                city_id : res.data.data.city_id,
                county_id : res.data.data.county_id,
                neighbourhood_id : res.data.data.neighbourhood_id,
                coordinates : lat+'-'+lng,
                cover_image_imagex : frontEndUrl+res.data.data.image.replace('public','storage'),
                gallery_imagesx : tempImages,
                gallery : [],
                situations : [],
                situations_imagesx : tempSituations
            })

            setLastImages(tempImages);
            setLastSituations(tempSituations);
        })
    },[])

    function getCoords(elem) { // crossbrowser version
        var box = elem.getBoundingClientRect();
    
        var body = document.body;
        var docEl = document.documentElement;
    
        var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
        var scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;
    
        var clientTop = docEl.clientTop || body.clientTop || 0;
        var clientLeft = docEl.clientLeft || body.clientLeft || 0;
    
        var top  = box.top +  scrollTop - clientTop;
        var left = box.left + scrollLeft - clientLeft;
    
        return { top: Math.round(top), left: Math.round(left) };
    }


    const createProject = () => {
        var tempErrors = [];
        var anotherBlockErrorsTemp = [];
        if(!projectData.project_title){
            tempErrors.push("project_title");
            var element = document.getElementById("project_title");
            window.scrollTo({
                top: getCoords(element).top - document.getElementById('navbarDefault').offsetHeight - 30,
                behavior: 'smooth' // Yumuşak kaydırma efekti için
            });
        }else{
            if(!projectData.description){
                var elementDesc = document.getElementById("description");
                window.scrollTo({
                    top: getCoords(elementDesc).top - document.getElementById('navbarDefault').offsetHeight - 30,
                    behavior: 'smooth' // Yumuşak kaydırma efekti için
                });
            }else{
                if(!projectData.city_id){
                    var elementCity = document.getElementById("city_id");
                    window.scrollTo({
                        top: getCoords(elementCity).top - document.getElementById('navbarDefault').offsetHeight - 30,
                        behavior: 'smooth' // Yumuşak kaydırma efekti için
                    });
                }else{
                    if(!projectData.county_id){
                        var element = document.getElementById("county_id");
                        window.scrollTo({
                            top: getCoords(element).top - document.getElementById('navbarDefault').offsetHeight - 30,
                            behavior: 'smooth' // Yumuşak kaydırma efekti için
                        });
                    }else{
                        if(!projectData.neighbourhood_id){
                            var element = document.getElementById("neighbourhood_id");
                            window.scrollTo({
                                top: getCoords(element).top - document.getElementById('navbarDefault').offsetHeight - 30,
                                behavior: 'smooth' // Yumuşak kaydırma efekti için
                            });
                        }else{
                            if(!projectData.coordinates || projectData.coordinates == "undefined-undefined"){
                                var element = document.getElementById("map");
                                window.scrollTo({
                                    top: getCoords(element).top - document.getElementById('navbarDefault').offsetHeight - 40,
                                    behavior: 'smooth' // Yumuşak kaydırma efekti için
                                });
                            }else{
                                if(!projectData.cover_image){
                                    var element = document.getElementById("cover_image");
                                    window.scrollTo({
                                        top: getCoords(element).top - document.getElementById('navbarDefault').offsetHeight - 40,
                                        behavior: 'smooth' // Yumuşak kaydırma efekti için
                                    });
                                }else{
                                    if(!projectData.gallery){
                                        var element = document.getElementById("gallery");
                                        window.scrollTo({
                                            top: getCoords(element).top - document.getElementById('navbarDefault').offsetHeight - 40,
                                            behavior: 'smooth' // Yumuşak kaydırma efekti için
                                        });
                                    }else{
                                        if(!projectData.situations){
                                            var element = document.getElementById("situations");
                                            window.scrollTo({
                                                top: getCoords(element).top - document.getElementById('navbarDefault').offsetHeight - 40,
                                                behavior: 'smooth' // Yumuşak kaydırma efekti için
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        setAnotherBlockErrors(anotherBlockErrorsTemp);

        if(!projectData.description){
            tempErrors.push("description");
        }

        if(!projectData.city_id){
            tempErrors.push("city_id");
        }

        if(!projectData.county_id){
            tempErrors.push("county_id");
        }

        if(!projectData.neighbourhood_id){
            tempErrors.push("neighbourhood_id");
        }

        if(!projectData.coordinates || projectData.coordinates == "undefined-undefined"){
            tempErrors.push("coordinates");
        }

        setAllErrors(tempErrors);
        var deletedImages = [];
         lastImages.filter((lastImage,order) => {
            if(!projectData.gallery_imagesx.includes(lastImage)){
                deletedImages.push(order);
            }
        })

        var deletedSituations = [];
         lastSituations.filter((lastImage,order) => {
            if(!projectData.situations_imagesx.includes(lastImage)){
                deletedSituations.push(order);
            }
        })

        if(tempErrors.length == 0){
            setLoadingModal(true);
            const formData = new FormData();

            formData.append('deleted_images',deletedImages);
            formData.append('deleted_situations',deletedSituations);
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
            
            formData.append('_method','put');
            
            axios.post(baseUrl+'edit_project_v3/'+projectId,formData,{
                headers: {
                    'accept': 'application/json',
                    'Accept-Language': 'en-US,en;q=0.8',
                    'Content-Type': `multipart/form-data;`,
                }
            }).then((res) => {
                if(res.data.status){
                    setStep(2);
                    setLoadingModal(false);
                }
            }).catch((error) => {
                
            })
        }
        
    }

    const style = {
        position: 'absolute',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        width: 600,
        bgcolor: 'background.paper',
        boxShadow: 24,
        p: 4,
    };

    function LinearProgressWithLabel(props) {
        return (
          <Box sx={{ display: 'flex', alignItems: 'center' }}>
            <Box sx={{ width: '100%', mr: 1 }}>
              <LinearProgress variant="determinate" {...props} />
            </Box>
            <Box sx={{ minWidth: 35 }}>
              <Typography variant="body2" color="text.secondary">{`${Math.round(
                props.value,
              )}%`}</Typography>
            </Box>
          </Box>
        );
    }

    return(
        <>
            <Modal
                open={loadingModal}
                onClose={() => {setLoadingModal(false)}}
                aria-labelledby="modal-modal-title"
                aria-describedby="modal-modal-description"
            >
                <Box sx={style}>
                    <h2>Projeniz güncelleniyor.</h2>
                    <p>Lütfen işlem tamamlanana kadar tarayıcıyı ve bilgisayarı kapatmayın. </p>
                </Box>
            </Modal>
            <ToastContainer/>
            {
                step == 1 ? 
                    <ProjectFormEdit center={center} setCenter={setCenter} anotherBlockErrors={anotherBlockErrors} selectedBlock={selectedBlock} setSelectedBlock={setSelectedBlock} selectedRoom={selectedRoom} setSelectedRoom={setSelectedRoom} allErrors={allErrors} createProject={createProject} selectedHousingType={selectedHousingType} blocks={blocks} setBlocks={setBlocks} roomCount={roomCount} setRoomCount={setRoomCount} haveBlocks={haveBlocks} setHaveBlocks={setHaveBlocks} setProjectData={setProjectData} projectData={projectData} setProjectDataFunc={setProjectDataFunc} />
                :
                    <EndSection2/>
            }
        
        </>
    )
}
export default EditProject