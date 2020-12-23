<template>
    <b-card >
        <div class="row">
           <h1 class="col-xl-8">Les contrats de l'employé sélectionné :</h1>
           <div class="col-xl-4 d-xl-flex justify-content-end align-items-start">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addCtrtModal">
                    <i class="fas fa-plus-circle"></i> &nbsp; Ajouter un contrat
                </button>
           </div>
        </div>
        <addctrt-component :id="idprop" v-on:addEvent="addEventHandler($event)" ></addctrt-component>
        <editctrt-component :id="idprop" :contrat="contrat" v-on:editContrat="editEventHandler($event)"></editctrt-component>
        <div class="row" v-if="error !== '' && Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="danger" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged"  v-for="err in error" v-bind:key="err.value" >
                <span v-for="e in err" v-bind:key="e.value" > {{ e }}</span>
            </b-alert>
        </div>
        <div class="row" v-if="error !== '' && !Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="success" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" >
                le contrat a été {{ motcle }} avec succès
            </b-alert>
        </div>
        <div class="row mt-2">
            <div class="table-responsive">
                <div class="table-wrapper table-light">
                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Date du signature</th>
                                <th>Type</th>
                                <th>Durée</th>
                                <th>Salaire</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <tr v-for="contrat in contrat" :key="contrat.id">
                                <td>{{ contrat.date_signature }}</td>
                                <td>{{ contrat.type }}</td>
                                <td>{{ contrat.duree }}</td>
                                <td>{{ contrat.salaire }}</td> 
                                <td>
                                    <a class="btn btn-sm btn-warning text-white mb-1" data-toggle="modal" data-target="#editCtrtModal" >modifier &nbsp;<i class="fas fa-edit fa-lg"></i></a> &nbsp;
                                    <a class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#deleteCtrtModal" >supprimer &nbsp;<i class="fas fa-trash fa-lg"></i></a>
                                    <div class="modal fade" id="deleteCtrtModal" tabindex="-1" role="dialog" aria-labelledby="deleteCtrtModalLabel" aria-hidden="true">
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
                                                <button @click="deleteCtrt(contrat.id)" type="button" class="btn btn-danger">Confirmez</button>
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
    name: 'list-contrat',
    props: ['idprop','contrat'],
    data() {
        return{
            employe_id:'',
            delete_id:'',
            ctrt:{},
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:'',
            error:''
        }
    },
    methods: {
        addEventHandler(data){
            this.$emit('addEvent',data);
            this.error = data;
            this.motcle = 'ajouté';
            this.showAlert();
        },
        editEventHandler(data){
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
        },
        deleteCtrt(id){
            axios.delete(`api/delContrat/${id}`)
            .then(res=>res.data.data)
            .then(data=>{
                this.$emit('delEvent',data);
                this.error = data;
                this.motcle = 'supprimé';
                this.showAlert();
            })
            .catch(err=>console.log(err));
            $('#deleteCtrtModal').modal('toggle');
        }
    }
}
</script>

<style>

</style>