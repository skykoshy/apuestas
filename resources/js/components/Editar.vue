<template>
    <div class="row">
        <div v-if="showAlert" class="alert alert-primary" role="alert">
                {{mensaje}}
        </div>
        <span class="text-right">Hola {{nombre}} <a type="button" @click="salir()" class="text-danger"><i class="fas fa-power-off"></i></a></span>
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h4>Actualizar Jugador</h4></div>
                <div class="card-body">
                    <div class="col-12">
                        <form @submit.prevent="actualizar">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" required class="form-control" v-model="player.name">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" required class="form-control" v-model="player.email">
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label>Saldo</label>
                                        <input type="text" required class="form-control" v-model="player.saldo">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <br>
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                </div>
                            </div>                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"editar",
    data(){
        return {
           
            player:{
                id:"",
                name:"",
                email:"",
                saldo: ""
            },
            mensaje:"",
            showAlert:false,
            nombre:localStorage.nombre
            
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        async getData(){
            await this.axios.get(`/api/players/show/${this.$route.params.id}`,{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
                this.player.id = response.data.id
                this.player.name = response.data.name
                this.player.email = response.data.email
                this.player.saldo = response.data.saldo
                
            }).catch(error=>{
                console.log(error)
            })
        },
        async actualizar(){
            await this.axios.patch(`/api/players/update/${this.$route.params.id}`,this.player,{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
               this.getData();
               this.mensaje = response.data.mensaje
               this.showAlert = true;
               setTimeout(() => {this.showAlert = false;}, 2000);
            }).catch(error=>{
                console.log(error)
            })
        },
        salir()
        {
            
            localStorage.removeItem('nombre')
            localStorage.removeItem('token')
            localStorage.auth = false
            this.$router.push({name:"login"})
        }
    }
}
</script>