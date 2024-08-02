import React, { useEffect, useState } from 'react';
import { Container, Grid, TextField, Typography, Button, MenuItem, Box, Select, InputLabel, FormControl , Modal, Switch, FormControlLabel } from '@mui/material';
import { baseUrl, dotNumberFormat } from '../../define/variables';
import { ReactSortable } from 'react-sortablejs';
import axios from 'axios';
import { toast, ToastContainer } from 'react-toastify';
import SelectUser from './SelectUser';
import PopUp from '../main_components/PopUp';

function PaymentModal({setSelectedId,open,setOpen,loading,setLoading,selectedData,selectedId,projectId,getLastCount,datat,roomOrder,reloadData}) {
    const [installments,setInstallments] = useState([]);
    const [startDate,setStartDate] = useState("");
    const [startDateConfirm,setStartDateConfirm] = useState(false);
    const [saveLoading,setSaveLoading] = useState(false);
    const [data, setData] = React.useState({});
    const [isShow,setIsShow] = useState(false);
    const [locked,setLocked] = useState(false);
    const [selectUserOpen,setSelectUserOpen] = useState(false);
    const [lockConfirm,setLockConfirm] = useState(false);
    const [lockedLoading,setLockedLoading] = useState(false);
    const [isManager,setIsManager] = useState(false);
    
    var months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];

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

    const save = () => {
        setSaveLoading(true);
        axios.post(baseUrl + 'save_installments/' + projectId + '/' + selectedId, {
            installments: installments
        }).then((res) => {
            console.log('save_installments'+res.data.data)
            if (res.data.status) { // Backend'in başarılı yanıt verdiğinden emin olun
                setInstallments(res.data.installments); // Güncellenmiş verileri kullanın
                // setOpen(false);
                toast.success("Başarıyla taksitleri güncellediniz");
                setSelectedId(null);
                // setSaveLoading(false);
            } else {
                toast.error("Taksitler güncellenemedi");
                setSaveLoading(false);
            }
        }).catch((err) => {
            console.error("Error saving installments:", err);
            toast.error("Taksitler güncellenemedi");
            setSaveLoading(false);
        });

        axios.post(baseUrl+'save_sale/'+projectId,{
            ...data,
            room_order : getLastCount() + roomOrder
        }).then((res) => {
            // console.log('save_sale'+res.data.data)
            if(res.data.status){
                // setLoading(false);
                setSaveLoading(false);

                toast.success("Başarıyla satış bilgilerini güncellediniz");
                setOpen(false);
                reloadData();
            }
        })
    }
    
    useEffect(() => {
        if (open && selectedId) {
            setInstallments([]); // Yeni veri yüklemeden önce eski verileri temizleyin
            setStartDate(""); // Başlangıç tarihini temizleyin
            setStartDateConfirm(false);
            axios.get(baseUrl + 'get_installments/' + projectId + '/' + selectedId).then((res) => {
                setInstallments(res.data.data);
                setStartDate(res.data.data[0].date);
                setStartDateConfirm(true);
            }).catch((err) => {
                console.error("Error fetching installments:", err);
                setLoading(false); // End loading    
            });

            axios.get(baseUrl+'get_lockeds?item_id='+(projectId+'-'+selectedId)+'&transaction=1').then((res) => {
                setIsShow(res.data.show)
                setLoading(false); // End loading    
            })

            axios.get(baseUrl+'get_user_locked_information/'+projectId+'/'+selectedId).then((res) => {
                setIsManager(res.data.is_manager)
                setLocked(res.data.is_locked)
                setLoading(false); // End loading    
                console.log(res);
            })
        }
    }, [projectId, selectedId, open]);    

    var installmentCount = selectedData && selectedData['installments[]'] ? parseInt(selectedData['installments[]']) : 0;

    const installmentsCreate = () => {
        if(!selectedData){
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
        setInstallments(newInstallments)
    }

    // const setPaymentMethod = (index, value) => {
    //     const updatedInstallments = [...installments];
    //     updatedInstallments[index].paymentType = value;
    //     setInstallments(updatedInstallments);
    // };
    

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

    const deleteInstallment = (id) => {
        var newInstallments = installments.filter((installment,key) => {
            if(id != key){
                return installment
            }
        })
        

        setInstallments(newInstallments)
    }

    

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setData({ ...data, [name]: value });
    };

    useEffect(() => {
        if(datat?.name){
            setData(datat)
        }
    },[datat])


    const addPayDec = () => {
        setData({
            ...data,
            pay_decs : [
                ...data.pay_decs,
                {}
            ]
        })
    }

    const removePayDec = (index) => {
        const newPayDecs = data.pay_decs.filter((payDec,payDecIndex) => {
            return index != payDecIndex
        })

        setData({
            ...data,
            pay_decs : newPayDecs
        })
    }


    const setPayDecPrice = (index,value) => {
        var newData = data.pay_decs.map((payDec,i) => {
            if(i == index){
                return {
                    ...payDec,
                    price : value
                }
            }else{
                return payDec
            }
        })

        setData({
            ...data,
            pay_decs : newData
        })
    }

    const setPayDecDate = (index,value) => {
        var newData = data.pay_decs.map((payDec,i) => {
            if(i == index){
                return {
                    ...payDec,
                    date : value
                }
            }else{
                return payDec
            }
        })

        setData({
            ...data,
            pay_decs : newData
        })
    }

    const setPayDecDescription = (index,value) => {
        var newData = data.pay_decs.map((payDec,i) => {
            if(i == index){
                return {
                    ...payDec,
                    description : value
                }
            }else{
                return payDec
            }
        })

        setData({
            ...data,
            pay_decs : newData
        })
    }

    const setPayDecStatus = (index,value) => {
        var newData = data.pay_decs.map((payDec,i) => {
            if(i == index){
                return {
                    ...payDec,
                    status : value
                }
            }else{
                return payDec
            }
        })

        setData({
            ...data,
            pay_decs : newData
        })
    }

    const lockedFunc = () => {
        setLockConfirm(true);
    }

    var lastChangeDate = new Date(data?.changer?.created_at);

    const openLockersFunc = () => {
        if(locked){
            toast.error("Yetkili kullanıcılar seçmek için kilitleyi kapatınız")
        }else{
            setSelectUserOpen(true)
        }
    }

    const lockedUpdate = () => {
        setLockedLoading(!lockedLoading);

        axios.post(baseUrl+'update_locked/'+projectId+'/'+roomOrder,{
            "is_locked" : !locked
        }).then((res) => {
            if(res.data.status){
                setLocked(!locked)
                setLockConfirm(false);
                setLockedLoading(false);
            }
        })
    }

    const copyInstallment = (itemOrder) => {
        var installment = installments.find((item,order) => itemOrder == order);

        setInstallments([
            ...installments,
            installment
        ])
    }

    return(
        <>
            <div className={'payment-modal '+(open ? "" : "d-none")}>
                <div onClick={() => {setOpen(false)}} className='payment-modal-bg'></div>
                <div className="payment-modal-content">
                    <div className="pop-up-top-gradient">
                        <div className="left">
                            <h3>Ödeme Planı ve Alıcı Bilgileri</h3>
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
                                isShow ? 
                                    <div className="content-payment-modal p-2 scrollbar" id="style-2">
                                        <div className="payment-modal-section">
                                            <h2>Alıcı Bilgileri</h2>
                                            <div className="row">
                                                <div className="col-md-4">
                                                    <div className="form-group">
                                                        <label htmlFor="">Alıcı Adı</label>
                                                        <input value={data.name} name='name' onChange={handleInputChange} type="text" className='form-control' />
                                                    </div>
                                                </div>
                                                <div className="col-md-4">
                                                    <div className="form-group">
                                                        <label htmlFor="">E-mail</label>
                                                        <input value={data.email} name='email' onChange={handleInputChange} type="text" className='form-control' />
                                                    </div>
                                                </div>
                                                <div className="col-md-4">
                                                    <div className="form-group">
                                                        <label htmlFor="">Telefon</label>
                                                        <input value={data.phone} name='phone' onChange={handleInputChange} type="text" className='form-control' />
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="row">
                                                <div className="col-md-4">
                                                    <div className="form-group">
                                                        <label htmlFor="">Tapu Devir Tarihi</label>
                                                        <input value={data.title_deed_date} name='title_deed_date' onChange={handleInputChange} type="date" className='form-control' />
                                                    </div>
                                                </div>
                                                <div className="col-md-4">
                                                    <div className="form-group">
                                                        <label htmlFor="">Sözleşme Tarihi</label>
                                                        <input value={data.agreement_date} name='agreement_date' onChange={handleInputChange} type="date" className='form-control' />
                                                    </div>
                                                </div>
                                                <div className="col-md-4">
                                                    <div className="form-group">
                                                        <label htmlFor="">Sözleşme İlan No</label>
                                                        <input value={data.agreement_no} name='agreement_no' onChange={handleInputChange} type="text" className='form-control' />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="payment-modal-section">
                                            <h2>Satın Alma Bilgileri</h2>
                                            <div className="row">
                                                <div className="col-md-4">
                                                    <div className="form-group">
                                                        <label htmlFor="">Satın Alma Şekli</label>
                                                        <select value={data.sale_type} name='sale_type' onChange={handleInputChange} className='form-control' id="">
                                                            <option value="1">Peşin Satış</option>
                                                            <option value="2">Taksitli Satış</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div className="col-md-4">
                                                    <div className="form-group">
                                                        <label htmlFor="">Toplam Satış Fiyatı</label>
                                                        <input value={dotNumberFormat(data.price)} name='price' onChange={handleInputChange} type="text" className='form-control' />
                                                    </div>
                                                </div>
                                                {
                                                    data.sale_type == 2 ? 
                                                        <>
                                                            <div className="col-md-4">
                                                                <div className="form-group">
                                                                    <label htmlFor="">Taksit Sayısı</label>
                                                                    <input type="text" name="installments" value={data.installments} onChange={handleInputChange} className='form-control' />
                                                                </div>
                                                            </div>
                                                        </>
                                                    : ''
                                                }
                                            </div>
                                        </div>

                                        <div className="payment-modal-section">
                                            <div className="form-section" id='down-payment'>
                                                <h2>Ödeme Bilgileri</h2>
                                                <div className="row">
                                                    <div className="col-md-2">
                                                        <div className="form-group">
                                                            <label htmlFor="">Kapora Ödendi</label>
                                                            <div>
                                                                <FormControlLabel control={<Switch checked={data.down_payment} onChange={() => {setData({...data,down_payment : !data.down_payment})}} />} label="Evet" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div className="col-md-10">
                                                        <div className="row">
                                                            <div className="col-md-4">
                                                                <div className="form-group">
                                                                    <label htmlFor="">Kapora Tutarı</label>
                                                                    <input type="text" name="down_payment_price" value={dotNumberFormat(data.down_payment_price)} onChange={handleInputChange} className='form-control' />
                                                                </div>
                                                            </div>
                                                            <div className="col-md-4">
                                                                <div className="form-group">
                                                                    <label htmlFor="">Kapora Ödenme Tarihi</label>
                                                                    <input type="date" name="deposit_date" value={data.deposit_date} onChange={handleInputChange} className='form-control' />
                                                                </div>
                                                            </div>
                                                            <div className="col-md-4">
                                                                <div className="form-group">
                                                                    <label htmlFor="">Kapora Açıklaması</label>
                                                                    <input type="text" name="down_payment_price_description" value={data.down_payment_price_description} onChange={handleInputChange} className='form-control' />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {
                                                data.sale_type == 2 ? 
                                                    <div className="form-section" id='advance-sc'>
                                                        <div className="row">
                                                            <div className="col-md-2">
                                                                <div className="form-group">
                                                                    <label htmlFor="">Peşinat Ödendi</label>
                                                                    <div>
                                                                        <FormControlLabel control={<Switch onChange={() => {setData({...data,advance_payment : !data.advance_payment})}} checked={data.advance_payment} />} label="Evet" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className="col-md-10">
                                                                <div className="row">
                                                                    <div className="col-md-4">
                                                                        <div className="form-group">
                                                                            <label htmlFor="">Peşinat Tutarı</label>
                                                                            <input type="text" name="advance"value={dotNumberFormat(data.advance)} onChange={handleInputChange} className='form-control' />
                                                                        </div>
                                                                    </div>
                                                                    <div className="col-md-4">
                                                                        <div className="form-group">
                                                                            <label htmlFor="">Peşinat Ödenme Tarihi</label>
                                                                            <input type="date" label="Peşinat Ödenme Tarihi" name="advance_date" onChange={handleInputChange} value={data.advance_date} className='form-control' />
                                                                        </div>
                                                                    </div>
                                                                    <div className="col-md-4">
                                                                        <div className="form-group">
                                                                            <label htmlFor="">Peşinat Açıklaması</label>
                                                                            <input type="text" label="Peşinat Açıklaması" name="advance_date_description" onChange={handleInputChange} value={data.advance_date_description} className='form-control' />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                : ''
                                            }
                                        </div>
                                        
                                        
                                        {
                                            data.sale_type == 2 ? 
                                                <div className="payment-modal-section">
                                                    <h2>Ara Ödeme Bilgileri</h2>
                                                    <div className="form-section" id='pay-decs'>
                                                        <div className="dec-pay-area">
                                                            <div className="pay-desc">
                                                                <table>
                                                                    <thead>
                                                                        <tr>
                                                                            <th style={{paddingLeft:'15px'}}>#</th>
                                                                            <th>Ara Ödeme Tutarı</th>
                                                                            <th>Ara Ödeme Tarihi</th>
                                                                            <th>Ara Ödeme Açıklaması</th>
                                                                            <th style={{textAlign:'center'}}>Ara Ödeme Durumu</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        {
                                                                            data?.pay_decs?.map((payDec,i) => {
                                                                                return(
                                                                                    <tr className={payDec.status ? "payment-bg" : "not-payment-bg"}>
                                                                                        <td style={{paddingLeft:'15px'}}>{i+1}</td>
                                                                                        <td>
                                                                                            <input type="text" className="form-control" onChange={(e) => {setPayDecPrice(i,e.target.value)}} value={dotNumberFormat(payDec.price)} />
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="date" className="form-control" onChange={(e) => {setPayDecDate(i,e.target.value)}} value={payDec.date} />
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="text" className="form-control" onChange={(e) => {setPayDecDescription(i,e.target.value)}} value={payDec.description} />
                                                                                        </td>
                                                                                        <td style={{textAlign:'center'}}>
                                                                                            {
                                                                                                payDec.status ? 
                                                                                                    <div onClick={() => {setPayDecStatus(i,false)}} className='add-button-payment mx-2'>
                                                                                                        <svg width="800px" height="800px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#0FA958" stroke-width="0.0002"> <g id="SVGRepo_bgCarrier" stroke-width="0"/> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/> <g id="SVGRepo_iconCarrier"> <path fill="#000000" fill-rule="evenodd" d="M3 10a7 7 0 019.307-6.611 1 1 0 00.658-1.889 9 9 0 105.98 7.501 1 1 0 00-1.988.22A7 7 0 113 10zm14.75-5.338a1 1 0 00-1.5-1.324l-6.435 7.28-3.183-2.593a1 1 0 00-1.264 1.55l3.929 3.2a1 1 0 001.38-.113l7.072-8z"/> </g> </svg>
                                                                                                    </div>
                                                                                                : 
                                                                                                    <div onClick={() => {setPayDecStatus(i,true)}} className='confirm-button-payment mx-2'>
                                                                                                        <svg viewBox="0 0 24 24" fill="#EC2F2E" xmlns="http://www.w3.org/2000/svg"> <path d="M12 21C10.22 21 8.47991 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89472 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17294C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36628 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C21 14.387 20.0518 16.6761 18.364 18.364C16.6761 20.0518 14.387 21 12 21ZM12 4.5C10.5166 4.5 9.0666 4.93987 7.83323 5.76398C6.59986 6.58809 5.63856 7.75943 5.07091 9.12988C4.50325 10.5003 4.35473 12.0083 4.64411 13.4632C4.9335 14.918 5.64781 16.2544 6.6967 17.3033C7.7456 18.3522 9.08197 19.0665 10.5368 19.3559C11.9917 19.6453 13.4997 19.4968 14.8701 18.9291C16.2406 18.3614 17.4119 17.4001 18.236 16.1668C19.0601 14.9334 19.5 13.4834 19.5 12C19.5 10.0109 18.7098 8.10323 17.3033 6.6967C15.8968 5.29018 13.9891 4.5 12 4.5Z" fill="#000000"/> <path d="M9.00001 15.75C8.90147 15.7504 8.80383 15.7312 8.71282 15.6934C8.62181 15.6557 8.53926 15.6001 8.47001 15.53C8.32956 15.3893 8.25067 15.1987 8.25067 15C8.25067 14.8012 8.32956 14.6106 8.47001 14.47L14.47 8.46997C14.6122 8.33749 14.8002 8.26537 14.9945 8.26879C15.1888 8.27222 15.3742 8.35093 15.5116 8.48835C15.649 8.62576 15.7278 8.81115 15.7312 9.00545C15.7346 9.19975 15.6625 9.38779 15.53 9.52997L9.53001 15.53C9.46077 15.6001 9.37822 15.6557 9.2872 15.6934C9.19619 15.7312 9.09855 15.7504 9.00001 15.75Z" fill="#000000"/> <path d="M15 15.75C14.9015 15.7504 14.8038 15.7312 14.7128 15.6934C14.6218 15.6557 14.5392 15.6001 14.47 15.53L8.47 9.52997C8.33752 9.38779 8.2654 9.19975 8.26882 9.00545C8.27225 8.81115 8.35097 8.62576 8.48838 8.48835C8.62579 8.35093 8.81118 8.27222 9.00548 8.26879C9.19978 8.26537 9.38782 8.33749 9.53 8.46997L15.53 14.47C15.6704 14.6106 15.7493 14.8012 15.7493 15C15.7493 15.1987 15.6704 15.3893 15.53 15.53C15.4608 15.6001 15.3782 15.6557 15.2872 15.6934C15.1962 15.7312 15.0985 15.7504 15 15.75Z" fill="#000000"/> </svg>
                                                                                                    </div>
                                                                                            }
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
                                            : ''
                                        }
                                        {
                                            data.sale_type == 2 ? 
                                                <div className="payment-modal-section">
                                                    <div className="d-flex" style={{alignItems:'center'}}>
                                                        <h2>Taksitler</h2>
                                                        <div className='add-new-installment ml-2' onClick={() => {setInstallments([...installments,{}])}}>
                                                            <svg width="800px" height="800px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#e33434" stroke="#e33434"> <g id="SVGRepo_bgCarrier" stroke-width="0"/> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/> <g id="SVGRepo_iconCarrier"> <defs> </defs> <g id="Page-1" stroke-width="2.144" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-464.000000, -1087.000000)" fill="#000000"> <path d="M480,1117 C472.268,1117 466,1110.73 466,1103 C466,1095.27 472.268,1089 480,1089 C487.732,1089 494,1095.27 494,1103 C494,1110.73 487.732,1117 480,1117 L480,1117 Z M480,1087 C471.163,1087 464,1094.16 464,1103 C464,1111.84 471.163,1119 480,1119 C488.837,1119 496,1111.84 496,1103 C496,1094.16 488.837,1087 480,1087 L480,1087 Z M486,1102 L481,1102 L481,1097 C481,1096.45 480.553,1096 480,1096 C479.447,1096 479,1096.45 479,1097 L479,1102 L474,1102 C473.447,1102 473,1102.45 473,1103 C473,1103.55 473.447,1104 474,1104 L479,1104 L479,1109 C479,1109.55 479.447,1110 480,1110 C480.553,1110 481,1109.55 481,1109 L481,1104 L486,1104 C486.553,1104 487,1103.55 487,1103 C487,1102.45 486.553,1102 486,1102 L486,1102 Z" id="plus-circle" sketch:type="MSShapeGroup"> </path> </g> </g> </g> </svg>
                                                        </div>
                                                    </div>
                                                    <div className="form-section mt-2" id='installment'>
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th style={{paddingLeft:'15px'}}>Taksit</th>
                                                                    <th>Ödenen Tutar</th>
                                                                    <th>Ödeme Tarihi</th>
                                                                    <th>Ödendiği Tarih</th>
                                                                    <th>Ödeme Yöntemi</th>
                                                                    <th>Açıklama</th>
                                                                    <th style={{textAlign:'center'}}>Ödeme Durumu</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                {
                                                                    installments.map((installment,i) => {
                                                                        return(
                                                                            <tr className={installment.is_payment ? "payment-bg" : "not-payment-bg"}>
                                                                                <td style={{paddingLeft:'15px'}}>{i + 1}. Taksit</td>
                                                                                <td>
                                                                                    <input type="text" onChange={(e) => {setPaymentPrice(i,e.target.value,'price')}} value={dotNumberFormat(installment.price)} className='form-control' />
                                                                                </td>
                                                                                <td>
                                                                                    <input type="date" onChange={(e) => {setPaymentDate(i,e.target.value)}} value={installment.date} className='form-control' />
                                                                                </td>
                                                                                <td>
                                                                                    <input type="date" onChange={(e) => {setPaymentPaymentDate(i,e.target.value)}} value={installment.payment_date} className='form-control' />
                                                                                </td>
                                                                                <td>
                                                                                    <select value={installment.paymentType} onChange={(e) => {console.log(e.target.value); setPaymentMethod(i,e.target.value)}} className='form-control' id="">
                                                                                        <option value="">Seçiniz</option>
                                                                                        <option value="Nakit">Nakit</option>
                                                                                        <option value="Çek">Çek</option>
                                                                                        <option value="Kredi Kartı">Kredi Kartı</option>
                                                                                        <option value="Diğer">Diğer</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" onChange={(e) => {setPaymentPrice(i,e.target.value,'desc')}} value={installment.description} className='form-control' />
                                                                                </td>
                                                                                <td style={{textAlign:'center'}}>
                                                                                    {
                                                                                        installment.is_payment ? 
                                                                                            <div onClick={() => {setPaymentType(i,false)}} className='add-button-payment mx-2'>
                                                                                                <svg width="800px" height="800px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#0FA958" stroke-width="0.0002"> <g id="SVGRepo_bgCarrier" stroke-width="0"/> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/> <g id="SVGRepo_iconCarrier"> <path fill="#000000" fill-rule="evenodd" d="M3 10a7 7 0 019.307-6.611 1 1 0 00.658-1.889 9 9 0 105.98 7.501 1 1 0 00-1.988.22A7 7 0 113 10zm14.75-5.338a1 1 0 00-1.5-1.324l-6.435 7.28-3.183-2.593a1 1 0 00-1.264 1.55l3.929 3.2a1 1 0 001.38-.113l7.072-8z"/> </g> </svg>
                                                                                            </div>
                                                                                        : 
                                                                                            <div onClick={() => {setPaymentType(i,true)}} className='confirm-button-payment mx-2'>
                                                                                                <svg viewBox="0 0 24 24" fill="#EC2F2E" xmlns="http://www.w3.org/2000/svg"> <path d="M12 21C10.22 21 8.47991 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89472 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17294C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36628 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C21 14.387 20.0518 16.6761 18.364 18.364C16.6761 20.0518 14.387 21 12 21ZM12 4.5C10.5166 4.5 9.0666 4.93987 7.83323 5.76398C6.59986 6.58809 5.63856 7.75943 5.07091 9.12988C4.50325 10.5003 4.35473 12.0083 4.64411 13.4632C4.9335 14.918 5.64781 16.2544 6.6967 17.3033C7.7456 18.3522 9.08197 19.0665 10.5368 19.3559C11.9917 19.6453 13.4997 19.4968 14.8701 18.9291C16.2406 18.3614 17.4119 17.4001 18.236 16.1668C19.0601 14.9334 19.5 13.4834 19.5 12C19.5 10.0109 18.7098 8.10323 17.3033 6.6967C15.8968 5.29018 13.9891 4.5 12 4.5Z" fill="#000000"/> <path d="M9.00001 15.75C8.90147 15.7504 8.80383 15.7312 8.71282 15.6934C8.62181 15.6557 8.53926 15.6001 8.47001 15.53C8.32956 15.3893 8.25067 15.1987 8.25067 15C8.25067 14.8012 8.32956 14.6106 8.47001 14.47L14.47 8.46997C14.6122 8.33749 14.8002 8.26537 14.9945 8.26879C15.1888 8.27222 15.3742 8.35093 15.5116 8.48835C15.649 8.62576 15.7278 8.81115 15.7312 9.00545C15.7346 9.19975 15.6625 9.38779 15.53 9.52997L9.53001 15.53C9.46077 15.6001 9.37822 15.6557 9.2872 15.6934C9.19619 15.7312 9.09855 15.7504 9.00001 15.75Z" fill="#000000"/> <path d="M15 15.75C14.9015 15.7504 14.8038 15.7312 14.7128 15.6934C14.6218 15.6557 14.5392 15.6001 14.47 15.53L8.47 9.52997C8.33752 9.38779 8.2654 9.19975 8.26882 9.00545C8.27225 8.81115 8.35097 8.62576 8.48838 8.48835C8.62579 8.35093 8.81118 8.27222 9.00548 8.26879C9.19978 8.26537 9.38782 8.33749 9.53 8.46997L15.53 14.47C15.6704 14.6106 15.7493 14.8012 15.7493 15C15.7493 15.1987 15.6704 15.3893 15.53 15.53C15.4608 15.6001 15.3782 15.6557 15.2872 15.6934C15.1962 15.7312 15.0985 15.7504 15 15.75Z" fill="#000000"/> </svg>
                                                                                            </div>
                                                                                    }
                                                                                </td>
                                                                                <td>
                                                                                    <span onClick={() => {deleteInstallment(i)}} className='installment-remove-button'>
                                                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M19 9H22M19 14H22M19 19H21M16 6L15.1991 18.0129C15.129 19.065 15.0939 19.5911 14.8667 19.99C14.6666 20.3412 14.3648 20.6235 14.0011 20.7998C13.588 21 13.0607 21 12.0062 21H7.99377C6.93927 21 6.41202 21 5.99889 20.7998C5.63517 20.6235 5.33339 20.3412 5.13332 19.99C4.90607 19.5911 4.871 19.065 4.80086 18.0129L4 6M2 6H18M14 6L13.7294 5.18807C13.4671 4.40125 13.3359 4.00784 13.0927 3.71698C12.8779 3.46013 12.6021 3.26132 12.2905 3.13878C11.9376 3 11.523 3 10.6936 3H9.30643C8.47705 3 8.06236 3 7.70951 3.13878C7.39792 3.26132 7.12208 3.46013 6.90729 3.71698C6.66405 4.00784 6.53292 4.40125 6.27064 5.18807L6 6M12 10V17M8 10L7.99995 16.9998" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </svg>
                                                                                    </span>
                                                                                    <span onClick={() => {copyInstallment(i)}} className='installment-copy-button'>
                                                                                        <svg fill="#000000" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 442 442" xml:space="preserve"> <g> <polygon points="291,0 51,0 51,332 121,332 121,80 291,80 	"/> <polygon points="306,125 306,195 376,195 	"/> <polygon points="276,225 276,110 151,110 151,442 391,442 391,225 	"/> </g> </svg>
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
                                            : ''
                                        }

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
                                                    {
                                                        isManager ? 
                                                            <>
                                                                <button onClick={lockedFunc} className='all_selected_button ml-2' style={{background:(locked ? "#EC2F2E" : "#fff"),color:(locked ? "#fff" : "#EC2F2E")}} > 
                                                                    <i className='fas fa-user-lock mx-2'></i> 
                                                                    <span>{locked ? "Kilitlendi" : "Kilitle"}</span> 
                                                                </button>
                                                                <button onClick={() => {openLockersFunc()}} className='all_selected_button ml-2' style={{borderColor:(locked ? "gray" : "#EC2F2E"),color:(locked ? "gray" : "#EC2F2E")}} > 
                                                                    <i className='fas fa-user-plus mx-2'></i> 
                                                                    <span>Yetk. Kullanıcıları Seç</span> 
                                                                </button>
                                                            </>
                                                        : ''
                                                    }
                                                    
                                                </div>
                                            </div>
                                            <div className="last-change">
                                                <span>
                                                    <i className='fa fa-calendar'></i> {months[lastChangeDate.getMonth()] + ', ' + lastChangeDate.getDate() + ' ' + lastChangeDate.getFullYear()}
                                                </span>
                                                <span>
                                                    <i className='fa fa-user'></i> {data?.changer?.user?.name} 
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                : 
                                    <div className='is_locked'>
                                        <i className='fas fa-user-cog'></i>
                                        <span>Ödeme Planını Düzenlemek İçin Yetkiniz Bulunmamaktadır</span>
                                    </div>
                            }
                            <SelectUser setOpen={setSelectUserOpen} projectId={projectId} roomOrder={roomOrder} open={selectUserOpen}/>
                            <PopUp style={{width:'20%'}} open={lockConfirm} setOpen={setLockConfirm}>
                                <div className="content-payment-modal p-2 scrollbar mt-2" id="style-2">
                                    <div className="payment-modal-section">
                                        <div className="message-with-icon">
                                            <i class="fas fa-exclamation"></i>
                                            {
                                                locked ? 
                                                    <span> İlanın ödeme planındaki kilidi kaldırıyorsunuz verdiğiniz izinler doğrultusunda alt kullanıcılar ödeme planını güncelleyebilir </span>
                                                : 
                                                    <span>İlanı kilitliyorsunuz. Kilitlemeniz durumunda kimse ödeme planını değiştiremez.</span>
                                            }
                                        </div>

                                        <div className='mt-3' style={{display:'flex',justifyContent:'center'}}>
                                            <button onClick={() => {setLockConfirm(false)}} className='confirm-modal-cancel-button' > 
                                                <i className='fa fa-save mx-2'></i> 
                                                <span>İptal Et</span> 
                                            </button>
                                            <button onClick={lockedUpdate} style={{display:'flex',alignItems:'center'}} className='confirm-modal-confirm-button' > 
                                                <i className='fa fa-save mx-2'></i> 
                                                <span>Kaydet</span> 
                                                <div className={lockedLoading ? "" : 'd-none'}>
                                                    <i className={'fa fa-spinner loading-icon ml-2'}></i>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </PopUp>
                    </div>
                </div>
            </div>
        </> 
    )
}
export default PaymentModal