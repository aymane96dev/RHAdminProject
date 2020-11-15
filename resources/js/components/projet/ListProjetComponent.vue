<template>
  <b-card >
        <div class="row">
           <h1 class="col-xl-8">Les projets de l'équipe sélectionné :</h1>
           <div class="col-xl-4 d-xl-flex justify-content-end align-items-start">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addProjetModal">
                    <i class="fas fa-plus-circle"></i> &nbsp; Ajouter un projet
                </button>
           </div>
        </div>
        <addprojet-component :id="idprop" v-on:addProjet="AddProjetHandler($event)"></addprojet-component>
        <editprojet-component :id="idprop" :projet="projet" v-on:editProjet="EditProjetHandler($event)"></editprojet-component>
        <div class="row" v-if="error !== '' && Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="danger" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged"  v-for="err in error" v-bind:key="err.value" >
                <span v-for="e in err" v-bind:key="e.value" > {{ e }}</span>
            </b-alert>
        </div>
        <div class="row" v-if="error !== '' && !Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="success" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" >
                le projet a été {{ motcle }} avec succès
            </b-alert>
        </div>
        <div class="row mt-2">
            <div class="table-responsive">
                <div class="table-wrapper table-light">
                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Description</th>
                                <th>Date de création</th>
                                <th>Date de livraison</th>
                                <th>Etat</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <tr v-for="projet in projets" v-bind:key="projet.id">
                                <td>{{ projet.description }}</td>
                                <td>{{ projet.date_creation }}</td>
                                <td>{{ projet.date_livraison }}</td>
                                <td>{{ projet.etat }}</td>
                                <td>
                                    <a class="btn btn-sm btn-warning text-white mb-1" @click="editProjet(projet)" data-toggle="modal" data-target="#editProjetModal" >modifier &nbsp;<i class="fas fa-edit fa-lg"></i></a> &nbsp;
                                    <a class="btn btn-sm btn-danger text-white" @click="deleteProjet(projet.id)" data-toggle="modal" data-target="#deleteProjetModal" >supprimer &nbsp;<i class="fas fa-trash fa-lg"></i></a>
                                    <div class="modal fade" id="deleteProjetModal" tabindex="-1" role="dialog" aria-labelledby="deleteProjetModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-lg" id="exampleModalLabel">Attention!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-lg font-weight-light">
                                                Voulez-vous supprimer ce projet ?
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button @click="deleteP()" type="button" class="btn btn-danger">Confirmez</button>
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
    name:'List-projet',
    props: ['idprop','projets'],
    data(){
        return{
            projet_id:'',
            projet:{},
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:'',
            error:''
        }
    },
    created() {
        
    },
    methods:{
        AddProjetHandler(data){
            this.$emit('addProjet',data);
            this.error = data;
            this.motcle = 'ajouté';
            this.showAlert();
        },
        EditProjetHandler(data){
            this.$emit('editProjet',data);
            this.error = data;
            this.motcle = 'modifié';
            this.showAlert();
        },
        editProjet(projet){
            this.projet = projet;
        },
        deleteProjet(id){
            this.projet_id = id;
        },
        deleteP(){
            axios.delete(`api/delProjet/${this.projet_id}`)
            .then(res=>res.data.data)
            .then(data=>{
                this.$emit('delProjet',data);
                this.error = data;
                this.motcle = 'supprimé';
                this.showAlert();
            })
            .catch(err=>console.log(err));
            $('#deleteProjetModal').modal('toggle');
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