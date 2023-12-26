<template>
    <div class="row">
        <div class="col-12 mb-2">
            <!-- llamamos al componente para Crear   -->
            <span class="text-right">Hola {{nombre}} APUESTA: {{color}} <a type="button" @click="salir()" class="text-danger"><i class="fas fa-power-off"></i></a></span>
        </div>
        <div class="col-12">             
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Jugador</th>
                            <th>Email</th>
                            <th>Apuesta</th>
                            <th>Saldo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="player in players" :key="player.id">
                            <td>{{ player.name }}</td>
                            <td>{{ player.email }}</td>
                            <td>{{ player.apuesta }}</td>
                            <td>{{ player.saldo }}</td>
                            <td>
                                <!-- llamamos al componente para Editar     -->
                                <router-link :to='{name:"editar",params:{id:player.id}}' class="btn btn-info"><i class="fas fa-edit"></i></router-link>
                                <a type="button" @click="borrarPlayer(player.id)" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>                          
        </div>
    </div>
</template>

<script>
//Bootstrap and jQuery libraries
import 'jquery/dist/jquery.min.js';
//Datatable Modules
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import $ from 'jquery'; 
export default {
    name:"players",
    data(){
        return {
            players:[],
            color:"",
            nombre:localStorage.nombre
        }
    },
    mounted(){
        
        this.getPlayers(),
        this.sorteo()
        
    },
    methods:{
        async getPlayers(){
            await this.axios.get('/api/players',{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
                this.players = response.data
                setTimeout(() => {
                    $("#datatable").DataTable({
                        lengthMenu: [
                        [5,10, 25, 50, -1],
                        [5,10, 25, 50, "All"],
                        ],
                        pageLength: 5,
                    });
                });
                
            }).catch(error=>{
                console.log(error)
                this.players = []
            })
        },
        borrarPlayer(id){
            if(confirm("¿Confirma eliminar el registro?")){
                this.axios.get(`/api/players/delete/${id}`,{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
                    this.getPlayers()
                }).catch(error=>{
                    console.log(error)
                })
            }
        },
        salir()
        {
            
            localStorage.removeItem('nombre')
            localStorage.removeItem('token')
            localStorage.auth = false
            this.$router.push({name:"login"})
        },
        async sorteo(){
            await this.axios.get('/api/players/sorteo',{headers:{'Authorization': `token ${localStorage.token}`}}).then(response=>{
                this.players = response.data.players
                this.color = response.data.color
                this.getPlayers()
                
                
            }).catch(error=>{
                console.log(error)
                this.players = []
            })
        }
    }
}
</script>