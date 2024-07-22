import { Box, Modal } from '@mui/material';
import React from 'react'
import FileUploadV2 from '../main_components/FileUploadV2';
function ImageChange({saveHousing,saveSingleHousing,open,setOpen,setData}) {
    return(
        <div className={'payment-modal '+(open ? "" : "d-none")}>
            <div onClick={() => {setOpen(false)}} className='payment-modal-bg'></div>
            <div className="payment-modal-content" style={{width:'25%'}}>
                <div className="pop-up-top-gradient">
                    <div className="left">
                        <h3>Resimi Güncelle</h3>
                    </div>
                    <div className="close" onClick={() => {setOpen(false)}}>
                        <span><i className='fa fa-times '></i></span>
                    </div>
                </div>
                <div className="payment-modal-area">
                    <div className="payment-modal-section">
                        <div className="pay-dec-modal-top" style={{justifyContent:'center'}}>
                            <div>
                                <button className='update-pay-dec-selected' onClick={() => {saveSingleHousing();setOpen(false);}}>Seçilen Konuta Uygula</button>
                                <button className='update-pay-dec-all' onClick={() => {saveHousing();setOpen(false);}}>Tüm Konutlara Uygula</button>
                            </div>
                        </div>
                        <div className="dec-pay-area">
                            <div className="">
                                <div className="form-group">
                                    <FileUploadV2 open={open} setData={setData}/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
export default ImageChange