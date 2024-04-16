import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import TablePagination from '@mui/material/TablePagination';
import { Box, IconButton, Skeleton, Tooltip, useTheme } from '@mui/material';
import { FirstPage, KeyboardArrowLeft, KeyboardArrowRight, LastPage } from '@mui/icons-material';
import axios from 'axios';
import { baseUrl, dotNumberFormat, frontEndUrl } from '../define/variables';
import { ToastContainer, toast } from 'react-toastify';
import Swal from 'sweetalert2';
import React, { useEffect, useState } from 'react'
import UpdateHousingModal from './create_project_components/UpdateHousingModal';
import UpdateSingleHousingModal from './create_project_components/UpdateSingleHousingModal';
import ImageChange from './create_project_components/ImageChange';
import PayDecTable from './create_project_components/PayDecTable';
import ChangePaymentStatus from './create_project_components/ChangePaymentStatus';
import InfoIcon from '@mui/icons-material/Info';

function TablePaginationActions(props) {
    const theme = useTheme();
    const { count, page, rowsPerPage, onPageChange } = props;
  
    const handleFirstPageButtonClick = (
      event,
    ) => {
      onPageChange(event, 0);
    };
  
    const handleBackButtonClick = (event) => {
      onPageChange(event, page - 1);
    };
  
    const handleNextButtonClick = (event) => {
      onPageChange(event, page + 1);
    };
  
    const handleLastPageButtonClick = (event) => {
      onPageChange(event, Math.max(0, Math.ceil(count / rowsPerPage) - 1));
    };
  
    return (
      <Box sx={{ flexShrink: 0, ml: 2.5 }}>
        <IconButton
          onClick={handleFirstPageButtonClick}
          disabled={page === 0}
          aria-label="first page"
        >
          {theme.direction === 'rtl' ? <LastPage /> : <FirstPage />}
        </IconButton>
        <IconButton
          onClick={handleBackButtonClick}
          disabled={page === 0}
          aria-label="previous page"
        >
          {theme.direction === 'rtl' ? <KeyboardArrowRight /> : <KeyboardArrowLeft />}
        </IconButton>
        <IconButton
          onClick={handleNextButtonClick}
          disabled={page >= Math.ceil(count / rowsPerPage) - 1}
          aria-label="next page"
        >
          {theme.direction === 'rtl' ? <KeyboardArrowLeft /> : <KeyboardArrowRight />}
        </IconButton>
        <IconButton
          onClick={handleLastPageButtonClick}
          disabled={page >= Math.ceil(count / rowsPerPage) - 1}
          aria-label="last page"
        >
          {theme.direction === 'rtl' ? <FirstPage /> : <LastPage />}
        </IconButton>
      </Box>
    );
  }

function HousingList({projectId}) {
    const [project,setProject] = useState({
        blocks : []
    });
    const [selectedBlock,setSelectedBlock] = useState(0);
    const [haveBlocks,setHaveBlocks] = useState(0);
    const [rows,setRows] = useState(0);
    const [loading,setLoading] = useState(true);
    const [rowPerPage,setRowPerPage] = useState(10);
    const [totalProjectsCount,setTotalProjectsCount] = useState(0);
    const [page,setPage] = useState(0);
    const [selectedAllCheck,setSelectedAllCheck] = useState(false);
    const [selectedRooms,setSelectedRooms] = useState([]);
    const [updateHousingModalOpen,setUpdateHousingModalOpen] = useState(false);
    const [changeData,setChangeData] = useState("");
    const [payDecData,setPayDecData] = useState([]);
    const [selectedType,setSelectedType] = useState("");
    const [isDotType,setIsDotType] = useState(false);
    const [selectedColumn,setSelectedColumn] = useState("");
    const [selectedSingleItem,setSelectedSingleItem] = useState(null);
    const [updateSingleHousingModalOpen,setSingleUpdateHousingModalOpen] = useState(false);
    const [updateSingleImageModalOpen,setSingleUpdateImageModalOpen] = useState(false);
    const [updatePayDecModalOpen,setUpdatePayDecModalOpen] = useState(false);
    const [changePaymentStatusOpen,setChangePaymentStatusOpen] = useState(false);
    const [sumCartQts,setSumCartQts] = useState([]);
    const [solds,setSolds] = useState([]);


    useEffect(() => {
        axiosRequestGetData(0)
    },[selectedBlock])

    const TableRowsLoader = ({ rowsNum }) => {
        return [...Array(rowsNum)].map((row, index) => (
            <Table sx={{ minWidth: 650 }} aria-label="simple table">
                <TableHead>
                    <TableRow>
                        <TableCell component="th" scope="row">
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    <TableRow>
                        <TableCell component="th" scope="row">
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell component="th" scope="row">
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell component="th" scope="row">
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell component="th" scope="row">
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell component="th" scope="row">
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell component="th" scope="row">
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell component="th" scope="row">
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell component="th" scope="row">
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell component="th" scope="row">
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                        <TableCell>
                            <Skeleton animation="wave" variant="text" />
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        ));
    };

    const axiosRequestGetData = (newPage) => {
        var start = newPage * rowPerPage;
        var end = (newPage + 1) * rowPerPage;
        axios.get(baseUrl+'project_housings/'+projectId+`?start=${start}&end=${end}&block=${selectedBlock}`).then((res) => {
            setProject(res.data.project)
            var result = Object.keys(res.data.rows).map((key) => res.data.rows[key]);
            setRows(result);
            if(res.data.project.have_blocks){
                setTotalProjectsCount(res.data.project.blocks[selectedBlock].housing_count);   
            }else{
                setTotalProjectsCount(res.data.project.room_count);   
            }
            var result2 = Object.keys(res.data.sumCartOrderQt).map((key) => res.data.sumCartOrderQt[key])
            setSumCartQts(result2);
            setLoading(false);
            setHaveBlocks(res.data.project.have_blocks)
            setSolds(res.data.solds)
        })
    }

    const handleChangePage = (
        event,
        newPage,
    ) => {
        setLoading(true);
        setPage(newPage);
        axiosRequestGetData(newPage)
    };

    const handleChangeRowsPerPage = (
        event,
        
    ) => {
        setLoading(true);
        setRowPerPage(parseInt(event.target.value, 10));
        setPage(0);

        var start = page * event.target.value;
        var end = (page + 1) * event.target.value;
        axios.get(baseUrl+'project_housings/'+projectId+`?start=${start}&end=${end}&block=${selectedBlock}`).then((res) => {
            setProject(res.data.project)
            var result = Object.keys(res.data.rows).map((key) => res.data.rows[key]);
            setRows(result);
            if(res.data.project.have_blocks){
                setTotalProjectsCount(res.data.project.blocks[selectedBlock].housing_count);   
            }else{
                setTotalProjectsCount(res.data.project.room_count);   
            }
            var result2 = Object.keys(res.data.sumCartOrderQt).map((key) => res.data.sumCartOrderQt[key])
            setSumCartQts(result2);
            setLoading(false);
            setHaveBlocks(res.data.project.have_blocks)
            setSolds(res.data.solds)
        })
    };

    const selectAll = () => {
        if(!selectedAllCheck){
            if(haveBlocks){
                console.log("asd");
                var tempSelected = [];
                var lastBlockCount = 0;
                var lastBlockCount2 = 0;

                for(var i = 0; i < project.blocks.length; i++){
                    if(i != selectedBlock){
                        for(var j = 0; j< project.blocks[i].housing_count; j++){
                            if(selectedRooms.includes(lastBlockCount2 + j + 1)){
                                tempSelected.push(lastBlockCount2 + j + 1)
                            }
                        }
                    }

                    lastBlockCount2 += project.blocks[i].housing_count;
                }

                for(var i = 0; i < selectedBlock; i++){
                    lastBlockCount += project.blocks[i].housing_count;
                }

                for(var i = 0 ; i < totalProjectsCount; i++){
                    if(findSold(lastBlockCount+i+1) == 2 || !findSold(lastBlockCount+i+1)){
                        tempSelected.push(lastBlockCount+i+1);
                    }
                }
        
                setSelectedRooms(tempSelected);
            }else{
                var tempSelected = [];
                for(var i = 0 ; i < totalProjectsCount; i++){
                    if(findSold(i+1) == 2 || !findSold(i+1)){
                        tempSelected.push(i+1);
                    }
                }
        
                setSelectedRooms(tempSelected);
            }
        }else{
            if(haveBlocks){
                var tempSelected = [];
                var lastBlockCount2 = 0;
                for(var i = 0; i < project.blocks.length; i++){
                    if(i != selectedBlock){
                        for(var j = 0; j< project.blocks[i].housing_count; j++){
                            if(selectedRooms.includes(lastBlockCount2 + j + 1)){
                                tempSelected.push(lastBlockCount2 + j + 1)
                            }
                        }
                    }

                    lastBlockCount2 += project.blocks[i].housing_count;
                }

                setSelectedRooms(tempSelected)
            }else{
                setSelectedRooms([]);
            }
        }
    }

    const saveHousing = () => {
        axios.post(baseUrl+'save_housing',{
            rooms : selectedRooms,
            column_name : selectedColumn,
            value : changeData,
            is_dot : isDotType,
            project_id : projectId
        }).then((res) => {
            if(res.data.status){
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
                
                axiosRequestGetData(page)
            }
        })
    }

    const changeRoom = (key) => {
        if(selectedRooms.includes(key + 1)){
            var newValues = selectedRooms.filter((room) => room != key + 1);
            setSelectedRooms(newValues);
        }else{
            setSelectedRooms([...selectedRooms,(key + 1)])
        }
    }

    const saveSingleHousing = () => {
        var tempSelected = [];
        tempSelected.push(selectedSingleItem)

        console.log(tempSelected);
        
        axios.post(baseUrl+'save_housing',{
            rooms : tempSelected,
            column_name : selectedColumn,
            value : changeData,
            is_dot : isDotType,
            project_id : projectId
        }).then((res) => {
            if(res.data.status){
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
                
                axiosRequestGetData(page)
            }else{
                toast.error(res.data.error)
            }
        })
    }

    const saveMultipleHousing = () => {
        var tempSelected = [];
        if(haveBlocks){
            tempSelected = blockSelects();
        }else{
            for(var i = 0 ; i < totalProjectsCount; i++){
                tempSelected.push(i+1);
            }
        }
        
        axios.post(baseUrl+'save_housing',{
            rooms : tempSelected,
            column_name : selectedColumn,
            value : changeData,
            is_dot : isDotType,
            project_id : projectId
        }).then((res) => {
            if(res.data.status){
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
                
                axiosRequestGetData(page)
            }else{
                toast.error(res.data.error)
            }
        })
    }

    const saveImageSingle = () => {
        var tempSelected = [selectedSingleItem];
        
        
        var formData = new FormData();

        for(var i = 0 ; i < tempSelected.length; i++){
            formData.append('rooms['+i+']',tempSelected[i]);
        }
        formData.append('column_name',selectedColumn);
        formData.append('value',changeData);
        formData.append('project_id',projectId);
        axios.post(baseUrl+'change_image',formData).then((res) => {
            if(res.data.status){
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
                
                axiosRequestGetData(page)
            }
        })
    }

    const blockSelects = () => {
        var tempSeleced = [];
        var lastCount = 0;
        for(var i = 0; i < project.blocks.length; i++){
            if(i < selectedBlock){
                lastCount += project.blocks[i].housing_count;
            }
        }

        for(var j = 0; j < project.blocks[selectedBlock].housing_count; j++){
            tempSeleced.push(lastCount+j+1);
        }

        console.log(tempSeleced);

        return tempSeleced;
    }

    const saveImageMultiple = () => {
        var tempSelected = [];
        if(haveBlocks){
            tempSelected = blockSelects();
        }else{
            for(var i = 0 ; i < totalProjectsCount; i++){
                tempSelected.push(i+1);
            }
        }
        
        var formData = new FormData();

        for(var i = 0 ; i < tempSelected.length; i++){
            formData.append('rooms['+i+']',tempSelected[i]);
        }
        formData.append('column_name',selectedColumn);
        formData.append('value',changeData);
        formData.append('project_id',projectId);
        axios.post(baseUrl+'change_image',formData).then((res) => {
            if(res.data.status){
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
                
                axiosRequestGetData(page)
            }
        })
    }

    const savePayDecs = () => {
        var tempSelected = [];
        if(haveBlocks){
            tempSelected = blockSelects();
        }else{
            for(var i = 0 ; i < totalProjectsCount; i++){
                tempSelected.push(i+1);
            }
        }
        
        axios.post(baseUrl+'save_pay_dec',{
            rooms : tempSelected,
            value : payDecData,
            project_id : projectId
        }).then((res) => {
            if(res.data.status){
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
                
                axiosRequestGetData(page)
            }
        })
    }

    const savePayDecsSingle = () => {
        var tempSelected = [selectedSingleItem];
        
        axios.post(baseUrl+'save_pay_dec',{
            rooms : tempSelected,
            value : payDecData,
            project_id : projectId
        }).then((res) => {
            if(res.data.status){
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
                
                axiosRequestGetData(page)
            }
        })
    }

    const savePaymentStatusSingle = () => {
        var tempSelected = [selectedSingleItem];
        
        
        axios.post(baseUrl+'save_payment_status',{
            rooms : tempSelected,
            value : changeData,
            project_id : projectId
        }).then((res) => {
            if(res.data.status){
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
                
                axiosRequestGetData(page)
            }
        })
    }

    const savePaymentStatus = () => {
        var tempSelected = [];
        if(haveBlocks){
            tempSelected = blockSelects();
        }else{
            for(var i = 0 ; i < totalProjectsCount; i++){
                tempSelected.push(i+1);
            }
        }
        
        axios.post(baseUrl+'save_payment_status',{
            rooms : tempSelected,
            value : changeData,
            project_id : projectId
        }).then((res) => {
            if(res.data.status){
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
                
                axiosRequestGetData(page)
            }
        })
    }

    const findOrderQt = (roomOrder) => {
        var haveSumCartQts = sumCartQts.find((cartQts) => {return cartQts.housing_id == roomOrder;});
        if(haveSumCartQts && haveSumCartQts != undefined){
            return haveSumCartQts.qt_total
        }else{
            return 0;
        }
    }

    const findSold = (roomOrder) => {
        var haveSold = solds.find((sold) => {var item = JSON.parse(sold.cart); return item.item.housing == roomOrder});
        if(haveSold){
            return haveSold.status;
        }else{
            return null;
        }
    }

    const getLastBlockCount = () => {
        var blockItemCount = 0;
        if(haveBlocks){
            project.blocks.map((block,key) => {
                if(key < selectedBlock){
                    blockItemCount += block.housing_count
                }
            })
        }
        return blockItemCount;
    }

    const getLastCount = () => {
        if(haveBlocks){
            return getLastBlockCount() + (page * rowPerPage);
        }else{
            return (rowPerPage * page)
        }
    }

    const savePayDecSelectedHousing = () => {
        axios.post(baseUrl+'save_pay_dec',{
            rooms : selectedRooms,
            value : payDecData,
            project_id : projectId
        }).then((res) => {
            if(res.data.status){
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
                
                axiosRequestGetData(page)
            }
        })
    }

    const setPayDecs = (roomOrder) => {
        roomOrder = roomOrder - 1;
        var temps = [];
        for(var i = 0; i < rows[roomOrder]["pay-dec-count"+(roomOrder + 1)]; i++){
            temps.push({
                price : dotNumberFormat(rows[roomOrder]["pay_desc_price"+(roomOrder + 1)+i]),
                date : rows[roomOrder]["pay_desc_date"+(roomOrder + 1)+i]
            });
        }

        setPayDecData(temps);
    }

    useEffect(() => {
        if(haveBlocks){
            var blockItemCount = 0;
            project.blocks.map((block,key) => {
                if(key < selectedBlock){
                    blockItemCount += block.housing_count
                }
            })
            var checked = true;

            for(var i = blockItemCount; i < blockItemCount + project.blocks[selectedBlock].housing_count; i++){
                if(!selectedRooms.includes(i+1)){
                    checked = false;
                }
            }
            setSelectedAllCheck(checked)
        }else{

        }
    },[selectedBlock,selectedRooms])
    

    useEffect(() => {
        setSelectedAllCheck(false);
    },[selectedBlock])

    return(
        <div>
            <ToastContainer/>
            <div className="card py-4">
                <div className="estate-table">
                    <div className="table-breadcrumb">
                        <ul>
                            <li>
                                Yönetim Paneli
                            </li>
                            <li className='none-underline'> / </li>
                            <li>{project.project_title} Adlı Projenin Konutları</li>
                        </ul>
                    </div>
                    <div className="tabs">
                        <ul>
                            {
                                project.blocks.map((block,blockIndex) => {
                                    return(
                                        <li onClick={() => {setSelectedBlock(blockIndex);setPage(0);setLoading(true)}} className={selectedBlock == blockIndex ? "active" : ""}>{block.block_name}</li>
                                    )
                                })
                            }
                        </ul>
                    </div>
                    <div>
                        <div>
                            {selectedRooms.length > 0 ? 
                                <div className='card p-4 mb-2'>
                                    <h2>Seçilen Konutlar</h2>
                                    <div className="d-flex" style={{flexWrap:'wrap'}}>
                                        {
                                            selectedRooms.sort(function(a, b) {
                                                return a - b;
                                            }).map((room,key) => {
                                                if(haveBlocks){
                                                    var lastBlockCountTemp = 0;
                                                    var lastBlockCountTemp3 = project.blocks[0].housing_count;
                                                    var lastBlockCountTemp2 = 0;
                                                    var selectedBlock = null;
                                                    for(var i = 0 ; i < project.blocks.length; i++){
                                                        if(room > lastBlockCountTemp && room <= lastBlockCountTemp + project.blocks[i].housing_count){
                                                            selectedBlock = project.blocks[i].block_name
                                                        }

                                                        if(room > lastBlockCountTemp3){
                                                            lastBlockCountTemp2 += project.blocks[i].housing_count;
                                                        }
                                                        
                                                        lastBlockCountTemp += project.blocks[i].housing_count;
                                                        lastBlockCountTemp3 += project.blocks[i].housing_count;
                                                    }

                                                    return(
                                                        <div  onClick={() => {changeRoom(room - 1)}} className='badge badge-phoenix badge-phoenix-success mx-1 my-1 c-pointer'>
                                                            {selectedBlock} {room - lastBlockCountTemp2} No'lu Konut <i className='fa fa-times'></i>
                                                        </div>
                                                    )
                                                }else{
                                                    return(
                                                        <div  onClick={() => {changeRoom(room - 1)}} className='badge badge-phoenix badge-phoenix-success mx-1 my-1 c-pointer'>
                                                            {room} <i className='fa fa-times'></i>
                                                        </div>
                                                    )
                                                }
                                                
                                            })
                                        }
                                    </div>
                                </div> 

                                : ''
                            }
                        </div>
                        {
                            selectedRooms.length > 0 ? 
                                <div>
                                    <span onClick={() => {setSelectedColumn("price");setIsDotType(true);setSelectedType('Fiyat');setUpdateHousingModalOpen(true)}} className="price-update cursor-pointer badge badge-phoenix badge-phoenix-primary btn-sm mx-1">
                                        Fiyatları Güncelle
                                    </span>
                                    <span
                                        onClick={() => {setSelectedColumn("installments-price");setIsDotType(true);setSelectedType('Taksitli Fiyat');setUpdateHousingModalOpen(true)}}
                                        className="installments-price-update cursor-pointer badge badge-phoenix badge-phoenix-primary btn-sm mx-1">
                                        Taksitli Fiyatları Güncelle
                                    </span>
                                    <span 
                                        onClick={() => {setUpdatePayDecModalOpen(true);setSelectedType('Ara Ödeme')}}
                                        className="pay-dec-update cursor-pointer badge badge-phoenix badge-phoenix-primary btn-sm mx-1">
                                        Ara Ödemeleri Güncelle
                                    </span>
                                    <span 
                                        onClick={() => {setSelectedColumn("installments");setIsDotType(false);setSelectedType('Taksit Sayısı');setUpdateHousingModalOpen(true)}}
                                        className="installments-update cursor-pointer badge badge-phoenix badge-phoenix-primary btn-sm mx-1">
                                        Taksit Sayılarını Güncelle
                                    </span>
                                    <span
                                        onClick={() => {setSelectedColumn("advance");setIsDotType(true);setSelectedType('Peşinat');setUpdateHousingModalOpen(true)}} 
                                        className="advance-update cursor-pointer badge badge-phoenix badge-phoenix-primary btn-sm mx-1">
                                        Peşinatları Güncelle
                                    </span>
                                </div> 
                            : ''
                        }
                    </div>
                    {
                        loading ? 
                            <TableRowsLoader/>
                        : 
                            rows.length > 0 ?
                                <>
                                    <TableContainer>
                                        <Table sx={{ minWidth: 650 }} aria-label="simple table">
                                            <TableHead>
                                                <TableRow>
                                                    <TableCell><input onChange={() => {selectedAllCheck ? selectAll() : selectAll()}} checked={selectedAllCheck} type="checkbox" /></TableCell>
                                                    <TableCell>No.</TableCell>
                                                    <TableCell>İlan Resmi</TableCell>
                                                    <TableCell>İlan Adı</TableCell>
                                                    <TableCell>Fiyat</TableCell>
                                                    <TableCell>Taksitli Fiyat</TableCell>
                                                    <TableCell>Ara Ödemeler</TableCell>
                                                    <TableCell>Taksit Sayısı</TableCell>
                                                    <TableCell>Peşinat</TableCell>
                                                    <TableCell>Hisse Sayısı</TableCell>
                                                    <TableCell>Satış Durumu</TableCell>
                                                    <TableCell>İşlemler</TableCell>
                                                </TableRow>
                                            </TableHead>
                                            <TableBody>
                                            {rows.map((row,key) => (
                                                <TableRow
                                                className={findSold(getLastCount() + key + 1) == 1 ? "non-sale" : findSold(getLastCount() + key + 1) == 0 ? "wait-sale" : ""}
                                                key={row.id}
                                                sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                                                >
                                                    <TableCell scope="row">
                                                        {
                                                            findSold(getLastCount() + key + 1) == 2 || !findSold(getLastCount() + key + 1) ?
                                                                <input onChange={() => changeRoom(getLastCount() + key)} checked={selectedRooms.includes(getLastCount() + key + 1)} type="checkbox" />
                                                            : ""
                                                        }
                                                    </TableCell>
                                                    <TableCell scope="row">
                                                        {(rowPerPage * page) + key + 1}
                                                    </TableCell>
                                                    <TableCell scope="row">
                                                        <div className='image-area' style={{width:'50px',height:'50px',display:'flex',alignItems:'center',justifyItems:'center'}}>
                                                            <div className="image-change" onClick={() => {setSelectedSingleItem(getLastCount() + key + 1);setSingleUpdateImageModalOpen(true);setSelectedColumn("image");setSelectedType('İlan Resimi');}}>
                                                                Resmi Değiştir
                                                            </div>
                                                            <img src={frontEndUrl+'project_housing_images/'+row['image[]']} alt="" />
                                                        </div>
                                                    </TableCell>
                                                    <TableCell >
                                                        <div style={{whiteSpace:'nowrap',alignItems:'center'}} className="d-flex">
                                                            {row['advertise_title[]']} 
                                                            {
                                                                findSold(getLastCount() + key + 1) == 2 || !findSold(getLastCount() + key + 1) ?
                                                                    <span onClick={() => {setChangeData(row['advertise_title[]']);setSelectedSingleItem(getLastCount() + key + 1);setSingleUpdateHousingModalOpen(true);setSelectedColumn("advertise_title");setIsDotType(false);setSelectedType('İlan Başlığı');}} className="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i className="fa fa-edit"></i></span>
                                                                : ""
                                                            }
                                                        </div>
                                                        <strong>
                                                            {
                                                                !row['share_sale[]'] || row['share_sale[]'] == "[]"? 
                                                                    ""
                                                                : "Hisseli Satış"
                                                            }
                                                        </strong>
                                                    </TableCell>
                                                    <TableCell >
                                                        <div className="d-flex" style={{whiteSpace:'nowrap',alignItems:'center'}}>
                                                            {dotNumberFormat(row['price[]'])} ₺
                                                            {
                                                                findSold(getLastCount() + key + 1) == 2 || !findSold(getLastCount() + key + 1) ?
                                                                    <span onClick={() => {setSelectedSingleItem(getLastCount() + key + 1);setSingleUpdateHousingModalOpen(true);setSelectedColumn("price");setIsDotType(true);setSelectedType('Fiyat');setChangeData(dotNumberFormat(row['price[]']))}} className="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i className="fa fa-edit"></i></span>
                                                                : ""
                                                            }
                                                        </div>
                                                    </TableCell>
                                                    <TableCell >
                                                        <div className="d-flex" style={{whiteSpace:'nowrap',alignItems:'center'}}>
                                                            {dotNumberFormat(row['installments-price[]'])} ₺
                                                            {
                                                                findSold(getLastCount() + key + 1) == 2 || !findSold(getLastCount() + key + 1) ?
                                                                    <span onClick={() => {setChangeData(dotNumberFormat(row['installments-price[]']));setSelectedSingleItem(getLastCount() + key + 1);setSingleUpdateHousingModalOpen(true);setSelectedColumn("installments-price");setIsDotType(true);setSelectedType('Taksitli Fiyat');}} className="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i className="fa fa-edit"></i></span>
                                                                : ""
                                                            }
                                                        </div>
                                                    </TableCell>
                                                    <TableCell >
                                                        {
                                                                findSold(getLastCount() + key + 1) == 2 || !findSold(getLastCount() + key + 1) ?
                                                                <span onClick={() => {setSelectedSingleItem(getLastCount() + key + 1);setUpdatePayDecModalOpen(true);setPayDecs(getLastCount() + key + 1)}} className="badge badge-phoenix badge-phoenix-primary batch_update_button">
                                                                    Ara ödemeleri güncelle 
                                                                    <br/>
                                                                    {row['pay-dec-count'+(getLastCount() + key + 1)] > 0 ? row['pay-dec-count'+(getLastCount() + key + 1)] : 0} Adet ara ödeme bulunmakta
                                                                </span>
                                                            : 
                                                                <span className='badge badge-phoenix badge-phoenix-success'>Ara Ödemeleri Gör ({row['pay-dec-count'+(getLastCount() + key + 1)]})</span>
                                                        }
                                                    </TableCell>
                                                    <TableCell >
                                                        <div className="d-flex" style={{whiteSpace:'nowrap',alignItems:'center'}}>
                                                            {row['installments[]']}
                                                            {
                                                                findSold(getLastCount() + key + 1) == 2 || !findSold(getLastCount() + key + 1) ?
                                                                    <span onClick={() => {setChangeData(dotNumberFormat(row['installments[]']));setSelectedSingleItem(getLastCount() + key + 1);setSingleUpdateHousingModalOpen(true);setSelectedColumn("installments");setIsDotType(true);setSelectedType('Taksit Sayısı');}} className="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i className="fa fa-edit"></i></span>
                                                                : ""
                                                            }
                                                        </div>
                                                    </TableCell>
                                                    <TableCell >
                                                        <div className="d-flex" style={{whiteSpace:'nowrap',alignItems:'center'}}>
                                                            {dotNumberFormat(row['advance[]'])} ₺
                                                            {
                                                                findSold(getLastCount() + key + 1) == 2 || !findSold(getLastCount() + key + 1) ?
                                                                    <span onClick={() => {setChangeData(dotNumberFormat(row['advance[]']));setSelectedSingleItem(getLastCount() + key + 1);setSingleUpdateHousingModalOpen(true);setSelectedColumn("advance");setIsDotType(true);setSelectedType('Peşinat');}} className="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i className="fa fa-edit"></i></span>
                                                                : ""
                                                            }
                                                        </div>
                                                    </TableCell>
                                                    <TableCell >
                                                        <div className="d-flex" style={{whiteSpace:'nowrap',alignItems:'center'}}>
                                                            {dotNumberFormat(row['number_of_shares[]'])}
                                                            {
                                                                findSold(getLastCount() + key + 1) == 2 || !findSold(getLastCount() + key + 1) ?
                                                                    <span onClick={() => {setChangeData(row['number_of_shares[]']);setSelectedSingleItem(getLastCount() + key + 1);setSingleUpdateHousingModalOpen(true);setSelectedColumn("number_of_shares");setIsDotType(true);setSelectedType('Hisse Sayısı');}} className="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i className="fa fa-edit"></i></span>
                                                                : ""
                                                            }
                                                        </div>
                                                    </TableCell>
                                                    <TableCell>
                                                        <div className="d-flex">

                                                            <div>
                                                                {
                                                                    row['share_sale[]'] && row['share_sale[]'] != "[]" ? 
                                                                        <div className="mb-2 d-flex">
                                                                            <span className='badge badge-phoenix badge-phoenix-info'>
                                                                                Hisse Sayısı
                                                                            </span>
                                                                            <span className='badge badge-phoenix badge-phoenix-success mx-2'>
                                                                            {
                                                                                row['share_sale[]'] != "[]" ? 
                                                                                    findOrderQt(getLastCount() + key + 1)+" / "+row['number_of_shares[]']
                                                                                : ""
                                                                            }
                                                                            </span>
                                                                        </div>
                                                                    : ""
                                                                }
                                                                
                                                                {
                                                                    row['share_sale[]'] && row['share_sale[]'] != "[]" ? 
                                                                        <div className="d-flex">
                                                                            {
                                                                                findOrderQt(getLastCount() + key + 1) == 0 ?
                                                                                    row['off_sale[]'] == '[]' ?
                                                                                        <button className="badge badge-phoenix badge-phoenix-success value-text">
                                                                                            Satışa Açık
                                                                                        </button>
                                                                                    : 
                                                                                        <button className="badge badge-phoenix badge-phoenix-danger value-text">
                                                                                            Satışa Kapatıldı 
                                                                                        </button>
                                                                                : <button className="badge badge-phoenix badge-phoenix-success value-text">
                                                                                    Satışa Açık
                                                                                </button>
                                                                            }
                                                                            {
                                                                                findOrderQt(getLastCount() + key + 1) == 0 ?
                                                                                    <span onClick={() => {setSelectedSingleItem(getLastCount() + key + 1);setChangePaymentStatusOpen(true)}} className="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i className="fa fa-edit"></i></span>
                                                                                : 
                                                                                    <Tooltip title="Bu ilanda hisse satıldığı için satış durumunda değişiklik yapılamaz" placement="top">
                                                                                        <InfoIcon className='info-icon'/>
                                                                                    </Tooltip>
                                                                            }
                                                                        </div>
                                                                        : ""
                                                                }
                                                                {
                                                                    !row['share_sale[]'] || row['share_sale[]'] == "[]" ? 
                                                                        <div className="d-flex">
                                                                            {
                                                                                findSold(getLastCount() + key + 1) != null ? 
                                                                                    findSold(getLastCount() + key + 1) == 0 ? 
                                                                                        <button className="badge badge-phoenix badge-phoenix-warning">Ödeme Bekleniyor</button>
                                                                                    : 
                                                                                        findSold(getLastCount() + key + 1) == 1 ? 
                                                                                            <button class="badge badge-phoenix badge-phoenix-danger">Satıldı </button>
                                                                                        : 
                                                                                            <button class="badge badge-phoenix badge-phoenix-success">Tekrar Satışta</button>
                                                                                : 
                                                                                    row['off_sale[]'] == '[]' ?
                                                                                        <div className='d-flex'>
                                                                                            <button className="badge badge-phoenix badge-phoenix-success value-text">
                                                                                                Satışa Açık
                                                                                            </button>
                                                                                            <span onClick={() => {setSelectedSingleItem(getLastCount() + key + 1);setChangePaymentStatusOpen(true)}} className="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i className="fa fa-edit"></i></span>
                                                                                        </div>  
                                                                                    : 
                                                                                        <div className='d-flex'>
                                                                                            <button className="badge badge-phoenix badge-phoenix-danger value-text">
                                                                                                Satışa Kapatıldı 
                                                                                            </button>
                                                                                            <span onClick={() => {setSelectedSingleItem(getLastCount() + key + 1);setChangePaymentStatusOpen(true)}} className="badge badge-phoenix badge-phoenix-primary edit-button-table mx-2 cursor-pointer d-block"><i className="fa fa-edit"></i></span>
                                                                                        </div>  
                                                                            }
                                                                        </div>
                                                                    : ""
                                                                }
                                                                
                                                            </div>
                                                        </div>
                                                    </TableCell>
                                                    <TableCell>
                                                        <a href={frontEndUrl+'institutional/projects/'+projectId+'/housings/edit/'+(getLastCount() + key + 1)} className='badge badge-phoenix badge-phoenix-primary'>İlanı Düzenle</a>
                                                    </TableCell>
                                                </TableRow>
                                            ))}
                                            </TableBody>
                                        </Table>
                                    </TableContainer>
                                    <TablePagination
                                        rowsPerPageOptions={[5, 10, 15,20, { label: 'All', value: 999 }]}
                                        colSpan={3}
                                        count={totalProjectsCount}
                                        rowsPerPage={rowPerPage}
                                        page={page}
                                        slotProps={{
                                            select: {
                                            inputProps: {
                                                'aria-label': 'rows per page',
                                            },
                                            native: true,
                                            },
                                        }}
                                        onPageChange={handleChangePage}
                                        onRowsPerPageChange={handleChangeRowsPerPage}
                                        ActionsComponent={TablePaginationActions}
                                        labelDisplayedRows={
                                            ({ from, to, count }) => {
                                            return count + ' veriden ' + from + '-' + to + ' gösteriliyor '; 
                                            }
                                        }
                                        labelRowsPerPage={"Gösterilen proje sayısı"}
                                    />
                                </>
                            : 
                                <div className="not-found">
                                    <div className="card">
                                        <span>Bu kategoride proje bulunamadı</span>
                                        <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" alt="" />
                                    </div>
                                </div>
                    }
                </div>
                <UpdateHousingModal saveHousing={saveHousing} data={changeData} setData={setChangeData} open={updateHousingModalOpen} selectedType={selectedType} setOpen={setUpdateHousingModalOpen} isDotType={isDotType} />
                <UpdateSingleHousingModal saveSingleHousing={saveSingleHousing} saveHousing={saveMultipleHousing} data={changeData} setData={setChangeData} open={updateSingleHousingModalOpen} selectedType={selectedType} setOpen={setSingleUpdateHousingModalOpen} isDotType={isDotType} />
                <ImageChange saveSingleHousing={saveImageSingle} saveHousing={saveImageMultiple} data={changeData} setData={setChangeData} open={updateSingleImageModalOpen} selectedType={selectedType} setOpen={setSingleUpdateImageModalOpen} />
                <PayDecTable savePayDecsSingle={savePayDecsSingle} saveSelectedHousing={savePayDecSelectedHousing} saveHousing={savePayDecs} data={payDecData} setData={setPayDecData} open={updatePayDecModalOpen} selectedType={selectedType} setOpen={setUpdatePayDecModalOpen} />
                <ChangePaymentStatus saveSingleHousing={savePaymentStatusSingle} saveHousing={savePaymentStatus} data={changeData} setData={setChangeData} open={changePaymentStatusOpen} selectedType={selectedType} setOpen={setChangePaymentStatusOpen} />
            </div>
        </div>
    )
}
export default HousingList