<template>
    <b-card >
        <div class="row">
           <h1 class="col-xl-8">Calendrier des congé pour l'employé sélectionné :</h1>
           <div class="col-xl-12 mt-3">
                <div class="row">
                    <div class="col-sm-4 text-dark"><i class="fas fa-square text-info"></i>&nbsp;Congé validée</div>
                </div>
           </div>
        </div>
        <div class="row mt-3 d-flex justify-content-center">
            <b-calendar block locale="fr-FR" :date-info-fn="dateColor" ></b-calendar>
        </div>
    </b-card>
</template>

<script>
export default {
    name:'calendar',
    props:['idprop','conges','demandes'],
    data(){
        return {
            dems:[]
        }
    },
    created(){
        
    },
    methods: {
        dateColor(ymd,date){
            let dateday = Number(date.getDate());
            let datemonth = date.getMonth();
            let dateyear = date.getFullYear();
            let etat=this.getdemande(dateday,datemonth,dateyear);
            return etat==true?'table-info':'';
        },
        getdemande(jour,mois,annee){
            var e=false;
            for(var i=0;i<this.demandes.length;i++){
                    let datedebut=new Date(this.demandes[i].date_debut);
                    let datefin=new Date(this.demandes[i].date_fin);
                    let jourdebut = Number(datedebut.getDate());
                    let moisdebut = datedebut.getMonth();
                    let anneedebut = datedebut.getFullYear();
                    let jourfin = Number(datefin.getDate());
                    let moisfin = datefin.getMonth();
                    let anneefin = datefin.getFullYear();
                    let dateday= Number(jour);
                    if(annee===anneedebut && annee===anneefin && mois===moisdebut && mois===moisfin
                    && dateday>=jourdebut && dateday<=jourfin ){
                        e=true;
                    }
            }
            return e;
        }
    }
}
</script>

<style scoped>

</style>