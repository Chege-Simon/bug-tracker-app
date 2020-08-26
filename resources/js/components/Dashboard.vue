<template>
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row" v-show="$gate.isAdmin()">
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ users.length }}</h3>

                                        <p>User Registrations</p>
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
                                        <h3>{{ projects.length }}</h3>

                                        <p>Projects</p>
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

                                        <p>Tickets Completed</p>
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
                                        <h3>{{issues.length }}</h3>

                                        <p>All Tickets</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <router-link to="/tickets"
                                        class="small-box-footer">More info
                                        <i
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
                                <!-- Custom tabs (Charts with tabs)-->
                                <div class="card" v-show="!$gate.isDeveloper()">
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
                                                           class="text-dark">{{
                                                            project.id }}
                                                            {{
                                                            project.project_name
                                                            }}
                                                        <i
                                                            class="nav-icon fa fa-arrow-right ml-5 pl-5"
                                                           data-toggle="tooltip"
                                                           title="Send message to project manager"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.card -->

                                <!-- Completed projects -->
                                <div class="card bg-gradient-info">
                                    <div class="card-header border-0">
                                        <h3 class="card-title">
                                            <i class="fas fa-th mr-1"></i>
                                            Closed Projects
                                        </h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
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
                                                <tr v-for="project in projects">
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
                                                }}</span></h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- Conversations are loaded here -->
                                        <div class="direct-chat-messages"
                                             v-for="issue in
                                             theProject.tickets">
                                            <!-- Message. Default to the left -->
                                            <div class="direct-chat-msg">
                                                <div class="direct-chat-infos clearfix">
                                                    <span
                                                        class="direct-chat-name float-left">{{ issue.user_id }}</span>
                                                    <span
                                                        class="direct-chat-timestamp float-right">{{ issue.created_at }}</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <img class="direct-chat-img" src="/images/user.png" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    {{
                                                    issue.ticket_description }}
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->

                                            <!-- Message to the right -->
<!--                                            <div class="direct-chat-msg right">-->
<!--                                                <div class="direct-chat-infos clearfix">-->
<!--                                                    <span class="direct-chat-name float-right">Sarah Bullock</span>-->
<!--                                                    <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>-->
<!--                                                </div>-->
<!--                                                &lt;!&ndash; /.direct-chat-infos &ndash;&gt;-->
<!--                                                <img class="direct-chat-img" src="/images/user.png" alt="message user image">-->
<!--                                                &lt;!&ndash; /.direct-chat-img &ndash;&gt;-->
<!--                                                <div class="direct-chat-text">-->
<!--                                                    You better believe it!-->
<!--                                                </div>-->
<!--                                                &lt;!&ndash; /.direct-chat-text &ndash;&gt;-->
<!--                                            </div>-->
                                            <!-- /.direct-chat-msg -->

                                        </div>
                                        <!-- /.direct-chat-pane -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <form action="#" method="post">
                                            <div class="input-group">
                                                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                                <span class="input-group-append">
                                                <button type="button" class="btn btn-primary">Send</button>
                                            </span>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.card-footer-->
                                </div>
                                <!--/.issues-chat -->
                                <!-- DIRECT CHAT -->
                                <div
                                    class="card direct-chat direct-chat-primary" v-show="!$gate.isUser()">
                                    <div class="card-header">
                                        <h3 class="card-title">Direct Chat</h3>

                                        <div class="card-tools">
                                            <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts"
                                                    data-widget="chat-pane-toggle">
                                                <i class="fas fa-comments"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- Conversations are loaded here -->
                                        <div class="direct-chat-messages">
                                            <!-- Message. Default to the left -->
                                            <div class="direct-chat-msg">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-left">Alexander Pierce</span>
                                                    <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <img class="direct-chat-img" src="/images/user.png" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    Is this template really for free? That's unbelievable!
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->

                                            <!-- Message to the right -->
                                            <div class="direct-chat-msg right">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-right">Sarah Bullock</span>
                                                    <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <img class="direct-chat-img" src="/images/user.png" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    You better believe it!
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->

                                            <!-- Contacts are loaded here -->
                                            <div class="direct-chat-contacts">
                                                <ul class="contacts-list">
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img" src="/images/user.png">

                                                            <div class="contacts-list-info"><span class="contacts-list-name">Count Dracula<small class="contacts-list-date float-right">2/28/2015</small></span>
                                                                <span class="contacts-list-msg">How have you been? I was...</span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                    <li>
                                                        <a href="#">
                                                            <img class="contacts-list-img" src="/images/user.png">

                                                            <div class="contacts-list-info"><span class="contacts-list-name">Sarah Doe<small class="contacts-list-date float-right">2/23/2015</small></span>
                                                                <span class="contacts-list-msg">I will be waiting for...</span>
                                                            </div>
                                                            <!-- /.contacts-list-info -->
                                                        </a>
                                                    </li>
                                                    <!-- End Contact Item -->
                                                </ul>
                                            </div>
                                            <!-- /.direct-chat-pane -->
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <form action="#" method="post">
                                                <div class="input-group">
                                                    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                                    <span class="input-group-append">
                                                <button type="button" class="btn btn-primary">Send</button>
                                            </span>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.card-footer-->
                                    </div>
                                    <!--/.direct-chat -->
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
    export default {
        props: {
            user:{
                type: Object,
                required: true
            }
        },
        data(){
            return{
                theProject:{},
                issues:{},
                tickets:{},
                projects:{},
                users: {},
                me: {},
            }
        },
        methods:{
            viewProject(project_id){
                const Pid = project_id;
                this.$router.push({path:'/projectdetails', query: {
                        Pid }
                })
            },
            toMessage(id){
                this.loadProject(id)
                // console.log(this.theProject);
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
            loadTickets(){
                this.$Progress.start();
                axios.get('api/ticket')
                    .then((response) =>{
                        this.tickets = response.data;
                    });
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
            this.loadIssues();
        }
    }
</script>
