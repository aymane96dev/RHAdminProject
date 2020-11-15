<template>
  <div>
    <b-card >
        <div class="row">
           <h1 class="col-xl-8">Les compétences de l'employé sélectionné :</h1>
           <div class="col-xl-4 d-flex justify-content-end mb-5">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addCptceModal">
                    <i class="fas fa-plus-circle"></i> &nbsp; Ajouter une compétence
                </button>
           </div>
        </div>
        <div class="row" v-for="err in error" v-bind:key="err.value">
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="danger" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" v-if="error !== '' && Array.isArray(err)" >
                <span v-for="e in err" v-bind:key="e.value" > {{ e }}</span>
            </b-alert>
            <b-alert class="col-xl-12 mt-2" :show="dismissCountDown" dismissible variant="success" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged" v-if="error !== '' && !Array.isArray(err)" >
                la compétence a été {{ motcle }} avec succès
            </b-alert>
        </div>
        <small class="text-primary">vous devez cliquer sur l'élément pour le modifier où avoir plus d'informations.</small>
        <b-aspect class="text-xl mt-2 bg-translucent-secondary p-2 border border-primary" :aspect="aspect" id="aspect">
            <span class="badge badge-pill badge-danger mx-1" v-for="cptce in cptces" v-bind:key="cptce.id">
                <span  @click="passcomp(cptce)" data-toggle="modal" data-target="#editCptceModal" id="comptext">{{ cptce.nom }} &nbsp;</span>
                <button type="button" class="close" aria-label="Close" data-toggle="modal" data-target="#deleteCptceModal" @click="passid(cptce.id)">
                    <span aria-hidden="true">&times;</span>
                </button>
            </span>
        </b-aspect>
    </b-card>
    <addcptce-component :idemploye="idprop" v-on:AddCptceEvent="UpdateAfterAdd($event)"></addcptce-component>
    <delcptce-component :idemp="idprop" :idcomp="comp_id" v-on:DelCptceEvent="UpdateAfterDel($event)"></delcptce-component>
    <editcptce-component :competence="competence" v-on:EditCptceEvent="UpdateAfterEdit($event)" ></editcptce-component>
  </div>
</template>

<script>
export default {
    name:'competence',
    props: ['idprop','cptces'],
    data(){
        return {
            aspect:'3:1',
            comp_id:'',
            competence:{},
            dismissSecs: 10,
            dismissCountDown: 0,
            motcle:'',
            error:''
        }
    },
    created() {
        this.passid(7);
    },
    methods: {
        UpdateAfterAdd(cptce){
            this.$emit('AddEvent',cptce);
            this.error = Object.values(cptce);
            this.motcle='ajouté';
            this.showAlert();
        },
        UpdateAfterDel(cptce){
            this.$emit('DelEvent',cptce);
            this.error = Object.values(cptce);
            this.motcle='supprimé';
            this.showAlert();
        },
        UpdateAfterEdit(cptce){
            this.$emit('EditEvent',cptce);
            this.error = Object.values(cptce);
            this.motcle='modifié';
            this.showAlert();
        },
        passid(id){
           this.comp_id = id;
        },
        passcomp(c){
           this.competence = c;
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert() {
            this.dismissCountDown = this.dismissSecs
        }
    }
}
</script>

<style scoped>
#aspect{
    overflow: auto;
}
#comptext{
    cursor: pointer;
}
</style>