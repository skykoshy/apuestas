<template>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h4>Iniciar sesión</h4></div>
                <div class="card-body">
                    <form @submit.prevent="loginProcess">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" required class="form-control" v-model="login.email">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" required class="form-control" v-model="login.password">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Iniciar</button>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"login-user",
    data(){
        return {
            login:{
                email:"",
                password:"",
            }
        }
    },
    methods:{
        async loginProcess(){
            await this.axios.post('/api/auth',this.login).then(response=>{
                localStorage.auth = response.data.success
                localStorage.token = response.data.token
                localStorage.nombre = response.data.nombre
                this.$router.push({name:"mostrarFacturas"})
            }).catch(error=>{
                console.log(error)
            })
        }
    }
}
</script>