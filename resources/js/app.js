/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import BootstrapVue from 'bootstrap-vue';

require('./bootstrap');

window.Vue = require('vue');
Vue.use(BootstrapVue);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('employes-component', require('./components/employe/TabEmpComponent.vue').default);
Vue.component('users-component', require('./components/user/TabUserComponent.vue').default);
Vue.component('pointage-component', require('./components/pointage/PointageComponent.vue').default);
Vue.component('history-component', require('./components/pointage/HistoryComponent.vue').default);
Vue.component('listhistory-component', require('./components/pointage/ListHistoryComponent.vue').default);
Vue.component('addptr-component', require('./components/pointage/AddPtrComponent.vue').default);
Vue.component('delptr-component', require('./components/pointage/DelPtrComponent.vue').default);
Vue.component('editptr-component', require('./components/pointage/EditPtrComponent.vue').default);
Vue.component('cptce-list-component', require('./components/competence/ListCptceComponent.vue').default);
Vue.component('cptce-component', require('./components/competence/CptceComponent.vue').default);
Vue.component('addcptce-component', require('./components/competence/AddCptceComponent.vue').default);
Vue.component('delcptce-component', require('./components/competence/DelCptceComponent.vue').default);
Vue.component('editcptce-component', require('./components/competence/EditCptceComponent.vue').default);
Vue.component('conge-component', require('./components/conge/CongeComponent.vue').default);
Vue.component('conge-list-component', require('./components/conge/ListCongeComponent.vue').default);
Vue.component('addconge-component', require('./components/conge/AddCongeComponent.vue').default);
Vue.component('editconge-component', require('./components/conge/EditCongeComponent.vue').default);
Vue.component('demande-component', require('./components/demande_conge/DemandeComponent.vue').default);
Vue.component('demande-list-component', require('./components/demande_conge/ListDemComponent.vue').default);
Vue.component('add-demande-component', require('./components/demande_conge/AddDemandeComponent.vue').default);
Vue.component('editdemande-component', require('./components/demande_conge/EditDemandeComponent.vue').default);
Vue.component('validation-component', require('./components/demande_conge/ValidationComponent.vue').default);
Vue.component('validation-list-component', require('./components/demande_conge/ListValidationComponent.vue').default);
Vue.component('calendrier-component', require('./components/calendrier/CalendrierComponent.vue').default);
Vue.component('calendar-component', require('./components/calendrier/CalendarComponent.vue').default);
Vue.component('countconges-component', require('./components/conge/CountCongeComponent.vue').default);
Vue.component('equipe-component', require('./components/equipe/EquipeComponent.vue').default);
Vue.component('addequipe-component', require('./components/equipe/AddEquipeComponent.vue').default);
Vue.component('editequipe-component', require('./components/equipe/EditEquipeComponent.vue').default);
Vue.component('projet-component', require('./components/projet/ProjetComponent.vue').default);
Vue.component('projet-list-component', require('./components/projet/ListProjetComponent.vue').default);
Vue.component('addprojet-component', require('./components/projet/AddProjetComponent.vue').default);
Vue.component('editprojet-component', require('./components/projet/EditProjetComponent.vue').default);
Vue.component('materiel-component', require('./components/materiel/MaterielComponent.vue').default);
Vue.component('materiel-list-component', require('./components/materiel/ListMatComponent.vue').default);
Vue.component('addmateriel-component', require('./components/materiel/AddMatComponent.vue').default);
Vue.component('editmateriel-component', require('./components/materiel/EditMatComponent.vue').default);
Vue.component('solde-component', require('./components/solde/SoldeComponent.vue').default);
Vue.component('solde-list-component', require('./components/solde/ListSoldeComponent.vue').default);
Vue.component('addsolde-component', require('./components/solde/AddSoldeComponent.vue').default);
Vue.component('editsolde-component', require('./components/solde/EditSoldeComponent.vue').default);
Vue.component('contrat-component', require('./components/contrat/ContratComponent.vue').default);
Vue.component('contrat-list-component', require('./components/contrat/ListContratComponent.vue').default);
Vue.component('addctrt-component', require('./components/contrat/AddContratComponent.vue').default);
Vue.component('editctrt-component', require('./components/contrat/EditContratComponent.vue').default);
Vue.component('candidat-component', require('./components/candidat/CandidatComponent.vue').default);
Vue.component('addcddt-component', require('./components/candidat/AddCandidatCpnt.vue').default);
Vue.component('editcddt-component', require('./components/candidat/EditCandidatCpnt.vue').default);
Vue.component('entretien-component', require('./components/entretien/EntretienComponent.vue').default);
Vue.component('addentien-component', require('./components/entretien/AddEntretienCpnt.vue').default);
Vue.component('editentien-component', require('./components/entretien/EditEntretienCpnt.vue').default);
Vue.component('cancal-component', require('./components/calen_entretien/CanCalComponent.vue').default);
Vue.component('entcal-component', require('./components/calen_entretien/EntCalComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
