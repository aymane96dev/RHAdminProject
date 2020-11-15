<template>
    <div class="modal fade" id="addPtrModal" tabindex="-1" role="dialog" aria-labelledby="addPtrModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg" id="exampleModalLabel">Ajouter une pause</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <form @submit.prevent="addPointer" >
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="date">Date :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="date" name="date" id="date" v-bind:max="datenow" v-model="pointer.date" required/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="debut">Temps de début :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="time" name="debut" id="debut" min="09:00" max="17:59" v-model="pointer.tps_debut" @change="getFinValue()" v-bind:class="{'border border-danger':alert_max}" ref="input_debut" required/>
                        </div>
                        <small class="text-danger offset-4 col-6" v-if="alert_max">le temps doit être supérieur à 9 heure et inférieure à 18 heure </small>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="fin">Temps de fin :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="time" name="fin" id="fin" v-bind:max="max_fin" v-bind:min="pointer.tps_debut" v-model="pointer.tps_fin" @change="showAlertFin()" v-bind:class="{'border border-danger':alert_min}" required/>
                        </div>
                        <small class="text-danger offset-4 col-6" v-if="alert_min"> le temps doit être supérieur à 9 heure et inférieure à 18 heure</small>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="type">Type :</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" name="type" id="type" v-model="pointer.type" required>
                                <option value="Pause déjeuner">Pause déjeuner</option>
                                <option value="Pause café">Pause café</option>
                                <option value="Autres">Autres</option>
                            </select>
                        </div> 
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="employe">Employé :</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" name="employe" id="employe" v-model="pointer.id_emp" required>
                                <option v-for="emp in employes" v-bind:key="emp.id" v-bind:value="emp.id">{{ emp.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary">Enregistrez</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'addptr-cpmt',
    data() {
        return{
            datenow:new Date().toISOString().substring(0,10),
            pointer:{
                date:'',
                tps_debut:'',
                tps_fin:'',
                type:'',
                id_emp:''
            },
            max_fin:'',
            alert_max:'',
            alert_min:'',
            employes:[],
        }
    },
    created() {
        this.getEmployes();
    },
    methods: {
        addPointer(){
            axios.post('api/addPtr',{
                'date':this.pointer.date,
                'tps_debut':this.pointer.tps_debut,
                'tps_fin':this.pointer.tps_fin,
                'type':this.pointer.type,
                'id_emp':this.pointer.id_emp
            })
            .then(res => res.data.data )
            .then(data =>{
                this.$emit('AddPtrEvent',data);
                this.pointer.date = '';
                this.pointer.tps_debut = '',
                this.pointer.tps_fin = '',
                this.pointer.type = '',
                this.pointer.id_emp = ''
            })
            .catch(err => console.log(err));
            $("#addPtrModal").modal('toggle');
        },
        getFinValue(){
            let values=this.pointer.tps_debut.split(":");
            let num_max= Number(values[0])+1;
            this.max_fin = num_max.toString()+":00";

            let num_min= Number(values[0]);
            this.alert_max = (num_min<9 || num_min>17)?true:false;
            
        },
        showAlertFin(){
            let values_min=this.pointer.tps_fin.split(":");
            let num_min_fin= Number(values_min[0]);
            this.alert_min = (num_min_fin<9 || num_min_fin>17)?true:false;
        },
        getEmployes(){
            axios.get('api/getEmployes')
            .then(res => res.data)
            .then(data=>{
                this.employes=data;
            })
        }
    }
}
</script>

<style>

</style>