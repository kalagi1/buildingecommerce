import * as React from 'react';
import { useMemo } from 'react';
import { useRef, useState, useEffect } from 'react';
import axios from 'axios'; // Ensure axios is imported
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
  TextField,
  Select,
  Snackbar,
  CircularProgress,
} from '@mui/material';
import AddIcon from '@mui/icons-material/Add';

//Icons Imports
import { AccountCircle, Send } from '@mui/icons-material';
import '../../css/crm.css';
import dayGridPlugin from '@fullcalendar/daygrid';
import moment from 'moment';
import { baseUrl } from '../define/variables';

const ProjectAssigment = () => {
  const formatDate = (dateString) => {
    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
  };

  const [users, setUsers] = useState([]);
  const [projects, setProjects] = useState([]);
  const [selectedUser, setSelectedUser] = useState(null);
  const [selectedProjects, setSelectedProjects] = useState([]);
  const [open, setOpen] = useState(false);
  const [loading, setLoading] = useState(false);
  const [snackbarOpen, setSnackbarOpen] = useState(false);

  useEffect(() => {
    fetchUsers();
    fetchProjects();
  }, []);

  const fetchUsers = async () => {
    setLoading(true);
    try {
      const response = await axios.get(baseUrl + 'fetch-users');
      setUsers(response.data.data);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching users:', error);
    }
  };

  const fetchProjects = async () => {
    setLoading(true);
    try {
      const response = await axios.get(baseUrl + 'fetch-projects');
      setProjects(Array.isArray(response.data.data) ? response.data.data : []);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching projects:', error);
    }
  };

  const handleAssignProjectClick = (user) => {
    setSelectedUser(user);
    setOpen(true);
  };

  const handleSave = async () => {
    setLoading(true);
    try {
      await axios.post(baseUrl + 'project_assignment', {
        userId: selectedUser.id,
        projectIds: selectedProjects,
      });
      setOpen(false);
      setSelectedProjects([]);
      setSnackbarOpen(true);
      setLoading(false);
    } catch (error) {
      console.error('Error assigning projects:', error);
    }
  };

  const handleSnackbarClose = () => {
    setSnackbarOpen(false);
  };

  const columns = [
    {
      header: 'Ad Soyad',
      accessorKey: 'name',
    },
    {
      header: 'Email',
      accessorKey: 'email',
    },
    {
      header: 'Telefon',
      accessorKey: 'phone',
    },
    {
      header: 'Proje Atama',
      Cell: ({ row }) => (
        <Button
          variant="contained"
          color="primary"
          onClick={() => handleAssignProjectClick(row.original)}
        >
          Proje Atama
        </Button>
      ),
    },
  ];

  return (
    <>
      {loading ? (
        <div className="loading" style={{ textAlign: 'center' }}>
          <CircularProgress />
        </div>
      ) : (
        <>
          <MaterialReactTable columns={columns} data={users} />
          <Dialog open={open} onClose={() => setOpen(false)} maxWidth="md" fullWidth>
            <DialogTitle>Proje Atama</DialogTitle>
            <DialogContent>
              <Select
                multiple
                value={selectedProjects}
                onChange={(e) => setSelectedProjects(e.target.value)}
                renderValue={(selected) =>
                  selected.length === 0 ? (
                    <em>Proje seçiniz</em>
                  ) : (
                    selected
                      .map((projectId) => {
                        const project = projects.find((p) => p.id === projectId);
                        return project ? project.project_title : projectId;
                      })
                      .join(', ')
                  )
                }
                displayEmpty
                fullWidth
              >
                <MenuItem disabled value="">
                  <em>Proje seçiniz</em>
                </MenuItem>
                {projects.map((project) => (
                  <MenuItem key={project.id} value={project.id}>
                    {project.project_title}
                  </MenuItem>
                ))}
              </Select>
            </DialogContent>
            <DialogActions>
              <Button onClick={() => setOpen(false)}>Kapat</Button>
              <Button onClick={handleSave} color="primary">
                Kaydet
              </Button>
            </DialogActions>
          </Dialog>
          <Snackbar
            open={snackbarOpen}
            autoHideDuration={6000}
            onClose={handleSnackbarClose}
            message="Başarıyla kaydedildi"
            anchorOrigin={{ vertical: 'bottom', horizontal: 'center' }}
          />
        </>
      )}
    </>
  );
};

export default ProjectAssigment;
