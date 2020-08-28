<template>
    <div class="container" >

        <div class="row justify-content-center mt-5" v-if="$gate.isSupreme()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Users And Their Roles</h3>
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
                                    <a href="#" @click="editModal(user)">
                                        <i class="fa fa-edit"></i>
<!--                                        data-toggle="modal" data-target="#editUserRole"-->
                                    </a>
                                        /
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
        <not-found v-else></not-found>
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
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <form @submit.prevent="editUserRole(user.id)">
                                            <div class="form-group row">
                                                <label class="col-md-4">Admin</label>
                                                <div class="col-md-6">
                                                <input v-model="form.role" type="radio" name="admin" value="admin"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                                                <has-error :form="form" field="role"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4">Project Manager</label>
                                                <div class="col-md-6">
                                                <input v-model="form.role" type="radio" name="project_manager" value="project_manager"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                                                <has-error :form="form" field="role"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4">Developer</label>
                                                <div class="col-md-6">
                                                <input v-model="form.role" type="radio" name="developer" value="developer"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                                                <has-error :form="form" field="role"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4">User</label>
                                                <div class="col-md-6">
                                                <input v-model="form.role" type="radio" name="user" value="user"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                                                <has-error :form="form" field="role"></has-error>
                                                </div>
                                            </div>
                                                <br>
                                                <div class="offset-md-5 form-group">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-cog"></i> Action</button>
                                                </div>
                                <!-- /.card-body -->
                                        </form>

                                    </div>
                                </div>
                            </div>
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
        props: {
            user:{
                type: Object,
                required: true
            }
        },
        data() {
            return  {
                users:{},
                form: new Form({
                    id:'',
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
            editModal(user){
                $('#editUserRole').modal('show')
                this.form.fill(user);
            },
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
            editUserRole(id){
                // Submit the form via a POST request
                this.$Progress.start();
                if(this.form.id != id ){
                    this.form.put('/api/user/'+this.form.id)
                        .then(()=>{
                            Toast.fire({
                                icon: 'success',
                                title: 'Edited user details successfully'
                            })
                            Fire.$emit('refreshUserList');
                            $('#editUserRole').modal('hide')
                            this.$Progress.finish();
                            this.$Progress.finish();
                        })
                        .catch(()=>{
                            Toast.fire({
                                icon: 'warning',
                                title: 'Oops...Something went wrong'
                            })
                            this.$Progress.fail();
                        })
                }else{
                    $('#editUserRole').modal('hide')
                    Toast.fire({
                        icon: 'warning',
                        title: 'You can not edit your own role ask another admin to change your role'
                    })
                    this.$Progress.fail();
                }

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
