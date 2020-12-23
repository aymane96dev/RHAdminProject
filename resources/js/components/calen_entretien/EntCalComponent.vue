<template>
<div class="card mb-xl-5">
    <div class="card-header border-0 bg-white">
        <div class="row">
            <div class="col-xl-2 mb-2 d-none d-xl-block">
                <span class="badge badge-default text-white">Horaire</span>
            </div>
            <div class="offset-xl-2 col-xl-4 mb-2 col-12 col-sm-6">
                <form @submit.prevent="ongetPtr()" >
                <input class="form-control form-control-sm text-dark" v-model="getDate" @change="ongetPtr()" placeholder="Selectionnez une date" type="date">
                </form>
            </div>
        </div>   
    </div>
    <table class="table table-white table-bordered table text-dark">
        <tbody >
            <tr>
            <th scope="row">08:00 H</th>
            <td class="col-10 bg-reprise text-white" :class="(getTime === 8)?'bg-primary':'bg-secondary'">
                <h1 class="text-white text-sm" v-if="(getTime === 8)">08:00 - 09:00</h1>
                <p class="text-lg font-weight-bold" v-if="(getTime === 8)">{{ fullname }}</p>
            </td>
            </tr>
            <tr>
            <th scope="row">09:00 H</th>
            <td class="col-10 bg-reprise text-white" :class="(getTime === 9)?'bg-primary':'bg-secondary'">
                <h1 class="text-white text-sm" v-if="(getTime === 9)">09:00 - 10:00</h1>
                <p class="text-lg font-weight-bold" v-if="(getTime === 9)">{{ fullname }}</p>
            </td>
            </tr>
            <tr>
            <th scope="row">10:00 H</th>
            <td class="col-10 bg-reprise text-white" :class="(getTime === 10)?'bg-primary':'bg-secondary'">
                <h1 class="text-white text-sm" v-if="(getTime === 10)">10:00 - 11:00</h1>
                <p class="text-lg font-weight-bold" v-if="(getTime === 10)">{{ fullname }}</p>
            </td>
            </tr>
            <tr>
            <th scope="row">11:00 H</th>
            <td class="col-10 bg-reprise text-white" :class="(getTime === 11)?'bg-primary':'bg-secondary'">
                <h1 class="text-white text-sm" v-if="(getTime === 11)">11:00 - 12:00</h1>
                <p class="text-lg font-weight-bold" v-if="(getTime === 11)">{{ fullname }}</p>
            </td>
            </tr>
            <tr>
            <th scope="row">12:00 H</th>
            <td class="col-10 bg-reprise text-white" :class="(getTime === 12)?'bg-primary':'bg-secondary'">
                <h1 class="text-white text-sm" v-if="(getTime === 12)">12:00 - 13:00</h1>
                <p class="text-lg font-weight-bold" v-if="(getTime === 12)">{{ fullname }}</p>
            </td>
            </tr>
            <tr>
            <th scope="row">13:00 H</th>
            <td class="col-10 bg-reprise text-white"  :class="(getTime === 13)?'bg-primary':'bg-secondary'">
                <h1 class="text-white text-sm" v-if="(getTime === 13)">13:00 - 14:00</h1>
                <p class="text-lg font-weight-bold" v-if="(getTime === 13)">{{ fullname }}</p>
            </td>
            </tr>
            <tr>
            <th scope="row">14:00 H</th>
            <td class="col-10 bg-reprise text-white"  :class="(getTime === 14)?'bg-primary':'bg-secondary'">
                <h1 class="text-white text-sm" v-if="(getTime === 14)">14:00 - 15:00</h1>
                <p class="text-lg font-weight-bold" v-if="(getTime === 14)">{{ fullname }}</p>
            </td>
            </tr>
            <tr>
            <th scope="row">15:00 H</th>
            <td class="col-10 bg-reprise text-white" :class="(getTime === 15)?'bg-primary':'bg-secondary'">
                <h1 class="text-white text-sm" v-if="(getTime === 15)">15:00 - 16:00</h1>
                <p class="text-lg font-weight-bold" v-if="(getTime === 15)">{{ fullname }}</p>
            </td>
            </tr>
            <tr>
            <th scope="row">16:00 H</th>
            <td class="col-10 bg-reprise text-white" :class="(getTime === 16)?'bg-primary':'bg-secondary'">
                <h1 class="text-white text-sm" v-if="(getTime === 16)">16:00 - 17:00</h1>
                <p class="text-lg font-weight-bold" v-if="(getTime === 16)">{{ fullname }}</p>
            </td>
            </tr>
            <tr>
            <th scope="row">17:00 H </th>
            <td class="col-10 bg-reprise text-white" :class="(getTime === 17)?'bg-primary':'bg-secondary'">
                <h1 class="text-white text-sm" v-if="(getTime === 17)">17:00 - 18:00</h1>
                <p class="text-lg font-weight-bold" v-if="(getTime === 17)">{{ fullname }}</p>
            </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
export default {
    name:'entcal-component',
    props: ['entretien','fullname'],
    data() {
        return{

        }
    },
    computed: {
        getDate(){
            if(this.entretien.date!=null) return this.entretien.date.substring(0,10);
        },
        getTime(){
            if(this.entretien.date!=null) return parseInt(this.entretien.date.substring(11,13));
        },
    }
}
</script>

<style scoped>
.rounded{
    border-radius: 100%;
}
</style>