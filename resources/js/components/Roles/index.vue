<template>
    <div :class="changeActive === true ? 'container content-large': 'container content-short'">
        <div class="card">
            <div class="card-header text-center">
                <h2><strong>Roles</strong></h2>
            </div>
            <div class="card-body">
                <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear rol</button>
                <table class="table table-striped table-bordered table-response">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Valor</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(rol, key) in roles" :key="key">
                            <td>{{rol.label}}</td>
                            <td>{{rol.value}}</td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" v-on:click="editRol(rol)">Editar</button>
                                <button class="btn btn-danger" v-on:click="deleteRol(rol.id)">Eliminar</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{id === null ? 'Creación de Rol' : 'Actualización de Rol'}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="label">Nombre</label>
                            <input type="text" v-model="rol.label" required="required" name="label" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="value">Valor</label>
                            <input type="text" v-model="rol.value" required="required" name="label" class="form-control"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" v-on:click="saveRol">Guardar Cambios</button>
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
            roles:[],
            rol:{},
            id: null,
            myModal:'',
        }    
    },
    mounted(){
        this.getRoles(); 
        this.modal = new Modal(document.getElementById('exampleModal'))       
    },
    methods:{
        getRoles(){
            axios.get('getRoles').then((response)=>{
                this.roles = response.data;
            }).catch((error)=>{
                console.log(error);
            })
        },

        editRol(data){
            this.rol = data;
            this.id = data.id;
        },

        saveRol(){
            if(this.id !== null){
                axios.put(`rol/${this.id}`,this.rol).then((response)=>{
                    this.cleanData();
                    toastr.success('rol Actualizado');
                    this.getRoles();                    
                }).catch((error)=>{
                    console.log(error);
                })
            }else{
                axios.post('rol',this.rol).then((response)=>{  
                    this.cleanData();
                    toastr.success('rol Creado');                  
                    this.getRoles();                    
                }).catch((error)=>{
                    console.log(error);
                });
            }
        },

        deleteRol(id){
            if(window.confirm('Seguro desea Eliminar este dato?')){
                axios.delete(`rol/${id}`).then((response)=>{
                    toastr.success('rol Eliminado');
                    this.getRoles();
                    this.cleanData();
                }).catch((error)=>{
                    console.log(error);
                })
            }            
        },

        cleanData(){
            this.modal.hide();
            this.rol={},
            this.id= null
        }
    }
}
</script>
<style>
.content-large{
    margin-left:118px; 
    transition: 0.5s;
}
.content-short{
    margin-left: 19px; 
    transition: 0.5s;
}
</style>