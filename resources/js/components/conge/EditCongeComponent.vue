<template>
  <div class="modal fade" id="editCongeModal" tabindex="-1" role="dialog" aria-labelledby="editCongeModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg" id="exampleModalLabel">Ajouter un congé {{ conge.id }} :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <form @submit.prevent="editConge">
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="type">Type :</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" v-model="conge.type" required>
                                <option value="Congé Annuel">Congé Annuel</option>
                                <option value="Congé de maladie">Congé de maladie</option>
                                <option value="Congé de maternité">Congé de maternité</option>
                                <option value="Congé exceptionnel">Congé exceptionnel</option>
                                <option value="Accident de travail">Accident de travail</option>
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
    name:'edit-conge',
    props: ['conge'],
    data(){
        return {
           conge_id:'' 
        }
    },
    methods:{
        editConge(){
            axios.put('api/editConge',{
                'id':this.conge.id,
                'type':this.conge.type
            })
            .then(res => res.data.data)
            .then(data=>{
                this.$emit('editcongeevent',data);
            })
            .catch(err=>console.log(err));
            $("#editCongeModal").modal('toggle');
        }
    }
}
</script>

<style>

</style>