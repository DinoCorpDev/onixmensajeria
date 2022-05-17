<template>
    <div :class="changeActive === true ? 'container content-large': 'container content-short'">
        <div class="card">
            <div class="card-header text-center">
                <h2><strong>Aptitudes</strong></h2>
            </div>
            <div class="card-body">
                <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear Aptitud</button>
                <table class="table table-striped table-bordered table-response">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Valor</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(competence, key) in competences" :key="key">
                            <td>{{competence.label}}</td>
                            <td>{{competence.value}}</td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" v-on:click="editCompetence(competence)">Editar</button>
                                <button class="btn btn-danger" v-on:click="deleteCompetence(competence.id)">Eliminar</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{id === null ? 'Creación de Aptitud' : 'Actualización de Aptitud'}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="label">Nombre</label>
                            <input type="text" v-model="competence.label" required="required" name="label" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="value">Valor</label>
                            <input type="text" v-model="competence.value" required="required" name="label" class="form-control"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" v-on:click="saveCompetence">Guardar Cambios</button>
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
            competences:[],
            competence:{},
            id: null,
            myModal:'',
        }    
    },
    mounted(){
        this.getCompetences(); 
        this.modal = new Modal(document.getElementById('exampleModal'))       
    },
    methods:{
        getCompetences(){
            axios.get('api/getCompetences').then((response)=>{
                this.competences = response.data;
            }).catch((error)=>{
                console.log(error);
            })
        },

        editCompetence(data){
            this.competence = data;
            this.id = data.id;
        },

        saveCompetence(){
            if(this.id !== null){
                axios.put(`api/competences/${this.id}`,this.competence).then((response)=>{
                    this.cleanData();
                    toastr.success('Aptitud Actualizada');
                    this.getCompetences();                    
                }).catch((error)=>{
                    console.log(error);
                })
            }else{
                axios.post('api/competences',this.competence).then((response)=>{  
                    this.cleanData();
                    toastr.success('Aptitud Creada');                  
                    this.getCompetences();                    
                }).catch((error)=>{
                    console.log(error);
                });
            }
        },

        deleteCompetence(id){
            if(window.confirm('Seguro desea Eliminar este dato?')){
                axios.delete(`api/competences/${id}`).then((response)=>{
                    toastr.success('Aptitud Eliminado');
                    this.getCompetences();
                    this.cleanData();
                }).catch((error)=>{
                    console.log(error);
                })
            }            
        },

        cleanData(){
            this.modal.hide();
            this.competence={},
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