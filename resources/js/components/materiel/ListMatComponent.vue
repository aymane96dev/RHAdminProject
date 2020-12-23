<template>
    <b-card >
        <div class="row">
           <h1 class="col-xl-8">Les matériaux de l'employé sélectionné :</h1>
           <div class="col-xl-4 d-xl-flex justify-content-end align-items-start">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addMaterielModal">
                    <i class="fas fa-plus-circle"></i> &nbsp; Ajouter un matériel
                </button>
           </div>
           <addmateriel-component :id="idprop" v-on:AddMatEvent="addEventHandler($event)"></addmateriel-component>
           <editmateriel-component :id="idprop" :materiel="materiel" v-on:editMatEvent="editEventHandler($event)"></editmateriel-component>
        </div>
        <div class="row" v-if="error !== '' && Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="danger" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged"  v-for="err in error" v-bind:key="err.value" >
                <span v-for="e in err" v-bind:key="e.value" > {{ e }}</span>
            </b-alert>
        </div>
        <div class="row" v-if="error !== '' && !Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="success" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" >
                le matériel a été {{ motcle }} avec succès
            </b-alert>
        </div>
        <div class="row mt-2">
            <div class="table-responsive">
                <div class="table-wrapper table-light">
                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Libellé</th>
                                <th>Matricule</th>
                                <th>Date_achat</th>
                                <th>Serie</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <tr v-for="materiel in materiels" v-bind:key="materiel.id">
                                <td>{{ materiel.libelle }}</td>
                                <td>{{ materiel.matricule }}</td>
                                <td>{{ materiel.date_achat }}</td>
                                <td>{{ materiel.serie }}</td>
                                <td>{{ materiel.type }}</td> 
                                <td>
                                    <a class="btn btn-sm btn-warning text-white mb-1" @click="editMateriel(materiel)" data-toggle="modal" data-target="#editMaterielModal" >modifier &nbsp;<i class="fas fa-edit fa-lg"></i></a> &nbsp;
                                    <a class="btn btn-sm btn-danger text-white" @click="deleteMateriel(materiel.id)" data-toggle="modal" data-target="#deleteMatModal" >supprimer &nbsp;<i class="fas fa-trash fa-lg"></i></a>
                                    <div class="modal fade" id="deleteMatModal" tabindex="-1" role="dialog" aria-labelledby="deleteMatModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-lg" id="exampleModalLabel">Attention!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-lg font-weight-light">
                                                Voulez-vous supprimer ce matériel ?
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button @click="deleteM()" type="button" class="btn btn-danger">Confirmez</button>
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
    name:'list-materiels',
    props: ['idprop','materiels'],
    data(){
        return {
            employe_id:'',
            materiel_id:'',
            delete_id:'',
            materiel:{},
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:'',
            error:''
        }
    },
    methods: {
        addEventHandler(data){
            this.$emit('AddMatEvent',data);
            this.error = data;
            this.motcle = 'ajouté';
            this.showAlert();
        },
        editEventHandler(data){
            this.$emit('EditMatEvent',data);
            this.error = data;
            this.motcle = 'modifié';
            this.showAlert();
        },
        editMateriel(materiel){
            this.materiel = materiel;
        },
        deleteMateriel(id){
            this.materiel_id = id;
        },
        deleteM(){
            axios.delete(`api/delMateriel/${this.materiel_id}`)
            .then(res=>res.data)
            .then(data=>{
                this.$emit('DelMatEvent',data);
                this.error = data;
                this.motcle = 'supprimé';
                this.showAlert();
            })
            .catch(err => console.log(err))
            $("#deleteMatModal").modal('toggle');
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