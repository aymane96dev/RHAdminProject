<template>
  <div class="modal fade" id="editDemandeModal" tabindex="-1" role="dialog" aria-labelledby="editDemandeModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg" id="exampleModalLabel">Modifier un demande de congé {{ idprop }} :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <form @submit.prevent="addDemande">
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="date">Date de début :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="date" name="date_debut" :min="datenow" v-model="demande.date_debut" required/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="date">Date de fin :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="date" name="date_fin" :min="demande.date_debut" v-model="demande.date_fin" required/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="date">Lettre de demande écrit :</label>
                        <div class="col-sm-8">
                            <div class="custom-file">
                                <input class="custom-file-input form-control-sm" type="file" name="lettre" @change="previewFiles" accept=".doc,.docx,.pdf"/>
                                <label class="custom-file-label col-form-label-sm" for="photo" >{{ filename || this.demande.lettre_ecrit }}</label> 
                            </div> 
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="date">Commentaire :</label>
                        <div class="col-sm-6">
                            <textarea class="form-control form-control-sm" name="lettre" v-model="demande.commentaire"></textarea>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="type">Congé concerné :</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" v-model="demande.conge_id" required>
                                <option v-for="conge in conges" v-bind:key="conge.id" :value="conge.id">{{ conge.type }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ml-3" v-if="error">
                        <div class="alert alert-danger text-white">
                            une erreur inattendue est survenue.
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
    name:'edit-demande',
    props: ['idprop','conges','demande'],
    data(){
        return {
            datenow:new Date().toISOString().substring(0,10),
            filename:'',
            error:false,
            conge:{}
        }
    },
    methods: {
        previewFiles(e){
            this.demande.lettre_ecrit = e.target.files[0];
            this.filename = e.target.files[0].name;
        },
        addDemande(){
            let id= this.idprop;
            const formdata=new FormData();
            formdata.append('id',this.demande.id);
            formdata.append('date_debut',this.demande.date_debut);
            formdata.append('date_fin',this.demande.date_fin);
            formdata.append('lettre_ecrit',this.demande.lettre_ecrit);
            formdata.append('commentaire',this.demande.commentaire);
            formdata.append('etat_validation',this.demande.etat_validation);
            formdata.append('conge_id',this.demande.conge_id);
            formdata.append('employe_id',id);
            axios.post('api/editDemande',formdata,
            {
                headers: {
                    'Content-Type':'multipart/form-data'
                }
            })
            .then(res => res.data.data)
            .then(data => {
                this.$emit('editEvent',data);
                $('#editDemandeModal').modal('toggle');
                this.error=false;
            })
            .catch(err => this.error=true);
        }
    }
}
</script>

<style>

</style>