<template>
  <div class="row justify-content-center mb-5">
        <div class="col-xl-4 col-sm-8 mb-5 mb-xl-0 text-white" >
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
            <b-card-group deck>
                <b-card bg-variant="danger" header-bg-variant="danger" text-variant="white" header="Nombre des conges" class="text-center">
                    <b-card-text>{{ total.nbrconges }}</b-card-text>
                </b-card>

                <b-card bg-variant="default" header-bg-variant="default" text-variant="white" header="Total des soldes" class="text-center">
                    <b-card-text>{{ total.soldes }}</b-card-text>
                </b-card>

                <b-card bg-variant="success" header-bg-variant="success" text-variant="white" header="Total des jours acquis" class="text-center">
                    <b-card-text>{{ total.nbrjrs }}</b-card-text>
                </b-card>
            </b-card-group>
            <div class="mt-3">
            <b-card >
                <div class="row">
                    <h1 class="col-xl-10">Calculer le total des jours et soldes<br> de l'employé sélectionné :</h1>
                </div>
                <div class="row mt-2">
                    <div class="table-responsive">
                    <div class="table-wrapper table-light">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Type</th>
                                    <th>Nombre de jours acquis</th>
                                    <th>Solde</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark">
                                <tr v-for="conge in conges" v-bind:key="conge.id">
                                    <td>{{ conge.type }}</td>
                                    <td>{{ conge.nbr_jrs_acquis }}</td>
                                    <td>{{ conge.solde }}</td> 
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </b-card>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'count-conges',
    data() {
        return {
            employes:[],
            id:'',
            nom:'',
            prenom:'',
            statut:'',
            fullname:'',
            photoimage:'',
            conges:[],
            demandes:[],
            total:''
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
            .then(data =>{
                this.getConges();
                this.getCalculTotal();
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
            this.getConges();
            this.getCalculTotal();
        },
        getConges(){
            let id= this.id;
            axios.get(`api/checkconges/${id}`)
            .then(res => res.data.data)
            .then(data =>{
               this.conges=data;
            });
        },
        getCalculTotal(){
            let id= this.id;
            axios.get(`api/calcultotal/${id}`)
            .then(res => res.data.data)
            .then(data =>{
               this.total=data;
            });
        }
    }
}
</script>

<style>

</style>