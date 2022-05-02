<template>
    <div :class="changeActive === true ? 'container content-large': 'container content-short'">
        <div class="card">
            <div class="card-header text-center">
                <h2><strong>Sectores</strong></h2>
            </div>
            <div class="card-body">
                <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear Sector</button>
                <table class="table table-striped table-bordered table-response">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Valor</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(sector, key) in sectors" :key="key">
                            <td>{{sector.label}}</td>
                            <td>{{sector.value}}</td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" v-on:click="editSector(sector)">Editar</button>
                                <button class="btn btn-danger" v-on:click="deleteSector(sector.id)">Eliminar</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{id === null ? 'Creación de Sector' : 'Actualización de Sector'}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="label">Nombre</label>
                            <input type="text" v-model="sector.label" required="required" name="label" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="value">Valor</label>
                            <input type="text" v-model="sector.value" required="required" name="label" class="form-control"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" v-on:click="saveSector">Guardar Cambios</button>
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
            sectors:[],
            sector:{},
            id: null,
            myModal:'',
        }    
    },
    mounted(){
        this.getSectors(); 
        this.modal = new Modal(document.getElementById('exampleModal'))       
    },
    methods:{
        getSectors(){
            axios.get('api/sectors').then((response)=>{
                this.sectors = response.data;
            }).catch((error)=>{
                console.log(error);
            })
        },

        editSector(data){
            this.sector = data;
            this.id = data.id;
        },

        saveSector(){
            if(this.id !== null){
                axios.put(`api/sector/${this.id}`,this.sector).then((response)=>{
                    this.cleanData();
                    toastr.success('Sector Actualizado');
                    this.getSectors();                    
                }).catch((error)=>{
                    console.log(error);
                })
            }else{
                axios.post('api/sector',this.sector).then((response)=>{  
                    this.cleanData();
                    toastr.success('Sector Creado');                  
                    this.getSectors();                    
                }).catch((error)=>{
                    console.log(error);
                });
            }
        },

        deleteSector(id){
            if(window.confirm('Seguro desea Eliminar este dato?')){
                axios.delete(`api/sector/${id}`).then((response)=>{
                    toastr.success('Sector Eliminado');
                    this.getSectors();
                    this.cleanData();
                }).catch((error)=>{
                    console.log(error);
                })
            }            
        },

        cleanData(){
            this.modal.hide();
            this.sector={},
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