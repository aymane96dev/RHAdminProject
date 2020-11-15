<template>
  <div class="modal fade modal-open" id="editPtrModal" tabindex="-1" role="dialog" aria-labelledby="editPtrModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg" id="exampleModalLabel">Modifier une pause</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <form @submit.prevent="updatePointer" >
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="date">Date :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="date" name="date" id="date" v-bind:max="datenow" v-model="editptr.date" required/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="debut">Temps <br> de début :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="time" name="debut" id="debut" min="09:00" max="17:59" v-model="editptr.temps_debut" @change="getFinValue()" v-bind:class="{'border border-danger':alert_max}" ref="input_debut" required/>
                        </div>
                        <small class="text-danger offset-4 col-6" v-if="alert_max">le temps doit être supérieur à 9 heure et inférieure à 18 heure </small>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="fin">Temps <br> de fin :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="time" name="fin" id="fin" v-bind:max="max_fin" v-bind:min="editptr.temps_debut" v-model="editptr.temps_fin" @change="showAlertFin()" v-bind:class="{'border border-danger':alert_min}" required/>
                        </div>
                        <small class="text-danger offset-4 col-6" v-if="alert_min"> le temps doit être supérieur à 9 heure et inférieure à 18 heure</small>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="type">Type :</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" name="type" id="type" v-model="editptr.libelle" required>
                                <option value="Pause déjeuner">Pause déjeuner</option>
                                <option value="Pause café">Pause café</option>
                                <option value="Autres">Autres</option>
                            </select>
                        </div> 
                    </div>
                    <div class="form-group form-inline">
                        <label class="col-sm-4 col-form-label col-form-label-sm mr-2" for="employe">Employé :</label>
                        <select class="form-control form-control-sm" name="employe" id="employe" v-model="editptr.fullname" required>
                            <option v-for="emp in employes"  v-bind:key="emp.id" ><option v-bind:value="emp.id" v-if="emp.name !== editptr.name">{{ emp.name }}</option></option>
                        </select>
                    </div>
                    <div class="modal-footer d-flex justify-content-start">
                        <button type="submit" class="btn btn-success">Modifiez</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'',
    props: ['editptr'],
    data(){
        return{
            datenow:new Date().toISOString().substring(0,10),
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
        getFinValue(){
            let values=this.editptr.temps_debut.split(":");
            let num_max= Number(values[0])+1;
            this.max_fin = num_max.toString()+":00";

            let num_min= Number(values[0]);
            this.alert_max = (num_min<9 || num_min>17)?true:false;
            
        },
        showAlertFin(){
            let values_min=this.editptr.temps_fin.split(":");
            let num_min_fin= Number(values_min[0]);
            this.alert_min = (num_min_fin<9 || num_min_fin>17)?true:false;
        },
        getEmployes(){
            axios.get('api/getEmployes')
            .then(res => res.data)
            .then(data=>{
                this.employes=data;
            })
        },
        updatePointer(){
            var id=0;
            this.employes.forEach(emp =>{
            if(emp.name === this.editptr.fullname) id= emp.id;
            });
            axios.put('api/editPtr',{
                'id':this.editptr.id,
                'date':this.editptr.date,
                'tps_debut':this.editptr.temps_debut,
                'tps_fin':this.editptr.temps_fin,
                'type':this.editptr.libelle,
                'id_emp':id
            })
            .then(res => res.data.data)
            .then(data =>{
                this.$emit('EditPtrEvent',data);
            })
            .catch(err => console.log(err));
            $("#editPtrModal").modal('toggle');
        }
    }
}
</script>

<style>
.modal-open {
  overflow-y: auto;
}
</style>