import { useEffect, useMemo, useState } from 'react';

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
    ListItemIcon,
    MenuItem,
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
                if (res.data.rows.hasOwnProperty(key)) {
                    dizi.push(res.data.rows[key]);
                }
            }
            setLoading(false);
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
        })

        console.log(totalProjectsBlocksx);

        axios.get(baseUrl+'get_sale_closes/'+projectId).then((res) => {
            setSaleCloses(res.data.sale_closes);
        })
    }

    console.log(data);

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


    const columns = useMemo(
        () => [
            {
                id: 'employee', //id used to define `group` column
                header: 'Proje İlanları',
                columns: [
                    {
                        id: 'no', //id is still required when using accessorFn instead of accessorKey
                        header: 'No',
                        size: 10,
                        accessorKey : "no",
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableEditing: false,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        muiEditTextFieldProps: {
                            select: false,
                            onChange: (event) => {
                                const value = event.target.value;
                            },
                        },
                        Cell: ({ renderedCellValue, row }) => {
                            return (
                                (getLastCount() + row.index + 1) - getLastBlockCount()
                            )
                        },
                    },
                    
                    {
                        accessorFn: (row) => `${row['image[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'image[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'İlan Görseli',
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableEditing: false,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        size : 75,
                        Cell: ({ renderedCellValue, row }) => {
                            var soldTemp = solds.find((sold) => {
                                var soldJson = JSON.parse(sold.cart);
                                if(soldJson.item.id == projectId && soldJson.item.housing == getLastCount() + row.index + 1 && soldJson.type == "project"){
                                    return sold
                                }
                            });
                            return (
                                <Box
                                    sx={{
                                        display: 'flex',
                                        alignItems: 'center',
                                        gap: '1rem',
                                    }}
                                >
                                    
                                        {
                                            soldTemp ?
                                                <div class="image-area" style={{ width: '80px', height: '80px', display: 'flex', placeItems: 'center' }}>
                                                    <img style={{ maxWidth: '100%', maxHeight: '100%' }} src={frontEndUrl + 'project_housing_images/' + renderedCellValue} alt="" />
                                                </div>
                                            : 
                                            <div class="image-area" onClick={() => { setSelectedSingleItem(getLastCount() + row.index + 1); setSingleUpdateImageModalOpen(true); setSelectedColumn("image"); setSelectedType('İlan Resimi'); }} style={{ width: '80px', height: '80px', display: 'flex', placeItems: 'center' }}>
                                                <div class="image-change">Resmi Değiştir</div>
                                                <img style={{ maxWidth: '100%', maxHeight: '100%' }} src={frontEndUrl + 'project_housing_images/' + renderedCellValue} alt="" />
                                            </div>
                                        }
                                    
                                </Box>
                            )
                        },
                    },
                    {
                        accessorFn: (row) => `${row['advertise_title[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'advert_title[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'İlan Başlığı',
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableEditing: true,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        size : 75,
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [getLastCount() + cell.row.index + 1],
                                    column_name: "advertise_title",
                                    value: value2,
                                    is_dot: false,
                                    project_id: projectId
                                }).then((res) => {
                                })
                            },
                        }),
                        Cell: ({ renderedCellValue, row }) => {
                            var soldx = solds.find((sold) => {
                                var soldJson = JSON.parse(sold.cart);
                                if(soldJson.item.id == projectId && soldJson.item.housing == getLastCount() + row.index + 1 && soldJson.type == "project" && (sold.status == 1 || sold.status == 0)){
                                    return sold
                                }
                            })
                            if(soldx){
                                return(
                                    <Box
                                        sx={{
                                            display: 'flex',
                                            alignItems: 'center',
                                            gap: '1rem',
                                        }}
                                    >
                                        <div>
                                            No : {row.id}
                                        </div>
                                        <div>
                                            Alıcı Adı soyadı : {soldx.full_name}
                                        </div>
                                        <div>
                                            Alıcı Telefon Numarası : {soldx.phone}
                                        </div>
                                        <div>
                                            Satış Tipi : {soldx.is_swap == 0 ? "Peşin Satış" : "Taksitli Satış"}
                                        </div>
                                        <div>
                                            Satış Fiyatı : {soldx.is_swap == 0 ? dotNumberFormat(row.original['price[]']) : dotNumberFormat(row.original['installments-price[]'])} ₺
                                        </div>
                                    </Box>
                                )
                            }else{
                                return(
                                    <Box
                                        sx={{
                                            display: 'flex',
                                            alignItems: 'center',
                                            gap: '1rem',
                                        }}
                                    >
                                        <span>{renderedCellValue.substr(0, 20)}...</span>
                                    </Box>
                                )
                            }
                            
                        },
                    },
                    {
                        accessorFn: (row) => `${row['price[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'price[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'Fiyat',
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableEditing: true,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        size : 75,
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [getLastCount() + cell.row.index + 1],
                                    column_name: "price",
                                    value: value2,
                                    is_dot: false,
                                    project_id: projectId
                                }).then((res) => {
                                })
                            },
                        }),
                        Cell: ({ renderedCellValue, row }) => (
                            <Box
                                sx={{
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: '1rem',
                                }}
                            >
                                <span>{dotNumberFormat(renderedCellValue)}₺</span>
                            </Box>
                        ),
                    },
                    {
                        accessorFn: (row) => `${row['installments-price[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'installments-price[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'Taksitli Fiyat',
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableEditing: true,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        size : 75,
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [getLastCount() + cell.row.index + 1],
                                    column_name: "installments-price",
                                    value: value2,
                                    is_dot: false,
                                    project_id: projectId
                                }).then((res) => {
                                })
                            },
                        }),
                        Cell: ({ renderedCellValue, row }) => (
                            <Box
                                sx={{
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: '1rem',
                                }}
                            >
                                <span>
                                    {
                                        row.original['installments-price[]'] ?
                                            dotNumberFormat(renderedCellValue) + '₺'
                                            : ''
                                    }
                                </span>
                            </Box>
                        ),
                    },
                    {
                        accessorFn: (row) => `${row['pay-decs[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'pay-decs[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'Ara Ödemeler',
                        enableEditing: false,
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableEditing: false,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        size : 75,
                        Cell: ({ renderedCellValue, row }) => {
                            var soldTemp = solds.find((sold) => {
                                var soldJson = JSON.parse(sold.cart);
                                if(soldJson.item.id == projectId && soldJson.item.housing == getLastCount() + row.index + 1 && soldJson.type == "project" && (sold.status == 1 || sold.status == 0)){
                                    return sold
                                }
                            });
                            return (
                                <Box
                                    sx={{
                                        display: 'flex',
                                        alignItems: 'center',
                                        gap: '1rem',
                                    }}
                                >
                                    {
                                        soldTemp ? 
                                            <span className="badge badge-phoenix badge-phoenix-primary batch_update_button" style={{background:'gray',color:'black',border:'1px solid gray'}}>
                                                {row['pay-dec-count' + (getLastCount() + row.index + 1)] > 0 ? row['pay-dec-count' + (getLastCount() + row.index + 1)] : 0} Ara Ödeme
                                            </span>
                                        :   
                                            <span onClick={() => { setSelectedSingleItem(getLastCount() + row.index + 1); setUpdatePayDecModalOpen(true); setPayDecDataFunc(row.original,getLastCount() + row.index + 1); }} className="badge badge-phoenix badge-phoenix-primary batch_update_button">
                                                Ara ödemeleri güncelle
                                                <br />
                                                {parseInt(row.original['pay-dec-count' + (getLastCount() + row.index + 1)]) > 0 ? row.original['pay-dec-count' + (getLastCount() + row.index + 1)] : 0} Ara Ödeme
                                            </span>
                                            
                                        
                                    }
                                    
                                </Box>
                            )
                        },
                    },
                    {
                        accessorFn: (row) => `${row['installments[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'installments[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'Taksit Sayısı',
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableEditing: true,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        size : 75,
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [getLastCount() + cell.row.index + 1],
                                    column_name: "installments",
                                    value: value2,
                                    is_dot: false,
                                    project_id: projectId
                                }).then((res) => {
                                })
                            },
                        }),
                        Cell: ({ renderedCellValue, row }) => (
                            <Box
                                sx={{
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: '1rem',
                                }}
                            >
                                <span>{renderedCellValue}</span>
                            </Box>
                        ),
                    },
                    {
                        accessorFn: (row) => `${row['advance[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'advance[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'Peşinat',
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableEditing: true,
                        enableColumnPinning: false,
                        visibleInShowHideMenu: false,
                        enableColumnOrdering : false,
                        size : 75,
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [getLastCount() + cell.row.index + 1],
                                    column_name: "advance",
                                    value: value2,
                                    is_dot: false,
                                    project_id: projectId
                                }).then((res) => {
                                })
                            },
                        }),
                        Cell: ({ renderedCellValue, row }) => (
                            <Box
                                sx={{
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: '1rem',
                                }}
                            >
                                <span>
                                    {
                                        row.original['advance[]'] ?
                                            dotNumberFormat(renderedCellValue) + '₺'
                                            : ''
                                    }
                                </span>
                            </Box>
                        ),
                    },
                    {
                        accessorFn: (row) => `${row['number_of_shares[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'number_of_shares[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'Hisse Sayısı',
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableEditing: true,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        size : 75,
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [getLastCount() + cell.row.index + 1],
                                    column_name: "number_of_shares",
                                    value: value2,
                                    is_dot: false,
                                    project_id: projectId
                                }).then((res) => {
                                })
                            },
                        }),
                        Cell: ({ renderedCellValue, row }) => {
                            return (
                                <Box
                                    sx={{
                                        display: 'flex',
                                        alignItems: 'center',
                                        gap: '1rem',
                                    }}
                                >
                                    <span>{renderedCellValue == undefined || renderedCellValue == "undefined" ? "" : renderedCellValue}</span>
                                </Box>
                            )
                        },
                    }, 
                    {
                        id: 'squaremeters[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'M² Net',
                        size: 10,
                        accessorKey : "squaremeters[]",
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        size : 75,
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event) => {
                                const value = event.target.value;
                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [getLastCount() + cell.row.index + 1],
                                    column_name: "squaremeters",
                                    value: value,
                                    is_dot: false,
                                    project_id: projectId
                                }).then((res) => {
                                })
                            },
                        }),
                        Cell: ({ renderedCellValue, row }) => {
                            if(!renderedCellValue){
                                return (
                                    'Belirtilmedi'
                                )
                            }else{
                                return (
                                    renderedCellValue + ' M²'
                                )
                            }
                        },
                    },
                    {
                        id: 'm2gross[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'M² Brüt',
                        size: 10,
                        accessorKey : "m2gross[]",
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        size : 75,
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event) => {
                                const value = event.target.value;
                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [getLastCount() + cell.row.index + 1],
                                    column_name: "m2gross",
                                    value: value,
                                    is_dot: false,
                                    project_id: projectId
                                }).then((res) => {
                                })
                            },
                        }),
                        Cell: ({ renderedCellValue, row }) => {
                            console.log(renderedCellValue);
                            if(!renderedCellValue){
                                return (
                                    'Belirtilmedi'
                                )
                            }else{
                                return (
                                    renderedCellValue + ' M²'
                                )
                            }
                            
                        },
                    },
                    {
                        accessorFn: (row) => `${row['room_count[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'room_count[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'Oda Sayısı',
                        size: 10,
                        accessorKey : "room_count[]",
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableEditing: true,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        size : 75,
                        editVariant: 'select',
                        editSelectOptions: [
                            {
                                label: "1+0",
                                value: "1+0",
                                select: true
                            },
                            {
                                label: "1+1",
                                value: "1+1",
                                select: true
                            },
                            {
                                label: "1.5+1",
                                value: "1.5+1",
                                select: true
                            },
                            {
                                label: "2+0",
                                value: "2+0",
                                select: true
                            },
                            {
                                label: "2+1",
                                value: "2+1",
                                select: true
                            },
                            {
                                label: "2.5+1",
                                value: "2.5+1",
                                select: true
                            },
                            {
                                label: "3+0",
                                value: "3+0",
                                select: true
                            },
                            {
                                label: "3+1",
                                value: "3+1",
                                select: true
                            },
                            {
                                label: "3.5+1",
                                value: "3.5+1",
                                select: true
                            },
                            {
                                label: "4+0",
                                value: "4+0",
                                select: true
                            },
                            {
                                label: "4+1",
                                value: "4+1",
                                select: true
                            },
                            {
                                label: "4.5+1",
                                value: "4.5+1",
                                select: true
                            },
                            {
                                label: "4+2",
                                value: "4+2",
                                select: true
                            },
                            {
                                label: "4+3",
                                value: "4+3",
                                select: true
                            },
                            {
                                label: "4+4",
                                value: "4+4",
                                select: true
                            },
                            {
                                label: "5+1",
                                value: "5+1",
                                select: true
                            },
                            {
                                label: "5.5+1",
                                value: "5.5+1",
                                select: true
                            },
                        ],
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: true,
                            value: cell.value,
                            onChange: (event) => {
                                const value = event.target.value;
                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [getLastCount() + cell.row.index + 1],
                                    column_name: "room_count",
                                    value: value,
                                    is_dot: false,
                                    project_id: projectId
                                }).then((res) => {
                                })
                            },
                        }),
                        Cell: ({ renderedCellValue, row }) => {
                            if(!renderedCellValue){
                                return (
                                    'Belirtilmedi'
                                )
                            }else{
                                return (
                                    renderedCellValue
                                )
                            }
                        },
                    },
                    {
                        id: 'floor_location[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'Bulunduğu Kat',
                        size: 10,
                        accessorKey : "floor_location[]",
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        size : 75,
                        
                        editVariant: 'select',
                        editSelectOptions: [
                            {
                                "label": "Giriş Altı Kat 1",
                                "value": "Giriş Altı Kat 1",
                                "select": false
                            },
                            {
                                "label": "Giriş Altı Kat 2",
                                "value": "Giriş Altı Kat 2",
                                "select": false
                            },
                            {
                                "label": "Giriş Altı Kat 3",
                                "value": "Giriş Altı Kat 3",
                                "select": false
                            },
                            {
                                "label": "Giriş Altı Kat 4",
                                "value": "Giriş Altı Kat 4",
                                "select": false
                            },
                            {
                                "label": "Bodrum Kat",
                                "value": "Bodrum Kat",
                                "select": false
                            },
                            {
                                "label": "Zemin Kat",
                                "value": "Zemin Kat",
                                "select": true
                            },
                            {
                                "label": "Bahçe Katı",
                                "value": "Bahçe Katı",
                                "select": false
                            },
                            {
                                "label": "Giriş Katı",
                                "value": "Giriş Katı",
                                "select": false
                            },
                            {
                                "label": "Yüksek Giriş",
                                "value": "Yüksek Giriş",
                                "select": false
                            },
                            {
                                "label": "Müstakil",
                                "value": "Müstakil",
                                "select": false
                            },
                            {
                                "label": "Villa Tipi",
                                "value": "Villa Tipi",
                                "select": false
                            },
                            {
                                "label": "Çatı Katı",
                                "value": "Çatı Katı",
                                "select": false
                            },
                            {
                                "label": "0",
                                "value": "0",
                                "select": false
                            },
                            {
                                "label": "1",
                                "value": "1",
                                "select": false
                            },
                            {
                                "label": "2",
                                "value": "2",
                                "select": false
                            },
                            {
                                "label": "3",
                                "value": "3",
                                "select": false
                            },
                            {
                                "label": "4",
                                "value": "4",
                                "select": false
                            },
                            {
                                "label": "5",
                                "value": "5",
                                "select": false
                            },
                            {
                                "label": "6",
                                "value": "6",
                                "select": false
                            },
                            {
                                "label": "7",
                                "value": "7",
                                "select": false
                            },
                            {
                                "label": "8",
                                "value": "8",
                                "select": false
                            },
                            {
                                "label": "9",
                                "value": "9",
                                "select": false
                            },
                            {
                                "label": "10",
                                "value": "10",
                                "select": false
                            },
                            {
                                "label": "11",
                                "value": "11",
                                "select": false
                            },
                            {
                                "label": "12",
                                "value": "12",
                                "select": false
                            },
                            {
                                "label": "13",
                                "value": "13",
                                "select": false
                            },
                            {
                                "label": "14",
                                "value": "14",
                                "select": false
                            },
                            {
                                "label": "15",
                                "value": "15",
                                "select": false
                            },
                            {
                                "label": "16",
                                "value": "16",
                                "select": false
                            },
                            {
                                "label": "17",
                                "value": "17",
                                "select": false
                            },
                            {
                                "label": "18",
                                "value": "18",
                                "select": false
                            },
                            {
                                "label": "19",
                                "value": "19",
                                "select": false
                            },
                            {
                                "label": "20",
                                "value": "20",
                                "select": false
                            },
                            {
                                "label": "21",
                                "value": "21",
                                "select": false
                            },
                            {
                                "label": "22",
                                "value": "22",
                                "select": false
                            },
                            {
                                "label": "23",
                                "value": "23",
                                "select": false
                            },
                            {
                                "label": "24",
                                "value": "24",
                                "select": false
                            },
                            {
                                "label": "25",
                                "value": "25",
                                "select": false
                            },
                            {
                                "label": "26",
                                "value": "26",
                                "select": false
                            },
                            {
                                "label": "27",
                                "value": "27",
                                "select": false
                            },
                            {
                                "label": "28",
                                "value": "28",
                                "select": false
                            },
                            {
                                "label": "29",
                                "value": "29",
                                "select": false
                            },
                            {
                                "label": "30 ve üzeri",
                                "value": "30 ve üzeri",
                                "select": false
                            }
                        ],
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: true,
                            value: cell.value,
                            onChange: (event) => {
                                const value = event.target.value;
                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [getLastCount() + cell.row.index + 1],
                                    column_name: "floor_location",
                                    value: value,
                                    is_dot: false,
                                    project_id: projectId
                                }).then((res) => {
                                })
                            },
                        }),
                        Cell: ({ renderedCellValue, row }) => {
                            if(!renderedCellValue){
                                return (
                                    'Belirtilmedi'
                                )
                            }else{
                                return (
                                    renderedCellValue
                                )
                            }
                        },
                    },
                    {
                        accessorFn: (row) => `${row['off_sale[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'off_sale[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'Satış Durumu',
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: false,
                        enableColumnActions: false,
                        enableEditing: true,
                        enableColumnPinning: false,
                        enableColumnOrdering : false,
                        editVariant: 'select',
                        editSelectOptions: [
                            {
                                label: "Satışa Açık",
                                value: "[]",
                                select: true
                            },

                            {
                                label: "Satışa Kapalı",
                                value: "['Satışa Kapalı']"
                            }
                        ],
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: true,
                            value: cell.value,
                            onChange: (event, s) => {
                                const value2 = event.target.value;
                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [getLastCount() + cell.row.index + 1],
                                    column_name: "off_sale",
                                    value: value2,
                                    is_dot: false,
                                    project_id: projectId
                                }).then((res) => {
                                })
                            },
                        }),
                        Cell: ({ renderedCellValue, row }) => {
                            var soldx = solds.find((sold) => {
                                var soldJson = JSON.parse(sold.cart);
                                if(soldJson.item.id == projectId && soldJson.item.housing == getLastCount() + row.index + 1 && soldJson.type == "project" && (sold.status == 1 || sold.status == 0)){
                                    return sold
                                }
                            })
                            return (
                                <Box
                                    sx={{
                                        display: 'flex',
                                        alignItems: 'center',
                                        gap: '1rem',
                                    }}
                                >
                                    {
                                        !soldx ?
                                            renderedCellValue == '[]' ?
                                                <button className="badge badge-phoenix badge-phoenix-success value-text">
                                                    Satışa Açık
                                                </button>
                                                :
                                                <button className="badge badge-phoenix badge-phoenix-danger value-text">
                                                    Satışa Kapatıldı
                                                </button>
                                            : <button disabled={true} className="badge badge-phoenix badge-phoenix-danger value-text">
                                                Satıldı
                                            </button>
                                    }
                                </Box>
                            )
                        },
                    },
                ],
            },

        ],
        [solds],
    );


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

    const changeSelectedItems = (selectedFunc) => {
        var items = selectedFunc();

        if(typeof items == "object"){
            if(Object.keys(items).length == 0){
                var items2 = Object.keys(selectedRoomsTemp);
                var newItems = {};
                items2.map((item) => {
                    if(parseInt(item) > getLastCount() && parseInt(item) <= getLastCount() + pagination.pageSize){
                        
                    }else{
                        newItems[item] = true;
                    }
                })
                setSelectedRoomsTemp(newItems);
            }else{
                var items4 = {...selectedRoomsTemp};
                var items2 = Object.keys(selectedRoomsTemp);
                var items3 = Object.keys(items);
                var newItems2 = {};
                items3.map((item) => {
                    if(!items2.includes(item)){
                        items4[item] = true;
                    }
                });
                setSelectedRoomsTemp(items4);
            }
            
            
        }else{
            var items2 = Object.keys(selectedRoomsTemp);
            if(items2.includes(''+items+'')){
                var newItems2 = {};
                items2.map((item) => {
                    if(parseInt(item) != items){
                        newItems2[item] = true
                    }
                });
    
                setSelectedRoomsTemp(newItems2);
            }else{
                setSelectedRoomsTemp({...selectedRoomsTemp,[items] : true});
            }
        }
        
    }

    const saleModalFunc = (id) => {
        id = id - getLastCount();
        setSelectedRoomOrder(id);
        var saleData = {};
        setSaleModalOpen(true)

        axios.get(baseUrl+'get_sale/'+projectId+'/'+(getLastCount() + id)).then((res) => {
            if(res.data.data && res.data.data.pay_decs){
                var payDecx = JSON.parse(res.data.data.pay_decs);
            }else{
                var payDecx = [];
            }
            console.log(data[id - 1])
            solds.map((sold) => {
                console.log(sold);
                var cart = JSON.parse(sold.cart);
                if(cart.item.id == projectId && cart.item.housing == getLastCount() + id){
                    var payDecs = [];
                    for(var i = 0; i < data[id - 1]['pay-dec-count'+(getLastCount() + id)];i++){
                        payDecs.push({});
                        payDecs[i]['price'] = data[id - 1]['pay_desc_price'+(getLastCount() + id)+""+i];
                        payDecs[i]['date'] = data[id - 1]['pay_desc_date'+(getLastCount() + id)+""+i];
                        if(payDecx.includes(i+1)){
                            payDecs[i]['status'] = true;
                        }else{
                            payDecs[i]['status'] = false;
                        }
                    }
                    saleData['name'] = sold.full_name;
                    saleData['email'] = sold.email;
                    saleData['phone'] = sold.phone;
                    saleData['sale_type'] = sold.is_swap == 0 ? 1 : 2,
                    saleData['price'] = sold.is_swap == 0 ? data[id - 1]['price[]'] : data[id - 1]['installments-price[]'],
                    saleData['installment_price'] = data[id - 1]['installments-price[]'],
                    saleData['advance'] = data[id - 1]['advance[]'],
                    saleData['installments'] = data[id - 1]['installments[]']
                    saleData['pay_decs'] = payDecs
                    saleData['down_payment'] = res.data.data?.down_payment
                    saleData['advance_payment'] = res.data.data?.advance
                    saleData['down_payment_price'] = res.data.data?.down_payment_price
                    saleData['show_neighbour'] = sold.is_show_user == "on" ? true : false
                }
            })
            setSelectedSaleData(saleData);
        })
    }

    console.log(selectedSaleData);

    const paymentModalFunc = (id) => {
        setPaymentModalOpen(true);
        setSelectedId(id);
        setSelectedData(data[id - 1]);
    }

    const table = useMaterialReactTable({
        columns,
        data, //data must be memoized or stable (useState, useMemo, defined outside of this component, etc.)
        enableColumnFilterModes: true,
        enableColumnOrdering: true,
        enableGrouping: false,
        enableColumnPinning: true,
        enableFacetedValues: true,
        enableRowActions: true,
        enableCellActions: true,
        enableColumnPinning: true,
        enableRowSelection: (row) => {
            var soldx = solds.find((sold) => {
                var soldJson = JSON.parse(sold.cart);
                if(soldJson.item.id == projectId && soldJson.item.housing == getLastCount() + row.index + 1 && soldJson.type == "project" && (sold.status == 1 || sold.status == 0)){
                    return sold
                }
            })
            if(!soldx){
                return true;
            }else{
                return false;
            }
        },
        onRowSelectionChange: (item) => {
            changeSelectedItems(item)
        },
        enableEditing: (row) => {
            var soldx = solds.find((sold) => {
                var soldJson = JSON.parse(sold.cart);
                if(soldJson.item.id == projectId && soldJson.item.housing == getLastCount() + row.index + 1 && soldJson.type == "project" && (sold.status == 1 || sold.status == 0)){
                    return sold
                }
            })
            if(!soldx){
                return true;
            }else{
                return false;
            }
        },
        editDisplayMode: 'cell',
        initialState: {
            showColumnFilters: true,
            showGlobalFilter: true,
            columnPinning: {
                left: ['mrt-row-select', 'no'],
                right: ['mrt-row-actions'],
            },
            pagination: pagination,
        },
        getRowId: (row,key) =>  { return parseInt(getLastCount()) + (key + 1);},
        onPaginationChange : setPagination,
        state: {
            pagination,
            rowSelection : selectedRoomsTemp,
            isLoading : loading
        },
        paginationDisplayMode: 'pages',
        positionToolbarAlertBanner: 'bottom',
        muiTableBodyCellProps: ( data ) => {
            var soldx = solds.find((sold) => {
                var soldJson = JSON.parse(sold.cart);
                if(soldJson.item.id == projectId && soldJson.item.housing == getLastCount() + data.row.index + 1 && soldJson.type == "project" && (sold.status == 1 || sold.status == 0)){
                    return sold
                }
            })
            if(soldx){
                if(data.cell.column.id === 'advert_title[]'){
                    return({
                        //conditionally style pinned columns
                        colSpan : 15,
                        sx: {
                          backgroundColor: "#28a745",
                          color : '#fff'
                        },
                    })
                }else{
                    if(data.cell.column.id == 'mrt-row-actions' ){
                        return {
                            sx: {
                                display: 'block', // Diğer hücreleri gizlemek için
                            },
                        };
                    }else{
                        return {
                            sx: {
                                display: 'none', // Diğer hücreleri gizlemek için
                            },
                        };
                    }
                    
                }
                
            }else{
                if(data.row.original['off_sale[]'] != "[]"){
                    return({
                        sx: {
                          backgroundColor: "#f0ad4e",
                          color : '#000'
                        },
                    })
                }
            }
        },
        muiPaginationProps: {
            color: 'secondary',
            rowsPerPageOptions: [10, 20, 30],
            shape: 'rounded',
            variant: 'outlined',
        },
        onPaginationChange: setPagination,
        manualPagination: true,
        rowCount: totalProjectsCount,
        enableStickyHeader: true,
        enableStickyFooter: true,
        onShowGlobalFilterChange : false,
        enableGlobalFilterModes : false,
        enableGlobalFilter: false,
        enableGlobalFilterRankedResults:false,
        enableFilterMatchHighlighting : false,
        muiTableContainerProps: { sx: { maxHeight: 'calc(100vh - 330px)' } },
        renderRowActionMenuItems: ({ closeMenu,row }) => {
            var soldx = solds.find((sold) => {
                var soldJson = JSON.parse(sold.cart);
                if(soldJson.item.id == projectId && soldJson.item.housing == getLastCount() + row.index + 1 && soldJson.type == "project" && (sold.status == 1 || sold.status == 0)){
                    return sold
                }
            })
            

            if(soldx){
                return [
                    <MenuItem
                        key={0}
                        onClick={() => {
                            saleModalFunc(getLastCount() + row.index + 1)
                            // View profile logic...
                            closeMenu();
                        }}
                        sx={{ m: 0 }}
                    >
                        <ListItemIcon>
                            <UserIcon />
                        </ListItemIcon>
                        Satış Bilgilerini Düzenle
                    </MenuItem>,
                    <MenuItem
                        key={0}
                        onClick={() => {
                            paymentModalFunc(getLastCount() + row.index + 1);
                        }}
                        sx={{ m: 0 }}
                    >
                        <ListItemIcon>
                            <ReceiptIcon />
                        </ListItemIcon>
                        Ödeme Planını Düzenle
                    </MenuItem>,
                    <MenuItem
                        key={0}
                        onClick={() => {
                            var anchor = document.createElement('a');
                            console.log(frontEndUrl+'react/render_pdf/'+projectId+'/'+(getLastCount() + row.index + 1));
                            anchor.href = frontEndUrl+'react/render_pdf/'+projectId+'/'+(getLastCount() + row.index + 1);
                            anchor.target="_blank";
                            anchor.click();
                        }}
                        sx={{ m: 0 }}
                    >
                        <ListItemIcon>
                            <ReceiptIcon />
                        </ListItemIcon>
                        Çıktı Al
                    </MenuItem>
                ]
            }else{
                return [
                    <MenuItem
                        key={0}
                        onClick={() => {
                            // View profile logic...
                            window.location.href = frontEndUrl+'hesabim/projects/'+projectId+'/housings/edit/'+(row.index + 1)
                            closeMenu();
                        }}
                        sx={{ m: 0 }}
                    >
                        <ListItemIcon>
                            <EditIcon />
                        </ListItemIcon>
                        İlanı Düzenle
                    </MenuItem>
                ]
            }
            
        },
        renderTopToolbar: ({ table }) => {

            return (
                <Box
                    sx={(theme) => ({
                        backgroundColor: lighten(theme.palette.background.default, 0.05),
                        display: 'flex',
                        gap: '0.5rem',
                        p: '8px',
                        justifyContent: 'space-between',
                    })}
                >
                    <Box sx={{ display: 'flex', gap: '0.5rem', alignItems: 'center' }}>
                        {/* import MRT sub-components */}
                        <MRT_GlobalFilterTextField table={table} />
                    </Box>
                    <Box>
                        <Box sx={{ display: 'flex', gap: '0.5rem' }}>
                            <Button
                                color="info"
                                disabled={!Object.keys(selectedRoomsTemp).length > 0}
                                onClick={() => {setCustomEditOpen(true)}}
                                variant="contained"
                            >
                                Seçilen İlanları Düzenle
                            </Button>
                        </Box>
                    </Box>
                </Box>
            );
        },
        localization: {
            actions: 'İşlemler',
            and: 've',
            cancel: 'İptal',
            changeFilterMode: 'Change filter mode',
            changeSearchMode: 'Change search mode',
            clearFilter: 'Filtreyi Temizle',
            clearSearch: 'Aramayı Temizle',
            clearSelection: 'Seçme işlemini sıfırla',
            clearSort: 'Sıralamyı sıfırla',
            clickToCopy: 'Kopyala',
            copy: 'Kopyala',
            collapse: 'Collapse',
            collapseAll: 'Collapse all',
            columnActions: 'Column Actions',
            copiedToClipboard: 'Copied to clipboard',
            dropToGroupBy: 'Drop to group by {column}',
            edit: 'Düzenle',
            expand: 'Expand',
            expandAll: 'Expand all',
            filterArrIncludes: 'Includes',
            filterArrIncludesAll: 'Includes all',
            filterArrIncludesSome: 'Includes',
            filterBetween: 'Between',
            filterBetweenInclusive: 'Between Inclusive',
            filterByColumn: '{column} alanına göre filtrele',
            filterContains: 'Contains',
            filterEmpty: 'Empty',
            filterEndsWith: 'Ends With',
            filterEquals: 'Equals',
            filterEqualsString: 'Equals',
            filterFuzzy: 'Fuzzy',
            filterGreaterThan: 'Greater Than',
            filterGreaterThanOrEqualTo: 'Greater Than Or Equal To',
            filterInNumberRange: 'Between',
            filterIncludesString: 'Contains',
            filterIncludesStringSensitive: 'Contains',
            filterLessThan: 'Less Than',
            filterLessThanOrEqualTo: 'Less Than Or Equal To',
            filterMode: '',
            filterNotEmpty: 'Not Empty',
            filterNotEquals: 'Not Equals',
            filterStartsWith: 'Starts With',
            filterWeakEquals: 'Equals',
            filteringByColumn: 'Filtering by {column} - {filterType} {filterValue}',
            goToFirstPage: 'Go to first page',
            goToLastPage: 'Go to last page',
            goToNextPage: 'Go to next page',
            goToPreviousPage: 'Go to previous page',
            grab: 'Grab',
            groupByColumn: 'Group by {column}',
            groupedBy: 'Grouped by ',
            hideAll: 'Hide all',
            hideColumn: 'Hide {column} column',
            max: 'Max',
            min: 'Min',
            move: 'Move',
            noRecordsToDisplay: 'No records to display',
            noResultsFound: 'No results found',
            of: 'of',
            or: 'or',
            pin: 'Pin',
            pinToLeft: 'Pin to left',
            pinToRight: 'Pin to right',
            resetColumnSize: 'Reset column size',
            resetOrder: 'Reset order',
            rowActions: 'Row Actions',
            rowNumber: '#',
            rowNumbers: 'Row Numbers',
            rowsPerPage: 'Gösterilen veri sayısı',
            save: 'Save',
            search: 'Ara...',
            selectedCountOfRowCountRowsSelected:
                '{selectedCount} of {rowCount} row(s) selected',
            select: 'Select',
            showAll: 'Show all',
            showAllColumns: 'Show all columns',
            showHideColumns: 'Show/Hide columns',
            showHideFilters: 'Show/Hide filters',
            showHideSearch: 'Show/Hide search',
            sortByColumnAsc: 'Sort by {column} ascending',
            sortByColumnDesc: 'Sort by {column} descending',
            sortedByColumnAsc: 'Sorted by {column} ascending',
            sortedByColumnDesc: 'Sorted by {column} descending',
            thenBy: ', then by ',
            toggleDensity: 'Toggle density',
            toggleFullScreen: 'Toggle full screen',
            toggleSelectAll: 'Toggle select all',
            toggleSelectRow: 'Toggle select row',
            toggleVisibility: 'Toggle visibility',
            ungroupByColumn: 'Ungroup by {column}',
            unpin: 'Unpin',
            unpinAll: 'Unpin all',
        }
    });

    return (
        <>
            {
                haveBlocks ? 
                    <div class="tabs">
                        <ul>
                            <li onClick={() => {setSelectedBlock(0)}} className={selectedBlock == 0 ? "active" : ""}>A Blok</li>
                            <li onClick={() => {setSelectedBlock(1)}} className={selectedBlock == 1 ? "active" : ""}>B Blok</li>
                        </ul>
                    </div>
                : ''
            }
            {
                Object.keys(selectedRoomsTemp).length > 0 ? 
                    <div className="card px-3 mb-2 pb-2">
                        <h4>Seçilen Konutlar</h4>
                        <div>
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
                                            <span onClick={() => {removeSelectedRoom(selectedRoom)}} style={{cursor:'pointer'}}  className='badge badge-phoenix badge-phoenix-success mx-1'>{ blockx[selectedBlockIndex].block_name +" "+ ( parseInt(selectedRoom) - lastItemsCountx)} <i className='fa fa-times'></i></span>
                                        )
                                    })
                                : 
                                    Object.keys(selectedRoomsTemp).map((selectedRoom,key) => {
                                        return(
                                            <span onClick={() => {removeSelectedRoom(selectedRoom)}} style={{cursor:'pointer'}}  className='badge badge-phoenix badge-phoenix-success mx-1'>{ ( parseInt(selectedRoom) )} <i className='fa fa-times'></i></span>
                                        )
                                    })
                            }
                        </div>
                    </div>
                : ''
            }
            
            {
                loading ? 
                    ''
                : 
                    <div style={{display:'flex',justifyContent:'space-between',marginBottom:'10px',alignItems:'center'}} className='px-3'>
                        <button className='all_selected_button' onClick={() => {allSelected()}}> <span className='buyUserRequest__text'>{allSelectedCheckbox ? 'Seçimi Kaldır' : 'Projedeki Tüm Konutları Seç'}</span> </button>
                        <div style={{width:'60%'}}>
                            <div style={{display:'flex',justifyContent:'space-around'}}>
                                <div className='info-color'>
                                    <div className='color-area' style={{background:'#22bb33'}}></div>
                                    <span>Satışa Açık</span>
                                </div>
                                <div className='info-color'>
                                    <div className='color-area' style={{background:'#f0ad4e'}}></div>
                                    <span>Satışa Kapalı</span>
                                </div>
                                <div className='info-color'>
                                    <div className='color-area' style={{background:'#bb2124'}}></div>
                                    <span>Satıldı</span>
                                </div>
                            </div>
                            <div className="progress-areax">
                                <div className="sales-open" style={{width:((salesCount()['saleOpenCount'] * 100) / project.room_count)+'%'}}> {salesCount()['saleOpenCount']}  </div>
                                {
                                    salesCount()['saleCloseCount'] > 0 ?
                                        <div className="sales-closed" style={{width:((salesCount()['saleCloseCount'] * 100) / project.room_count)+'%'}}> {salesCount()['saleCloseCount']}  </div>
                                    : ''
                                }
                                <div className="sale" style={{width:((salesCount()['saleCount'] * 100) / project.room_count)+'%'}}> {salesCount()['saleCount']} </div>
                            </div>
                        </div>
                    </div>
            }
            

            <CustomEdit reloadData={reloadData} selectedRoomsTemp={selectedRoomsTemp} open={customEditOpen} setOpen={setCustomEditOpen} project={project}/>
            <MaterialReactTable table={table} />
            <ImageChange saveSingleHousing={saveImageSingle} saveHousing={saveImageMultiple} data={changeData} setData={setChangeData} open={updateSingleImageModalOpen} selectedType={selectedType} setOpen={setSingleUpdateImageModalOpen} />
            <ToastContainer />
            <PayDecTable savePayDecsSingle={savePayDecsSingle} saveSelectedHousing={savePayDecSelectedHousing} saveHousing={savePayDecs} data={payDecData} setData={setPayDecData} open={updatePayDecModalOpen} selectedType={selectedType} setOpen={setUpdatePayDecModalOpen} />
            <UpdateSingleHousingModal saveSingleHousing={saveSingleHousing} saveHousing={saveMultipleHousing} data={changeData} setData={setChangeData} open={updateSingleHousingModalOpen} selectedType={selectedType} setOpen={setSingleUpdateHousingModalOpen} isDotType={isDotType} />
            <UpdateHousingModal saveHousing={saveHousing} data={changeData} setData={setChangeData} open={updateHousingModalOpen} selectedType={selectedType} setOpen={setUpdateHousingModalOpen} isDotType={isDotType} />
            <SaleModal getLastCount={getLastCount} reloadData={reloadData2} projectId={projectId} roomOrder={selectedRoomOrder} datat={selectedSaleData} open={saleModalOpen} setOpen={setSaleModalOpen}/>   
            <PaymentModal projectId={projectId} selectedId={selectedId} selectedData={selectedData} setSelectedId={setSelectedId} open={paymentModalOpen} solds={solds} setOpen={setPaymentModalOpen}/>   
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
