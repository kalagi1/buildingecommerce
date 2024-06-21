import * as React from 'react';
import { useMemo } from 'react';
import  { useRef } from 'react';
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
  Dialog,
  DialogActions,
  DialogContent,
  DialogContentText,
  DialogTitle,
  IconButton,
  TextField
} from '@mui/material';
import AddIcon from '@mui/icons-material/Add';

//Icons Imports
import { AccountCircle, Send } from '@mui/icons-material';
import CircularProgress from '@mui/material/CircularProgress';
import '../../css/crm.css';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import moment from 'moment';
// import '@fullcalendar/common/main.css';
// import '@fullcalendar/daygrid/main.css';
// const localizer = momentLocalizer(moment);
// import Modal from './Modal';

const Crm = () => {
  const [customers, setCustomers] = useState([]);
  const [projects, setProjects] = useState([]);
  const [wasMeeting,setWasMeeting] = useState(0);
  const [loading,setLoading] = useState(false);
  const [loadingModal, setLoadingModal] = useState(false);
  const [selectedMeetType,setSelectedMeetType] = useState(null);
  const [selectedRating,setSelectedRating] = useState(null);
  const [selectedCustomerStatus,setSelectedCustomerStatus] = useState(null);
  const [selectedConclusion,setSelectedConclusion] = useState(null);

  const [openDialog, setOpenDialog] = useState(false);
  const [selectedCustomer, setSelectedCustomer] = useState(null);
  const [anchorEl, setAnchorEl] = useState(null);
  const formRef = useRef(null); // Ref tanımlama
  // State değişkeni tanımı
const [showAllCalls, setShowAllCalls] = useState(false);
const [events, setEvents] = useState([]);
const [selectedEvent, setSelectedEvent] = useState(null);
const [isDialogOpen, setIsDialogOpen] = useState(false);
const [customerData, setCustomerData] = useState(null);
const [projectData, setProjectData] = useState(null);

  var months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];
  const fetchRecords = () => {
    setLoading(true);
    var filter = {
      was_meeting: wasMeeting,
      selected_meet_type: selectedMeetType,
      selected_rating: selectedRating,
      selected_customer_status: selectedCustomerStatus,
      selected_conclusion: selectedConclusion
    };

    axios.get(baseUrl + 'customer?' + QueryString.stringify(filter)).then((res) => {
      setCustomers(res.data.data);
      setProjects(res.data.projects);
      setLoading(false);
    });
  };

  useEffect(() => {
    setLoading(true);
    fetchRecords();
  }, [wasMeeting,selectedMeetType,selectedRating,selectedConclusion,selectedCustomerStatus])

  const changeData = (key, value, id) => {
    axios.put(baseUrl + 'customer/' + id, { key, value }).then((res) => {
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

  const columns = [
    {
      id: 'employee', //id used to define `group` column
      header: 'Müşteriler',
      columns: [
        {
          accessorKey: 'date', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          header: 'Tarih',
          size: 250,
          enableStickyHeader: true,
          enableStickyFooter: true,
          onShowGlobalFilterChange : false,
          enableGlobalFilterModes : false,
          enableGlobalFilter: false,
          enableGlobalFilterRankedResults:false,
          enableFilterMatchHighlighting : false,
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
            // console.log(row);
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
          accessorKey: 'project', //accessorKey used to define `data` column. `id` gets set to accessorKey automatically
          id: 'project', //id is still required when using accessorFn instead of accessorKey
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
              <select name="" className='form-control' id="">
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
            // console.log(renderedCellValue);
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
            // console.log(renderedCellValue);
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
        },
      ],
    },
  ];

  const handleClickOpen = (customer) => {
    setSelectedCustomer(customer);
    setOpenDialog(true);
  };
// console.log('customer-->>'+JSON.stringify(selectedCustomer))
  const handleClose = () => {
    setOpenDialog(false);
    setSelectedCustomer(null);
  };


  const table = useMaterialReactTable({
    columns,
    data: customers, //data must be memoized or stable (useState, useMemo, defined outside of this component, etc.)
    enableColumnFilterModes: true,
    enableColumnOrdering: true,
    enableGrouping: true,
    enableColumnPinning: true,
    enableFacetedValues: true,
    enableRowActions: true,
    enableRowSelection: true,
    enableEditing: true,
    editDisplayMode: 'cell',
    initialState: {
      showColumnFilters: true,
      showGlobalFilter: true,
      columnPinning: {
        left: ['mrt-row-expand', 'mrt-row-select','was_meeting'],
        right: ['mrt-row-actions'],
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
    renderRowActionMenuItems: ({ closeMenu,row }) => [
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
        View Profile
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
       <MenuItem onClick={() => {
        setAnchorEl(null);
        handleClickOpen(row.original);
      }}>
         <ListItemIcon>
         <Send />

        </ListItemIcon>
        Arama Kayıtları</MenuItem>
    ],
    enableStickyHeader: true,
    enableStickyFooter: true,
    onShowGlobalFilterChange : false,
    enableGlobalFilterModes : false,
    enableGlobalFilter: false,
    enableGlobalFilterRankedResults:false,
    enableFilterMatchHighlighting : false,
  });

  const formatDate = (dateString) => {
    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
  };

  const [showForm, setShowForm] = useState(false);
  const [newRecord, setNewRecord] = useState({
    meet_date: '',
    note: '',
    meet_type: '',
    presentation: '',
    conclusion: '',
    appointment_date: '',
    appointment_info: '',
    email: '',
    city: '',
    name: '',
    project_title: ''
  });

  const handleChange = (e) => {
    setNewRecord({
      ...newRecord,
      [e.target.name]: e.target.value
    });
  };

  useEffect(() => {
    if (selectedCustomer) {
      setNewRecord({
        meet_date: '',
        note: '',
        meet_type: '',
        presentation: '',
        conclusion: '',
        appointment_date: '',
        appointment_info: '',
        email: selectedCustomer.email || '',
        city: selectedCustomer.city || '',
        name: selectedCustomer.name || '',
        project_title: selectedCustomer.project.project_title || ''
      });
    }
  }, [selectedCustomer]);

  const handleSave = async () => {
    try {
      // Save the new call record
      setLoadingModal(true);
      const response = await axios.post(baseUrl+'new-call-record', {
        customer_id: selectedCustomer.id,
        meet_date: newRecord.meet_date,
        note: newRecord.note,
        meet_type: newRecord.meet_type,
        presentation: newRecord.presentation,
        conclusion: newRecord.conclusion,
        email: newRecord.email,
        city: newRecord.city,
        name: newRecord.name,
        project_title: newRecord.project_title
      });

      if (newRecord.conclusion === 1) {
        // Save the appointment if the conclusion is 'Randevu'
        await axios.post(baseUrl+'new-appointment', {
          customer_id: selectedCustomer.id,
          appointment_date: newRecord.appointment_date,
          appointment_info: newRecord.appointment_info
        });
      }

      console.log('New Record saved:', response.data);

      // Close the form after saving
      setShowForm(false);

      // Reset the form
      setNewRecord({
        meet_date: '',
        note: '',
        meet_type: '',
        presentation: '',
        conclusion: '',
        appointment_date: '',
        appointment_info: '',
        email: '',
        city: '',
        name: '',
        project_title: ''
      });

      fetchAllCustomerCalls();
      setLoadingModal(false);

    } catch (error) {
      console.error('Error saving the new record:', error);
    }
  };

const fetchAllCustomerCalls = async () => {
  try {
    const response = await  axios.get(baseUrl + 'fetch-customers/' + selectedCustomer.id);
    setCustomerCalls(response.data.data);
    console.log('aramaaaa '+JSON.stringify(customerCalls))
  } catch (error) {
    console.error('Error fetching customer calls:', error);
  }
};


const [customerCalls, setCustomerCalls] = useState([]);

useEffect(() => {
  const fetchCustomerCalls = async () => {
    setLoadingModal(true); // Yükleme durumunu başlat
    try {
      const response = await axios.get(baseUrl + 'fetch-customers/' + selectedCustomer.id);
      setCustomerCalls(response.data.data);
    } catch (error) {
      console.error('Error fetching customer calls:', error);
    }
    setLoadingModal(false); // Yükleme durumunu bitir
  };

  if (selectedCustomer && selectedCustomer.id) {
    fetchCustomerCalls();
  }
}, [selectedCustomer]);

const [date, setDate] = useState(new Date());
const [appointments, setAppointments] = useState([]);
const [selectedAppointments, setSelectedAppointments] = useState([]);

useEffect(() => {
  getAppointments();
}, []);

const getAppointments = async () => {
  try {
    const response = await axios.get(baseUrl + 'all-appointments');
    // console.log('Fetched appointments:',JSON.stringify(response.data));
    setAppointments(response.data.data);
    const formattedEvents = response.data.data.map(appointment => ({
      title: appointment.appointment_info,
      date: appointment.appointment_date,
      id: appointment.id, 
      customer_id: appointment.customer_id,
    }));
    setEvents(formattedEvents);
  } catch (error) {
    console.error('Error fetching appointments:', error);
  }
};

  // Takvimde bir etkinliğe tıklandığında tetiklenecek fonksiyon
  const handleEventClick = (clickInfo) => {
    const clickedEvent = events.find(event => event.id == clickInfo.event._def.publicId);
   
    setSelectedEvent(clickedEvent);
    setIsDialogOpen(true);   

    if (clickedEvent) {
      axios.get(baseUrl +`getbycustomer/${clickedEvent.customer_id}`)
        .then(response => {
          setCustomerData(response.data.data);
           setProjectData(response.data.project)
        
        })
        .catch(error => {
          console.error('Error fetching customer data:', error);
        });
       
    }
   
};
console.log('data'+projectData)
const handleCloseDialog = () => {
  setIsDialogOpen(false);
  setSelectedEvent(null);
  setCustomerData(null);
  setProjectData(null);
};

  return (
    <>
      <div class="tabs">
        <ul>
          <li onClick={() => {setWasMeeting(0)}} className={wasMeeting == 0 ? "active" : ""}>Arama Yapılmamış</li>
          <li onClick={() => {setWasMeeting(1)}} className={wasMeeting == 1 ? "active" : ""}>Arama Yapılmış</li>
          <li onClick={() => {setWasMeeting(2)}} className={wasMeeting === 2 ? "active" : ""}>Randevu Takvimi</li>
        </ul>
      </div>

      {wasMeeting === 2 && (
        
        <div style={{ width: '80%', margin: '20px auto' }}>
            <FullCalendar
              plugins={[dayGridPlugin]}
              initialView="dayGridMonth"
              events={events}
              eventColor="green"
              locale="tr"
              height="auto"
              contentHeight={400}
              eventClick={handleEventClick} // Etkinliğe tıklama işlemi
            />
       
     
        </div>
        
      )}
       <Dialog
            open={isDialogOpen}
            onClose={handleCloseDialog}
            aria-labelledby="alert-dialog-title"
            >
              {/* <DialogTitle id="alert-dialog-title">
              <h3 className='section-title'>Müşteri Bilgileri ve Randevu Detayları</h3>
              </DialogTitle> */}
              <DialogContent style={{width:'400px'}}>
                {selectedEvent && (
                  <div className="event-details">
                    <h4 className='section-title'>Müşteri Bilgileri</h4>
                  
                    {customerData ? (
                      <>
                        <p>İsim              : <strong> {customerData.name}</strong></p>
                        <p>Email             : <strong>{customerData.email}</strong></p>
                        <p>Telefon           : <strong>{customerData.phone}</strong></p>
                        <p>Meslek            : <strong> {customerData.job}</strong></p>
                        <p>Şehir             : <strong>{customerData.city}</strong></p>
                        <p>İlgilendiği Proje : <strong>{projectData ? projectData.project_title : 'Yükleniyor...'}</strong></p>
              
                      </>
                    ) : (
                      <p>Müşteri bilgileri yükleniyor...</p>
                    )}
                    <h4 className='section-title'>Randevu Bilgileri</h4>

                    <p>Randevu Bilgisi : <strong> {selectedEvent.title}</strong></p>
                    <p>Randevu Tarihi  : <strong>{formatDate(selectedEvent.date)}</strong></p>
                  </div>
                )}
              </DialogContent>
                
              <DialogActions>
                  <Button onClick={handleCloseDialog} color="primary">
                    Kapat
                  </Button>
                </DialogActions>
    
          </Dialog>
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
                    <option value="">Görüşme Sonucu Seçiniz</option>
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
      <Dialog
        open={openDialog}
        onClose={handleClose}
        aria-labelledby="form-dialog-title"
        // maxWidth="md"
        // fullWidth
         >
      <DialogContent>
      {loadingModal ? (
          <div className="loading" style={{textAlign:'center'}}>
            <CircularProgress />
          </div>
        ) : (
          <>
       
      <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center',backgroundColor: 'whitesmoke',padding: '6px 20px' }}>
                <Typography variant="h6">Yeni Kayıt Ekle</Typography>
                <IconButton onClick={() => {
                      setShowForm(!showForm);
                      setTimeout(() => {
                          formRef.current.scrollIntoView({ behavior: 'smooth' }); // Scroll yap
                      }, 300);
                  }}>
                  <AddIcon />
                </IconButton>
              </Box><br />
        {selectedCustomer && (
          
          <Box sx={{ display: 'block', justifyContent: 'space-between', gap: '1rem', }}>
            <Box sx={{ flex: 1,marginBottom:'18px' }}>
              <Typography variant="h6" className="section-title">Müşteri Bilgileri</Typography>
              <hr />
              <br />
              <Box sx={{ display: 'flex',marginBottom:'2px' }}>
                <Typography sx={{ width: '25%' }}><strong>Ad:</strong></Typography>
                <Typography sx={{ width: '75%' }}>{selectedCustomer.name}</Typography>
              </Box>
              <Box sx={{ display: 'flex',marginBottom:'2px' }}>
                <Typography sx={{ width: '25%' }}><strong>Email:</strong></Typography>
                <Typography sx={{ width: '75%' }}>{selectedCustomer.email}</Typography>
              </Box>
              <Box sx={{ display: 'flex',marginBottom:'2px'}}>
                <Typography sx={{ width: '25%' }}><strong>Telefon:</strong></Typography>
                <Typography sx={{ width: '75%' }}>{selectedCustomer.phone}</Typography>
              </Box>
              <Box sx={{ display: 'flex',marginBottom:'2px'}}>
                <Typography sx={{ width: '25%' }}><strong>Şehir:</strong></Typography>
                <Typography sx={{ width: '75%' }}>{selectedCustomer.city}</Typography>
              </Box>
              <Box sx={{ display: 'flex',marginBottom:'2px' }}>
                <Typography sx={{ width: '25%' }}><strong>İlgilendiği Proje:</strong></Typography>
                <Typography sx={{ width: '75%' }}>{selectedCustomer.project.project_title}</Typography>
              </Box>
            </Box>
            <Box sx={{ flex: 1 }}>
            <Typography variant="h6"  className="section-title">Arama Kayıtları Bilgileri</Typography>
            <hr />
            {customerCalls.slice(0, 3).map(call => (
                <Box key={call.id}>
                
                  <br />
                  <Box sx={{ display: 'flex',marginBottom:'2px' }}>
                    <Typography sx={{ width: '25%' }}><strong>Görüşme Tarihi:</strong></Typography>
                    <Typography sx={{ width: '75%' }}>{formatDate(call.meeting_date)}</Typography>
                  </Box>
                  <Box sx={{ display: 'flex',marginBottom:'2px'  }}>
                    <Typography sx={{ width: '25%' }}><strong>Görüşme Türü:</strong></Typography>
                    <Typography sx={{ width: '75%' }}>
                      {call.meet_type == 1 ? "Telefon Numarası" : call.meet_type == 2 ? "Ziyaret" : call.meet_type == 3 ? "Yüz Yüze" :  call.meet_type == 4 ? "Zoom" : ""}
                    </Typography>
                  </Box>
             

                  <Box sx={{ display: 'flex',marginBottom:'2px'  }}>
                    <Typography sx={{ width: '25%' }}><strong>Görüşme Sonucu:</strong></Typography>
                    <Typography sx={{ width: '75%' }}>
                    {
                    call.conclusion == 1 ? "Randevu" : call.conclusion == 2 ? "Yeni Projelerde Aranacak" : call.conclusion == 3 ? "Bir daha aranmayacak" : ""
                    }
                    </Typography>
                  </Box>
                  <Box sx={{ display: 'flex',marginBottom:'2px' }}>
                      <Typography sx={{ width: '25%' }}><strong>Görüşme Notu:</strong></Typography>
                      <Typography sx={{ width: '75%' }}>{call.note}</Typography>
                  </Box>
                  <hr />
                </Box>                
              ))}
            </Box>
            {customerCalls.length > 4 && !showAllCalls && (
    <Button onClick={() => setShowAllCalls(true)} color="primary">
        Daha fazla göster
    </Button>
)}
{showAllCalls && (
    <>
        {customerCalls.slice(3).map(call => (
                  <Box key={call.id}>
                
                  <br />
                  <Box sx={{ display: 'flex',marginBottom:'2px'}}>
                    <Typography sx={{ width: '25%' }}><strong>Görüşme Tarihi:</strong></Typography>
                    <Typography>{formatDate(call.meeting_date)}</Typography>
                  </Box>
                  <Box sx={{ display: 'flex',marginBottom:'2px' }}>
                    <Typography sx={{ width: '25%' }}><strong>Görüşme Türü:</strong></Typography>
                    <Typography sx={{ width: '75%' }}>
                      {call.meet_type == 1 ? "Telefon Numarası" : call.meet_type == 2 ? "Ziyaret" : call.meet_type == 3 ? "Yüz Yüze" :  call.meet_type == 4 ? "Zoom" : ""}
                    </Typography>
                  </Box>
                  <Box sx={{ display: 'flex',marginBottom:'2px' }}>
                    <Typography sx={{ width: '25%' }}><strong>Görüşme Notu:</strong></Typography>
                    <Typography sx={{ width: '75%' }}>{call.note}</Typography>
                  </Box>
                  <Box sx={{ display: 'flex',marginBottom:'2px' }}>
                    <Typography sx={{ width: '25%' }}><strong>Görüşme Sonucu:</strong></Typography>
                    <Typography sx={{ width: '75%' }}>{call.conclusion == 1 ? "Randevu" : call.conclusion == 2 ? "Yeni Projelerde Aranaacak" : call.conclusion == 3 ? "Bir daha aranmayacak" : ""}
                    </Typography>
                  </Box><hr />
                </Box>   
        ))}
        <Button onClick={() => setShowAllCalls(false)} color="primary">
            Daha az göster
        </Button>
    </>
)}
          </Box>
        )}
        {showForm && (
          <Box sx={{ mt: 1 }}  ref={formRef}>
            <Typography variant="h6">Yeni Arama Kaydı Ekle</Typography>
            <Box sx={{ display: 'flex', flexDirection: 'column', gap: '1rem', mt: 2 }}>
              <TextField
                label="Görüşme Tarihi"
                type="date"
                name="meet_date"
                value={newRecord.meet_date}
                onChange={handleChange}
                InputLabelProps={{
                  shrink: true,
                }}
              />
              <TextField
                label="Görüşme Notu"
                name="note"
                value={newRecord.note}
                onChange={handleChange}
              />
              <TextField
                label="Görüşme Türü"
                name="meet_type"
                value={newRecord.meet_type}
                onChange={handleChange}
                select >
                <MenuItem value={1}>Telefon Numarası</MenuItem>
                <MenuItem value={2}>Ziyaret</MenuItem>
                <MenuItem value={3}>Yüz Yüze</MenuItem>
                <MenuItem value={4}>Zoom</MenuItem>
              </TextField>
              <TextField
                label="Sunum Dosyası"
                name="presentation"
                value={newRecord.presentation}
                onChange={handleChange}
                select
              >
                <MenuItem value={1}>Gösterildi</MenuItem>
                <MenuItem value={0}>Gösterilmedi</MenuItem>
              </TextField>
              <TextField
                label="Görüşme Sonucu"
                name="conclusion"
                value={newRecord.conclusion}
                onChange={handleChange}
                select >
                <MenuItem value={1}>Randevu</MenuItem>
                <MenuItem value={2}>Yeni Projelerde Aranacak</MenuItem>
                <MenuItem value={3}>Bir daha Aranmayacak</MenuItem>
              </TextField>
              {newRecord.conclusion === 1 && (
                <>
                  <TextField
                    label="Randevu Tarihi"
                    type="date"
                    name="appointment_date"
                    value={newRecord.appointment_date}
                    onChange={handleChange}
                    InputLabelProps={{
                      shrink: true,
                    }}
                  />
                  <TextField
                    label="Randevu Bilgisi"
                    name="appointment_info"
                    value={newRecord.appointment_info}
                    onChange={handleChange}
                  />
                </>
              )}
            </Box>
          </Box>
        )}
            </>
        )}
      </DialogContent>
      <DialogActions>
      {showForm && (
        <Button onClick={handleSave} color="primary">
          Kaydet
        </Button>
         )}
        <Button onClick={handleClose} color="primary">
          Kapat
        </Button>
      </DialogActions>
    </Dialog>
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
import Add from '@mui/icons-material/Add';
const ExampleWithLocalizationProvider = () => (
  //App.tsx or AppProviders file
  <LocalizationProvider dateAdapter={AdapterDayjs}>
    <Crm />
  </LocalizationProvider>
);

export default ExampleWithLocalizationProvider;
