import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom';
import CreateProject from './Components/CreateProject';
import EditProject from './Components/EditProject';
import CreateHousing from './Components/CreateHousing';
import ProjectListItem from './Components/project_components/ProjectListItem';
import HousingList from './Components/HousingList';
import Crm from './Components/Crm';
import ProjectAssigment from './Components/ProjectAssigment';
import ReactTable from './Components/reactTable';

var currentURL = window.location.href;
var slashs = currentURL.split('/');

console.log(slashs);

if(slashs[slashs.length - 1] == "proje-ilani-ekle"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<CreateProject />, document.getElementById('react_render_area'));
    }
}else if(slashs[slashs.length - 3] == "edit_project_v3"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<EditProject projectId={slashs[slashs.length - 1]} />, document.getElementById('react_render_area'));
    }
}else if(slashs[slashs.length - 1] == "emlak-ilani-ekle"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<CreateHousing projectId={slashs[slashs.length - 1]} />, document.getElementById('react_render_area'));
    }
}else if(slashs[slashs.length - 1] == "detay" && slashs[3] == "proje"){
    if(document.getElementById('project_list_items')){
        ReactDOM.render(<ProjectListItem projectId={slashs[slashs.length - 1]} />, document.getElementById('project_list_items'));
    }
}else if(slashs[slashs.length - 1] == "housings_v2" && slashs[4] == "pojects"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<HousingList projectId={slashs[slashs.length - 2]} />, document.getElementById('react_render_area'));
    }
}else if(slashs[slashs.length - 1] == "crm"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<Crm projectId={slashs[slashs.length - 2]} />, document.getElementById('react_render_area'));
    }
}else if(slashs[slashs.length - 1] == "project_assigment"){
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<ProjectAssigment projectId={slashs[slashs.length - 2]} />, document.getElementById('react_render_area'));
    }
}
else{
    if(document.getElementById('react_render_area')){
        ReactDOM.render(<ReactTable  />, document.getElementById('react_render_area'));
    }
}
