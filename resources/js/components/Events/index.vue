<template>
    <div :class="changeActive === true ? 'container content-large': 'container content-short'">
        <div class="card">
            <div class="card-header text-center">
                <h2><strong>Convocatorias</strong></h2>
            </div>
            <div class="card-body">                
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th></th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(application, key) in applications" :key="key">
                            <td>{{application.event_name}}</td>
                            
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
                        <div class="form-group">
                            <label for="label">Nombre</label>
                            <input type="text" v-model="application.label" required="required" name="label" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="value">Valor</label>
                            <input type="text" v-model="application.value" required="required" name="label" class="form-control"/>
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
export default {
    props:['changeActive'],
    data() {
        return{
            applications:[],
            application:{},
            id:null,
        }    
    },
    mounted() {

    },
    methods:{
        getApplications(){

        },
        editApplication(data){
            this.application = data;
            this.id = data.id;
        },
        saveApplication(){
            if(this.id === null){
                axios.post('events',this.application).then((response)=>{
                    toastr.success(response.data.statusText);
                    console.log(response.data)
                }).catch((error)=>{
                    console.log(error);
                    toastr.error('Intenta de nuevo mas tarde');
                });
            }else{
                axios.put(`events/${this.id}`,this.application).then((response)=>{
                    toastr.success(response.data.statusText);
                    console.log(response.data)
                }).catch((error)=>{
                    console.log(error);
                    toastr.error('Intenta de nuevo mas tarde');
                });
            }
        },
        deleteApplication(id){
            if(window.confirm('Seguro desea Eliminar este dato?')){
                axios.delete(`events/${id}`).then((response)=>{
                    toastr.success(response.data.statusText);
                }).catch((error)=>{
                    toastr.error('Intenta de nuevo mas tarde');
                    console.log(error)
                })
            }
        }
    }
}
</script>