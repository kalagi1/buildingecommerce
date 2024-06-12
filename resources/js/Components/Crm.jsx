import * as React from 'react';
import { useMemo } from 'react';

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
  Checkbox,
  ListItemIcon,
  MenuItem,
  Rating,
  Typography,
  lighten,
} from '@mui/material';

//Icons Imports
import { AccountCircle, Send } from '@mui/icons-material';


const Crm = () => {
  const [customers, setCustomers] = useState([]);
  const [projects, setProjects] = useState([]);
  const [wasMeeting,setWasMeeting] = useState(0);
  const [loading,setLoading] = useState(false);
  const [selectedMeetType,setSelectedMeetType] = useState(null);
  const [selectedRating,setSelectedRating] = useState(null);
  const [selectedCustomerStatus,setSelectedCustomerStatus] = useState(null);
  const [selectedConclusion,setSelectedConclusion] = useState(null);
  const [customerProfileOpen,setCustomerProfileOpen] = useState(false);
  const [selectedCustomerId,setSelectedCustomerId] = useState(null);
  
  const customerProfileOpenFunc = (id) => {
    setCustomerProfileOpen(true);
    setSelectedCustomerId(id);
  }

  var months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];

  useEffect(() => {
    setLoading(true);
    var filter = {
      was_meeting : wasMeeting,
      selected_meet_type : selectedMeetType,
      selected_rating : selectedRating,
      selected_customer_status : selectedCustomerStatus,
      selected_conclusion : selectedConclusion
    }
    
    axios.get(baseUrl + 'customer?'+QueryString.stringify(filter)).then((res) => {
      setCustomers(res.data.data);
      setProjects(res.data.projects);
      setLoading(false);
    })
  }, [wasMeeting,selectedMeetType,selectedRating,selectedConclusion,selectedCustomerStatus])

  const changeData = (key, value, id) => {
    axios.put(baseUrl + 'customer/' + id, { key, value }).then((res) => {
      console.log(res);
    })

    var newDatas = customers.map((customer) => {
      if (customer.id == id) {
        return {
          ...customer,
          [key]: value
        }
      } else {
        return customer
      }
    })

    setCustomers(newDatas);
  }

  console.log(projects);
  const columns = [
    {
      id: 'employee', //id used to define `group` column
      header: 'Müşteriler',
      columns: [
        {
          accessorKey: 'date', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          header: 'Tarih',
          size: 250,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableEditing: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
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
                    
                </Box>
            );
          },
          Cell: ({ renderedCellValue, row }) => {
            console.log(row);
            var date = new Date(row.original.date);
            return (
              <Box
                sx={{
                  display: 'flex',
                  alignItems: 'center',
                  gap: '1rem',
                }}
              >
                <span>{months[date.getMonth()] + ', ' + date.getDate() + ' ' + date.getFullYear()}</span>
              </Box>
            )
          },
        },
        {
          accessorKey: 'source', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          header: 'Data/Kaynak',
          size: 250,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableEditing: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => {
            console.log(row);
            var date = new Date(row.original.date);
            return (
              <Box
                sx={{
                  display: 'flex',
                  alignItems: 'center',
                  gap: '1rem',
                }}
              >
                <span>{renderedCellValue}</span>
              </Box>
            )
          },
        },
        {
          accessorKey: 'new', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          header: 'Yeni/Eski',
          size: 250,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableEditing: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => {
            console.log(row);
            var date = new Date(row.original.date);
            return (
              <Box
                sx={{
                  display: 'flex',
                  alignItems: 'center',
                  gap: '1rem',
                }}
              >
                <span>{renderedCellValue == 1 ? "Yeni" : "Eski"}</span>
              </Box>
            )
          },
        },
        {
          accessorFn: (row) => `${row.name}`, //accessorFn used to join multiple data into a single cell
          id: 'name', //id is still required when using accessorFn instead of accessorKey
          header: 'Name',
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableEditing: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          size: 250,
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
          accessorFn: (row) => `${row.phone}`, //accessorFn used to join multiple data into a single cell
          id: 'phone', //id is still required when using accessorFn instead of accessorKey
          header: 'Telefon Numarası',
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableEditing: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          size: 250,
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
          accessorKey: 'email', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          enableClickToCopy: true,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableEditing: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          filterVariant: 'autocomplete',
          header: 'Email',
          size: 300,
        },
        {
          accessorKey: 'city', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          enableClickToCopy: true,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableEditing: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          filterVariant: 'autocomplete',
          header: 'Şehir',
          size: 300,
        },
        {
          accessorKey: 'interested_project', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          id: 'interested_project', //id is still required when using accessorFn instead of accessorKey
          header: 'İlgilendiği Proje',
          size: 250,
          enableEditing: false,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => (
            <Box
              sx={{
                display: 'flex',
                alignItems: 'center',
                gap: '1rem',
              }}
            >
              <select name="" onChange={(e) => { changeData('interested_project', e.target.value, row.original.id) }} className='form-control' id="">
                {
                  projects.map((project) => {
                    return (
                      <option value={project.value}>{project.label}</option>
                    )
                  })
                }
              </select>
            </Box>
          ),
        },
        {
          accessorKey: 'meet_type', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          id: 'meet_type', //id is still required when using accessorFn instead of accessorKey
          header: 'Görüşme Türü',
          size: 250,
          enableEditing: false,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => (
            <Box
              sx={{
                display: 'flex',
                alignItems: 'center',
                gap: '1rem',
              }}
            >
              <select name="" onChange={(e) => { changeData('meet_type', e.target.value, row.original.id) }} className='form-control' id="">
                <option value="">Görüşme Türü Seçiniz</option>
                <option value="1" selected={renderedCellValue == 1}>Telefon Numarası</option>
                <option value="2" selected={renderedCellValue == 2}>Ziyaret</option>
                <option value="3" selected={renderedCellValue == 3}>Yüz Yüze</option>
                <option value="4" selected={renderedCellValue == 4}>Zoom</option>
              </select>
            </Box>
          ),
        },
        {
          accessorKey: 'note', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          id: 'note', //id is still required when using accessorFn instead of accessorKey
          header: 'Görüşme Notu',
          size: 250,
          enableEditing: false,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => (
            <Box
              sx={{
                display: 'flex',
                alignItems: 'center',
                gap: '1rem',
              }}
            >
              <textarea onChange={(e) => { changeData('note', e.target.value, row.original.id) }} className='form-control' value={renderedCellValue} name="" id=""></textarea>
            </Box>
          ),
        },
        {
          accessorKey: 'rating', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          id: 'rating', //id is still required when using accessorFn instead of accessorKey
          header: 'Müşteri Kalite Puanı',
          size: 250,
          enableEditing: false,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => (
            <Box
              sx={{
                display: 'flex',
                alignItems: 'center',
                gap: '1rem',
              }}
            >
              <Rating
                name="simple-controlled"
                value={renderedCellValue}
                onChange={(event, newValue) => {
                  changeData('rating', newValue, row.original.id)
                }}
              />
            </Box>
          ),
        },
        {
          accessorKey: 'customer_status', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          id: 'customer_status', //id is still required when using accessorFn instead of accessorKey
          header: 'Müşteri Statüsü',
          size: 250,
          enableEditing: false,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => (
            <Box
              sx={{
                display: 'flex',
                alignItems: 'center',
                gap: '1rem',
              }}
            >
              <select onChange={(e) => { changeData('customer_status', e.target.value, row.original.id) }} name="" className='form-control' id="">
                <option value="">Müşteri Statüsü</option>
                <option value="1" selected={renderedCellValue == 1}>Olumsuz</option>
                <option value="2" selected={renderedCellValue == 2}>Ulaşılamadı</option>
                <option value="3" selected={renderedCellValue == 3}>Nötr</option>
                <option value="4" selected={renderedCellValue == 4}>Takip Edilecek</option>
                <option value="5" selected={renderedCellValue == 5}>Olumlu</option>
                <option value="6" selected={renderedCellValue == 6}>Opsiyon</option>
                <option value="7" selected={renderedCellValue == 7}>Satış</option>
              </select>
            </Box>
          ),
        },
        {
          accessorKey: 'presentation', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          id: 'presentation', //id is still required when using accessorFn instead of accessorKey
          header: 'Sunum Dosyası',
          size: 250,
          enableEditing: false,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => {
            console.log(renderedCellValue);
            return (
              <Box
                sx={{
                  display: 'flex',
                  alignItems: 'center',
                  gap: '1rem',
                }}
              >
                <Checkbox onChange={(e) => { changeData('presentation', !renderedCellValue, row.original.id) }} checked={renderedCellValue} />
              </Box>
            )
          },
        },
        {
          accessorKey: 'conclusion', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          id: 'conclusion', //id is still required when using accessorFn instead of accessorKey
          header: 'Görüşme Sonucu',
          size: 250,
          enableEditing: false,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => (
            <Box
              sx={{
                display: 'flex',
                alignItems: 'center',
                gap: '1rem',
              }}
            >

              <select name="" onChange={(e) => { changeData('conclusion', e.target.value, row.original.id) }} className='form-control' id="">
                <option value="">Görüşme Sonucu</option>
                <option value="1" selected={renderedCellValue == 1}>Randevu</option>
                <option value="2" selected={renderedCellValue == 2}>Yeni Projelerde Aranacak</option>
                <option value="3" selected={renderedCellValue == 3}>Bir Daha Aranmayacak</option>
              </select>
            </Box>
          ),
        },
        {
          accessorKey: 'return_date', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          id: 'return_date', //id is still required when using accessorFn instead of accessorKey
          header: 'Geri Dönüş Tarihi',
          size: 250,
          enableEditing: false,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => {
            console.log(renderedCellValue);
            return (
              <Box
                sx={{
                  display: 'flex',
                  alignItems: 'center',
                  gap: '1rem',
                }}
              >
                <input type="date" onChange={(e) => { changeData('return_date', e.target.value, row.original.id) }} className='form-control' value={renderedCellValue} />
              </Box>
            )
          },
        },
        {
          accessorKey: 'was_meeting', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          id: 'was_meeting', //id is still required when using accessorFn instead of accessorKey
          header: 'Görüşme Yapıldı',
          size: 250,
          enableEditing: false,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => (
            <Box
              sx={{
                display: 'flex',
                alignItems: 'center',
                gap: '1rem',
              }}
            >
              <Checkbox onChange={(e) => {
                Swal.fire({
                  title: "Görüşme yapıldı mı?",
                  text: "Görüşme yapıldı olarak işaretlerseniz görüşme yapılanlar başlığı altına taşınacaktır.",
                  showDenyButton: false,
                  showCancelButton: true,
                  confirmButtonText: "Evet",
                  cancelButtonText: "İptal",
                }).then((result) => {
                  if (result.isConfirmed) {
                    changeData('was_meeting', !renderedCellValue, row.original.id);
                  }
                });

              }} checked={renderedCellValue} />
            </Box>
          ),
        },{
          accessorKey: 'actions', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          id: 'actions', //id is still required when using accessorFn instead of accessorKey
          header: 'İşlemler',
          size: 250,
          enableEditing: false,
          enableColumnFilterModes: false,
          enableColumnFilter: false,
          enableSorting: false,
          enableColumnActions: false,
          enableColumnPinning: false,
          enableColumnOrdering: false,
          Cell: ({ renderedCellValue, row }) => (
            <Box
              sx={{
                display: 'flex',
                alignItems: 'center',
                gap: '1rem',
              }}
            >
              <div className="tabs">
                <ul>
                  <li className="active" onClick={() => {customerProfileOpenFunc(row.original.id)}}><i className='fa fa-user'></i></li>
                  <li className="active"><i className='fa fa-plus'></i></li>
                  <li className="active"><i className='fa fa-handshake'></i></li>
                  <li className="active"><i className='fa fa-heart'></i></li>
                </ul>
              </div>
            </Box>
          ),
        },
      ],
    },
  ];

  const table = useMaterialReactTable({
    columns,
    data: customers, //data must be memoized or stable (useState, useMemo, defined outside of this component, etc.)
    enableColumnFilterModes: true,
    enableColumnOrdering: true,
    enableGrouping: true,
    enableColumnPinning: true,
    enableFacetedValues: true,
    enableRowActions: false,
    enableRowSelection: false,
    enableEditing: true,
    editDisplayMode: 'cell',
    initialState: {
      showColumnFilters: true,
      showGlobalFilter: true,
      columnPinning: {
        left: ['mrt-row-expand', 'mrt-row-select','was_meeting'],
        right: ['mrt-row-actions','actions'],
      },
    },
    state: {
      isLoading : loading
    },
    paginationDisplayMode: 'pages',
    positionToolbarAlertBanner: 'bottom',
    muiSearchTextFieldProps: {
      size: 'small',
      variant: 'outlined',
    },
    muiPaginationProps: {
      color: 'secondary',
      rowsPerPageOptions: [10, 20, 30],
      shape: 'rounded',
      variant: 'outlined',
    },
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
          <AccountCircle />
        </ListItemIcon>
        Kullanıcı Kayıtları
      </MenuItem>,
      <MenuItem
        key={1}
        onClick={() => {
          // Send email logic...
          closeMenu();
        }}
        sx={{ m: 0 }}
      >
        <ListItemIcon>
          <Send />
        </ListItemIcon>
        Send Email
      </MenuItem>,
    ],
    enableStickyHeader: true,
    enableStickyFooter: true,
    onShowGlobalFilterChange : false,
    enableGlobalFilterModes : false,
    enableGlobalFilter: false,
    enableGlobalFilterRankedResults:false,
    enableFilterMatchHighlighting : false,
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
      <div class="tabs">
        <ul>
          <li onClick={() => {setWasMeeting(0)}} className={wasMeeting == 0 ? "active" : ""}>Arama Yapılmamış</li>
          <li onClick={() => {setWasMeeting(1)}} className={wasMeeting == 1 ? "active" : ""}>Arama Yapılmış</li>
        </ul>
      </div>
      {
        wasMeeting == 1 ? 
          <div className="filters">
            <div className="card p-4 my-2">
              <div className="row">
                <div className="col-md-3">
                  <label htmlFor="">Görüşme Türü</label>
                  <select className='form-control' value={selectedMeetType} onChange={(e) => {setSelectedMeetType(e.target.value)}} name="" id="">
                    <option value="">Görüşme Türü Seçiniz</option>
                    <option value="1" selected={selectedMeetType == 1}>Telefon Numarası</option>
                    <option value="2" selected={selectedMeetType == 2}>Ziyaret</option>
                    <option value="3" selected={selectedMeetType == 3}>Yüz Yüze</option>
                    <option value="4" selected={selectedMeetType == 4}>Zoom</option>
                  </select>
                </div>
                <div className="col-md-3">
                  <label htmlFor="">Müşteri Kalite Puani</label>
                  <select className='form-control' value={selectedRating} onChange={(e) => {setSelectedRating(e.target.value)}} name="" id="">
                    <option value="">Müşteri Kalite Puani Seçiniz</option>
                    <option value="1" selected={selectedRating == 1}>1</option>
                    <option value="2" selected={selectedRating == 2}>2</option>
                    <option value="3" selected={selectedRating == 3}>3</option>
                    <option value="4" selected={selectedRating == 4}>4</option>
                    <option value="5" selected={selectedRating == 5}>5</option>
                  </select>
                </div>
                <div className="col-md-3">
                  <label htmlFor="">Müşteri Statüsü</label>
                  <select className='form-control' value={selectedCustomerStatus} onChange={(e) => {setSelectedCustomerStatus(e.target.value)}} name="" id="">
                    <option value="">Müşteri Statüsü Seçiniz</option>
                    <option value="1" selected={selectedCustomerStatus == 1}>Olumsuz</option>
                    <option value="2" selected={selectedCustomerStatus == 2}>Ulaşılamadı</option>
                    <option value="3" selected={selectedCustomerStatus == 3}>Nötr</option>
                    <option value="4" selected={selectedCustomerStatus == 4}>Takip Edilecek</option>
                    <option value="5" selected={selectedCustomerStatus == 5}>Olumlu</option>
                    <option value="6" selected={selectedCustomerStatus == 6}>Opsiyon</option>
                    <option value="7" selected={selectedCustomerStatus == 7}>Satış</option>
                  </select>
                </div>
                <div className="col-md-3">
                  <label htmlFor="">Görüşme Sonucu</label>
                  <select className='form-control' value={selectedConclusion} onChange={(e) => {setSelectedConclusion(e.target.value)}} name="" id="">
                    <option value="">Görüşme Sonucu Seöiniz</option>
                    <option value="1">Randevu</option>
                    <option value="2">Yeni Projelerde Aranacak</option>
                    <option value="3">Bir Daha Aranmayacak</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        : ''
      }
      <MaterialReactTable table={table} />
      <CustomerProfile open={customerProfileOpen} customerId={selectedCustomerId} setOpen={setCustomerProfileOpen}/>
    </>
  );
}
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { useEffect } from 'react';
import { useState } from 'react';
import axios from 'axios';
import { baseUrl } from '../define/variables';
import { render } from 'react-dom';
import { ro } from 'date-fns/locale';
import Swal from 'sweetalert2';
import QueryString from 'qs';
import CustomerProfile from './create_project_components/CustomerProfile';
const ExampleWithLocalizationProvider = () => (
  //App.tsx or AppProviders file
  <LocalizationProvider dateAdapter={AdapterDayjs}>
    <Crm />
  </LocalizationProvider>
);

export default ExampleWithLocalizationProvider;
