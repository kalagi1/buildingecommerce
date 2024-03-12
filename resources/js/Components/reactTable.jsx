import React, { useEffect, useState } from 'react'
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import TablePagination from '@mui/material/TablePagination';
import { Box, IconButton, Skeleton, useTheme } from '@mui/material';
import { FirstPage, KeyboardArrowLeft, KeyboardArrowRight, LastPage } from '@mui/icons-material';
import axios from 'axios';
import { baseUrl } from '../define/variables';
import { ToastContainer, toast } from 'react-toastify';
import Swal from 'sweetalert2';

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

const TableRowsLoader = ({ rowsNum }) => {
    return [...Array(rowsNum)].map((row, index) => (
        <TableContainer component={Paper}>
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
        </TableContainer>    
    ));
};

function ReactTable(props) {
    const [tabs,setTabs] = useState([
        {
            tabId : 1 ,
            name : "Aktif İlanlar"
        },
        {
            tabId : 2,
            name : "Onay Bekleyen İlanlar",
        },
        {
            tabId : 3,
            name : "Reddedilen İlanlar",
        },{
            tabId : 0,
            name : "Pasif İlanlar"
        }
    ])

    const [page,setPage] = useState(0);
    const [tabIndex,setTabIndex] = useState(1);
    const [rows,setRows] = useState([]);
    const [rowPerPage,setRowPerPage] = useState(10);
    const [totalProjectsCount,setTotalProjectsCount] = useState(0);
    const [loading,setLoading] = useState(true);
    useEffect(() => {
        setLoading(true);
        axios.get('https://emlaksepette.com/react/my_projects?status='+tabIndex+'&start=0&take='+rowPerPage).then((res) => {
            setRows(res.data.data);
            setTotalProjectsCount(res.data.total_projects_count);
            setLoading(false);
            setPage(0);
        })
    },[tabIndex])
    
    const handleChangePage = (
        event,
        newPage,
    ) => {
        setLoading(true);
        setPage(newPage);
        var start = newPage * rowPerPage;
        axios.get(`https://emlaksepette.com/react/my_projects?status=${tabIndex}&start=${start}&take=${rowPerPage}`).then((res) => {
            setRows(res.data.data);
            setTotalProjectsCount(res.data.total_projects_count);
            setLoading(false);
        })
    };

    

    const handleChangeRowsPerPage = (
        event,
        
    ) => {
        setLoading(true);
        setRowPerPage(parseInt(event.target.value, 10));
        setPage(0);

        axios.get(`https://emlaksepette.com/react/my_projects?status=${tabIndex}&start=0&take=${event.target.value}`).then((res) => {
            setRows(res.data.data);
            setTotalProjectsCount(res.data.total_projects_count);   
            setLoading(false);
        })
    };

    const deactive = (id) => {
        Swal.fire({
            title: "Projeyi aktife almak istediğine emin misin?",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "Evet",
            cancelButtonText : "İptal"
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.post(baseUrl+'deactive/'+id,{"_method":"PUT"}).then((res) => {
                    if(res.data.status){
                        setLoading(true);
                        axios.get('https://emlaksepette.com/react/my_projects?status='+tabIndex+'&start=0&take='+rowPerPage).then((res) => {
                            Swal.fire("Başarıyla projeyi pasife aldınız", "", "success");
                            setRows(res.data.data);
                            setTotalProjectsCount(res.data.total_projects_count);
                            setLoading(false);
                            setPage(0);
                        })
                    }
                })
            }
        });
        
    }

    const active = (id) => {
        Swal.fire({
            title: "Projeyi aktife almak istediğine emin misin?",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "Evet",
            cancelButtonText : "İptal"
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.post(baseUrl+'active/'+id,{"_method":"PUT"}).then((res) => {
                    if(res.data.status){
                        setLoading(true);
                        axios.get(baseUrl+'/react/my_projects?status='+tabIndex+'&start=0&take='+rowPerPage).then((res) => {
                            setRows(res.data.data);
                            Swal.fire("Başarıyla projeyi aktife aldınız", "", "success");
                            setTotalProjectsCount(res.data.total_projects_count);
                            setLoading(false);
                            setPage(0);
                        })
                    }
                })
            }
        });
    }

    const remove = (id) => {
        Swal.fire({
            title: "Projeyi silmek istediğine emin misin?",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "Evet",
            cancelButtonText : "İptal"
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.post(baseUrl+'remove/'+id,{"_method":"DELETE"}).then((res) => {
                    if(res.data.status){
                        setLoading(true);
                        axios.get('https://emlaksepette.com/react/my_projects?status='+tabIndex+'&start=0&take='+rowPerPage).then((res) => {
                            Swal.fire("Başarıyla projeyi sildiniz", "", "success");
                            setRows(res.data.data);
                            setTotalProjectsCount(res.data.total_projects_count);
                            setLoading(false);
                            setPage(0);
                        })
                    }
                })
            }
        });

        
    }


    return(
        <div className="estate-table">
            <ToastContainer/>
            <div className="table-breadcrumb">
                <ul>
                    <li>
                        Yönetim Paneli
                    </li>
                    <li className='none-underline'> / </li>
                    <li>Proje İlanlarım</li>
                </ul>
            </div>
            <div className="tabs">
                <ul>
                    {
                        tabs.map((tab) => {
                            return(
                                <li onClick={() => {setTabIndex(tab.tabId)}} className={tabIndex == tab.tabId ? "active" : ""}>{tab.name}</li>
                            )
                        })
                    }
                </ul>
            </div>
            {
                loading ? 
                    <TableRowsLoader/>
                : 
                    rows.length > 0 ?
                        <>
                            <TableContainer component={Paper}>
                                <Table sx={{ minWidth: 650 }} aria-label="simple table">
                                    <TableHead>
                                        <TableRow>
                                            <TableCell>No.</TableCell>
                                            <TableCell>Proje Adı</TableCell>
                                            <TableCell>Toplam İlan Sayısı</TableCell>
                                            <TableCell>Satış Adeti</TableCell>
                                            <TableCell>Onaydaki Siparişler</TableCell>
                                            <TableCell>Satışa Kapalı Adet</TableCell>
                                            <TableCell>Satışa Açık Adet</TableCell>
                                            <TableCell>Yayın Durumu</TableCell>
                                            <TableCell>İlanları Düzenle</TableCell>
                                            <TableCell>İşlem Kayıtları & Genel Düzenleme</TableCell>
                                            <TableCell>Sil</TableCell>
                                        </TableRow>
                                    </TableHead>
                                    <TableBody>
                                    {rows.map((row) => (
                                        <TableRow
                                        key={row.id}
                                        sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                                        >
                                            <TableCell scope="row">
                                                {1000000+row.id}
                                            </TableCell>
                                            <TableCell >
                                                {row.project_title} 
                                                <br/>
                                                <span className='table-location'>
                                                    {row.city.title} / {row.county.ilce_title} / {row.neighbourhood?.mahalle_title}
                                                </span>
                                            </TableCell>
                                            <TableCell>{row.room_count}</TableCell>
                                            <TableCell>{row.cartOrders}</TableCell>
                                            <TableCell>{row.paymentPending}</TableCell>
                                            <TableCell>{row.offSale}</TableCell>
                                            <TableCell>{row.room_count - row.cartOrders - row.offSale}</TableCell>
                                            <TableCell>{
                                                row.status == 1 ? 
                                                    <div className='text-success'>Yayında</div> 
                                                : 
                                                row.status == 2 ? 
                                                    <div className='text-warning'>Admin Onayı Bekliyor</div> 
                                                : row.status == 3 ? 
                                                    <div class="text-danger">Reddedildi</div> 
                                                : <div class="text-danger">Pasif</div>}
                                            </TableCell>
                                            <TableCell>
                                                <a href={`https://emlaksepette.com/institutional/projects/${row.id}/housings`} class="badge badge-phoenix badge-phoenix-success">İlanları Düzenle</a>
                                            </TableCell>
                                            <TableCell>
                                                <a class="badge badge-phoenix badge-phoenix-warning" href={`https://emlaksepette.com/institutional/projects/${row.id}/logs`}>İşlem Kayıtları</a>
                                                <a class="badge badge-phoenix badge-phoenix-success mx-3" href={`https://emlaksepette.com/institutional/edit_project_v2/${row.slug}/${row.id}`}>Genel Düzenleme</a>
                                            </TableCell>
                                            <TableCell>
                                                {
                                                    row.status == 2 ?
                                                        <button onClick={() => {active(row.id)}} className='badge badge-phoenix badge-phoenix-warning'>Admin Onayının Arından işlem Yapabilirsiniz</button>
                                                    : 
                                                        row.status == 0 ? 
                                                            <button onClick={() => {active(row.id)}} className='badge badge-phoenix badge-phoenix-success'>Aktife Al</button>
                                                        :  
                                                            <button onClick={() => {deactive(row.id)}} className='badge badge-phoenix badge-phoenix-danger'>Pasife Al</button>

                                                }
                                                <button onClick={() => {remove(row.id)}} className='badge badge-phoenix badge-phoenix-danger mx-3'>Sil</button>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                    </TableBody>
                                </Table>
                            </TableContainer>
                            <TablePagination
                            rowsPerPageOptions={[5, 10, 25, { label: 'All', value: 999 }]}
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
    )
}
export default ReactTable