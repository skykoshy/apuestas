<template>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h4>Registre un usuario</h4></div>
                <div class="card-body">
                    <form @submit.prevent="registroProcess">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" required class="form-control" v-model="user.nombre">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" required class="form-control" v-model="user.email">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" required class="form-control" v-model="user.password">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Registrar</button>
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
    name:"registro-user",
    data(){
        return {
            user:{
                email:"",
                nombre:"",
                password:"",
            }
        }
    },
    methods:{
        async registroProcess(){
            await this.axios.post('/api/register',this.user).then(response=>{
                localStorage.auth = response.data.success
                localStorage.token = response.data.token
                localStorage.nombre = response.data.user.name
                this.$router.push({name:"players"})
            }).catch(error=>{
                console.log(error)
            })
        }
    }
}
</script>