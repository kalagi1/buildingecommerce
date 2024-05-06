import { Box, Button, FormControlLabel, Modal, Switch } from '@mui/material'
import React, { useEffect, useState } from 'react'
import { baseUrl, dotNumberFormat } from '../../define/variables';
import axios from 'axios';

function CustomEdit({project,open,setOpen,selectedRoomsTemp,reloadData}) {
    const [housingTypeData,setHousingTypeData] = useState({
        form_json : ''
    });
    const [textData,setTextData] = useState("");
    const [selectData,setSelectData] = useState("");
    const [formJsonData,setFormJsonData] = useState([]);
    const [selectedType,setSelectedType] = useState({});
    const [checkboxValues,setCheckboxValues] = useState([]);
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

    useEffect(() => {
        if(project.housing_type_id){
            axios.get(baseUrl+'get_housing_type/'+project.housing_type_id).then((res) => {
                setHousingTypeData(res.data.data)
                setFormJsonData(JSON.parse(res.data.data.form_json))
            })
        }
    },[project])

    const saveEdit = () => {
        var itemsx = Object.keys(selectedRoomsTemp)
        var newItems =  itemsx.map((item) => parseInt(item) + 1);

        if(formJsonData?.find((jsonData) => {return jsonData.name == selectedType})?.type == "text"){
            axios.post(baseUrl + 'save_housing', {
                rooms: newItems,
                column_name: formJsonData?.find((jsonData) => {return jsonData.name == selectedType})?.name.replace('[]',''),
                value: textData,
                is_dot: true,
                project_id: project.id
            }).then((res) => {
                if(res.data.status){
                    setOpen(false);
                    reloadData();
                }
            })
        }else if(formJsonData?.find((jsonData) => {return jsonData.name == selectedType})?.type == "select"){
            axios.post(baseUrl + 'save_housing', {
                rooms: newItems,
                column_name: formJsonData?.find((jsonData) => {return jsonData.name == selectedType})?.name.replace('[]',''),
                value: selectData,
                is_dot: true,
                project_id: project.id
            }).then((res) => {
                if(res.data.status){
                    setOpen(false);
                    reloadData();
                }
            })
        }else{
            axios.post(baseUrl + 'save_housing_checkboxes', {
                rooms: newItems,
                column_name: formJsonData?.find((jsonData) => {return jsonData.name == selectedType})?.name.replace('[]',''),
                value: checkboxValues,
                is_dot: true,
                project_id: project.id
            }).then((res) => {
                if(res.data.status){
                    setOpen(false);
                    reloadData();
                }
            })
        }
        
    }
 
    const checkboxChange = (val) => {
        if(checkboxValues.includes(val)){
            var newValues = checkboxValues.filter((checkboxValue) => { return checkboxValue != val});
            setCheckboxValues(newValues);
        }else{
            setCheckboxValues([...checkboxValues,val])
        }
    }

    console.log(checkboxValues);

    return(
        <div>
            <Modal
                open={open}
                onClose={() => {setOpen(false);}}
                aria-labelledby="modal-modal-title"
                aria-describedby="modal-modal-description"
            >
                <Box sx={style}>
                    <div className="row">
                        <h4>{housingTypeData.title}</h4>
                        <span>{housingTypeData.title} tipinde bir ilanda alanlar üzerinde bir değişiklik yapıyorsunuz</span>
                        <div className="col-md-12">
                            <label htmlFor="">Alan Seç</label>
                            <select className='form-control' value={selectedType} onChange={(e) => {setSelectedType(e.target.value)}} name="" id="">
                                {
                                    formJsonData.map((typeData) => {
                                        if(!typeData.className.includes('project-disabled')){
                                            return(
                                                <option value={typeData.name}>{typeData.label}</option>
                                            )
                                        }
                                        
                                    })
                                }
                            </select>
                        </div>
                        <div className="col-md-12 mt-2">
                            <label htmlFor="">{formJsonData?.find((jsonData) => {return jsonData.name == selectedType})?.label}</label>
                            {
                                formJsonData?.find((jsonData) => {return jsonData.name == selectedType})?.type == "text" ? 
                                    <input value={textData} onChange={(e) => {formJsonData?.find((jsonData) => {return jsonData.name == selectedType})?.className?.includes("price-only") ? setTextData(dotNumberFormat(e.target.value)) : setTextData(e.target.value)}} type="text"  className='form-control' />
                                : formJsonData?.find((jsonData) => {return jsonData.name == selectedType})?.type == "select" ? 
                                    <select value={selectData} onChange={(e) => {setSelectData(e.target.value)}} className='form-control'>
                                        {
                                            formJsonData?.find((jsonData) => {return jsonData.name == selectedType})?.values?.map((value) => {
                                                return(
                                                    <option value={value.value}>{value.label}</option>
                                                )
                                            })
                                        }
                                    </select>
                                    : 
                                    <div className="checkbox-groups">
                                        <div className="row">
                                            {
                                                formJsonData?.find((jsonData) => {return jsonData.name == selectedType})?.values?.map((valueCheckbox) => {
                                                    return (
                                                        <div className="col-md-3">
                                                            <FormControlLabel control={<Switch checked={checkboxValues.includes(valueCheckbox.value)} onChange={() => {checkboxChange(valueCheckbox.value)}} label={valueCheckbox.label} />} label={valueCheckbox.label} />
                                                        </div>
                                                    )
                                                })
                                            }
                                        </div>
                                    </div>
                            }
                        </div>
                        <div>
                            <Button onClick={() => {saveEdit()}} className='save_button mt-2'> Kaydet</Button>
                        </div>
                    </div>
                </Box>
            </Modal>
        </div>
    )
}
export default CustomEdit