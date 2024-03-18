import React, { useState } from 'react'
import { dotNumberFormat } from '../../define/variables'
import { Box, Modal } from '@mui/material'
function UpdateHousingModal({saveHousing,open,setOpen,data,setData,selectedType,isDotType}) {
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
                                <input type="text" className='form-control' value={data} onChange={(e) => {isDotType ? setData(dotNumberFormat(e.target.value)) : setData(e.target.value)}} />
                            </div>
                        </div>
                    </div>

                    <button className='btn btn-primary mt-2' onClick={() => {saveHousing();setOpen(false);}}>Kaydet</button>
                </Box>
            </Modal>
        </div>
    )
}
export default UpdateHousingModal