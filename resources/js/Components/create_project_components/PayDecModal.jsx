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
        if(blocks[selectedBlock]?.rooms[selectedRoom] && !blocks[selectedBlock]?.rooms[selectedRoom]['payDecs']){
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
        <div className={'payment-modal '+(open ? "" : "d-none")}>
            <div onClick={() => {setOpen(false)}} className='payment-modal-bg'></div>
            <div className="payment-modal-content">
                <div className="pop-up-top-gradient">
                    <div className="left">
                    <h3>Ara Ödeme Ekle ve Düzenle</h3>
                    </div>
                    <div className="close" onClick={() => {setOpen(false)}}>
                        <span><i className='fa fa-times '></i></span>
                    </div>
                </div>
                <div className="payment-modal-area">
                    <div className="payment-modal-section">
                        <div className="pay-dec-modal-top">
                            <button className="add-pay-dec" onClick={newPayDec}><i className="fa fa-plus mr-2"></i> Ara Ödeme Ekle</button>
                            <div>
                                <button className='update-pay-dec-selected' onClick={() => {savePayDecs();}}>Kaydet</button>
                            </div>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th style={{paddingLeft:'15px'}}>#</th>
                                    <th>Ara Ödeme Tutarı</th>
                                    <th>Ara Ödeme Tarihi</th>
                                    <th style={{textAlign:'center'}}></th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    blocks[selectedBlock]?.rooms[selectedRoom]?.payDecs?.map((payDec,payDecIndexLo) => {
                                        return(
                                            <tr>
                                                <td style={{paddingLeft:'15px'}}>{payDecIndexLo+1}</td>
                                                <td>
                                                    <input type="text" onChange={(e) => {changePayDecData(payDecIndexLo,'price',dotNumberFormat(e.target.value))}}  className="form-control" value={dotNumberFormat(payDec.price)} />
                                                </td>
                                                <td>
                                                    <input type="date" onChange={(e) => {changePayDecData(payDecIndexLo,'date',e.target.value)}} className="form-control" value={payDec.date} />
                                                </td>
                                                <td>
                                                    <span onClick={() => {removePayDec(payDecIndexLo)}} className='installment-remove-button'>
                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M19 9H22M19 14H22M19 19H21M16 6L15.1991 18.0129C15.129 19.065 15.0939 19.5911 14.8667 19.99C14.6666 20.3412 14.3648 20.6235 14.0011 20.7998C13.588 21 13.0607 21 12.0062 21H7.99377C6.93927 21 6.41202 21 5.99889 20.7998C5.63517 20.6235 5.33339 20.3412 5.13332 19.99C4.90607 19.5911 4.871 19.065 4.80086 18.0129L4 6M2 6H18M14 6L13.7294 5.18807C13.4671 4.40125 13.3359 4.00784 13.0927 3.71698C12.8779 3.46013 12.6021 3.26132 12.2905 3.13878C11.9376 3 11.523 3 10.6936 3H9.30643C8.47705 3 8.06236 3 7.70951 3.13878C7.39792 3.26132 7.12208 3.46013 6.90729 3.71698C6.66405 4.00784 6.53292 4.40125 6.27064 5.18807L6 6M12 10V17M8 10L7.99995 16.9998" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </svg>
                                                    </span>
                                                </td>
                                            </tr>
                                        ) 
                                    })
                                }
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    )
}
export default PayDecModal