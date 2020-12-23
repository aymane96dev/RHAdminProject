<template>
    <b-card >
        <div class="row">
           <h1 class="col-xl-8">Les soldes de l'employé sélectionné :</h1>
           <div class="col-xl-4 d-xl-flex justify-content-end align-items-start">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addSoldeModal">
                    <i class="fas fa-plus-circle"></i> &nbsp; Ajouter un solde
                </button>
           </div>
        </div>
        <addsolde-component :id="idprop" v-on:addEvent="AddEventHandler($event)"></addsolde-component>
        <editsolde-component :id="idprop" :solde="solde" v-on:editEvent="EditEventHandler($event)"></editsolde-component>
        <div class="row" v-if="error !== '' && Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="danger" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged"  v-for="err in error" v-bind:key="err.value" >
                <span v-for="e in err" v-bind:key="e.value" > {{ e }}</span>
            </b-alert>
        </div>
        <div class="row" v-if="error !== '' && !Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="success" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" >
                le solde a été {{ motcle }} avec succès
            </b-alert>
        </div>
        <div class="row mt-2">
            <div class="table-responsive">
                <div class="table-wrapper table-light">
                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Salaire</th>
                                <th>Date du paiement</th>
                                <th>Type du paiement</th>
                                <th>Mois</th>
                                <th>Année</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <tr v-for="solde in soldes" v-bind:key="solde.id">
                                <td>{{ solde.salaire }}</td>
                                <td>{{ solde.date_paiement }}</td>
                                <td>{{ solde.type_paiement }}</td>
                                <td v-if="solde.mois === 1">Janvier</td>
                                <td v-else-if="solde.mois === 2">Février</td>
                                <td v-else-if="solde.mois === 3">Mars</td>
                                <td v-else-if="solde.mois === 4">Avril</td>
                                <td v-else-if="solde.mois === 5">Mai</td>
                                <td v-else-if="solde.mois === 6">Juin</td>
                                <td v-else-if="solde.mois === 7">Juillet</td>
                                <td v-else-if="solde.mois === 8">Août</td>
                                <td v-else-if="solde.mois === 9">Septembre</td>
                                <td v-else-if="solde.mois === 10">Octobre</td>
                                <td v-else-if="solde.mois === 11">Novembre</td>
                                <td v-else>Décembre</td>
                                <td>{{ solde.année}}</td>
                                <td>
                                    <a class="btn btn-sm btn-warning text-white mb-1" @click="editSolde(solde)" data-toggle="modal" data-target="#editSoldeModal" >modifier &nbsp;<i class="fas fa-edit fa-lg"></i></a> &nbsp;
                                    <a class="btn btn-sm btn-danger text-white" @click="deleteSolde(solde.id)" data-toggle="modal" data-target="#deleteSoldeModal" >supprimer &nbsp;<i class="fas fa-trash fa-lg"></i></a>
                                    <div class="modal fade" id="deleteSoldeModal" tabindex="-1" role="dialog" aria-labelledby="deleteSoldeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-lg" id="exampleModalLabel">Attention!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-lg font-weight-light">
                                                Voulez-vous supprimer ce congé ?
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button @click="deleteS()" type="button" class="btn btn-danger">Confirmez</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulez</button>
                                            </div>
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
    name: 'list-solde',
    props: ['idprop','soldes'],
    data() {
        return {
            employe_id:'',
            solde_id:'',
            delete_id:'',
            solde:{},
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:'',
            error:''
        }
    },
    methods: {
        AddEventHandler(data){
            this.$emit('addEvent',data);
            this.error = data;
            this.motcle = 'ajouté';
            this.showAlert();
        },
        editSolde(solde){
            this.solde = solde;
        },
        deleteSolde(id){
            this.delete_id = id;
        },
        deleteS(){
            axios.delete(`api/deleteSolde/${this.delete_id}`)
            .then(res=>res.data)
            .then(data=>{
                this.$emit('deleteEvent',data);
                this.error = data;
                this.motcle = 'supprimé';
                this.showAlert();
            })
            .catch(err => console.log(err))
            $("#deleteSoldeModal").modal('toggle');
        },
        EditEventHandler(data){
            this.$emit('editEvent',data);
            this.error = data;
            this.motcle = 'modifié';
            this.showAlert();
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert() {
            this.dismissCountDown = this.dismissSecs
        }
    }
}
</script>

<style>

</style>