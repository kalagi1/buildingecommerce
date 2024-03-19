import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom';
import ReactTable from './Components/reactTable';
import CreateProject from './Components/CreateProject';
import EditProject from './Components/EditProject';
import CreateHousing from './Components/CreateHousing';
import ProjectListItem from './Components/project_components/ProjectListItem';
import HousingList from './Components/HousingList';

var currentURL = window.location.href;
var slashs = currentURL.split('/');

console.log(slashs,slashs[slashs.length - 1] == "detay" && slashs[3] == "proje" ,slashs[3],slashs[slashs.length - 1]);
if(slashs[slashs.length - 1] == "create_project_v3"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<CreateProject />, document.getElementById('react_render_area'));
    }
}else if(slashs[slashs.length - 3] == "edit_project_v3"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<EditProject projectId={slashs[slashs.length - 1]} />, document.getElementById('react_render_area'));
    }
}else if(slashs[slashs.length - 1] == "create_housing_v3"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<CreateHousing projectId={slashs[slashs.length - 1]} />, document.getElementById('react_render_area'));
    }
}else if(slashs[slashs.length - 1] == "detay" && slashs[3] == "proje"){
    if(document.getElementById('project_list_items')){
        ReactDOM.render(<ProjectListItem projectId={slashs[slashs.length - 1]} />, document.getElementById('project_list_items'));
    }
}else if(slashs[slashs.length - 1] == "housings_v2" && slashs[4] == "projects"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<HousingList projectId={slashs[slashs.length - 2]} />, document.getElementById('react_render_area'));
    }
}else{
    if(document.getElementById('react_projects')){
        ReactDOM.render(<ReactTable />, document.getElementById('react_projects'));
    }
}
