<template>
        <div class="justify-content-center mt-5 row">
            <div class="col-md-6">
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
                                <th style="width: 8%" class="text-center">
                                    Status
                                </th>
                                <th style="width: 20%" class="text-center">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody v-for="person in users"
                                   :key="person.id" v-if="person.id === me.id">
                            <tr v-for="project in person.projects"
                                :key="project.id">
                                <td>{{ project.id }}</td>
                                <td>{{ project.project_name }}</td>
                                <td class="project-state">
                                    <span class="badge badge-success">Success</span>
                                </td>
                                <td class="text-center">
                                    <a href="#" @click="viewProject(project.id)"
                                       class="nav-link">
                                        <i class="nav-icon fa fa-info"
                                           data-toggle="tooltip"
                                           title="View project details">
                                            details
                                        </i>
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
            <div class="col-md-4">
            </div>

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
        methods: {
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
            }
        },
        mounted() {
            this.loadUsers();
            Fire.$on('refreshProjectList', () => {
                this.loadUsers();
            });
        }
    }
</script>
