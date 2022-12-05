<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" v-model="formData.password">
                            <p class="text-danger" v-text="errors.password"></p>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" v-model="formData.password_confirmation">
                            <p class="text-danger" v-text="errors.password_confirmation"></p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button @click="changePassword" class="btn btn-primary">Change</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            formData: {
                email: '',
                token: '',
                password: '',
                password_confirmation: '',
            },
            errors: {}
        }
    },
    methods: {
        changePassword(){
            let searchParams = new URLSearchParams(window.location.search);

            this.formData.token = searchParams.get('token');
            this.formData.email = searchParams.get('email');

            axios.post('/api/change-password', this.formData).then((response) => {
                localStorage.setItem('token', response.data)
                alert('Password changed')
                this.$router.push('/login')
            }).catch((errors) => {
                this.errors = errors.response.data.errors
            })
        }
    },
}
</script>
