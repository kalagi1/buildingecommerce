import { useEffect, useMemo, useRef, useState } from 'react';

//MRT Imports
import {
    MaterialReactTable,
    useMaterialReactTable,
    MRT_GlobalFilterTextField,
    MRT_ToggleFiltersButton,
} from 'material-react-table';

//Material UI Imports
import {
    Box,
    Button,
    FormControl,
    FormControlLabel,
    ListItemIcon,
    MenuItem,
    Popover,
    Skeleton,
    Switch,
    Typography,
    lighten,
} from '@mui/material';

import UpdateHousingModal from './create_project_components/UpdateHousingModal';
import UpdateSingleHousingModal from './create_project_components/UpdateSingleHousingModal';
import PayDecTable from './create_project_components/PayDecTable';
import ImageChange from './create_project_components/ImageChange';
import EditIcon from '@mui/icons-material/Edit';
import UserIcon from '@mui/icons-material/Person';
import ReceiptIcon from '@mui/icons-material/Receipt';

const HousingList = ({ projectId }) => {

    const [selectedBlock, setSelectedBlock] = useState(0);
    const [haveBlocks, setHaveBlocks] = useState(0);
    const [loading, setLoading] = useState(true);
    const [pagination, setPagination] = useState({
        pageIndex: 0,
        pageSize: 20, //customize the default page size
    });
    const [blockx,setBlocksx] = useState([]);
    const [totalProjectsBlocksx,setTotalProjectsBlockx] = useState(0);
    const [totalProjectsCount, setTotalProjectsCount] = useState(0);
    const [page, setPage] = useState(0);
    const [selectedRooms, setSelectedRooms] = useState([]);
    const [updateHousingModalOpen, setUpdateHousingModalOpen] = useState(false);
    const [changeData, setChangeData] = useState("");
    const [payDecData, setPayDecData] = useState([]);
    const [selectedType, setSelectedType] = useState("");
    const [isDotType, setIsDotType] = useState(false);
    const [selectedColumn, setSelectedColumn] = useState("");
    const [selectedSingleItem, setSelectedSingleItem] = useState(null);
    const [updateSingleHousingModalOpen, setSingleUpdateHousingModalOpen] = useState(false);
    const [updateSingleImageModalOpen, setSingleUpdateImageModalOpen] = useState(false);
    const [updatePayDecModalOpen, setUpdatePayDecModalOpen] = useState(false);
    const [sumCartQts, setSumCartQts] = useState([]);
    const [installments,setInstallments] = useState([]);
    const [solds, setSolds] = useState([]);
    const [selectedRoomsTemp,setSelectedRoomsTemp] = useState([]);
    const [selectedRoomsTemp2,setSelectedRoomsTemp2] = useState([]);
    const [customEditOpen,setCustomEditOpen] = useState(false);
    const [allSelectedCheckbox,setAllSelectedCheckbox] = useState(false);
    const [saleModalOpen,setSaleModalOpen] = useState(false);
    const [selectedSaleData,setSelectedSaleData] = useState({});
    const [selectedRoomOrder,setSelectedRoomOrder] = useState(null);
    const [project, setProject] = useState({
        blocks: []
    });
    const [selectedData,setSelectedData] = useState({});
    const [selectedId,setSelectedId] = useState(null);
    const [paymentModalOpen,setPaymentModalOpen] = useState(false);
    const [saleCloses,setSaleCloses] = useState([]);
    const [paymentModalLoading,setPaymentModalLoading] = useState(false);

    const getLastBlockCount = () => {
        var blockItemCount = 0;
        if (haveBlocks) {
            project.blocks.map((block, key) => {
                if (key < selectedBlock) {
                    blockItemCount += block.housing_count
                }
            })
        }
        return blockItemCount;
    }


    const getLastCount = () => {
        if (haveBlocks) {
            return getLastBlockCount() + ((pagination.pageIndex)  * pagination.pageSize);
        } else {
            return ((pagination.pageIndex) * pagination.pageSize)
        }
    }

    const [data, setData] = useState([])

    const axiosRequestGetData = (newPage) => {
        setLoading(true);
        var start = newPage * pagination.pageSize;
        var end = (newPage + 1) * pagination.pageSize;
        axios.get(baseUrl + 'project_housings/' + projectId + `?start=${start}&end=${end}&block=`+selectedBlock).then((res) => {
            const dizi = [];

            // Nesnenin her özelliğini diziye ekleyelim
            for (let key in res.data.rows) {
                // Sadece nesne kendi özelliklerini kontrol etmek için 'hasOwnProperty' kullanıyoruz
                if (res?.data?.rows?.hasOwnProperty(key)) {
                    dizi.push(res.data.rows[key]);
                }
            }
            setData(dizi);
            setProject(res.data.project)
            setBlocksx(res.data.project.blocks);
            if (res.data.project.have_blocks) {
                var totalxCount = 0;
                for(var i = 0; i < res.data.project.blocks.length; i++){
                    totalxCount += res.data.project.blocks[i].housing_count;
                }
                setTotalProjectsBlockx(totalxCount);
                setTotalProjectsCount(res.data.project.blocks[selectedBlock].housing_count);
            } else {
                setTotalProjectsCount(res.data.project.room_count);
                setTotalProjectsBlockx(res.data.project.room_count);
            }
            var result2 = Object.keys(res.data.sumCartOrderQt).map((key) => res.data.sumCartOrderQt[key])
            setSumCartQts(result2);
            setHaveBlocks(res.data.project.have_blocks)
            setSolds(res.data.solds)
            setLoading(false);
        })

        // console.log(totalProjectsBlocksx);

        axios.get(baseUrl+'get_sale_closes/'+projectId).then((res) => {
            setSaleCloses(res.data.sale_closes);
        })
    }

    // console.log(data);

    const savePayDecSelectedHousing = () => {
        axios.post(baseUrl + 'save_pay_dec', {
            rooms: selectedRooms,
            value: payDecData,
            project_id: projectId
        }).then((res) => {
            if (res.data.status) {
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");

                axiosRequestGetData(pagination.pageIndex)
            }
        })
    }

    const savePayDecsSingle = () => {
        var tempSelected = [selectedSingleItem];

        axios.post(baseUrl + 'save_pay_dec', {
            rooms: tempSelected,
            value: payDecData,
            project_id: projectId
        }).then((res) => {
            if (res.data.status) {
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");

                axiosRequestGetData(pagination.pageIndex)
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

        return tempSeleced;
    }

    const savePayDecs = () => {
        var tempSelected = [];
        if (haveBlocks) {
            tempSelected = blockSelects();
        } else {
            for (var i = 0; i < totalProjectsCount; i++) {
                tempSelected.push(i + 1);
            }
        }

        axios.post(baseUrl + 'save_pay_dec', {
            rooms: tempSelected,
            value: payDecData,
            project_id: projectId
        }).then((res) => {
            if (res.data.status) {
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");

                axiosRequestGetData(pagination.pageIndex)
            }
        })
    }

    const removeSelectedRoom = (selectedRoom) => {
        var items2 = {...selectedRoomsTemp};
        items2 = Object.keys(items2);
        var newItems2 = {};
        items2.map((item) => {
            if(parseInt(item) != parseInt(selectedRoom)){
                newItems2[item] = true
            }
        });

        setSelectedRoomsTemp(newItems2);
    }

    useEffect(() => {
        axiosRequestGetData(pagination.pageIndex);
    }, [pagination,selectedBlock])

    const setPayDecDataFunc = (data,index) => {
        var payDecItems = [];
        for(var i = 0 ; i < data["pay-dec-count"+index]; i++){
            payDecItems.push({
                price : dotNumberFormat(data['pay_desc_price'+index+i]),
                date : data['pay_desc_date'+index+i]
            })
        }


        setPayDecData(payDecItems);
    }

    useEffect(() => {
        var newItems = {};

        Object.keys(selectedRoomsTemp).forEach((selectedRoom) => {
            newItems[(parseInt(selectedRoom) - getLastCount())] = true;
        })

        setSelectedRoomsTemp2(newItems)
    },[selectedRoomsTemp])

    const allSelected = () => {
        if(allSelectedCheckbox){
            tempSelected = {};
        }else{
            var tempSelected = {};
            for (var i = 0; i < totalProjectsBlocksx; i++) {
                var soldx = solds.find((sold) => {
                    var soldJson = JSON.parse(sold.cart);
                    if(soldJson.item.id == projectId && soldJson.item.housing ==  i + 1 && soldJson.type == "project" && (sold.status == 1 || sold.status == 0)){
                        return sold
                    }
                })
                if(!soldx){
                    tempSelected[i+1] = true;   
                }
            }
        }
        
        setAllSelectedCheckbox(!allSelectedCheckbox);

        setSelectedRoomsTemp(tempSelected);
    }

    const salesCount = () => {
        var saleCount = 0;
        var saleCloseCount = 0;
        solds.map((sold) => {
            if(sold.status == 0 || sold.status == 1){
                saleCount++;
            }
        })

        for(var i = 0; i < saleCloses.length; i++){
            var soldx = solds.find((sold) => {
                var soldJson = JSON.parse(sold.cart);
                if(soldJson.item.id == projectId && soldJson.item.housing == saleCloses[i].room_order && soldJson.type == "project" && (sold.status == 1 || sold.status == 0)){
                    return sold
                }
            })
            if(!soldx){
                saleCloseCount++;
            }
        }

        return {
            saleCount : saleCount,
            saleCloseCount: saleCloseCount,
            saleOpenCount : project.room_count - saleCloseCount - saleCount
        }
    }

    const saveHousing = () => {
        var itemsx = Object.keys(selectedRoomsTemp)
        var newItems =  itemsx.map((item) => parseInt(item));
        axios.post(baseUrl + 'save_housing', {
            rooms: newItems,
            column_name: selectedColumn,
            value: changeData,
            is_dot: isDotType,
            project_id: projectId
        }).then((res) => {
            if (res.data.status) {
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
                setSelectedRoomsTemp({});
                axiosRequestGetData(page)
            }
        })
    }

    const reloadData = () => {
        setLoading(true);
        setChangeData("");
        setSelectedRooms([]);
        toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");
        setSelectedRoomsTemp({});
        setAllSelectedTable(false);
        setAllSelectedCheckbox(false);
        axiosRequestGetData(pagination.pageIndex)
    }

    const reloadData2 = () => {
        setLoading(true);
        setChangeData("");
        setSelectedRooms([]);
        setSelectedRoomsTemp({});
        axiosRequestGetData(pagination.pageIndex)
    }

    const saveSingleHousing = () => {
        var tempSelected = [];
        tempSelected.push(selectedSingleItem)

        axios.post(baseUrl + 'save_housing', {
            rooms: tempSelected,
            column_name: selectedColumn,
            value: changeData,
            is_dot: isDotType,
            project_id: projectId
        }).then((res) => {
            if (res.data.status) {
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");

                axiosRequestGetData(page)
            } else {
                toast.error(res.data.error)
            }
        })
    }

    const saveMultipleHousing = () => {
        var tempSelected = [];
        if (haveBlocks) {
            tempSelected = blockSelects();
        } else {
            for (var i = 0; i < totalProjectsCount; i++) {
                tempSelected.push(i + 1);
            }
        }

        axios.post(baseUrl + 'save_housing', {
            rooms: tempSelected,
            column_name: selectedColumn,
            value: changeData,
            is_dot: isDotType,
            project_id: projectId
        }).then((res) => {
            if (res.data.status) {
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");

                axiosRequestGetData(page)
            } else {
                toast.error(res.data.error)
            }
        })
    }

    const setPayDecs = () => {
        axios.post(baseUrl + 'save_housing', {
            rooms: selectedRooms,
            column_name: selectedColumn,
            value: changeData,
            is_dot: isDotType,
            project_id: projectId
        }).then((res) => {
            if (res.data.status) {
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");

                axiosRequestGetData(page)
            }
        })
    }

    const saveImageSingle = () => {
        var tempSelected = [selectedSingleItem];


        var formData = new FormData();

        for (var i = 0; i < tempSelected.length; i++) {
            formData.append('rooms[' + i + ']', tempSelected[i]);
        }
        formData.append('column_name', selectedColumn);
        formData.append('value', changeData);
        formData.append('project_id', projectId);
        axios.post(baseUrl + 'change_image', formData).then((res) => {
            if (res.data.status) {
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");

                axiosRequestGetData(page)
            }
        })
    }

    const saveImageMultiple = () => {
        var tempSelected = [];
        if (haveBlocks) {
            tempSelected = blockSelects();
        } else {
            for (var i = 0; i < totalProjectsCount; i++) {
                tempSelected.push(i + 1);
            }
        }

        var formData = new FormData();

        for (var i = 0; i < tempSelected.length; i++) {
            formData.append('rooms[' + i + ']', tempSelected[i]);
        }
        formData.append('column_name', selectedColumn);
        formData.append('value', changeData);
        formData.append('project_id', projectId);
        axios.post(baseUrl + 'change_image', formData).then((res) => {
            if (res.data.status) {
                setLoading(true);
                setChangeData("");
                setSelectedRooms([]);
                toast.success("Başarıyla seçtiğiniz ilanları güncellediniz");

                axiosRequestGetData(page)
            }
        })
    }

    const paymentModalFunc = (id) => {             
        setPaymentModalOpen(true);
        id = id - getLastCount();
        setSelectedRoomOrder(id);
        var saleData = {};
        setLoading(true); 
        setPaymentModalLoading(true);
        axios.get(baseUrl + 'get_sale/' + projectId + '/' + (getLastCount() + id))
            .then((res) => {
                if (res.data.data && res.data.data.pay_decs) {
                    var payDecx = JSON.parse(res.data.data.pay_decs);
                } else {
                    var payDecx = [];
                }
                solds.map((sold) => {
                    var cart = JSON.parse(sold.cart);
                    try{
                        if (cart.item.id == projectId && cart.item.housing == getLastCount() + id) {
                            var payDecs = [];
                            if(data){
                                for (var i = 0; i < data[id - 1]['pay-dec-count' + (getLastCount() + id)]; i++) {
                                    payDecs.push({});
                                    payDecs[i]['price'] = data[id - 1]['pay_desc_price' + (getLastCount() + id) + "" + i];
                                    payDecs[i]['date'] = data[id - 1]['pay_desc_date' + (getLastCount() + id) + "" + i];
                                    payDecs[i]['description'] = res.data.data?.pay_dec_description ? JSON.parse(res.data.data?.pay_dec_description)[i]?.description : "";
                                    payDecs[i]['status'] = payDecx.includes(i + 1) ? true : false;
                                }
                            }
                            console.log(sold)
                            
                            saleData['name']                            = sold.full_name;
                            saleData['email']                           = sold.email;
                            saleData['phone']                           = sold.phone;
                            saleData['sale_type']                       = sold.is_swap == 0 ? 1 : 2;
                            saleData['price']                           = sold.is_swap == 0 ? data[id - 1]['price[]'] : data[id - 1]['installments-price[]'];
                            saleData['installment_price']               = data[id - 1]['installments-price[]'];
                            saleData['advance']                         = data[id - 1]['advance[]'];
                            saleData['installments']                    = data[id - 1]['installments[]'];
                            saleData['pay_decs']                        = payDecs;
                            saleData['down_payment']                    = res.data.data?.down_payment;
                            saleData['advance_payment']                 = res.data.data?.advance;
                            saleData['down_payment_price']              = res.data.data?.down_payment_price;
                            saleData['advance_date']                    = res.data.data?.advance_date;
                            saleData['deposit_date']                    = res.data.data?.deposit_date;
                            saleData['show_neighbour']                  = sold.is_show_user === "on" ? true : false;
                            saleData['down_payment_price_description']  = res.data.data?.down_payment_price_description,
                            saleData['advance_date_description']        = res.data.data?.advance_date_description;
                            saleData['title_deed_date'] = res.data.data?.title_deed_date;
                            saleData['agreement_date'] = res.data.data?.agreement_date;
                            saleData['agreement_no'] = res.data.data?.agreement_no;
                            saleData['pay_dec_description'] = JSON.parse(res.data.data?.pay_dec_description);
                            saleData['changer'] = res?.data?.changer;
                        }
                    }catch(err){
                        console.log(err)
                    }
                });
                setSelectedSaleData(saleData);
                setLoading(false); // End loading   
                setSelectedId(id);
                setSelectedData(data[id - 1]);
            })
            .catch(() => {
                setLoading(false); // End loading on error
            });
    
    }

    const [refs, setRefs] = useState([]);
    const ref2 = useRef();

    const containerRef = useRef(null);

    useEffect(() => {
        const divs = containerRef.current.querySelectorAll('.scrollable');
        const newRefs = Array.from(divs).map((_, index) => React.createRef());
        setRefs(newRefs);
    
        
    
        newRefs.forEach((ref, index) => {
            console.log(ref);
          if (ref.current) {
            ref.current.addEventListener('scroll', handleScroll);
          }
        });
    
      }, [data]);

    const handleScroll = (e) => {
        const scrollLeft = e.target.scrollLeft;
        refs.forEach((ref, index) => {
            if (ref.current && ref.current !== e.target) {
                ref.current.scrollLeft = scrollLeft;
                ref2.current.scrollLeft = scrollLeft;
            }
        });
    };

    const allSelectedShowItems = (e) => {

        if(e.target.checked){
            var tempItems = selectedRoomsTemp;
            var end = 20;
            console.log(getLastCount() + 20,project.room_count);
            if(getLastCount() + 20 > project.room_count){
                end = project.room_count - getLastCount();
            }
            for(var i = 0 ; i < end ; i++){
                var soldx = solds.find((sold) => {
                    var soldJson = JSON.parse(sold.cart);
                    if(soldJson.item.id == projectId && soldJson.item.housing == getLastCount() + i + 1 && soldJson.type == "project" && (sold.status == 1 || sold.status == 0)){
                        return sold
                    }
                })

                if(!soldx){
                    tempItems[getLastCount() + i + 1] = true;
                }
            }
            setSelectedRoomsTemp(tempItems)
            setAllSelectedTable(true);
        }else{
            var tempItems = {};

            for(var i = 1; i < Object.keys(selectedRoomsTemp).length; i++){
                if(i > getLastCount() && i < getLastCount() + 20){

                }else{
                    tempItems[i] = selectedRoomsTemp[i]
                }
            }
            setSelectedRoomsTemp(tempItems);
            setAllSelectedTable(false);
        }
        
    }

    const allSelectedOpenFunc = () => {
        if(Object.keys(selectedRoomsTemp).length > 0){
            setCustomEditOpen(true)
        }else{
            toast.error("Toplu ilan güncellemesi yapmanız için lütfen ilan seçiniz")
        }
    }

    const [pageCountGlob,setPageCountGlob] = useState([]);

    useEffect(() => {
        if(project?.have_blocks){
            var roomCount = project.blocks[selectedBlock].housing_count;
            var pageCount = roomCount / 20;
            var pageCountInt = parseInt(roomCount / 20);
            pageCount = pageCount != pageCountInt ? pageCountInt + 1 : pageCountInt;
            
            var temp = [];

            for(var i = 0 ; i < pageCount; i++){
                temp.push(i);
            }

            setPageCountGlob(temp)
        }else{
            var roomCount = project.room_count;
            var pageCount = roomCount / 20;
            var pageCountInt = parseInt(roomCount / 20);
            pageCount = pageCount != pageCountInt ? pageCountInt + 1 : pageCountInt;
            
            var temp = [];

            for(var i = 0 ; i < pageCount; i++){
                temp.push(i);
            }

            setPageCountGlob(temp)
        }
    },[project])


    const [allSelectedTable,setAllSelectedTable] = useState(false);

    console.log(pageCountGlob)

    const getNextPage = () => {
        if(pagination.pageIndex < pageCountGlob.length - 1){
            setPagination({
                pageIndex : pagination.pageIndex + 1,
                pageSize : 20
            })
        }
    }

    const getPrevPage = () => {
        if(pagination.pageIndex > 0){
            setPagination({
                pageIndex : 0,
                pageSize : 20
            })
        }
    }

    const selectedSingleItemFunc = (roomOrder) => {
        var tempItems = selectedRoomsTemp;
        if(Object.keys(tempItems).find((tempItem) => roomOrder == tempItem)){
            var items2 = {...selectedRoomsTemp};
            items2 = Object.keys(items2);
            var newItems2 = {};
            items2.map((item) => {
                if(parseInt(item) != parseInt(roomOrder)){
                    newItems2[item] = true
                }
            });

            setSelectedRoomsTemp(newItems2);
        }else{
            setSelectedRoomsTemp({
                ...selectedRoomsTemp,
                [roomOrder] : true
            })
        }
        
    }


    const id = open ? 'simple-popover' : undefined;
    const [anchorEl,setAnchorEl] = useState(null);
    const popoverOpen = Boolean(anchorEl);
    const [selectedRow,setSelectedRow] = useState(null)
    const [isSelectedSold,setIsSelectedSold] = useState(false);

    const handlePopoverClick = (event,row,isSold) => {
        setAnchorEl(event.currentTarget);
        setSelectedRow(row);
        setIsSelectedSold(isSold);
    };

    const handleClose = () => {
        setAnchorEl(null);
    };

    return (
        <>
            <Popover
                id={id}
                open={popoverOpen}
                anchorEl={anchorEl}
                onClose={handleClose}
                anchorOrigin={{
                vertical: 'bottom',
                horizontal: 'center',
                }}
                transformOrigin={{
                vertical: 'top',
                horizontal: 'center',
                }}
            >
                <ul className="popover-project-actions p-relative">
                    {
                        isSelectedSold ? 
                            <>
                                <li className="d-flex">
                                    <a onClick={(e) => {e.preventDefault();e.stopPropagation();paymentModalFunc(getLastCount() + selectedRow + 1);setAnchorEl(null)}}>Ödeme Planını Düzenle</a>
                                </li>
                                <li className="d-flex">
                                    <a onClick={(e) => {
                                        var anchor = document.createElement('a');
                                        // console.log(frontEndUrl+'react/render_pdf/'+projectId+'/'+(getLastCount() + row.index + 1));
                                        anchor.href = frontEndUrl+'react/render_pdf/'+projectId+'/'+(getLastCount() + selectedRow + 1);
                                        anchor.target="_blank";
                                        anchor.click();
                                    }}>Çıktı Al</a>
                                </li>
                            </>
                        : 
                            <li className="d-flex">
                                <a onClick={(e) => {window.location.href = frontEndUrl+'hesabim/projects/'+projectId+'/housings/edit/'+(selectedRow + 1); closeMenu();}}>İlanı Düzenle</a>
                            </li>
                    }
                    
                </ul>
            </Popover>
            
            {
                loading ? 
                    <>
                        <div>
                            <div className="row" style={{justifyContent:'space-between'}}>
                                <div className="col-md-6">
                                    <Skeleton animation="wave" width={'100%'} style={{height : '30px',style:'100%'}} variant="rectangular" />
                                </div>
                                <div className="col-md-3">
                                    <Skeleton animation="wave" width={'100%'} style={{height : '30px',style:'100%'}} variant="rectangular" />
                                </div>
                            </div>
                            <div className="d-flex mt-3" style={{justifyContent:'space-between'}}>
                                <div className="d-flex">
                                    <Skeleton animation="wave" width={30} height={30} style={{marginRight:'5px'}} variant='rectangular'/>
                                    <Skeleton animation="wave" width={30} height={30} style={{marginRight:'5px'}} variant='rectangular'/>
                                    <Skeleton animation="wave" width={30} height={30} style={{marginRight:'5px'}} variant='rectangular'/>
                                    <Skeleton animation="wave" width={30} height={30} style={{marginRight:'5px'}} variant='rectangular'/>
                                </div>
                                <div>
                                    <Skeleton animation="wave" width={160} height={30}  variant='rectangular'/>
                                </div>
                            </div>
                            <div className="d-flex mt-3" style={{justifyContent:'space-between'}}>
                                <div>
                                    <Skeleton animation="wave" width={190} height={30}  variant='rectangular'/>
                                </div>
                            </div>
                            <div>
                                <Skeleton variant="rounded" animation="wave" width='100%' height={60} style={{marginTop:'10px'}}/>
                                <Skeleton variant="rounded" animation="wave" width='100%' height={60} style={{marginTop:'10px'}}/>
                                <Skeleton variant="rounded" animation="wave" width='100%' height={60} style={{marginTop:'10px'}}/>
                                <Skeleton variant="rounded" animation="wave" width='100%' height={60} style={{marginTop:'10px'}}/>
                                <Skeleton variant="rounded" animation="wave" width='100%' height={60} style={{marginTop:'10px'}}/>
                                <Skeleton variant="rounded" animation="wave" width='100%' height={60} style={{marginTop:'10px'}}/>
                                <Skeleton variant="rounded" animation="wave" width='100%' height={60} style={{marginTop:'10px'}}/>
                                <Skeleton variant="rounded" animation="wave" width='100%' height={60} style={{marginTop:'10px'}}/>
                            </div>
                        </div>
                    </>
                : 
                    <>
                        <div style={{display:'flex',justifyContent:'space-between',marginBottom:'10px',alignItems:'center',marginBottom:'20px'}} >
                            <div className="table-breadcrumb">
                                <ul>
                                    <li><i className="fa fa-home"></i></li>
                                    <li>Ofisim</li>
                                    <li>{project.project_title} Adlı Projenin Konutları</li>
                                </ul>
                            </div>
                            <div style={{width:'30%'}}>
                                <div style={{display:'flex',justifyContent:'space-around'}}>
                                    <div className='info-color' style={{borderColor:'green',color:'green'}}>
                                        <span>Satışa Açık</span>
                                        <span >{salesCount()['saleOpenCount']}</span>
                                    </div>
                                    <div className='info-color' style={{borderColor:'rgba(240, 173, 78)',color:'rgba(240, 173, 78)'}}>
                                        <span>Satışa Kapalı</span>
                                        <span>{salesCount()['saleCloseCount']}</span>
                                    </div>
                                    <div className='info-color'>
                                        <span>Satıldı</span>
                                        <span>{salesCount()['saleCount']}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="d-flex" style={{marginBottom : '20px',justifyContent:'space-between'}}>
                            <div className="housing-pagination">
                                <ul>
                                    <li onClick={() => {getPrevPage()}} className={pagination.pageIndex != 0 ? 'active' : '' }><i className='fa fa-chevron-left'></i></li>
                                    {
                                        pageCountGlob.map((_,i) => {
                                            return(
                                                <li onClick={() => {setPagination({pageIndex : i , pageSize : 20});setAllSelectedTable(false)}} className={pagination.pageIndex == i ? "active" : ""}>{i + 1}</li>
                                            )
                                        })
                                    }
                                    <li onClick={() => [getNextPage()]} className={pagination.pageIndex != pageCountGlob.length - 1 ? 'active' : '' }><i className='fa fa-chevron-right'></i></li>
                                </ul>
                            </div>

                            <button onClick={() => {allSelectedOpenFunc()}} className={'edit-selected-items '+(!Object.keys(selectedRoomsTemp).length > 0 ? "disabled" : "")}>Seçilen İlanları Düzenle</button>
                        </div>
                        <div className="d-flex" style={{justifyContent:'space-between'}}>
                            {
                                haveBlocks ? 
                                    <div class="block-tabs mb-3">
                                        <ul>
                                            {
                                                project?.blocks?.map((block,index) => {
                                                    return(
                                                        <li onClick={() => {setSelectedBlock(index)}} className={selectedBlock == index ? "active" : ""}>{block.block_name}</li>
                                                    )
                                                })
                                            }
                                        </ul>
                                    </div>
                                : ''
                            }

                            <button className={'all_selected_button mb-4 '+(allSelectedCheckbox ? "" : "active")} onClick={() => {allSelected()}}> <span className='buyUserRequest__text'>{allSelectedCheckbox ? 'Seçimi Kaldır' : 'Projedeki Tüm Konutları Seç'}</span> </button>

                        </div>
                        {
                            Object.keys(selectedRoomsTemp).length > 0 ? 
                                <div className="selected-items-area">
                                    <h4>Seçilen Konutlar</h4>
                                    <div className='selected-items' id='style-x' style={{paddingBottom:'5px'}}>
                                        {
                                            haveBlocks ? 
                                                Object.keys(selectedRoomsTemp).map((selectedRoom,key) => {
                                                    var lastItemsCountx = 0;
                                                    var x = 0;
                                                    var blockName = "";
                                                    var selectedBlockIndex = 0;
                                                    for(var t = 0; t < blockx.length; t++ ){
                                                        x += blockx[t].housing_count;
                                                        if(selectedRoom > x){
                                                            lastItemsCountx += blockx[t].housing_count;
                                                            selectedBlockIndex = t + 1;
                                                        }
                                                    }
                                                    return(
                                                        <span onClick={() => {removeSelectedRoom(selectedRoom)}} style={{cursor:'pointer'}}  className='selected-item'>{ blockx[selectedBlockIndex].block_name +" "+ ( parseInt(selectedRoom) - lastItemsCountx)} <i className='fa fa-times'></i></span>
                                                    )
                                                })
                                            : 
                                                Object.keys(selectedRoomsTemp).map((selectedRoom,key) => {
                                                    return(
                                                        <span onClick={() => {removeSelectedRoom(selectedRoom)}} style={{cursor:'pointer'}}  className='selected-item'>{ ( parseInt(selectedRoom) )} <i className='fa fa-times'></i></span>
                                                    )
                                                })
                                        }
                                    </div>
                                </div>
                            : ''
                        }
                        <div className="project-housings-table-head">
                            <div className="pinned-left">
                                <span><input checked={allSelectedTable} type="checkbox" onChange={(e) => {allSelectedShowItems(e)}}/></span>
                                <span>No</span>
                            </div>
                            <div className="center-scroll" ref={ref2} onScroll={handleScroll} id='style-x'>
                                <span>İlan Görseli</span>
                                <span style={{width:'23%'}}>İlan Başlığı</span>
                                <span style={{width:'15%'}}>Fiyat</span>
                                <span>Taksitli Fiyat</span>
                                <span>Taksit Sayısı</span>
                                <span>Peşinat</span>
                                <span>Ara Ödemeler</span>
                                <span style={{textAlign:'center'}}>Hisse Sayısı</span>
                                <span>M² Net</span>
                                <span>M² Brüt</span>
                                <span>Oda Sayısı</span>
                                <span>Bulunduğu Kat</span>
                                <span>Satış Durumu</span>
                            </div>
                            <div className="pinned-right">
                                <span>İşlemler</span>
                            </div>
                        </div>
                    </>
            }
            
            <div ref={containerRef}>
                {
                    data.map((row,index) => {
                        var soldx = solds.find((sold) => {
                            var soldJson = JSON.parse(sold.cart);
                            if(soldJson.item.id == projectId && soldJson.item.housing == getLastCount() + index + 1 && soldJson.type == "project" && (sold.status == 1 || sold.status == 0)){
                                return sold
                            }
                        })

                        if(soldx){
                            return(
                                <div className="project-housings-table-row" style={{background : row['off_sale[]'] != "[]" ? "rgb(240 173 78 / 20%)" : "#fff"}}>
                                    <div className="sold-area">
                                        <div className="sold-area2">
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                            <div className="sold-item">Satıldı</div>
                                        </div>
                                        <div className='customer-info'>
                                            Alıcı Adı soyadı : {soldx.full_name}
                                        </div>
                                        <div className='customer-info'>
                                            Alıcı Telefon Numarası : {soldx.phone}
                                        </div>
                                        <div className='customer-info'>
                                            Satış Tipi : {soldx.is_swap == 0 ? "Peşin Satış" : "Taksitli Satış"}
                                        </div>
                                        <div className='customer-info'>
                                            Satış Fiyatı : {soldx.is_swap == 0 ? dotNumberFormat(row['price[]']) : dotNumberFormat(row['installments-price[]'])} ₺
                                        </div>
                                    </div>
                                    <div className="pinned-left">
                                        <span><input disabled type="checkbox" /></span>
                                        <span>{(getLastCount() + index + 1) - getLastBlockCount()}</span>
                                    </div>
                                    <div className="center-scroll scrollable" id='style-x' ref={refs[index]} onScroll={handleScroll}>
                                        <span className='table-row-image'><img src={frontEndUrl + 'project_housing_images/' + row['image[]']} alt="" /></span>
                                        <span style={{width:'23%'}}>{row['advertise_title[]']}</span>
                                        <span style={{width:'15%'}}>{dotNumberFormat(row['price[]'])}₺</span>
                                        <span>{dotNumberFormat(row['installments-price[]'])}₺</span>
                                        <span>{dotNumberFormat(row['installments[]'])}</span>
                                        <span>{dotNumberFormat(row['advance[]'])}₺</span>
                                        <span>
                                            <p onClick={() => { setSelectedSingleItem(getLastCount() + index + 1); setUpdatePayDecModalOpen(true); setPayDecDataFunc(row,getLastCount() + index + 1); }} className="pay-decs-button">
                                                <p>Ara ödemeleri güncelle</p>
                                                <p>{parseInt(row['pay-dec-count' + (getLastCount() + index + 1)]) > 0 ? row['pay-dec-count' + (getLastCount() + index + 1)] : 0} Ara Ödeme</p>
                                            </p>
                                        </span>
                                        <span>{row['number_of_shares[]']}</span>
                                        <span>{row['squaremeters[]']}m²</span>
                                        <span>{row['m2gross[]']}m²</span>
                                        <span>{row['room_count[]']}</span>
                                        <span>{row['floor_location[]']}</span>
                                        <span>
                                            {
                                                soldx ? 
                                                    <p className='sale-text'>
                                                        Satıldı
                                                    </p>  
                                                : 
                                                    row['off_sale[]'] == "[]" ?
                                                        <p className='sale-open-text'>Satışa Açık</p>
                                                    :   <p className='sale-close-text'>Satışa Kapalı</p>
                                            }
                                            {}
                                        </span>
                                    </div>
                                    <div className="pinned-right">
                                        <span onClick={(e) => {handlePopoverClick(e,index,true)}} className="project-table-content-actions-button" >
                                            <i className="fa fa-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                            )
                        }else{
                            var isChecked = false;
                            if(selectedRoomsTemp[getLastCount() + index + 1] && selectedRoomsTemp[getLastCount() + index + 1] == true){isChecked = true}
                            
                            return(
                                <div className="project-housings-table-row" style={{background : row['off_sale[]'] != "[]" ? "rgb(240 173 78 / 20%)" : "#fff"}}>
                                    {
                                        isChecked ? 
                                            <div className='selected-div'>

                                            </div>
                                        : ''
                                    }
                                    <div className="pinned-left">
                                        <span><input onChange={() => {selectedSingleItemFunc(getLastCount() + index + 1)}} type="checkbox" checked={selectedRoomsTemp[getLastCount() + index + 1] && selectedRoomsTemp[getLastCount() + index + 1] == true}/></span>
                                        <span>{(getLastCount() + index + 1) - getLastBlockCount()}</span>
                                    </div>
                                    <div className="center-scroll scrollable" id='style-x' ref={refs[index]} onScroll={handleScroll}>
                                        <span className='table-row-image'><img onClick={() => {setSingleUpdateImageModalOpen(true);setSelectedSingleItem( getLastCount() + index + 1);setSelectedColumn('image')}} src={frontEndUrl + 'project_housing_images/' + row['image[]']} alt="" /></span>
                                        <span style={{width:'23%'}}>{row['advertise_title[]']}</span>
                                        <span style={{width:'15%'}}>{dotNumberFormat(row['price[]'])}₺</span>
                                        <span>{dotNumberFormat(row['installments-price[]'])}₺</span>
                                        <span>{dotNumberFormat(row['installments[]'])}</span>
                                        <span>{dotNumberFormat(row['advance[]'])}₺</span>
                                        <span>
                                            <p onClick={() => { setSelectedSingleItem(getLastCount() + index + 1); setUpdatePayDecModalOpen(true); setPayDecDataFunc(row,getLastCount() + index + 1); }} className="pay-decs-button">
                                                <p>Ara ödemeleri güncelle</p>
                                                <p>{parseInt(row['pay-dec-count' + (getLastCount() + index + 1)]) > 0 ? row['pay-dec-count' + (getLastCount() + index + 1)] : 0} Ara Ödeme</p>
                                            </p>
                                        </span>
                                        <span style={{textAlign:'center'}}>{row['number_of_shares[]']}</span>
                                        <span>{row['squaremeters[]']}m²</span>
                                        <span>{row['m2gross[]']}m²</span>
                                        <span>{row['room_count[]']}</span>
                                        <span>{row['floor_location[]']}</span>
                                        <span>
                                            {
                                                soldx ? 
                                                    <p className='sale-text'>
                                                        Satıldı
                                                    </p>  
                                                : 
                                                    row['off_sale[]'] == "[]" ?
                                                        <p className='sale-open-text'>Satışa Açık</p>
                                                    :   <p className='sale-close-text'>Satışa Kapalı</p>
                                            }
                                            {}
                                        </span>
                                    </div>
                                    <div className="pinned-right">
                                        <span onClick={(e) => {handlePopoverClick(e,index,false)}} className="project-table-content-actions-button" >
                                            <i className="fa fa-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                            )
                        }
                        
                    })
                }
            </div>
            
            <CustomEdit reloadData={reloadData} selectedRoomsTemp={selectedRoomsTemp} open={customEditOpen} setOpen={setCustomEditOpen} project={project}/>
            <ImageChange saveSingleHousing={saveImageSingle} saveHousing={saveImageMultiple} data={changeData} setData={setChangeData} open={updateSingleImageModalOpen} selectedType={selectedType} setOpen={setSingleUpdateImageModalOpen} />
            <ToastContainer />
            <PayDecTable savePayDecsSingle={savePayDecsSingle} saveSelectedHousing={savePayDecSelectedHousing} saveHousing={savePayDecs} data={payDecData} setData={setPayDecData} open={updatePayDecModalOpen} selectedType={selectedType} setOpen={setUpdatePayDecModalOpen} />
            <UpdateSingleHousingModal saveSingleHousing={saveSingleHousing} saveHousing={saveMultipleHousing} data={changeData} setData={setChangeData} open={updateSingleHousingModalOpen} selectedType={selectedType} setOpen={setSingleUpdateHousingModalOpen} isDotType={isDotType} />
            <UpdateHousingModal saveHousing={saveHousing} data={changeData} setData={setChangeData} open={updateHousingModalOpen} selectedType={selectedType} setOpen={setUpdateHousingModalOpen} isDotType={isDotType} />
            <SaleModal getLastCount={getLastCount} reloadData={reloadData2} projectId={projectId} roomOrder={selectedRoomOrder} datat={selectedSaleData} open={saleModalOpen} setOpen={setSaleModalOpen}
            selectedId={selectedId}  selectedData={selectedData} setSelectedId={setSelectedId}  solds={solds}   />   
            <PaymentModal loading={paymentModalLoading} setLoading={setPaymentModalLoading} projectId={projectId} selectedId={selectedId} selectedData={selectedData} setSelectedId={setSelectedId} open={paymentModalOpen} solds={solds} setOpen={setPaymentModalOpen} getLastCount={getLastCount} reloadData={reloadData2} roomOrder={selectedRoomOrder} datat={selectedSaleData} setSelectedData={setSelectedData}/>   
        </>
    );
};
import dayjs from 'dayjs';
import React from 'react';
//Date Picker Imports - these should just be in your Context Provider
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { baseUrl, dotNumberFormat, frontEndUrl } from '../define/variables';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import CustomEdit from './create_project_components/CustomEdit';
import SaleModal from './create_project_components/SaleModal';
import PaymentModal from './create_project_components/PaymentModal';

const ExampleWithLocalizationProvider = ({ projectId }) => (
    //App.tsx or AppProviders file
    <LocalizationProvider dateAdapter={AdapterDayjs}>
        <HousingList projectId={projectId} />
    </LocalizationProvider>
);

export default ExampleWithLocalizationProvider;
