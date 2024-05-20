import { Box, Modal } from '@mui/material'
import React from 'react'
import { dotNumberFormat } from '../../define/variables'
function PayDecTable({savePayDecsSingle,saveHousing,open,setOpen,setData,data,saveSelectedHousing}) {
    
    const newPayDec = () => {
        setData([
            ...data,
            {
                price : '',
                date : ''
            }
        ])
    }

    const changePayDecData = (payDecIndex,keyx,value) => {
        var newDatas = data.map((payDec,payDecIndexLoop) => {
            if(payDecIndexLoop == payDecIndex){
                return {
                    ...payDec,
                    [keyx] : value
                }
            }else{  
                return payDec;
            }
        })

        setData(newDatas);
    }

    const removePayDec = (payDecIndex) => {
        var newData = data.filter((payDec,payDecIndexLoop) => {
            if(payDecIndexLoop != payDecIndex){
                return payDec;
            }
        })
        

        setData(newData);
    }


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
    return(
        <div>
            <Modal
                open={open}
                onClose={() => {setOpen(false)}}
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
                                data?.map((payDec,payDecIndexLo) => {
                                    return(
                                        <div className="pay-desc-item">
                                            <div className="row" style={{alignItems:'flex-end'}}>
                                                <div className="flex-1">
                                                    <button onClick={() => {removePayDec(payDecIndexLo)}} className="btn btn-primary remove-pay-dec"><i className="fa fa-trash"></i></button>
                                                </div>
                                                <div className="flex-10">
                                                    <label for="">Ara Ödeme </label>
                                                    <input onChange={(e) => {changePayDecData(payDecIndexLo,'price',dotNumberFormat(e.target.value))}} type="text" value={payDec.price} className="form-control"/>
                                                </div>
                                                <div className="flex-10">
                                                    <label for="">Ara Ödeme Tarihi</label>
                                                    <input onChange={(e) => {changePayDecData(payDecIndexLo,'date',e.target.value)}} type="date" value={payDec.date} className="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    ) 
                                })
                            }
                            
                        </div>
                    </div>

                    <button className='btn btn-primary mt-2' onClick={() => {savePayDecsSingle();setOpen(false);}}>Seçilen Konuta Uygula</button>
                    <button className='btn btn-primary mt-2 mx-1' onClick={() => {saveHousing();setOpen(false);}}>Tüm Konutlara Uygula</button>
                </Box>
            </Modal>
        </div>
    )
}
export default PayDecTable