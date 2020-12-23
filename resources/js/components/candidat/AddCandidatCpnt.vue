<template>
    <div class="modal fade" id="addCandidatModal" tabindex="-1" role="dialog" aria-labelledby="addCandidatModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-lg" id="addModalLabel">Ajouter une équipe:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="dropdown-divider"></div>
                <div class="modal-body text-dark">
                    <form @submit.prevent="addCandidat">
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="nom">Nom :</label>
                            <div class="col-sm-6">
                                <input class="form-control form-control-sm" type="text" name="nom" v-model="candidat.nom" required/>
                            </div>
                        </div>
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="prenom">Prénom :</label>
                            <div class="col-sm-6">
                                <input class="form-control form-control-sm" type="text" name="prenom" v-model="candidat.prenom" required/>
                            </div>
                        </div>
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="num_tel">Numéro de téléphone :</label>
                            <div class="col-sm-6">
                                <input class="form-control form-control-sm" type="tel" name="num_tel" v-model="candidat.num_tel" required/>
                            </div>
                        </div>
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="email">Email :</label>
                            <div class="col-sm-6">
                                <input class="form-control form-control-sm" type="email" name="email" v-model="candidat.email" required/>
                            </div>
                        </div>
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="cv">CV :</label>
                            <div class="custom-file col-sm-6 ml-3">
                                <input class="custom-file-input form-control-sm" type="file" name="cv" @change="previewFiles($event)" accept=".doc,.docx,.pdf"/>
                                <label class="custom-file-label col-form-label-sm" for="photo" >{{filename}}</label> 
                            </div> 
                        </div>
                        <div class="form-group row ml-3">
                            <label class="col-sm-4 col-form-label text-sm" for="diplome">Diplome :</label>
                            <div class="col-sm-6">
                                <input class="form-control form-control-sm" type="text" name="diplome" v-model="candidat.diplome" required/>
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
    name: 'add-candidat',
    data() {
        return{
            candidat:{
                nom:'',
                prenom:'',
                num_tel:'',
                email:'',
                cv:'',
                diplome:''
            },
            filename:''
        }
    },
    methods: {
        previewFiles(e){
            this.candidat.cv = e.target.files[0];
            this.filename = e.target.files[0].name;
        },
        addCandidat(){
            const formdata=new FormData();
            formdata.append('nom',this.candidat.nom);
            formdata.append('prenom',this.candidat.prenom);
            formdata.append('num_tel',this.candidat.num_tel);
            formdata.append('email',this.candidat.email);
            formdata.append('cv',this.candidat.cv);
            formdata.append('diplome',this.candidat.diplome);
            axios.post('api/addCandidat',formdata,
            {
                headers: {
                    'Content-Type':'multipart/form-data'
                }
            })
            .then(res => res.data)
            .then(data => {
                let vals= ('data' in data)?data.data:Object.values(data);
                this.$emit('addEvent',vals);
                this.candidat.nom = '';
                this.candidat.prenom = '';
                this.candidat.num_tel = '';
                this.candidat.email = '';
                this.candidat.cv = '';
                this.candidat.diplome = '';
                $('#addCandidatModal').modal('toggle');
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style>

</style>