import React, { useState } from 'react'
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';
import Modal from '@mui/material/Modal';
import { dotNumberFormat } from '../../define/variables';
import { Checkbox, FormControlLabel, Switch } from '@mui/material';
import RoomNavigator from './RoomNavigator';
import PayDecModal from './PayDecModal';
function BlockRooms({blocks,setBlocks,roomCount,setRoomCount,selectedHousingType}) {
    const [open,setOpen] = useState(false);
    const [validationErrors,setValidationErrors] = useState([]);
    const [blockName,setBlockName] = useState("");
    const [selectedBlock,setSelectedBlock] = useState(null);
    const [selectedRoom,setSelectedRoom] = useState(0);
    const [payDecOpen,setPayDecOpen] = useState(false);
    var formData = JSON.parse(selectedHousingType?.housing_type?.form_json);
    const [rendered,setRendered] = useState(0);
    const style = {
        position: 'absolute',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        width: 400,
        bgcolor: 'background.paper',
        boxShadow: 24,
        p: 4,
    };

    


    const addBlock = () => {
        setSelectedBlock(blocks.length)
        setBlocks([
            ...blocks,
            {
                name : blockName,
                roomCount : roomCount,
                rooms : [
                    {}
                ]
            }
        ]);

        setBlockName("");
        setRoomCount(0);
        setOpen(false);
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
        <div className='card p-3 mt-3' style={{position:'relative'}}>
            <div>
                <h6 className='block-title'>Bloklar</h6>
                <div className="add-new-block" onClick={() => {setOpen(true)}}>
                    <i className='fa fa-plus'></i>
                </div>
                <div className="block-list row mt-3">
                    {
                        blocks.map((block,key) => {
                            return(
                                <div onClick={() => {setSelectedBlock(key);setSelectedRoom(0)}} class={"block "+(key == selectedBlock ? "active" : "")}>
                                    {block.name}
                                    <div class="remove-block">Sil</div>
                                </div>
                            )
                        })
                    }
                    
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
                                                    <input type='text' value={blocks[selectedBlock]?.rooms[selectedRoom] && blocks[selectedBlock]?.rooms[selectedRoom][data.name] ? blocks[selectedBlock]?.rooms[selectedRoom][data.name] : ''} onChange={(e) => {blockDataSet(selectedBlock,data?.name,dotNumberFormat(e.target.value))}} className={'form-control '+(validationErrors.includes(data?.name) ? "error-border" : "")} />
                                                : 
                                                    <input type='text' value={blocks[selectedBlock]?.rooms[selectedRoom] && blocks[selectedBlock]?.rooms[selectedRoom][data.name] ? blocks[selectedBlock]?.rooms[selectedRoom][data.name] : ''} onChange={(e) => {blockDataSet(selectedBlock,data?.name,e.target.value)}} className={'form-control '+(validationErrors.includes(data?.name) ? "error-border" : "")}/>
                                            }
                                        </div>
                                    )
                                }else if(data.type == "select"){
                                    return(
                                        <div className={"form-group "+(!(blocks[selectedBlock] && blocks[selectedBlock].rooms[selectedRoom] && blocks[selectedBlock].rooms[selectedRoom]['payment-plan[]'] && blocks[selectedBlock].rooms[selectedRoom]['payment-plan[]'].includes('taksitli')) && data.className.includes('second-payment-plan') ? "d-none" : "")}>
                                            <label className='font-bold' htmlFor="">{data.label} {data.required ? <span className='required-span'>*</span> : ""}</label>
                                            <select name="" className={'form-control '+(validationErrors.includes(data?.name) ? "error-border" : "")} onChange={(e) => {blockDataSet(selectedBlock,data?.name,e.target.value)}} value={blocks[selectedBlock]?.rooms[selectedRoom] && blocks[selectedBlock]?.rooms[selectedRoom][data.name] ? blocks[selectedBlock]?.rooms[selectedRoom][data.name] : ''} id="">
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
                                                    <div className="checkbox-groups">
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
                                            <input accept="image/png, image/gif, image/jpeg" onChange={(event) => {changeFormImage(selectedBlock,data?.name,event)}} type='file' className={'form-control '+(validationErrors.includes(data?.name) ? "error-border" : "")}/>
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
            <Modal
                open={open}
                onClose={() => {setOpen(false)}}
                aria-labelledby="modal-modal-title"
                aria-describedby="modal-modal-description"
            >
                <Box sx={style}>
                    <div className="form-group">
                        <label htmlFor="">Blok Adı</label>
                        <input type="text" value={blockName} onChange={(e) => {setBlockName(e.target.value)}} className='form-control' />
                    </div>
                    <div className="form-group">
                        <label htmlFor="">Bu Blokta Kaç Tane Konut Var</label>
                        <input type="text" value={roomCount} onChange={(e) => {setRoomCount(e.target.value)}} className='form-control' />
                    </div>
                    <div className="form-group">
                        <button class="btn btn-success confirm-button-block" onClick={addBlock}>Bloğu Ekle</button>
                    </div>
                </Box>
            </Modal>

            <PayDecModal open={payDecOpen} blocks={blocks} setBlocks={setBlocks} selectedBlock={selectedBlock} selectedRoom={selectedRoom} setOpen={setPayDecOpen}/>
        </div>
    )
}
export default BlockRooms