<template>
    <div class="modal fade" id="addEntretienModal" tabindex="-1" role="dialog" aria-labelledby="addEntretienModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-lg" id="addModalLabel">Ajouter un entretien:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="dropdown-divider"></div>
                <div class="modal-body text-dark">
                    <form @submit.prevent="addEntretien">
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="date">Date :</label>
                            <div class="col-sm-7">
                                <input class="form-control form-control-sm" type="datetime-local" name="date" v-model="entretien.date" required/>
                            </div>
                        </div>
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="description">Description :</label>
                            <div class="col-sm-7">
                                <textarea class="form-control form-control-sm" name="description" v-model="entretien.description" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="contrat">Candidat :</label>
                            <div class="col-sm-7">
                                <select class="form-control form-control-sm" id="type" v-model="entretien.candidat" required>
                                    <option v-for="candidat in candidats" :key="candidat.id" :value="candidat.id">{{candidat.nom}} {{candidat.prenom}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row ml-4">
                            <button type="submit" class="btn btn-primary">Enregistrez</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'add-entretien',
    data() {
        return{
            entretien:{
                date:'',
                description:'',
                candidat:''
            },
            candidats:[]
        }
    },
    created() {
        this.getCandidats();
    },
    methods:{
        getCandidats(){
            axios.get('api/fullcandidats')
            .then(res=> res.data)
            .then(data=>{
                this.candidats = data.data; 
            })
            .catch(err=>console.log(err))
        },
        addEntretien(){
            let newdate = this.entretien.date.replace('T',' ');
            axios.post('api/addEntretien',{
                'date':newdate,
                'description':this.entretien.description,
                'candidat_id':this.entretien.candidat,
            })
            .then(res => res.data)
            .then(data=>{
                let vals= ('data' in data)?data.data:Object.values(data);
                this.$emit('addEvent',vals);
                this.entretien.date = '';
                this.entretien.description = '';
                this.entretien.candidat = '';
            })
            .catch(err=>console.log(err));
            $("#addEntretienModal").modal('toggle');
        }
    }
}
</script>

<style>

</style>