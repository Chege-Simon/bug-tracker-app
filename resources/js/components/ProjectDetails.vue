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
                                            <span class="info-box-number text-center text-muted mb-0">2300</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span
                                                class="info-box-text text-center text-muted">Tickets Completed</span>
                                            <span class="info-box-number text-center text-muted mb-0">2000</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span
                                                class="info-box-text text-center text-muted">People concerned</span>
                                            <span
                                                class="info-box-number text-center text-muted mb-0">20 </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h4>Recent Activity</h4>
                                    <div class="post clearfix">
                                        <div class="user-block"
                                             v-for="ticket in project.tickets">
                                            <div>
                                                <img
                                                    class="img-circle img-bordered-sm" src="/images/user.png" alt="user image">
                                                <span class="username"
                                                      v-for="user in users"
                                                      v-if="user.id ===
                                                      ticket.user_id">
                                                    <p
                                                        href="#">{{user.first_name }} {{user.last_name }}</p>
                                                </span>
                                                <span class="description">{{
                                                    ticket.created_at }}</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <p>
                                                {{ ticket.ticket_description }}
                                            </p>

                                            <p>
                                                <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a>
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

                            <h5 class="mt-5 text-muted">Project files</h5>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="" class="btn-link text-secondary"><i class="fa fa-fw fa-file-word"></i> Functional-requirements.docx</a>
                                </li>
                                <li>
                                    <a href="" class="btn-link text-secondary"><i class="fa fa-fw fa-file-pdf"></i> UAT.pdf</a>
                                </li>
                                <li>
                                    <a href="" class="btn-link text-secondary"><i class="fa fa-fw fa-envelope"></i> Email-from-flatbal.mln</a>
                                </li>
                                <li>
                                    <a href="" class="btn-link text-secondary"><i class="fa fa-fw fa-image "></i> Logo.png</a>
                                </li>
                                <li>
                                    <a href="" class="btn-link text-secondary"><i class="fa fa-fw fa-file-word"></i> Contract-10_12_2014.docx</a>
                                </li>
                            </ul>
                            <div class="text-center mt-5 mb-3">
                                <a href="#" class="btn btn-sm btn-primary"
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
                })
            }
        },
        methods: {
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
                    });
                this.$Progress.finish();
            },
            loadUsers() {
                this.$Progress.start();
                axios.get('api/user')
                    .then((response) => {
                        this.users = response.data;
                    });
                this.$Progress.finish();
            },
        },
    mounted() {
        this.project_id = this.$route.query.Pid;
        this.loadProject();
        this.loadUsers();
        Fire.$on('fetchProjectDetails',()=>{
            this.loadProject();
            this.loadUsers()
        });
    }
    }
</script>
