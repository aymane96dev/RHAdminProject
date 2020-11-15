<template>
    <div class="modal fade" id="addCptceModal" tabindex="-1" role="dialog" aria-labelledby="addCptceModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg" id="exampleModalLabel">Ajouter une compétence :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <form @submit.prevent="addCptce" >
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="nom">Nom ou description :</label>
                        <div class="col-sm-6">
                            <textarea class="form-control form-control-sm" name="nom" v-model="competence.nom" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="type">Niveau :</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" name="niveau" v-model="competence.niveau" required>
                                <option value="Debutant">Débutant</option>
                                <option value="Intermediaire">Intérmediaire</option>
                                <option value="Avance">Avancé</option>
                                <option value="Expert">Expert</option>
                            </select>
                        </div> 
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="certificat">Certificat (optionnel) :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="text" name="certificat" v-model="competence.certificat" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary" :disabled="(idemploye == null)?true:false">Enregistrez</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>  
</template>

<script>
export default {
    name:'add-competence',
    props:['idemploye'],
    data(){
        return{
            employes:[],
            competence:{
                id:'',
                nom:'',
                niveau:'',
                certificat:'',
                id_emp:''
            }
        }
    },
    methods:{
        addCptce(){
            axios.post('api/addCptce',{
                'nom':this.competence.nom,
                'niveau':this.competence.niveau,
                'certificat':this.competence.certificat,
                'id_emp':this.idemploye
            })
            .then(res => res.data)
            .then(data=>{
                this.$emit('AddCptceEvent',data);
                this.competence.nom='';
                this.competence.niveau='';
                this.competence.certificat ='';
            })
            .catch(err => console.log(err))
            $("#addCptceModal").modal('toggle');
        }
    }
}
</script>

<style>

</style>