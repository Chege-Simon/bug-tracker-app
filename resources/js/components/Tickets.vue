<template>
        <div class="justify-content-center mt-5">
            <section class="content">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tickets</h3>

                        <div class="card-tools">
                            <button class="btn btn-success"  @click="showSelectProjectModal">New Ticket <i class="fa fa-file fa-fw"></i></button>
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
                                    #id
                                </th>
                                <th style="width: 20%">
                                    Project Name
                                </th>
                                <th style="width: 30%">
                                    Ticket Description
                                </th>
                                <th>
                                    Developer
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
                            <tr v-for="ticket in tickets" :key="ticket.id">
                                <td>{{ ticket.id }}</td>
                                <td>{{ ticket.project.project_name }}</td>
                                <td>{{ ticket.ticket_description }}</td>
                                <td>{{ ticket.user.first_name }} {{ ticket.user.last_name }}</td>
                                <td class="project-state">
                                    <span class="badge badge-success"
                                          v-if="ticket.status === 'complete'">complete
                                    </span>
                                    <span class="badge badge-warning"
                                          v-else-if="ticket.status ===
                                          'in_line'">Waiting List
                                    </span>
                                    <span class="badge badge-primary"
                                          v-else-if="ticket.status ===
                                          'in_progress'">In Progress
                                    </span>
                                </td>
                                <td class="text-center">

                                    <a href='#'@click="">
                                        <i
                                            class="nav-icon fa fa-paperclip text-dark p-1" data-toggle="tooltip" title="View Attachments"></i>
                                    </a>

                                    <a href="#"
                                       @click="deleteTicket(ticket.id)">
                                        <i
                                            class="nav-icon fa fa-trash text-danger p-1" data-toggle="tooltip" title="Delete Ticket"></i>
                                    </a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!--project Modal -->
                <div class="modal fade" id="newTicket" tabindex="-1" role="dialog" aria-labelledby="newTicket" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newTicketTitle">New Ticket</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">New Ticket</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form @submit.prevent="newTicket" class="m-2">
                                        <div class="form-group">
                                            <label class="form-check-label" for="ticket_description">Ticket Description</label>
                                            <input v-model="form.ticket_description" type="text" name="ticket_description" id="ticket_description"
                                                   placeholder="Ticket description"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('ticket_description') }">
                                            <has-error :form="form" field="ticket_description"></has-error>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-check-label" for="project">Select Developer</label>
                                            <select class="custom-select form-control"
                                                    v-model="theDeveloper">
                                                <option v-for="developer in members" :key="developer.id" :value="developer.id" id="developer"
                                                        v-if="developer.role === 'developer'">
                                                    {{ developer.first_name }} {{ developer.last_name }} -- {{ developer.role}}
                                                </option>
                                            </select>
<!--                                            <div v-for="project in projects" :key="project.id" id="project" v-if="project.project_manager === user.id">-->
<!--                                                <input v-model="theProject" type="checkbox" :value="project.id">-->
<!--                                                {{ project.project_name }} {{ project.id }} &#45;&#45; {{ project.project_manager}}-->
<!--                                            </div>-->

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
                <div class="modal fade" id="selectProject" tabindex="-1" role="dialog" aria-labelledby="selectProject" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUsersTitle">Select The Project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Select Project</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form @submit.prevent="selectProject" class="m-2">
                                        <div class="form-group">
                                            <label class="form-check-label" for="project">Select Project</label>
                                            <select class="custom-select form-control"
                                                    v-model="theProject">
                                                <option v-for="project in projects" :key="project.id" :value="project.id" id="project"
                                                        v-if="project.project_manager === user.id || project.created_by === user.id">
                                                    {{ project.project_name
                                                    }}
                                                </option>
                                            </select>
<!--                                            <div v-for="project in projects" :key="project.id" id="project" v-if="project.project_manager === user.id">-->
<!--                                                <input v-model="theProject" type="checkbox" :value="project.id">-->
<!--                                                {{ project.project_name }} {{ project.id }} &#45;&#45; {{ project.project_manager}}-->
<!--                                            </div>-->

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
                tickets:{},
                theDeveloper:'',
                members:[],
                theProject:'',
                users:{},
                current_project:'',
                projects:{},
                form: new Form({
                    ticket_description: '',
                    project_id: '',
                    developer_id: '',
                })
            }
        },
        methods:{
            selectProject(){
                $('#selectProject').modal('hide');
                this.getDevelopers();
                $('#newTicket').modal('show');
            },
            getDevelopers(){
                this.users.forEach(user =>
                    user.projects.forEach(project => {
                        if(project.id == this.theProject){
                            this.members.push(user);
                        }
                    })
                );
            },
            showSelectProjectModal(){
                $('#selectProject').modal('show');
            },
            newTicket(){
                this.$Progress.start();
                $('#newTicket').modal('hide');
                axios.post('api/ticket/',[this.form.ticket_description, this.theProject, this.theDeveloper ])
                    .then(() =>{
                        Toast.fire({
                            icon: 'success',
                            title: 'New ticket created successfully'
                        })
                    });
                this.form.clear();
                Fire.$emit('refreshProjectList');
                this.$Progress.finish();

            },
            deleteTicket(id){
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
                    this.form.delete('api/ticket/'+id)
                        .then(()=>{
                            if (result.value) {
                                Swal.fire(
                                    'Deleted!',
                                    'Ticket deleted successfully.',
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
            loadTickets(){
                this.$Progress.start();
                axios.get('api/ticket')
                    .then((response) =>{
                        this.tickets = response.data;
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
        },
        mounted() {
            this.loadProjects();
            this.loadUsers();
            this.loadTickets();
            Fire.$on('refreshProjectList',()=>{
                this.loadTickets();
            });
        }
    }
</script>
