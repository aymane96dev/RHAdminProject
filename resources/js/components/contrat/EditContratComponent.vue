<template>
    <div class="modal fade" id="editCtrtModal" tabindex="-1" role="dialog" aria-labelledby="editCtrtModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg" id="exampleModalLabel">Modifier un contrat :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <form @submit.prevent="editContrat">
                    <div class="form-group row ml-3">
                        <label class="col-sm-5 col-form-label text-sm" for="date_signature">Date du signature :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="date" name="date_signature" :max="max_date" v-model="contrat.date_signature" required/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-5 col-form-label text-sm" for="type">Type :</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" v-model="contrat.type" required>
                                <option value="Contrat à durée indéterminée">Contrat à durée indéterminée</option>
                                <option value="Contrat à durée déterminée">Contrat à durée déterminée</option>
                                <option value="Anapec">Anapec</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-5 col-form-label text-sm" for="duree">Durée :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="text" name="duree" v-model="contrat.duree" placeholder="Tapez une durée" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-5 col-form-label text-sm" for="salaire">Salaire :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="number" name="salaire" v-model="contrat.salaire" placeholder="Tapez un salaire" autocomplete="off"/>
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
    name: 'edit-contrat',
    props: ['id','contrat'],
    data(){
        return{
            max_date:new Date().toISOString().substring(0,10),
            /*contrat:{
                date_signature:'',
                type:'',
                etat:'',
                duree:'',
                salaire:'',
            }*/
        }
    },
    methods: {
         editContrat(){
            axios.put(`api/editContrat`,{
                'id':this.contrat.id,
                'date_signature':this.contrat.date_signature,
                'type':this.contrat.type,
                'duree':this.contrat.duree,
                'salaire':this.contrat.salaire,
            })
            .then(res=>res.data)
            .then(data=>{
                let vals= ('data' in data)?data.data:Object.values(data);
                this.$emit('editContrat',vals);
            })
            .catch(err=>console.log(err));
            $('#editCtrtModal').modal('toggle');
        }
    }
}
</script>

<style>

</style>