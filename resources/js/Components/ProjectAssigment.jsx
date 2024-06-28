import * as React from 'react';
import { useState, useEffect } from 'react';
import axios from 'axios';
// MRT Imports
import {
  MaterialReactTable,
} from 'material-react-table';
// Material UI Imports
import {
  Box,
  Button,
  MenuItem,
  Select,
  Dialog,
  DialogActions,
  DialogContent,
  DialogTitle,
  Snackbar,
  CircularProgress,
  List,
  ListItem,
  ListItemText,
  IconButton,
  TextField,
} from '@mui/material';
import AddIcon from '@mui/icons-material/Add';
import DeleteIcon from '@mui/icons-material/Delete';

import '../../css/crm.css';
import { baseUrl } from '../define/variables';

const ProjectAssignment = () => {
  const [users, setUsers] = useState([]);
  const [projects, setProjects] = useState([]);
  const [projectAssignments, setProjectAssignments] = useState([]);
  const [selectedUser, setSelectedUser] = useState(null);
  const [selectedProjects, setSelectedProjects] = useState([]);
  const [openAssignDialog, setOpenAssignDialog] = useState(false);
  const [openViewDialog, setOpenViewDialog] = useState(false);
  const [openAddUserDialog, setOpenAddUserDialog] = useState(false); // State for Add User dialog
  const [newUser, setNewUser] = useState({ name: '', email: '', phone: '', job_title: '' }); // State for new user form
  const [newUserProjects, setNewUserProjects] = useState([]); // State for new user project selection
  const [loading, setLoading] = useState(false);
  const [snackbarOpen, setSnackbarOpen] = useState(false);

  useEffect(() => {
    fetchUsers();
    fetchProjects();
    fetchProjectAssignments();
  }, []);

  const fetchUsers = async () => {
    setLoading(true);
    try {
      const response = await axios.get(baseUrl + 'fetch-users');
      setUsers(response.data.data);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching users:', error);
      setLoading(false);
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
      setLoading(false);
    }
  };

  const fetchProjectAssignments = async () => {
    setLoading(true);
    try {
      const response = await axios.get(baseUrl + 'fetch-project-assigments');
      setProjectAssignments(response.data.data);
      setLoading(false);
    } catch (error) {
      console.error('Error fetching project assignments:', error);
      setLoading(false);
    }
  };

  const handleAssignProjectClick = (user) => {
    setSelectedUser(user);
    setOpenAssignDialog(true);
  };

  const handleViewProjectsClick = (user) => {
    setSelectedUser(user);
    setOpenViewDialog(true);
  };

  const handleSave = async () => {
    setLoading(true);
    try {
      await axios.post(baseUrl + 'project_assignment', {
        userId: selectedUser.id,
        projectIds: selectedProjects,
      });
      setOpenAssignDialog(false);
      setSelectedProjects([]);
      setSnackbarOpen(true);
      setLoading(false);
      fetchProjectAssignments(); // Refresh project assignments after saving
    } catch (error) {
      console.error('Error assigning projects:', error);
      setLoading(false);
    }
  };

  const handleRemoveProject = async (projectId) => {
    setLoading(true);
    try {
      await axios.post(baseUrl + 'remove-project-assignment', {
        userId: selectedUser.id,
        projectId: projectId,
      });
      fetchProjectAssignments(); // Refresh project assignments after removing
      setLoading(false);
    } catch (error) {
      console.error('Error removing project:', error);
      setLoading(false);
    }
  };

  const handleSnackbarClose = () => {
    setSnackbarOpen(false);
  };

  const getAssignedProjects = (userId) => {
    const userAssignments = projectAssignments.filter(
      (assignment) => assignment.user_id === userId
    );
    return userAssignments
      .map((assignment) => {
        const project = projects.find((p) => p.id === assignment.project_id);
        return project ? project : null;
      })
      .filter((project) => project !== null);
  };

  const handleAddUserClick = () => {
    setOpenAddUserDialog(true);
  };

  const handleAddUserSave = async () => {
    setLoading(true);
    try {
      const response = await axios.post(baseUrl + 'add-user', newUser);
      const userId = response.data.data.id;

      if (newUserProjects.length > 0) {
        await axios.post(baseUrl + 'project_assignment', {
          userId: userId,
          projectIds: newUserProjects,
        });
      }

      setOpenAddUserDialog(false);
      setNewUser({ name: '', email: '', phone: '', job_title: '' });
      setNewUserProjects([]);
      setSnackbarOpen(true);
      setLoading(false);
      fetchUsers(); // Refresh users after adding
      fetchProjectAssignments(); // Refresh project assignments after adding
    } catch (error) {
      console.error('Error adding user:', error);
      setLoading(false);
    }
  };

  const columns = [
    {
      header: 'No',
      Cell: ({ row }) => row.index + 1,
      size: 50,
    },
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
      Cell: ({ cell }) => cell.getValue().replace(/^p:/, ''),
    },
    {
      header: 'Atanmış Projeler',
      accessorKey: 'project_name',
    },
    {
      header: 'Atanan Projeler',
      Cell: ({ row }) => {
        const assignedProjects = getAssignedProjects(row.original.id);
        return (
          <>
            {assignedProjects.length > 0 || row.original.project_name ? (
              <Button
                variant="contained"
                color="primary"
                onClick={() => handleViewProjectsClick(row.original)}
              >
                Görüntüle
              </Button>
            ) : (
              '-'
            )}
          </>
        );
      },
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
          <Box display="flex" justifyContent="space-between" mb={2}>
            <Button
              variant="contained"
              color="primary"
              startIcon={<AddIcon />}
              onClick={handleAddUserClick}
            >
              Kullanıcı Ekle
            </Button>
          </Box>
          <MaterialReactTable columns={columns} data={users} />
          <Dialog open={openAssignDialog} onClose={() => setOpenAssignDialog(false)} maxWidth="md" fullWidth>
            <DialogTitle sx={{ backgroundColor: '#1976d2', color: 'white', padding: '16px', textAlign: 'center' }}>Proje Atama</DialogTitle>
            <DialogContent>
              <Select
                sx={{ marginTop: '8px' }}
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
              <Button onClick={() => setOpenAssignDialog(false)}>Kapat</Button>
              <Button onClick={handleSave} color="primary">
                Kaydet
              </Button>
            </DialogActions>
          </Dialog>
          <Dialog open={openViewDialog} onClose={() => setOpenViewDialog(false)} maxWidth="md" fullWidth>
            <DialogTitle sx={{ backgroundColor: '#1976d2', color: 'white', padding: '16px', textAlign: 'center' }}>Atanan Projeler</DialogTitle>
            <DialogContent>

            {/* <List>
                {selectedUser?.project_name?.split(', ').map((projectName, index) => (
                  <ListItem key={index} style={{ backgroundColor: '#f1f1f1', marginBottom: '7px' }}>
                    <ListItemText primary={projectName} />
                    <IconButton edge="end" onClick={() => handleRemoveProject(project.id)}>
                      <DeleteIcon />
                    </IconButton>
                  </ListItem>
                ))}
              </List> */}
              <List>
                {getAssignedProjects(selectedUser?.id).map((project) => (
                  <ListItem key={project.id} style={{ backgroundColor: '#f1f1f1', marginBottom: '7px' }}>
                    <ListItemText primary={project.project_title} />
                    <IconButton edge="end" onClick={() => handleRemoveProject(project.id)}>
                      <DeleteIcon />
                    </IconButton>
                  </ListItem>
                ))}
              </List>
            </DialogContent>
            <DialogActions>
              <Button onClick={() => setOpenViewDialog(false)}>Kapat</Button>
            </DialogActions>
          </Dialog>
          <Dialog open={openAddUserDialog} onClose={() => setOpenAddUserDialog(false)} maxWidth="md" fullWidth>
            <DialogTitle sx={{ backgroundColor: '#1976d2', color: 'white', padding: '16px', textAlign: 'center' }}>Kullanıcı Ekle</DialogTitle>
            <DialogContent>
              <TextField
                margin="dense"
                label="Ad Soyad"
                type="text"
                fullWidth
                value={newUser.name}
                onChange={(e) => setNewUser({ ...newUser, name: e.target.value })}
              />
              <TextField
                margin="dense"
                label="Email"
                type="email"
                fullWidth
                value={newUser.email}
                onChange={(e) => setNewUser({ ...newUser, email: e.target.value })}
              />
              <TextField
                margin="dense"
                label="Telefon"
                type="tel"
                fullWidth
                value={newUser.phone}
                onChange={(e) => setNewUser({ ...newUser, phone: e.target.value })}
              />
              <TextField
                margin="dense"
                label="Meslek"
                type="text"
                fullWidth
                value={newUser.job_title}
                onChange={(e) => setNewUser({ ...newUser, job_title: e.target.value })}
              />
              <Select
                sx={{ marginTop: '7px' }}
                multiple
                value={newUserProjects}
                onChange={(e) => setNewUserProjects(e.target.value)}
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
              <Button onClick={() => setOpenAddUserDialog(false)}>Kapat</Button>
              <Button onClick={handleAddUserSave} color="primary">
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

export default ProjectAssignment;
