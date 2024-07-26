import React, { useEffect, useState } from "react";
import Table from "@mui/material/Table";
import TableBody from "@mui/material/TableBody";
import TableCell from "@mui/material/TableCell";
import TableContainer from "@mui/material/TableContainer";
import TableHead from "@mui/material/TableHead";
import TableRow from "@mui/material/TableRow";
import Paper from "@mui/material/Paper";
import TablePagination from "@mui/material/TablePagination";
import { Box, IconButton, Popover, Skeleton, useTheme } from "@mui/material";
import {
  FirstPage,
  KeyboardArrowLeft,
  KeyboardArrowRight,
  LastPage,
} from "@mui/icons-material";
import axios from "axios";
import { baseUrl, frontEndUrl } from "../define/variables";
import { ToastContainer, toast } from "react-toastify";
import Swal from "sweetalert2";

function TablePaginationActions(props) {
  const theme = useTheme();
  const { count, page, rowsPerPage, onPageChange } = props;

  const handleFirstPageButtonClick = (event) => {
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
        {theme.direction === "rtl" ? <LastPage /> : <FirstPage />}
      </IconButton>
      <IconButton
        onClick={handleBackButtonClick}
        disabled={page === 0}
        aria-label="previous page"
      >
        {theme.direction === "rtl" ? (
          <KeyboardArrowRight />
        ) : (
          <KeyboardArrowLeft />
        )}
      </IconButton>
      <IconButton
        onClick={handleNextButtonClick}
        disabled={page >= Math.ceil(count / rowsPerPage) - 1}
        aria-label="next page"
      >
        {theme.direction === "rtl" ? (
          <KeyboardArrowLeft />
        ) : (
          <KeyboardArrowRight />
        )}
      </IconButton>
      <IconButton
        onClick={handleLastPageButtonClick}
        disabled={page >= Math.ceil(count / rowsPerPage) - 1}
        aria-label="last page"
      >
        {theme.direction === "rtl" ? <FirstPage /> : <LastPage />}
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
  const [tabs, setTabs] = useState([
    {
      tabId: 1,
      name: "Aktif İlanlar",
    },
    {
      tabId: 2,
      name: "Onay Bekleyen İlanlar",
    },
    {
      tabId: 3,
      name: "Reddedilen İlanlar",
    },
    {
      tabId: 0,
      name: "Pasif İlanlar",
    },
  ]);

  const [page, setPage] = useState(0);
  const [tabIndex, setTabIndex] = useState(1);
  const [rows, setRows] = useState([]);
  const [rowPerPage, setRowPerPage] = useState(10);
  const [totalProjectsCount, setTotalProjectsCount] = useState(0);
  const [loading, setLoading] = useState(false);
  const [anchorEl,setAnchorEl] = useState(null);
  useEffect(() => {
    if(!loading){
      setLoading(true);
      axios
        .get(
          "https://private.emlaksepette.com/react/my_projects?status=" +
            tabIndex +
            "&start=0&take=" +
            rowPerPage
        )
        .then((res) => {
          setRows(res.data.data);
          setTotalProjectsCount(res.data.total_projects_count);
          setLoading(false);
          setPage(0);
        });
    }
  }, [tabIndex]);

  const handleChangePage = (event, newPage) => {
    setLoading(true);
    setPage(newPage);
    var start = newPage * rowPerPage;

    axios
      .get(
        `https://private.emlaksepette.com/react/my_projects?status=${tabIndex}&start=${start}&take=${rowPerPage}`
      )
      .then((res) => {
        setRows(res.data.data);
        setTotalProjectsCount(res.data.total_projects_count);
        setLoading(false);
      });
  };

  const handleChangeRowsPerPage = (event) => {
    setLoading(true);
    setRowPerPage(parseInt(event.target.value, 10));
    setPage(0);

    axios
      .get(
        `https://private.emlaksepette.com/react/my_projects?status=${tabIndex}&start=0&take=${event.target.value}`
      )
      .then((res) => {
        setRows(res.data.data);
        setTotalProjectsCount(res.data.total_projects_count);
        setLoading(false);
      });
  };

  const deactive = (id) => {
    Swal.fire({
      title: "Projeyi pasife almak istediğine emin misin?",
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: "Evet",
      cancelButtonText: "İptal",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        axios
          .post(baseUrl + "deactive/" + id, { _method: "PUT" })
          .then((res) => {
            if (res.data.status) {
              setLoading(true);

              axios
                .get(
                  "https://private.emlaksepette.com/react/my_projects?status=" +
                    tabIndex +
                    "&start=0&take=" +
                    rowPerPage
                )
                .then((res) => {
                  Swal.fire("Başarıyla projeyi pasife aldınız", "", "success");
                  setRows(res.data.data);
                  setTotalProjectsCount(res.data.total_projects_count);
                  setLoading(false);
                  setPage(0);
                });
            }
          });
      }
    });
  };

  const active = (id) => {
    Swal.fire({
      title: "Projeyi aktife almak istediğine emin misin?",
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: "Evet",
      cancelButtonText: "İptal",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        axios.post(baseUrl + "active/" + id, { _method: "PUT" }).then((res) => {
          if (res.data.status) {
            setLoading(true);
            axios
              .get(
                baseUrl +
                  "/react/my_projects?status=" +
                  tabIndex +
                  "&start=0&take=" +
                  rowPerPage
              )
              .then((res) => {
                setRows(res.data.data);
                Swal.fire("Başarıyla projeyi aktife aldınız", "", "success");
                setTotalProjectsCount(res.data.total_projects_count);
                setLoading(false);
                setPage(0);
              });
          }
        });
      }
    });
  };

  const remove = (id) => {
    Swal.fire({
      title: "Projeyi silmek istediğine emin misin?",
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: "Evet",
      cancelButtonText: "İptal",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        axios
          .post(baseUrl + "remove/" + id, { _method: "DELETE" })
          .then((res) => {
            if (res.data.status) {
              setLoading(true);

              axios
                .get(
                  "https://private.emlaksepette.com/react/my_projects?status=" +
                    tabIndex +
                    "&start=0&take=" +
                    rowPerPage
                )
                .then((res) => {
                  Swal.fire("Başarıyla projeyi sildiniz", "", "success");
                  setRows(res.data.data);
                  setTotalProjectsCount(res.data.total_projects_count);
                  setLoading(false);
                  setPage(0);
                });
            }
          });
      }
    });
  };

  const open = Boolean(anchorEl);

  const handleClose = () => {
    setAnchorEl(null);
  };

  const handleClick = (event,row) => {
    setAnchorEl(event.currentTarget);
    setSelectedRow(row);
  };

  const id = open ? 'simple-popover' : undefined;
  const [selectedRow,setSelectedRow] = useState(null)

  return (
    <div className="estate-table">
      <ToastContainer />
      <div className="table-breadcrumb">
        <ul>
          <li><i className="fa fa-home"></i></li>
          <li>Ofisim</li>
          <li>Proje İlanlarım</li>
        </ul>
      </div>
      <div className="front-project-tabs mt-5">
        <ul>
          {tabs.map((tab) => {
            return (
              <li
                onClick={() => {
                  if(!loading){
                    setTabIndex(tab.tabId);
                  }
                }}
                className={tabIndex == tab.tabId ? "active" : ""}
              >
                {tab.name}
              </li>
            );
          })}
        </ul>
      </div>

      <div>
        {
          loading ? 
            <>
              <Skeleton variant="rounded" width='100%' height={60} style={{marginTop:'10px'}}/>
              <Skeleton variant="rounded" width='100%' height={60} style={{marginTop:'10px'}}/>
              <Skeleton variant="rounded" width='100%' height={60} style={{marginTop:'10px'}}/>
              <Skeleton variant="rounded" width='100%' height={60} style={{marginTop:'10px'}}/>
            </>
          : 
            rows.map((row) => {
              return(
                <div className="project-table-content">
                  <ul>
                    <li style={{width : '5%'}}>{1000000 + row.id}</li>
                    <li style={{width : '12%'}}>
                      <img style={{maxWidth:'80%',maxHeight:'30px'}} src={frontEndUrl+(row.image.replace('public','storage'))} alt="" />
                    </li>
                    <li style={{width : '23%',alignItems:'flex-start'}} >
                      <div>
                        <p className="project-table-content-title">{row.project_title}</p>
                        <span className="project-table-content-location">{row.city.title} / {row.county.ilce_title} / {row.neighbourhood?.mahalle_title}</span>
                      </div>
                    </li>
                    <li style={{width : '7%'}}>
                      {row.room_count}
                    </li>
                    <li style={{width : '7%'}}>
                      {row.cartOrders}
                    </li>
                    <li  style={{width : '12%'}}>
                      {row.paymentPending}
                    </li>
                    <li  style={{width : '8%'}}>
                      {row.offSale}
                    </li>
                    <li style={{width : '8%'}}>
                      {row.room_count - (row.cartOrders + row.paymentPending)}
                    </li>
                    <li style={{width : '9%'}}>
                      {row.status == 1 ? (
                        <div className="text-success">Yayında</div>
                      ) : row.status == 2 ? (
                        <div className="text-warning">
                          Onay Bekliyor
                        </div>
                      ) : row.status == 3 ? (
                        <div class="text-danger">Reddedildi</div>
                      ) : (
                        <div class="text-danger">Pasif</div>
                      )}
                    </li>
                    <li style={{width : '5%'}}>
                      <span className="project-table-content-actions-button" onClick={(e) => {handleClick(e,row)}}>
                        <i className="fa fa-chevron-down"></i>
                      </span>
                    </li>
                  </ul>
                </div>
                
              )
            })
        }
      </div>
      <Popover
        id={id}
        open={open}
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
        <ul className="popover-project-actions">
          <li>
            <a href={`https://private.emlaksepette.com/hesabim/projects/${selectedRow?.id}/housings_v2`}>İlanları Düzenle</a>
          </li>
          <li><a href={`https://private.emlaksepette.com/hesabim/projects/${selectedRow?.id}/logs`}>İşlem Kayıtları</a></li>
          <li><a href={`https://private.emlaksepette.com/hesabim/edit_project_v2/${selectedRow?.slug}/${selectedRow?.id}`}>Genel Düzenleme</a></li>
          <li>
            {selectedRow?.status == 2 ? (
              <span className="badge badge-phoenix badge-phoenix-warning">
                Admin Onayının Arından işlem Yapabilirsiniz
              </span>
            ) : selectedRow?.status == 0 ? (
              <span
                onClick={() => {
                  active(selectedRow?.id);
                }}
              >
                Aktife Al
              </span>
            ) : (
              <span
                onClick={() => {
                  deactive(selectedRow?.id);
                }}
              >
                Pasife Al
              </span>
            )}
          </li>
          <li>
            <span onClick={() => { remove(selectedRow.id); }}>
              Sil
            </span>
          </li>
        </ul>
      </Popover>
    </div>
  );
}
export default ReactTable;
