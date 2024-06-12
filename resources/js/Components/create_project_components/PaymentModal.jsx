import React, { useEffect, useState } from 'react';
import {  Box, Modal, Typography } from '@mui/material';
import { baseUrl, dotNumberFormat } from '../../define/variables';
import { ReactSortable } from 'react-sortablejs';
import axios from 'axios';
import { toast } from 'react-toastify';

function PaymentModal({setSelectedId,open,setOpen,solds,selectedData,selectedId,projectId}) {
    const [installments,setInstallments] = useState([]);
    const [startDate,setStartDate] = useState("");
    const [startDateConfirm,setStartDateConfirm] = useState(false);
    const [saveLoading,setSaveLoading] = useState(false);
    const style = {
        position: 'absolute',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        width: "70%",
        bgcolor: 'background.paper',
        boxShadow: 24,
        p: 4,
        height: 'calc(100vh - 150px)',
        overflowY : 'scroll'
    }

    useEffect(() => {
        if(selectedId && projectId){
            axios.get(baseUrl+'get_installments/'+projectId+'/'+selectedId).then((res) =>{
                if(res.data.data){
                    setInstallments(res.data.data);
                    setStartDate(res.data.data[0].date);
                    setStartDateConfirm(true)
                }
               
            })
        }
    },[projectId,selectedId])

    const save = () => {
        setSaveLoading(true);
        axios.post(baseUrl+'save_installments/'+projectId+'/'+selectedId,{
            installments : installments
        }).then((res) => {
            setOpen(false);
            setInstallments([]);
            toast.success("Başarıyla taksitleri güncellediniz");
            setSelectedId(null)
            setSaveLoading(false);
        })
    }

    var installmentCount = selectedData && selectedData['installments[]'] ? parseInt(selectedData['installments[]']) : 0;

    const installmentsCreate = () => {
        var installmentsTemp = [];
        for(var i = 0 ; i < installmentCount; i++){
            var date = new Date(startDate);
            date.setMonth(date.getMonth() + i);
            let year = date.getFullYear();
            let month = String(date.getMonth() + 1).padStart(2, '0');
            let day = String(date.getDate()).padStart(2, '0');
            let formattedDate = `${year}-${month}-${day}`;
            if(!installments[i]){
                installmentsTemp.push({
                    price : getInstallmentMonthPrice().toFixed(0),
                    date : formattedDate,
                    payment_date : '',
                    is_payment : false,
                    paymentType : "Nakit"
                });
            }else{
                installmentsTemp.push(installments[i]);
            }
            
        }

        setInstallments(installmentsTemp);
    }

    useEffect(() => {
        installmentsCreate();
    },[selectedData,startDate])

    const getInstallmentMonthPrice = () => {
        var priceNotPayDecs = parseInt(selectedData['installments-price[]']) - parseInt(selectedData['advance[]']);
        var payDecPrice = 0;
        for(var i = 0; i < selectedData['pay-dec-count'+selectedId]; i++){
            payDecPrice += parseInt(selectedData['pay_desc_price'+selectedId+i].replace('.',''));
        }

        var lastPrice = priceNotPayDecs - payDecPrice;
        return lastPrice / selectedData['installments[]'];
    }

    const startDateConfirmFunc = () => {
        setStartDateConfirm(true);
    }

    const setPaymentType = (id,paymentStatus) => {
        var newInstallments = installments.map((installment,key) => {
            if(id == key){
                return {
                    ...installment,
                    is_payment : paymentStatus
                }
            }else{
                return installment
            }
        })

        setInstallments(newInstallments)
    }

    const setPaymentDate = (id,date) => {
        var newInstallments = installments.map((installment,key) => {
            if(id == key){
                return {
                    ...installment,
                    date : date
                }
            }else{
                return installment
            }
        })

        setInstallments(newInstallments)
    }

    const setPaymentPaymentDate = (id,date) => {
        var newInstallments = installments.map((installment,key) => {
            if(id == key){
                return {
                    ...installment,
                    payment_date : date
                }
            }else{
                return installment
            }
        })

        setInstallments(newInstallments)
    }

    const setPaymentMethod = (id,paymentType) => {
        var newInstallments = installments.map((installment,key) => {
            if(id == key){
                return {
                    ...installment,
                    paymentType : paymentType
                }
            }else{
                return installment
            }
        })
        console.log(newInstallments,id,paymentType);
        setInstallments(newInstallments)
    }

    console.log(installments)

    const setPaymentPrice = (id,price,type) => {
        if(type == "price"){
            var newInstallments = installments.map((installment,key) => {
                if(id == key){
                    return {
                        ...installment,
                        price : price,
                    }
                }else{
                    return installment
                }
            })
    
            setInstallments(newInstallments)
        }else{
            var newInstallments = installments.map((installment,key) => {
                if(id == key){
                    return {
                        ...installment,
                        description : price,
                    }
                }else{
                    return installment
                }
            })
    
            setInstallments(newInstallments)
        }
        
    }

    const setPaymentDescriptionx = (id,description) => {
        console.log(id,description)
    }

    const deleteInstallment = (id) => {
        var newInstallments = installments.filter((installment,key) => {
            if(id != key){
                return installment
            }
        })

        setInstallments(newInstallments)
    }

    return(
        <Modal
            open={open}
            onClose={() => {setOpen(false);setSelectedId(null)}}
            aria-labelledby="modal-modal-title"
            aria-describedby="modal-modal-description"
        >
            <Box sx={style}>
                <div style={{display:'flex',justifyContent:'space-between'}}>
                    <Typography variant="h4" gutterBottom>
                        Ödeme Planı
                    </Typography>
                    <button onClick={save} className='all_selected_button' > 
                        <i className='fa fa-lock mx-2'></i> 
                        <span>Kaydet</span> 
                        <div className={saveLoading ? "" : 'd-none'}>
                            <i className={'fa fa-spinner loading-icon ml-2'}></i>
                        </div>
                    </button>
                </div>   
                <div>
                    <div className="form-group">
                        <label htmlFor="">Taksit Başlangıç Tarihi</label>
                        <div className="input-with-save-button">
                            <input value={startDate} onChange={(e) => {setStartDate(e.target.value)}} type="date" className='form-control' />
                            <span onClick={() => {startDateConfirmFunc()}}><i className='fa fa-check'></i></span>    
                        </div>
                    </div>
                    <div className="installments">
                        <div className='d-flex'>
                            <h4 className='mb-0'>Taksitler ({installments.length})</h4>
                            <span className='add-button-payment' onClick={() => {setInstallments([...installments,{}])}}><i className='fa fa-plus'></i></span>
                        </div>
                        {
                            startDateConfirm ? 
                                <ReactSortable multiDrag swap list={installments} setList={setInstallments}>
                                    {
                                        installments.map((installment,i) => {
                                            return(
                                                <div key={i} className="row mb-2" style={{alignItems:'flex-end'}}>
                                                    <div className="col-md-1">
                                                        <div className="d-flex">
                                                            <span className='add-button-payment' style={{cursor:'pointer',display:'flex',justifyContent:'center',alignItems:'center'}}><i class="fa fa-arrows-up-down-left-right"></i></span>
                                                            <div className='add-button-payment mx-2'>
                                                                {i + 1}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div className="col-md-2">
                                                        <label htmlFor="">Fiyat</label>
                                                        <input type="text" onChange={(e) => {setPaymentPrice(i,e.target.value,'price')}} value={dotNumberFormat(installment.price)} className='form-control' />
                                                    </div>
                                                    <div className="col-md-2">
                                                        <label htmlFor="">Tarih</label>
                                                        <input type="date" onChange={(e) => {setPaymentDate(i,e.target.value)}} value={installment.date} className='form-control' />
                                                    </div>
                                                    <div className="col-md-2">
                                                        <label htmlFor="">Ödeme Tarihi</label>
                                                        <input type="date" onChange={(e) => {setPaymentPaymentDate(i,e.target.value)}} value={installment.payment_date} className='form-control' />
                                                    </div>
                                                    <div className="col-md-2">
                                                        <label htmlFor="">Ödeme Yöntemi</label>
                                                        <select value={installment.paymentType} onChange={(e) => {console.log(e.target.value); setPaymentMethod(i,e.target.value)}} name="" className='form-control' id="">
                                                            <option value="Nakit">Nakit</option>
                                                            <option value="Çek">Çek</option>
                                                            <option value="Kredi Kartı">Kredi Kartı</option>
                                                            <option value="Diğer">Diğer</option>
                                                        </select>
                                                    </div>
                                                    <div className="col-md-2">
                                                        <label htmlFor="">Açıklama</label>
                                                        <input type="text" onChange={(e) => {setPaymentPrice(i,e.target.value,'desc')}} value={installment.description} className='form-control' />
                                                    </div>
                                                    <div className="col-md-1">
                                                        <div className="d-flex">
                                                            {
                                                                installment.is_payment ? 
                                                                    <div onClick={() => {setPaymentType(i,false)}} className='add-button-payment mx-2' style={{cursor:'pointer'}}>
                                                                        <i className='fa fa-times'></i>
                                                                    </div>
                                                                : 
                                                                    <div onClick={() => {setPaymentType(i,true)}} className='confirm-button-payment mx-2' style={{cursor:'pointer'}}>
                                                                        <i className='fa fa-check'></i>
                                                                    </div>
                                                            }
                                                            
                                                            <span onClick={() => {deleteInstallment(i)}} className='add-button-payment'><i className='fa fa-minus'></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            )
                                        })
                                    }
                                </ReactSortable>
                                
                            : 
                                <div>
                                    <div className='alert alert-danger mt-3'>
                                        Taksit başlangıç tarihi girilmeden taksitleri listeleyemezsiniz
                                    </div>
                                </div>
                        }
                        
                    </div>    
                </div>             
            </Box>
        </Modal>
    )
}
export default PaymentModal