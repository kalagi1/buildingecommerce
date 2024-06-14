import React, { useEffect, useState } from 'react';
import { Container, Grid, TextField, Typography, Button, MenuItem, Box, Select, InputLabel, FormControl , Modal, Switch, FormControlLabel } from '@mui/material';
import { baseUrl, dotNumberFormat } from '../../define/variables';
import { ReactSortable } from 'react-sortablejs';
import axios from 'axios';
import { toast } from 'react-toastify';

function PaymentModal({setSelectedId,open,setOpen,solds,selectedData,selectedId,projectId,getLastCount,datat,roomOrder,reloadData,setSelectedData}) {
    const [installments,setInstallments] = useState([]);
    const [startDate,setStartDate] = useState("");
    const [startDateConfirm,setStartDateConfirm] = useState(false);
    const [saveLoading,setSaveLoading] = useState(false);
    const [data, setData] = React.useState({});
    const [loading, setLoading] = useState(false);

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
        // setSaveLoading(true);
        console.log('instalments-->>' + installments)

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
            setLoading(true); // Start loading
            axios.get(baseUrl + 'get_installments/' + projectId + '/' + selectedId).then((res) => {
                console.log('response: ' + JSON.stringify(res.data.data)); // Veriyi konsolda gösterir
                console.log('Number of installments:', res.data.data.length);
                setInstallments(res.data.data);
                setStartDate(res.data.data[0].date);
                setStartDateConfirm(true);
                setLoading(false); // End loading    
            }).catch((err) => {
                console.error("Error fetching installments:", err);
                setLoading(false); // End loading    
            });
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

    

// aaaaaaaaaaaaa
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

    return(
        <Modal
            open={open}
            onClose={() => {setOpen(false);setSelectedId(null);}}
            aria-labelledby="modal-modal-title"
            aria-describedby="modal-modal-description"
        >
                     {loading ? (
                <div style={{display: 'flex', justifyContent: 'center', alignItems: 'center', height: '100%'}}>
                    <i className="fa fa-spinner fa-spin" style={{fontSize: '24px'}}></i>
                </div>
            ) : (
            <Box sx={style}>
                <div style={{display:'flex',justifyContent:'space-between'}}>
                    <Typography variant="h4" gutterBottom>
                        Ödeme Planı ve Alıcı Bilgileri
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
       
                <Grid container spacing={3}>
                    <Grid item xs={6} md={6}>
                        <TextField
                            fullWidth
                            label="Alıcı Adı"
                            name="name"
                            value={data.name}
                            onChange={handleInputChange}
                            margin="normal"
                        />
                        <TextField
                            fullWidth
                            label="Alıcı Email Adresi"
                            name="email"
                            value={data.email}
                            onChange={handleInputChange}
                            margin="normal"
                        />
                        <TextField
                            fullWidth
                            label="Alıcı Telefon Numarası"
                            name="phone"
                            value={data.phone}
                            onChange={handleInputChange}
                            margin="normal"
                        />
                        <FormControl fullWidth margin="normal">
                            <label htmlFor="">Komşumu Gör</label>
                            
                            <FormControlLabel control={<Switch onChange={() => {setData({...data,show_neighbour : !data.show_neighbour})}} checked={data.show_neighbour} />} label="Açık" />
                        </FormControl>
                         <FormControl fullWidth margin="normal">
                            <label htmlFor="">Kapora Ödendi</label>
                            
                            <FormControlLabel control={<Switch onChange={() => {setData({...data,down_payment : !data.down_payment})}} checked={data.down_payment} />} label="Evet" />
                        </FormControl>
                        <TextField
                            fullWidth
                            label="Kapora Bedeli"
                            name="down_payment_price"
                            value={dotNumberFormat(data.down_payment_price)}
                            onChange={handleInputChange}
                            margin="normal"
                        />
                        <TextField
                            type='date'
                            fullWidth
                            label="Kapora Ödenme Tarihi"
                            name="deposit_date"
                            value={data.deposit_date}
                            onChange={handleInputChange}
                            margin="normal"
                        />
                        <TextField
                            fullWidth
                            label="Kapora Açıklaması"
                            name="down_payment_price_description"
                            value={data.down_payment_price_description}
                            onChange={handleInputChange}
                            margin="normal"
                        />
                         <FormControl fullWidth margin="normal">
                            <label htmlFor="">Peşinat Ödendi</label>
                            
                            <FormControlLabel control={<Switch onChange={() => {setData({...data,advance_payment : !data.advance_payment})}} checked={data.advance_payment} />} label="Evet" />
                        </FormControl>
                        <TextField
                            fullWidth
                            type='date'
                            label="Peşinat Ödenme Tarihi"
                            name="advance_date"
                            value={data.advance_date}
                            onChange={handleInputChange}
                            margin="normal"
                        />
                        <TextField
                            fullWidth
                            label="Peşinat Açıklaması"
                            name="advance_date_description"
                            value={data.advance_date_description}
                            onChange={handleInputChange}
                            margin="normal"
                        />
                    </Grid>
                    <Grid item xs={6} md={6}>
                        <FormControl fullWidth margin="normal">
                            <InputLabel id="attributes-label">Satın Alma Türü</InputLabel>
                            <Select
                                labelId="attributes-label"
                                id="attributes"
                                name="sale_type"
                                value={data.sale_type}
                                onChange={handleInputChange}
                                label="Attributes"
                            >
                                <MenuItem value="1">Peşin Satış</MenuItem>
                                <MenuItem value="2">Taksitli Satış</MenuItem>
                            {/* Diğer atributlar burada eklenebilir */}
                            </Select>
                        </FormControl>
                        <TextField
                            fullWidth
                            label="Satış Fiyatı"
                            name="price"
                            value={dotNumberFormat(data.price)}
                            onChange={handleInputChange}
                            margin="normal"
                        />
                        {
                            data.sale_type == 2 ? 
                                <>
                                    <TextField
                                        fullWidth
                                        label="Peşinat"
                                        name="advance"
                                        value={dotNumberFormat(data.advance)}
                                        onChange={handleInputChange}
                                        margin="normal"
                                        type="text"
                                    />
                                    <TextField
                                        fullWidth
                                        label="Taksit Sayısı"
                                        name="installments"
                                        value={data.installments}
                                        onChange={handleInputChange}
                                        margin="normal"
                                        type="text"
                                    />
                                </>
                            : ''
                        }
                    </Grid>
                    <Grid item xs={12} md={12}>
                        
                    {
                        data.sale_type == 2 ? 
                            <FormControl fullWidth margin="normal">
                                <div className="dec-pay-area">
                                    <div className="top">
                                        <h4>Ara Ödemeler</h4>
                                        <button onClick={addPayDec} className="btn btn-primary add-pay-dec">
                                            <svg
                                                className="svg-inline--fa fa-plus"
                                                aria-hidden="true"
                                                focusable="false"
                                                data-prefix="fas"
                                                data-icon="plus"
                                                role="img"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 448 512"
                                                data-fa-i2svg=""
                                            >
                                                <path
                                                fill="currentColor"
                                                d="M432 256c0 17.69-14.33 32.01-32 32.01H256v144c0 17.69-14.33 31.99-32 31.99s-32-14.3-32-31.99v-144H48c-17.67 0-32-14.32-32-32.01s14.33-31.99 32-31.99H192v-144c0-17.69 14.33-32.01 32-32.01s32 14.32 32 32.01v144h144C417.7 224 432 238.3 432 256z"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                    <div className="pay-desc">
                                        {
                                            data?.pay_decs?.map((payDec,i) => {
                                                return(
                                                    <div className="pay-desc-item">
                                                        <div className="row" style={{ alignItems: "flex-end" }}>
                                                            <div className="flex-1">
                                                                <button onClick={() => {removePayDec(i)}} className="btn btn-primary remove-pay-dec">
                                                                    <svg
                                                                    className="svg-inline--fa fa-trash"
                                                                    aria-hidden="true"
                                                                    focusable="false"
                                                                    data-prefix="fas"
                                                                    data-icon="trash"
                                                                    role="img"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 448 512"
                                                                    data-fa-i2svg=""
                                                                    >
                                                                        <path
                                                                            fill="currentColor"
                                                                            d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z"
                                                                        />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div className="flex-10">
                                                                <label htmlFor="">Ara Ödeme </label>
                                                                <input type="text" className="form-control" onChange={(e) => {setPayDecPrice(i,e.target.value)}} value={dotNumberFormat(payDec.price)} />
                                                            </div>
                                                            <div className="flex-10">
                                                                <label htmlFor="">Ara Ödeme Tarihi</label>
                                                                <input type="date" className="form-control" onChange={(e) => {setPayDecDate(i,e.target.value)}} value={payDec.date} />
                                                            </div>
                                                            <div style={{flex:'2'}}>
                                                                {
                                                                    payDec.status ? 
                                                                        <div onClick={() => {setPayDecStatus(i,false)}} className='add-button-payment mx-2' style={{cursor:'pointer'}}>
                                                                            <i className='fa fa-times'></i>
                                                                        </div>
                                                                    : 
                                                                        <div onClick={() => {setPayDecStatus(i,true)}} className='confirm-button-payment mx-2' style={{cursor:'pointer'}}>
                                                                            <i className='fa fa-check'></i>
                                                                        </div>
                                                                }
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                )
                                            })
                                        }
                                        
                                    </div>
                                </div>
                            </FormControl>
                        : ''
                    }
                    </Grid>
                    <Grid item xs={12} md={12}>
                    </Grid>
                </Grid>
               
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
                                                        <select value={installment.paymentType} onChange={(e) => {console.log(e.target.value); setPaymentMethod(i,e.target.value)}} className='form-control' id="">
                                                            <option value="">Seçiniz</option>
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
            )}

        </Modal>
    )
}
export default PaymentModal