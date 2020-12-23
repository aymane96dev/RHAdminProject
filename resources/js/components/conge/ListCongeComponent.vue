<template>
    <b-card >
        <div class="row">
           <h1 class="col-xl-8">Les congés de l'employé sélectionné :</h1>
           <div class="col-xl-4 d-xl-flex justify-content-end align-items-start">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addCongeModal">
                    <i class="fas fa-plus-circle"></i> &nbsp; Ajouter un congé
                </button>
           </div>
           <addconge-component :idprop="idprop" v-on:addcongeevent="addEventHandler($event)"></addconge-component>
           <editconge-component :conge="conge" v-on:editcongeevent="editEventHandler($event)"></editconge-component>
        </div>
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
        <small class="text-danger">N.B: le nombre de jours acquis et le solde seront approuvés par le chef de projet ou l'administrateur.</small>
        <div class="row mt-2">
            <div class="table-responsive">
                <div class="table-wrapper table-light">
                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Type</th>
                                <th>Nombre de jours acquis</th>
                                <th>Solde</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <tr v-for="conge in conges" v-bind:key="conge.id">
                                <td>{{ conge.type }}</td>
                                <td v-if="conge.nbr_jrs_acquis == null">Non validée</td>
                                <td v-else>{{ conge.nbr_jrs_acquis }}</td>
                                <td v-if="conge.solde == null">Non validée</td>
                                <td v-else>{{ conge.solde }}</td> 
                                <td>
                                    <a class="btn btn-sm btn-warning text-white mb-1" @click="editConge(conge)" data-toggle="modal" data-target="#editCongeModal" >modifier &nbsp;<i class="fas fa-edit fa-lg"></i></a> &nbsp;
                                    <a class="btn btn-sm btn-danger text-white" @click="deleteConge(conge.id)" data-toggle="modal" data-target="#deleteCongeModal" >supprimer &nbsp;<i class="fas fa-trash fa-lg"></i></a>
                                    <div class="modal fade" id="deleteCongeModal" tabindex="-1" role="dialog" aria-labelledby="deleteCongeModalLabel" aria-hidden="true">
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
                                                <button @click="deleteC()" type="button" class="btn btn-danger">Confirmez</button>
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
    name:'list-conges',
    props: ['idprop','conges'],
    data() {
        return {
            employe_id:'',
            conge_id:'',
            delete_id:'',
            conge:{},
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:'',
            error:''
        }
    },
    methods: {
        addEventHandler(data){
            this.$emit('addcongevent',data);
            this.error = data;
            this.motcle='ajouté';
            this.showAlert();
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert() {
            this.dismissCountDown = this.dismissSecs
        },
        editConge(conge){
            this.conge=conge;
        },
        deleteConge(id){
            this.delete_id = id;
        },
        deleteC(){
            axios.delete(`api/deleteConge/${this.delete_id}`)
            .then(res => res.data.data)
            .then(data =>{ 
                this.$emit('deleteevent',data);
                this.error = data;
                this.motcle='supprimé';
                this.showAlert();
                $("#deleteCongeModal").modal('toggle');
            })
        },
        editEventHandler(data){
            this.$emit('editcongevent',data);
            this.error = data;
            this.motcle='modifié';
            this.showAlert();
        },
        searchtxt(){

        }
    }
}
</script>

<style>

</style>