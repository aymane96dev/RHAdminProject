<template>
    <div class="row justify-content-center mb-5">
        <div class="col-xl-4 col-sm-8 mb-5 mb-xl-0 text-white" >
            <div class="card ">
                <div class="card-body text-dark">
                    <h5 class="card-title text-xl">Candidat :</h5>
                    <select class="form-control form-control-sm" @change="changecan()" required>
                            <option v-for="can in candidats" v-bind:key="can.id" :value="can.id" ref="canoption" >{{ can.prenom }} {{ can.nom }}</option>
                    </select>
                    <p class="card-text mt-3">Cette liste montre les informations du candidat sélectionné.</p>
                </div>
                <ul class="list-group">
                    <li class="list-group-item text-dark font-weight-bold"><label>Id :</label> &nbsp; {{ id }}</li>
                  <li class="list-group-item text-dark font-weight-bold"><label>Nom :</label> &nbsp; {{ nom }}</li>
                  <li class="list-group-item text-dark font-weight-bold"><label>Prénom :</label> &nbsp; {{ prenom }}</li>
                  <li class="list-group-item text-dark font-weight-bold"><label>Dîplome :</label> &nbsp; {{ diplome }}</li>
                </ul>
            </div>
        </div>
        <div class="col-xl-8 mb-5 mb-xl-0 text-white">
            <entcal-component :entretien="entretien" :fullname="fullname"></entcal-component>
        </div>
    </div>
</template>

<script>
export default {
    name:'cancal-component',
    data() {
        return {
            candidats:[],
            id:'',
            nom:'',
            prenom:'',
            diplome:'',
            fullname:'',
            id_entretien:'',
            entretien:{}
        };
    },
    created() {
        this.fetchFullCandidats();
    },
    methods: {
        fetchFullCandidats(){
            fetch('api/fullcandidats')
            .then(res => res.json())
            .then(res => {
                    this.candidats = res.data;
                    this.nom = this.candidats[0].nom;
                    this.prenom = this.candidats[0].prenom;
                    this.diplome = this.candidats[0].diplome;
                    this.id = this.candidats[0].id;
                    this.fullname = this.candidats[0].nom+' '+this.candidats[0].prenom;
                    this.id_entretien = this.candidats[0].id_entretien;  
            })
            .then(data =>{
                this.getEntretien();
            })
            .catch(err => console.log(err));
        },
        changecan(){
            let selected = this.$refs.canoption.filter(opt => opt.selected === true);
            let val = parseInt(selected[0].value);
            var can = '';
            this.candidats.forEach(c =>{ if(c.id === val){can = c;} });
            this.id = can.id;
            this.nom = can.nom;
            this.prenom = can.prenom;
            this.diplome = can.diplome;
            this.id_entretien = can.id_entretien;
            this.fullname = can.nom+' '+can.prenom; 
            this.getEntretien();
        },
        getEntretien(){
            axios.get(`api/getentretien/${this.id_entretien}`)
            .then(res=>res.data)
            .then(data=>{
                this.entretien = data.data;
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style>

</style>