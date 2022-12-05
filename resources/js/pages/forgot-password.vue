<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" v-model="formData.email">
                            <p class="text-danger" v-text="errors.email"></p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button @click="login" class="btn btn-primary">Send recovery email</button>
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
            },
            errors: {}
        }
    },
    methods: {
        login(){
            axios.post('api/forgot-password', this.formData).then((response) => {
                localStorage.setItem('token', response.data)
                alert('Email sent')
            }).catch((errors) => {
                this.errors = errors.response.data.errors
            })
        }
    }
}
</script>
