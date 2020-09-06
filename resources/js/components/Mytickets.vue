<template>
    <div class="justify-content-center mt-5 row">
        <div class="col-md-6">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Pending Tickets</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 20%">
                                Project Name
                            </th>
                            <th style="width: 30%">
                                Ticket Description
                            </th>
                            <th style="width: 8%" class="text-center">
                                Priority
                            </th>
                            <th style="width: 8%" class="text-center">
                                Status
                            </th>
                            <th style="width: 5%" class="text-center">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="ticket in tickets" :key="ticket.id"
                            v-if="ticket.user.id === user.id && ticket.status
                             ==='in_line'">
                            <td>{{ ticket.project.project_name }}</td>
                            <td>{{ ticket.ticket_description }}</td>
                            <td class="project-state">
                                    <span class="badge badge-danger"
                                          v-if="ticket.priority === 'high'">High
                                    </span>
                                <span class="badge badge-warning"
                                      v-else-if="ticket.priority ===
                                          'medium'"> Medium
                                    </span>
                                <span class="badge badge-info"
                                      v-else-if="ticket.priority ===
                                          'low'">Low
                                    </span>
                            </td>
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
<!--                                <a href="#" @click="deleteUser(ticket.id)">-->
<!--                                    <i class="nav-icon fa fa-paperclip"-->
<!--                                    data-toggle="tooltip"-->
<!--                                    title="View attached files"></i>-->
<!--                                </a>-->
                                <a href="#"
                                   @click="showUpdateStatusModal(ticket)">
                                    <i
                                        class="nav-icon fa fa-tasks pl-3 text-success"
                                       data-toggle="tooltip"
                                       title="Update Ticket Status"></i>
                                </a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">

            <div class="card" v-show="$gate.isDeveloper()">
                <div class="card-header">
                    <h3 class="card-title">My Tickets in Progress</h3>

                    <div class="card-tools">
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
                                Ticket Description
                            </th>
                            <th style="width: 8%" class="text-center">
                                Priority
                            </th>
                            <th style="width: 8%" class="text-center">
                                Status
                            </th>
                            <th style="width: 5%" class="text-center">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="ticket in tickets" :key="ticket.id"
                            v-if="ticket.user.id ===
                                                user.id && ticket.status
                                                ==='in_progress'">
                            <td>{{ ticket.project.project_name }}</td>
                            <td>{{ ticket.ticket_description }}</td>
                            <td class="project-state">
                                    <span class="badge badge-danger"
                                          v-if="ticket.priority === 'high'">High
                                    </span>
                                <span class="badge badge-warning"
                                      v-else-if="ticket.priority ===
                                          'medium'"> Medium
                                    </span>
                                <span class="badge badge-info"
                                      v-else-if="ticket.priority ===
                                          'low'">Low
                                    </span>
                            </td>
                            <td class="project-state">
                                                    <span
                                                        class="badge badge-success"
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
<!--                                <a href="#" @click="deleteUser(ticket.id)">-->
<!--                                    <i class="nav-icon fa fa-paperclip"-->
<!--                                       data-toggle="tooltip"-->
<!--                                       title="View attached files"></i>-->
<!--                                </a>-->
                                <a href="#"
                                   @click="showUpdateStatusModal(ticket)">
                                    <i class="nav-icon fa fa-tasks pl-3 text-success"
                                       data-toggle="tooltip"
                                       title="Update Ticket Status"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-8">

            <div class="card" v-show="$gate.isDeveloper()">
                <div class="card-header">
                    <h3 class="card-title">My Completed Tickets</h3>

                    <div class="card-tools">
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
                                Ticket Description
                            </th>
                            <th style="width: 8%" class="text-center">
                                Priority
                            </th>
                            <th style="width: 8%" class="text-center">
                                Status
                            </th>
<!--                            <th style="width: 5%" class="text-center">-->
<!--                                Actions-->
<!--                            </th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="ticket in tickets" :key="ticket.id"
                            v-if="ticket.user.id ===
                                                user.id && ticket.status
                                                ==='complete'">
                            <td>{{ ticket.project.project_name }}</td>
                            <td>{{ ticket.ticket_description }}</td>
                            <td class="project-state">
                                    <span class="badge badge-danger"
                                          v-if="ticket.priority === 'high'">High
                                    </span>
                                <span class="badge badge-warning"
                                      v-else-if="ticket.priority ===
                                          'medium'"> Medium
                                    </span>
                                <span class="badge badge-info"
                                      v-else-if="ticket.priority ===
                                          'low'">Low
                                    </span>
                            </td>
                            <td class="project-state">
                                                    <span
                                                        class="badge badge-success"
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
<!--                            <td class="text-center">-->
<!--                                <a href="#" @click="deleteUser(ticket.id)">-->
<!--                                    <i class="nav-icon fa fa-paperclip"-->
<!--                                       data-toggle="tooltip"-->
<!--                                       title="View attached files"></i>-->
<!--                                </a>-->
<!--                            </td>-->
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!--Update ticket Status Modal -->
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
                                <h3 class="card-title">Update ticket
                                    Status</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form
                                @submit.prevent="updateStatus(to_be_edited_ticket.id)"
                                class="m-2">
                                <div class="form-group">
                                    <label
                                        class="form-check-label">Select
                                        Project
                                        Status</label>
                                    <select class="custom-select form-control"
                                            v-model="form.ticket_status">
                                        <option value="in_progress"
                                                class="bg-gradient-primary p-3">In
                                            Progress
                                        </option>
                                        <option value="complete"
                                                class="bg-gradient-success p-3">
                                            Complete</option>
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
                to_be_edited_ticket:{},
                tickets:{},
                theDeveloper:'',
                members:[],
                theProject:'',
                users:{},
                current_project:'',
                projects:{},
                form: new Form({
                    ticket_status:'',
                    ticket_description: '',
                    project_id: '',
                    developer_id: '',
                })
            }
        },
        methods:{
            showUpdateStatusModal(ticket){
                $('#updateStatus').modal('show');
                this.to_be_edited_ticket = ticket;
                this.form.fill(ticket);
            },
            updateStatus(id){
                // Submit the form via a POST request
                $('#updateStatus').modal('hide');
                this.$Progress.start();
                this.form.put('/api/ticket/'+id)
                    .then(()=>{
                        Toast.fire({
                            icon: 'success',
                            title: 'Ticket Status updated successfully'
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
                            title: 'Edited user details successfully'
                        })
                    });
                this.form.clear();
                Fire.$emit('refreshProjectList');
                this.$Progress.finish();

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
