import React, { useEffect, useState } from 'react';
import { Container, Grid, TextField, Typography, Button, MenuItem, Box, Select, InputLabel, FormControl , Modal, Switch, FormControlLabel } from '@mui/material';
import { baseUrl, dotNumberFormat } from '../../define/variables';
import axios from 'axios';
import { toast } from 'react-toastify';

function SaleModal({reloadData,projectId,open,setOpen,datat,roomOrder}) {
    const [loading,setLoading] = useState(false);
    const [data, setData] = React.useState({
        name: 'Abdurrahman İslamoğlu',
        price : '1000000',
        advance : '400000',
        installments : 36,
        email : 'islamoglu.abd@gmail.com',
        phone : '(551) 108 36 52',
        sale_type : 2,
        pay_decs : [
            {
                price : '200000',
                date : '2024-05-26'
            },
            {
                price : '200000',
                date : '2024-09-26'
            },
        ]
    });

    useEffect(() => {
        setData(datat)
    },[datat])
    
    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setData({ ...data, [name]: value });
    };

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
    };

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

    const saveSale = () => {
        setLoading(true);
        axios.post(baseUrl+'save_sale/'+projectId,{
            ...data,
            room_order : roomOrder
        }).then((res) => {
            if(res.data.status){
                setLoading(false);
                toast.success("Başarıyla satış bilgilerini güncellediniz");
                setOpen(false);
                reloadData();
            }
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

    return(
        <Modal
            open={open}
            onClose={() => {setOpen(false)}}
            aria-labelledby="modal-modal-title"
            aria-describedby="modal-modal-description"
        >
            <Box sx={style}>
                <div style={{display:'flex',justifyContent:'space-between'}}>
                    <Typography variant="h4" gutterBottom>
                        Satış Bilgileri
                    </Typography>
                    <button onClick={saveSale} className='all_selected_button' > 
                        <i className='fa fa-lock mx-2'></i> 
                        <span>Kaydet</span> 
                        <div className={loading ? "" : 'd-none'}>
                            <i className={'fa fa-spinner loading-icon ml-2'}></i>
                        </div>
                    </button>
                </div>
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
                        <button onClick={saveSale} className='all_selected_button' style={{width:'100%',display:'flex',justifyContent:'center'}}> 
                            <i className='fa fa-lock mx-2'></i> 
                            <span>Kaydet</span> 
                            <div className={loading ? "" : 'd-none'}>
                                <i className={'fa fa-spinner loading-icon ml-2'}></i>
                            </div>
                        </button>
                    </Grid>
                </Grid>
            </Box>
        </Modal>
    )
}
export default SaleModal