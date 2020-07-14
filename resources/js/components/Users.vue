<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Project Users</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.first_name }}</td>
                                <td>{{ user.last_name }}</td>
                                <td><span class="tag tag-success">{{ user.email }}</span></td>
                                <td><span class="tag tag-success">{{ user.role }}</span></td>
                                <td>
                                    <a href="#">
                                        <i class="fa fa-edit" data-toggle="modal" data-target="#editUserRole"></i>
                                    </a>
                                        /
                                    <a href="#">
                                        <i class="fa fa-trash text-danger"></i>
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
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editUserRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Change User Role</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form @submit.prevent="editUserRole">
                                <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="role" id="admin" value="admin">
                                                    <label class="form-check-label" for="admin">
                                                        Admin
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="role" id="project_manager" value="project_manager">
                                                    <label class="form-check-label" for="project_manager">
                                                        Project Manager
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="role" id="developer" value="developer">
                                                    <label class="form-check-label" for="developer">
                                                        Developer
                                                    </label>
                                                </div>
                                                <div class="form-check ">
                                                    <input class="form-check-input" type="radio" name="role" id="user" value="user">
                                                    <label class="form-check-label" for="user">
                                                        User
                                                    </label>
                                                </div>
                                                <br>
                                                <div class="offset-md-5 form-group">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-cog"></i> Action</button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {Form} from "vform";

    export default {

        data() {
            return  {
                users:{},
                form: new Form({
                    first_name: '',
                    last_name: '',
                    email: '',
                    role: '',
                    password: '',
                    remember: false
                })
            }
        },
        methods:{
            loadUsers(){
                this.$Progress.start();
                axios.get('api/user')
                    .then((response) =>{
                        this.users = response.data;
                    });
                this.$Progress.finish();
            },
            editUserRole(){
                this.$Progress.start();
                // this.form.post('/api/user');
                Fire.$emit('refreshUserList');
                $('#editUserRole').modal('hide')
                this.$Progress.finish();
            }
        },
        mounted() {
            this.loadUsers();
            Fire.$on('refreshUserList',()=>{
                this.loadUsers();
            });
        }
    }
</script>
