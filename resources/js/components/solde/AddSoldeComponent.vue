<template>
    <div class="modal fade" id="addSoldeModal" tabindex="-1" role="dialog" aria-labelledby="addSoldeModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg" id="exampleModalLabel">Ajouter un salaire :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <form @submit.prevent="addSolde">
                    <div class="form-group row ml-3">
                        <label class="col-sm-5 col-form-label text-sm" for="libelle">Salaire :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="number" name="salaire" v-model="solde.salaire" placeholder="Tapez un salaire" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-5 col-form-label text-sm" for="date_paiement">Date du paiement :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="date" name="date_paiement" :max="max_date" v-model="solde.date_paiement" required/>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-5 col-form-label text-sm" for="type">Type du paiement :</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" v-model="solde.type_paiement" required>
                                <option value="Espèces">Espèces</option>
                                <option value="Par chèque">Par chèque</option>
                                <option value="Virement bancaire">Virement bancaire</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-5 col-form-label text-sm" for="mois">Mois :</label>
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" v-model="solde.mois" required>
                                <option value="1">Janvier</option>
                                <option value="2">Février</option>
                                <option value="3">Mars</option>
                                <option value="4">Avril</option>
                                <option value="5">Mai</option>
                                <option value="6">Juin</option>
                                <option value="7">Juillet</option>
                                <option value="8">Août</option>
                                <option value="9">Septembre</option>
                                <option value="10">Octobre</option>
                                <option value="11">Novembre</option>
                                <option value="12">Décembre</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ml-3">
                        <label class="col-sm-5 col-form-label text-sm" for="annee">Année :</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" type="number" min="2000" max="2050" step="1" name="annee" v-model="solde.annee" placeholder="Choisissez une année" autocomplete="off"/>
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
    name:'add-solde',
    props: ['id'],
    data(){
        return{
            max_date:new Date().toISOString().substring(0,10),
            solde:{
                salaire:'',
                date_paiement:'',
                type_paiement:'',
                mois:'',
                annee:new Date().getFullYear(),
            }
        }
    },
    computed:{
        employeid()
        {
            return this.id;   
        }
    },
    methods: {
        addSolde(){
            axios.post('api/addSolde',{
                'salaire':this.solde.salaire,
                'date_paiement':this.solde.date_paiement,
                'type_paiement':this.solde.type_paiement,
                'mois':parseInt(this.solde.mois),
                'annee':this.solde.annee,
                'employeid':this.employeid
            })
            .then(res => res.data)
            .then(data=>{
                let vals= ('data' in data)?data.data:Object.values(data);
                this.$emit('addEvent',vals);
                this.solde.salaire = '';
                this.solde.date_paiement = '';
                this.solde.type_paiement = '';
                this.solde.mois = '';
                this.solde.annee = new Date().getFullYear(); 
            })
            .catch(err=>console.log(err));
            $("#addSoldeModal").modal('toggle');
        }
    }
}
</script>

<style>

</style>