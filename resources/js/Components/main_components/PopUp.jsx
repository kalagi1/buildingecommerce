import React from 'react';

const PopUp = ({children,open,setOpen,style}) => {
    return(
        <div className={'confirm-modal '+(open ? "" : "d-none")}>
            <div onClick={() => {setOpen(false)}} className='confirm-modal-bg'></div>
            <div className="confirm-modal-content" style={style}>
                <div className="confirm-modal-area">
                    {
                        children
                    }
                </div>
            </div>
        
        </div>
    )
}

export default PopUp