import { Box, Modal } from '@mui/material'
import React, { useEffect } from 'react'
import { dotNumberFormat } from '../../define/variables';
import { toast } from 'react-toastify';
function PayDecModal({open,setOpen,blocks,setBlocks,selectedBlock,selectedRoom}) {
    const style = {
        position: 'absolute',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        width: "70%",
        bgcolor: 'background.paper',
        boxShadow: 24,
        p: 4,
    };

    useEffect(() => {
        if(!blocks[selectedBlock]?.rooms[selectedRoom]['payDecs']){
            blockDataSet(selectedBlock,"payDecs",[])
        }
    },[selectedBlock,selectedRoom])

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

        setBlocks(newDatas);
    }

    const changePayDecData = (payDecIndex,keyx,value) => {
        var newDatas = blocks.map((block,key) => {
            if(selectedBlock == key){
                var newData2 = block.rooms.map((room,keyRoom) => {
                    if(keyRoom == selectedRoom){
                        var payDecsTemp = room.payDecs.map((payDec,payDecIndexLoop) => {
                            if(payDecIndexLoop == payDecIndex){
                                return {
                                    ...payDec,
                                    [keyx] : value
                                }
                            }else{  
                                return payDec;
                            }
                        })

                        return {
                            ...room,
                            payDecs : payDecsTemp
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
    }

    const removePayDec = (payDecIndex) => {
        var newDatas = blocks.map((block,key) => {
            if(selectedBlock == key){
                var newData2 = block.rooms.map((room,keyRoom) => {
                    if(keyRoom == selectedRoom){
                        var payDecsTemp = room.payDecs.filter((payDec,payDecIndexLoop) => {
                            if(payDecIndexLoop != payDecIndex){
                                return payDec;
                            }
                        })
                        return {
                            ...room,
                            payDecs : payDecsTemp
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
    }

    const newPayDec = () => {
        var newDatas = blocks.map((block,key) => {
            if(selectedBlock == key){
                var newData2 = block.rooms.map((room,keyRoom) => {
                    if(keyRoom == selectedRoom){
                        return {
                            ...room,
                            payDecs : [
                                ...room.payDecs,
                                {
                                    price : '',
                                    date : ''
                                }
                            ]
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
    }

    const savePayDecs = () => {
        var error = false;

        blocks[selectedBlock].rooms[selectedRoom].payDecs.map(payDec => {
            if(payDec.price == ""){
                error = true;
            }

            if(payDec.date == ""){
                error = true;
            }
        })

        if(error){
            toast.error("Arama ödemeler tamamen doldurulmalıdır");
        }else{
            setOpen(false);
        }
    }

    const removeNonFull = () => {
        var tempPayDecs = [];

        blocks[selectedBlock].rooms[selectedRoom].payDecs.map(payDec => {
            if(payDec.price != "" && payDec.date != ""){
                tempPayDecs.push(payDec);
            }
        })

        var newDatas = blocks.map((block,key) => {
            if(selectedBlock == key){
                var newData2 = block.rooms.map((room,keyRoom) => {
                    if(keyRoom == selectedRoom){
                        return {
                            ...room,
                            payDecs : tempPayDecs
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
        setOpen(false);
    }


    return(
        <div>
            <Modal
                open={open}
                onClose={() => {removeNonFull();}}
                aria-labelledby="modal-modal-title"
                aria-describedby="modal-modal-description"
            >
                <Box sx={style}>
                    <div className="dec-pay-area">
                        <div className="top">
                            <h4>Ara Ödemeler</h4>
                            <button className="btn btn-primary add-pay-dec" onClick={newPayDec}><i className="fa fa-plus"></i></button>
                        </div>
                        <div className="pay-desc">
                            {
                                blocks[selectedBlock]?.rooms[selectedRoom]?.payDecs?.map((payDec,payDecIndexLo) => {
                                    return(
                                        <div className="pay-desc-item">
                                            <div className="row" style={{alignItems:'flex-end'}}>
                                                <div className="flex-1">
                                                    <button onClick={() => {removePayDec(payDecIndexLo)}} className="btn btn-primary remove-pay-dec"><i className="fa fa-trash"></i></button>
                                                </div>
                                                <div className="flex-10">
                                                    <label for=""><strong>{payDecIndexLo + 1}. Ara Ödeme</strong> </label>
                                                    <input onChange={(e) => {changePayDecData(payDecIndexLo,'price',dotNumberFormat(e.target.value))}} type="text" value={payDec.price} className="form-control"/>
                                                </div>
                                                <div className="flex-10">
                                                    <label for=""><strong>{payDecIndexLo + 1}. Ara Ödeme Tarihi</strong></label>
                                                    <input onChange={(e) => {changePayDecData(payDecIndexLo,'date',e.target.value)}} type="date" value={payDec.date} className="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    ) 
                                })
                            }
                            
                        </div>
                    </div>

                    <button className='btn btn-primary mt-2' onClick={() => {savePayDecs()}}>Kaydet</button>
                </Box>
            </Modal>
        </div>
    )
}
export default PayDecModal