<template>
  <div class="card mb-5">
    <div class="card-header border-0">
        <div class="row bg-white">
            <div class="col-xl-5">
                <h3 class="text-dark">L'historique des Pauses :</h3>
            </div>
            <div class="col-xl-4 col-6 col-sm-4 bg-primary mb-2 ml-3 rounded d-flex justify-content-center align-items-start">
                <div class="input-group input-group-sm input-group-alternative bg-primary" title="cherchez ici">
                    <div class="input-group-prepend bg-primary">
                        <span class="input-group-text bg-primary"><i class="fas fa-search text-white"></i></span>
                    </div>
                    <input class="form-control bg-primary text-white" type="text" id="srchtxt" placeholder="Cherchez ici" @keyup="searchtxt($event)" >
                </div>
            </div>
        </div> 
    </div>
    <div class="table-responsive">
        <div class="table-wrapper table-light">
            <div class="table-title">
            </div>
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Heure Début</th>
                        <th>Heure Fin</th>
                    </tr>
                </thead>
                <tbody class="text-dark">
                    <tr v-for="ptr in ptrs" v-bind:key="ptr.id">
                        <td>{{ ptr.libelle }}</td>
                        <td>{{ ptr.date }}</td>
                        <td>{{ ptr.heure_debut }}</td>
                        <td>{{ ptr.heure_fin }}</td>
                    </tr> 
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <div class="clearfix pl-4 py-2">
                    <ul class="pagination mt-2">
                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item" data-toggle="tooltip" data-placement="top" title="Précédent">
                            <a href="#" class="page-link" @click="fetchPtrs(pagination.prev_page_url)"><i class="fas fa-angle-double-left " style="color:cornflowerblue;"></i> &nbsp;</a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="#" style="color:cornflowerblue;">{{ pagination.current_page }}</a></li>
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item" data-toggle="tooltip" data-placement="top" title="Suivant">
                            <a href="#" class="page-link" @click="fetchPtrs(pagination.next_page_url)">&nbsp; <i class="fas fa-angle-double-right " style="color:cornflowerblue;"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name:'list-history',
    props:['idprop','ptrs','ptrsfull','ptrsbeta','pagination'],
    data() {
        return {
            
        }
    },
    methods:{
        searchtxt(e) {
            let valtext = e.target.value;
            if(valtext !== ''){
                this.ptrs = this.ptrsbeta.filter(ptr => (ptr.libelle.includes(valtext) || ptr.date.includes(valtext) 
            || ptr.heure_debut.includes(valtext) || ptr.heure_fin.includes(valtext)));
            }else{
                this.ptrs = this.ptrsfull;
            }
        }
    }
}
</script>

<style>

</style>