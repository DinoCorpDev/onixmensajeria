<template>
    <div :class="changeActive === true ? 'container content-large': 'container content-short'">
        <div class="card">
            <div class="card-header text-center">
                <h2><strong>Usuarios</strong></h2>
            </div>
            <div class="card-body">
                <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear Sector</button>
                <table class="table table-striped table-bordered table-response">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, key) in users" :key="key">
                            <td>{{user.name}}</td>
                            <td>{{user.lastname}}</td>
                            <td>{{user.email}}</td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Editar</button>
                                <button class="btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Creación de Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>       
    </div>
</template>
<script>
export default {
    props:['changeActive'],
    data() {
        return{
            users:[],
        }    
    },

    mounted(){
        this.getUsers();
    },

    methods:{
        getUsers(){
            axios.get('getAllUsers').then(response=>{    
                console.log(response.data.data);            
                this.users = response.data.data
            })
        },
    }
}
</script>