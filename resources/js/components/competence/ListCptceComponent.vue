<template>
    <div class="row justify-content-center mb-5">
        <div class="col-xl-4 mb-5 mb-xl-0 text-white" >
            <div class="card ">
                <img class="card-img-top" width="200px" height="200px" :src="photoimage" alt="Image Introuvable"/>
                <div class="card-body text-dark">
                    <h5 class="card-title text-xl">Employé :</h5>
                    <select class="form-control form-control-sm" @change="changeimg()" required>
                            <option v-for="emp in employes" v-bind:key="emp.id" :value="emp.id" ref="empoption" >{{ emp.prenom }} {{ emp.nom }}</option>
                    </select>
                    <p class="card-text mt-3">Cette liste montre les informations de l'employé sélectionné.</p>
                </div>
                <ul class="list-group">
                  <li class="list-group-item text-dark font-weight-bold"><label>Nom :</label> &nbsp; {{ nom }}</li>
                  <li class="list-group-item text-dark font-weight-bold"><label>Prénom :</label> &nbsp; {{ prenom }}</li>
                  <li class="list-group-item text-dark font-weight-bold"><label>Statut :</label> &nbsp; {{ statut }}</li>
                </ul>
            </div>
        </div>
        <div class="col-xl-8 mb-5 mb-xl-0 text-white">
            <cptce-component :idprop="id" :cptces="competences" v-on:AddEvent="UpdateAfter($event)" v-on:DelEvent="UpdateAfter($event)" v-on:EditEvent="UpdateAfter($event)" ></cptce-component>
        </div>
    </div>
</template>

<script>
export default {
    name:'list-competences',
    data() {
        return {
            employes:[],
            id:'',
            nom:'',
            prenom:'',
            statut:'',
            photoimage:'',
            competences:[] 
        };
    },
    created() {
        this.fetchFullEmployes();
    },
    methods: {
        fetchFullEmployes(){
            fetch('api/employesfull')
            .then(res => res.json())
            .then(res => {
                    this.employes = res.data;
                    this.photoimage = "storage/images/"+this.employes[0].photo;
                    this.nom = this.employes[0].nom;
                    this.prenom = this.employes[0].prenom;
                    this.statut = this.employes[0].statut;
                    this.id = this.employes[0].id; 
            })
            .then(res =>{
                this.getCompetences();
            })
            .catch(err => console.log(err));
        },
        changeimg(){
            let selected = this.$refs.empoption.filter(opt => opt.selected === true);
            let val = parseInt(selected[0].value);
            var image = ''; var emp = '';
            this.employes.forEach(emp =>{ if(emp.id === val){image = emp.photo;} });
            this.employes.forEach(e =>{ if(e.id === val){emp = e;} });
            this.id = emp.id;
            this.nom = emp.nom;
            this.prenom = emp.prenom;
            this.statut = emp.statut; 
            this.photoimage = "storage/images/"+image;
            this.getCompetences();
        },
        getCompetences(){
            axios.get(`api/competences/${this.id}`)
            .then(res => res.data.data)
            .then(data =>{
                this.competences = data;
            })
            .catch(error => console.log(error))
        },
        UpdateAfter(cptce){
            this.getCompetences();
        },
    }
}
</script>

<style>

</style>