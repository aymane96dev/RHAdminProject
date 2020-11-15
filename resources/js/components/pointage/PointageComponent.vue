<template>
<div>
    <div class="card mb-xl-5">
        <div class="card-header border-0 bg-white">
            <div class="row">
                <div class="col-xl-2 mb-2 d-none d-xl-block">
                    <span class="badge badge-default text-white">Horaire</span>
                </div>
                <div class="offset-xl-2 col-xl-4 mb-2 col-12 col-sm-6">
                    <form @submit.prevent="ongetPtr()" >
                    <input class="form-control form-control-sm text-dark" v-model="datePtr" @change="ongetPtr()" placeholder="Selectionnez une date" type="date" min="2020-01-01" v-bind:max="datenow">
                    </form>
                </div>
                <div class="col-xl-4 d-sm-flex justify-content-end align-items-start col-6 d-block">
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addPtrModal" ><i class="fas fa-plus-circle"></i> &nbsp; Ajouter une pause</button>
                </div>
                <addptr-component v-on:AddPtrEvent="UpdateAfterAdd($event)"></addptr-component>
                <delptr-component v-bind:deleteid="delete_id" v-on:DeletePtrEvent="UpdateAfterDelete($event)" ></delptr-component>
                <editptr-component v-bind:editptr="editPtr" v-on:EditPtrEvent="UpdateAfterEdit($event)" ></editptr-component>
            </div>
            <div class="row">
              <b-alert class="col-xl-12" :show="dismissCountDown" dismissible variant="success" 
              @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged">
                Votre pause a été {{ operation }} avec succès!
              </b-alert>
            </div>   
        </div>
        <table class="table table-white table-bordered table text-dark">
                    <tbody >
                      <tr >
                        <th >09:00 H</th>
                        <td class="col-10 bg-reprise text-white" v-bind:class="ptr9hcolor" v-bind:data-target="(Array.isArray(this.ptr9h) && this.ptr9h.length >= 1)?target:''" @click="ptrinfos(ptr9h)" data-toggle="modal" id="ptr9h">
                            <h1 class="text-white text-sm" v-if="Array.isArray(ptr9h) && ptr9h.length === 1">{{ ptr9h[0].heure_debut }} - {{ ptr9h[0].heure_fin }}</h1>
                            <h1 class="text-white text-sm" v-if="Array.isArray(ptr9h) && ptr9h.length > 1">09:00 - 10:00</h1>
                            <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr9h) && ptr9h.length === 1">{{ ptr9h[0].libelle }}</p>
                            <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr9h) && ptr9h.length > 1">Plusieurs pointages</p>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">10:00 H</th>
                        <td class="col-10 bg-reprise text-white" v-bind:class="ptr10hcolor" v-bind:data-target="(Array.isArray(this.ptr10h) && this.ptr10h.length >= 1)?target:''" @click="ptrinfos(ptr10h)" data-toggle="modal" id="ptr10h">
                            <h1 class="text-white text-sm" v-if="Array.isArray(ptr10h) && ptr10h.length === 1">{{ ptr10h[0].heure_debut }} - {{ ptr10h[0].heure_fin }}</h1>
                            <h1 class="text-white text-sm" v-if="Array.isArray(ptr10h) && ptr10h.length > 1">10:00 - 11:00</h1>
                            <p class="text-lg font-weight-bold " v-if="Array.isArray(ptr10h) && ptr10h.length === 1">{{ ptr10h[0].libelle }}</p>
                            <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr10h) && ptr10h.length > 1">Plusieurs pointages</p>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">11:00 H</th>
                        <td class="col-10 bg-reprise text-white" v-bind:class="ptr11hcolor" v-bind:data-target="(Array.isArray(this.ptr11h) && this.ptr11h.length >= 1)?target:''" @click="ptrinfos(ptr11h)" data-toggle="modal" id="ptr11h">
                            <h1 class="text-white text-sm" v-if="Array.isArray(ptr11h) && ptr11h.length === 1">{{ ptr11h[0].heure_debut }} - {{ ptr11h[0].heure_fin }}</h1>
                            <h1 class="text-white text-sm" v-if="Array.isArray(ptr11h) && ptr11h.length > 1">11:00 - 12:00</h1>
                            <p class="text-lg font-weight-bold " v-if="Array.isArray(ptr11h) && ptr11h.length === 1">{{ ptr11h[0].libelle }}</p>
                            <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr11h) && ptr11h.length > 1">Plusieurs pointages</p>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">12:00 H</th>
                        <td class="col-10 bg-reprise text-white" v-bind:class="ptr12hcolor" v-bind:data-target="(Array.isArray(this.ptr12h) && this.ptr12h.length >= 1)?target:''" @click="ptrinfos(ptr12h)" data-toggle="modal" id="ptr12h">
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr12h) && ptr12h.length === 1">{{ ptr12h[0].heure_debut }} - {{ ptr12h[0].heure_fin }}</h1>
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr12h) && ptr12h.length > 1">12:00 - 13:00</h1>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr12h) && ptr12h.length === 1">{{ ptr12h[0].libelle }}</p>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr12h) && ptr12h.length > 1">Plusieurs pointages</p>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">13:00 H</th>
                        <td class="col-10 bg-reprise text-white"  v-bind:class="ptr13hcolor" v-bind:data-target="(Array.isArray(this.ptr13h) && this.ptr13h.length >= 1)?target:''" @click="ptrinfos(ptr13h)" data-toggle="modal" id="ptr13h">
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr13h) && ptr13h.length === 1">{{ ptr13h[0].heure_debut }} - {{ ptr13h[0].heure_fin }}</h1>
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr13h) && ptr13h.length > 1">13:00 - 14:00</h1>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr13h) && ptr13h.length === 1">{{ ptr13h[0].libelle }}</p>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr13h) && ptr13h.length > 1">Plusieurs pointages</p>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">14:00 H</th>
                        <td class="col-10 bg-reprise text-white"  v-bind:class="ptr14hcolor" v-bind:data-target="(Array.isArray(this.ptr14h) && this.ptr14h.length >= 1)?target:''" @click="ptrinfos(ptr14h)" data-toggle="modal" id="ptr14h">
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr14h) && ptr14h.length === 1">{{ ptr14h[0].heure_debut }} - {{ ptr14h[0].heure_fin }}</h1>
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr14h) && ptr14h.length > 1">14:00 - 15:00</h1>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr14h) && ptr14h.length === 1">{{ ptr14h[0].libelle }}</p>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr14h) && ptr14h.length > 1">Plusieurs pointages</p>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">15:00 H</th>
                        <td class="col-10 bg-reprise text-white" v-bind:class="ptr15hcolor" v-bind:data-target="(Array.isArray(this.ptr15h) && this.ptr15h.length >= 1)?target:''" @click="ptrinfos(ptr15h)" data-toggle="modal" id="ptr15h">
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr15h) && ptr15h.length === 1">{{ ptr15h[0].heure_debut }} - {{ ptr15h[0].heure_fin }}</h1>
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr15h) && ptr15h.length > 1">15:00 - 16:00</h1>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr15h) && ptr15h.length === 1">{{ ptr15h[0].libelle }}</p>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr15h) && ptr15h.length > 1">Plusieurs pointages</p>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">16:00 H</th>
                        <td class="col-10 bg-reprise text-white" v-bind:class="ptr16hcolor" v-bind:data-target="(Array.isArray(this.ptr16h) && this.ptr16h.length >= 1)?target:''" @click="ptrinfos(ptr16h)" data-toggle="modal" id="ptr16h">
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr16h) && ptr16h.length === 1">{{ ptr16h[0].heure_debut }} - {{ ptr16h[0].heure_fin }}</h1>
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr16h) && ptr16h.length > 1">16:00 - 17:00</h1>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr16h) && ptr16h.length === 1">{{ ptr16h[0].libelle }}</p>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr16h) && ptr16h.length > 1">Plusieurs pointages</p>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">17:00 H </th>
                        <td class="col-10 bg-reprise text-white" v-bind:class="ptr17hcolor" v-bind:data-target="(Array.isArray(this.ptr17h) && this.ptr17h.length >= 1)?target:''" @click="ptrinfos(ptr17h)" data-toggle="modal" id="ptr13h">
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr17h) && ptr17h.length === 1">{{ ptr17h[0].heure_debut }} - {{ ptr17h[0].heure_fin }}</h1>
                          <h1 class="text-white text-sm" v-if="Array.isArray(ptr17h) && ptr17h.length > 1">17:00 - 18:00</h1>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr17h) && ptr17h.length === 1">{{ ptr17h[0].libelle }}</p>
                          <p class="text-lg font-weight-bold" v-if="Array.isArray(ptr17h) && ptr17h.length > 1">Plusieurs pointages</p>
                        </td>
                      </tr>
                    </tbody>
        </table>
    </div>
    <div class="modal fade" id="RowModal" tabindex="-1" role="dialog" aria-labelledby="RowModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-lg">les informataions des pointages valables</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark">
                <table class="table table-bordered table-responsive">
                  <thead>
                    <tr>
                      <th scope="col">Employé</th>
                      <th scope="col">Date de pointage</th>
                      <th scope="col">Type</th>
                      <th scope="col">Temps de début</th>
                      <th scope="col">Temps de fin</th>
                      <th scope="col">Opérations</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="p in ptrsModal" v-bind:key="p.fullname">
                      <td>{{ p.fullname }}</td>
                      <td>{{ p.date }}</td>
                      <td>{{ p.libelle }}</td>
                      <td>{{ p.temps_debut }}</td>
                      <td>{{ p.temps_fin }}</td>
                      <td class="text-white">
                        <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletePtrModal" @click="handleDelete(p.id)">Supprimer</a>
                        <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#editPtrModal" @click="handleEdit(p)">Modifier</a>
                      </td>
                    </tr>
                  </tbody>
                </table>

            </div>
        </div>
    </div>
    </div>
</div>
</template>

<script>
export default {
    name:'pointage-component',
    data() {
        return {
            datenow:new Date().toISOString().substring(0,10),
            datePtr:'',
            pointers2day:[],
            pointersfull:[],
            ptr9h:'',
            ptr10h:'',
            ptr11h:'',
            ptr12h:'',
            ptr13h:'',
            ptr14h:'',
            ptr15h:'',
            ptr16h:'',
            ptr17h:'',
            ptr9hcolor:'',
            ptr10hcolor:'',
            ptr11hcolor:'',
            ptr12hcolor:'',
            ptr13hcolor:'',
            ptr14hcolor:'',
            ptr15hcolor:'',
            ptr16hcolor:'',
            ptr17hcolor:'',
            target:'#RowModal',
            ptrsModal:[],
            delete_id:'',
            editPtr:'',
            dismissSecs: 10,
            dismissCountDown: 0,
            operation:'',
            error:'' 
        };
    },
    created() {
        this.getPointers2day();
    },
    methods: {
        getPointers2day(){
            axios.get('api/pointers2day')
            .then(res => res.data.data)
            .then(data => {
              this.ptr9h = data.neufh;
              this.ptr10h = data.dixh;
              this.ptr11h = data.onzeh;
              this.ptr12h = data.douzeh;
              this.ptr13h = data.treizeh;
              this.ptr14h = data.quatorzeh;
              this.ptr15h = data.quinzeh;
              this.ptr16h = data.seizeh;
              this.ptr17h = data.dixsepth;
              this.ptr9hcolor = data.neufhcolor;
              this.ptr10hcolor = data.dixhcolor;
              this.ptr11hcolor = data.onzehcolor;
              this.ptr12hcolor = data.douzehcolor;
              this.ptr13hcolor = data.treizehcolor;
              this.ptr14hcolor = data.quatorzehcolor;
              this.ptr15hcolor = data.quinzehcolor;
              this.ptr16hcolor = data.seizehcolor;
              this.ptr17hcolor = data.dixsepthcolor;
            })
            .catch(error => this.error=error)
        },
        ongetPtr(){
          axios.post('api/pointersfull',{
            'date': this.datePtr
          })
          .then(res => res.data.data)
          .then(data =>{
              this.ptr9h = data.neufh;
              this.ptr10h = data.dixh;
              this.ptr11h = data.onzeh;
              this.ptr12h = data.douzeh;
              this.ptr13h = data.treizeh;
              this.ptr14h = data.quatorzeh;
              this.ptr15h = data.quinzeh;
              this.ptr16h = data.seizeh;
              this.ptr17h = data.dixsepth;
              this.ptr9hcolor = data.neufhcolor;
              this.ptr10hcolor = data.dixhcolor;
              this.ptr11hcolor = data.onzehcolor;
              this.ptr12hcolor = data.douzehcolor;
              this.ptr13hcolor = data.treizehcolor;
              this.ptr14hcolor = data.quatorzehcolor;
              this.ptr15hcolor = data.quinzehcolor;
              this.ptr16hcolor = data.seizehcolor;
              this.ptr17hcolor = data.dixsepthcolor;
          })
          .catch(error => console.log(error));

        },
        ptrinfos(ptr){
          if(Array.isArray(ptr) && ptr.length >= 1){
            var ids=[];
            ptr.forEach(p => ids.push(p.id_employe));
            axios.post('api/PtrInfos',{
            'ids': ids
            })
            .then(res => res.data)
            .then(data =>{
              this.ptrsModal = [];
              ptr.forEach((pr,i) => {
                let p = {id:pr.id,fullname:data[i],date:pr.date,temps_debut:pr.heure_debut,temps_fin:pr.heure_fin,libelle:pr.libelle};
                this.ptrsModal.push(p);
              });
            })
          }
        },
        UpdateAfterAdd(ptr){
          if(this.datePtr === ptr.date){
            this.ongetPtr();
            this.operation = 'ajouté';
            this.showAlert();
          }else if(this.datenow === ptr.date){
            this.getPointers2day();
            this.operation = 'ajouté';
            this.showAlert();
          }
        },
        UpdateAfterEdit(ptr){
          if(this.datePtr === ptr.date){
            this.ongetPtr();
            this.operation = 'modifié';
            this.showAlert();
          }else if(this.datenow === ptr.date){
            this.getPointers2day();
            this.operation = 'modifié';
            this.showAlert();
          }
        },
        handleDelete(id){
          $('#RowModal').modal('hide');
          this.delete_id = id;
          $('#deletePtrModal').modal('show');
        },
        handleEdit(p){
          $('#RowModal').modal('hide');
          this.editPtr = p;
          $('#editPtrModal').modal('show');
        },
        UpdateAfterDelete(id){
          if(this.datePtr === this.datenow){
            this.getPointers2day();
            this.operation = 'supprimé';
            this.showAlert();
          }else{
            this.ongetPtr();
            this.operation = 'supprimé';
            this.showAlert();
          }
        },
        countDownChanged(dismissCountDown) {
          this.dismissCountDown = dismissCountDown
        },
        showAlert() {
          this.dismissCountDown = this.dismissSecs;
        }
    }
}
</script>

<style scoped>
.bg-reprise{
    background-color:#f5f5f5;
}

.bg-custom-purple{
    background-color:hsl(271, 23%, 26%);
}

.bg-custom-grey{
    background-color: hsl(199, 25%, 46%);
}


</style>