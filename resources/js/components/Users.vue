<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Users</h3>

                        <div class="card-tools text-right">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addUser">Add User <i class="fa fa-user-plus fa-fw"></i></button>
                        </div>
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
                                <th>Project</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users" :key="user.id" v-if="user.role == 'user'">
                                <td>{{ user.id }}</td>
                                <td>{{ user.first_name }}</td>
                                <td>{{ user.last_name }}</td>
                                <td><span class="tag tag-success">{{ user.email }}</span></td>
                                <td><span class="tag tag-success">{{ user.role }}</span></td>
                                <td>
                                    <a href="#" @click="deleteUser(user.id)">
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
        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUser" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserTitle">Edit User Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add User</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form @submit.prevent="addUser" class="m-2">
                                <div class="form-group">
                                    <label class="form-check-label" for="first_name">First Name</label>
                                    <input v-model="form.first_name" type="text" name="first_name" id="first_name"
                                           placeholder="First Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
                                    <has-error :form="form" field="first_name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label class="form-check-label" for="last_name">Last Name</label>
                                    <input v-model="form.last_name" type="text" name="last_name" id="last_name"
                                           placeholder="Last Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }">
                                    <has-error :form="form" field="last_name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label class="form-check-label" for="email">Email</label>
                                    <input v-model="form.email" type="text" name="email" id="email"
                                           placeholder="Email Address"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                <div class="form-group">
                                    <label class="form-check-label" for="role">Role</label>
                                    <select class="custom-select form-control" :class="{ 'is-invalid': form.errors.has('role') }" v-model="form.role" name="role" id="role">
                                        <option selected>Select User's Role</option>
                                        <option value="user">Normal User</option>
                                        <option value="admin">Admin</option>
                                        <option value="project manager">Project Manager</option>
                                        <option value="developer">Developer</option>
                                    </select>
                                    <has-error :form="form" field="role"></has-error>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 text-right">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-cog fa-fw"></i> Action</button>
                                    </div>
                                </div>
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
                    remember: false
                })
            }
        },
        methods:{
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
            loadUsers(){
                this.$Progress.start();
                axios.get('api/user')
                    .then((response) =>{
                        this.users = response.data;
                    });
                this.$Progress.finish();
            },
            addUser(){
                // Submit the form via a POST request
                this.$Progress.start();
                this.form.post('/api/user')
                    .then(()=>{
                        $('#addUser').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Edited user details successfully'
                        })
                        Fire.$emit('refreshUserList');
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                        Toast.fire({
                            icon: 'warning',
                            title: 'Oops... Something want wrong while adding user.'
                        })
                        this.$Progress.fail();
                    })
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
