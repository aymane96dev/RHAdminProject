<template>
  <div class="card mb-5">
    <div class="card-header border-0">
        <div class="row bg-white">
            <div class="col-xl-3">
                <h3 class="text-dark">Liste des <b>Equipes</b></h3>
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
                <button type="button" class="btn btn-sm btn-primary mr-3 mb-2" data-toggle="modal" data-target="#addEquipeModal" >
                    <i class="fas fa-plus-circle"></i> <span>Ajouter une équipe</span>
                </button>					
            </div>
            <addequipe-component v-on:addEvent="AddEventHandler($event)"></addequipe-component>
            <editequipe-component :equipe="equipe" :DispoEmps="DispoEmps" :IndispEmps="IndispEmps" v-on:editEvent="EditEventHandler($event)"></editequipe-component>
        </div>
        <div class="row" v-for="err in error" v-bind:key="err.value">
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="danger" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" v-if="error !== '' && Array.isArray(err)" >
                <span v-for="e in err" v-bind:key="e.value" > {{ e }}</span>
            </b-alert>
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="success" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" v-if="error !== '' && !Array.isArray(err)" >
                l'équipe a été {{ motcle }} avec succès
            </b-alert>
        </div> 
    </div>
    <div class="table-responsive">
        <div class="table-wrapper table-light">
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Nom</th>
                        <th>Mission</th>
                        <th>La liste des employés</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-dark">
                    <tr v-for="equipe in equipes" v-bind:key="equipe.id">
                        <td>{{ equipe.nom }}</td> 
                        <td>{{ equipe.mission }}</td>
                        <td><a class="text-center text-primary" @click="showEmployes(equipe.id)">Afficher</a></td>   
                        <td>
                            <a class="btn btn-sm btn-warning text-white mb-1" @click="editEquipe(equipe)" data-toggle="modal" data-target="#editEquipeModal" title="modifier" >modifier &nbsp;<i class="fas fa-edit fa-lg"></i></a> &nbsp;
                            <a class="btn btn-sm btn-danger text-white" @click="setDeletedId(equipe.id)" data-toggle="modal" data-target="#deleteEquipeModal" title="supprimer" >supprimer &nbsp;<i class="fas fa-trash fa-lg"></i></a>
                            <div class="modal fade" id="deleteEquipeModal" tabindex="-1" role="dialog" aria-labelledby="deleteEquipeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-lg" id="exampleModalLabel">Attention!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-lg font-weight-light">
                                        Voulez-vous supprimer cette équipe ?
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button  @click="deleteEquipe()" type="button" class="btn btn-danger">Confirmez</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulez</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr> 
                </tbody>
            </table>
            <b-modal v-model="modalShow" hide-backdrop content-class="shadow" title="La liste des employés" ok-only>
                <table class="table table-light table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-light text-dark">
                        <tr v-for="employe in employes" v-bind:key="employe.id">
                            <td>{{ employe.nom }}</td>
                            <td>{{ employe.prenom }}</td>
                            <td>{{ employe.statut }}</td>
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
    name:'equipe-component',
    data() {
        return {
            id:'',
            modalShow:false,
            equipes:[],
            eqs:[],
            equipe:{},
            delete_id:'',
            employes:[],
            DispoEmps:[],
            IndispEmps:[],
            error:'',
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:''
        }
    },
    created(){
        this.getEquipes();
    },
    methods:{
        AddEventHandler(data){
            this.error=data;
            this.getEquipes();
            this.motcle = 'ajouté';
            this.showAlert();
        },
        EditEventHandler(data){
            this.error=data;
            this.getEquipes();
            this.motcle = 'modifié';
            this.showAlert();
        },
        getEquipes(){
            axios.get('api/equipes')
            .then(res => res.data.data)
            .then(data=>{
                this.equipes = data;
                this.eqs = data;
            })
            .catch(err => console.log(err));
        },
        getDispEmps(){
            axios.get('api/getEmployes')
            .then(res => res.data)
            .then(data=>{
                this.DispoEmps=data;
            })
            .catch(err=>console.log(err));
        },
        getIndispEmps(id){
            axios.get(`api/getIndispEmps/${id}`)
            .then(res => res.data.data)
            .then(data=>{
                this.IndispEmps=data;
            })
            .catch(err=>console.log(err));
        },
        showEmployes(id){
            axios.get(`api/getEmpsEquipe/${id}`)
            .then(res => res.data.data)
            .then(data=>{
                this.employes = data;
            })
            .catch(err => console.log(err));
            this.modalShow=true;
        },
        editEquipe(equipe){
            this.equipe = equipe;
            this.getDispEmps();
            this.getIndispEmps(equipe.id);
        },
        setDeletedId(id){
            this.delete_id=id;
        },
        deleteEquipe(){
            axios.delete(`api/deleteEmp/${this.delete_id}`)
            .then(res=>res.data)
            .then(data=>{
                this.getEquipes();
                this.error=data;
                this.motcle = 'supprimé';
                this.showAlert();
            })
            .catch(err=>console.log(err));
            $("#deleteEquipeModal").modal('toggle');
        },
        searchtxt(e) {
            let valtext = e.target.value;
            if(valtext !== ''){
                this.equipes = this.equipes.filter(equipe => (equipe.nom.includes(valtext) || equipe.mission.includes(valtext)));
            }else{
                this.equipes = this.eqs;
            }
        },
        countDownChanged(dismissCountDown) {
          this.dismissCountDown = dismissCountDown
        },
        showAlert() {
          this.dismissCountDown = this.dismissSecs;
        }
    }
}
</script>

<style>

</style>