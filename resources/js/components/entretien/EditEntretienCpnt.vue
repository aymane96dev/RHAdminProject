<template>
    <div class="modal fade" id="editEntretienModal" tabindex="-1" role="dialog" aria-labelledby="editEntretienModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-lg" id="addModalLabel">Modifier un entretien:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="dropdown-divider"></div>
                <div class="modal-body text-dark">
                    <form @submit.prevent="editEntretien">
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="date">Date :</label>
                            <div class="col-sm-7">
                                <input class="form-control form-control-sm" type="datetime-local" name="date" v-model="getdate" required/>
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
                                <select class="form-control form-control-sm" v-model="entretien.id_candidat" required>
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
    name:'edit-entretien',
    props: ['entretien'],
    data() {
        return{
            candidats:[]
        }
    },
    created() {
        this.getCandidats();
    },
    computed:{
        getdate(){
            if(this.entretien.date!=null) return this.entretien.date.replace(' ','T');
        }
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
        editEntretien(){
            let newdate = this.getdate.replace('T',' ');
            let newdate1 = newdate.substring(0,16);
            axios.put('api/editEntretien',{
                'id':this.entretien.id,
                'date':newdate1,
                'description':this.entretien.description,
                'candidat_id':this.entretien.id_candidat,
            })
            .then(res => res.data)
            .then(data=>{
                let vals= ('data' in data)?data.data:Object.values(data);
                this.$emit('editEvent',vals);
            })
            .catch(err=>console.log(err));
            $("#editEntretienModal").modal('toggle');
        }
    }
}
</script>

<style>

</style>