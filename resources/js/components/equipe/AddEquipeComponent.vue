<template>
    <div class="modal fade" id="addEquipeModal" tabindex="-1" role="dialog" aria-labelledby="addEquipeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-lg" id="addModalLabel">Ajouter une équipe:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="dropdown-divider"></div>
                <div class="modal-body text-dark">
                    <form @submit.prevent="addEquipe">
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="nom">Nom :</label>
                            <div class="col-sm-6">
                                <input class="form-control form-control-sm" type="text" name="nom" id="nom" v-model="equipe.nom" required/>
                            </div>
                        </div>
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="mission">Mission :</label>
                            <div class="col-sm-6">
                                <textarea class="form-control form-control-sm" name="mission" v-model="equipe.mission" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row ml-3 text-sm">
                            <label class="col-sm-4 col-form-label" for="date_naissance">Employés :</label>
                            <small class="text-danger ml-4" v-if="!employes.length">Aucun employé n'est disponible pour une nouvelle équipe.</small>
                        </div>
                        <div class="form-group row ml-5 text-sm">
                            <div class="form-check form-check-inline" v-for="emp in employes" :key="emp.id" >
                                <input class="form-check-input col-2" type="checkbox" :value="emp.id" v-model="equipe.emps">
                                <label class="form-check-label " for="Checkbox">{{ emp.nom+' '+emp.prenom }}</label>
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
    name:'addEquipe',
    data() {
        return{
            equipe:{
                nom:'',
                mission:'',
                emps:[]
            },
            employes:[],
        }
    },
    created() {
        this.getEmployes();
    },
    methods: {
        getEmployes(){
            axios.get('api/getDispEmps')
            .then(res => res.data.data)
            .then(data=>{
                this.employes=data;
            })
            .catch(err=>console.log(err));
        },
        addEquipe(){
            axios.post('api/addEquipe',this.equipe)
            .then(res => res.data)
            .then(data=>{
                this.$emit('addEvent',data);
                this.equipe.nom = '';
                this.equipe.mission = '';
                this.equipe.emps = [];
                this.getEmployes();
            })
            .catch(err=>console.log(err));
            $("#addEquipeModal").modal('toggle');
        }
    }
}
</script>

<style>

</style>