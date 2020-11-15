<template>
  <div class="modal fade" id="editEquipeModal" tabindex="-1" role="dialog" aria-labelledby="editEquipeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-lg" id="addModalLabel">Modifier une équipe:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="dropdown-divider"></div>
                <div class="modal-body text-dark">
                    <form @submit.prevent="editEquipe">
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="nom">Nom :</label>
                            <div class="col-sm-6">
                                <input class="form-control form-control-sm" type="text" name="nom" v-model="equipe.nom" required/>
                            </div>
                        </div>
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="mission">Mission :</label>
                            <div class="col-sm-6">
                                <textarea class="form-control form-control-sm" name="mission" v-model="equipe.mission" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row ml-3 text-sm">
                            <label class="col-sm-12 col-form-label" for="date_naissance">Employés que vous voulez ajoutés dans l'équipe :</label>
                        </div>
                        <div class="form-group row ml-5 text-sm">
                            <div class="form-check form-check-inline" v-for="emp in DispoEmps" :key="emp.id" >
                                <input class="form-check-input col-2" type="checkbox" :value="emp.id" v-model="addedEmps">
                                <label class="form-check-label " for="addCheckbox">{{ emp.name }}</label>
                            </div>
                        </div>
                        <div class="form-group row ml-3 text-sm">
                            <label class="col-sm-12 col-form-label" for="date_naissance">Employés que vous voulez supprimés de l'équipe:</label>
                            <small class="text-danger ml-4" v-if="!IndispEmps.length">Aucun employé n'est disponible.</small>
                        </div>
                        <div class="form-group row ml-5 text-sm">
                            <div class="form-check form-check-inline" v-for="emp in IndispEmps" :key="emp.id" >
                                <input class="form-check-input col-2" type="checkbox" :value="emp.id" v-model="deletedEmps">
                                <label class="form-check-label " for="delCheckbox">{{ emp.nom+' '+emp.prenom }}</label>
                            </div>
                        </div>
                        <div class="form-group row ml-4">
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
    name:'edit-equipe',
    props:['equipe','DispoEmps','IndispEmps'],
    data() {
        return {
            addedEmps:[],
            deletedEmps:[]
        }
    },
    methods:{
        editEquipe(){
            axios.put('api/editEquipe',{
                'id':this.equipe.id,
                'nom':this.equipe.nom,
                'mission':this.equipe.mission,
                'addedEmps':this.addedEmps,
                'deletedEmps':this.deletedEmps
            })
            .then(res=>res.data)
            .then(data=>{
                this.$emit('editEvent',data);
            })
            .catch(err=>console.log(err));
            $("#editEquipeModal").modal('toggle');
        }
    }
}
</script>

<style>

</style>