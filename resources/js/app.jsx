import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom';
import ReactTable from './Components/reactTable';
import CreateProject from './Components/CreateProject';
import EditProject from './Components/EditProject';

var currentURL = window.location.href;
var slashs = currentURL.split('/');

if(slashs[slashs.length - 1] == "create_project_v3"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<CreateProject />, document.getElementById('react_render_area'));
    }
}else if(slashs[slashs.length - 3] == "edit_project_v3"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<EditProject projectId={slashs[slashs.length - 1]} />, document.getElementById('react_render_area'));
    }
}else{
    if(document.getElementById('react_projects')){
        ReactDOM.render(<ReactTable />, document.getElementById('react_projects'));
    }
}
