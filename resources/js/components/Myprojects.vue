<template>
        <div class="justify-content-center mt-5">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">My Projects</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body  table-responsive p-0">
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
                                        <div class="progress-bar bg-green"
                                             role="progressbar"
                                             aria-volumemin="0"
                                             aria-volumemax="100"
                                             :style="{width: percent + '%'}">
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
                                        <i class="nav-icon fa fa-info"
                                           data-toggle="tooltip"
                                           title="View project details"> Details
                                        </i>
                                    </a>
                                    <a href="#"
                                       v-if="$gate.isAdmin()"
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
    </div>
</template>

<script>
    import {Form} from "vform";

    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                percent:0,
                num_of_incomplete_tickets:0,
                num_of_complete_ticket:0,
                fraction:0,
                selectedUsers: [],
                users: {},
                me: {},
                current_project: '',
                projects: {},
                form: new Form({
                    project_name: '',
                    project_description: '',
                    users: '',
                    project: '',
                    project_manager: '',
                })
            }
        },
        computed:{
        },
        methods: {
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
            viewProject(project_id){
                const Pid = project_id;
                this.$router.push({path:'/projectdetails', query: {
                        Pid }
                })
            },
            loadUsers() {
                this.$Progress.start();
                axios.get('api/user')
                    .then((response) => {
                        this.users = response.data;
                    });
                axios.get('api/user/' + this.user.id)
                    .then((response) => {
                        this.me = response.data;
                    });
            },
            loadProjects(){
                this.$Progress.start();
                axios.get('api/project')
                    .then((response) =>{
                        this.projects = response.data;
                    });
                this.$Progress.finish();
            },
        },
        mounted() {
            this.loadProjects()
            this.loadUsers();
            Fire.$on('refreshProjectList', () => {
                this.loadUsers();
            });
        }
    }
</script>
