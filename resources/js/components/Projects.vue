<template>
        <div class="justify-content-center mt-5">
            <section class="content">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Projects</h3>

                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#newProject">New Project <i class="fa fa-briefcase fa-fw"></i></button>
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
                                <th style="width: 1%">
                                    #
                                </th>
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
                                <td>{{ project.id }}</td>
                                <td>{{ project.project_name }}</td>
                                <td class="d-flex flex-row">
                                    <div v-for="user in project.users" :key="user.id">
                                        <div class="p-2">
                                            {{ user.first_name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="project_progress">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-green" role="progressbar" aria-volumenow="57" aria-volumemin="0" aria-volumemax="100" style="width: 57%">
                                        </div>
                                    </div>
                                    <small>
                                        57% Complete
                                    </small>
                                </td>
                                <td class="project-state">
                                    <span class="badge badge-success">Success</span>
                                </td>
                                <td class="text-center">
                                    <a href="#" @click="deleteUser(project.id)">
                                        <i class="fa fa-folder text-primary p-1">View</i>
                                    </a>
                                    <a href="#" @click="deleteUser(project.id)">
                                        <i class="fa fa-pencil-alt text-dark p-1">Edit</i>
                                    </a>
                                    <a href="#" @click="deleteUser(project.id)" v-if="$gate.isAdmin()">
                                        <i class="fa fa-trash text-danger p-1">Delete</i>
                                    </a>
                                    <a href="#" @click="showAddUserModal(project.id, project.project_name)" v-if="$gate.isProjectmanager()">
                                        <i class="fa fa-user-plus text-success p-1">Add Users</i>
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
                                            <label class="form-check-label" for="project_manager">Project Manager</label>
                                            <input v-model="form.project_manager" type="text" name="project_manager" id="project_manager"
                                                   placeholder="Project Manager"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('project_manager') }">
                                            <has-error :form="form" field="project_manager"></has-error>
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
<!--                                            <select class="custom-select form-control"-->
<!--                                                    v-model="selectedUser">-->
<!--                                                <option v-for="user in users" :key="user.id" :value="user.id"-->
<!--                                                        v-if="user.role == 'user' || user.role == 'developer'">-->
<!--                                                    {{ user.first_name }} {{ user.first_name }} &#45;&#45; {{ user.role }}-->
<!--                                                </option>-->
<!--                                            </select>-->
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
            </section>
    </div>
</template>

<script>
    import {Form} from "vform";

    export default {

        data() {
            return  {
                selectedUsers: [],
                users:{},
                current_project:'',
                projects:{},
                form: new Form({
                    project_name: '',
                    project_description: '',
                    users: '',
                    project: '',
                    password: '',
                    remember: false
                })
            }
        },
        methods:{
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
            deleteUser(id){
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
                    this.form.delete('api/user/'+id)
                        .then(()=>{
                            if (result.value) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            }
                            Fire.$emit('refreshUserList');
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
                        Fire.$emit('refreshUserList');
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                        $('#newProject').modal('hide')
                        Toast.fire({
                            icon: 'warning',
                            title: 'Oops... Something want wrong while adding user.'
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
