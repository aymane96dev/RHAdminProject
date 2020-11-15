<template>
    <div class="modal fade overflow-auto" id="deletePtrModal" tabindex="-1" role="dialog" aria-labelledby="deletePtrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-lg" id="exampleModalLabel">Attention!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-lg text-dark">
                    Voulez-vous supprimer cette pause ?
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button @click="deleteP(deleteid)" type="button" class="btn btn-danger">Confirmez</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulez</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'DeletePtrModal',
    props: ['deleteid'],
    data() {
        return { 
        }
    },
    methods: {
        deleteP(id){
            axios.delete(`api/deletePtr/${id}`)
            .then(res => res.data)
            .then(data =>{
                this.$emit('DeletePtrEvent',data);
                $("#deletePtrModal").modal('toggle');
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style>

</style>