<template>
  <div class="modal fade" id="editCptceModal" tabindex="-1" role="dialog" aria-labelledby="editCptceModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg" id="exampleModalLabel">Modifier une compétence :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <form @submit.prevent="editCptce" >
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="nom">Nom ou description :</label>
                        <div class="col-sm-6">
                            <div class="input-group" v-if="!editnom">
                                <input type="text" class="form-control" v-model="competence.nom" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text" @click="editnom = !editnom"><i class="fas fa-pen text-dark"></i></span>
                                </div>
                            </div>
                            <textarea class="form-control form-control-sm" name="nom" v-model="competence.nom" v-if="editnom" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="type">Niveau :</label>
                        <div class="col-sm-6">
                            <div class="input-group" v-if="!editniv">
                                <input type="text" class="form-control" v-model="competence.niveau" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text" @click="editniv = !editniv"><i class="fas fa-pen text-dark"></i></span>
                                </div>
                            </div>
                            <select class="form-control form-control-sm" name="niveau" v-model="competence.niveau" v-if="editniv" required>
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
                            <div class="input-group" v-if="!editcer">
                                <input type="text" class="form-control" v-model="competence.certificat" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text" @click="editcer = !editcer"><i class="fas fa-pen text-dark"></i></span>
                                </div>
                            </div>
                            <input class="form-control form-control-sm" type="text" name="certificat" v-model="competence.certificat" v-if="editcer" autocomplete="off"/>
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
    name:'edit-competence',
    props:['competence'],
    data(){
        return{
            employes:[],
            comp:{
                id:'',
                nom:'',
                niveau:'',
                certificat:'',
                id_emp:''
            },
            editnom:false,
            editniv:false,
            editcer:false
        }
    },
    methods: {
        editCptce(){
            axios.put('api/editCptce',{
                'id':this.competence.id,
                'nom':this.competence.nom,
                'niveau':this.competence.niveau,
                'certificat':this.competence.certificat,
            })
            .then(res => res.data)
            .then(data=>{
                this.$emit('EditCptceEvent',data);
                this.editnom=false;
                this.editniv=false;
                this.editcer=false;
            })
            .catch(err => console.log(err))
            $("#editCptceModal").modal('toggle');
        }
    }
}
</script>

<style>

</style>