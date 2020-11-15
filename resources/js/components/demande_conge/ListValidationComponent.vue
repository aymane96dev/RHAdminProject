<template>
    <b-card>
        <div class="row">
            <h1 class="col-xl-8">Validation des demandes de congé :</h1>
        </div>
        <div class="row" v-if="error !== '' && Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="danger" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged"  v-for="err in error" v-bind:key="err.value" >
                <span v-for="e in err" v-bind:key="e.value" > {{ e }}</span>
            </b-alert>
        </div>
        <div class="row" v-if="error !== '' && !Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="success" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" >
                la demande a été {{ motcle }} avec succès
            </b-alert>
        </div>
        <div class="row mt-2">
            <div class="table-responsive">
                <div class="table-wrapper table-light">
                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Type de congé </th>
                                <th>Date de début</th>
                                <th>Date de fin</th>
                                <th>Etat de validation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <tr v-for="demande in demandes" v-bind:key="demande.id">
                                <td ><span v-for="conge in conges" v-bind:key="conge.id">{{ (conge.id === demande.conge_id)?conge.type:'' }}</span></td>
                                <td>{{ demande.date_debut }}</td>
                                <td>{{ demande.date_fin }}</td>
                                <td v-if="demande.etat_validation == 'En attente de validation'">En attente de validation</td>
                                <td v-else>{{ demande.etat_validation }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary text-white mb-1" @click="editDemande(demande)" data-toggle="modal" data-target="#validationModal" >valider</a> &nbsp;
                                    <div class="modal fade" id="validationModal" tabindex="-1" role="dialog" aria-labelledby="validationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-lg" id="exampleModalLabel">Validez cette demande</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form @submit.prevent="ValidateForm">
                                                    <div class="form-group row ml-3 mt-5">
                                                        <label class="col-sm-4 col-form-label text-sm" for="type">Etat de validation :</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control form-control-sm" v-model="validate.etat" required>
                                                                <option ref="valselect">Validée</option>
                                                                <option ref="valselect">Non validée</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row ml-3">
                                                        <label class="col-sm-4 col-form-label text-sm" for="date">Solde :</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control form-control-sm" type="number" name="solde" v-model="validate.solde"/>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary">Confirmez</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </b-card>
</template>

<script>
export default {
    name:'list-validation',
    props: ['idprop','conges','demandes'],
    data() {
        return{
            validate:{
                id:'',
                etat:'',
                solde:'',
                conge_id:'',
            },
            demande:{},
            error:'',
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:'',
            etat:'',
        }
    },
    methods: {
        ValidateForm() {
            axios.post(`api/valDemande`,this.validate)
            .then(res=>res.data.data)
            .then(data=>{
                this.$emit('validatedEvent',data)
                this.error = data;
                this.motcle='validé';
                this.showAlert();
                $('#validationModal').modal('toggle');
                this.validate.etat='';
                this.validate.nbrjrs='';
                this.validate.solde='';
            })
        },
        editDemande(d){
            this.validate.conge_id=d.conge_id;
            this.validate.id=d.id;
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert() {
            this.dismissCountDown = this.dismissSecs
        },
    }
}
</script>

<style>

</style>