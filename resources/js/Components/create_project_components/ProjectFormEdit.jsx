import { Alert, FormControl, Switch } from '@mui/material'
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';
import React, { useCallback, useEffect, useState } from 'react'
import EditorToolbar, { modules, formats } from "./QuilToolbar";
import BlockRooms from './BlockRooms';
import Rooms from './Rooms';
import axios from 'axios';
import { baseUrl } from '../../define/variables';
import { GoogleMap, Marker, useJsApiLoader } from '@react-google-maps/api';
import { fromAddress, setDefaults } from 'react-geocode';
import FileUpload from './FileUpload';
import FinishArea from './FinishArea';
function ProjectFormEdit({center,setCenter,anotherBlockErrors,selectedBlock,setSelectedBlock,selectedRoom,setSelectedRoom,projectData,allErrors,setProjectDataFunc,haveBlocks,setHaveBlocks,roomCount,setRoomCount,blocks,setBlocks,selectedHousingType,setProjectData,createProject}) {
    const [cities,setCities] = useState([]);
    const [counties,setCounties] = useState([]);
    const [neighborhoods,setNeighborhoods] = useState([]);
    const [map, setMap] = useState(null);
    const [zoom,setZoom] = useState(1);
    const [selectedLocation,setSelectedLocation] = useState({});
    const setProjectTitle = (projectTitle) => {
        if(projectTitle.length <= 70){
            setProjectDataFunc('project_title',projectTitle)
        }
    }

    const dotNumberFormat = (number) => {
        if(number.replace('.','').replace('.','').replace('.','').replace('.','') != parseInt(number.replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
            return "";
            
        }else{
            var inputValue = number.replace(/\D/g, '');
            inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
            return inputValue;
        }
    }

    useEffect(() => {
        axios.get(baseUrl+'cities').then((res) => {
            setCities(res.data.data);
        })

        setDefaults({
            key: "AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0", // Your API key here.
            language: "en", // Default language for responses.
            region: "es", // Default region for responses.
        });
    },[])

    const setGeolocation = (cityId,countyId = null,neighborhoodId = null) => {
        var cityTemp = cities.find((city) => { return city.id == cityId});

        if(cityId && !countyId && !neighborhoodId){
            setZoom(8);
        }else if(cityId && countyId && !neighborhoodId){
            setZoom(10);
        }else{
            setZoom(12);
        }

        var countyTemp = counties.find((county) => { return county.ilce_key == countyId});
        var neighborhoodTemp = neighborhoods.find((neighborhood) => { return neighborhood.mahalle_id == neighborhoodId});
        fromAddress(cityTemp.title+" "+countyTemp?.ilce_title+' '+neighborhoodTemp?.mahalle_title)
        .then(({ results }) => {
            setCenter(results[0].geometry.location)
        })
        .catch(console.error);
    }

    const getCounties = (cityId) => {
        axios.get(baseUrl+'counties?city_id='+cityId).then((res) => {
            setCounties(res.data.data);
        })
    }

    useEffect(() => {
        getCounties(projectData.city_id)
        getNeighborhoods(projectData.county_id)
    },[projectData.city_id])

    const getNeighborhoods = (countyId) => {
        axios.get(baseUrl+'neighborhoods?county_id='+countyId).then((res) => {
            setNeighborhoods(res.data.data)
        })
    }

    const label = { inputProps: { 'aria-label': 'Switch demo' } };

    const containerStyle = {
        width: '100%',
        height: '400px'
    };

    const { isLoaded } = useJsApiLoader({
        id: 'google-map-script',
        googleMapsApiKey: "AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0"
    })

    const onLoad = useCallback(function callback(map) {
        // This is just an example of getting and using the map instance!!! don't just blindly copy!
        const bounds = new window.google.maps.LatLngBounds(center);

        map.fitBounds(bounds);
        map.addListener('click', (e) => {
            const lat = e.latLng.lat();
            const lng = e.latLng.lng();
            setSelectedLocation({lat,lng});
            setProjectDataFunc('coordinates',(lat+'-'+lng));
          });
        setMap(map)
    }, [])


    const onUnmount = useCallback(function callback(map) {
        setMap(null)
    }, [])
    

    return(
        <div>
            <h2>
                {projectData.project_title} Projesini Güncelle
            </h2>
            <div className="card p-4">
                <div className="form-group">
                    <label htmlFor="">Proje Adı <span className="required">*</span></label>
                    <div className="max-character-input">
                        <div className="row" style={{alignItems:'center'}}>
                            <div className="input col-md-10">
                                <input id='project_title' value={projectData.project_title} onChange={(e) => {setProjectTitle(e.target.value)}} type="text" className={'form-control advert_title '+(allErrors.includes('project_title') ? "error-border" : "")} />
                            </div>
                            <div className="col-md-2">
                                <label className="max-character" htmlFor="">{projectData.project_title ? projectData.project_title.length : 0}/70</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="form-group">
                    <label htmlFor="">Proje Açıklaması <span className="required">*</span></label>
                    <EditorToolbar />
                    <ReactQuill 
                        theme="snow" 
                        value={projectData.description} 
                        id='description'
                        onChange={(e) => {setProjectDataFunc('description',e)}} 
                        modules={modules}
                        formats={formats}
                        className={allErrors.includes('description') ? "error-border" : ""}
                    />
                </div>
            </div>

            <div className="card p-3 mb-4 mt-4">
                <div className="htmlform-group">
                    <div className="row">
                        <div className="col-md-6">
                            <label htmlfor="">Yapımcı Firma</label>
                            <div className="icon-input">
                                <div className="icon-area">
                                    <i className="fa fa-building"></i>
                                </div>
                                <input type="text" value={projectData.create_company} onChange={(e) => {setProjectDataFunc('create_company',e.target.value)}} className='create_company'/>
                            </div>
                        </div>
                        <div className="col-md-6">
                            <label htmlfor="">Toplam Proje Alanı (M2)</label>
                            <div className="icon-input">
                                <div className="icon-area">
                                    <i className='fa fa-line-height'></i>
                                </div>
                                <input type="text" value={projectData.total_project_area} onChange={(e) => {setProjectDataFunc('total_project_area',dotNumberFormat(e.target.value))}} className='total_project_area price-only'/>
                            </div>
                        </div>
                        
                        <div className="col-md-6 mt-2">
                            <label htmlfor="">Başlangıç Tarihi</label>
                            <div className="icon-input">
                                <div className="icon-area">
                                    <i className="fa fa-calendar-days"></i>
                                </div>
                                <input type="date" value={projectData.start_date} onChange={(e) => {setProjectDataFunc('start_date',e.target.value)}} className="start_date"/>
                            </div>
                        </div>
                        
                        <div className="col-md-6 mt-2">
                            <label htmlfor="">Bitiş Tarihi</label>
                            <div className="icon-input">
                                <div className="icon-area">
                                    <i className="fa fa-calendar-days"></i>
                                </div>
                                <input type="date" value={projectData.end_date} onChange={(e) => {setProjectDataFunc('end_date',e.target.value)}} className="end_date"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <span className="section-title">Adres Bilgileri</span>
                <div className="card">
                    <div className="row px-5 py-4">
                        <div className="col-md-4">
                            <label for="">İl <span className="required">*</span></label>
                            <select value={projectData.city_id} onChange={(e) => {setGeolocation(e.target.value);setProjectDataFunc('city_id',e.target.value);getCounties(e.target.value)}} name="city_id" id="city_id" className={"form-control "+(allErrors.includes('city_id') ? "error-border" : "")}>
                                <option value="">İl Seç</option>
                                {
                                    cities.map((city) => {
                                        return(
                                            <option value={city.id}>{city.title}</option>
                                        )
                                    })
                                }
                            </select>
                        </div>
                        <div className="col-md-4">
                            <label for="">İlçe <span className="required">*</span></label>
                            <select value={projectData.county_id} onChange={(e) => {setGeolocation(projectData.city_id,e.target.value);setProjectDataFunc('county_id',e.target.value);getNeighborhoods(e.target.value)}} name="county_id" id="county_id" className={"form-control "+(allErrors.includes('city_id') ? "error-border" : "")}>
                                <option  value="">İlçe Seç</option>
                                {
                                    counties.map((county) => {
                                        return(
                                            <option value={county.ilce_key}>{county.ilce_title}</option>
                                        )
                                    })
                                }
                            </select>
                        </div>
                        <div className="col-md-4">
                            <label for="">Mahalle <span className="required">*</span></label>
                            <select value={projectData.neighbourhood_id} onChange={(e) => {setGeolocation(projectData.city_id,projectData.county_id,e.target.value);setProjectDataFunc('neighbourhood_id',e.target.value)}} name="neighbourhood_id" id="neighbourhood_id" className={"form-control "+(allErrors.includes('neighbourhood_id') ? "error-border" : "")}>
                                <option value="">Mahalle Seç</option>
                                {
                                    neighborhoods.map((neighborhood) => {
                                        return(
                                            <option value={neighborhood.mahalle_id}>{neighborhood.mahalle_title}</option>
                                        )
                                    })
                                }
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    {
                        allErrors.includes('coordinates') ? <Alert severity="error">Harita üzerine bir konum seçin</Alert> : ""
                    }
                    {
                        isLoaded ? (
                            <GoogleMap
                                zoom={zoom}
                                id='map'
                                mapContainerStyle={containerStyle}
                                center={center}
                                onLoad={onLoad}
                                onUnmount={onUnmount}
                            >
                              <Marker position={selectedLocation} />
                            </GoogleMap>
                        ) : <></>
                    }
                </div>
                <FileUpload accept={"image/png, image/gif, image/jpeg"} projectData={projectData} setProjectData={setProjectData} allErrors={allErrors} fileName={"cover_image"} title="Kapak Fotoğrafı" setProjectDataFunc={setProjectDataFunc} multiple={false}/>
                <FileUpload accept={"image/png, image/gif, image/jpeg"} projectData={projectData} setProjectData={setProjectData} allErrors={allErrors} fileName={"gallery"} title="Proje Galerisi" setProjectDataFunc={setProjectDataFunc} multiple={true}/>
                <FileUpload accept={"image/png, image/gif, image/jpeg"} projectData={projectData} setProjectData={setProjectData} allErrors={allErrors} fileName={"situations"} setProjectDataFunc={setProjectDataFunc} title="Vaziyet & Kat Planı" multiple={true}/>
                <FinishArea createProject={createProject}/>
            </div>
        </div>
    )
}
export default ProjectFormEdit