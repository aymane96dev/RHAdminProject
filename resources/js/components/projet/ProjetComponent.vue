<template>
  <div class="row justify-content-center mb-5">
        <div class="col-xl-4 col-sm-8 mb-5 mb-xl-0 text-white" >
            <div class="card">
                <div class="card-body text-dark">
                    <h5 class="card-title text-xl">Equipe :</h5>
                    <select class="form-control form-control-sm" @change="changeequipe()" required>
                        <option v-for="equipe in equipes" v-bind:key="equipe.id" :value="equipe.id" ref="equipeoption">{{ equipe.nom }}</option>
                    </select>
                    <p class="card-text mt-3">Cette liste montre les informations de l'équipe sélectionné et leurs employés associés.</p>
                </div>
                <ul class="list-group">
                  <li class="list-group-item text-dark font-weight-bold"><label>Nom :</label> &nbsp;{{ nom }}</li>
                  <li class="list-group-item text-dark font-weight-bold"><label>Mission :</label> &nbsp;{{ mission }}</li>
                  <li class="list-group-item text-dark font-weight-bold"><label>Employés :</label> &nbsp;<a class="text-center text-primary" @click="showEmployes()">Afficher la liste</a></li>
                </ul>
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
        <div class="col-xl-8 mb-5 mb-xl-0 text-white">
            <projet-list-component :idprop="equipe_id" :projets="projets" v-on:addProjet="ProjetHandler($event)" v-on:editProjet="ProjetHandler($event)" v-on:delProjet="ProjetHandler($event)" ></projet-list-component>
        </div>
    </div>
</template>

<script>
export default {
    name:'projet-component',
    data(){
        return{
            modalShow:false,
            equipes:[],
            projets:[],
            employes:[],
            equipe_id:'',
            nom:'',
            mission:''
        }
    },
    created() {
        this.getEquipes();
    },
    methods: {
        getEquipes(){
            axios.get('api/equipes')
            .then(res => res.data.data)
            .then(data=>{
                this.equipes = data;
                this.nom = this.equipes[0].nom;
                this.mission = this.equipes[0].mission;
                this.equipe_id = this.equipes[0].id;
            })
            .then(data=>this.getProjets())
            .catch(err => console.log(err));
        },
        changeequipe(){
            let selected = this.$refs.equipeoption.filter(opt => opt.selected === true);
            let val = parseInt(selected[0].value);
            let equipe={};
            this.equipes.forEach(e =>{ if(e.id === val){equipe = e;} });
            this.equipe_id = equipe.id;
            this.nom = equipe.nom;
            this.mission = equipe.mission;
            this.getProjets();
        },
        showEmployes(){
            axios.get(`api/getEmpsEquipe/${this.equipe_id}`)
            .then(res => res.data.data)
            .then(data=>{
                this.employes = data;
            })
            .catch(err => console.log(err));
            this.modalShow=true; 
        },
        getProjets(){
            axios.get(`api/projets/${this.equipe_id}`)
            .then(res=>res.data.data)
            .then(data=>{
                this.projets = data;
            })
            .catch(err=>console.log(err))
        },
        ProjetHandler(data){
            this.getProjets();
        }
    }
}
</script>

<style>

</style>