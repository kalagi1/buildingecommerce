import React, { useState } from 'react'
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';
import Modal from '@mui/material/Modal';
import { dotNumberFormat } from '../../define/variables';
import { Alert, Checkbox, FormControlLabel, Switch } from '@mui/material';
import RoomNavigator from './RoomNavigator';
import PayDecModal from './PayDecModal';

function Rooms({allErrors,anotherBlockErrors,selectedBlock,setSelectedBlock,selectedRoom,setSelectedRoom,blocks,setBlocks,roomCount,setRoomCount,selectedHousingType}) {
    const [validationErrors,setValidationErrors] = useState([]);
    var formData = JSON.parse(selectedHousingType?.housing_type?.form_json);
    const [rendered,setRendered] = useState(0);
    const [payDecOpen,setPayDecOpen] = useState(false);


    const setRoomCountFunc = (event) => {
        setBlocks([
            {
                name : "none",
                roomCount : roomCount,
                rooms : [
                    {}
                ]
            }
        ]);

        setSelectedBlock(0);
        setSelectedRoom(0)
    }

    const blockDataSet = (blockIndex,keyx,value) => {
        var newDatas = blocks.map((block,key) => {
            if(blockIndex == key){
                var newData2 = block.rooms.map((room,keyRoom) => {
                    if(keyRoom == selectedRoom){
                        return {
                            ...room,
                            [keyx] : value
                        }
                    }else{
                        return room;
                    }
                })

                return {
                    ...block,
                    rooms : [
                        ...newData2
                    ]
                }
            }else{
                return block;
            }
        })

        var newErrors = validationErrors.filter((validationError) => validationError != keyx);

        setValidationErrors(newErrors);

        setBlocks(newDatas);
        setRendered(rendered + 1);
    }

    const blockCheckboxDataSet = (blockIndex,keyx,value,isChecked) => {
        var newDatas = blocks.map((block,key) => {
            if(blockIndex == key){
                var newData2 = block.rooms.map((room,keyRoom) => {
                    if(keyRoom == selectedRoom){
                        if(room[keyx]){
                            if(room[keyx].includes(value)){
                                var newKeyValues = room[keyx].filter((keyVal) => {
                                    if(keyVal != value){
                                        return keyVal;
                                    }
                                })

                                return {
                                    ...room,
                                    [keyx] : newKeyValues
                                }
                            }else{
                                return {
                                    ...room,
                                    [keyx] : [...room[keyx],value]
                                }
                            }
                            
                        }else{
                            return {
                                ...room,
                                [keyx] : [value]
                            }
                        }
                        
                    }else{
                        return room;
                    }
                })

                return {
                    ...block,
                    rooms : [
                        ...newData2
                    ]
                }
            }else{
                return block;
            }
        })
        setBlocks(newDatas);
        setRendered(rendered + 1);
    }

    const changeFormImage = (blockIndex,keyx,event) => {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = () => {
            var newDatas = blocks.map((block,key) => {
                if(blockIndex == key){
                    var newData2 = block.rooms.map((room,keyRoom) => {
                        if(keyRoom == selectedRoom){
                            return {
                                ...room,
                                [keyx] : file,
                                [keyx+'_imagex'] : reader.result
                            }
                        }else{
                            return room;
                        }
                    })

                    return {
                        ...block,
                        rooms : [
                            ...newData2
                        ]
                    }
                }else{
                    return block;
                }
            })
            

            var newErrors = validationErrors.filter((validationError) => validationError != keyx);
            setValidationErrors(newErrors);
            setBlocks(newDatas);
            setRendered(rendered + 1);
        };


        
        if (file) {
            reader.readAsDataURL(file);
        }
        
    };

    return(
        <div className='card p-3 mt-3'  style={{position:'relative'}}>
            <div  id='housing-forms'>
                <h6 className='block-title'>Proje İlanları</h6>
                {
                    anotherBlockErrors.length > 0 ?
                        <Alert icon={false} severity="error">
                            <ul style={{margin:0}}>
                                {
                                    anotherBlockErrors.map((anotherBlockError) => {
                                        return(
                                            <li>
                                                {anotherBlockError}
                                            </li>  
                                        )
                                    })
                                }
                            </ul>
                        </Alert> 
                    : ''
                }
                <div className="block-list mt-3">
                    <label htmlFor="">Projedeki İlan Sayısı</label>
                    <div className='d-flex'>
                        <input type="text" style={{width:'150px'}} name="" className='form-control' value={roomCount} onChange={(e) => {setRoomCount(e.target.value)}} id="" />
                        <span id="generate_tabs" style={{width:'230px',justifyContent:'center'}} onClick={setRoomCountFunc} className="mx-2 d-flex btn btn-primary has_blocks-close">İlan Formunu Oluştur</span>
                    </div>
                </div>

                <div className="housing-form mt-7">
                    {
                        formData.map((data) => {
                            if(!data?.className?.includes("project-disabled")){
                                if(data.type == "text"){
                                    return(
                                        <div className={"form-group "+(!(blocks[selectedBlock] && blocks[selectedBlock].rooms[selectedRoom] && blocks[selectedBlock].rooms[selectedRoom]['payment-plan[]'] && blocks[selectedBlock].rooms[selectedRoom]['payment-plan[]'].includes('taksitli')) && data.className.includes('second-payment-plan') ? "d-none" : "")}>
                                            <label className='font-bold' htmlFor="">{data.label} {data.required ? <span className='required-span'>*</span> : ""}</label>
                                            {
                                                data?.className?.includes('price-only') || data?.className?.includes('number-only') ?
                                                    <input id={data?.name.replace('[]','')} type='text' value={blocks[selectedBlock]?.rooms[selectedRoom] && blocks[selectedBlock]?.rooms[selectedRoom][data.name] ? blocks[selectedBlock]?.rooms[selectedRoom][data.name] : ''} onChange={(e) => {blockDataSet(selectedBlock,data?.name,dotNumberFormat(e.target.value))}} className={'form-control '+(validationErrors.includes(data?.name) ? "error-border" : "")+' '+(allErrors.includes(data?.name.replace('[]','')) ? "error-border" : "")} />
                                                : 
                                                    <input id={data?.name.replace('[]','')} type='text' value={blocks[selectedBlock]?.rooms[selectedRoom] && blocks[selectedBlock]?.rooms[selectedRoom][data.name] ? blocks[selectedBlock]?.rooms[selectedRoom][data.name] : ''} onChange={(e) => {blockDataSet(selectedBlock,data?.name,e.target.value)}} className={'form-control '+(validationErrors.includes(data?.name) ? "error-border" : "")+' '+(allErrors.includes(data?.name.replace('[]','')) ? "error-border" : "")}/>
                                            }
                                        </div>
                                    )
                                }else if(data.type == "select"){
                                    return(
                                        <div className={"form-group "+(!(blocks[selectedBlock] && blocks[selectedBlock].rooms[selectedRoom] && blocks[selectedBlock].rooms[selectedRoom]['payment-plan[]'] && blocks[selectedBlock].rooms[selectedRoom]['payment-plan[]'].includes('taksitli')) && data.className.includes('second-payment-plan') ? "d-none" : "")}>
                                            <label className='font-bold' htmlFor="">{data.label} {data.required ? <span className='required-span'>*</span> : ""}</label>
                                            <select id={data?.name.replace('[]','')} name="" className={'form-control '+(validationErrors.includes(data?.name) ? "error-border" : "")+' '+(allErrors.includes(data?.name.replace('[]','')) ? "error-border" : "")} onChange={(e) => {blockDataSet(selectedBlock,data?.name,e.target.value)}} value={blocks[selectedBlock]?.rooms[selectedRoom] && blocks[selectedBlock]?.rooms[selectedRoom][data.name] ? blocks[selectedBlock]?.rooms[selectedRoom][data.name] : ''}>
                                                {
                                                    data.values.map(valueSelect => {
                                                        return(
                                                            <option value={valueSelect.value}>{valueSelect.label}</option>
                                                        )
                                                    })
                                                }
                                            </select>
                                        </div>
                                    )
                                }else if(data.type == "checkbox-group"){
                                    if(data.name == "payment-plan[]"){
                                        return(
                                            <div>
                                                <div>
                                                    <label className='mt-3 font-bold' htmlFor="">{data.label} {data.required ? <span className='required-span'>*</span> : ""}</label>
                                                    <div className="checkbox-groups" id={data?.name.replace('[]','')}>
                                                        <div className="row">
                                                            {
                                                                data.values.map((valueCheckbox) => {
                                                                    return (
                                                                        <div className="col-md-3">
                                                                            <FormControlLabel control={<Switch label={label} checked={blocks[selectedBlock]?.rooms[selectedRoom][data.name] && blocks[selectedBlock]?.rooms[selectedRoom] ? blocks[selectedBlock]?.rooms[selectedRoom][data.name].includes(valueCheckbox.value) : false} onChange={(e) => {blockCheckboxDataSet(selectedBlock,data?.name,valueCheckbox?.value,e)}} />} label={valueCheckbox.label} />
                                                                        </div>
                                                                    )
                                                                })
                                                            }
                                                            {
                                                                allErrors.includes(data?.name.replace('[]','')) ?
                                                                    <Alert severity="error">Harita üzerine bir konum seçin</Alert>
                                                                : ""
                                                            }
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className={"pay-decs mb-3 mt-3 "+(!(blocks[selectedBlock] && blocks[selectedBlock].rooms[selectedRoom] && blocks[selectedBlock].rooms[selectedRoom]['payment-plan[]'] && blocks[selectedBlock].rooms[selectedRoom]['payment-plan[]'].includes('taksitli')) ? "d-none" : "")}>
                                                    <label htmlFor="" className='font-bold'>Ödeme Planı</label>
                                                    <button className="btn btn-primary d-block" onClick={() => {setPayDecOpen(true)}}>Ödeme Planını Yönet ({blocks[selectedBlock]?.rooms[selectedRoom] ? blocks[selectedBlock]?.rooms[selectedRoom]?.payDecs?.length : 0})</button>
                                                </div>
                                            </div>
                                        )
                                    }else{
                                        return(
                                            <div>
                                                <label className='mt-3 font-bold' htmlFor="">{data.label} {data.required ? <span className='required-span'>*</span> : ""}</label>
                                                <div className="checkbox-groups">
                                                    <div className="row">
                                                        {
                                                            data.values.map((valueCheckbox) => {
                                                                return (
                                                                    <div className="col-md-3">
                                                                        <FormControlLabel control={<Checkbox checked={blocks[selectedBlock]?.rooms[selectedRoom][data.name] && blocks[selectedBlock]?.rooms[selectedRoom] ? blocks[selectedBlock]?.rooms[selectedRoom][data.name].includes(valueCheckbox.value) : false} onChange={(e) => {blockCheckboxDataSet(selectedBlock,data?.name,valueCheckbox?.value,e)}} />} label={valueCheckbox.label} />
                                                                    </div>
                                                                )
                                                            })
                                                        }
                                                    </div>
                                                </div>
                                            </div>
                                        )
                                    }
                                    
                                }else if(data.type == "file"){
                                    return (
                                        <div className='form-group'>
                                            <label className='font-bold' htmlFor="">{data.label} {data.required ? <span className='required-span'>*</span> : ""}</label>
                                            <input id={data?.name.replace('[]','')} accept="image/png, image/gif, image/jpeg" onChange={(event) => {changeFormImage(selectedBlock,data?.name,event)}} type='file' className={'form-control '+(validationErrors.includes(data?.name) ? "error-border" : "")+' '+(allErrors.includes(data?.name.replace('[]','')) ? "error-border" : "")}/>
                                            <div className='project_imaget'>
                                                <img src={blocks[selectedBlock]?.rooms[selectedRoom] && blocks[selectedBlock]?.rooms[selectedRoom][data.name+'_imagex'] ? blocks[selectedBlock]?.rooms[selectedRoom][data.name+'_imagex'] : ''} alt="" />
                                            </div>
                                        </div>
                                    )
                                }
                            }
                        })
                    }
                </div>
            </div>
            <RoomNavigator validationErrors={validationErrors} setValidationErrors={setValidationErrors} formData={formData} selectedBlock={selectedBlock} blocks={blocks} setBlocks={setBlocks} selectedRoom={selectedRoom} setSelectedRoom={setSelectedRoom}/>
            
            <PayDecModal open={payDecOpen} blocks={blocks} setBlocks={setBlocks} selectedBlock={selectedBlock} selectedRoom={selectedRoom} setOpen={setPayDecOpen}/>
        </div>
    )
}
export default Rooms