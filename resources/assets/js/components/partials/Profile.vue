<template>
        <v-form ref="form" v-model="valid" lazy-validation>
<!--           -->


            <v-text-field
                v-model="name"
                label="Name"
                required
                :rules="[v => (!!v) || 'Item is required']"
            >{{name}}</v-text-field>


            <v-text-field
                v-model="lat"
                label="lat"
                required
                :rules="[v => (!!v) || 'Item is required']"
            >{{lat}}</v-text-field>

            <v-text-field
                v-model="long"
                label="long"
                required
                :rules="[v => (!!v) || 'Item is required']"
            >{{long}}</v-text-field>

            <v-checkbox
                    v-model="storm"
                label="Storm notification?"
            ></v-checkbox>


            <v-checkbox
                    v-model="drizzle"
                    label="Drizzle notification?"
            ></v-checkbox>

            <v-checkbox
                    v-model="rain"
                    label="Rain notification?"
            ></v-checkbox>

            <v-checkbox
                    v-model="snow"
                    label="snow notification?"
            ></v-checkbox>

            <v-checkbox
                    v-model="atmosphere"
                    label="atmosphere notification? (dust, fog, tornado, etc)"
            ></v-checkbox>

            <v-btn
                    :disabled="!valid"
                    @click="submit"
            >
                submit
            </v-btn>


            <v-btn
                    :disabled="!valid"
                    @click="deleteProfile"
            >
                Delete profile
            </v-btn>
            <v-btn @click="clear">clear</v-btn>

        </v-form>
</template>

<script>
    import {wthrAPI} from "../../wthrAPI";

    export default {
        props: [],
        mounted() {
            console.log('Component NewTripView mounted.');
            this.fetchUser();
        },
        created() {
            console.log('Component NewTripView created.')
        },
        data() {
            return {
                valid: true,
                lat: null,
                long: null,
                name: null,
                storm: null,
                rain: null,
                drizzle: null,
                snow: null,
                atmosphere: null,
            }
        },
        watch: {},
        computed: {},
        methods: {
            isChecked(obj) {
                console.log(obj);
                return (typeof obj === "boolean" )
                    ? obj
                    : typeof obj === "string" && obj === '1';
            },
            dateChanged(date) {
                this.date = date;
            },
            fetchUser() {
                axios.get('/api/user/')
                    .then(response => {
                        this.name = response.data.name;
                        this.lat = response.data.settings.lat;
                        this.long = response.data.settings.long;
                        this.storm = (response.data.settings.storm);
                        this.drizzle = (response.data.settings.drizzle);
                        this.rain = (response.data.settings.rain);
                        this.snow = (response.data.settings.snow);
                        this.atmosphere = (response.data.settings.atmosphere);
                    }).catch(e => {
                    console.log(e);
                })
            },

            submit() {
                if (this.$refs.form.validate()) {
                    axios.post(wthrAPI.editProfileEndpoint(), {
                        name: this.name,
                        lat: this.lat,
                        long: this.long,
                        storm: this.storm,
                        drizzle: this.drizzle,
                        rain: this.rain,
                        snow: this.snow,
                        atmosphere: this.atmosphere,
                    }).then(response => {
                        this.$router.push('/profile')
                    }).catch(e => {
                        console.log(e);
                    });
                }
            },
            deleteProfile() {
                if (confirm()) {
                    axios.post(wthrAPI.deleteProfileEndpoint(), {
                    }).then(response => {
                        this.$router.push('/profile')
                    }).catch(e => {
                        console.log(e);
                    });
                }
            },
            clear () {
                this.$refs.form.reset()
            }
        },
        components: {
            'date-picker' : require('../common/DatePicker.vue')
        }
    }
</script>

<style scoped lang="scss">

</style>
