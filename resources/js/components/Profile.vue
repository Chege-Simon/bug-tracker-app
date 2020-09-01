<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Profile Component</div>

                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                            <div class="text-center">
                                                <img class="profile-user-img img-fluid img-circle"
                                                     src="/images/user.png"
                                                     alt="User profile picture">
                                            </div>

                                            <h3 class="profile-username text-center">{{ me.first_name }} {{ me.last_name }}</h3>

                                            <p class="text-muted text-center">{{ me.role }}</p>

                                            <ul class="list-group list-group-unbordered mb-3">
                                                <li class="list-group-item">
                                                    <b>Email</b> <a class="float-right">{{ me.email }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="tab-pane col-md-9" id="settings">
                                    <form @submit.prevent="updateUser(user.id)" >
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input v-model="form.first_name" type="text" name="first_name"
                                                   placeholder="First Name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
                                            <has-error :form="form" field="first_name"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input v-model="form.last_name" type="text" name="last_name"
                                                   placeholder="Last Name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }">
                                            <has-error :form="form" field="last_name"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input v-model="form.email" type="text" name="email"
                                                   placeholder="Email Address"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary"> <i class="fa fa-cog fa-fw"></i> Action</button>
                                            </div>
                                        </div>
                                    </form>
<!--                                    <form-->
<!--                                        @submit.prevent="updateProfile(user.id)">-->
<!--                                        <div class="form-group">-->
<!--                                            <div class="form-group">-->
<!--                                                <label-->
<!--                                                    class="col-sm-12 control-label"-->
<!--                                                    for="profile_pic"-->
<!--                                                >Profile Picture-->
<!--                                                </label>-->
<!--                                                <div class="input-group">-->
<!--                                                    <div class="custom-file">-->
<!--                                                        <input-->
<!--                                                            @change="updateProfilePic"-->
<!--                                                               type="file"-->
<!--                                                               class="form-input"-->
<!--                                                               name="profile_pic"-->
<!--                                                               id="profile_pic">-->
<!--&lt;!&ndash;                                                        <label &ndash;&gt;-->
<!--&lt;!&ndash;                                                            class="custom-file-label" for="profile_pic">Select Pic</label>&ndash;&gt;-->
<!--&lt;!&ndash;                                                    </div>&ndash;&gt;-->
<!--                                                    <div class="input-group-append">-->
<!--                                                        <button type="submit"-->
<!--                                                                class="btn btn-primary">Upload</button>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </form>-->
                                    <hr>
                                    <div class="row">
                                        <p class="col-md-8 text-left">want to change your password?</p>
                                        <div class="col-md-2">
                                            <a class="btn btn-primary" href="/password/reset">
                                                Change Password
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.row -->
                        </div><!-- /.container-fluid -->
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
                me:{},
                profile_pic:'',
                form: new Form({
                    id:'',
                    first_name: '',
                    last_name: '',
                    email: '',
                })
            }
        },
        methods:{
            updateUser(id){
                // Submit the form via a POST request
                this.$Progress.start();
                this.form.put('/api/user/'+id)
                .then(()=>{
                    Toast.fire({
                        icon: 'success',
                        title: 'Edited user details successfully'
                    })
                    Fire.$emit('userInfo');
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
            loadUser(){
                this.$Progress.start();
                axios.get('api/user/'+this.user.id)
                    .then((response) =>{
                        this.me = response.data;
                    });
                this.$Progress.finish();
            },
            // updateProfilePic(e){
            //     let profile_pic = e.target.files[0];
            // },
            // updateProfile(id){
            //     let formData = new FormData();
            //     formData.append('profile_pic',this.profile_pic);
            //     axios.put('/api/user/'+id, formData)
            //         .then(()=>{
            //             Toast.fire({
            //                 icon: 'success',
            //                 title: 'Profile picture updated successfully'
            //             })
            //             Fire.$emit('userInfo');
            //             this.$Progress.finish();
            //         })
            //         .catch(()=>{
            //             Toast.fire({
            //                 icon: 'warning',
            //                 title: 'Oops...Something went wrong'
            //             })
            //             this.$Progress.fail();
            //         })
            // }
        },
        mounted() {
            // this.updateUser(this.user.id);
            // // var ref = this;
            this.loadUser();
            this.form.fill(this.user);
            Fire.$on('userInfo',()=>{
                this.loadUser();
            });
        }
    }
</script>
