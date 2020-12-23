<template>
<div class="card mb-5">
    <div class="card-header border-0">
        <div class="row bg-white">
            <div class="col-xl-3">
                <h3 class="text-dark">Liste des <b>Employees</b></h3>
            </div>
            <div class="col-xl-3 col-6 col-sm-4 bg-primary rounded mb-2 ml-3">
                <div class="input-group input-group-sm input-group-alternative bg-primary" title="cherchez ici">
                    <div class="input-group-prepend bg-primary">
                        <span class="input-group-text bg-primary"><i class="fas fa-search text-white"></i></span>
                    </div>
                    <input class="form-control bg-primary text-white" type="text" id="srchtxt" placeholder="Cherchez ici" v-on:keyup="searchtxt()" >
                </div>
            </div>
            <div class="offset-xl-1 col-xl-4 d-xl-flex justify-content-end mt-2 d-sm-block">
                <button @click="changeAddState()" type="button" class="btn btn-sm btn-primary mr-3 mb-2" data-toggle="modal" data-target="#addModal" >
                    <i class="fas fa-plus-circle"></i> <span>Ajouter un employé</span>
                </button>					
            </div>
        </div>
        <div class="row" v-for="err in error" v-bind:key="err.value">
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="danger" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" v-if="error !== '' && Array.isArray(err)" >
                <span v-for="e in err" v-bind:key="e.value" > {{ e }}</span>
            </b-alert>
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="success" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" v-if="error !== '' && !Array.isArray(err)" >
                l'employé a été {{ motcle }} avec succès
            </b-alert>
        </div> 
    </div>
    <div class="table-responsive">
        <div class="table-wrapper table-light">
            <div class="table-title">
            </div>
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                        <th>Numéro de téléphone</th>
                        <th>Email</th>
                        <th>CIN</th>
                        <th>Date Intégration</th>
                        <th>Statut</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-dark">
                    <tr v-for="employe in employes" v-bind:key="employe.id">
                        <td>{{ employe.nom }}</td>
                        <td>{{ employe.prenom}}</td>
                        <td>{{ employe.date_naissance }}</td>
                        <td>{{ employe.num_tele }}</td>
                        <td>{{ employe.email }}</td>
                        <td>{{ employe.cin }}</td>
                        <td>{{ employe.date_integration }}</td>
                        <td>{{ employe.statut }}</td>
                        <td><a class="text-center text-primary" @click="toggleModal(employe.photo)">Afficher</a></td>   
                        <td>
                            <a class="btn btn-sm btn-warning text-white mb-1" @click="editEmploye(employe)" data-toggle="modal" data-target="#addModal" title="modifier" >modifier &nbsp;<i class="fas fa-edit fa-lg"></i></a> &nbsp;
                            <a class="btn btn-sm btn-danger text-white" v-if="role !== 'employe'" @click="deleteEmploye(employe.id)" data-toggle="modal" data-target="#deleteModal" title="supprimer" >supprimer &nbsp;<i class="fas fa-trash fa-lg"></i></a>
                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-lg" id="exampleModalLabel">Attention!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-lg font-weight-light">
                                        Voulez-vous supprimer cet employé ?
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button @click="deleteEmp()" type="button" class="btn btn-danger">Confirmez</button>
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
                            <a href="#" class="page-link" @click="fetchEmployes(pagination.prev_page_url)"><i class="fas fa-angle-double-left " style="color:cornflowerblue;"></i> &nbsp;</a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="#" style="color:cornflowerblue;">{{ pagination.current_page }}</a></li>
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item" data-toggle="tooltip" data-placement="top" title="Suivant">
                            <a href="#" class="page-link" @click="fetchEmployes(pagination.next_page_url)">&nbsp; <i class="fas fa-angle-double-right " style="color:cornflowerblue;"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
            <b-modal v-model="modalShow" hide-backdrop content-class="shadow" title="Photo d'employé" ok-only>
                <img width="450px" height="360px" :src="photoimage"/>
            </b-modal>
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-lg" id="addModalLabel">Ajouter un employé</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="modal-body text-dark">
                            <form @submit.prevent="addEmploye">
                                <div class="form-group row ml-3">
                                    <label class="col-sm-4 col-form-label text-sm" for="nom">Nom :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="text" name="nom" id="nom" v-model="employe2.nom" required/>
                                    </div>
                                </div>
                                <div class="form-group row ml-3">
                                    <label class="col-sm-4 col-form-label text-sm" for="prenom">Prénom :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="text" name="prenom" id="prenom" v-model="employe2.prenom" required/>
                                    </div>
                                </div>
                                <div class="form-group row ml-3">
                                    <label class="col-sm-4 col-form-label text-sm" for="date_naissance">Date de <br> naissance :</label>
                                    <div class="col-sm-6">
                                    <input class="form-control form-control-sm" type="date" name="date_naissance" id="date_naissance" v-model="employe2.date_naissance" required/>
                                    </div>
                                </div>
                                <div class="form-group row ml-3">
                                    <label class="col-sm-4 col-form-label text-sm" for="num_tele">Numéro de téléphone :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="tel" name="num_tele" id="num_tele" v-model="employe2.num_tele" required/>
                                    </div>
                                </div>
                                <div class="form-group row ml-3">
                                    <label class="col-sm-4 col-form-label text-sm" for="email">Email :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="email" name="email" id="email" v-model="employe2.email" required/>
                                    </div>
                                </div>
                                <div class="form-group row ml-3">
                                    <label class="col-sm-4 col-form-label text-sm" for="cin">CIN :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="text" name="cin" id="cin" v-model="employe2.cin" required/>
                                    </div>
                                </div>
                                <div class="form-group row ml-3">
                                    <label class="col-sm-4 col-form-label text-sm" for="date_integration">Date <br> d'intégration :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="date" name="date_integration" id="date_integration" v-model="employe2.date_integration" required/>
                                    </div>
                                </div>
                                <div class="form-group row ml-3">
                                    <label class="col-sm-4 col-form-label text-sm" for="statut">Statut :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="text" name="statut" id="statut" v-model="employe2.statut" required/>
                                    </div>
                                </div>
                               <div class="form-group row ml-3">
                                   <label class="col-sm-4 col-form-label text-sm" for="photo">Photo :</label>
                                   <div class="custom-file col-sm-6 ml-3">
                                    <input class="custom-file-input form-control-sm" type="file" name="photo" id="photo" @change="previewFiles" accept="image/*"/>
                                    <label class="custom-file-label col-form-label-sm" for="photo" >{{ employe2.photo.name || employe2.photo }}</label> 
                                   </div> 
                                </div>
                                <div class="form-group row ml-4">
                                    <button type="submit" class="form-control-sm btn btn-primary" id="btnSaveForm">Enregistrez</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name:'employe-table',
    props: ['role'],
    data() {
        return{
            employes:[],
            employesfull:[],
            employesbeta:[],
            employe2:{
                id:'',
                nom:'',
                prenom:'',
                date_naissance:'',
                num_tele:'',
                email:'',
                cin:'',
                date_integration:'',
                statut:'',
                photo:''
            },
            employe_id:'',
            delete_id:'',
            pagination:{},
            edit:false,
            modalShow:false,
            photoimage:'',
            imgurl:'',
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:'',
            error:'',
        }
    },
    created(){
        this.fetchEmployes();
        this.fetchFullEmployes();
        //this.findiduser();
    },
    methods:{
        fetchEmployes(page_url){
            let vm= this;
            page_url = page_url || '/api/employes'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.employes = res.data;
                    this.employesfull = res.data; 
                    vm.makePagination(res.meta,res.links);
                })
                .catch(err => console.log(err));
        },
        fetchFullEmployes(){
             fetch('api/employesfull')
                .then(res => res.json())
                .then(res => {
                    this.employesbeta = res.data;
                })
                .catch(err => console.log(err));
        },
        makePagination(meta,links){
            let pagination={
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }
            this.pagination = pagination;
        },
        searchtxt(){
            let valtext= document.getElementById('srchtxt').value;
            if(valtext !== ''){
                this.employes = this.employesbeta.filter(emp => (emp.nom.includes(valtext) || emp.prenom.includes(valtext) 
            || emp.date_naissance.includes(valtext) || emp.num_tele.includes(valtext) || emp.email.includes(valtext)    
            || emp.cin.includes(valtext) || emp.date_integration.includes(valtext) || emp.statut.includes(valtext) ));
            }else{
                this.employes = this.employesfull;
            }
        },
        addEmploye(){
            if(this.edit === false){
                //add
                var formdata= new FormData();
                formdata.append('nom',this.employe2.nom);
                formdata.append('prenom',this.employe2.prenom);
                formdata.append('date_naissance',this.employe2.date_naissance);
                formdata.append('num_tele',this.employe2.num_tele);
                formdata.append('email',this.employe2.email);
                formdata.append('cin',this.employe2.cin);
                formdata.append('date_integration',this.employe2.date_integration);
                formdata.append('statut',this.employe2.statut);
                formdata.append('photo',this.employe2.photo);
                axios.post('api/employe',formdata,
                {
                    headers: {
                    'Content-Type': 'multipart/form-data'
                    }
                })
                .then(res => res.data)
                .then(data =>{
                    this.error='';
                    this.employe2.nom = '';
                    this.employe2.prenom = '';
                    this.employe2.date_naissance = '';
                    this.employe2.num_tele = '';
                    this.employe2.email = '';
                    this.employe2.cin = '';
                    this.employe2.date_integration = '';
                    this.employe2.statut = '';
                    this.employe2.photo = '';
                    $('#addModal').modal('toggle');
                    this.fetchEmployes();
                    this.error = Object.values(data);
                    this.motcle='ajouté';
                    this.showAlert();
                })
                .catch(err => console.log(err))
            } else {
                //edit
                var formdata= new FormData();
                formdata.append('id',this.employe2.id);
                formdata.append('nom',this.employe2.nom);
                formdata.append('prenom',this.employe2.prenom);
                formdata.append('date_naissance',this.employe2.date_naissance);
                formdata.append('num_tele',this.employe2.num_tele);
                formdata.append('email',this.employe2.email);
                formdata.append('cin',this.employe2.cin);
                formdata.append('date_integration',this.employe2.date_integration);
                formdata.append('statut',this.employe2.statut);
                formdata.append('photo',this.employe2.photo);
                axios.post('api/employe/edit',formdata,
                {
                    headers: {
                    'Content-Type': 'multipart/form-data'
                    }
                })
                .then(res => res.data)
                .then(data =>{
                    console.log(data);
                    this.error='';
                    this.employe2.nom = '';
                    this.employe2.prenom = '';
                    this.employe2.date_naissance = '';
                    this.employe2.num_tele = '';
                    this.employe2.email = '';
                    this.employe2.cin = '';
                    this.employe2.date_integration = '';
                    this.employe2.statut = '';
                    this.employe2.photo = '';
                    $('#addModal').modal('toggle');
                    this.fetchEmployes();
                    this.error = Object.values(data);
                    this.motcle='modifié';
                    this.showAlert();
                })
                .catch(err => this.error=err)
            }
        },
        deleteEmploye(id) {
            this.delete_id=id;
        },
        deleteEmp(){
            //alert('item'+this.delete_id+'deleted');
            fetch(`api/employe/${this.delete_id}`,{
                method: 'delete',
                headers :{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(res => res.json())
            .then(data =>{
                this.fetchEmployes();
                this.error = Object.values(data);
                 $('#deleteModal').modal('toggle');
                 this.motcle='supprimé';
                 this.showAlert();
            })
            .catch(err => console.log(err))
        },
        editEmploye(employe){
            this.edit=true;
            $('#addModal').modal('show');
            $('#addModalLabel').text('Modifier un employé');
            $('#btnSaveForm').attr('class','btn btn-warning');
            $('#btnSaveForm').text('Modifiez');
            this.employe2.id = employe.id;
            this.employe2.nom = employe.nom;
            this.employe2.prenom = employe.prenom;
            this.employe2.date_naissance = employe.date_naissance;
            this.employe2.num_tele = employe.num_tele;
            this.employe2.email = employe.email;
            this.employe2.cin = employe.cin;
            this.employe2.date_integration = employe.date_integration;
            this.employe2.statut = employe.statut;
            this.employe2.photo = employe.photo;
        },
        changeAddState(){
            this.edit=false;
            $('#addModal').modal('show');
            $('#addModalLabel').text('Ajouter un employé');
            $('#btnSaveForm').attr('class','btn btn-primary');
            $('#btnSaveForm').text('Enregistrez');
            this.employe2.id = '';
            this.employe2.nom = '';
            this.employe2.prenom = '';
            this.employe2.date_naissance = '';
            this.employe2.num_tele = '';
            this.employe2.email = '';
            this.employe2.cin = '';
            this.employe2.date_integration = '';
            this.employe2.statut = '';
            this.employe2.photo = '';
        },
        previewFiles(event)
        {
            this.employe2.photo = event.target.files[0];
        },
        toggleModal(photo){
            this.modalShow = !this.modalShow;
            if(this.modalShow == true){
                this.photoimage = "storage/images/"+photo;
            }
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

<style scoped>

</style>