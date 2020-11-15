<template>
    <div class="modal fade" id="addCongeModal" tabindex="-1" role="dialog" aria-labelledby="addCongeModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg" id="exampleModalLabel">Ajouter un congé :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <form @submit.prevent="addConge">
                    <div class="form-group row ml-3">
                        <label class="col-sm-4 col-form-label text-sm" for="type">Type :</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="type" v-model="conge.type" required>
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
    name:'add-conge',
    props: ['idprop'],
    data(){
        return {
            conge:{
                type:'',
                id_emp:''
            }
        }
    },
    methods: { 
        addConge(){
            this.conge.id_emp = this.idprop;
            axios.post('api/addConge',this.conge)
            .then(res => res.data.data)
            .then(data =>{
                console.log(data);
                this.$emit('addcongeevent',data);
                this.conge.type='';
            })
            .catch(error=> console.log(error));
            $("#addCongeModal").modal('toggle');
        } 
    }
}
</script>

<style>

</style>