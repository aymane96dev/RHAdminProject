<template>
  <div class="modal fade" id="editMaterielModal" tabindex="-1" role="dialog" aria-labelledby="addMatModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg" id="exampleModalLabel">Modifier un matériel :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <form @submit.prevent="editMateriel">
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="libelle">Libellé :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="text" name="libelle" v-model="materiel.libelle" placeholder="Tapez une libellé" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="matricule">Matricule :</label>
                        <div class="col-sm-6">
                            <textarea class="form-control form-control-sm" name="matricule" v-model="materiel.matricule" placeholder="Tapez un matricule"></textarea>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="date_achat">Date d'achat :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="date" name="date_achat" v-model="materiel.date_achat" required/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="serie">Série :</label>
                        <div class="col-sm-6">
                            <textarea class="form-control form-control-sm" name="serie" v-model="materiel.serie" placeholder="Tapez une serie"></textarea>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="type">Type :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="text" name="type" v-model="materiel.type" placeholder="Tapez un type" autocomplete="off"/>
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
    name:'edit-materiel',
    props: ['id','materiel'],
    data(){
        return{
            
        }
    },
    computed: {
        employeid() {
            return this.id;
        }
    },
    methods: {
        editMateriel(){
            axios.put('api/editMateriel',{
                'id':this.materiel.id,
                'libelle':this.materiel.libelle,
                'matricule':this.materiel.matricule,
                'date_achat':this.materiel.date_achat,
                'serie':this.materiel.serie,
                'type':this.materiel.type,
            })
            .then(res => res.data)
            .then(data =>{
                let vals= ('data' in data)?data.data:Object.values(data);
                this.$emit('editMatEvent',vals);
            })
            .catch(err => console.log(err))
            $("#editMaterielModal").modal('toggle');
        }
    }
}
</script>

<style>

</style>