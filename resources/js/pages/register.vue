<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" v-model="formData.name">
                            <p class="text-danger" v-text="errors.name"></p>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" v-model="formData.email">
                            <p class="text-danger" v-text="errors.email"></p>
                        </div>
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
                        <div class="form-group">
                            <label for="password_confirmation">CEP</label>
                            <input type="text" @change="changeCep" v-click-outside="methodToInvoke" class="form-control" name="cep" v-model="formData.cep">
                            <p class="text-danger"  v-text="errors.password_confirmation"></p>
                        </div>
                        <div class="form-group">
                            <label for="name">Rua</label>
                            <input type="text" class="form-control" name="street" v-model="formData.street">
                            <p class="text-danger" v-text="errors.street"></p>
                        </div>
                        <div class="form-group">
                            <label for="name">Bairro</label>
                            <input type="text" class="form-control" name="district" v-model="formData.district">
                            <p class="text-danger" v-text="errors.district"></p>
                        </div>
                        <div class="form-group">
                            <label for="city">Cidade</label>
                            <input type="text" class="form-control" name="city" v-model="formData.city">
                            <p class="text-danger" v-text="errors.district"></p>
                        </div>
                        <div class="form-group">
                            <label for="state">Estado</label>
                            <input type="text" class="form-control" name="state" v-model="formData.state">
                            <p class="text-danger" v-text="errors.district"></p>
                        </div>
                        <div class="form-group">
                            <label for="number">Número</label>
                            <input type="text" class="form-control" name="number" v-model="formData.number">
                            <p class="text-danger" v-text="errors.district"></p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button @click="registerUser" class="btn btn-primary">Register</button>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <router-link to="/login">Already have an account!</router-link>
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
    data() {
        return {
            formData: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                cep: '',
                street: '',
                district: '',
                city: '',
                state: '',
                number: ''
            },
            errors: {}
        }
    },
    methods: {
        registerUser(){
            axios.post('api/register', this.formData).then((response) => {
                console.log(response.data)
                this.formData.name = this.formData.email = this.formData.password = this.formData.password_confirmation = ''
                this.errors = {}
                this.$router.push('/login')
                this.$toaster.success('Account created successfully, now you can login!')
            }).catch((errors) => {
                this.errors = errors.response.data.errors
                console.log(errors.response.data.errors)
            });
        },
        changeCep(){
            if (this.formData.cep.length === 8) {
                axios.get('https://viacep.com.br/ws/'+this.formData.cep+'/json/').then((response) => {
                    this.formData.street = response.data.logradouro;
                    this.formData.district = response.data.bairro;
                    this.formData.city = response.data.localidade;
                    this.formData.state = response.data.uf;
                }).catch((errors) => {
                    console.log(errors)
                });
            }

            if (this.formData.cep.length > 8) {
                this.formData.cep = this.formData.cep.slice(0, 8)
            }

            if (this.formData.cep.length < 8) {
                this.formData.street = this.formData.district = this.formData.city = this.formData.state = ''
            }
        }
    }
}
</script>
