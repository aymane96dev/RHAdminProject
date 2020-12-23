<template>
    <div class="card mb-5">
    <div class="card-header border-0">
        <div class="row bg-white">
            <div class="col-xl-3">
                <h3 class="text-dark">Liste des <b>Entretiens</b></h3>
            </div>
            <div class="col-xl-3 col-6 col-sm-4 bg-primary rounded mb-2 ml-3">
                <div class="input-group input-group-sm input-group-alternative bg-primary" title="cherchez ici">
                    <div class="input-group-prepend bg-primary">
                        <span class="input-group-text bg-primary"><i class="fas fa-search text-white"></i></span>
                    </div>
                    <input class="form-control bg-primary text-white" type="text" id="srchtxt" placeholder="Cherchez ici" v-on:keyup="searchtxt($event)" >
                </div>
            </div>
            <div class="offset-xl-1 col-xl-4 d-xl-flex justify-content-end mt-2 d-sm-block">
                <button type="button" class="btn btn-sm btn-primary mr-3 mb-2" data-toggle="modal" data-target="#addEntretienModal" >
                    <i class="fas fa-plus-circle"></i> <span>Ajouter un entretien</span>
                </button>					
            </div>
        </div>
        <addentien-component v-on:addEvent="AddEventHandler($event)"></addentien-component>
        <editentien-component :entretien="entretien" v-on:editEvent="EditEventHandler($event)"></editentien-component>
         <div class="row" v-if="error !== '' && Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="danger" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged"  v-for="err in error" v-bind:key="err.value" >
                <span v-for="e in err" v-bind:key="e.value" > {{ e }}</span>
            </b-alert>
        </div>
        <div class="row" v-if="error !== '' && !Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="success" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" >
                l'entretien a été {{ motcle }} avec succès
            </b-alert>
        </div>
    </div>
    <div class="table-responsive">
        <div class="table-wrapper table-light">
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Candidat</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-dark">
                    <tr v-for="entretien in entretiens" v-bind:key="entretien.id"> 
                        <td>{{ entretien.date }}</td>
                        <td>{{ entretien.description }}</td>
                        <td><a class="text-primary" @click="afficher(entretien.id)" target="_blank">Afficher</a></td>  
                        <td>
                            <a class="btn btn-sm btn-warning text-white mb-1" @click="editEntretien(entretien)" data-toggle="modal" data-target="#editEntretienModal" title="modifier" >modifier &nbsp;<i class="fas fa-edit fa-lg"></i></a> &nbsp;
                            <a class="btn btn-sm btn-danger text-white" @click="setDeletedId(entretien.id)" data-toggle="modal" data-target="#deleteEntretienModal" title="supprimer" >supprimer &nbsp;<i class="fas fa-trash fa-lg"></i></a>
                            <div class="modal fade" id="deleteEntretienModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-lg" id="exampleModalLabel">Attention!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-lg font-weight-light">
                                        Voulez-vous supprimer cet entretien ?
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button  @click="deleteEntretien()" type="button" class="btn btn-danger">Confirmez</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulez</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr> 
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <div class="clearfix pl-4 py-2">
                    <ul class="pagination mt-2">
                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item" data-toggle="tooltip" data-placement="top" title="Précédent">
                            <a href="#" class="page-link" @click="fetchEntretiens(pagination.prev_page_url)"><i class="fas fa-angle-double-left " style="color:cornflowerblue;"></i> &nbsp;</a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="#" style="color:cornflowerblue;">{{ pagination.current_page }}</a></li>
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item" data-toggle="tooltip" data-placement="top" title="Suivant">
                            <a href="#" class="page-link" @click="fetchEntretiens(pagination.next_page_url)">&nbsp; <i class="fas fa-angle-double-right " style="color:cornflowerblue;"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
            <b-modal v-model="modalShow" hide-backdrop content-class="shadow" title="La liste des employés" ok-only>
                <table class="table table-light table-hover table-responsive">
                    <thead class="thead-light">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Numéro de téléphone</th>
                            <th>Email</th>
                            <th>Diplome</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-light text-dark">
                        <tr >
                            <td>{{ candidat.nom }}</td>
                            <td>{{ candidat.prenom }}</td>
                            <td>{{ candidat.num_tel }}</td>
                            <td>{{ candidat.email }}</td>
                            <td>{{ candidat.diplome }}</td>
                        </tr>
                    </tbody>
                </table> 
            </b-modal>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'entretien-cpnt',
    data() {
        return {
            modalShow:false,
            entretiens:[],
            entretien:{},
            full_entrs:[],
            fetched_entrs:[],
            candidat:{},
            entretien:{},
            pagination:{},
            delete_id:'',
            error:'',
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:''
        };
    },
    created() {
        this.fetchEntretiens();
        this.fetchFullEntrs();
    },
    methods: {
        searchtxt(e) {
            let valtext = e.target.value;
            if(valtext !== ''){
                this.entretiens = this.full_entrs.filter(entretien => (entretien.date.includes(valtext) ||
                entretien.description.includes(valtext)));
            }else{
                this.entretiens = this.fetched_entrs;
            }
        },
        fetchEntretiens(page_url){
            let vm= this;
            page_url = page_url || 'api/entretiens';
            axios.get(page_url)
                .then(res => res.data)
                .then(data => {
                    this.entretiens = data.data;
                    this.fetched_entrs = data.data; 
                    vm.makePagination(data.current_page,data.last_page,data.next_page_url,data.prev_page_url);
                })
                .catch(err => console.log(err));
        },
        fetchFullEntrs(){
            axios.get('api/fullentretiens')
                .then(res => res.data)
                .then(data => {
                    this.full_entrs = data.data;
                })
                .catch(err => console.log(err));
        },
        makePagination(current_page,last_page,next_page_url,prev_page_url){
            let pagination={
                current_page: current_page,
                last_page: last_page,
                next_page_url: next_page_url,
                prev_page_url: prev_page_url
            }
            this.pagination = pagination;
        },
        editEntretien(entretien){
            this.entretien = entretien;
        },
        setDeletedId(id){
            this.delete_id = id;
        },
        deleteEntretien(){
            axios.delete(`api/deleteEntretien/${this.delete_id}`)
            .then(res=>res.data)
            .then(data=>{
                this.error = data;
                this.motcle = 'supprimé';
                this.showAlert();
                this.fetchEntretiens();
            })
            .catch(err => console.log(err))
            $("#deleteEntretienModal").modal('toggle');
        },
        AddEventHandler(data){
            this.error = data;
            this.motcle = 'ajouté';
            this.showAlert();
            this.fetchEntretiens();
        },
        EditEventHandler(data){
            this.error = data;
            this.motcle = 'modifié';
            this.showAlert();
            this.fetchEntretiens();
        },
        afficher(id){
            this.modalShow = true;
            axios.get(`api/entretienCandidat/${id}`)
            .then(res=>res.data)
            .then(data=>{
                this.candidat = data.data;
            })
            .catch(err=>console.log(err));
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