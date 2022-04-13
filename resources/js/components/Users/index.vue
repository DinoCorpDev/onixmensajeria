<template>
    <div :class="changeActive === true ? 'container content-large': 'container content-short'">
        <div class="card">
            <div class="card-header text-center">
                <h2><strong>Usuarios</strong></h2>
            </div>
            <div class="card-body">
                <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear Usuario</button>
                <table class="table table-striped table-bordered table-response">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Contacto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, key) in users" :key="key">
                            <td>{{user.name}}</td>
                            <td>{{user.lastname}}</td>
                            <td>{{user.email}}</td>
                            <td>{{user.contact.phone}}</td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" v-on:click="editUser(user)">Editar</button>                                
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
                        <h5 class="modal-title" id="exampleModalLabel">{{id === null ? 'Creación de Usuario': 'Actialización de usuario'}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" v-on:click="cleanData"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" v-model="user.name" id="name">
                        </div>

                        <div class="form-group">
                            <label for="lastname">Apellido</label>
                            <input type="text" class="form-control" v-model="user.lastname" id="lastname">
                        </div>

                        <div class="form-group" v-if="id !== null">
                            <label for="nickname">Nombre Artistico</label>
                            <input type="text" class="form-control" v-model="user.nickname" id="nickname">
                        </div>

                        <div class="form-group">
                            <label for="phone">Numero de Telefono</label>
                            <input type="number" class="form-control" v-model="user.contact.phone" id="phone">
                        </div>

                        <div class="form-group" v-if="id === null">
                            <label for="email">Correo</label>
                            <input type="email" class="form-control" v-model="user.email" id="email">
                        </div>

                        <div class="form-group" v-if="id === null">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" v-model="user.password" id="password">
                        </div>

                        <div class="form-group" v-if="id !== null">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control" v-model="user.address" id="address">
                        </div>

                        <div class="form-group" v-if="id !== null">                            
                            <label for="city">Ciudad</label>
                            <input type="text" class="form-control" v-model="user.city" id="city">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" v-on:click="cleanData">Cerrar</button>
                        <button type="button" class="btn btn-primary" v-on:click="saveUser">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>       
    </div>
</template>
<script>
import { Modal } from 'bootstrap'
export default {
    props:['changeActive'],
    data() {
        return{
            users:[],
            user:{
                contact:{},
                autorization:true,
                terms_conditions:true,
            },
            id:null,
        }    
    },

    mounted(){
        this.getUsers();
        this.modal = new Modal(document.getElementById('exampleModal'));
    },

    methods:{
        getUsers(){
            axios.get('getAllUsers').then(response=>{
                this.users = response.data.data
            })
        },
        editUser(data){
            this.user = data;
            this.id = data.id;
        },
        saveUser(){
            if(this.id === null){
                console.log(this.user);
                axios.post('adminRegisterUser',this.user).then((response)=>{
                    console.log(response.data);
                    toastr.success('Usuario Creado');
                    this.cleanData();
                    this.getUsers();
                }).catch((error)=>{
                    toastr.error('Intenta de nuevo mas Tarde');
                    console.log(error);
                })
            }else{
                console.log(this.user);
                axios.patch(`updateUserInAdmin/${this.id}`,this.user).then((response)=>{
                    console.log(response.data);
                    toastr.success('Usuario Actualizado');
                    this.cleanData();
                    this.getUsers();
                }).catch((error)=>{
                    toastr.error('Intenta de nuevo mas Tarde');
                    console.log(error);
                })
            }            
        },
        cleanData(){
            this.modal.hide();
            this.user = {
                contact:{},
                autorization:true,
                terms_conditions:true,
            };
            this.id = null
        }
    }
}
</script>