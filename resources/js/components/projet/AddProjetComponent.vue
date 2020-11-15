<template>
  <div class="modal fade" id="addProjetModal" tabindex="-1" role="dialog" aria-labelledby="addProjetModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg" id="exampleModalLabel">Ajouter un projet :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <form @submit.prevent="addProjet">
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="date">Description :</label>
                        <div class="col-sm-6">
                            <textarea class="form-control form-control-sm" name="description" v-model="projet.description" placeholder="Tapez une description"></textarea>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="date">Date de création :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="date" name="date_creation" :min="datenow" v-model="projet.date_creation" required/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="date">Date de livraison :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="date" name="date_livraison" :min="projet.date_creation" v-model="projet.date_livraison" required/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="type">Etat :</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" v-model="projet.etat" required>
                                <option>En planification</option>
                                <option>En construction</option>
                                <option>terminé</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-start">
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
    name:'add-projet',
    props:['id'],
    data(){
        return{
            datenow:new Date().toISOString().substring(0,10),
            projet:{
                description:'',
                date_creation:'',
                date_livraison:'',
                etat:''
            }
        }
    },
    computed: {
        equipeid() {
            return this.id;
        }
    },
    methods:{
        addProjet(){
            axios.post('api/addProjet',{
                'description':this.projet.description,
                'date_creation':this.projet.date_creation,
                'date_livraison':this.projet.date_livraison,
                'etat':this.projet.etat,
                'equipe_id':this.equipeid
            })
            .then(res=>res.data.data)
            .then(data=>{
                this.$emit('addProjet',data);
                this.projet.description = '';
                this.projet.date_creation = '';
                this.projet.date_livrasion = '';
                this.projet.etat = '';
            })
            .catch(err=>console.log(err));
            $('#addProjetModal').modal('toggle');
        }
    }
}
</script>

<style>

</style>