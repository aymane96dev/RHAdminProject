<template>
<div class="card mb-5">
    <div class="card-header border-0">
        <div class="row bg-white">
            <div class="col-xl-3">
                <h3 class="text-dark">Liste des <b>Utilisateurs</b></h3>
            </div>
                    
            <div class="col-xl-3 col-6 col-sm-4 bg-primary rounded mb-2 ml-3">
                <div class="input-group input-group-sm input-group-alternative bg-primary" >
                    <div class="input-group-prepend bg-primary">
                        <span class="input-group-text bg-primary"><i class="fas fa-search text-white"></i></span>
                    </div>
                    <input class="form-control bg-primary text-white" type="text" id="srchtxt" placeholder="Cherchez ici" v-on:keyup="searchtxt()" >
                </div>
            </div>
            <div class="offset-xl-1 col-xl-4 d-xl-flex justify-content-end mt-2 d-sm-block" v-if="role === 'administrateur'">
                <button @click="changeAddState()" type="button" class="btn btn-sm btn-primary mb-2" data-toggle="modal" data-target="#addModal" >
                    <i class="fas fa-plus-circle"></i> <span>Ajouter un utilisateur</span>
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
                        <th>Email du compte</th>
                        <th>Role</th>
                        <th v-if="role === 'administrateur' || user.name === name">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-dark">
                    <tr v-for="user in users" v-bind:key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role }}</td> 
                        <td v-if="role === 'administrateur'">
                            <a v-if="user.role !== 'administrateur' || (user.role === 'administrateur' && user.name === name)" class="btn btn-sm btn-warning text-white" @click="editUser(user)" data-toggle="modal" data-target="#addModal" title="modifier" >modifier&nbsp;<i class="fas fa-edit fa-lg text-white"></i></a> &nbsp;
                            <a v-if="user.role !== 'administrateur' || (user.role === 'administrateur' && user.name === name)" class="btn  btn-sm btn-danger text-white" @click="deleteUser(user.id)" data-toggle="modal" data-target="#deleteModal" title="supprimer" >supprimer&nbsp;<i class="fas fa-trash fa-lg text-white"></i></a>
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
                                        Voulez-vous supprimer cet utilisateur ?
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button @click="deleteU()" type="button" class="btn btn-danger">Confirmez</button>
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
                        <a href="#" class="page-link" @click="fetchUsers(pagination.prev_page_url)"><i class="fas fa-angle-double-left"></i> &nbsp;</a>
                    </li>
                    <li class="page-item disabled"><a class="page-link text-dark" href="#">{{ pagination.current_page }}</a></li>
                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item" data-toggle="tooltip" data-placement="top" title="Suivant">
                        <a href="#" class="page-link" @click="fetchUsers(pagination.next_page_url)"> &nbsp; <i class="fas fa-angle-double-right"></i></a>
                    </li>
                </ul>
            </div>
            </nav>        
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-lg" id="addModalLabel">Ajouter un utilisateur</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="modal-body text-dark">
                            <form @submit.prevent="addUser" >
                                <div class="form-group row ml-3">
                                    <label class="col-sm-4 col-form-label text-sm" for="nom">Nom :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="text" name="nom" id="nom" v-model="user.name" placeholder="nom" autocomplete="off" required/>
                                    </div>
                                </div>
                                <div class="form-group row ml-3">
                                    <label class="col-sm-4 col-form-label text-sm" for="email">Email du compte :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="email" name="email" id="email" v-model="user.email" placeholder="email" autocomplete="off" required/>
                                    </div>
                                </div>
                                <div class="form-group row ml-3" v-if="!edit">
                                    <label class="col-sm-4 col-form-label text-sm" for="password">Mot de passe :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="password" name="password" id="password" v-model="user.password" placeholder="mot de passe" autocomplete="off" required/>
                                    </div>
                                </div>
                                <div class="form-group row ml-3" v-if="!edit">
                                    <label class="col-sm-4 col-form-label text-sm" for="password-confirm">Confirmez votre mot de passe :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-sm" type="password" name="password_confirmation" id="password-confirm" v-model="user.password_confirmation" placeholder="confirmation du mot de passe" autocomplete="off" required/>
                                    </div>
                                </div>
                                <div class="form-group row ml-3">
                                    <label class="col-sm-4 col-form-label text-sm" for="role">Role :</label>
                                    <div class="col-sm-6">
                                        <select class="form-control form-control-sm" name="role" id="role" v-model="user.role" autocomplete="off" required>
                                            <option value="administrateur">administrateur</option>
                                            <option value="chef_projet">chef de projet</option>
                                            <option value="employe">employe</option>
                                        </select>
                                    </div>    
                                </div>
                                <div class="form-group row ml-4">
                                    <button type="submit" class="form-control form-control-sm btn btn-primary" id="btnSaveForm">Enregistrez</button>
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
    name:'user-table',
    props: ['role','name'],
    data(){
        return{
            users:[],
            usersfull:[],
            usersbeta:[],
            user:{
                id:'',
                name:'',
                email:'',
                password:'',
                password_confirmation:'',
                role:''
            },
            user_id:'',
            delete_id:'',
            pagination:{},
            edit:false,
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:'',
            error:'',
            success:'',
        }
    },
    created(){
        this.fetchUsers();
        this.fetchFullUsers();
    },
    methods:{
        fetchFullUsers(){
            axios.get('api/fullusers')
            .then(res => res = res.data)
            .then(res => this.usersbeta = res.data)
            .catch(err => console.log(err))
        },
        fetchUsers(page_url){
            let vm= this;
            page_url = page_url || '/api/users'
            axios.get(page_url)
            .then(res => res = res.data)
            .then(res => {
                this.users = res.data;
                this.usersfull = res.data; 
                vm.makePagination(res.meta,res.links);
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
                this.users = this.usersbeta.filter(user => (user.name.includes(valtext) || user.email.includes(valtext) 
            || user.role.includes(valtext) ));
            }else{
                this.users = this.usersfull;
            }
        },
        addUser(){
            if(this.edit === false){
                //add
                fetch('api/user',{
                    method:'post',
                    body: JSON.stringify(this.user),
                    headers :{
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(res => res.json())
                .then(data =>{
                    this.error='';
                    this.user.name = '';
                    this.user.email = '';
                    this.user.password = '';
                    this.user.password_confirm = '';
                    this.user.role = '';
                    $('#addModal').modal('toggle');
                    this.fetchUsers();
                    this.error = Object.values(data);
                    this.motcle='ajouté';
                    this.showAlert();
                })
                .catch(err => console.log(err))
            } else {
                //edit
                fetch('api/user',{
                    method:'put',
                    body: JSON.stringify(this.user),
                    headers :{
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(res => res.json())
                .then(data =>{
                    this.error = Object.values(data);
                    this.user.name = '';
                    this.user.email = '';
                    this.user.role = '';
                    $('#addModal').modal('toggle');
                    this.fetchUsers();
                    this.motcle='modifié';
                    this.showAlert();
                })
                .catch(err => this.error=err)
            }
        },
        deleteUser(id) {
            this.delete_id=id;
        },
        deleteU(){
            fetch(`api/user/${this.delete_id}`,{
                method: 'delete',
                headers :{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(res => res.json())
            .then(data =>{
                this.error = Object.values(data);
                this.fetchUsers();
                 $('#deleteModal').modal('toggle');
                this.motcle='supprimé';
                this.showAlert(); 
            })
            .catch(err => console.log(err))
        },
        editUser(user){
            this.edit=true;
            $('#addModal').modal('show');
            $('#addModalLabel').text('Modifier un utilisateur');
            $('#btnSaveForm').attr('class','btn btn-warning');
            $('#btnSaveForm').text('Modifiez');
            this.user.id= user.id;
            this.user.name = user.name;
            this.user.email = user.email;
            this.user.role = user.role;
        },
        changeAddState(){
            this.edit=false;
            $('#addModal').modal('show');
            $('#addModalLabel').text('Ajouter un utilisateur');
            $('#btnSaveForm').attr('class','btn btn-primary');
            $('#btnSaveForm').text('Enregistrez');
            this.user.id= '';
            this.user.name = '';
            this.user.email = '';
            this.user.password = '';
            this.user.password_confirm = '';
            this.user.role = '';
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