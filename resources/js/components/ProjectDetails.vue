<template>
    <div  class="justify-content-center mt-5">
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Projects Detail</h3>
                    <div  class="card-title ml-5 pl-5">
                                    <span class="badge badge-warning"
                                          v-if="project.status === 'closed'">Project is Closed
                                    </span>
                        <span class="badge badge-success"
                              v-else>Project is Open
                                    </span>
                    </div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div
                            class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span
                                                class="info-box-text text-center text-muted">Tickets Issued</span>
                                            <span
                                                class="info-box-number text-center text-muted mb-0">{{ totalTickets }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span
                                                class="info-box-text text-center text-muted">Tickets Completed</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{num_of_complete_tickets}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span
                                                class="info-box-text text-center text-muted">Project Memebers</span>
                                            <span
                                                class="info-box-number text-center text-muted mb-0">{{ num_of_project_members }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h4>Recent Activity</h4>
                                    <div class="post clearfix">
                                        <div class="user-block"
                                             v-for="ticket in recentActivity"
                                             v-if="ticket.status
                                                      ==='complete'">
                                            <div>
                                                <img
                                                    v-for="user in users"v-if="user.id === ticket.user_id"
                                                    class="img-circle img-bordered-sm" :src="getProfilePhoto(user)" alt="user image">
                                                <span class="username"
                                                      v-for="user in users"
                                                      v-if="user.id ===
                                                      ticket.user_id">
                                                    <p
                                                        href="#">{{user.first_name }} {{user.last_name }}</p>
                                                </span>
                                                <span class="description">{{
                                                    ticket.created_at | formatDate
                                                    }}</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <p>
                                                {{ ticket.ticket_description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-sm-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <h3 class="text-primary"><i
                                class="fas fa-paint-brush"></i>{{
                                project.project_name }}</h3>
                            <p class="text-muted">{{ project.project_description }}</p>
                            <br>
                            <div class="text-muted">
                                <p class="text-sm">Client Company
                                    <b class="d-block">{{ project.owner }}</b>
                                </p>
                                <p class="text-sm" v-for="user in users"
                                   v-if="user.id === project.project_manager">Project
                                    Manager
                                    <b class="d-block">{{ user.first_name }}
                                        {{ user.last_name }}</b>
                                </p>
                            </div>

                            <h5 class="mt-5 text-bold">Project files
                                <span class="text-muted">pdf(s)</span></h5>
                            <ul class="list-unstyled" v-for="file in files">
                                <li v-if="file.file_type ==='docx' ||
                                file.file_type ==='doc' || file.file_type
                                ==='odt' || file.file_type ==='txt'">
                                    <a href="" @click="downloadFile(file.id)"
                                       class="btn-link text-secondary"><i
                                        class="fa fa-fw fa-file-word"
                                    ></i>{{file.file}} | Size: {{file.file_size}}bytes
                                    </a><span class="ml-5"><i
                                    class="fa fa-trash text-danger"
                                    @click="deleteFile(file.id)"></i></span>
                                </li>
                                <li v-else-if="file.file_type ==='pdf'">
                                    <a href="" @click="downloadFile(file.id)"
                                       class="btn-link text-secondary"><i
                                        class="fa fa-fw fa-file-pdf"></i>{{file.file}} | Size: {{file.file_size}}bytes</a><span class="ml-5"><i
                                    class="fa fa-trash text-danger"
                                    @click="deleteFile(file.id)"></i></span>
                                </li>
                                <li v-else-if="file.file_type ==='pps' ||
                                file.file_type ==='ppt' || file.file_type
                                ==='pptx' || file.file_type ==='odp' ||
                                file.file_type ==='key'">
                                    <a href="" @click="downloadFile(file.id)"
                                       class="btn-link text-secondary"><i
                                        class="fa fa-fw fa-file-powerpoint"></i>{{file.file}} | Size: {{file.file_size}}bytes</a><span class="ml-5"><i
                                    class="fa fa-trash text-danger"
                                    @click="deleteFile(file.id)"></i></span>
                                </li>
                                <li v-else-if="file.file_type ==='xls' ||
                                file.file_type ==='xlsm' || file.file_type
                                ==='xlsx' || file.file_type ==='ods' ||
                                file.file_type ==='csv'">
                                    <a href="" @click="downloadFile(file.id)"
                                       class="btn-link text-secondary"><i
                                        class="fa fa-fw fa-file-excel"></i>{{file.file}} | Size: {{file.file_size}}bytes</a><span class="ml-5"><i
                                    class="fa fa-trash text-danger"
                                    @click="deleteFile(file.id)"></i></span>
                                </li>
                                <li v-else>
                                    <a href="" @click="downloadFile(file.id)"
                                       class="btn-link text-secondary"><i
                                        class="fa fa-fw fa-file "></i>{{file.file}} | Size: {{file.file_size}}bytes</a><span class="ml-5"><i
                                    class="fa fa-trash text-danger"
                                    @click="deleteFile(file.id)"></i></span>
                                </li>
                            </ul>
                            <div class="text-center mt-5 mb-3">
                                <a href="#"
                                   @click="openAddFileModal(project.id)"
                                   class="btn btn-sm btn-primary"
                                   v-show="$gate.isAdminOrisProjectmanager()">Add files</a>
                                <span v-show="$gate.isAdmin()">
                                    <a href="#"
                                       @click="showUpdateStatusModal(project)"v-if="project.status === 'open'"
                                       class="btn btn-sm btn-warning">Close Project
                                    </a>
                                    <a href="#"
                                       @click="showUpdateStatusModal(project)"v-else
                                       class="btn btn-sm btn-success">Open Project
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!--Update project Status Modal -->
            <div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="newProject" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateStatusTitle">
                                Update Project Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Update {{
                                        project.project_name
                                        }} Project
                                        Status</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form
                                    @submit.prevent="updateStatus(project.id)" class="m-2">
                                    <div class="form-group">
                                        <label
                                            class="form-check-label">Select
                                            Project
                                            Status</label>
                                        <select class="custom-select form-control"
                                                v-model="form.project_status">
                                            <option value="open">open</option>
                                            <option value="closed" >close
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
<!--            addFileModal-->
            <div class="modal fade" id="addFile" tabindex="-1" role="dialog"
                 aria-labelledby="newProject" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addFileTitle">
                                Add File</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Add File for:
                                        {{project.project_name}}</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form @submit="formSubmit" enctype="multipart/form-data">
                                    <strong>File:</strong>
                                    <input type="file" class="form-control"
                                           accept="application/pdf"
                                           v-on:change="onFileChange">

                                    <button class="btn btn-success">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
    import {Form} from "vform";

    export default {
        props: {
        },
        data() {
            return  {
                totalTickets:0,
                num_of_complete_tickets:0,
                num_of_project_members:0,
                files:{},
                recentActivity:[],
                file: '',
                project_id:'',
                selectedUsers: [],
                users:{},
                current_project:'',
                project:'',
                form: new Form({
                    project_name: '',
                    project_description: '',
                    project_status:'',
                    users: '',
                    project_manager: '',
                    belongs_to_project:'',
                    attachment:'',
                })
            }
        },
        methods: {
            getProfilePhoto(user){
                if(user.profile_pic !== undefined) {
                    let photo = "images/profile/"+ user.profile_pic ;
                    return photo;
                }else if(user.profile_pic === undefined || user.profile_pic
                    === null){
                    let photo = "images/user.png" ;
                    return photo;
                }
            },
            downloadFile(id){
                this.$Progress.start();
                axios.get('/api/attachment/'+id)
                    .then(()=>{
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                    })
            },
            deleteFile(id){
                // Submit the form via a POST request
                this.$Progress.start();
                axios.delete('/api/attachment/'+id)
                    .then(()=>{
                        Toast.fire({
                            icon: 'success',
                            title: 'File deleted successfully'
                        })
                        Fire.$emit('fetchProjectDetails');
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
            onFileChange(e){
                this.file = e.target.files[0];
            },
            formSubmit(e) {
                e.preventDefault();
                $('#addFile').modal('hide');
                let currentObj = this;

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                let formData = new FormData();
                formData.append('file', this.file);
                formData.append('posted_for', this.project.id);

                axios.post('/api/attachment/',formData, config)
                    .then(()=>{
                        Toast.fire({
                            icon: 'success',
                            title: 'File added successfully'
                        })
                        Fire.$emit('fetchProjectDetails');
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
            openAddFileModal(project){
                $('#addFile').modal('show');
            },
            showUpdateStatusModal(project){
                $('#updateStatus').modal('show');
                this.form.fill(project);
            },
            updateStatus(id){
                // Submit the form via a POST request
                $('#updateStatus').modal('hide');
                this.$Progress.start();
                this.form.put('/api/project/'+id)
                    .then(()=>{
                        Toast.fire({
                            icon: 'success',
                            title: 'Project Status updated successfully'
                        })
                        Fire.$emit('fetchProjectDetails');
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
            loadProject() {
                this.$Progress.start();
                axios.get('api/project/'+this.project_id)
                    .then((response) => {
                        this.project = response.data;
                        let recentActivity = this.project.tickets;
                        this.recentActivity =
                            recentActivity.slice(recentActivity.length-3);
                        this.calculateProjectMembers();
                        this.calculateTickets();
                this.$Progress.finish();
                })
            },
            calculateProjectMembers(){
                let num = 0;
                this.project.users.map(function(user){
                    num = num+1;
                })
                this.num_of_project_members = num;
            },
            calculateTickets(){
                let num = 0;
                this.project.tickets.map(function(ticket){
                    if(ticket.status === 'complete'){
                        num = num+1;
                    }
                })
                this.num_of_complete_tickets = num;
                this.project.tickets.map(function(ticket){
                    if(ticket.status === ''){
                        num = num+1;
                    }
                })
                this.totalTickets = num;
            },
            loadUsers() {
                this.$Progress.start();
                axios.get('api/user')
                    .then((response) => {
                        this.users = response.data;
                    });
                this.$Progress.finish();
            },
            loadFiles(){
                this.$Progress.start();
                axios.get('api/attachment')
                    .then((response) => {
                        this.files = response.data;
                    });
                this.$Progress.finish();
            },
        },
    mounted() {
        this.project_id = this.$route.query.Pid;
        this.loadProject();
        this.loadUsers();
        this.loadFiles();
        Fire.$on('fetchProjectDetails',()=>{
            this.loadProject();
            this.loadUsers();
            this.loadFiles();
        });
    }
    }
</script>
