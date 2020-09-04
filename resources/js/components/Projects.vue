<template>
        <div class="justify-content-center mt-5">
            <section class="content">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Projects</h3>

                        <div class="card-tools">
                            <button class="btn btn-success"
                                    @click="showNewProjectModal"
                                    v-if="$gate.isAdmin()"> New Project <i class="fa fa-briefcase fa-fw"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th style="width: 20%">
                                    Project Name
                                </th>
                                <th style="width: 30%">
                                    Team Members
                                </th>
                                <th>
                                    Project Progress
                                </th>
                                <th style="width: 8%" class="text-center">
                                    Status
                                </th>
                                <th style="width: 20%" class="text-center">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="project in projects" :key="project.id">
                                <td>{{ project.project_name }}</td>
                                <td class="d-flex flex-row">
                                    <div v-for="user in project.users" :key="user.id">
                                        <div class="p-2">
                                            {{ user.first_name }} {{
                                            user.last_name }},
                                        </div>
                                    </div>
                                </td>
                                <td class="project_progress">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-green" role="progressbar" aria-volumenow="57" aria-volumemin="0" aria-volumemax="100" :style="{width: percent + '%'}">
                                        </div>
                                    </div>
                                    <small>
                                        {{calculateTickets(project)}} % Complete
                                    </small>
                                </td>
                                <td class="project-state">
                                    <span class="badge badge-warning"
                                          v-if="project.status === 'closed'">Closed
                                    </span>
                                    <span class="badge badge-success"
                                          v-else>Open
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="#" @click="viewProject(project.id)"
                                       class="nav-link">
                                        <i class="nav-icon fa fa-info ml-1"
                                           data-toggle="tooltip"
                                           title="View project details">_Details
                                        </i>
                                    </a>
                                    <a href="#"
                                        @click="showEditProjectModal(project)">
                                        <i
                                            class="nav-icon fa fa-pencil-alt text-dark p-1" data-toggle="tooltip" title="Edit the project details"></i>
                                    </a>
                                    <a href="#"
                                       @click="deleteProject(project.id)"
                                       v-if="$gate.isAdmin()">
                                        <i
                                            class="fa fa-trash text-danger p-1" data-toggle="tooltip" title="Delete the project"></i>
                                    </a>
                                    <a href="#" @click="showAddUserModal(project.id, project.project_name)" v-if="$gate.isProjectmanager()">
                                        <i
                                            class="fa fa-user-plus text-success p-1" data-toggle="tooltip" title="Add Users to the projects"></i>
                                    </a>
<!--                                    <button class="btn btn-success" >New Project <i class="fa fa-briefcase fa-fw"></i></button>-->
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!--project Modal -->
                <div class="modal fade" id="newProject" tabindex="-1" role="dialog" aria-labelledby="newProject" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newProjectTitle">New Project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">New Project</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form @submit.prevent="newProject" class="m-2">
                                        <div class="form-group">
                                            <label class="form-check-label"
                                                   for="project_owner">Project
                                                Owner</label>
                                            <input v-model="form.owner"
                                                   type="text"
                                                   name="owner"
                                                   id="project_owner"
                                                   placeholder="Owner"
                                                   class="form-control"
                                                   :class="{ 'is-invalid':
                                                   form.errors.has('owner') }">
                                            <has-error :form="form"
                                                       field="owner"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label" for="project_name">Project Name</label>
                                            <input v-model="form.project_name" type="text" name="project_name" id="project_name"
                                                   placeholder="Project Name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('project_name') }">
                                            <has-error :form="form" field="project_name"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label" for="project_description">Project Description</label>
                                            <input v-model="form.project_description" type="text" name="project_description" id="project_description"
                                                   placeholder="Project Description"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('project_description') }">
                                            <has-error :form="form" field="project_description"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label">Project Manager</label>
                                            <select class="custom-select form-control"
                                                    v-model="form.project_manager">
                                                <option v-for="user in users" :key="user.id" :value="user.id"
                                                        v-if="user.role == 'project_manager'">
                                                    {{ user.first_name }} {{ user.last_name }} -- {{ user.role }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10 text-right">
                                                <button type="submit" class="btn btn-primary"> <i class="fa fa-cog fa-fw"></i> Action</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--User Modal -->
                <div class="modal fade" id="addUsers" tabindex="-1" role="dialog" aria-labelledby="addUsers" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUsersTitle">Add Users to {{current_project}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Users</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form @submit.prevent="addUsers" class="m-2">
                                        <div class="form-group">
                                            <label class="form-check-label" for="users">Select Users</label>
                                            <div v-for="user in users" :key="user.id" id="users">
                                                <input v-model="selectedUsers" type="checkbox" :value="user.id">
                                                {{ user.first_name }} {{ user.last_name }} -- {{ user.role }}
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10 text-right">
                                                <button type="submit" class="btn btn-primary"> <i class="fa fa-cog fa-fw"></i> Action</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Edit project Modal -->
                <div class="modal fade" id="editProject" tabindex="-1"
                     role="dialog" aria-labelledby="newProject" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"
                                    id="editProjectTitle">Edit Project </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit {{
                                            to_be_edited_project.project_name}}
                                            Project</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form
                                        @submit.prevent="editProject(to_be_edited_project.id)"
                                          class="m-2">
                                        <div class="form-group">
                                            <label class="form-check-label"
                                                   for="owner">Project
                                                Owner</label>
                                            <input v-model="form.owner"
                                                   type="text"
                                                   name="owner"
                                                   id="owner"
                                                   placeholder="Owner"
                                                   class="form-control"
                                                   :class="{ 'is-invalid':
                                                   form.errors.has('owner') }">
                                            <has-error :form="form"
                                                       field="owner"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label"
                                                   for="edit_project_name">Project Name</label>
                                            <input
                                                v-model="form.project_name"
                                                type="text"
                                                name="project_name"
                                                id="edit_project_name"
                                                   placeholder="Project Name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('project_name') }">
                                            <has-error :form="form" field="project_name"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label"
                                                   for="edit_project_description">Project Description</label>
                                            <input
                                                v-model="form.project_description" type="text" name="project_description" id="edit_project_description"
                                                   placeholder="Project Description"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('project_description') }">
                                            <has-error :form="form" field="project_description"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label">Project Manager</label>
                                            <select class="custom-select form-control"
                                                    v-model="form.project_manager">
                                                <option v-for="user in users" :key="user.id" :value="user.id"
                                                        v-if="user.role == 'project_manager'">
                                                    {{ user.first_name }} {{ user.last_name }} -- {{ user.role }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10 text-right">
                                                <button type="submit" class="btn btn-primary"> <i class="fa fa-cog fa-fw"></i> Action</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
</template>

<script>
    import {Form} from "vform";

    export default {
        props: {
            user:{
                type: Object,
                required: true
            }
        },
        data() {
            return  {
                percent:0,
                to_be_edited_project:{},
                selectedUsers: [],
                users:{},
                current_project:'',
                projects:{},
                form: new Form({
                    owner:'',
                    project_name: '',
                    project_description: '',
                    users: '',
                    project: '',
                    project_manager: '',
                })
            }
        },
        methods:{
            calculateTickets(project){
                let num = 0;
                project.tickets.map(function(project){
                    if(project.status === 'complete' ){
                        num = num+1;
                    }
                })
                this.num_of_complete_tickets = num;
                // return
                // ((this.num_of_complete_tickets/project.tickets.length)*100).toFixed(4);
                let fraction = (this.num_of_complete_tickets/project.tickets.length)*100
                this.percent = fraction.toFixed(0);
                return fraction.toFixed(0);
            },
            showNewProjectModal(){
                this.form.reset();
                $('#newProject').modal('show');
            },
            showEditProjectModal(project){
                $('#editProject').modal('show');
                this.to_be_edited_project = project;
                this.form.fill(this.to_be_edited_project);
            },
            viewProject(project_id){
                const Pid = project_id;
                this.$router.push({path:'/projectdetails', query: {
                    Pid }
                })
            },
            showAddUserModal(project_id, project_name){
                $('#addUsers').modal('show');
                this.current_project = project_id;
            },
            addUsers(){
                this.$Progress.start();
                $('#addUsers').modal('hide');
                axios.post('api/miscellaneous/',[this.selectedUsers, this.current_project])
                    .then(() =>{
                        Toast.fire({
                            icon: 'success',
                            title: 'Edited user details successfully'
                        })
                    });
                Fire.$emit('refreshProjectList');
                this.$Progress.finish();

            },
            editProject(id){
                // Submit the form via a POST request
                $('#editProject').modal('hide');
                this.$Progress.start();
                this.form.put('/api/project/'+id)
                    .then(()=>{
                        Toast.fire({
                            icon: 'success',
                            title: 'Edited project details successfully'
                        })
                        Fire.$emit('refreshProjectList');
                        this.form.reset();
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                        Toast.fire({
                            icon: 'warning',
                            title: 'Oops...Something went wrong'
                        })
                        this.$Progress.fail();
                    })
            },
            deleteProject(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    //send request to server to delete the user
                    this.form.delete('api/project/'+id)
                        .then(()=>{
                            if (result.value) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            }
                            Fire.$emit('refreshProjectList');
                        })
                        .catch(()=>{
                            Swal.fire(
                                'Failed!',
                                'Oops... Something want wrong while deleting.',
                                'warning'
                            )
                        })
                })
            },
            loadProjects(){
                this.$Progress.start();
                axios.get('api/project')
                    .then((response) =>{
                        this.projects = response.data;
                    });
                this.$Progress.finish();
            },
            loadUsers(){
                this.$Progress.start();
                axios.get('api/user')
                    .then((response) =>{
                        this.users = response.data;
                    });
                this.$Progress.finish();
            },
            newProject(){
                // Submit the form via a POST request
                this.$Progress.start();
                this.form.post('/api/project')
                    .then(()=>{
                        $('#newProject').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Created new project Successfully'
                        })
                        Fire.$emit('refreshProjectList');
                        this.form.reset();
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                        $('#newProject').modal('hide')
                        Toast.fire({
                            icon: 'warning',
                            title:
                                'Oops... Something want wrong while creating new project.'
                        })
                        this.$Progress.fail();
                    })
            }
        },
        mounted() {
            this.loadProjects();
            this.loadUsers();
            Fire.$on('refreshProjectList',()=>{
                this.loadProjects();
            });
        }
    }
</script>
