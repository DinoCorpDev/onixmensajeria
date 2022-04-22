<template>
    <div :class="changeActive === true ? 'container content-large': 'container content-short'">
        <div class="card">
            <div class="card-header text-center">
                <h2><strong>Postulaciones</strong></h2>
            </div>
            <div class="card-body">                
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Nombre del Evento</th>
                            <th>Dirección</th>
                            <th>Ciudad</th>                            
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Calendario del Evento</th>
                            <th>Ubicación</th>
                            <th>Tipo de Personal</th>
                            <th>Presupuesto Diario</th>
                            <th>Presupuesto Final</th>
                            <th>Estado</th>
                            <th>Total Asistentes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(postulation, key) in postulations" :key="key">
                            <td>{{postulation.event_name}}</td>
                            <td>
                                <!-- {{postulation.address}} -->
                            </td>
                            
                            <td>{{postulation.city}}</td>                            
                            
                            <td>{{postulation.event_initial_date}}</td>
                            <td>{{postulation.event_end_date}}</td>                            
                            
                            <td>
                                <!-- {{postulation.hourly}} -->
                            </td>
                                                                                    
                            <td>{{postulation.location}}</td>
                            <td>{{postulation.typePersonal}}</td>   
                            <td>{{postulation.dailyBudget}}</td>                         
                            <td>{{postulation.totalBudget}}</td>
                            <td>{{postulation.status}}</td>
                            <td>{{postulation.total_assistants}}</td>
                            
                            
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
                            <input type="text" v-model="postulation.label" required="required" name="label" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="value">Valor</label>
                            <input type="text" v-model="postulation.value" required="required" name="label" class="form-control"/>
                        </div>
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
import { Modal } from 'bootstrap'
export default {
    props:['changeActive'],
    data() {
        return{
            postulations:[],
            postulation:{},
            id: null,
            myModal:'',
        }    
    },
    mounted(){
        this.getPostulations(); 
        this.modal = new Modal(document.getElementById('exampleModal'))       
    },
    methods:{
        getPostulations(){
            axios.get('getPostulations').then((response)=>{
                this.postulations = response.data;
            }).catch((error)=>{
                console.log(error);
            })
        },
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