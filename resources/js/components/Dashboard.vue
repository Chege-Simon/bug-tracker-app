<template>
        <div class="row justify-content-center mt-5">
            <div class="col-md-12" >
                <!-- Main content -->
                <section class="content" >
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row" v-show="$gate.isSupreme()">
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ users.length }}</h3>

                                        <p>Users Registered</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <router-link
                                        to="/manageroles"
                                        class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></router-link>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ num_of_open_projects }}</h3>

                                        <p>Projects Registered</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                    <router-link to="/projects"
                                           class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i></router-link>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{tickets.length }}</h3>

                                        <p>Tickets Registered</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <router-link to="/tickets"
                                                 class="small-box-footer">More
                                        info <i
                                            class="fas fa-arrow-circle-right"></i></router-link>
                                </div>
                            </div>

                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>{{ num_of_incomplete_tickets }}</h3>

                                        <p>Incomplete tickets</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <router-link to="/tickets"
                                                 class="small-box-footer">More
                                        info <i
                                            class="fas fa-arrow-circle-right"></i></router-link>
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- /.row -->
                        <!-- Main row -->
                        <div class="row">
                            <!-- Left col -->
                            <section class="col-lg-5 connectedSortable">
                                <div class="card"
                                     v-show="$gate.isSupreme()"style="height: 40%">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            Projects
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content p-0">
                                            <div
                                                style="position: relative;
                                                 height: 275px;">
                                                <ul v-for="project in projects"
                                                    :key="project.id"
                                                    v-if="project.status ==='open'">
                                                    <li @click="toMessage(project.id)">
                                                        <a href="#"
                                                           class="text-dark">
                                                            {{
                                                            project.project_name
                                                            }}
                                                            <i
                                                                class="nav-icon fa fa-arrow-right ml-5 pl-5"
                                                                data-toggle="tooltip"
                                                                title="Send message to project manager"></i></a>
                                                    </li>
                                                    <hr>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="card"
                                     v-show="$gate.isUser() ||
                                     $gate.isProjectmanager() ||
                                     $gate.isAdmin()"style="height:
                                     40%">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            Report Issue
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content p-0">
                                            <div
                                                 style="position: relative;
                                                 height: 275px;">
                                                <ul v-for="person in users" :key="person.id" v-if="person.id === me.id">
                                                    <li v-for="project in
                                                    person.projects"
                                                        :key="project.id" @click="toMessage(project.id)">
                                                        <a href="#"
                                                           class="text-dark">
                                                            {{
                                                            project.project_name
                                                            }}
                                                        <i
                                                            class="nav-icon fa fa-arrow-right ml-5 pl-5"
                                                           data-toggle="tooltip"
                                                           title="Send message to project manager"></i></a>
                                                    </li>
                                                    <hr>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </section>
                            <section class="col-lg-7 connectedSortable">

                                <!-- ISSUES CHAT -->
                                <div
                                    class="card direct-chat direct-chat-primary text-dark" v-show="!$gate.isDeveloper()">
                                    <div class="card-header">
                                        <h3 class="card-title">Issues for
                                            <span style="font-size: 1.2em;
                                            font-weight: bold;">{{
                                                theProject.project_name
                                                }}</span> project</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="max-height:
                                     400px; height: 400px">
                                        <!-- Conversations are loaded here -->
                                        <div class="direct-chat-messages"
                                             style="height:25%"
                                             v-for="issue in issues"
                                             v-if="issue.project_id === theProject_id">
                                            <!-- Message. Default to the left -->
                                            <div class="direct-chat-msg"
                                                 v-if="issue.user.role
                                                 ==='user'">
                                                <div class="direct-chat-infos clearfix">
                                                    <span
                                                        class="direct-chat-name float-left">{{ issue.user.first_name}} {{ issue.user.last_name}} <span class="text-muted"> #{{ issue.user.role }}</span></span>
                                                    <span
                                                        class="direct-chat-timestamp float-right">{{ issue.user.created_at | formatDate }}</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <img class="direct-chat-img" src="/images/user.png" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    {{issue.issue_description }}
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->

                                            <!-- Message to the right -->
                                            <div
                                                class="direct-chat-msg right"
                                                v-else-if="issue.user.role
                                                ==='admin' || issue.user.role
                                                 ==='project_manager' ||
                                                 issue.user.role ==='supreme'">
                                                <div class="direct-chat-infos clearfix">
                                                    <span
                                                        class="direct-chat-name float-right"><span class="text-muted"> #{{ issue.user.role }} </span>{{ issue.user.first_name}} {{ issue.user.last_name}}</span>
                                                    <span
                                                        class="direct-chat-timestamp float-left">{{ issue.created_at | formatDate }}</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <img class="direct-chat-img" src="/images/user.png" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    {{issue.issue_description }}
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->

                                        </div>
                                        <!-- /.direct-chat-pane -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <form @submit.prevent="postIssue(theProject_id, me.id)">
                                            <div class="input-group">
                                                <input v-model="form.issue_description"
                                                       type="text"
                                                       name="issue_description"
                                                       placeholder="Type Message"
                                                       class="form-control"
                                                       :class="{ 'is-invalid':
                                                   form.errors.has('issue_description') }">
                                                <span class="input-group-append">
                                                <button type="submit"
                                                        class="btn btn-primary">Send</button>
                                            </span>
                                                <has-error :form="form"
                                                           field="issue_description"></has-error>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.card-footer-->
                                </div>
                                <!--/.issues-chat -->

                                <!-- Completed projects -->
                                <div class="card bg-gradient-secondary"
                                     v-show="$gate.isSupreme()">
                                    <div class="card-header border-0">
                                        <h3 class="card-title">
                                            <i class="fas fa-th mr-1"></i>
                                            Closed Projects
                                        </h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm" data-card-widget="remove">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div style="position: relative;
                                                 height: 275px;">
                                            <table class="table table-striped table-hover table-sm"
                                                   style="width: 100%;">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th>Project Id</th>
                                                    <th>Project Name</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="project in
                                                projects"
                                                    v-if="project.status ===
                                                    'closed'">
                                                    <td>{{ project.id
                                                        }}</td>
                                                    <td>{{ project.project_name
                                                        }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="card" v-show="$gate.isDeveloper()">
                                    <div class="card-header">
                                        <h3 class="card-title">My
                                            Pending Tickets</h3>

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
                                                <th style="width: 1%">
                                                    #id
                                                </th>
                                                <th style="width: 20%">
                                                    Project Name
                                                </th>
                                                <th style="width: 30%">
                                                    Ticket Description
                                                </th>
                                                <th style="width: 8%" class="text-center">
                                                    Status
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="ticket in tickets" :key="ticket.id"
                                                v-if="ticket.user.id ===
                                                user.id && ticket.status
                                                ==='in_line'">
                                                <td>{{ ticket.id }}</td>
                                                <td>{{ ticket.project.project_name }}</td>
                                                <td>{{ ticket.ticket_description }}</td>
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
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>

                            </section>

                        </div>
                    </div>
                </section>
            </div>
            <!--        <not-found v-if="!$gate.isAdmin()"></not-found>-->
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
        data(){
            return{
                num_of_open_projects:0,
                num_of_incomplete_tickets:0,
                theProject_id:{},
                theProject:{},
                issues:{},
                tickets:{},
                projects:{},
                users: {},
                me: {},
                form: new Form({
                    issue_description:'',
                    project_id:'',
                    user_id:'',
                })
            }
        },
        methods:{
            postIssue(project_id,user_id){
                this.$Progress.start();
                this.form.project_id = project_id;
                this.form.user_id = user_id;
                $('#addUsers').modal('hide');
                axios.post('api/issues/',this.form)
                    .then(() =>{
                        this.form.reset();
                        Toast.fire({
                            icon: 'success',
                            title: 'Issue submitted'
                        })
                    })
                    .catch(()=>{
                        Toast.fire(
                            'Failed!',
                            'Oops... Something want wrong while sending.',
                            'warning'
                        )
                    })
                Fire.$emit('refreshIssues');
                this.$Progress.finish();

            },
            viewProject(project_id){
                const Pid = project_id;
                this.$router.push({path:'/projectdetails', query: {
                        Pid }
                })
            },
            toMessage(id){
                this.theProject_id = id;
                this.loadProject(id);
                this.loadIssues();
            },
            loadProject(id) {
                this.$Progress.start();
                axios.get('api/project/'+id)
                    .then((response) => {
                        this.theProject = response.data;
                    });
                this.$Progress.finish();
            },
            loadIssues(){
                this.$Progress.start();
                axios.get('api/issues')
                    .then((response) =>{
                        this.issues = response.data;
                    });
                this.$Progress.finish();
            },
            calculateTickets(){
                let num = 0;
                this.tickets.map(function(ticket){
                    if(ticket.status === 'in_line' || ticket.status ===
                        'in_progress'){
                        num = num+1;
                    }
                })
                this.num_of_incomplete_tickets = num;
            },
            loadTickets(id){
                this.$Progress.start();
                axios.get('api/ticket')
                    .then((response) =>{
                        this.tickets = response.data;
                        this.calculateTickets(id);
                    });
                this.$Progress.finish();
            },
            calculateProjects(){
                let num = 0;
                this.projects.map(function(project){
                    if(project.status === 'open' ){
                        num = num+1;
                    }
                })
                this.num_of_open_projects = num;
            },
            loadProjects(){
                this.$Progress.start();
                axios.get('api/project')
                    .then((response) =>{
                        this.projects = response.data;
                        this.calculateProjects();
                    });
                this.$Progress.finish();
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
            }
        },
        mounted() {
            this.loadUsers();
            this.loadProjects();
            this.loadTickets();
            Fire.$on('refreshIssues',()=>{
                this.toMessage(this.theProject_id);
                this.loadIssues();
                this.loadTickets();
            })
        }
    }
</script>
