<template>
    <b-card >
        <div class="row">
           <h1 class="col-xl-8">Les demandes de congé de l'employé sélectionné {{ idprop }} :</h1>
           <div class="col-xl-4 d-xl-flex justify-content-end align-items-start">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addDemandeModal">
                    <i class="fas fa-plus-circle"></i> &nbsp; Ajouter une demande
                </button>
           </div>
        </div>
        <add-demande-component :idprop="idprop" :conges="conges" v-on:addEvent="addEventHandler($event)"></add-demande-component>
        <editdemande-component :idprop="idprop" :conges="conges" :demande="demande" v-on:editEvent="editEventHandler($event)"></editdemande-component>
       <div class="row" v-if="error !== '' && Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="danger" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged"  v-for="err in error" v-bind:key="err.value" >
                <span v-for="e in err" v-bind:key="e.value" > {{ e }}</span>
            </b-alert>
        </div>
        <div class="row" v-if="error !== '' && !Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="success" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" >
                le congé a été {{ motcle }} avec succès
            </b-alert>
        </div>
        <div class="row mt-2">
            <div class="table-responsive">
                <div class="table-wrapper table-light">
                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Date de début</th>
                                <th>Date de fin</th>
                                <th>Lettre de demande</th>
                                <th>Commentaire</th>
                                <th>Etat de validation</th>
                                <th>Congé concerné</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <tr v-for="demande in demandes" v-bind:key="demande.id">
                                <td>{{ demande.date_debut }}</td>
                                <td>{{ demande.date_fin }}</td>
                                <td v-if="demande.lettre_ecrit == null">aucune lettre est envoyée</td>
                                <td v-else><a :href="'storage/demandes/'+demande.lettre_ecrit" target="_blank">Ouvrir</a></td>
                                <td v-if="demande.commentaire == null">aucun commentaire est envoyé</td>
                                <td v-else>{{ demande.commentaire }}</td>
                                <td>{{ demande.etat_validation }}</td>
                                <td ><span v-for="conge in conges" v-bind:key="conge.id">{{ (conge.id === demande.conge_id)?conge.type:'' }}</span></td>
                                <td>
                                    <a class="btn btn-sm btn-warning text-white mb-1" @click="editDemande(demande)" data-toggle="modal" data-target="#editDemandeModal" >modifier &nbsp;<i class="fas fa-edit fa-lg"></i></a> &nbsp;
                                    <a class="btn btn-sm btn-danger text-white" @click="deleteDemande(demande.id)" data-toggle="modal" data-target="#deleteDemModal" >supprimer &nbsp;<i class="fas fa-trash fa-lg"></i></a>
                                    <div class="modal fade" id="deleteDemModal" tabindex="-1" role="dialog" aria-labelledby="deleteDemModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-lg" id="exampleModalLabel">Attention!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-lg font-weight-light">
                                                Voulez-vous supprimer cette demande ?
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button @click="deleteD()" type="button" class="btn btn-danger">Confirmez</button>
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
    name:'list-demandes',
    props: ['idprop','conges','demandes'],
    data() {
        return {
            employe_id:'',
            conge_id:'',
            delete_id:'',
            demande:{},
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:'',
            error:''
        }
    },
    methods: {
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert() {
            this.dismissCountDown = this.dismissSecs
        },
        searchtxt(){

        },
        addEventHandler(data)
        {
            this.$emit('addEvent',data);
            this.error = data;
            this.motcle='ajouté';
            this.showAlert();
        },
        editDemande(d){
            this.demande = d;
        },
        editEventHandler(data){
            this.$emit('editEvent',data);
            this.error = data;
            this.motcle='modifié';
            this.showAlert();
        },
        deleteDemande(id){
            this.delete_id = id;
        },
        deleteD(){
            axios.delete(`api/deleteDemande/${this.delete_id}`)
            .then(res=>res.data)
            .then(data=>{
                this.$emit('deleteEvent',data);
                this.error = data;
                this.motcle='supprimé';
                this.showAlert();
            })
            .catch(err=>console.log(err));
            $('#deleteDemModal').modal('toggle');
        }
    }
}
</script>

<style>

</style>