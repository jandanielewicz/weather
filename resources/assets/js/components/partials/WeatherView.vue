<template>
    <div>
        <v-layout style="margin-bottom: 20px">
        </v-layout>
        <v-layout>
            <v-flex xs12>
                <table>
                    <tr>
                        <td>Name</td>
                        <td v-if="items.forecast">{{ items.forecast.name }}</td>
                    </tr>
                    <tr>
                        <td>Long</td>
                        <td v-if="items.forecast && items.forecast.coord">{{ items.forecast.coord.lon }}</td>
                    </tr>
                    <tr>
                        <td>Lat</td>
                        <td v-if="items.forecast && items.forecast.coord">{{ items.forecast.coord.lat }}</td>
                    </tr>
                    <tr>
                        <td>Weather</td>
                        <td v-if="items.forecast && items.forecast.weather">{{ items.forecast.weather.find(Boolean).main }}</td>
                    </tr>
                    <tr>
                        <td>Temp</td>
                        <td v-if="items.forecast && items.forecast.main">{{ items.forecast.main.temp }}</td>
                    </tr>
                    <tr>
                        <td>pressure</td>
                        <td v-if="items.forecast && items.forecast.main">{{ items.forecast.main.pressure }}</td>
                    </tr>
                    <tr>
                        <td>humidity</td>
                        <td v-if="items.forecast && items.forecast.main">{{ items.forecast.main.humidity }}</td>
                    </tr>
                    <tr>
                        <td>visibility</td>
                        <td v-if="items.forecast">{{ items.forecast.visibility }}</td>
                    </tr>
                    <tr>
                        <td>clouds</td>
                        <td v-if="items.forecast && items.forecast.clouds">{{ items.forecast.clouds.all }}</td>
                    </tr>

                </table>
            </v-flex>

        </v-layout>
    </div>
</template>

<script>

    import {wthrAPI} from "../../wthrAPI";

    export default {
        mounted() {
            console.log('Component TripsView mounted.');
            this.fetch();
        },
        created() {
            console.log('Component TripsView created.')
        },
        data() {
            return {
                name: null,
                lat: '',
                long: '',
                items: [],
                headers: [
                    { text: 'Main', value: 'date' },
                    { text: 'Description', value: 'car' },
                    { text: 'Temp', value: 'car' },
                ]
            }
        },
        watch: {},
        computed: {},
        methods: {
            fetch() {
                axios.get(wthrAPI.getWeatherTodayEndpoint())
                    .then(response => {
                        this.items = response.data;
                    }).catch(e => {
                    console.log(e);
                });
            },
            addTripSelected() {
                this.$router.push('new-trip')
            }
        },
        components: {}
    }
</script>

<style scoped lang="scss">

</style>
