<template>
    <div :class="changeActive === true ? 'container content-large': 'container content-short'">
        <div class="card">
            <div class="card-header text-center">
                <h2><strong>Convocatorias</strong></h2>
            </div>
            <div class="col-md-">
                <button class="btn btn-outline-primary mb-2 mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear Postulación</button>
            </div>            
            <div class="card-body">                
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Nombre del Evento</th>
                            <th>Dirección</th>
                            <th>Ciudad</th>                                                                                    
                            <th>Ubicación</th>                            
                            <th>Total Asistentes</th>                                
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(postulation, key) in postulations" :key="key">
                            <td>{{postulation.event_name}}</td>
                            <td>{{postulation.address.name}}</td>                            
                            <td>{{postulation.city}}</td>                                                                                                                                       
                            <td>{{postulation.location}}</td>                            
                            <td>{{postulation.total_assistants}}</td>  
                            <td>
                                <button class="btn btn-outline-primary">Detalle</button>
                                <button class="btn btn-outline-primary">Editar</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{id === null ? 'Creación de Postulación' : 'Actualización de Postulación'}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">                        
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="label">Id Italentt</label>
                                    <input type="text" v-model="postulation.idItalentt" required="required" name="label" class="form-control"/>
                                </div>                            
                                <div class="form-group">
                                    <label for="value">banner</label>
                                    <input type="file" name="banner" id="banner" class="form-control" v-on:change="(e)=>bannerUpload(e.target.files)">
                                    <!-- <input type="text" v-model="postulation.banner" required="required" name="label" class="form-control"/> -->
                                </div>                            
                                <div class="form-group">
                                    <label for="value">Nombre</label>
                                    <input type="text" v-model="postulation.name" required="required" name="label" class="form-control"/>
                                </div>
                            </div>                                
                        </div>

                        <div class="row mt-5 mb-5">
                            <div class="col">
                                <div class="form-group">
                                    <label for="value">Tipo de Personal</label>
                                    <input type="text" v-model="postulation.aboutPersonal.type" required="required" name="label" class="form-control"/>

                                    <label for="value">Cantidad</label>
                                    <input type="number" v-model="postulation.aboutPersonal.quantity" required="required" name="label" class="form-control"/>

                                    <label for="value">Descripción</label>
                                    <textarea type="text" v-model="postulation.aboutPersonal.description" required="required" name="label" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col">
                                <div class="form-group">
                                    <label for="value">Fecha Inicial</label>
                                    <input type="text" v-model="postulation.initialDate" required="required" name="label" class="form-control"/>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="value">Fecha Final</label>
                                    <input type="text" v-model="postulation.endDate" required="required" name="label" class="form-control"/>
                                </div>
                            </div>
                        </div>      

                        <div class="row mb-5">
                            <div class="col mt-3">
                                <button class="btn btn-success" v-if="postulation.hourly.length < 7" v-on:click="moreDays">+</button>
                                <button class="btn btn-danger" v-on:click="lessDays">-</button>
                            </div>
                            <div class="col">
                                <div class="form-group" v-for="(postHour, key) in postulation.hourly" :key="key">
                                    <label for="value">Dia</label>
                                    <input type="text" v-model="postulation.hourly[key].day" required="required" name="label" class="form-control"/>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group" v-for="(postHour, key) in postulation.hourly" :key="key">
                                    <label for="value">Hora</label>
                                    <input type="text" v-model="postulation.hourly[key].hourly" required="required" name="label" class="form-control"/>
                                </div>
                            </div>
                        </div>                        

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="value">Ciudad</label>
                                    <input type="text" v-model="postulation.city" required="required" name="label" class="form-control"/>
                                </div>
                            
                                <div class="form-group">
                                    <label for="value">Ubicación</label>
                                    <input type="text" v-model="postulation.location" required="required" name="label" class="form-control"/>
                                </div>   
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="value">Dirección</label>
                                    <input type="text" v-model="postulation.address" required="required" name="label" class="form-control"/>
                                </div>                            
                                <div class="form-group">
                                    <label for="value">Presupuesto Total</label>
                                    <input type="text" v-model="postulation.totalBudget" required="required" name="label" class="form-control"/>
                                </div>
                            
                                <div class="form-group">
                                    <label for="value">Presupuesto Diario</label>
                                    <input type="text" v-model="postulation.dailyBudget" required="required" name="label" class="form-control"/>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" v-on:click="savePostulation" data-bs-dismiss="modal">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>       
    </div>
</template>
<script>
import { Modal } from 'bootstrap';
import { getStorage, ref, uploadBytesResumable, getDownloadURL } from "firebase/storage";
export default {
    props:['changeActive'],
    data() {
        return{
            postulations:[],
            postulation:{
                aboutPersonal:{},
                hourly:[{
                    day:"",
                    hourly:""
                }]
            },
            id: null,
            myModal:'',
            fileBanner:null
        }    
    },
    mounted(){
        this.getPostulations(); 
        this.modal = new Modal(document.getElementById('exampleModal'))       
    },
    methods:{
        getPostulations(){
            axios.get('api/getPostulations').then((response)=>{
                this.postulations = response.data;
            }).catch((error)=>{
                console.log(error);
            })
        },
        moreDays(){            
            this.postulation.hourly.push({
                day:"",
                hourly:""
            })
        },
        lessDays(){
            this.postulation.hourly = this.postulation.hourly.slice(0,-1);
        },
        bannerUpload(file){            
            this.fileBanner = file[0];
        },
        savePostulation(){
            const storage = getStorage();            
            const storageRef = ref(storage, `adminDashboard/postulations/${this.fileBanner.name}/`);
            uploadBytesResumable(storageRef, this.fileBanner).then((snapshot) => {                
                getDownloadURL(snapshot.ref).then((url) => {
                    console.log('File available at', url);
                });
            }).catch((error) => {
                console.error('Upload failed', error);                
            });
            console.log(this.postulation)
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