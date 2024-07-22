import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { baseUrl } from '../../define/variables';
import { toast } from 'react-toastify';

const SelectUser = ({open,setOpen,projectId,roomOrder}) => {
    const [loading,setLoading] = useState(false);
    const [subUsers,setSubUsers] = useState([]);
    const [saveLoading,setSaveLoading] = useState(false);
    const [selectedSubUsers,setSelectedSubUsers] = useState([]);
    useEffect(() => {
        if(open){
            setLoading(true);
            axios.get(baseUrl+'subUsers').then((res) => {
                setLoading(false);
                setSubUsers(res.data.data);
            })

            axios.get(baseUrl+'get_lockers/'+projectId+'/'+roomOrder).then((res) => {
                setSelectedSubUsers(res.data.data)
            })
        }
    },[open])
    
    console.log(selectedSubUsers);

    const save = () => {
        setSaveLoading(true);

        axios.post( baseUrl+'save_lockers/'+projectId+'/'+roomOrder,{
            "selected_subusers" : selectedSubUsers
        }).then((res) => {
            if(res.data.status){
                toast.success("Yetkili kişileri başarıyla güncellediniz")
                setOpen(false);
                setSaveLoading(false)
            }else{
                toast.error(res.data.message);
            }
        }).catch(e => {
            toast.error(e.getMessage())
        }) 
    }

    const setSelectedSubUsersFunc = (subUserId) => {
        if(selectedSubUsers.includes(subUserId)){
            var newSubUsers = selectedSubUsers.filter((selectedSubUser) => subUserId != selectedSubUser)
            setSelectedSubUsers(newSubUsers);
        }else{
            setSelectedSubUsers([
                ...selectedSubUsers,
                subUserId
            ])
        }
    }

    return(
        <div className={'payment-modal '+(open ? "" : "d-none")}>
            <div onClick={() => {setOpen(false)}} className='payment-modal-bg'></div>
            <div className="payment-modal-content">
                <div className="pop-up-top-gradient">
                    <div className="left">
                        <h3>Yetkili Kullanıcıları Seç</h3>
                    </div>
                    <div className="close" onClick={() => {setOpen(false)}}>
                        <span><i className='fa fa-times '></i></span>
                    </div>
                </div>
                <div className="payment-modal-area">
                    {
                        loading ? 
                            <div className="loading-area">
                                <i className='fa fa-spinner infinite-icon'></i>
                            </div>
                        : 
                            <div>
                                <div className="content-payment-modal p-2 scrollbar mt-2" id="style-2">
                                    <div className="payment-modal-section">
                                        {
                                            subUsers.map((subUser,index) => {
                                                return(
                                                    <div>
                                                        <label style={{display:'flex',cursor:'pointer',marginTop:'5px'}} htmlFor={'user'+index}><input checked={selectedSubUsers.includes(subUser.id)} onChange={() => {setSelectedSubUsersFunc(subUser.id)}} type="checkbox" name="" id={'user'+index} style={{marginRight:'5px'}} /> {subUser.name}</label>
                                                    </div>
                                                )
                                            })
                                        }
                                    </div>
                                </div>
                                <div className="modal-footer">
                                    <div>
                                        <div className="payment-modal-section d-flex">
                                            <button onClick={save} className='all_selected_button' > 
                                                <i className='fa fa-save mx-2'></i> 
                                                <span>Kaydet</span> 
                                                <div className={saveLoading ? "" : 'd-none'}>
                                                    <i className={'fa fa-spinner loading-icon ml-2'}></i>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    }
                </div>
            </div>
            
         </div>
    )
}

export default SelectUser;