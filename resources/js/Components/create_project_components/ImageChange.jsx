import { Box, Modal } from '@mui/material';
import React from 'react'
function ImageChange({saveHousing,saveSingleHousing,open,setOpen,data,setData,selectedType,isDotType}) {
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
                        <div className="">
                            <h4>{selectedType} Güncelle</h4>
                            <div className="form-group">
                                <input type="file" name="" id="" onChange={(e) => {setData(e.target.files[0])}}/>
                            </div>
                        </div>
                    </div>

                    <button className='btn btn-primary mt-2' onClick={() => {saveSingleHousing();setOpen(false);}}>Seçilen Konuta Uygula</button>
                    <button className='btn btn-primary mt-2 mx-2' onClick={() => {saveHousing();setOpen(false);}}>Tüm Konutlara Uygula</button>
                </Box>
            </Modal>
        </div>
    )
}
export default ImageChange