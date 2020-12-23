<template>
<div class="card mb-5">
    <div class="card-header border-0">
        <div class="row bg-white">
            <div class="col-xl-3">
                <h3 class="text-dark">Liste des <b>Candidats</b></h3>
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
                <button type="button" class="btn btn-sm btn-primary mr-3 mb-2" data-toggle="modal" data-target="#addCandidatModal" >
                    <i class="fas fa-plus-circle"></i> <span>Ajouter un candidat</span>
                </button>					
            </div>
            <addcddt-component v-on:addEvent="AddEventHandler($event)"></addcddt-component>
            <editcddt-component :candidat="candidat" v-on:editEvent="EditEventHandler($event)"></editcddt-component>
        </div>
         <div class="row" v-if="error !== '' && Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="danger" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged"  v-for="err in error" v-bind:key="err.value" >
                <span v-for="e in err" v-bind:key="e.value" > {{ e }}</span>
            </b-alert>
        </div>
        <div class="row" v-if="error !== '' && !Array.isArray(error)" >
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="success" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" >
                le candidat a été {{ motcle }} avec succès
            </b-alert>
        </div>
    </div>
    <div class="table-responsive">
        <div class="table-wrapper table-light">
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Numéro du téléphone</th>
                        <th>Email</th>
                        <th>CV</th>
                        <th>Diplome</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-dark">
                    <tr v-for="candidat in candidats" v-bind:key="candidat.id">
                        <td>{{ candidat.nom }}</td> 
                        <td>{{ candidat.prenom }}</td>
                        <td>{{ candidat.num_tel }}</td>
                        <td>{{ candidat.email }}</td>
                        <td><a :href="'storage/cvs/'+candidat.cv" target="_blank">Ouvrir</a></td>
                        <td>{{ candidat.diplome }}</td>    
                        <td>
                            <a class="btn btn-sm btn-warning text-white mb-1" @click="editCandidat(candidat)" data-toggle="modal" data-target="#editCandidatModal" title="modifier" >modifier &nbsp;<i class="fas fa-edit fa-lg"></i></a> &nbsp;
                            <a class="btn btn-sm btn-danger text-white" @click="setDeletedId(candidat.id)" data-toggle="modal" data-target="#deleteCandidatModal" title="supprimer" >supprimer &nbsp;<i class="fas fa-trash fa-lg"></i></a>
                            <div class="modal fade" id="deleteCandidatModal" tabindex="-1" role="dialog" aria-labelledby="deleteCandidatModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-lg" id="exampleModalLabel">Attention!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-lg font-weight-light">
                                        Voulez-vous supprimer ce candidat ?
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button  @click="deleteCandidat()" type="button" class="btn btn-danger">Confirmez</button>
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
                            <a href="#" class="page-link" @click="fetchCandts(pagination.prev_page_url)"><i class="fas fa-angle-double-left " style="color:cornflowerblue;"></i> &nbsp;</a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="#" style="color:cornflowerblue;">{{ pagination.current_page }}</a></li>
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item" data-toggle="tooltip" data-placement="top" title="Suivant">
                            <a href="#" class="page-link" @click="fetchCandts(pagination.next_page_url)">&nbsp; <i class="fas fa-angle-double-right " style="color:cornflowerblue;"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'candidat-component',
    data() {
        return {
            modalShow:false,
            candidats:[],
            candidat:{},
            full_cdts:[],
            fetched_cdts:[],
            pagination:{},
            delete_id:'',
            error:'',
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:''
        };
    },
    created() {
        this.fetchCandts();
        this.fetchFullCdts();
    },
    methods: {
        searchtxt(e) {
            let valtext = e.target.value;
            if(valtext !== ''){
                this.candidats = this.full_cdts.filter(candidat => (candidat.nom.includes(valtext) || candidat.prenom.includes(valtext) ||
                candidat.num_tel.includes(valtext) || candidat.email.includes(valtext) || candidat.cv.includes(valtext) || candidat.diplome.includes(valtext)));
            }else{
                this.candidats = this.fetched_cdts;
            }
        },
        fetchCandts(page_url){
            let vm= this;
            page_url = page_url || 'api/candidats';
            axios.get(page_url)
                .then(res => res.data)
                .then(data => {
                    this.candidats = data.data;
                    this.fetched_cdts = data.data; 
                    vm.makePagination(data.current_page,data.last_page,data.next_page_url,data.prev_page_url);
                })
                .catch(err => console.log(err));
        },
        fetchFullCdts(){
             axios.get('api/fullcandidats')
                .then(res => res.data)
                .then(data => {
                    this.full_cdts = data.data;
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
        editCandidat(candidat){
            this.candidat = candidat;
        },
        setDeletedId(id){
            this.delete_id = id;
        },
        deleteCandidat(){
            axios.delete(`api/deleteCandidat/${this.delete_id}`)
            .then(res=>res.data)
            .then(data=>{
                this.error = data;
                this.motcle = 'supprimé';
                this.showAlert();
                this.fetchCandts();
            })
            .catch(err => console.log(err))
            $("#deleteCandidatModal").modal('toggle');
        },
        AddEventHandler(data){
            this.error = data;
            this.motcle = 'ajouté';
            this.showAlert();
            this.fetchCandts();
        },
        EditEventHandler(data){
            this.error = data;
            this.motcle = 'modifié';
            this.showAlert();
            this.fetchCandts();
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