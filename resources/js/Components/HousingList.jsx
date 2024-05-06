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

//Icons Imports
import { AccountCircle, Send } from '@mui/icons-material';

import UpdateHousingModal from './create_project_components/UpdateHousingModal';
import UpdateSingleHousingModal from './create_project_components/UpdateSingleHousingModal';
import PayDecTable from './create_project_components/PayDecTable';
import ImageChange from './create_project_components/ImageChange';
import EditIcon from '@mui/icons-material/Edit';


const HousingList = ({ projectId }) => {

    const [selectedBlock, setSelectedBlock] = useState(0);
    const [haveBlocks, setHaveBlocks] = useState(0);
    const [loading, setLoading] = useState(true);
    const [pagination, setPagination] = useState({
        pageIndex: 0,
        pageSize: 20, //customize the default page size
    });

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
    const [project, setProject] = useState({
        blocks: []
    });

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
    

    const findOrderQt = (roomOrder) => {
        var haveSumCartQts = sumCartQts.find((cartQts) => { return cartQts.housing_id == roomOrder; });
        if (haveSumCartQts && haveSumCartQts != undefined) {
            return haveSumCartQts.qt_total
        } else {
            return 0;
        }
    }

    const [data, setData] = useState([])

    const axiosRequestGetData = (newPage) => {
        setLoading(true);
        var start = newPage * pagination.pageSize;
        var end = (newPage + 1) * pagination.pageSize;
        axios.get(baseUrl + 'project_housings/' + projectId + `?start=${start}&end=${end}&block=0`).then((res) => {
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
            if (res.data.project.have_blocks) {
                setTotalProjectsCount(res.data.project.blocks[selectedBlock].housing_count);
            } else {
                setTotalProjectsCount(res.data.project.room_count);
            }
            var result2 = Object.keys(res.data.sumCartOrderQt).map((key) => res.data.sumCartOrderQt[key])
            setSumCartQts(result2);
            setHaveBlocks(res.data.project.have_blocks)
            setSolds(res.data.solds)
        })
    }

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
        console.log(selectedRoom);
    }

    useEffect(() => {
        axiosRequestGetData(pagination.pageIndex);
    }, [pagination])

    useEffect(() => {
        var newItems = {};

        Object.keys(selectedRoomsTemp).forEach((selectedRoom) => {
            newItems[(parseInt(selectedRoom) - getLastCount())] = true;
        })

        setSelectedRoomsTemp2(newItems)
    },[selectedRoomsTemp])

    const columns = useMemo(
        () => [
            {
                id: 'employee', //id used to define `group` column
                header: 'Proje İlanları',
                columns: [
                    {
                        accessorFn: (row) => `${row['no']}`, //accessorFn used to join multiple data into a single cell
                        id: 'id', //id is still required when using accessorFn instead of accessorKey
                        header: 'No',
                        size: 10,
                        enableColumnFilterModes: false,
                        enableColumnFilter: false,
                        enableSorting: true,
                        enableColumnOrdering: false,
                        enableColumnActions: false,
                        enableEditing: false,
                        enableColumnPinning : true,
                        muiEditTextFieldProps: {
                            select: false,
                            onChange: (event) => {
                                const value = event.target.value;
                            },
                        },
                        Cell: ({ renderedCellValue, row }) => {
                            return (
                                getLastCount() + row.index + 1
                            )
                        },
                    },
                    {
                        accessorFn: (row) => `${row['image[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'image[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'İlan Görseli',
                        enableEditing: false,
                        Cell: ({ renderedCellValue, row }) => {
                            var soldTemp = solds.find((sold) => {
                                var soldJson = JSON.parse(sold.cart);
                                if(soldJson.item.id == projectId && soldJson.item.housing == row.index + 1 && soldJson.type == "project"){
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
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [cell.row.index + 1],
                                    column_name: "advertise_title",
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
                        accessorFn: (row) => `${row['price[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'price[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'Fiyat',
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [cell.row.index + 1],
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
                        size : 10,
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [cell.row.index + 1],
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
                        Cell: ({ renderedCellValue, row }) => {
                            var soldTemp = solds.find((sold) => {
                                var soldJson = JSON.parse(sold.cart);
                                if(soldJson.item.id == projectId && soldJson.item.housing == row.index + 1 && soldJson.type == "project"){
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
                                            <span onClick={() => { setSelectedSingleItem(getLastCount() + row.index + 1); setUpdatePayDecModalOpen(true); setPayDecs(getLastCount() + row.index + 1) }} className="badge badge-phoenix badge-phoenix-primary batch_update_button">
                                                Ara ödemeleri güncelle
                                                <br />
                                                {row['pay-dec-count' + (getLastCount() + row.index + 1)] > 0 ? row['pay-dec-count' + (getLastCount() + row.index + 1)] : 0} Ara Ödeme
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
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [cell.row.index + 1],
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
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [cell.row.index + 1],
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
                        muiEditTextFieldProps: ({ cell, column, table }) => ({
                            select: false,
                            onChange: (event, s) => {
                                const value2 = event.target.value;

                                axios.post(baseUrl + 'save_housing', {
                                    rooms: [cell.row.index + 1],
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
                    }, {
                        accessorFn: (row) => `${row['off_sale[]']}`, //accessorFn used to join multiple data into a single cell
                        id: 'off_sale[]', //id is still required when using accessorFn instead of accessorKey
                        header: 'Satış Durumu',
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
                                    rooms: [cell.row.index + 1],
                                    column_name: "off_sale",
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
                                    {
                                        findOrderQt(getLastCount() + row.index + 1) == 0 ?
                                            renderedCellValue == '[]' ?
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
        var newItems =  itemsx.map((item) => parseInt(item) + 1);
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
        axiosRequestGetData(page)
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

    console.log(selectedRoomsTemp,selectedRoomsTemp2);

    const changeSelectedItems = (selectedFunc) => {
        var items = selectedFunc();
        var newItems = selectedRoomsTemp;
        console.log(newItems);
        Object.keys(items).forEach((item) => {
            newItems[parseInt(getLastCount()) + parseInt(item)] = true;
        });
        console.log(newItems);
        setSelectedRoomsTemp(newItems);
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
        enableRowSelection: (row) => {
            var soldx = solds.find((sold) => {
                var soldJson = JSON.parse(sold.cart);
                if(soldJson.item.id == projectId && soldJson.item.housing == row.index + 1 && soldJson.type == "project"){
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
                if(soldJson.item.id == projectId && soldJson.item.housing == row.index + 1 && soldJson.type == "project"){
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
                left: ['mrt-row-expand', 'mrt-row-select', 'no'],
                right: ['mrt-row-actions'],
            },
            pagination: pagination,
        },
        onPaginationChange : setPagination,
        state: {
            pagination,
            rowSelection : selectedRoomsTemp2,
            isLoading : loading
        },
        paginationDisplayMode: 'pages',
        positionToolbarAlertBanner: 'bottom',
        muiSearchTextFieldProps: {
            size: 'small',
            variant: 'outlined',
        },
        muiTableBodyCellProps: ( data ) => {
            var soldx = solds.find((sold) => {
                var soldJson = JSON.parse(sold.cart);
                if(soldJson.item.id == projectId && soldJson.item.housing == data.row.index + 1 && soldJson.type == "project"){
                    return sold
                }
            })
            if(soldx){
                return({
                    //conditionally style pinned columns
                    sx: {
                      backgroundColor: "#EA2B2E",
                      color : '#fff'
                    },
                })
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
        renderRowActionMenuItems: ({ closeMenu }) => [
            <MenuItem
                key={0}
                onClick={() => {
                    // View profile logic...
                    closeMenu();
                }}
                sx={{ m: 0 }}
            >
                <ListItemIcon>
                    <EditIcon />
                </ListItemIcon>
                İlanı Düzenle
            </MenuItem>,
        ],
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
                        <MRT_ToggleFiltersButton table={table} />
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
                Object.keys(selectedRoomsTemp).length > 0 ? 
                    <div className="card px-3 mb-2 pb-2">
                        <h4>Seçilen İlanlar</h4>
                        <div>
                            {
                                Object.keys(selectedRoomsTemp).map((selectedRoom) => {
                                    return(
                                        <span onClick={() => {removeSelectedRoom(selectedRoom)}} style={{cursor:'pointer'}}  className='badge badge-phoenix badge-phoenix-success mx-1'>{parseInt(selectedRoom)  + 1} <i className='fa fa-times'></i></span>
                                    )
                                })
                            }
                        </div>
                    </div>
                : ''
            }
            

            <CustomEdit reloadData={reloadData} selectedRoomsTemp={selectedRoomsTemp} open={customEditOpen} setOpen={setCustomEditOpen} project={project}/>
            <MaterialReactTable table={table} />
            <ImageChange saveSingleHousing={saveImageSingle} saveHousing={saveImageMultiple} data={changeData} setData={setChangeData} open={updateSingleImageModalOpen} selectedType={selectedType} setOpen={setSingleUpdateImageModalOpen} />
            <ToastContainer />
            <PayDecTable savePayDecsSingle={savePayDecsSingle} saveSelectedHousing={savePayDecSelectedHousing} saveHousing={savePayDecs} data={payDecData} setData={setPayDecData} open={updatePayDecModalOpen} selectedType={selectedType} setOpen={setUpdatePayDecModalOpen} />
            <UpdateSingleHousingModal saveSingleHousing={saveSingleHousing} saveHousing={saveMultipleHousing} data={changeData} setData={setChangeData} open={updateSingleHousingModalOpen} selectedType={selectedType} setOpen={setSingleUpdateHousingModalOpen} isDotType={isDotType} />
            <UpdateHousingModal saveHousing={saveHousing} data={changeData} setData={setChangeData} open={updateHousingModalOpen} selectedType={selectedType} setOpen={setUpdateHousingModalOpen} isDotType={isDotType} />
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

const ExampleWithLocalizationProvider = ({ projectId }) => (
    //App.tsx or AppProviders file
    <LocalizationProvider dateAdapter={AdapterDayjs}>
        <HousingList projectId={projectId} />
    </LocalizationProvider>
);

export default ExampleWithLocalizationProvider;
